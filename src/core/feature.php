<?php

// require_once(__DIR__ . '\..\utils\Utils.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'Utils.php');

class Feature
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("PATH");
    }

    function engFeature($pBranch, $pEngId)
    {
        $feature = new Feature();

        exec("cd  $feature->path && git checkout $pBranch");

        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'feature.php', '-');
        exec("cd $feature->path && git pull origin $pBranch && git fetch --all");

        exec("cd $feature->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        if ($last_release[0] == "  ") $last_release[0] = $last_release[1];
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'feature.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'feature.php', '-');

        exec("cd $feature->path && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'feature.php', '-');

        exec("cd $feature->path && git branch --all | grep -e 'feature/ENG-B-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'feature/ENG-B-I$pEngId'", 'info', 'feature.php', '-');

        if ($ret) {
            exec("cd $feature->path && git checkout feature/ENG-B-I$pEngId", $output);
            // exec("cd $feature->path && git pull origin feature/ENG-B-I$pEngId", $output);
            logMsg("->git checkout feature/ENG-B-I$pEngId", 'info', 'feature.php', '-');
        } else {
            exec("cd $feature->path && git checkout -b feature/ENG-B-I$pEngId", $output);
            logMsg("->git checkout -b feature/ENG-B-I$pEngId", 'info', 'feature.php', '-');
        }

        exec("cd $feature->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
