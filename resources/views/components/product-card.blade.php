@props(['product'])
<div {{ $attributes }}>
    <div class="Product-card">
        <div class="Product-card-img">
            <img src="{{$product->image}}" alt="{{$product->name}}">
        </div>
        <div class="Product-card-content">
            <div>
                <div>{{$product->name}}</div>
            </div>
            <div>
                <div class="fw-bold">{{price(rand(100, 1999))}}</div>
            </div>
            <div>
                <div class="small {{$product->in_stock ? 'text-success' : 'text-danger'}}">{{$product->in_stock ? 'В наличии' : 'Нет в наличии' }}</div>
            </div>
            <div class="mt-2">
                <addtocart class="btn btn-sm btn-primary w-100 text-white" uuid="{{$product->uuid}}" @disabled(!$product->in_stock)>Купить</addtocart>
            </div>
        </div>
    </div>
</div>