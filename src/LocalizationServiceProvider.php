<?php

namespace DNT\Translate;

use DNT\Translate\Contracts\Locator as Contract;
use DNT\Translate\Supports\Locator;
use DNT\Translate\Supports\Router as LocalizationRouter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use RuntimeException;
use Throwable;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function register()
    {
        $this->configuration();

        $this->app->singleton(Contract::class, function ($app) {
            return new Locator($app);
        });
    }

    /**
     * @throws Throwable
     * @throws BindingResolutionException
     */
    private function configuration()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'localization');
        $this->loadTranslationsFrom($this->getLangPath(), 'localization');
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
     * @throws Throwable
     * @throws BindingResolutionException
     */
    private function resolveLocalizationSupport()
    {
        $config = $this->app->make('config');
        /**
         * Validate Array
         */
        throw_unless(is_array($config['localization.supports']), RuntimeException::class, 'Localization support must be array');

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

        $this->customValidator();
    }

    private function publishFile()
    {
        $this->publishes([
            __DIR__ . '/lang' => resource_path('lang/vendor/localization'),
        ], 'localization-lang');

        $this->publishes([
            __DIR__ . '/config' => base_path('config')
        ], 'localization-config');
    }

    private function customValidator()
    {
        Validator::extend('locale', function ($attribute, $value, $params) {
            $localeSupport = array_diff($this->app->make(Contract::class)->getLocaleSupport(), $params);
            return in_array($value, $localeSupport);
        }, __('localization::locator.localeNotSupport'));
    }
}
