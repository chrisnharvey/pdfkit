<?php

namespace ChrisHarvey\PDFKit;

use FFI;
use RuntimeException;

class GarbageCollectable
{
    private $destructor;
    private $object;

    public function __construct(callable $constructor, ?callable $destructor = null)
    {
        $this->destructor = $destructor;

        $this->object = $constructor();
    }

    public function __destruct()
    {
        if (! $this->destructor) {
            FFI::free($this->object);
            return;
        }

        ($this->destructor)($this->object);
    }

    public function __invoke()
    {
        return $this->object;
    }

    public function __clone()
    {
        throw new RuntimeException('Cloning this object is not allowed');
    }
}