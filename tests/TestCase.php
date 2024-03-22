<?php

namespace Drive\ScaleflexApiConnector\Tests;

use Drive\ScaleflexApiConnector\ScaleflexServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            ScaleflexServiceProvider::class,
        ];
    }
}
