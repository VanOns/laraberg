# Upgrading

We aim to make upgrading between versions as smooth as possible, but sometimes it involves specific steps to be taken.
This document will outline those steps. And as much as we try to cover all cases, we might miss some. If you come
across such a case, please let us know by [opening an issue][issues], or by adding it yourself and creating a pull request.

## Every update

When updating Laraberg you have to publish the vendor files again by running
the following command:

```bash
php artisan vendor:publish --provider="VanOns\Laraberg\LarabergServiceProvider" --tag="public" --force
```

[issues]: https://github.com/VanOns/laraberg/issues
