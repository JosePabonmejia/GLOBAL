@extends('layouts.app')

@section('content')
<div class="header navbar-dark bg-default pb-5 pt-3 pt-md-5">
    <div class="container-fluid">
    </div>
</div>
<div class="container"> <br>
    @if(session('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('failed') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif

    @if(session()->has('success_msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('success_msg') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    @if(session()->has('alert_msg'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session()->get('alert_msg') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    @if(count($errors) > 0)
    @foreach($errors0>all() as $error)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endforeach
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <br>
            @if(\Cart::getTotalQuantity()>0)
            <h4>{{ \Cart::getTotalQuantity()}} Productos en tu carrito</h4><br>
            @else
            <h4>Carrito vacío</h4><br>
            <a href="{{ route('shop') }}" class="btn btn-dark">Continuar comprando</a>
            @endif

            @foreach($cartCollection as $item)
            <div class="row">
                <div class="col-lg-3">
                    <img src="{{ route('producto.image', ['filename' => $item->attributes->image ]) }}" alt="Imagen del producto" class="img-thumbnail" width="200" height="200">
                    <!-- <img src=" {{asset('images')}}/{{ $item->attributes->image }}" class="img-thumbnail" width="200" height="200"> -->
                </div>
                <div class="col-lg-5">
                    <p>
                        <b><a href="/shop/{{ $item->attributes->slug }}">{{ $item->name }}</a></b><br>
                        <b>Precio: </b>${{ $item->price }}<br>
                        <b>Sub Total: </b>${{ \Cart::get($item->id)->getPriceSum() }}<br>
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <form action="{{ route('cart.update') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <input type="hidden" value="{{ $item->id}}" id="id" name="id">
                                <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}" id="quantity" name="quantity" style="width: 70px; margin-right: 10px;">
                                <button class="btn btn-secondary btn-sm" style="margin-right: 25px;"><i class="fa fa-edit"></i></button>
                            </div>
                        </form>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                            <button class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            @endforeach
            @if(count($cartCollection)>0)
            <form action="{{ route('cart.clear') }}" method="POST">
                {{ csrf_field() }}
                <button class="btn btn-secondary btn-md">Vaciar carrito</button>
            </form>
            @endif
        </div>
        @if(count($cartCollection)>0)
        <div class="col-lg-5">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>
                </ul>
            </div>
            <br><a href="{{ route('shop') }}" class="btn btn-dark">Continuar comprando</a>
            <!-- <a href="{{ route('cart.cheackout') }}" class="btn btn-success">Procesar pago</a> -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                Continuar
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Datos del pedido</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('cart.cheackout') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('provincia') ? ' has-danger' : '' }}">
                                            <h4>Provincia <span style="color: red;">*</span></h4>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('provincia') ? ' is-invalid' : '' }}" placeholder="provincia*" type="text" name="provincia" value="{{ old('provincia') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('provincia'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('provincia') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('localidad') ? ' has-danger' : '' }}">
                                            <h4>Localidad <span style="color: red;">*</span></h4>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('localidad') ? ' is-invalid' : '' }}" placeholder="localidad*" type="text" name="localidad" value="{{ old('localidad') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('localidad'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('localidad') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }}">
                                            <h4>Dirección <span style="color: red;">*</span></h4>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" placeholder="direccion*" type="text" name="direccion" value="{{ old('direccion') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('direccion'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('direccion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('fecha') ? ' has-danger' : '' }}">
                                            <h4>Fecha <span style="color: red;">*</span></h4>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('fecha') ? ' is-invalid' : '' }}" placeholder="fecha*" type="datetime-local" name="fecha" value="{{  old('fecha') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('fecha'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('fecha') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Realizar Pedido</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
   
    <br><br>
</div>
@endsection