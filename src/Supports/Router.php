<?php

namespace DNT\Translate\Supports;

use Closure;
use DNT\Translate\Contracts\Locator as LocatorContract;
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

            $locale = $locator->getLocale();

            if ($locale) {
                $container->setLocale($locale);
                $attributes['prefix'] = $locale;
                $attributes['as'] = $locale . '.';
            }

            $this->group($attributes, $callback);

            if ($container->make('config')['localization.locale_route']) {
                $localeSupport = array_diff($locator->getLocaleSupport(), [$locale]);

                foreach ($localeSupport as $name) {
                    $attributes['prefix'] = $name;
                    $attributes['as'] = $name . '.';

                    $this->group($attributes, $callback);
                }
            }

//            Route::frontend($attributes);
        };
    }

    /**
     * Các route về chỉnh sửa đa ngôn ngữ bằng giao diện
     */
//    public function frontend()
//    {
//        return function ($option = []) {
//        };
//    }
}
