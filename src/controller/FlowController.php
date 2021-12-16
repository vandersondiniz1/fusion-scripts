<?php

require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../utils/console.php');

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
        exec("cd  $this->path && git checkout $pBranch");

        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'FlowController.php', '-');
        exec("cd $this->path && git pull origin $pBranch && git fetch --all");

        exec("cd $this->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        if ($last_release[0] == "  ") $last_release[0] = $last_release[1];
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'FlowController.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'FlowController.php', '-');

        exec("cd $this->path && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'FlowController.php', '-');

        exec("cd $this->path && git branch --all | grep -e 'feature/ENG-B-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'feature/ENG-B-I$pEngId'", 'info', 'FlowController.php', '-');

        if ($ret) {
            exec("cd $this->path && git checkout feature/ENG-B-I$pEngId", $output);
            // exec("cd $this->path && git pull origin feature/ENG-B-I$pEngId", $output);
            logMsg("->git checkout feature/ENG-B-I$pEngId", 'info', 'FlowController.php', '-');
        } else {
            exec("cd $this->path && git checkout -b feature/ENG-B-I$pEngId", $output);
            logMsg("->git checkout -b feature/ENG-B-I$pEngId", 'info', 'FlowController.php', '-');
        }

        exec("cd $this->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
