# parabola-bundle

This bundle provide tools to handle Rest API.
It includes response builders (Success, ServerError, Client Error) and functionnal testing (using Behat).

## Configuration
To be able to use "the response must be optimized" you need to enable the profiler in config_test.yml

```yaml
profiler:
    enabled: true
```

And in your paramaters.yml define cute_ninja_parabola_allowed_origins with the url of your API. 
The parameter is an array to allow you to have multi sources allowed.

For exemple:
```yaml
cute_ninja_parabola_allowed_origins: 
    - 'http://api.my-application.com'
```

To enable API wrapping and access the display of the symfony2 profilter, add the following to your parameters.yml
```yaml
wrap_api_response: true
```

## BaseContext
Create a BaseContext in your project has follow
````php
use CuteNinja\ParabolaBundle\Tests\Feature\Context\BaseContext as ParabolaBaseContext;

class BaseContext extends ParabolaBaseContext
{

}

````

## DB structure & Data
The functionnal tests require you to generate DB structure and populate it with data.
The best way to do it is by implementing two methods with the annotations "@BeforeSuite" and " @AfterScenario @regenerateDB".
To optimize the DB loading we generate the before each suite and after a scenario that use the "@regenerateDB".
This way we won't reload the DB after a test on List API for example since the DB conttent hasn't been modify.

````php
use CuteNinja\ParabolaBundle\Tests\Feature\Context\BaseContext as ParabolaBaseContext;

class BaseContext extends ParabolaBaseContext
{
    /**
     * @BeforeSuite
     */
    public static function beforeSuite()
    {
        // Implement your own DB structure and data logic
    }

    /**
     * @AfterScenario @regenerateDB
     */
    public function regenerateDBAfterScenario()
    {
        // Implement your own DB structure and data logic
    }
}
````

If you want, you can use https://github.com/Cute-Ninja/memoria-bundle to handle the DB structure and data by adding it to your project and using the following code.

````php
use CuteNinja\ParabolaBundle\Tests\Feature\Context\BaseContext as ParabolaBaseContext;

class BaseContext extends ParabolaBaseContext
{
    /**
     * @BeforeSuite
     */
    public static function beforeSuite()
    {
        $process = new Process("php bin/console doctrine:schema:create --env=test");
        $process->setTimeout(3600);
        $process->run();

        $process = new Process("php bin/console cute_ninja:fixture:load --env=test");
        $process->setTimeout(3600);
        $process->run();
    }

    /**
     * @AfterScenario @regenerateDB
     */
    public function regenerateDBAfterScenario()
    {
        $process = new Process("php bin/console doctrine:schema:drop --force --env=test");
        $process->setTimeout(3600);
        $process->run();

        $process = new Process("php bin/console doctrine:schema:create --env=test");
        $process->setTimeout(3600);
        $process->run();

        $process = new Process("php bin/console cute_ninja:fixture:load --env=test");
        $process->setTimeout(3600);
        $process->run();
    }
}
````