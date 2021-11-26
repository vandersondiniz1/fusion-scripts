<?php

require_once(__DIR__ . '\..\utils\Utils.php');

$msg = true;
$path = ("C:\Users\Fusion\Desktop\Fusion\Projetos\bitbucket/fusionweb");

// wellCome();

logMsg('->Executing application ', 'info', 'api-server.php', '\n');

logMsg("->Updating repository ", "info", "api-server.php", "\n");
exec("cd $path && git pull origin master && git fetch --all");

logMsg('->Updating repository ', 'info', 'api-server.php', '\n');
exec("cd $path && git describe --abbrev=0");


