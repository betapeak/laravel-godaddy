[![Latest Stable Version](https://poser.pugx.org/betapeak/laravel-godaddy/v/stable)](https://packagist.org/packages/betapeak/laravel-godaddy)
[![License](https://poser.pugx.org/betapeak/laravel-godaddy/license)](https://packagist.org/packages/betapeak/laravel-godaddy)
[![Total Downloads](https://poser.pugx.org/betapeak/laravel-godaddy/downloads)](https://packagist.org/packages/betapeak/laravel-godaddy)

# Laravel GoDaddy
#### Easy and simple GoDaddy API service for your Laravel project

```
$availability = GoDaddy::available('my-dream-website.com');

if($availability->getAvailable() === true){
    GoDaddy::purchase('my-dream-website.com');
}
```

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

and you must enter your key and secret which can be generated from [GoDaddy's website](https://developer.godaddy.com/keys/).
The config file is located at /config/laravel-godaddy.php.

If you are planning to use the package to *purchase* domains, make sure you change
your company details inside the config file as well.

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
GoDaddy::purchase('example.com' );
```

#### Purchasing a domain for two years
```
GoDaddy::purchase('example.com', 2);
```

#### Purchasing a domain with automatic renewal (defaults to false)
```
GoDaddy::purchase('example.com', 1, true);
```

#### Purchasing a domain as a reseller
```
GoDaddy::purchase('example.com', 1, false, 'some-x-seller-id');
```

### Full docs
A list of all available methods and models can be found [here](https://github.com/gellu/godaddy-api-client).