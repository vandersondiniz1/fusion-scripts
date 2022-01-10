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

    function gitBranchOperation($pBranchOp)
    {
        $git = new GitController();
        $error = new Err();
        $pBranch = $pBranchOp['branch'];
        $pOperation = $pBranchOp['op'];
        $pEngId = $pBranchOp['eng_id'];

        $ret = $git->gitExistsRepository($this->path);
        if ($ret['response'] == 'failure') $error->gitRepositoryNotExistsError($ret['error']);

        $ret = $git->gitExistsBranch($pBranch);
        if ($ret) {
            $ret = $git->gitCheckoutBranch($pBranch);
            if ($ret['response'] == 'failure') $error->gitGenericError($ret['error']);
            $git->gitUpdateBranch($pBranch);
        } else
            $error->gitBranchNotExistsError($pBranch);

        logMsg("->Getting the latest release", 'info', 'FlowController.php', '-');
        $ret = $git->gitLastestRelease($pBranchOp);
        if ($ret) {
            $last_release = $ret;
            $ret = $git->gitCheckoutBranch($last_release);
            if ($ret['response'] == 'failure') $error->gitGenericError($ret['error']);
        } else $error->gitBranchNotExistsError($pBranch);

        $ret = $git->gitExistsBranch("$pOperation/ENG-B-I$pEngId");

        $ret ? $git->gitCheckoutBranch("$pOperation/ENG-B-I$pEngId") : $git->gitCreateBranch($pBranchOp);

        $ret = $git->gitReturnBranch();

        $ret ? $ret : false;

        return $ret;
    }

    function gitCommitOperation($pBranchOp)
    {
        $git = new GitController();
        $error = new Err();
        $pBranch = $pBranchOp['branch'];

        $ret = $git->gitExistsRepository($this->path);
        if ($ret['response'] == 'failure') $error->gitRepositoryNotExistsError($ret['error']);

        $ret = $git->gitExistsBranch($pBranch);
        if ($ret) {
            $ret = $git->gitCheckoutBranch($pBranch);
            if ($ret['response'] == 'failure') $error->gitGenericError($ret['error']);
            $ret = $git->gitCommitChanges($pBranch);
            if ($ret['response'] == 'failure') $error->gitGenericError($ret['error']);
        } else
            $error->gitBranchNotExistsError($pBranch);

        return $ret;
    }

    //FIXME: continuar daqui
    function gitPushOperation($pBranchOp)
    {
        $git = new GitController();
        $error = new Err();
        $pBranch = $pBranchOp['branch'];

        $ret = $git->gitExistsRepository($this->path);
        if ($ret['response'] == 'failure') $error->gitRepositoryNotExistsError($ret['error']);

        $ret = $git->gitExistsBranch($pBranch);
        if ($ret) {
            $ret = $git->gitCheckoutBranch($pBranch);
            if ($ret['response'] == 'failure') $error->gitGenericError($ret['error']);
            $ret = $git->gitCommitChanges($pBranch);
            if ($ret['response'] == 'failure') $error->gitGenericError($ret['error']);
        } else
            $error->gitBranchNotExistsError($pBranch);

        return $ret;
    }
}
