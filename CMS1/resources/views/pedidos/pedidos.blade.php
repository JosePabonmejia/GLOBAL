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
                        <h3 class="mb-0">Lista de Pedidos</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table align-items-center" id="tblpedidos">
                            <thead>
                                <tr>
                                    <th><strong>Nro. Pedido</strong> </th>
                                    <th><strong>Cliente</strong> </th>
                                    <th><strong>Costo Total</strong> </th>
                                    <th><strong>Fecha Envío</strong> </th>
                                    <th><strong>Estado</strong></th>
                                    <th><strong>Opciones</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $item)
                                <tr>
                                    <td><a href="{{ route('pedido.detalle', ['id' => $item->id]) }}">{{ $item->id }}</a> </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>$. {{ $item->costo_total }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->fecha))}}</td>
                                    @if($item->estado == 'pendiente')
                                    <td> <span class="badge badge-pill badge-danger"> {{ $item->estado }}</span></td>

                                    @elseif($item->estado == 'preparando')
                                    <td> <span class="badge badge-pill badge-warning"> {{ $item->estado }}</span></td>

                                    @elseif($item->estado == 'enviado')
                                    <td> <span class="badge badge-pill badge-success"> {{ $item->estado }}</span></td>

                                    @elseif($item->estado == 'entregado')
                                    <td> <span class="badge badge-pill badge-success"> {{ $item->estado }}</span></td>
                                    @endif
                                    <td>
                                        <button type="button" class="boton_actualizar btn btn-primary btn-sm" value="{{ $item->id }}" data-toggle="modal" data-target="#modalopedido">
                                            Actualizar
                                        </button>
                                    </td>
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

<!-- Modal de actualizar pedido -->
<div class="modal fade" id="modalopedido" tabindex="-1" role="dialog" aria-labelledby="modalopedido" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3  class="modal-title" id="modalopedido">Actualizar estado pedido</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <form action="{{ route('pedido.update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="pedido_id" name="pedido_id">
                            <div class="form-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <select class="form-control{{ $errors->has('sexo') ? ' is-invalid' : '' }}" name="estado" required autofocus>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="preparando">Preparando</option>
                                        <option value="enviado">Enviado</option>
                                        <option value="entregado">Entregado</option>
                                    </select>
                                </div>
                                @if ($errors->has('estado'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('estado') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
            </form>
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


<script type="text/javascript">
    $('.boton_actualizar').on('click', function(e) {
        e.preventDefault();
        var pedido_id = $(this).val();
        document.getElementById('pedido_id').value = pedido_id;
    });

    function submit() {
        var parameters = new FormData();
        parameters.append('pedido_id', $('input[name="pedido_id"]').val());
        parameters.append('estado', $('select[name="estado"]').val());
        $.ajax({
            url: "{{ route('pedido.update') }}",
            type: 'POST',
            data: parameters,
            dataType: 'json',
            processData: false,
            contentType: false,
        }).done(function(data) {
            swal({
                title: 'Pedido actualizado correctamente',
                position: 'center',
                type: 'success',
                showConfirmButton: false,
                timer: 2500
            });
            location.reload();
        }).fail(function() {
            swal({
                title: 'Error, al procesar la ejecucion',
                position: 'center',
                type: 'warning',
                showConfirmButton: false,
                timer: 2500
            });
        })
    }
</script>
@endsection
@endsection