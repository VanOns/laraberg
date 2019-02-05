<?php

namespace mauricewijnia\Laraberg\Test;

use mauricewijnia\Laraberg\LarabergFacade;
use mauricewijnia\Laraberg\LarabergServiceProvider;
use Orchestra\Testbench\Testcase as OrchestraTestCase;

class TestCase extends OrchestraTestCase {
      /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return mauricewijnia\Laraberg\LarabergServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [LarabergServiceProvider::class];
    }
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Laraberg' => LarabergFacade::class,
        ];
    }
}