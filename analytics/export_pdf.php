<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "auth.php";
require "db.php";

require_once __DIR__ . "/vendor/dompdf/dompdf/dompdf_config.inc.php";

$dompdf = new DOMPDF();

echo "DOMPDF loaded successfully";
exit();