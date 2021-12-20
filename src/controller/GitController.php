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
        exec("cd $this->path && git branch --list | grep $pBranch", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitCheckoutBranch($pBranch)
    {
        exec("cd $this->path && git checkout $pBranch", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitUpdateBranch($pBranch)
    {
        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'GitController.php', '-');
        exec("cd $this->path && git pull origin $pBranch && git fetch --all", $output, $ret);
        if ($ret == 0) return true;
        else return false;
    }

    function gitCreateBranch()
    {
    }

    function gitRollbackChanges($pBranch, $pBranchName)
    {
        /*  FIXME: como previnir que o usuario nao delete a:
         master, develop, staging, prod/v2.5, etc? */
        $path = getEnvironment("REPOSITORY_LOCATION");
        exec("cd $path && git checkout $pBranch", $output, $return_var);
        //exec("git branch -D $pBranchName", $output, $return_var);
    }

    function gitPushChanges($pBranch, $pBranchName)
    {
        /*  FIXME: como previnir que o usuario nao delete a:
     master, develop, staging, prod/v2.5, etc? */
        $path = getEnvironment("REPOSITORY_LOCATION");
        exec("cd $path && git checkout $pBranch", $output, $return_var);
        //exec("git branch -D $pBranchName", $output, $return_var);
    }
}
