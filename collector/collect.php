<?php
$data = file_get_contents("php://input");
file_put_contents(__DIR__ . "/beacon.log", $data . PHP_EOL, FILE_APPEND);
http_response_code(204);