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
     * @param array $apiKeys Must have array keys 'key' and 'secret'
     */
    public function __construct(array $apiKeys)
    {
        $configuration = new Configuration();

        if (config('laravel-godaddy.testing') === true) {
            $configuration->setHost('https://api.ote-godaddy.com');
        }

        $configuration->addDefaultHeader("Authorization", "sso-key " . $apiKeys['key'] . ":" . $apiKeys['secret']);

        $apiClient = new ApiClient($configuration);
        $this->api = new VdomainsApi($apiClient);
    }

    /**
     * Handle dynamic method calls into the api.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->getApi()->{$method}(...$parameters);
    }

    /**
     * @param string $domain Must be of the type 'top-level-domain.tld', e.g. example.com
     * @param int $purchaseYears
     * @param bool $autoRenew
     * @param null $xShopperId
     */
    public function purchase(string $domain, int $purchaseYears = 1, $autoRenew = false, $xShopperId = null)
    {
        $domainTLD = $this->getTLDFromDomain($domain);
        $contact = config('laravel-godaddy.company-details');

        $agreement = GoDaddy::getAgreement($domainTLD, false);
        $agreementKeys = [$agreement[0]->getAgreementKey()];

        $domainPurchase = new \GoDaddyDomainsClient\Model\DomainPurchase();
        $domainPurchase->setDomain($domain);

        $domainPurchaseConsent = new \GoDaddyDomainsClient\Model\Consent();
        $domainPurchaseConsent->setAgreementKeys($agreementKeys);
        $domainPurchaseConsent->setAgreedBy($contact['name'] . ' ' . $contact['surname']);
        $domainPurchaseConsent->setAgreedAt(date("Y-m-d\TH:i:s\Z"));
        $domainPurchase->setConsent($domainPurchaseConsent);

        $domainContactAdmin = new \GoDaddyDomainsClient\Model\Contact();
        $domainContactAdmin->setNameFirst($contact['name']);
        $domainContactAdmin->setNameLast($contact['surname']);
        $domainContactAdmin->setEmail($contact['email']);
        $domainContactAdmin->setPhone($contact['phone']);
        $domainContactAdmin->setOrganization($contact['organization']);

        $domainContactAdminAddressMailing = new \GoDaddyDomainsClient\Model\Address();
        $domainContactAdminAddressMailing->setAddress1($contact['street']);
        $domainContactAdminAddressMailing->setCity($contact['city']);
        $domainContactAdminAddressMailing->setCountry($contact['country']);
        $domainContactAdminAddressMailing->setPostalCode($contact['postal-code']);
        $domainContactAdminAddressMailing->setState($contact['state']);

        $domainContactAdmin->setAddressMailing($domainContactAdminAddressMailing);

        $domainPurchase->setContactAdmin($domainContactAdmin);
        $domainPurchase->setContactBilling($domainContactAdmin);
        $domainPurchase->setContactRegistrant($domainContactAdmin);
        $domainPurchase->setContactTech($domainContactAdmin);
        $domainPurchase->setPeriod($purchaseYears);
        $domainPurchase->setRenewAuto($autoRenew);

        $this->getApi()->purchase($domainPurchase, $xShopperId);
    }

    /**
     * @return VdomainsApi
     */
    protected function getApi()
    {
        return $this->api;
    }

    /**
     * @param $domain
     * @return mixed
     */
    protected function getTLDFromDomain($domain)
    {
        if (!str_contains($domain, '://')) {
            $domain = 'http://' . $domain;
        }

        $parsed = parse_url($domain, PHP_URL_HOST);

        $parsedParts = explode(".", $parsed);

        return end($parsedParts);
    }
}