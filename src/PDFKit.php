<?php

namespace ChrisHarvey\PDFKit;

use FFI;

class PDFKit
{
    protected array $globalSettings = [];
    protected array $objects = [];
    protected $onStageChanged = null;
    protected $onProgressChanged = null;
    protected array $errors = [];
    protected array $warnings = [];

    public function settings(array $settings)
    {
        $this->globalSettings = $settings;

        return $this;
    }

    public function add(array $settings)
    {
        $this->objects[] = $settings;

        return $this;
    }

    public function resetErrors(): void
    {
        $this->errors = [];
        $this->warnings = [];
    }

    public function onStageChanged(callable $callback)
    {
        $this->onStageChanged = $callback;

        return $this;
    }

    public function onProgressChanged(callable $callback)
    {
        $this->onProgressChanged = $callback;

        return $this;
    }

    public function saveTo(string $path)
    {
        $this->globalSettings['out'] = $path;

        return $this;
    }

    public function convert(bool $useGraphics = false): Output
    {
        $this->resetErrors();

        $wkHtmlToPdf = new WkHtmlToPdf();
        $wkHtmlToPdf->wkhtmltopdf_init($useGraphics);

        $globalSettings = $wkHtmlToPdf->wkhtmltopdf_create_global_settings();

        foreach ($this->globalSettings as $setting => $value) {
            $wkHtmlToPdf->wkhtmltopdf_set_global_setting($globalSettings, $setting, $value);
        }

        $converter = $wkHtmlToPdf->wkhtmltopdf_create_converter($globalSettings);

        foreach ($this->objects as $settings) {
            $objectSettings = $wkHtmlToPdf->wkhtmltopdf_create_object_settings();
            
            foreach ($settings as $setting => $value) {
                $wkHtmlToPdf->wkhtmltopdf_set_object_setting($objectSettings(), $setting, $value);
            }

            $wkHtmlToPdf->wkhtmltopdf_add_object($converter, $objectSettings, null);
        }

        $wkHtmlToPdf->wkhtmltopdf_set_error_callback($converter, function ($converter, string $error) {
            $this->errors[] = $error;
        });

        $wkHtmlToPdf->wkhtmltopdf_set_warning_callback($converter, function ($converter, string $warning) {
            $this->warnings[] = $warning;
        });

        if ($onStageChanged = $this->onStageChanged) {
            $wkHtmlToPdf->wkhtmltopdf_set_phase_changed_callback($converter, function () use ($onStageChanged) {
                $onStageChanged();
            });
        }

        if ($onProgressChanged = $this->onProgressChanged) {
            $wkHtmlToPdf->wkhtmltopdf_set_progress_changed_callback($converter, function ($converter, $progress) use ($onProgressChanged) {
                $onProgressChanged((int) $progress);
            });
        }

        $wkHtmlToPdf->wkhtmltopdf_set_finished_callback($converter, function ($converter, $success) {
            if (! $success) {
                throw new ConversionFailedException($this->errors[0] ?? 'PDF conversion failed', $this->errors, $this->warnings);
            }
        });

        $wkHtmlToPdf->wkhtmltopdf_convert($converter);

        return new Output($this->warnings);
    }
}
