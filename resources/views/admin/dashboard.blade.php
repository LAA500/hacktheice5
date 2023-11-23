@extends('layouts.admin')

@section('content')
<div>
    <div>
        <div>
            <div>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-secondary text-uppercase mb-1">Товаров</div>
                                        <div class="h1 mb-0 fw-bold text-gray-800">{{$products_count}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-secondary text-uppercase mb-1">Заказов</div>
                                        <div class="h1 mb-0 fw-bold text-gray-800">{{$orders_count}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-secondary text-uppercase mb-1">Пользователей</div>
                                        <div class="h1 mb-0 fw-bold text-gray-800">{{$users_count}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection