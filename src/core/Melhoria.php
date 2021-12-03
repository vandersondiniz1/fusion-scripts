<?php

require_once(__DIR__ . '\..\utils\Utils.php');

class Melhoria
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("PATH");
    }

    function engMelhoria($pBranch, $pEngId)
    {
        $melhoria = new Melhoria();

        exec("cd $$melhoria->path && git checkout $pBranch");
        logMsg("->git checkout $pBranch", 'info', 'melhoria.php', '-');

        exec("cd $$melhoria->path && git pull origin $pBranch && git fetch --all");
        logMsg("->git pull origin $pBranch && git fetch --all", 'info', 'melhoria.php', '-');

        exec("cd $$melhoria->path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
        $last_release = explode('remotes/origin/', $output[0]);
        logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'melhoria.php', '-');
        logMsg("->Last Release encountered:$last_release[0] ", 'info', 'melhoria.php', '-');

        exec("cd $$melhoria->path && git checkout $last_release[0]");
        logMsg("->git checkout $last_release[0]", 'info', 'melhoria.php', '-');

        exec("cd $$melhoria->path && git branch --all | grep -e 'feature/ENG-M-I$pEngId'", $ret);
        logMsg("->git branch --all | grep -e 'feature/ENG-M-I$pEngId'", 'info', 'melhoria.php', '-');

        if ($ret) {
            exec("cd $$melhoria->path && git checkout feature/ENG-M-I$pEngId", $output);
            exec("cd $$melhoria->path && git pull origin feature/ENG-M-I$pEngId", $output);
        } else
            exec("cd $$melhoria->path && git checkout -b feature/ENG-M-I$pEngId", $output);
        logMsg("->cd $$melhoria->path && git checkout -b feature/ENG-M-I$pEngId", 'info', 'melhoria.php', '-');

        exec("cd $$melhoria->path && git rev-parse --abbrev-ref HEAD", $branch);

        return $branch[0];
    }
}
