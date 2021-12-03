<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

define('GERALOG', 5);

function getEnvironment($envKey = null)
{
    try {
        $envs = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env'); //modificar a barra de acordo com o SO
        if (isset($envs[$envKey])) {
            $_ENV[$envKey] = $envs[$envKey];
            return $_ENV[$envKey];
        } else {
            logMsg('->Error in handling the directories ', 'error', 'Utils.php', 'getEnvironment');
            return null;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

function logMsg($msg, $level = 'info', $fileSource = '', $method = '', $file = '')
{
    if (GERALOG) {

        $date = date('Y-m-d H:i:s');

        if ($file == '') {

            if (!file_exists("./resources/logs/")) {
                mkdir("./resources/logs/", 0777, true);
            };

            $file = "./resources/logs/" . date('Ymd') . "-" . gethostname() . "-" . "git-flow-3.0";
        }

        $output = "[%datetime%] [%channel%] [%level_name%] %message%\n";
        $formatter = new LineFormatter($output, $date, false, true);
        $streamErro = new StreamHandler($file . "-erro.log", Logger::ERROR);
        $streamErro->setFormatter($formatter);
        $stream = new StreamHandler($file . ".log", Logger::DEBUG);
        $stream->setFormatter($formatter);

        $log = new Logger('sys');
        $log->pushHandler($stream);
        $log->pushHandler($streamErro);
        $dblog = new Logger('database');
        $dblog->pushHandler($stream);
        $dblog->pushHandler($streamErro);

        $logmsg = sprintf("[%s] [%s]: %s", $fileSource, $method, $msg);

        switch ($level) {
            case 'info':
                if (GERALOG >= 3) $log->info($logmsg);
                break;
            case 'warning':
                if (GERALOG >= 2) $log->warning($logmsg);
                break;
            case 'error':
                if (GERALOG >= 1) $log->error($logmsg);
                break;
            case 'database':
                if (GERALOG >= 2) $dblog->error($logmsg);
                break;

            default:
                $log->info($logmsg);
                break;
        }
    }
};

function wellCome()
{
    global $msg;
    if ($msg) {

        echo "\n";
        echo '========================================================' . chr(10) . chr(13);
        echo "    ______           _             ____  __  ________" . chr(10) . chr(13);
        echo "   / ____/_  _______(_)___  ____  / __ \/  |/  / ___/" . chr(10) . chr(13);
        echo "  / /_  / / / / ___/ / __ \/ __ \/ / / / /|_/ /\__ \ " . chr(10) . chr(13);
        echo " / __/ / /_/ (__  ) / /_/ / / / / /_/ / /  / /___/ / " . chr(10) . chr(13);
        echo "/_/    \__,_/____/_/\____/_/ /_/_____/_/  /_//____/  " . chr(10) . chr(13);
        echo "                                                     " . chr(10) . chr(13);
        echo '========================================================' . chr(10) . chr(13);
        echo 'Execução' . chr(10) . chr(13);
        echo 'php app.php [parâmetro] [número da eng] [nome da branch]' . chr(10) . chr(13);
        echo 'php app.php bug 666 master' . chr(10) . chr(13);
        echo 'php app.php hotfix 666 develop' . chr(10) . chr(13);
        echo 'php app.php melhoria 666 staging' . chr(10) . chr(13);
        echo '========================================================' . chr(10) . chr(13);
        echo "\n";
    }
}
