<?php

namespace BetaPeak\GoDaddy;

use Illuminate\Support\Facades\Facade;

class GoDaddyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor() : string
    {
        return 'laravel-godaddy';
    }
}