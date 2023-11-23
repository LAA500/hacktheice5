@extends('layouts.simple')

@section('title', 'Регистрация')

@section('content')
<section class="Register">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
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
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" novalidate>
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="form-floating">
                                        <input id="name" type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" required autocomplete="name"
                                            placeholder="Ваше имя">
                                        <label for="name">Ваше имя</label>
                                    </div>

                                    @error('name')
                                    <span class="form-control-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-floating">
                                        <input id="email" type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email">
                                        <label for="email">{{ __('Email') }}</label>
                                    </div>

                                    @error('email')
                                    <span class="form-control-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-floating">
                                        <input id="phone" type="tel" class="form-control" name="phone"
                                            value="{{ old('phone') }}" required autocomplete="tel"
                                            placeholder="Номер телефона">
                                        <label for="phone">Номер телефона</label>
                                    </div>

                                    @error('phone')
                                    <span class="form-control-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-floating">
                                        <input id="password" type="password" class="form-control" name="password"
                                            required autocomplete="new-password" placeholder="Пароль">
                                        <label for="password">Пароль</label>
                                    </div>
                                    @error('password')
                                    <span class="form-control-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg w-100 loader text-white">Зарегистрироваться</button>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="accept" value="1"
                                            id="accept" checked>
                                        <label class="form-check-label lh-1 small text-justify" for="accept">Я соглашаюсь с Пользовательским
                                            соглашением и Политикой обработки персональных данных</label>
                                    </div>
                                    @error('accept')
                                    <span class="form-control-invalid small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </form>
                            <div class="text-center">
                                <a href="/auth/login">У меня есть аккаунт</a>
                            </div>
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