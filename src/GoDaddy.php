<?php

namespace BetaPeak\GoDaddy;

use GoDaddyDomainsClient\Api\VdomainsApi;
use GoDaddyDomainsClient\ApiClient;
use GoDaddyDomainsClient\Configuration;

class GoDaddy
{
    /**
     * @var VdomainsApi
     */
    protected $api;

    /**
     * @var
     */
    protected $xShopperId;

    /**
     * GoDaddy constructor.
     */
    public function __construct(){
        $configuration = new Configuration();
        $configuration->addDefaultHeader("Authorization", "sso-key ". config('laravel-godaddy.key') .":". config('laravel-godaddy.secret'));

        $apiClient = new ApiClient($configuration);
        $this->api = new VdomainsApi($apiClient);
    }

    /**
     * Handle dynamic method calls into the api.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
       return $this->api->{$method}(...$parameters);
    }
}