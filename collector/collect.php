<?php
file_put_contents(
    __DIR__ . '/collector.log',
    "TEST WRITE " . date("c") . PHP_EOL,
    FILE_APPEND
);
http_response_code(204);