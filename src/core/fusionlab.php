<?php

require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../utils/console.php');
require_once(__DIR__ . '/../controller/FlowController.php');

date_default_timezone_set('America/Sao_Paulo');

$msg = true;
$branch = null;
$flow = new Flow();

logMsg('->Executing application ', 'info', 'fusionlab.php', '-');

/* FIXME: quando a aplicação é executada, acessamos o diretorio do 
repositorio externamente e nao neste mesmo terminal. Verificar a 
melhor forma de fazer isso. */

for ($i = 0; $i < $argc; $i++) {
    if ($argc == 1) {
        $modules = true;
        wellCome();
        logMsg('->Showing available modules', 'info', 'fusionlab.php', '-');
        die();
    }
}

for ($i = 1; $i < $argc; $i++) {
    if (empty($argv[4])) $branch = 'master';
    if (!empty($argv[3])) {
        $eng_id = preg_replace("/[^0-9]/", "", $argv[3]);
    } else {
        wellCome();
        logMsg('->The eng number cannot be null', 'info', 'fusionlab.php', '-');
        return false;
    }

    $operations = array(
        'bugfix' => $bugfix = false,
        'hotfix' => $hotfix = false,
        'feature' => $feature = false
    );

    if (array_key_exists(strtolower($argv[2]), $operations)) {
        $git = true;
        $operations["$argv[2]"] = true;
    } else {
        logMsg('->Invalid parameter', 'info', 'fusionlab.php', '-');
        wellCome();
        return false;
    }
}

//FIXME: atribuir nomes as variaveis com arg para melhor identificar
// for ($i = 1; $i < $argc; $i++) {
//     if (strtolower($argv[2]) == 'bugfix') {
//         $bugfix = true;
//         $git = true;
//         if (!empty($argv[3])) {
//             $eng_id = preg_replace("/[^0-9]/", "", $argv[3]);
//             if (empty($argv[4])) {
//                 $branch = 'master';
//             }
//         } else {
//             logMsg('->The eng number cannot be null', 'info', 'fusionlab.php', '-');
//             wellCome();
//             return false;
//         }
//     } else
//     if (strtolower($argv[2]) == 'hotfix') {
//         $hotfix = true;
//         if (!empty($argv[3])) {
//             $eng_id = preg_replace("/[^0-9]/", "", $argv[3]);
//             if (empty($argv[4])) {
//                 $branch = 'master';
//             }
//         } else {
//             logMsg('->The eng number cannot be null', 'info', 'fusionlab.php', '-');
//             wellCome();
//             return false;
//         }
//     } else 
//     if (strtolower($argv[2]) == 'feature') {
//         $feature = true;
//         if (!empty($argv[3])) {
//             $eng_id = preg_replace("/[^0-9]/", "", $argv[3]);
//             if (empty($argv[4])) {
//                 $branch = 'master';
//             }
//         } else {
//             logMsg('->The eng number cannot be null', 'info', 'fusionlab.php', '-');
//             wellCome();
//             return false;
//         }
//     } else {
//         logMsg('->Invalid parameter', 'info', 'fusionlab.php', '-');
//         wellCome();
//         return false;
//     }
// }

//FIXME:
//verificar diretorio atual e diretorio criado
//como serao diferentes, perguntar ao usuario se ele deseja ser redirecionado
//deseja entrar no diretorio da branch criada?
if ($operations["$argv[2]"]) {
    $arr_key =  key($operations);
    $ret = $flow->gitBranchOp($arr_key, $branch, $eng_id);
    if ($ret) {
        logMsg("->Actual branch:$ret", 'info', 'fusionlab.php', '-');
    } else {
        logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
    }
}

// if ($hotfix) {
//     $ret = $eng_hotfix->engHotfix($branch, $eng_id);
//     if ($ret) {
//         logMsg("->Actual branch:$ret", 'info', 'fusionlab.php', '-');
//     } else {
//         logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
//     }
// }

// if ($feature) {
//     $ret = $eng_feature->engFeature($branch, $eng_id);
//     if ($ret) {
//         logMsg("->Actual branch:$ret", 'info', 'fusionlab.php', '-');
//     } else {
//         logMsg('->Some info occurred on the execution process. Check the logs', 'info', 'fusionlab.php', '-');
//     }
// }

logMsg('->Ending application', 'info', 'fusionlab.php', '-');
