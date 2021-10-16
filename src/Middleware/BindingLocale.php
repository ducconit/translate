<?php

namespace DNT\Translate\Middleware;

use Closure;
use DNT\Translate\Contracts\Locator;

class BindingLocale
{
    private $locator;

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function handle($request, Closure $next)
    {
        $locale = $request->route()->getAction('localization') ?: $this->locator->getLocaleSession();

        if ($locale) {
            $this->locator->setLocale($locale, true);
        }
        return $next($request);
    }
}
