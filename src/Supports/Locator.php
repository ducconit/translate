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
        $this->supports = $this->getLocaleSupport();
        $this->resolveLocale();
    }

    public function getLocaleSupport(): array
    {
        return $this->container->make('config')['localization.supports'];
    }

    protected function resolveLocale()
    {
        $localeUrl = $this->getLocaleUrl();

        if ($localeUrl) {
            $this->setLocale($localeUrl);
            return;
        }

        $this->setLocale($this->getLocaleSession());
    }

    public function getLocaleUrl(): ?string
    {
        $locale = Str::before($this->container->make('request')->path(), '/');

        return $this->checkLocale($locale) ? $locale : null;
    }

    public function checkLocale(?string $locale): bool
    {
        return in_array($locale, $this->supports, true);
    }

    public function getLocaleSession(): ?string
    {
        $locale = $this->container->make('session')->get('locale');

        return $this->checkLocale($locale) ? $locale : null;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale, $global = false)
    {
        if (!$this->checkLocale($locale)) {
            return;
        }
        $this->locale = $locale;
        if ($global) {
            $this->container->setLocale($locale);
        }
    }
}
