<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    @vite(['resources/sass/admin.scss', 'resources/js/admin.js'])
    @yield('meta')
</head>

<body>
    <div id="app">
        <header>
            <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="light">
                <div class="container">
                    <a class="navbar-brand fw-bold text-white" href="/admin/dashboard">СЕВЕРНОЕ СИЯНИЕ</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.products.index')}}">Товары</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.categories.index')}}">Категории</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.orders.index')}}">Заказы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.supplies.index')}}">Поставки</a>
                            </li>
                            @if(session('role.name') == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.users.index')}}">Пользователи</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="text-white">
                        <div>{{auth()->user()->name}}</div>
                        <div class="text-end"><a class="small text-decoration-underline" href="{{route('select_role')}}">{{session('role.label')}}</a></div>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="container my-4">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>