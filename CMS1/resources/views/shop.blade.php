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
<div class="header navbar-dark bg-default pb-5 pt-3 pt-md-5">
    <div class="container-fluid">
    </div>
</div>

<!-- Modal Detalle product-->
<div class="modal fade" id="modalproducto" tabindex="-1" role="dialog" aria-labelledby="modalproducto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="nombre_producto" class="text-center"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <img id="imagen" style="text-align: center;" width="150px" height="150px">
                    </div>
                    <div class="col">
                        <p class="h3" id="codigo"></p>
                        <p class="h3" id="details"></p>
                        <p class="h3" id="description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    @can('products.index')
                    <li>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge badge-pill badge-default">
                                <i class="fas fa-bell" ></i> <span style="color: red; font-weight: bold;">{{ $count }}</span>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 430px; padding: 0px; border-color: #9DA0A2">
                                <ul class="list-group" style="margin: 10px;">
                                    @include('partials.alerta')
                                </ul>
                            </div>
                        </a>
                    </li>
                    @endcan
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    @foreach($categorias as $categoria)
                    <li class="breadcrumb-item"><a href="{{ route('producto.categoria', ['id' => $categoria->id]) }}">{{ $categoria->nombre }}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center my-4">
        <div class="col-lg-12">
            <div class="row">
                @foreach($products as $pro)
                <div class="col-lg-3">
                    <div class="card" style="margin-bottom: 20px; height: auto;">
                        <!-- <a href=""></a> -->
                        <img src="{{ route('producto.image',['filename' => $pro->image_path]) }}" class="card-img-top mx-auto my-2" style="height: 150px; width: 150px;display: block;" alt="{{ $pro->image_path }}">
                        <div class="card-body">
                            <a href="javascript:void(0)" id="{{ $pro->id }}" onclick="detalle_producto('{{ $pro->id }}');">
                                <h4 class="card-title">{{ $pro->name }}</h4>
                            </a>
                            <p>
                                <span class="badge badge-success"> {{ $pro->estado }}
                            </p>
                            <span>{{ $pro->categoria->nombre }}</span>
                            <p> <strong>${{ $pro->price }}</strong> </p>
                            <form action="{{ route('cart.store') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $pro->id }}" id="id" name="id">
                                <input type="hidden" value="{{ $pro->name }}" id="name" name="name">
                                <input type="hidden" value="{{ $pro->price }}" id="price" name="price">
                                <input type="hidden" value="{{ $pro->image_path }}" id="img" name="img">
                                <input type="hidden" value="{{ $pro->slug }}" id="slug" name="slug">
                                <input type="hidden" value="1" id="quantity" name="quantity">
                                <div class="card-footer" style="background-color: white;">
                                    <div class="row">
                                        <button class="btn btn-default btn-sm" class="tooltip-test" title="Añadir al carrito">
                                            <i class="fa fa-shopping-cart"></i> Añadir al carrito
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                {{$products->links()}}
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script type="text/javascript">
    function detalle_producto(id) {

        $.get('producto/detalle/' + id, function(producto) {

            var ruta = 'http://localhost/CMS/public/producto/image/' + producto.image_path;
            $("#imagen").attr("src", ruta);
            $("#nombre_producto").html(producto.name);
            $("#codigo").html(producto.slug);
            $("#details").html(producto.details);
            $("#description").html(producto.description);

            //asignar a una ventana modal
            $('#modalproducto').modal('toggle');
        });
    }
</script>
@endsection