<?php

require_once(__DIR__ . '\..\utils\Utils.php');
require_once(__DIR__ . '\Bug.php');

// wellCome();

logMsg('->Executing application ', 'info', 'app.php');

for ($i = 0; $i < $argc; $i++) {
    if (strtolower($argv[$i]) == 'bug') {
        $bug = true;
        if (!empty($argv[2])) {
            $eng_id = $argv[2];
            echo ('Eng number ' . $eng_id);
        } else {
            echo ('The eng number cannot be null');
            return false;
        }
    }
}

if ($bug) {
    var_dump($argv);
}
