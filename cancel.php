<?php
print_r($_GET);
//Something to write to txt log
$log  = "Call-time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
         "Log: ".$_GET.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./lib/Openpay/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);