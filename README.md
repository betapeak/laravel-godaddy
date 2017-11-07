Provides an easy to use way to communicate with GoDaddy's API in the context of
a Laravel application.

### Installation

This package requires that you are using Laravel 5.3 or above. 

You can install it with composer like so:
```
composer require betapeak/laravel-godaddy
```

If you are using Laravel 5.3 or 5.4, you will need to add the service provider and
facade to your /config/app.php:

```
/config/app.php

    ...
    
    'providers' => [
        ...,
        BetaPeak\GoDaddy\GoDaddyServiceProvider::class
    ],
    
    'aliases' => [
        ...,
        'GoDaddy' => BetaPeak\GoDaddy\GoDaddyFacade::class
    ],
    ...


```

Finally, you need to publish the config file:

```
php artisan vendor:publish --provider="BetaPeak\GoDaddy\GoDaddyServiceProvider"
```

**You need to enter your key and secret (which can be generated [here](https://developer.godaddy.com/keys/)) 
inside the config file you just published. It is located at /config/laravel-godaddy.php.**

### Example usage

#### Checking if a domain is available for purchase
```
    $result = GoDaddy::available('example.com');
    
    if($result->getAvailable() === true)
    {
        \\ Yey, ready to be bought!
    } else {
        \\ Not available
    }
```

#### Purchasing a domain
```
$domain 			= 'test-domain.com';
$domainPeriod 		= 1;
$domainAutoRenew	= false;
$domainTLD 			= 'pl';
$contact 			= [
	'name'			=> 'John',
	'surname'		=> 'Doe',
	'email'			=> 'john.doe@test-domain.com',
	'phone'			=> '+48.111111111',
	'organization'	=> 'Corporation Inc.',
	'street'		=> 'Street Ave. 666',
	'city'			=> 'New City',
	'country'		=> 'PL',
	'postal-code'	=> '11-111',
	'state'			=> 'state of art'
];

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
$domainPurchase->setPeriod($domainPeriod);
$domainPurchase->setRenewAuto($domainAutoRenew);

$result = GoDaddy::purchase($domainPurchase);
```

### Full docs
A list of all available methods and models can be found [here](https://github.com/gellu/godaddy-api-client).