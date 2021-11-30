<?php

require_once(__DIR__ . '\..\utils\Utils.php');

$msg = true;
$path = ("C:\\Users\\Fusion\\Desktop\\Fusion\\Projetos\\bitbucket\\fusionweb");
$get_release = "git branch -a --sort=-committerdate | grep release | sed -n '1 p'";

logMsg("->cd 'C:\\Users\\Fusion\\Desktop\\Fusion\\Projetos\\bitbucket\\fusionweb' ", 'info', 'hotfix.php');

#ir no seu repositório local e executar um git fetch, pra atualizar as branchs
#FIXME: precisamos definir qual sera a branch principal. Existe master, develop, prod2.5
#acho que precisamos passar o nome da branch por parametro
exec("cd $path && git checkout master");
logMsg('->git checkout master', 'info', 'hotfix.php');

exec("cd $path && git pull origin master && git fetch --all");
logMsg('->git pull origin master && git fetch --all', 'info', 'hotfix.php');

exec("cd $path && git branch -a --sort=-committerdate | grep release | sed -n '1 p'", $output);
$last_release = explode('remotes/origin/', $output[0]);
logMsg("->git branch -a --sort=-committerdate | grep release | sed -n '1 p'", 'info', 'hotfix.php');
logMsg("->Last Release:$last_release[0] ", 'info', 'hotfix.php');

exec("cd $path && git checkout $last_release[0]");
logMsg("->git checkout $last_release[0]", 'info', 'hotfix.php');

exec("cd $path && git checkout -b Feature/ENG-H-I");
