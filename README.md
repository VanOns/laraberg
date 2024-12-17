<p align="center"><img height="300px" src="./logo-text.svg" alt="logo"></p>

# Laraberg

<!-- BADGES -->

Laraberg aims to provide an easy way to integrate the Gutenberg editor with your
Laravel projects. It takes the Gutenberg editor and adds all the communication
and data it needs to function in a Laravel environment.

## Quick start

### Requirements

| Dependency | Minimum version |
|------------|-----------------|
| PHP        | 8.1             |

### Installation

Install the package using Composer:

```bash
composer require van-ons/laraberg
```

Add the vendor files to your project (CSS, JS & config):

```bash
php artisan vendor:publish --provider="VanOns\Laraberg\LarabergServiceProvider"
```

#### JavaScript and CSS files

The package provides a JS and CSS file that should be present on the page you
want to use the editor on:

```html
<link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">

<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
```

#### Dependencies

The Gutenberg editor expects React, ReactDOM, Moment and JQuery to be in the
environment it runs in. An easy way to do this would be to add the following
lines to your page:

```html
<script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>

<script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
```

### Usage

#### Initializing the Editor

The Gutenberg editor should replace an existing textarea in a form. On submit, the
raw content from the editor will be put in the `value` attribute of this textarea:

```html
<textarea id="[id_here]" name="[name_here]" hidden></textarea>
```

In order to edit the content on an already existing model, we have to set the value
of the textarea to the raw content that the Gutenberg editor provided:

```html
<textarea id="[id_here]" name="[name_here]" hidden>{{ $model->content }}</textarea>
```

To initialize the editor, all we have to do is call the initialize method with
the ID of the textarea. You probably want to do this inside a `DOMContentLoaded` event.

And that's it! The editor will replace the textarea in the DOM, and on a form
submit the editor content will be available in the textarea's value attribute.

```js
Laraberg.init('[id_here]')
```

#### Configuration options

The `init()` function takes an optional configuration object which can be used
to change Laraberg's behaviour in some ways:

```js
const options = {}
Laraberg.init('[id_here]', options)
```

The `options` object should be an `EditorSettings` object:

```typescript
interface EditorSettings {
    height?: string;
    mediaUpload?: (upload: MediaUpload) => void;
    fetchHandler?: FetchHandler;
    disabledCoreBlocks?: string[];
    alignWide?: boolean;
    supportsLayout?: boolean;
    maxWidth?: number;
    imageEditing?: boolean;
    colors?: Color[];
    gradients?: Gradient[];
    fontSizes?: FontSize[];
}
```

#### Models

In order to add the editor content to a model, Laraberg provides the
`RendersContent` trait:

```php
use VanOns\Laraberg\Traits\RendersContent;

class MyModel extends Model
{
    use RendersContent;
}
```

This adds the `render` method to your model, which takes care of rendering the
raw editor content. By default, the `render` method renders the content in the
`content` column. This column can be changed by setting the `$contentColumn`
property on your model to the column that you want to use instead:

```php
use VanOns\Laraberg\Traits\RendersContent;

class MyModel extends Model
{
    use RendersContent;

    protected $contentColumn = 'my_column';
}
```

You can also pass the column name to the render method:

```php
$model->render('my_column');
```

#### Custom Blocks

Gutenberg allows developers to create custom blocks. For information on how to
create a custom block you should read the
[Gutenberg documentation].

Registering custom blocks is fairly easy. A Gutenberg block requires the
properties `title`, `icon` and `categories`. It also needs to implement the
functions `edit()` and `save()`:

```js
const myBlock =  {
  title: 'My First Block!',
  icon: 'universal-access-alt',
  category: 'my-category',

  edit() {
    return <h1>Hello editor.</h1>
  },

  save() {
    return <h1>Hello saved content.</h1>
  }
}

Laraberg.registerBlockType('my-namespace/my-block', myBlock)
```

##### Server-side blocks

Server-side blocks can be registered in Laravel. You probably want to create a
ServiceProvider and register your server-side blocks in its `boot` method:

```php
class BlockServiceProvider extends ServiceProvider
{
    public function boot() {
        Laraberg::registerBlockType(
            'my-namespace/my-block',
            [],
            function ($attributes, $content) {
                return view('blocks.my-block', compact('attributes', 'content'));
            }
        );
    }
}
```

#### WordPress exports

Laraberg uses the WordPress Gutenberg packages under the hood. A lot of these
packages expose functionality that lets you customize the editor. You can access these packages
in Javascript using the global `Laraberg` object.

- `Laraberg.wordpress.blockEditor`
- `Laraberg.wordpress.blocks`
- `Laraberg.wordpress.components`
- `Laraberg.wordpress.data`
- `Laraberg.wordpress.element`
- `Laraberg.wordpress.hooks`
- `Laraberg.wordpress.serverSideRender`

## Contributing

Please see [contributing] for more information about how you can contribute.

## Changelog

Please see [changelog] for more information about what has changed recently.

## Upgrading

Please see [upgrading] for more information about how to upgrade.

## Security

Please see [security] for more information about how we deal with security.

## Credits

We would like to thank the following contributors for their contributions to this project:

- [All Contributors][all-contributors]

## License

The scripts and documentation in this project are released under the [GPL-3.0 License][license].

---

<p align="center">
    <a href="https://van-ons.nl/" target="_blank">
        <img src="https://opensource.van-ons.nl/files/cow.png" width="50" alt="Logo of Van Ons">
    </a>
</p>

[Gutenberg documentation]: https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/writing-your-first-block-type/
[contributing]: CONTRIBUTING.md
[changelog]: CHANGELOG.md
[upgrading]: UPGRADING.md
[security]: SECURITY.md
[all-contributors]: ../../contributors
[license]: LICENSE.md
