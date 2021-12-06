<?php

require_once(__DIR__ . '\..\utils\utils.php');
require_once(__DIR__ . '\..\utils\console.php');
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

Console::log('Executing application', 'green');
logMsg('->Executing application ', 'info', 'app.php', '-');

for ($i = 0; $i < $argc; $i++) {
    if ($argc == 1) {
        echo Console::yellow('Its necessary to pass the required arguments', 'reverse') . "\n";
        logMsg('->The branch name cannot be null', 'info', 'app.php', '-');
        wellCome();
        return false;
    }
}

for ($i = 1; $i < $argc; $i++) {
    if (strtolower($argv[1]) == 'bug') {
        $bug = true;
        if (!empty($argv[2])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[2]);
            if (!empty($argv[3])) {
                $branch = $argv[3];
            } else {
                echo Console::yellow('The branch name cannot be null', 'reverse') . "\n";
                logMsg('->The branch name cannot be null', 'info', 'app.php', '-');
                wellCome();
                return false;
            }
        } else {
            echo Console::yellow('The eng number cannot be null', 'reverse') . "\n";
            logMsg('->The eng number cannot be null', 'info', 'app.php', '-');
            wellCome();
            return false;
        }
    } else
    if (strtolower($argv[1]) == 'hotfix') {
        $hotfix = true;
        if (!empty($argv[2])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[2]);
            if (!empty($argv[3])) {
                $branch = $argv[3];
            } else {
                echo Console::yellow('The branch name cannot be null', 'reverse') . "\n";
                logMsg('->The branch name cannot be null', 'info', 'app.php', '-');
                wellCome();
                return false;
            }
        } else {
            echo Console::yellow('The eng number cannot be null', 'reverse') . "\n";
            logMsg('->The eng number cannot be null', 'info', 'app.php', '-');
            wellCome();
            return false;
        }
    } else 
    if (strtolower($argv[1]) == 'melhoria') {
        $melhoria = true;
        if (!empty($argv[2])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[2]);
            if (!empty($argv[3])) {
                $branch = $argv[3];
            } else {
                echo Console::yellow('The branch name cannot be null', 'reverse') . "\n";
                logMsg('->The branch name cannot be null', 'info', 'app.php', '-');
                wellCome();
                return false;
            }
        } else {
            echo Console::yellow('The eng number cannot be null', 'reverse') . "\n";
            logMsg('->The eng number cannot be null', 'info', 'app.php', '-');
            wellCome();
            return false;
        }
    }else{
        echo Console::yellow('Invalid parameter', 'reverse') . "\n";
        logMsg('->Invalid parameter', 'info', 'app.php', '-');
        wellCome();
        return false;
    }
}

if ($bug) {
    $ret = $eng_bug->engBug($branch, $eng_id);
    if ($ret) {
        echo ('->Actual branch: ' . $ret . "\n");
        logMsg("->Actual branch:$ret", 'info', 'app.php', '-');
    } else {
        echo Console::yellow('Some info occurred on the execution process. Check the logs', 'reverse') . "\n";
        logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'app.php', '-');
    }
}

if ($hotfix) {
    $ret = $eng_hotfix->engHotfix($branch, $eng_id);
    if ($ret) {
        echo ('->Actual branch: ' . $ret . "\n");
        logMsg("->Actual branch:$ret", 'info', 'app.php', '-');
    } else {
        echo Console::yellow('Some info occurred on the execution process. Check the logs', 'reverse') . "\n";
        logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'app.php', '-');
    }
}

if ($melhoria) {
    $ret = $eng_melhoria->engMelhoria($branch, $eng_id);
    if ($ret) {
        echo ('->Actual branch: ' . $ret . "\n");
        logMsg("->Actual branch:$ret", 'info', 'app.php', '-');
    } else {
        echo Console::yellow('Some info occurred on the execution process. Check the logs', 'reverse') . "\n";
        logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'app.php', '-');
    }
}

Console::log('Ending application', 'green');
logMsg('->Ending application ', 'info', 'app.php', '-');
