<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>

    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <header>
        <h1>{{config('app.name')}}</h1>

        <nav class="menu">
            <ul>
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('posts.index')}}">Posts</a></li>
            </ul>
        </nav>
    </header>
    @yield('content')
</body>
@stack('scripts')
</html>
