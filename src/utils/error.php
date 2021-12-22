<?php

require_once('logger.php');
require_once('utils.php');
require_once('console.php');

class Err
{
    function gitRepositoryNotExistsError($pPath)
    {
        // Console::log('->The branch '$pBranch' does not exist ', 'white', true, 'blue');
        logMsg("->The repository '$pPath' does not exist or you don't have permission to access it", 'error', 'error.php', '-');
        logMsg('->Ending application', 'info', 'fusionlab.php', '-');
        exit();
    }

    function gitBranchNotExistsError($pBranch)
    {
        // Console::log('->The branch '$pBranch' does not exist ', 'white', true, 'blue');
        logMsg("->The branch '$pBranch' does not exist ", 'error', 'error.php', '-');
        logMsg('->Ending application', 'info', 'fusionlab.php', '-');
        exit();
    }

    function gitGenericError($pError)
    {
        logMsg("->Error: $pError", 'error', 'error.php', '-');
        logMsg('->Ending application', 'info', 'fusionlab.php', '-');
        exit();
    }

    function gitUpdateBranch()
    {
    }

    function gitCreateBranch()
    {
    }

    function gitRollbackChanges($pBranch, $pBranchName)
    {
    }

    function gitPushChanges($pBranch, $pBranchName)
    {
    }
}
