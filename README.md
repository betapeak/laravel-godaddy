The included trait provides additional features on top of the existing `DatabaseMigrations` trait currently included with Laravel:
 - Using 'migrate:refresh' instead of the hardcoded 'migrate:fresh' by including a property on your test class 
 ```
 protected $useRefreshMigrations = true;
 ```
 
 - Using custom seeders which can be defined separately for each test
 ```
 protected $seederClass = 'AnotherDatabaseSeeder';
 ```


### Installation

This package requires that you are using `laravel/framework: 5.5.*`. Provided this is fulfilled,
you can install the helper traits like so:

```
composer require betapeak/laravel-testing-helper-traits
```

### Usage

You can use the included `DatabaseMigrationsWithSeeding` trait in place of the existing `DatabaseMigrations` trait included
in Laravel. Like the default trait, it will `migrate:fresh` the database, but will also seed it with the default `DatabaseSeeder` class.

```
namespace Tests;
use BetaPeak\Testing\Traits\DatabaseMigrationsWithSeeding;

class SomeUnitTest extends TestCase
{
    use DatabaseMigrationsWithSeeding;
    

    /** @test */
    public function it_tests_something()
    {
        //Test something
    }
    
}
```

You can specify a different seeder class like so:
```
namespace Tests;
use BetaPeak\Testing\Traits\DatabaseMigrationsWithSeeding;

class SomeUnitTest extends TestCase
{
    use DatabaseMigrationsWithSeeding;
    
    protected $seederClass = 'AnotherSeederClass';

    ...
    
}
```

Finally, if you don't want to use `migrate:fresh`, you can force the trait to use `migrate:refresh` like so:
```
namespace Tests;
use BetaPeak\Testing\Traits\DatabaseMigrationsWithSeeding;

class SomeUnitTest extends TestCase
{
    use DatabaseMigrationsWithSeeding;
    
    protected $useRefreshMigrations = true;

    ...
    
}
```

More information on using database migrations in tests can be found on [Laravel's homepage](https://laravel.com/docs/5.5/database-testing)