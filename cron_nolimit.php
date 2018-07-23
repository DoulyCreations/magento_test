<?php

$fileName = escapeshellarg(basename(__FILE__));
$cronPath = escapeshellarg(dirname(__FILE__) . '/cron.php');

while(1) {
    var_dump('run cron.php at '.date('Y-m-d H:i:s'));
    shell_exec(escapeshellcmd("php $cronPath $fileName > /dev/null 2>&1 &"));
    sleep(30);
}

