<?php

namespace DNT\Translate\Contracts;

interface Locator
{

    public function getLocale();

    public function setLocale(?string $locale, $force = false);

    public function setLocaleToSession(?string $locale);

    public function getLocaleSupport(): array;
}
