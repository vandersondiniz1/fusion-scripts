<?php

require_once(__DIR__ . '/../utils/logger.php');
require_once(__DIR__ . '/../utils/utils.php');
require_once(__DIR__ . '/../utils/error.php');
require_once(__DIR__ . '/../controller/GitController.php');

$msg = true;
class Flow
{
    public $path;

    function __construct()
    {
        $this->path = getEnvironment("REPOSITORY_LOCATION");
    }

    function gitBranchOp($pBranchOp)
    {
        $git = new GitController();
        $error = new Err();
        $pBranch = $pBranchOp['branch'];
        $pOperation = $pBranchOp['op'];
        $pEngId = $pBranchOp['eng_id'];

        $ret = $git->gitExistsBranch($pBranch);
        if ($ret) {
            $git->gitCheckoutBranch($pBranch);
            $git->gitUpdateBranch($pBranch);
        } else $error->gitBranchNotExistsError($pBranch);

        logMsg("->Getting the latest release", 'info', 'FlowController.php', '-');
        $ret = $git->gitLastestRelease($pBranchOp);
        if ($ret) {
            $last_release = $ret;
            $git->gitCheckoutBranch($last_release);
        } else $error->gitBranchNotExistsError($pBranch);

        $ret = $git->gitExistsBranch("$pOperation/ENG-B-I$pEngId");

        $ret ? $git->gitCheckoutBranch("$pOperation/ENG-B-I$pEngId") : $git->gitCreateBranch($pBranchOp);

        $ret = $git->gitReturnBranch();

        $ret ? $ret : false;

        return $ret;
    }
}
