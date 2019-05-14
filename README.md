# <img height="300px" src="./logo-text.svg"> <!-- omit in toc -->
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/van-ons/laraberg.svg)](https://packagist.org/packages/van-ons/laraberg)
![License](https://img.shields.io/github/license/VanOns/laraberg.svg)
[![Gitter](https://badges.gitter.im/VanOns/laraberg.svg)](https://gitter.im/VanOns/laraberg?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)


Laraberg aims to provide an easy way to integrate the Gutenberg editor with your Laravel projects. It is built on top of the [GutenbergJS](https://github.com/front/gutenberg-js) project, implements all the necessary communication and adds an easy to use API. A demo can be found at [demo.laraberg.io](http://demo.laraberg.io/). If you would like to see an example of how to implement Laraberg you can take a look at the code from the demo  [over here](https://github.com/VanOns/laraberg-demo).

# Table of Contents <!-- omit in toc -->
- [Installation](#installation)
  - [JavaScript and CSS files](#javascript-and-css-files)
  - [Dependencies](#dependencies)
- [Updating](#updating)
- [Configuration](#configuration)
  - [Styling](#styling)
  - [API Routes](#api-routes)
  - [Laravel File Manager](#laravel-file-manager)
- [Usage](#usage)
  - [Initializing the Editor](#initializing-the-editor)
    - [Using the Editor Wihout a Form](#using-the-editor-wihout-a-form)
  - [Models](#models)
    - [Renaming Gutenbergable method names](#renaming-gutenbergable-method-names)
  - [Rendering Gutenberg Content](#rendering-gutenberg-content)
  - [Custom Blocks](#custom-blocks)
    - [Registering Blocks](#registering-blocks)
    - [Registering Categories](#registering-categories)
  - [Events](#events)
  - [Sidebar](#sidebar)
    - [Checkbox](#checkbox)
    - [Radio](#radio)
    - [Select](#select)
    - [Text](#text)
    - [Textarea](#textarea)
- [Missing Blocks](#missing-blocks)
- [Updating from 0.0.1 to 0.0.2-or-later](#updating-from-001-to-002-or-later)
- [Contributors](#contributors)

# Installation

Install package using composer:

```bash
composer require van-ons/laraberg
```

Add vendor files to your project (CSS, JS & Config):

```bash
php artisan vendor:publish --provider='VanOns\Laraberg\LarabergServiceProvider'
```

In order to store the data for the Gutenberg editor, Laraberg needs to run a database migration:

```
php artisan migrate
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

# Updating

When updating Laraberg you have to publish the vendor files again by running this command:
```bash
php artisan vendor:publish --provider='VanOns\Laraberg\LarabergServiceProvider' --tag="public" --force
```

# Configuration

When initializing the editor there are a number of configuration options you can provide. This is still a work in progress!

## Styling

It is possible to set the height, maxHeight, and minHeight of the editor by providing the desired values in the options object:

```js
Laraberg.init('[id_here]', { height: '500px' })

Laraberg.init('[id_here]', { maxHeight: '500px' })

Laraberg.init('[id_here]', { minHeight: '500px' })
```
## API Routes

After publishing the vendor files you can find the 'laraberg.php' file in your config folder. This file allows you to configure the API Routes. Here you can change the URL prefix and the middleware for the routes.

When you change the route prefix you also have to provide the prefix when you initialize the editor like this:

```js
Laraberg.init('[id_here]', { prefix: '/[prefix_here]' })
```

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
Laraberg.init('[id_here]', { laravelFilemanager: true })
```

If you are not using the default routes for Laravel File Manager you can provide the location of your Laravel File Manager endpoints in the options object like this:

```js
Laraberg.init('[id_here]', { laravelFilemanager: { prefix: '/[lfm_prefix_here]' } })
```

> Note: Laraberg does not do any configuration on your Laravel File Manager setup. By default a lot of media filetypes can not be uploaded unless they are whitelisted in the Laravel File Manager configuration file. For more information on this you can check the [Laravel File Manager documentation](https://unisharp.github.io/laravel-filemanager/config).

# Usage

## Initializing the Editor

The Gutenberg editor should replace an existing textarea in a form. On submit the raw content from the editor will be put in the 'value' attribute of this textarea.

```html
<textarea id="[id_here]" name="[name_here]" hidden></textarea>
```

In order to edit content on an already existing model we have to set the value of the textarea to the raw content that the Gutenberg editor provided.

```html
<textarea id="[id_here]" name="[name_here]" hidden>{{$model->getRawContent()}}</textarea>
```

To initialize the editor all we have to do is call the initialize function with the id of the textarea. You probably want to do this insde a DOMContentLoaded event.

And that's it! The editor will replace the textarea in the DOM and on a form submit the editor content will be available in the textarea's value attribute.

```js
Laraberg.init('[id_here]')
```

### Using the Editor Wihout a Form

If you want to use the editor, but for some reason do not want to deal with submitting forms there is a way to get the content from the editor through JavaScript:

```js
let content = Laraberg.getContent()
```

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

// Add or update the content & (if true is provided) call save() on the content object
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

## Custom Blocks

Gutenberg allows developers to create custom blocks. For information on how to create a custom block you should read the [Gutenberg documentation.](https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/writing-your-first-block-type/)

### Registering Blocks

Registering custom blocks is fairly easy. A Gutenberg block requires the properties `title`, `icon`, and `categories`. It also needs to implement the functions `edit()` and `save()`.

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

Laraberg.registerBlock('my-namespace/my-block', myBlock)
```

### Registering Categories

If you want to add your custom block to a new category you need to add that category first:

```js
let title = 'My Category'
let slug = 'my-category'
Laraberg.registerCategory(title, slug)
```

## Events

Laraberg implements Laravel events that you can use to implement your own listeners. The events contain a 'content' attribute that contains the relevant Content object. For information on how Laravel events work you can read the [Laravel documentation](https://laravel.com/docs/5.8/events).

- VanOns\Laraberg\Events\ContentCreated
- VanOns\Laraberg\Events\ContentRendered
- VanOns\Laraberg\Events\ContentUpdated

## Sidebar

Laraberg provides a way to put your form fields in a seperate sidebar in the Gutenberg editor. This way you can let the editor take the entire screen while still having a place for your form fields. This is done by putting the input element in a parent element with the `.laraberg-sidebar` class. This is currently supported for the following input types:
- Checkbox
- Radio
- Select
- Text
- Textarea

For the labels Laraberg first checks if there is a label assigned to the element and will try to use that. If there is no label assigned it will check if there is a placeholder and use that as the label.

To enable the sidebar set the `sidebar` option to true when initializing Laraberg:
```js
Laraberg.init('[id_here]', { sidebar: true })
```

### Checkbox
```HTML
<div class="laraberg-sidebar">
  ...
  <label for="article-public">Public</label>
  <input id="article-public" name="public" type="checkbox">
</div>
```

### Radio

```HTML
<div class="laraberg-sidebar">
  ...
  <label for="letter-a">A</label>
  <input type="radio" name="letter" id="letter-a" value="a" checked> 
  <label for="letter-b">B</label>
  <input type="radio" name="letter" id="letter-b" value="b"> 
  <label for="letter-c">C</label>
  <input type="radio" name="letter" id="letter-c" value="c">
</div>
```

### Select
```HTML
<div class="laraberg-sidebar">
  ...
  <label for="article-month">Month</label>
  <select id="article-month" name="month" class="uk-select uk-form-large ">
      <option value="1">January</option>
      <option value="2">February</option>
      <option value="3">March</option>
      <option value="4">April</option>
      ...
  </select>
</div>
```

### Text
```HTML
<div class="laraberg-sidebar">
  ...
  <input id="article-title" type="text" name="title" placeholder="Title" />
</div>
```

### Textarea
```HTML
<div class="laraberg-sidebar">
  ...
  <textarea name="excerpt" id="article-excerpt" placeholder="Excerpt"></textarea>
</div>
```


# Missing Blocks

Since we have disabled direct file uploading, some of the media blocks require a media library to operate.
This means that the following blocks will only be enabled when you're using Laravel Filemanager for now:

- Cover
- Gallery
- Media & Text

# Updating from 0.0.1 to 0.0.2-or-later

In beta version 0.0.1 we used JSON column types for block titles. This was not supported by MariaDB, so we had to change that.
In the [releasenotes for beta version 0.0.2](https://github.com/VanOns/laraberg/releases/tag/v0.0.2-beta) you can find how to deal with this problem if you do not want to lose your data from version 0.0.1.

# Contributors

[![Maurice Wijnia](https://github.com/mauricewijnia.png?size=100)](https://github.com/mauricewijnia) |
--- |
[Maurice Wijnia](http://mauricewijnia.nl) |

<div align="center">
	<br><br><br>
	<a href="https://van-ons.nl">
		<img src="https://koenect.van-ons.nl/bestanden/VO-logo_final.svg" width="200" alt="Van Ons">
	</a>
  <br>
</div>