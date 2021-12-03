<?php

require_once(__DIR__ . '\..\utils\Utils.php');
require_once(__DIR__ . '\bug.php');
require_once(__DIR__ . '\hotfix.php');
require_once(__DIR__ . '\melhoria.php');

date_default_timezone_set('America/Sao_Paulo');

$msg = true;
$bug = false;
$hotfix = false;
$melhoria = false;
$branch = null;
$eng_bug = new Bug();
$eng_hotfix = new Hotfix();
$eng_melhoria = new Melhoria();

logMsg('->Executing application ', 'info', 'app.php', '-');

for ($i = 1; $i < $argc; $i++) {
    if (strtolower($argv[$i]) == 'bug') {
        $bug = true;
        if (!empty($argv[2])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[2]);
            if (!empty($argv[3])) {
                $branch = $argv[3];
            } else {
                echo ('The branch name cannot be null');
                logMsg('->The branch name cannot be null', 'error', 'app.php', '-');
                wellCome();
                return false;
            }
        } else {
            echo ('The eng number cannot be null');
            logMsg('->The eng number cannot be null', 'error', 'app.php', '-');
            wellCome();
            return false;
        }
    }
}

for ($i = 1; $i < $argc; $i++) {
    if (strtolower($argv[$i]) == 'hotfix') {
        $hotfix = true;
        if (!empty($argv[2])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[2]);
            if (!empty($argv[3])) {
                $branch = $argv[3];
            } else {
                echo ('The branch name cannot be null');
                wellCome();
                return false;
            }
        } else {
            echo ('The eng number cannot be null');
            wellCome();
            return false;
        }
    }
}

for ($i = 1; $i < $argc; $i++) {
    if (strtolower($argv[$i]) == 'melhoria') {
        $melhoria = true;
        if (!empty($argv[2])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[2]);
            if (!empty($argv[3])) {
                $branch = $argv[3];
            } else {
                echo ('The branch name cannot be null');
                wellCome();
                return false;
            }
        } else {
            echo ('The eng number cannot be null');
            wellCome();
            return false;
        }
    }
}

if ($bug) {
    $ret = $eng_bug->engBug($branch, $eng_id);
    if ($ret) {
        echo ('->Actual branch: ' . $ret . "\n");
        logMsg("->Actual branch:$ret", 'info', 'app.php', '-');
    } else
        logMsg('->Some error occurred on the execution process. Check the logs', 'error', 'app.php', '-');
}

if ($hotfix) {
    $ret = $eng_hotfix->engHotfix($branch, $eng_id);
    if ($ret) {
        echo ('->Actual branch: ' . $ret . "\n");
        logMsg("->Actual branch:$ret", 'info', 'app.php', '-');
    } else
        logMsg('->Some error occurred on the execution process. Check the logs', 'error', 'app.php', '-');
}

if ($melhoria) {
    $ret = $eng_melhoria->engMelhoria($branch, $eng_id);
    if ($ret) {
        echo ('->Actual branch: ' . $ret . "\n");
        logMsg("->Actual branch:$ret", 'info', 'app.php', '-');
    } else
        logMsg('->Some error occurred on the execution process. Check the logs', 'error', 'app.php', '-');
}

echo ('->Ending application<-' . "\n");
logMsg('->Ending application ', 'info', 'app.php', '-');
