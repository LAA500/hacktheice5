@extends('layouts.admin')

@section('content')
<div>
    <div class="col-md-4">
        <form action="{{route('admin.users.store')}}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <div class="form-floating">
                    <input type="text" id="username" name="name" class="form-control" autocomplete="off" placeholder="Имя Фамилия">
                    <label for="name">Имя Фамилия</label>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="form-floating">
                    <input type="email" id="email" name="email" class="form-control" autocomplete="off" placeholder="Имя Фамилия">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="form-floating">
                    <input type="text" id="phone" name="phone" class="form-control" autocomplete="off" placeholder="Имя Фамилия">
                    <label for="phone">Номер телефона</label>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="form-floating">
                    <select name="city_id" id="city_id" class="form-select" autocomplete="off">
                        @foreach($cities as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <label for="city_id">Населенный пункт</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection