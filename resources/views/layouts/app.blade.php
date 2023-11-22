<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <header class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <button type="button" class="menu-button" data-bs-toggle="offcanvas" data-bs-target="#menu"
                                aria-controls="menu">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#333"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <a class="navbar-brand" href="/">
                                <div class="Logo" style="background-image: url(/assets/images/logo.png?v=001);">
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="/profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#000"
                                    viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="footer">
            <div class="container">
                <div class="copyright">
                    <div>&copy; проект команды «Fairy Tail» {{date('Y')}}</div>
                    <div>специально для <a href="https://ityakutia.com/hacktheice5" target="_blank"
                            rel="noopener noreferrer">HACK-the-ICE 5.0 «OldSchool»</a></div>
                </div>
            </div>
        </footer>
        <aside>
            <div class="modal fade" id="city" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-hidden="true">
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
                                            <div><a href="{{route('set_city', $city)}}">{{$city->name}}</a></div>
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
            @include('layouts.menu')
        </aside>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="arrow-right-circle" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
            </symbol>
        </svg>
    </div>
</body>

</html>