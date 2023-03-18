@extends('layouts.app')

@section('css')
<style>
    .card {
  box-shadow: 0 6px 8px 0 rgba(0,0,0,0.4);
  transition: 0.4s;
  border-radius: 8px;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
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
                        <h3 class="mb-0">Lista de Usuarios</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table align-items-center table table-striped" id="tblusers">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Ci/Nit</th>
                                    <th>Email</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->ci }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar"  href="{{ route('admin.users.edit', $user) }}"><i class="fas fa-edit"></i></a>
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
@endsection
@section('js')
<!-- Datatable -->
<script type="text/javascript">
    var tblusers;
    $(document).ready(function() {
        tblusers = $('#tblusers').DataTable({
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
                    url: "user/change_estado/" + id,
                    success: function(resultado) {
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Estado actualizado correctamente',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        location.reload();
                    }
                })
            }
        })
    });
</script>

@endsection