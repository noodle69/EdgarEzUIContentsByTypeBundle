# EdgarEzUIContentsByTypeBundle

## Installation

### Get the bundle using composer

Add EdgarEzUIContentsByTypeBundle by running this command from the terminal at the root of
your symfony project:

```bash
composer require edgar/ez-uicontentsbytype-bundle
```

## Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Edgar\EzUIContentsByTypeBundle\EdgarEzUIContentsByTypeBundle(),
        // ...
    );
}
```

## Add routing

Add to your global configuration app/config/routing.yml

```yaml
edgar.ezuicontentsbytype:
    resource: '@EdgarEzUIContentsByTypeBundle/Resources/config/routing.yml'
```
