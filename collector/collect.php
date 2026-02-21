<?php

header("Access-Control-Allow-Origin: https://test.adomasvcse135.site");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Max-Age: 86400");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

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