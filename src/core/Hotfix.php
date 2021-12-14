<?php

// require_once(__DIR__ . '\..\utils\Utils.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'Utils.php');

class Hotfix
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("PATH");
    }

    function engHotfix($pBranch, $pEngId)
    {
        $hotfix = new Hotfix();

        exec("cd $hotfix->path && git checkout $pBranch");
        logMsg("->git checkout $pBranch", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git pull origin $pBranch && git fetch --all");
        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'hotfix.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git branch --all | grep -e 'feature/ENG-H-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'feature/ENG-H-I$pEngId'", 'info', 'hotfix.php', '-');

        if ($ret) {
            exec("cd $hotfix->path && git checkout feature/ENG-H-I$pEngId", $output);
            exec("cd $hotfix->path && git pull origin feature/ENG-H-I$pEngId", $output);
        } else
            exec("cd $hotfix->path && git checkout -b feature/ENG-H-I$pEngId", $output);
        logMsg("->cd $hotfix->path && git checkout -b feature/ENG-H-I$pEngId", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
