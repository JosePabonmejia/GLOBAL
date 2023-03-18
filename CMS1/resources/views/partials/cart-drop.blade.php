@if(count(\Cart::getContent()) > 0)
@foreach(\Cart::getContent() as $item)
<li class="list-group-item">
    <div class="row">
        <div class="col-lg-3">
            <!-- <img src="{{ asset('images') }}/{{ $item->attributes->image }}" style="width: 50px; height: 50px;"> -->
            <img src="{{ route('producto.image', ['filename' => $item->attributes->image ]) }}" alt="Imagen del producto"  width="50" height="50">
        </div>
        <div class="col-lg-6">
            <b>{{$item->name}}</b>
            <br><small>Cant.: {{$item->quantity}}</small>
        </div>
        <div class="col-lg-3">
            <p>${{ \Cart::get($item->id)->getPriceSum() }}</p>
        </div>
        <hr>
    </div>
</li>
@endforeach
<br>
<li class="list-group-item">
    <div class="row">
        <div class="col-lg-8">
        <b>Total: </b>${{ \Cart::getTotal() }}
        </div>
    </div>
</li>
<div class="row" style="margin: 0px;">
    <a class="btn btn-dark btn-sm btn-block" href="{{ route('cart.index') }}">
        CheackOut <i class="fa fa-arrow-right"></i>
    </a>
</div>
@else
<li class="list-group-item">Tu carrito esta vacío</li>
@endif