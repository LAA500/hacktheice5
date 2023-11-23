@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<section class="Checkout">
    <div class="container">
        <div class="SectionHeader">
            <h2 class="SectionTitle">Оформление заказа</h2>
        </div>
        <div class="SectionContent">
            <div class="row">
                <div class="col-md-4">
                    <checkout></checkout>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection