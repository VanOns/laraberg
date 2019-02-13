<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>Edit - {{$page->title}}</title>
</head>
<body>
<h1>Header</h1>
  <div id="laraberg-editor" class="gutenberg__editor block-editor__container"></div>
  <script src="https://unpkg.com/react@16.6.3/umd/react.production.min.js"></script>
  <script src="https://unpkg.com/react-dom@16.6.3/umd/react-dom.production.min.js"></script>
  {{-- <script src="https://unpkg.com/react@16.6.3/umd/react.development.js"></script>
  <script src="https://unpkg.com/react-dom@16.6.3/umd/react-dom.development.js"></script> --}}
  <script src="https://unpkg.com/moment@2.22.1/min/moment.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
  <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
  <script>
    initGutenberg('laraberg-editor', {{$page->id}})
  </script>
</body>
</html>