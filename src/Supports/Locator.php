<?php

namespace DNT\Translate\Supports;

use DNT\Translate\Contracts\Locator as LocatorContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;

class Locator implements LocatorContract
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $supports = [];

    /**
     * @var string
     */
    private $locale;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->resolveLocaleSupport();
        $this->resolveLocale();
    }

    protected function resolveLocaleSupport()
    {
        $this->supports = $this->container->make('config')['localization.supports'];
    }

    protected function resolveLocale()
    {
        $localeUrl = $this->getLocaleUrl();

        if ($localeUrl) {
            $this->setLocale($localeUrl);
            return;
        }

        $localeSession = $this->getLocaleSession();

        if ($localeSession) {
            $this->setLocale($localeSession);
            return;
        }

        $this->locale = $this->container->getLocale();
    }

    public function getLocaleUrl(): ?string
    {
        $locale = Str::before($this->container->make('request')->path(), '/');

        return $this->checkLocale($locale) ? $locale : null;
    }

    public function checkLocale(?string $locale, $strict = true): bool
    {
        return in_array($locale, $this->supports, $strict);
    }

    public function getLocaleSession(): ?string
    {
        $locale = $this->container->make('session')->get($this->getNameSession());

        return $this->checkLocale($locale) ? $locale : null;
    }

    protected function getNameSession(): string
    {
        return 'locale';
    }

    public function getLocaleSupport(): array
    {
        return $this->supports;
    }

    public function getLocaleSupportDiffCurrent(): array
    {
        return array_diff($this->supports, [$this->getLocale()]);
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale, $force = false)
    {
        if (!$locale) {
            return;
        }
        if (!$this->checkLocale($locale)) {
            return;
        }
        $this->locale = $locale;
        if ($force) {
            $this->container->setLocale($locale);
        }
    }

    public function setLocaleToSession(?string $locale)
    {
        $this->container->make('session')->put($this->getNameSession(), $locale);
    }

    public function getMiddlewares()
    {
        return $this->container->make('config')['localization.middleware'];
    }
}
