# parabola-bundle

This bundle provide tools to handle Rest API.
It includes response builders (Success, ServerError, Client Error) and functionnal testing (using Behat).

## Configuration
To be able to use "the response must be optimized" you need to enable the profiler in config_test.yml

```yaml
profiler:
    enabled: true
```

To enable API wrapping and access the display of the symfony2 profilter, add the following to your parameters.yml
```yaml
wrap_api_response: true
```
