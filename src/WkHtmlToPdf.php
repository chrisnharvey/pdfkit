<?php

namespace ChrisHarvey\PDFKit;

use FFI;
use FFI\CData;

class WkHtmlToPdf
{
    protected FFI $ffi;
    protected bool $initialized = false;

    public function __construct()
    {
        $this->ffi = FFI::load(__DIR__.'/../pdf.h');
    }

    public function __call(string $name, array $args = [])
    {
        return $this->ffi->$name(...$this->normalizeArgs($args));
    }

    protected function normalizeArgs(array $origArgs)
    {
        $arguments = [];

        foreach ($origArgs as $argument) {
            $arguments[] = $this->normalizeArg($argument);
        }

        return $arguments;
    }

    protected function normalizeArg($arg)
    {
        if ($arg instanceof GarbageCollectable) {
            return $arg();
        }

        return $arg;
    }

    public function wkhtmltopdf_create_converter(...$args)
    {
        return new GarbageCollectable(
            fn () => $this->ffi->wkhtmltopdf_create_converter(...$this->normalizeArgs($args)),
            fn ($converter) => $this->ffi->wkhtmltopdf_destroy_converter($converter)
        );
    }

    public function wkhtmltopdf_create_global_settings()
    {
        return new GarbageCollectable(
            fn () => $this->ffi->wkhtmltopdf_create_global_settings(),
            fn ($globalSettings) => $this->ffi->wkhtmltopdf_destroy_global_settings($globalSettings)
        );
    }

    public function wkhtmltopdf_create_object_settings()
    {
        return new GarbageCollectable(
            fn () => $this->ffi->wkhtmltopdf_create_object_settings(),
            fn ($objectSettings) => $this->ffi->wkhtmltopdf_destroy_object_settings($objectSettings)
        );
    }

    public function wkhtmltopdf_init(...$args)
    {
        if ($this->initialized) {
            return;
        }

        $this->initialized = true;

        return $this->ffi->wkhtmltopdf_init(...$args);
    }

    public function __destruct()
    {
        if ($this->initialized) {
            $this->ffi->wkhtmltopdf_deinit();
        }
    }
}