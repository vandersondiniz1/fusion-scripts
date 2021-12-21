<?php

require_once('logger.php');
require_once('utils.php');
require_once('console.php');

class Err
{
    function gitBranchNotExistsError($pBranch)
    {
        // Console::log('->The branch '$pBranch' does not exist ', 'white', true, 'blue');
        logMsg("->The branch '$pBranch' does not exist ", 'error', 'FlowController.php', '-');
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
