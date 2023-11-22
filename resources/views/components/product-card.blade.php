@props(['product'])
<div {{ $attributes }}>
    <div class="Product-card">
        <div>
            <div>{{$product->name}}</div>
        </div>
        <div>
            <div>{{$product->description}}</div>
        </div>
        <div>
            <div class="fw-bold">{{price(rand(100, 1999))}}</div>
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-sm btn-primary">В корзину</button>
        </div>
    </div>
</div>