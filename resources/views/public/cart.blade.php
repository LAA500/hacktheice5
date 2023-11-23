@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
<section class="Cart">
    <div class="container">
        <div class="SectionHeader">
            <h2 class="SectionTitle">Корзина</h2>
        </div>
        <div class="SectionContent">
            <cart></cart>
        </div>
    </div>
</section>
@endsection