# <img height="300px" src="./logo-text.svg"> <!-- omit in toc -->
[![Latest Version](https://img.shields.io/packagist/v/van-ons/laraberg)](https://packagist.org/packages/van-ons/laraberg)
![License](https://img.shields.io/github/license/VanOns/laraberg.svg)
[![Gitter](https://badges.gitter.im/VanOns/laraberg.svg)](https://gitter.im/VanOns/laraberg?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)


Laraberg aims to provide an easy way to integrate the Gutenberg editor with your Laravel projects. It takes the Gutenberg editor and adds all the communication and data it needs function in a Laravel environment. A demo can be found at [demo.laraberg.io](http://demo.laraberg.io/). If you would like to see an example of how to implement Laraberg you can take a look at the code from the demo  [over here](https://github.com/VanOns/laraberg-demo).

# Table of Contents <!-- omit in toc -->
- [Installation](#installation)
  - [JavaScript and CSS files](#javascript-and-css-files)
  - [Dependencies](#dependencies)
- [Updating](#updating)
- [Usage](#usage)
  - [Initializing the Editor](#initializing-the-editor)
    - [Using the Editor Wihout a Form](#using-the-editor-wihout-a-form)
    - [Setting the editor content](#setting-the-editor-content)
    - [Configuration options](#configuration-options)
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
- [Configuration](#configuration)
  - [Styling](#styling)
  - [API Routes](#api-routes)
  - [Laravel File Manager](#laravel-file-manager)
- [Search Callback](#search-callback)
- [Missing Blocks](#missing-blocks)
- [Contributing](#contributing)

# Installation

Install package using composer:

```bash
composer require van-ons/laraberg
```

Add vendor files to your project (CSS, JS & Config):

```bash
php artisan vendor:publish --provider="VanOns\Laraberg\LarabergServiceProvider"
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
<script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>

<script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>
```

# Updating

When updating Laraberg you have to publish the vendor files again by running this command:
```bash
php artisan vendor:publish --provider="VanOns\Laraberg\LarabergServiceProvider" --tag="public" --force
```

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

### Setting the editor content

It's possible to set the the editor's content using JavaScript:

```js
Laraberg.setContent('content')
```

### Configuration options

The `init()` function takes an optional configuration object which can be used to change Laraberg's behaviour in some ways.
```js
const options = {}
Laraberg.init('[id_here]', options)
```

The `options` object can contain the following optional keys:

|Key                        |Type         |Description                                                                                  |
|---------------------------|-------------|---------------------------------------------------------------------------------------------|
|**sidebar**                |Boolean      |Enables the Laraberg sidebar if `true`                                                       |
|**prefix**                 |String       |The API prefix to use for requests (only use this if you changed the API location manually)  |
|**laravelFilemanager**     |Bool/Object  |Enables Laravel Filemanager for fileuploads if value is truth. Can be an object that contains configuration options. See [Laravel File Manager](#laravel-file-manager).                                                                             |
|**sidebar**                |Boolean      |Enables the Laraberg sidebar if `true`                                                       |
|**searchCb**               |Function     |Will be called when using certain search fields within Gutenberg. See [Search Callback](#search-callback).|
|**height**                 |String       |Sets the height of the editor. Value must be a valid css height value (e.g. '10px', '50%', '100vh').|
|**minHeight**              |String       |Sets the minHeight of the editor. Value must be a valid css min-height value (e.g. '10px', '50%', '100vh').|
|**maxHeight**              |String       |Sets the maxHeight of the editor. Value must be a valid css max-height value (e.g. '10px', '50%', '100vh').|

## Models

In order to add the editor content to a model Laraberg provides the 'Gutenbergable' trait.

```php
use VanOns\Laraberg\Models\Gutenbergable;

class MyModel extends Model {
  use Gutenbergable;
}
```

This adds multiple attributes to your model that will help you with creating/updating/rendering the Gutenberg content.

```php
$content // This is the raw content from the Gutenberg editor
$model = new MyModel;

// Add or update the content
$model->lb_content = $content;

// Save the model
$model->save();

// Get the rendered HTML
$model->lb_content;

// Get the raw Gutenberg output, this should be in the target textarea when updating content
$model->lb_raw_content;
```

> Note: The old renderContent, getRawContent, getRenderedContent and setContent methods from v0.0.4-beta and lower are deprecated and will be removed in a future release.

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
  {!! $page->lb_content !!}
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

# Search Callback

The **button block** has a field that searches for pages or aritcles. In order to use this functionality you can pass a
callback function when initializing Laraberg. This callback functions will receive a `search`, `perPage` and `type` parameter. The callback should return an array of objects that contain a title and an URL or a promise that resolves to such an array.

```javascript
let customSearch = (search, perPage, type) => {
  return [
    {
      title: 'Laraberg Demo',
      url: 'demo.laraberg.io'
    }
  ]
}

Laraberg.init('content', { searchCb: customSearch })
```

# Missing Blocks

Since we have disabled direct file uploading, some of the media blocks require a media library to operate.
This means that the following blocks will only be enabled when you're using Laravel Filemanager for now:

- Cover
- Gallery
- Media & Text

# Contributing

If you want to contribute to Laraberg checkout the [CONTRIBUTING.md](https://github.com/VanOns/laraberg/blob/master/CONTRIBUTING.md)

<div align="center">
	<br><br><br>
	<a href="https://van-ons.nl">
		<svg width="200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 134"><g fill="none"><path fill="#03C758" d="M43.19 90.17H26.13A26.13 26.13 0 0 1 0 64V25.31C0 11.332 11.332 0 25.31 0h97.29c14.431 0 26.13 11.699 26.13 26.13v17.06h17.06c14.431 0 26.13 11.699 26.13 26.13v58.38a5.67 5.67 0 0 1-5.67 5.67H69.32c-14.431 0-26.13-11.699-26.13-26.13z"></path><path fill="#fff" d="M84.54 75.062c4.753 0 8.695 1.519 11.826 4.557 3.132 3.038 4.697 6.861 4.697 11.47s-1.565 8.432-4.697 11.47c-3.13 3.038-7.073 4.557-11.826 4.557-4.733 0-8.664-1.519-11.796-4.557-3.13-3.038-4.696-6.861-4.696-11.47s1.565-8.432 4.696-11.47c3.132-3.038 7.063-4.557 11.796-4.557zm0 9.052c-1.901 0-3.472.651-4.712 1.953s-1.86 2.976-1.86 5.022.62 3.72 1.86 5.022 2.81 1.953 4.712 1.953c1.922 0 3.503-.651 4.743-1.953s1.86-2.976 1.86-5.022-.62-3.72-1.86-5.022-2.821-1.953-4.743-1.953zm40.083-9.052c3.12 0 5.699 1.023 7.734 3.069 2.036 2.046 3.054 4.784 3.054 8.215v19.964h-9.703V89.787c0-1.798-.424-3.183-1.271-4.154s-2.025-1.457-3.534-1.457c-1.426 0-2.604.49-3.534 1.472s-1.395 2.413-1.395 4.294v16.368h-9.703V75.899h9.3v3.813c1.86-3.1 4.877-4.65 9.052-4.65zm42.966 2.635l-2.697 7.564c-3.637-1.55-6.975-2.335-10.013-2.356-2.356 0-3.534.62-3.534 1.86 0 .31.098.573.294.79.197.218.558.409 1.085.574.528.165 1.013.29 1.458.372.444.083 1.131.196 2.061.341l2.232.341c3.265.496 5.74 1.524 7.424 3.084 1.685 1.56 2.527 3.612 2.527 6.154 0 3.348-1.24 5.962-3.72 7.843-2.48 1.88-5.931 2.821-10.354 2.821-6.097 0-10.778-1.064-14.043-3.193l3.379-7.502c3.203 1.901 6.779 2.852 10.726 2.852 2.831 0 4.247-.661 4.247-1.984 0-.579-.351-1.018-1.054-1.317-.703-.3-1.953-.584-3.751-.853l-1.767-.248c-3.658-.537-6.36-1.586-8.107-3.147-1.746-1.56-2.619-3.704-2.619-6.432 0-3.224 1.152-5.725 3.457-7.502 2.304-1.777 5.533-2.666 9.687-2.666 2.439 0 4.593.191 6.463.573 1.87.383 4.077 1.06 6.619 2.031zM56.425 29.899L44.8 60.31H33.733l-11.78-30.411h10.571l6.789 19.84 6.851-19.84zm33.092 0V60.31h-9.393v-3.286c-2.087 2.728-5.001 4.092-8.742 4.092-4.03 0-7.393-1.545-10.09-4.635-2.698-3.09-4.046-6.897-4.046-11.423 0-2.955.61-5.652 1.829-8.091 1.22-2.439 2.914-4.366 5.084-5.781 2.17-1.416 4.588-2.124 7.254-2.124 3.7 0 6.603 1.374 8.711 4.123v-3.286zm-15.81 8.215c-1.922 0-3.482.661-4.681 1.984s-1.798 2.986-1.798 4.991.6 3.668 1.798 4.991c1.199 1.323 2.759 1.984 4.681 1.984 1.901 0 3.462-.656 4.681-1.968 1.22-1.313 1.829-2.982 1.829-5.007s-.61-3.694-1.829-5.006c-1.22-1.313-2.78-1.969-4.681-1.969zm40.966-9.052c3.12 0 5.699 1.023 7.735 3.069 2.035 2.046 3.053 4.784 3.053 8.215V60.31h-9.703V43.787c0-1.798-.424-3.183-1.271-4.154s-2.025-1.457-3.534-1.457c-1.426 0-2.604.49-3.534 1.472s-1.395 2.413-1.395 4.294V60.31h-9.703V29.899h9.3v3.813c1.86-3.1 4.877-4.65 9.052-4.65z"></path></g></svg>
	</a>
  <br>
</div>
