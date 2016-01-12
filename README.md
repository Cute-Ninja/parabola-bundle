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
