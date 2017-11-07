<?php

namespace BetaPeak\GoDaddy\Tests;

use BetaPeak\GoDaddy\GoDaddy;
use BetaPeak\GoDaddy\GoDaddyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        config(['laravel-godaddy.testing' => true]);
        config(['laravel-godaddy.key' => '2s83KQDmVY_UV9QNVRM2GjFfhK9DLAmSU']);
        config(['laravel-godaddy.secret' => 'UV9SJwBz7mGpf3SbVtHa6Q']);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            GoDaddyServiceProvider::class,
        ];
    }
}
