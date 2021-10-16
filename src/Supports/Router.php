<?php

namespace DNT\Translate\Supports;

use Closure;
use DNT\Translate\Contracts\Locator as LocatorContract;
use DNT\Translate\Controllers\LocalizationController;
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
            $attributes['middleware'] = array_merge($attributes['middleware']??[],$locator->getMiddlewares());

            $this->group($attributes, $callback);

            if ($container->make('config')['localization.locale_route']) {
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
            $this->get('change-locale/{locale?}',[LocalizationController::class,'changeLocale'])->name('changeLocale');
        };
    }
}
