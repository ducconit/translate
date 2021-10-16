<?php

namespace DNT\Translate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DNT\Translate\Supports\Locator
 */
class Locator extends Facade
{
    public static function getFacadeAccessor()
    {
        return \DNT\Translate\Contracts\Locator::class;
    }
}
