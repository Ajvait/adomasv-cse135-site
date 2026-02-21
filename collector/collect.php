<?php

http_response_code(204);

$raw = file_get_contents("php://input");

if ($raw) {
    $logfile = __DIR__ . '/collector.log';
    file_put_contents(
        $logfile,
        date("c") . " " . $raw . PHP_EOL,
        FILE_APPEND
    );
}