# PDFKit for PHP

PDFKit is a PHP package that converts HTML to PDFs using WebKit.

Uses the [wkhtmltopdf](http://github.com/antialize/wkhtmltopdf) C library via PHP FFI.

*Note: This package is a work in progress and its API is subject to change. Use in production environments not recommended.*

## Requirements

- PHP 7.4 or later
- FFI extension
- wkhtmltopdf library

## Installation

```
composer require chrisnharvey/pdfkit
```

## Usage

```php
use ChrisHarvey\PDFKit\PDFKit;
use ChrisHarvey\PDFKit\ConversionFailedException;

$pdfkit = new PDFKit();

// Add a page to the pdf
$pdfkit->add([
    'page' => 'http://example.com'
]);

$pdfkit->saveTo('example.pdf');

$pdfkit->onStageChanged(function () {
    echo "Moved to next stage";
});

$pdfKit->onProgressChanged(function ($percent) {
    echo $percent; // Print percentage
});

try {
    $pdfkit->convert();
} catch (ConversionFailedException $e) {
    print_r($e->getErrors());
    print_r($e->getWarnings());
}
```