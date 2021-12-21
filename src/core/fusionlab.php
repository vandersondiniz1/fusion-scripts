<?php

require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../utils/logger.php');
require_once(__DIR__ . '/../utils/console.php');
require_once(__DIR__ . '/../controller/FlowController.php');

date_default_timezone_set('America/Sao_Paulo');

$msg = true;
$branch = null;
$flow = new Flow();

logMsg('->Executing application ', 'info', 'fusionlab.php', '-');

//FIXME: implementar um metodo de deploy e tirar o do docker

for ($i = 0; $i < $argc; $i++) {
    if ($argc <= 2) {
        $modules = true;
        wellCome();
        logMsg('->Showing available modules', 'info', 'fusionlab.php', '-');
        die();
    }
}

for ($i = 1; $i < $argc; $i++) {
    $eng_type = $argv[2];

    empty($argv[4]) ? $branch = 'master' : $branch = $argv[4];

    if (!empty($argv[3]) && is_numeric($argv[3])) {
        $eng_id = preg_replace("/[^0-9]/", "", $argv[3]);
    } else {
        wellCome();
        logMsg('->The eng number cannot be null and cannot contain letters', 'info', 'fusionlab.php', '-');
        return false;
    }

    $operations = array(
        'bugfix' => $bugfix = false,
        'hotfix' => $hotfix = false,
        'feature' => $feature = false
    );

    if (array_key_exists(strtolower($eng_type), $operations)) {
        $git = true;
        $operations["$eng_type"] = true;
    } else {
        logMsg('->Invalid parameter', 'info', 'fusionlab.php', '-');
        wellCome();
        return false;
    }
}

//FIXME:
//verificar diretorio atual e diretorio criado
//como serao diferentes, perguntar ao usuario se ele deseja ser redirecionado
//deseja entrar no diretorio da branch criada?
if ($operations["$eng_type"]) {
    $op =  key($operations);

    $branch_op = array(
        'op' => $op,
        'branch' => $branch,
        'eng_id' => $eng_id
    );

    $ret = $flow->gitBranchOp($branch_op);
    if ($ret) {
        logMsg("->Actual branch:$ret", 'info', 'fusionlab.php', '-');
    } else {
        logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
    }
}

logMsg('->Ending application', 'info', 'fusionlab.php', '-');
