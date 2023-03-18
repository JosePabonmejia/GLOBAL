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
            <div class="row">
                <div class="col-lg-6 col-7">
                    <button type="button" class="btn btn-neutral btn-sm" data-toggle="modal" data-target="#modalcategoria">
                        Crear Categoria
                    </button>
                </div>
            </div>
            @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>


<!-- Modal para crear categoria-->
<div class="modal fade" id="modalcategoria" tabindex="-1" role="dialog" aria-labelledby="modalcategoria" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalcategoria">Crear Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <form action="{{ route('categoria.save') }}" method="POST">
                            @csrf
                            <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                <h4>Nombre <span style="color: red;">*</span></h4>
                                <div class="input-group input-group-alternative mb-3">
                                    <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="nombre*" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus>
                                </div>
                                @if ($errors->has('nombre'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para editar categoria -->
<div class="modal fade" id="modaleditcat" tabindex="-1" role="dialog" aria-labelledby="modaleditcat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaleditcat">Editar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <form id="edit_categoria" action="{{ route('categoria.update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="categoria_id" name="categoria_id">
                            <div class="form-group{{ $errors->has('nombre_categoria') ? ' has-danger' : '' }}">
                                <h4>Nombre <span style="color: red;">*</span></h4>
                                <div class="input-group input-group-alternative mb-3">
                                    <input class="form-control{{ $errors->has('nombre_categoria') ? ' is-invalid' : '' }}" placeholder="nombre*" type="text" id="nombre_categoria" name="nombre_categoria" value="{{ old('nombre_categoria') }}" required autofocus>
                                </div>
                                @if ($errors->has('nombre_categoria'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('nombre_categoria') }}</strong>
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


<div class="header pb-6 pt-1 pt-md-6">
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Lista de Categorias</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table align-items-center" id="tblcategoria">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td>{{ $categoria->nombre }}</td>
                                    @if($categoria->estado == 'activa')
                                    <td><span class="badge badge-pill badge-success">{{ $categoria->estado }}</span></td>
                                    @elseif($categoria->estado == 'inactiva')
                                    <td><span class="badge badge-pill badge-danger"> {{ $categoria->estado }} </span> </td>
                                    @endif
                                    <td>
                                        <a type="button" class="editar btn btn-sm btn-primary" id="{{ $categoria->id }}" href="javascript:void(0)" onclick="editar_cat('{{ $categoria->id }}');" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="estado btn btn-sm btn-default" id="{{ $categoria->id }}" data-toggle="tooltip" data-placement="bottom" title="Cambiar Estado"><i class="fas fa-sync-alt"></i></button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" id="{{ $categoria->id }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar Categoria"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
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


<!-- Cambiar estado -->
<script>
    var id;
    $(".estado").on("click", function() {
        //parents devuelve toda la data de la fila seleccionada
        id = $(this).attr('id');
        swal({
            title: 'Estas Seguro?',
            text: "Ya no puedes revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    url: "categoria/change_status/" + id,
                    success: function(resultado) {
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Categoria Actualizada Correctamente',
                            showConfirmButton: false,
                            timer: 1000000
                        })
                        location.reload();
                    }
                })
            }
        })
    });
</script>

<!-- Cargar al formulario para editar -->
<script>
    function editar_cat(id) {
        $.get('categoria/editar/' + id, function(categoria) {

            $("#categoria_id").val(categoria.id);
            $("#nombre_categoria").val(categoria.nombre);
            //asignar a una ventana modal
            $('#modaleditcat').modal('toggle');
        });
    }
</script>



<!-- Enviar para eliminar -->
<script>
    var id;
    $(".eliminar").on("click", function() {
        //parents devuelve toda la data de la fila seleccionada
        id = $(this).attr('id');
        swal({
            title: 'Estas Seguro?',
            text: "Ya no puedes revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    url: "categoria/delete/" + id,
                    success: function(resultado) {
                        if(resultado != 'error'){
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Eliminada Correctamente',
                                showConfirmButton: false,
                                timer: 1000000
                            })
                        }else{
                            Swal.fire({
                                position: 'center',
                                type: 'warning',
                                title: 'Error al eliminar',
                                showConfirmButton: false,
                                timer: 1000000
                            })
                        }
                        location.reload();
                    }
                })
            }
        })
    });
</script>
@endsection