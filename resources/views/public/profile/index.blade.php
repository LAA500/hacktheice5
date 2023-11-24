@extends('layouts.app')

@section('title', 'Профиль')

@push('meta')
<meta name="theme-color" content="#fff" />
@endpush

@section('header')

@endsection

@section('content')
<section class="Profile">
    <div class="container">
        <div class="Profile-top mb-4">
            <div class="text-center">
                <div class="Profile-avatar">
                    <img src="/assets/images/avatar.jpg" alt="">
                </div>
                <div class="Profile-data">
                    <div class="Profile-name">
                        <div>{{$user->name}}</div>
                    </div>
                    <div class="Profile-city">
                        <div>{{$user->city->name}}</div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row justify-content-around">
                        <div class="col-4">
                            <div class="Profile-menu-block">
                                <a href="/profile/orders">
                                    <div class="Profile-menu-block-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#fff"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="Profile-menu-block">
                                <a href="/cart">
                                    <div class="Profile-menu-block-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#fff"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="Profile-menu-block">
                                <a href="/profile/favorites">
                                    <div class="Profile-menu-block-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#fff"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="Profile-menu mb-4">
            <div>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center bb-line">
                        <div class="ms-2"><a href="/delivery">Доставка и оплата</a></div>
                        <div class="_icon">
                            <svg width="30" height="30">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                        </div>
                    </li>
                    <li class="d-flex align-items-center bb-line">
                        <div class="ms-2"><a href="/documents">Документы</a></div>
                        <div class="_icon">
                            <svg width="30" height="30">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                        </div>
                    </li>
                    <li class="d-flex align-items-center bb-line">
                        <div class="ms-2"><a href="/addresses">Мои адреса</a></div>
                        <div class="_icon">
                            <svg width="30" height="30">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div>
            <div>
                <div>
                    <a href="{{route('logout')}}" class="text-danger">Выйти из профиля</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection