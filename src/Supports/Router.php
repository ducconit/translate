<?php

namespace DNT\Translate\Supports;

use Closure;
use DNT\Translate\Contracts\Locator as LocatorContract;
use DNT\Translate\Controllers\LocalizationController;
use DNT\Translate\Middleware\BindingLocale;
use Illuminate\Support\Facades\Route;

class Router
{
    /**
     * Thực liện tự động thêm localization vào url
     * domain/{locale}/...
     */
    public function localization()
    {
        return function (Closure $callback, $attributes = []) {
            $container = $this->container;
            $locator = $container->make(LocatorContract::class);

            if ($attributes['use-locale-middleware'] ?? true) {
                $attributes['middleware'] = array_merge($attributes['middleware'] ?? [], [BindingLocale::class]);
            }
            $attributes['middleware'] = array_merge($attributes['middleware'] ?? [], $locator->getMiddlewares());

            $this->group($attributes, $callback);

            $renderRouteLocale = $attributes['route-name-locale'] ?? $container->make('config')['localization.route-name-locale'];

            if ($renderRouteLocale) {
                foreach ($locator->getLocaleSupport() as $locale) {
                    $attributes['prefix'] = $locale;
                    $attributes['as'] = $locale . '.';
                    $attributes['localization'] = $locale;

                    $this->group($attributes, $callback);
                }
            }

            Route::frontend($attributes);
        };
    }

    /**
     * Các route về chỉnh sửa đa ngôn ngữ bằng giao diện
     */
    public function frontend()
    {
        return function ($option = []) {
            if ($option['use-route-change-locale'] ?? true) {
                $this->get('change-locale/{locale?}', [LocalizationController::class, 'changeLocale'])->name('changeLocale');
            }
        };
    }
}
