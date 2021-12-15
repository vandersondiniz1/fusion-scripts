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

        exec("cd  $hotfix->path && git checkout $pBranch");

        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'hotfix.php', '-');
        exec("cd $hotfix->path && git pull origin $pBranch && git fetch --all");

        exec("cd $hotfix->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        if ($last_release[0] == "  ") $last_release[0] = $last_release[1];
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'hotfix.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'hotfix.php', '-');

        exec("cd $hotfix->path && git branch --all | grep -e 'hotfix/ENG-B-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'hotfix/ENG-B-I$pEngId'", 'info', 'hotfix.php', '-');

        if ($ret) {
            exec("cd $hotfix->path && git checkout hotfix/ENG-B-I$pEngId", $output);
            // exec("cd $hotfix->path && git pull origin hotfix/ENG-B-I$pEngId", $output);
            logMsg("->git checkout hotfix/ENG-B-I$pEngId", 'info', 'hotfix.php', '-');
        } else {
            exec("cd $hotfix->path && git checkout -b hotfix/ENG-B-I$pEngId", $output);
            logMsg("->git checkout -b hotfix/ENG-B-I$pEngId", 'info', 'hotfix.php', '-');
        }

        exec("cd $hotfix->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
