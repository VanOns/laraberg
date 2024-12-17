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

## v1 to v2

There are some big changes in Laraberg v2.

- Content is now stored in a column of the model's table.
- WordPress packages are available in Javascript. This means we can use a lot of the functionality, like hooks, that's already available in Gutenberg.
- `@van-ons/block-editor` is used to render the editor. This makes it a lot easier to keep up with the latest Gutenberg versions.
- Server side rendered blocks are now supported.

Unfortunately this means that updating to v2 is not as straight-forward as we would like it to be.

- `Gutenbergable` is no longer used, instead use `RendersContent`.
    - Rendered content is no longer stored in a table, so to migrate to v2 you have to move all content from the `raw_content` column in the `lb_contents` table to a column on your model's table.
- `Laraberg.registerBlock` was renamed to `Laraberg.registerBlockType`.
- `Laraberg.registerCategory` was removed, you can use the WordPress exports to register categories.
- The configurable sidebar was removed.
- Laravel File Manager is no longer supported.
    - This can be solved by implementing your own `mediaUpload` function and passing it as an editor setting.

[issues]: https://github.com/VanOns/laraberg/issues
