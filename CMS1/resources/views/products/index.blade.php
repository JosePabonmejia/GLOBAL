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
                    <a class="btn btn-neutral btn-sm" href="{{ route('products.create') }}">
                        Crear Producto
                    </a>
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
            @if(session()->has('message_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('message_error') }}
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
                        <h3 class="mb-0">Lista de Productos</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table align-items-center" id="tblproducts">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->categoria->nombre }}</td>
                                    <td>$. {{ $product->price }}</td>
                                    @if($product->estado == 'disponible')
                                    <td><span class="badge badge-pill badge-success"> {{ $product->estado }}</span></td>
                                    @elseif($product->estado == 'inactivo')
                                    <td><span class="badge badge-pill badge-danger"> {{ $product->estado }}</span></td>
                                    @endif
                                    <td>
                                        <a class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar" href="{{ route('producto.edit', ['id' => $product->id]) }}"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="estado btn btn-sm btn-danger" id="{{ $product->id }}" data-toggle="tooltip" data-placement="bottom" title="Cambiar esado"><i class="fas fa-sync-alt"></i></button>
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
    var tblproducts;
    $(document).ready(function() {
        tblproducts = $('#tblproducts').DataTable({
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
                    url: "producto/change_status/" + id,
                    success: function(resultado) {
                        if(resultado != 'error'){
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Producto Actualizado',
                                showConfirmButton: false,
                                timer: 18000
                            })
                        }else{
                            Swal.fire({
                                position: 'center',
                                type: 'warning',
                                title: 'Error al actualizar estado',
                                showConfirmButton: false,
                                timer: 18000
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