<?php

require_once(__DIR__ . '\..\utils\Utils.php');
require_once(__DIR__ . '\..\utils\console.php');

$msg = true;
class Bugfix
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("PATH");
    }

    function engBugfix($pBranch, $pEngId)
    {
        $bug = new Bugfix();

        exec("cd  $bug->path && git checkout $pBranch");

        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'bugfix.php', '-');
        exec("cd $bug->path && git pull origin $pBranch && git fetch --all");

        exec("cd $bug->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        if ($last_release[0] == "  ") $last_release[0] = $last_release[1];
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'bugfix.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'bugfix.php', '-');

        exec("cd $bug->path && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'bugfix.php', '-');

        exec("cd $bug->path && git branch --all | grep -e 'feature/ENG-B-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'feature/ENG-B-I$pEngId'", 'info', 'bugfix.php', '-');

        if ($ret) {
            exec("cd $bug->path && git checkout feature/ENG-B-I$pEngId", $output);
            // exec("cd $bug->path && git pull origin feature/ENG-B-I$pEngId", $output);
            logMsg("->git checkout feature/ENG-B-I$pEngId", 'info', 'bugfix.php', '-');
        } else {
            exec("cd $bug->path && git checkout -b feature/ENG-B-I$pEngId", $output);
            logMsg("->git checkout -b feature/ENG-B-I$pEngId", 'info', 'bugfix.php', '-');
        }

        exec("cd $bug->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
