@extends('layouts.simple')

@section('title', 'Вход')

@section('content')
<section class="Login">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <div class="mb-4">
                                <a href="/">
                                    <div class="Logo" style="background-image: url(/assets/images/logo.png?v=001);">
                                    </div>
                                </a>
                            </div>
                            <div class="fs-4 fw-bold">Добро пожаловать!</div>
                        </div>
                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf
                            <div class="form-group mb-3">
                                <div class="form-floating">
                                    <input id="email" type="email" class="form-control form-control-lg" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                                @error('email')
                                <span class="form-control-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-floating">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="current-password" placeholder="Пароль">
                                    <label for="password">Пароль</label>
                                </div>

                                <div>
                                    @error('password')
                                    <span class="form-control-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit"
                                    class="btn btn-lg btn-primary w-100 loader text-white">Войти</button>
                                <div class="text-center">
                                    <div class="mt-3">
                                        @if (Route::has('password.request'))
                                        <a class="btn fw-bold" href="{{ route('password.request') }}">Забыли
                                            пароль?</a>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if (Route::has('register'))
                                        <a class="btn fw-bold" href="{{ route('register') }}">Регистрация</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="module">
    document.querySelector("form").addEventListener("submit", function (e) {
        let button = document.querySelector('.loader');
        button.setAttribute('disabled', 'disabled');
        button.className += ' btn-loading';
    });
</script>
@endpush