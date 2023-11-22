@extends('layouts.simple')

@section('title', 'Восстановление пароля')

@section('content')
<section class="Register">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="card border-0">
                    <div class="card-body">
                        @if (session('status'))
                        <div class="mb-3 alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <div class="mb-3 text-center">
                            <div class="mb-4">
                                <a href="/">
                                    <div class="Logo" style="background-image: url(/assets/images/logo.png?v=001);">
                                    </div>
                                </a>
                            </div>
                            <div class="fs-4 fw-bold">Восстановление пароля</div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
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

                                <div class="form-group mb-0">
                                    <button type="submit"
                                        class="btn btn-lg btn-primary w-100 text-white">Отправить</button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <a href="/auth/login" class="fw-bold">Назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection