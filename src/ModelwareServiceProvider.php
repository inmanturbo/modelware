<?php

namespace Inmanturbo\Modelware;

use Inmanturbo\Modelware\Commands\ModelwareCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelwareServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('modelware')
            ->hasConfigFile()
            ->hasCommand(ModelwareCommand::class);
    }
}
