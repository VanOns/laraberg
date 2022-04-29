<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <header>
        <h1>{{config('app.name')}}</h1>

        <nav class="menu">
            <ul>
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('posts.create')}}">Create Post</a></li>
            </ul>
        </nav>
    </header>
    @yield('content')
    <script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
