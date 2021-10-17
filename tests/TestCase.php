<?php

namespace DNT\Translate\Tests;

use DNT\Translate\Facades\Locator;
use DNT\Translate\TranslateServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            TranslateServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test_translate');
        $app['config']->set('database.connections.test_translate', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);
    }

    protected function getPackageAliases($app)
    {
        return [
            'Locator' => Locator::class
        ];
    }
}

