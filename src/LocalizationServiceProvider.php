<?php

namespace DNT\Translate;

use DNT\Translate\Contracts\Locator as Contract;
use DNT\Translate\Supports\Locator;
use DNT\Translate\Supports\Router as LocalizationRouter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     * @throws \Throwable
     */
    public function register()
    {
        $this->configuration();

        $this->app->singleton(Contract::class, function ($app) {
            return new Locator($app);
        });
    }

    /**
     * @throws \Throwable
     * @throws BindingResolutionException
     */
    private function configuration()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'localization');
        $this->loadTranslationsFrom($this->getLangPath(),'localization');
        $this->resolveLocalizationSupport();
    }

    public function getConfigPath(): string
    {
        return __DIR__ . '/config/localization.php';
    }

    public function getLangPath(): string
    {
        return __DIR__ . '/lang';
    }

    /**
     * @throws \Throwable
     * @throws BindingResolutionException
     */
    private function resolveLocalizationSupport()
    {
        $config = $this->app->make('config');
        /**
         * Validate Array
         */
        throw_unless(is_array($config['localization.supports']), \RuntimeException::class, 'Localization support must be array');

        /**
         * Check Locale Support
         */
        if (count($config['localization.supports']) < 1) {
            $config['localization.supports'] = [$config['app.locale']];
        }
    }

    public function boot()
    {
        $this->publishFile();
        Route::mixin(new LocalizationRouter());
        Validator::extend('locale',function($app,$t){
            dd($app,$t);
        });
    }

    private function publishFile()
    {
        $this->publishes([
            __DIR__.'/lang' => resource_path('lang/vendor/localization'),
            __DIR__.'/config' => base_path('config'),
        ]);
    }
}
