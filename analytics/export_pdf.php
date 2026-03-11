<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$html = "<h1>Test PDF</h1>";

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("test.pdf");