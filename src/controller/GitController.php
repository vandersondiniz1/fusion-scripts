<?php

require_once(__DIR__ . '/../utils/logger.php');
require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../utils/logger.php');

class GitController
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("REPOSITORY_LOCATION");
    }

    function gitExistsBranch($pBranch)
    {
        /*$return_var:0 - success, 1 - failure*/
        logMsg("->Checking if the branch '$pBranch' exists", 'info', 'GitController.php', '-');
        exec("cd $this->path && git branch --list | grep -w '$pBranch'", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitCheckoutBranch($pBranch)
    {
        logMsg("->git checkout '$pBranch'", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git checkout $pBranch", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitLastestRelease($pBranchOp)
    {
        $pOperation = $pBranchOp['op'];
        $pEngId = $pBranchOp['eng_id'];

        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output, $ret);

        if ($ret == 0) {
            $release = explode('remotes/origin/', $output[0]);
            $limit = 2; //removendo dois espacos
            $last_release = preg_replace('/\s+/', '', $release[1], $limit);
            logMsg("->Last Release encountered:$last_release", 'info', 'FlowController.php', '-');
        } else {
            logMsg("->No releases were found", 'info', 'FlowController.php', '-');
            $branch_name = "$pOperation/ENG-B-I$pEngId";
            $ret = $this->gitAlertMessage();
            if ($ret) $this->gitRollbackChanges($pBranchOp['branch'], $branch_name);
        }

        !empty($last_release) ? $ret = $last_release : false;
        return $ret;
    }

    function gitUpdateBranch($pBranch)
    {
        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'GitController.php', '-');
        exec("cd $this->path && git pull origin $pBranch && git fetch --all", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitCreateBranch($pBranchOp)
    {
        $pOperation = $pBranchOp['op'];
        $pEngId = $pBranchOp['eng_id'];
        logMsg("->git checkout -b $pOperation/ENG-B-I$pEngId", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git checkout -b $pOperation/ENG-B-I$pEngId", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitReturnBranch()
    {
        exec("cd $this->path && git rev-parse --abbrev-ref HEAD", $output, $ret);
        if ($ret == 0) return $output[0];
        else return false;
    }

    function gitAlertMessage()
    {
        logMsg("->Are you sure you want to do this?  Type 'y' to continue or 'n' to abort", 'info', 'FlowController.php', '-');
        $handle = fopen("php://stdin", "r");
        $line = fgets(strtolower($handle));
        if (trim($line) != 'y') {
            logMsg("->Continuing", 'info', 'FlowController.php', '-');
            return true;
        } else {
            logMsg("->Abortin process", 'info', 'FlowController.php', '-');
            return false;
        }
    }

    function gitRollbackChanges($pBranch, $pBranchName)
    {

        logMsg("->Undoing changes", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git checkout $pBranch", $output, $return_var);
        logMsg("->git branch -D", 'info', 'FlowController.php', '-');
        exec("git branch -D $pBranchName", $output, $return_var);
    }

    function gitPushChanges($pBranch, $pBranchName)
    {
    }
}
