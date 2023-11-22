<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>@yield('title') | {{config('app.name')}}</title>
    <link rel="manifest" href="/manifest.webmanifest">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @routes()
    @stack('meta')
</head>

<body>
    <div id="app">
        @yield('header')
        <main>
            @yield('content')
        </main>

        <aside>
            @stack('modals')
        </aside>

        @include('layouts.menu')
    </div>

    @stack('scripts')
</body>

</html>