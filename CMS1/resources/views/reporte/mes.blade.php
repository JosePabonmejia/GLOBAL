@extends('layouts.app')

@section('css')
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
            @if(session()->has('correct'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('correct') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            @if(session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('failed') }}
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
                    <div class="card-header border-0">
                        <h2 class="mb-0 text-center">Lista de Pedidos Mes</h2>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table align-items-center" id="tblpedidos">
                            <thead>
                                <tr>
                                    <th><strong>Nro. Pedido</strong> </th>
                                    <th><strong>Cliente</strong> </th>
                                    <th><strong>Fecha</strong> </th>
                                    <th><strong>Costo Total</strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $item)
                                <tr>
                                    <td><a href="{{ route('pedido.detalle', ['id' => $item->id]) }}">{{ $item->id }}</a> </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->fecha))}}</td>
                                    <td>$. {{ number_format($item->costo_total,2)  }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><h3>Total</h3></td>
                                    <td><h3>$. {{ number_format($total,2)  }}</h3></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script type="text/javascript">
    var tblpedidos;
    $(document).ready(function() {
        tblpedidos = $('#tblpedidos').DataTable({
            paging: true,
            filter: true,
            info: false,
            autoWidth: false,
            responsive: true,
            destroy: true,
            ordering: false,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": ">",
                    "previous": "<"
                }
            }
        });
    });
</script>

@endsection
@endsection