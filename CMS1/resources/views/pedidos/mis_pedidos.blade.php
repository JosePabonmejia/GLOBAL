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
        </div>
    </div>
</div>

<div class="header pb-6 pt-1 pt-md-6">
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Lista de Mis Pedidos</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table align-items-center" id="tblcategoria">
                            <thead>
                                <tr>
                                    <th><strong>Nro. Pedido</strong> </th>
                                    <th><strong>Costo Total</strong> </th>
                                    <th><strong>Fecha</strong> </th>
                                    <th><strong>Estado</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->pedidos as $item)
                                <tr>
                                    <td><a href="{{ route('pedido.detalle', ['id' => $item->id]) }}">{{ $item->id }}</a> </td>
                                    <td>$ {{ $item->costo_total }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->fecha))}}</td>
                                    @if($item->estado == 'pendiente')
                                    <td> <span class="badge badge-pill badge-danger"> {{ $item->estado }}</span></td>

                                    @elseif($item->estado == 'preparando')
                                    <td> <span class="badge  badge-pill badge-warning"> {{ $item->estado }}</span></td>

                                    @elseif($item->estado == 'enviando')
                                    <td> <span class="badge badge-pill badge-success"> {{ $item->estado }}</span></td>

                                    @elseif($item->estado == 'entregado')
                                    <td> <span class="badge badge-pill badge-success"> {{ $item->estado }}</span></td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    var tblcategoria;
    $(document).ready(function() {
        tblcategoria = $('#tblcategoria').DataTable({
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