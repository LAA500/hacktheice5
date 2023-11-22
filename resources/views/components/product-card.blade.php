@props(['product'])
<div {{ $attributes }}>
    <div class="Product-card">
        <div>
            <div>{{$product->name}}</div>
        </div>
        <div>
            <button type="button" class="btn btn-primary">В корзину</button>
        </div>
    </div>
</div>