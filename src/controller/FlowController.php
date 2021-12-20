<?php

use Monolog\Utils;

require_once(__DIR__ . '/../utils/logger.php');
require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../controller/GitController.php');

$msg = true;
class Flow
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("REPOSITORY_LOCATION");
    }

    function gitBranchOp($pOperation, $pBranch, $pEngId)
    {
        $git = new GitController();

        $ret = $git->gitExistsBranch($pBranch);
        if ($ret) {
            logMsg("->git checkout '$pBranch'", 'info', 'FlowController.php', '-');
            $git->gitCheckoutBranch($pBranch);
            $git->gitUpdateBranch($pBranch);
        } else {
            logMsg("->the branch '$pBranch' does not exist ", 'info', 'FlowController.php', '-');
            exit();
        }
        //FIXME: continuar daqui
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output, $return_var);

        if ($return_var == 0) {
            $release = explode('remotes/origin/', $output[4]);
            $limit = 2; //removendo dois espacos
            $last_release = preg_replace('/\s+/', '', $release[0], $limit);
            logMsg("->Last Release encountered:$last_release", 'info', 'FlowController.php', '-');
        } else {
            logMsg("->No releases were found", 'info', 'FlowController.php', '-');
            //desfazendo alterações
            $branch_name = "$pOperation/ENG-B-I$pEngId";
            $rollback = $git->gitRollbackChanges($pBranch, $branch_name);
            //fazer algum if aqui
            exit();
        }

        logMsg("->git checkout $last_release", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git checkout $last_release", $output, $return_var);

        logMsg("->Checking if the branch '$pOperation/ENG-B-I$pEngId' exists", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git branch --all | grep -e '$pOperation/ENG-B-I$pEngId'", $ret, $return_var);

        if ($ret) {
            logMsg("->git checkout $pOperation/ENG-B-I$pEngId", 'info', 'FlowController.php', '-');
            exec("cd $this->path && git checkout $pOperation/ENG-B-I$pEngId", $output);
        } else {
            logMsg("->git checkout -b $pOperation/ENG-B-I$pEngId", 'info', 'FlowController.php', '-');
            exec("cd $this->path && git checkout -b $pOperation/ENG-B-I$pEngId", $output);
        }

        exec("cd $this->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
