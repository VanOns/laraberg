<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


  <title>Pages</title>
</head>
<body>
  <main class="content">
    <div class="content-header">
        <h1>Pages</h1>
        <div>
          <a class="button bg-color-primary" href="/laraberg/ui/pages/create"><i class="fa fa-plus"></i></a>
        </div>
    </div>

    @foreach ($pages as $page)
      <div class="page-item">
        <div>{{ $page->id }}</div>
        <div class="bold">{{ $page->title }}</div>
        <div>{{ $page->created_at }}</div>
        <div>
          <a href="/laraberg/ui/pages/{{$page->id}}" class="button bg-color-primary"><i class="fa fa-eye"></i></a>
          <a href="/laraberg/ui/pages/{{$page->id}}/edit"class="button bg-color-primary"><i class="fa fa-pen"></i></a>
          <form action="/laraberg/ui/pages/{{$page->id}}" method="POST">
            @method('DELETE')
            <button href="/laraberg/ui/pages/{{$page->id}}" class="bg-color-accent-1"><i class="fa fa-trash-alt"></i></button>
          </form>
        </div>
      </div>
    @endforeach
  </main>
</body>
</html>