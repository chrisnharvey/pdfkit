<?php

namespace ChrisHarvey\PDFKit;

use RuntimeException;

class ConversionFailedException extends RuntimeException
{
    protected array $errors = [];
    protected array $warnings = [];

    public function __construct(string $message, array $errors = [], array $warnings = [], ...$args)
    {
        $this->errors = $errors;
        $this->warnings = $warnings;

        parent::__construct($message, ...$args);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getWarnings(): array
    {
        return $this->warnings;
    }
}