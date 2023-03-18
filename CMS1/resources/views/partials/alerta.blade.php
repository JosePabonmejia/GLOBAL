@if($count > 0)
    @foreach($pedidos as $item)
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-6">
                <h3>{{$item->user->name}}</h3>
                <span>{{$item->fecha}}</span>
                <small style="color: red; font-weight: bold;">{{$item->estado}}</small>
                <p>Bs. {{ number_format($item->costo_total,2) }}</p>
            </div>
            
            <hr>
        </div>
    </li>
    @endforeach
@else
<li class="list-group-item">Sin nuevos pedidos</li>
@endif