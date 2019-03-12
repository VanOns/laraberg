# Laraberg <!-- omit in toc -->
A Gutenberg implementation for Laravel

# Table of Contents <!-- omit in toc -->
- [Installation](#installation)
  - [Initializing the Editor](#initializing-the-editor)
  - [Models](#models)
- [Configuration](#configuration)
  - [Styling](#styling)
  - [Laravel-Filemanager](#laravel-filemanager)

# Installation

Install package using composer and run:

```bash
php artisan vendor:publish --tag=public
```
To copy the required JS and CSS files to your public folder.

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
use MauriceWijnia\Laraberg\Models\Gutenbergable;

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

# Configuration

When initializing the editor there are a number of configuration options we can provide using a second optional parameter in the initialize function.

## Styling

It is possible to set the height, maxHeight, and minHeight of the editor by providing the desired values in the options object:

```js
Laraberg.initGutenberg('[id_here]', { height: '500px' })
```

```js
Laraberg.initGutenberg('[id_here]', { maxHeight: '500px' })
```

```js
Laraberg.initGutenberg('[id_here]', { minHeight: '500px' })
```

## Laravel-Filemanager

Laraberg supports [laravel-filemanager](https://unisharp.github.io/laravel-filemanager/) for uploading files. To enable uploading media through laravel-filemanager the laravelFilemanager field should be set to true. This will add a 'File Manager' button to the Gutenberg media blocks that will open laravel-filemanager for uploading and selecting media files.

Note: Laraberg does not do any configuration on your laravel-filemanager setup. By default a lot of media filetypes can not be uploaded unless they are whitelisted in the laravel-filemanager configuration file. For more information on this you can check the [laravel-filemanager documentation](https://unisharp.github.io/laravel-filemanager/config).

```js
Laraberg.initGutenberg('[id_here]', { laravelFilemanager: true })
```

If you are not using the default routes for laravel-filemanager you can provide the location of your laravel-filemanager endpoints in the options object like this:

```js
Laraberg.initGutenberg('[id_here]', { laravelFilemanager: { prefix: '/[lfm_prefix_here]' } })
```