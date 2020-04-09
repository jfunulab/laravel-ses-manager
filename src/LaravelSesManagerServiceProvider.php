<?php

namespace Jfunu\LaravelSesManager;

use Illuminate\Support\ServiceProvider;
use Jfunu\LaravelSesManager\Contracts\SESMessageValidatorContract;

class LaravelSesManagerServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->mergeConfigFrom(
            $this->getConfigFilePath(),
            'ses-manager'
        );

        $this->app->bind(SESMessageValidatorContract::class, SESMessageValidator::class);
    }

    public function boot()
    {
        $this->publishes([
            $this->getConfigFilePath() => config_path('ses-manager.php'),
        ]);
    }

    private function getConfigFilePath()
    {
        return __DIR__ . '/config.php';
    }
}
