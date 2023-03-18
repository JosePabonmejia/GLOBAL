@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('nota/style.css') }}">
<style>
    .card {
        box-shadow: 0 6px 8px 0 rgba(0, 0, 0, 0.4);
        transition: 0.4s;
        border-radius: 8px;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@section('content')
<div class="header navbar-dark bg-default pb-7 pt-5 pt-md-7">
    <div class="container-fluid">
        <div class="header-body">
            @if(session()->has('confirmado'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('confirmado') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="header pb-6 pt-1 pt-md-6">
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div id="page_pdf">
                        <table id="factura_head">
                            <tr>
                                <td class="logo_factura">
                                    <div>
                                        <img src="{{ asset('nota/img/logo.png')}}">
                                    </div>
                                </td>
                                <td class="info_empresa">
                                    <div>
                                        <h1>E-commerce</h1>
                                        <p>Avenida Alto San Pedro 3er anillo (interno)</p>
                                        <p>Teléfono: +(591) 65949863</p>
                                        <p>Email: sergiofernandorodriguez@gmail.com</p>
                                    </div>
                                </td>
                                <td class="info_factura" style="text-align: center;">
                                    <div class="round">
                                        <span class="h3">Nota Pedido</span>
                                        <h2>No. Nota: <strong>0000{{ $pedido->id }}</strong></h2>
                                        <h4>Fecha: {{ date('d/m/Y', strtotime($pedido->fecha)) }}</h4>
                                        <h4>Provincia: {{ $pedido->provincia }}</h4>
                                        <h4>Localidad: {{ $pedido->localidad }}</h4>
                                        <h4>Dirección: {{ $pedido->direccion }}</h4>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table id="factura_cliente">
                            <tr>
                                <td class="info_cliente">
                                    <div class="round">
                                        <span class="h3">Cliente</span>
                                        <table class="datos_cliente">
                                            <tr>
                                                <td><label>Ci/Nit:</label>
                                                    <p>{{ $pedido->user->ci }}</p>
                                                </td>
                                                <td><label>Nombre:</label>
                                                    <p>{{ $pedido->user->name }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label>Teléfono:</label>
                                                    <p>{{ $pedido->user->telefono }}</p>
                                                </td>
                                                <td><label>Correo:</label>
                                                    <p>{{ $pedido->user->email }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <div class="table-responsive">
                                    <div class="round">
                                        <table id="customers">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pedido->productos as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="text-center">{{ $item->pivot->cantidad }}</td>
                                                    <td class="text-center">$. {{ $item->pivot->costo_unitario }}</td>
                                                    <td class="text-center">$. {{ $item->pivot->subtotal }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot id="detalle_totales">
                                                <tr>
                                                    <td colspan="3" class="textright"><span>TOTAL A.</span></td>
                                                    <td class="text-center"><span>$ {{$pedido->costo_total}} </span></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="label_gracias">¡Gracias por su preferencia!</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection