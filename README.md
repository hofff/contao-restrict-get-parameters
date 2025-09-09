# Contao Restrict Get Parameters

This Contao extension allows you to restrict GET parameters in the frontend by configuring a whitelist of allowed
parameter patterns. Any GET parameters not matching the whitelist will be marked as unused and won't be processed by
Contao.

## System Requirements

- `PHP 8.1` or higher
- Contao `4.13+` or `5.3+`
- Symfony `5.4+, 6.4+ or 7.0+`

## Configuration

In the Contao system settings, you can:

1. Enable GET parameter restriction
2. Configure a whitelist of allowed parameter patterns using wildcards (e.g., page*, *id, *alias*)

It's also possible to use the bundle configuration:

```yaml
contao:
    localconfig:
      restrict_get_parameters: true
      restrict_get_parameters_whitelist: ['param-a', 'param-b']
```
## Known limitations

### Isotope product list

This extension uses the unused get parameter feature of Contao and marks all get parameters as unused before rendering a
page. Used get parameters on the page are marked as used later on, so in the end Contao throws an exception if any
parameter was not used. This does not work when a page contains an isotope product list / filter, as Isotope marks all
get parameters as used.
