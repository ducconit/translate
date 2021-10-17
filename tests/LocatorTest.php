<?php

namespace DNT\Translate\Tests;

use Illuminate\Support\Facades\Route;

class LocatorTest extends TestCase
{

    public function test_route_localization()
    {
        Route::localization(function () {
            Route::get('/', function () {
                return 'success';
            })->name('index');
        });

        $this->get('/')->assertStatus(200);
    }
}
