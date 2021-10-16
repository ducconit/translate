<?php

namespace DNT\Translate\Contracts;

interface Locator
{

    public function getLocale();

    public function setLocale(string $locale);

    public function getLocaleSupport(): array;
}
