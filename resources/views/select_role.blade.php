@extends('layouts.simple')

@section('title', 'Выберите роль')

@section('content')
<div class="container">
    <div class="text-center">
        <div>
            <div class="mb-4">
                <div class="fs-4">Для продолжения работы с сайтом, выберите роль</div>
            </div>
            <div class="my-4">
                @foreach($user->roles as $role)
                <div class="col-md-3 mb-3 mx-auto">
                    <a class="btn btn-primary w-100" href="{{route('select_role.set', $role->name)}}">{{$role->label}}</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection