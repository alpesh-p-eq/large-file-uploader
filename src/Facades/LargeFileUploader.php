<?php

namespace AlpeshEquest\LargeFileUploader\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AlpeshEquest\LargeFileUploader\LargeFileUploader
 */
class LargeFileUploader extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AlpeshEquest\LargeFileUploader\LargeFileUploader::class;
    }
}
