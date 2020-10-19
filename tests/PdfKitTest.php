<?php

use ChrisHarvey\PDFKit\ConversionFailedException;
use ChrisHarvey\PDFKit\PDFKit;
use PHPUnit\Framework\TestCase;

class PdfKitTest extends TestCase
{
    public function testConversionWorksWithoutErrors()
    {
        $pdf = new PDFKit();

        $pdf->add([
            'page' => 'http://example.com'
        ]);

        $output = $pdf->convert();

        $this->assertEmpty($output->getWarnings());

    }
}