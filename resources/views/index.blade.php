@extends('layouts.app')

@section('title', 'Главная')

@section('content')
@foreach(App\Models\City::all()->groupBy('district')->all() as $city)
{{$city}}
@endforeach
@endsection