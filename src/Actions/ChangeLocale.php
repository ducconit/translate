<?php

namespace DNT\Translate\Actions;

use DNT\Translate\Contracts\Locator;

class ChangeLocale
{

    private $locator;

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function setLocale(?string $locale,$force = false)
    {
        $this->locator->setLocale($locale,$force);
        $this->locator->setLocaleToSession($locale);
    }
}
