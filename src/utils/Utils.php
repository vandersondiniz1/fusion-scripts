<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

function getEnvironment($envKey = null)
{
    try {
        $envs = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env');
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

function wellCome()
{
    global $modules;
    global $git;
    global $aws;
    global $deploy;

    if ($modules) {

        echo "\n";
        echo '========================================================' . chr(10) . chr(13);
        echo "    ______           _             ____  __  ________" . chr(10) . chr(13);
        echo "   / ____/_  _______(_)___  ____  / __ \/  |/  / ___/" . chr(10) . chr(13);
        echo "  / /_  / / / / ___/ / __ \/ __ \/ / / / /|_/ /\__ \ " . chr(10) . chr(13);
        echo " / __/ / /_/ (__  ) / /_/ / / / / /_/ / /  / /___/ / " . chr(10) . chr(13);
        echo "/_/    \__,_/____/_/\____/_/ /_/_____/_/  /_//____/  " . chr(10) . chr(13);
        echo "                                                     " . chr(10) . chr(13);
        echo '========================================================' . chr(10) . chr(13);
        echo 'Available Modules'                                        . chr(10) . chr(13);
        echo 'git    :: fusionlab_git'                                  . chr(10) . chr(13);
        echo 'aws    :: fusionlab_aws'                                  . chr(10) . chr(13);
        echo 'deploy :: fusionlab_deploy'                               . chr(10) . chr(13);
        echo '========================================================' . chr(10) . chr(13);
        echo "\n";
    } else if ($git) {
        echo "\n";
        echo '========================================================' . chr(10) . chr(13);
        echo "    _______  ___   _______                              " . chr(10) . chr(13);
        echo "    |       ||   | |       |                            " . chr(10) . chr(13);
        echo "    |    ___||   | |_     _|                            " . chr(10) . chr(13);
        echo "    |   | __ |   |   |   |                              " . chr(10) . chr(13);
        echo "    |   ||  ||   |   |   |                              " . chr(10) . chr(13);
        echo "    |   |_| ||   |   |   |                              " . chr(10) . chr(13);
        echo "    |_______||___|   |___|                              " . chr(10) . chr(13);
        echo '========================================================' . chr(10) . chr(13);
        echo 'Execution' . chr(10) . chr(13);
        echo 'fusionlab_git_bugfix  [eng_id] [branch_name - optional]'  . chr(10) . chr(13);
        echo 'fusionlab_git_hotfix  [eng_id] [branch_name - optional]'  . chr(10) . chr(13);
        echo 'fusionlab_git_feature [eng_id] [branch_name - optional]'  . chr(10) . chr(13);
        echo '========================================================' . chr(10) . chr(13);
        echo "\n";
    }
}
