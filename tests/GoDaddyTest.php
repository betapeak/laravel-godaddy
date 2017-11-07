<?php

namespace BetaPeak\GoDaddy\Tests;


use BetaPeak\GoDaddy\GoDaddyFacade as GoDaddy;
use GoDaddyDomainsClient\Model\DomainAvailableResponse;

class GoDaddyTest extends TestCase
{
    protected $popularTLDSs = [
        '.com',
        '.xyz',
        '.net',
        '.org',
        '.co',
        '.info',
        '.io',
        '.me',
        '.in',
        '.eu',
    ];

    /** @test */
    public function it_checks_if_any_of_the_most_popular_tlds_are_available()
    {
        foreach ($this->popularTLDSs as $tld) {
            $this->assertInstanceOf(DomainAvailableResponse::class, GoDaddy::available('example' . $tld));
        }
    }

    /** @test */
    public function it_checks_if_it_can_register_any_of_the_popular_tlds()
    {
        // Not testable with GoDaddy Test API
    }
}