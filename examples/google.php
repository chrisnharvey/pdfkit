<?php

require __DIR__.'/../vendor/autoload.php';

use ChrisHarvey\PDFKit\ConversionFailedException;
use ChrisHarvey\PDFKit\PDFKit;

$pdf = new PDFKit();

$pdf->add([
    'page' => 'https://www.google.com/'
])->onProgressChanged(function (int $progress) {
    var_dump($progress);
});

try {
    $output = $pdf->saveTo('google.pdf')->convert();

    print_r($output->getWarnings());
} catch (ConversionFailedException $e) {
    print_r($e->getErrors());
    print_r($e->getWarnings());
}
