# Translations Testing Bundle

*A simple way to test translations in your Symfony application.*

A Symfony bundle, which provides a page in your application to input translation keys and arguments and instantly see the translation results. Useful for testing / debugging ICU based translations with multiple arguments, without having to change the state of your application for each variant, or hunt down the page which uses the translation.

![alt text](https://therichcourt.com/images/translations-testing-bundle-screenshot.png "Screenshot of Translations Testing Bundle")

## Installation
composer require --dev therichcourt/translations-testing-bundle

## Configuration

### 1. Register the bundle in `config/bundles.php`

```php
TheRichCourt\TranslationsTestingBundle\TranslationsTestingBundle::class => ['dev' => true],
```

### 2. Create a configuration for the bundle in `config/packages/dev/translations_testing.yaml`

```yaml
translations_testing:
    locales:
        - 'en'
        - 'es'
        - 'fr'
        # ...
```

### 3. Set up the routes in `config/routes/dev/routes.yaml`

```yaml
_translations_testing:
    resource: '@TranslationsTestingBundle/Resources/config/routes.yaml'
    # Change the prefix to wherever you'd like the translations testing page to be.
    # Keep in mind any path prefixes you have on your site, for example the page may
    # end up at `/en_GB/tests/translations`
    prefix: /tests/translations
```

That's all the set-up done. You can now go to the page on your site, and start testing translations.

## Features

* Translate your keys into all locales
* Test ICU translations, by passing arguments
* Highlights potential issues, e.g. if the translated message matches the key *(which could mean you're missing a translation definiton)*

*N.B. this is **not** an automated testing solution - it just makes it much easier for you to manually test the results of your translations.*

## Contributing

Any PRs with fixes or improvements gratefully received.

### Setting the project up

Simply fork, clone and then run `composer install`.

### Testing

Run `composer test` to run all tests and lints.
