<?php

require_once(__DIR__ . '\..\utils\Utils.php');

class Bug
{
    function engBug($pBranch, $pEngId, $pPath)
    {
        exec("cd $pPath && git checkout $pBranch");
        logMsg("->git checkout $pBranch", 'info', 'bug.php', '-');

        exec("cd $pPath && git pull origin $pBranch && git fetch --all");
        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'bug.php', '-');

        exec("cd $pPath && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'bug.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'bug.php', '-');

        exec("cd $pPath && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'bug.php', '-');

        exec("cd $pPath && git branch --all | grep -e 'feature/ENG-B-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'feature/ENG-B-I$pEngId'", 'info', 'bug.php', '-');

        if ($ret) {
            exec("cd $pPath && git checkout feature/ENG-B-I$pEngId", $output);
            exec("cd $pPath && git pull origin feature/ENG-B-I$pEngId", $output);
        } else
            exec("cd $pPath && git checkout -b feature/ENG-B-I$pEngId", $output);
        logMsg("->cd $pPath && git checkout -b feature/ENG-B-I$pEngId", 'info', 'bug.php', '-');

        exec("cd $pPath && git rev-parse --abbrev-ref HEAD", $branch);
        
        return $branch[0];
    }
}
