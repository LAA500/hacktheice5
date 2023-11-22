<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <header class="header">
            <nav class="navbar bg-body-tertiary">
                <div class="container">
                    <div class="row justify-content-between">
                        <div>
                            <span class="navbar-brand mb-0 h1">Северное сияние</span>
                        </div>
                        <div>
                            <div>
                                <div data-bs-toggle="modal" data-bs-target="#city">{{session()->has('city.name') ? session('city.name') : 'Выберите населенный пункт'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="footer">
            <div class="container">
                <div class="copyright">
                    <div>&copy; проект команды «Fairy Tail» {{date('Y')}}</div>
                    <div>специально для <a href="https://ityakutia.com/hacktheice5" target="_blank" rel="noopener noreferrer">HACK-the-ICE 5.0 «OldSchool»</a></div>
                </div>
            </div>
        </footer>
        <aside>
            <div class="modal fade" id="city" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Населенный пункт</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div>
                                    <div class="text-center">
                                        @foreach($districts as $district=>$cities)
                                        <div class="mb-4">
                                            <div class="fw-bold">{{$district}}</div>
                                            @foreach($cities as $city)
                                            <div><a href="{{route('ajax.set_city', $city)}}">{{$city->name}}</a></div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</body>

</html>