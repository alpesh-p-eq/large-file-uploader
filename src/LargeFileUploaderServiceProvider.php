<?php

namespace AlpeshEquest\LargeFileUploader;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LargeFileUploaderServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('large-file-uploader')
            ->hasConfigFile()
            ->hasAssets()
            ->hasRoute('web')
            ->hasViewComponent('chunk-file-upload-input', 'ChunkFileUploadInput')
            ->hasViews()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publish('web');
            });
    }
}
