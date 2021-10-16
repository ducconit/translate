<?php
/**
 * 21:30 16/10/2021
 * coded by Trung Đức(DNT)
 */

namespace DNT\Translate;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class TranslateServiceProvider extends ServiceProvider
{

    /**
     * @throws BindingResolutionException
     * @throws \Throwable
     */
    public function register()
    {
        $this->configuration();
        $this->registerLocalization();
    }

    /**
     * @throws \Throwable
     * @throws BindingResolutionException
     */
    private function configuration()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'translate');
    }

    /**
     * Configuration path
     */
    public function getConfigPath(): string
    {
        return __DIR__ . '/config/translate.php';
    }

    private function registerLocalization()
    {
        $this->app->register(LocalizationServiceProvider::class);
    }

    public function boot()
    {
    }
}
