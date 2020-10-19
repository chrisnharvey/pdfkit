<?php

namespace ChrisHarvey\PDFKit;

class Output
{
    protected array $warnings = [];

    public function __construct(array $warnings = [])
    {
        $this->warnings = $warnings;
    }

    public function getWarnings(): array
    {
        return $this->warnings;
    }
}