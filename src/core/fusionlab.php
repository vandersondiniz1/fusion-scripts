<?php

require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../utils/logger.php');
require_once(__DIR__ . '/../utils/console.php');
require_once(__DIR__ . '/../controller/FlowController.php');
require_once(__DIR__ . '/../../config/constants.php');

date_default_timezone_set('America/Sao_Paulo');

$msg = true;
$branch = null;
$operations = false;
$flow_controller = new Flow();
$git_controller = new GitController();

logMsg('->Executing application ', 'info', 'fusionlab.php', '-');

//FIXME: verificar se os aliases existem

for ($i = 0; $i < $argc; $i++) {
    if ($argc <= 2) {
        $modules = true;
        wellCome();
        logMsg('->Showing available modules', 'info', 'fusionlab.php', '-');
        die();
    }
}

for ($i = 1; $i < $argc; $i++) {
    $action = $argv[2];
    $git = true;

    if (array_key_exists(strtolower($action), BRANCH_OPERATIONS)) {
        $operations["$action"] = true;
        empty($argv[4]) ? $branch = 'master' : $branch = $argv[4];
        if (!empty($argv[3]) && is_numeric($argv[3])) {
            $eng_id = preg_replace("/[^0-9]/", "", $argv[3]);
        } else {
            wellCome();
            logMsg('->The eng number cannot be null and cannot contain letters', 'info', 'fusionlab.php', '-');
            return false;
        }
    } else  
    if (array_key_exists(strtolower($action), COMMIT_OPERATION)) {
        if (!empty($argv[3])) {
            $commit = true;
            $branch = $argv[3];
        } else {
            wellCome();
            logMsg('->The eng number cannot be null', 'info', 'fusionlab.php', '-');
            return false;
        }
    } else
    if (array_key_exists(strtolower($action), PUSH_OPERATION)) {
        echo "Push";
        $push = true;
    } else {
        echo "Option not implemented";
        return false;
    }
}

if ($operations) {
    if ($operations["$action"]) {
        $op =  key($operations);

        $branch_op = array(
            'op' => $op,
            'branch' => $branch,
            'eng_id' => $eng_id
        );

        $ret = $flow_controller->gitBranchOperation($branch_op);
        if ($ret) {
            logMsg("->Actual branch:$ret", 'info', 'fusionlab.php', '-');
        } else {
            logMsg('->Some error occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
        }
    }
}

if ($commit) {
    $branch_op = array(
        'branch' => $branch
    );

    $ret = $flow_controller->gitCommitOperation($branch_op);
    if ($ret) {
        logMsg("->Successful commitment", 'info', 'fusionlab.php', '-');
        logMsg("->Pushing", 'info', 'fusionlab.php', '-');
        $ret = $flow_controller->gitPushOperation($branch_op);
        if ($ret)
            logMsg("->successful push", 'info', 'fusionlab.php', '-');
        else
            logMsg('->Some error occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
    } else {
        logMsg('->Some error occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
    }
}

logMsg('->Ending application', 'info', 'fusionlab.php', '-');
