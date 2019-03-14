# Laraberg <!-- omit in toc -->
A Gutenberg implementation for Laravel

# Table of Contents <!-- omit in toc -->
- [Installation](#installation)
  - [JavaScript and CSS files](#javascript-and-css-files)
  - [Dependencies](#dependencies)
- [Configuration](#configuration)
  - [Styling](#styling)
  - [API Routes](#api-routes)
  - [Laravel File Manager](#laravel-file-manager)
- [Usage](#usage)
  - [Initializing the Editor](#initializing-the-editor)
  - [Models](#models)
    - [Renaming Gutenbergable method names](#renaming-gutenbergable-method-names)
  - [Rendering Gutenberg Content](#rendering-gutenberg-content)

# Installation

Install package using composer and run:

```bash
php artisan vendor:publish --provider='VanOns\Laraberg\LarabergServiceProvider'
```
To copy the required JS, CSS and config files to your project.

In order to store the data for the Gutenberg editor, Laraberg needs to run a database migration:

```
php artisan:migrate
```

This will create the 'lb_contents' and 'lb_blocks' tables.

## JavaScript and CSS files

The package provides a JS and CSS file that should be present on the page you want to use the editor on: 

```html
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">

<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
```

## Dependencies

The Gutenberg editor expects React, ReactDOM, Moment and JQuery to be in the environment it runs in. An easy way to do this would be to add the following lines to your page:

```html
<script src="https://unpkg.com/react@16.6.3/umd/react.production.min.js"></script>

<script src="https://unpkg.com/react-dom@16.6.3/umd/react-dom.production.min.js"></script>

<script src="https://unpkg.com/moment@2.22.1/min/moment.min.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
```

# Configuration

When initializing the editor there are a number of configuration options we can provide using a second optional parameter in the initialize function.

## Styling

It is possible to set the height, maxHeight, and minHeight of the editor by providing the desired values in the options object:

```js
Laraberg.initGutenberg('[id_here]', { height: '500px' })

Laraberg.initGutenberg('[id_here]', { maxHeight: '500px' })

Laraberg.initGutenberg('[id_here]', { minHeight: '500px' })
```
## API Routes

After publishing the vendor files you can find the 'laraberg.php' file in your config folder. This file allows you to configure the API Routes. Here you can change the URL prefix and the middleware for the routes.

If you wish to define the routes yourself you can do that by setting 'use_package_routes' to 'false' in the config. Then you can take the following routes and make changes as you see fit:

```php
Route::group(['prefix' => 'laraberg', 'middleware' => ['web', 'auth']], function() {
  Route::apiResource('blocks', 'VanOns\Laraberg\Http\Controllers\BlockController');
  Route::get('oembed', 'VanOns\Laraberg\Http\Controllers\OEmbedController');
});
```

## Laravel File Manager

Laraberg supports [Laravel File Manager](https://unisharp.github.io/laravel-filemanager/) for uploading files. To enable uploading media through Laravel File Manager the laravelFilemanager field should be set to true. This will add a 'File Manager' button to the Gutenberg media blocks that will open Laravel File Manager for uploading and selecting media files.

```js
Laraberg.initGutenberg('[id_here]', { laravelFilemanager: true })
```

If you are not using the default routes for Laravel File Manager you can provide the location of your Laravel File Manager endpoints in the options object like this:

```js
Laraberg.initGutenberg('[id_here]', { laravelFilemanager: { prefix: '/[lfm_prefix_here]' } })
```

> Note: Laraberg does not do any configuration on your Laravel File Manager setup. By default a lot of media filetypes can not be uploaded unless they are whitelisted in the Laravel File Manager configuration file. For more information on this you can check the [Laravel File Manager documentation](https://unisharp.github.io/laravel-filemanager/config).

# Usage

## Initializing the Editor

The Gutenberg editor should replace an existing textarea in a form. On submit the raw content from the editor will be put in the 'value' attribute of this textarea.

```html
<input id="[id_here]" type="textarea" name="[name_here]" hidden>
```

In order to edit content on an already existing model we have to set the value of the textarea to the raw content that the Gutenberg editor provided.

```html
<input id="[id_here]" type="textarea" name="[name_here]" value="{{$model->getRawContent()}}" hidden>
```

To initialize the editor all we have to do is call the initialize function with the id of the textarea. You probably want to do this insde a DOMContentLoaded event.

```js
Laraberg.initGutenberg('[id_here]')
```

And that's it! The editor will replace the textarea in the DOM and on a form submit the editor content will be available in the textarea's value attribute.

## Models

In order to add the editor content to a model Laraberg provides the 'Gutenbergable' trait.

```php
use VanOns\Laraberg\Models\Gutenbergable;

class MyModel extends Model {
  use Gutenbergable;
}
```

This adds multiple methods to your model that will help you with creating/updating/rendering the Gutenberg content.

```php
$content // This is the raw content from the Gutenberg editor
$model = new MyModel;

// Add the content to your model
$model->createContent($content);

// Update the content & (if true is provided) call save() on the content object
$model->setContent($content, true);

// Get the rendered HTML inside of a container
// This is the function you should use for rendering the content on a page
$model->renderContent();

// Get the rendered content
$model->getRenderedContent();

// Get the raw content
$model->getRawContent();
```

### Renaming Gutenbergable method names

There is always the possibility that your model already implements a method with the same name as one of the Gutenbergable methods. Luckily PHP Traits provide an easy way to rename the methods from a trait:

```php
class MyModel extends Model {
  use Gutenbergable {
    renderContent as renderLBContent;
  }

  public function renderContent() {
    // Your method
  }
}
```
In this example you can just call the 'renderLBContent' method to render the content.

## Rendering Gutenberg Content

Rendering the Gutenberg content is very simple and happens like this:

```html
<div id="your_container"> <!-- The element you want to render the content in -->
  {!! $page->renderContent() !!}
</div>

```

Keep in mind that in order to correctly display some of the Wordpress styling the Laraberg CSS has to be present on the page:

```html
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
```
