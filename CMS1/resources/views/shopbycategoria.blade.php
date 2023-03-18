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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-8">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{route('shop')}}"><i class="fas fa-home"></i></a></li>
                    @foreach($categorias as $categoria)
                        <li class="breadcrumb-item"><a href="{{ route('producto.categoria', ['id' => $categoria->id]) }}">{{ $categoria->nombre }}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
    <h2>{{ $category->nombre }}</h2>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="row">
                @foreach($products as $pro)
                <div class="col-lg-3">
                    <div class="card" style="margin-bottom: 20px; height: auto;">
                        <!-- <img src="{{ asset('images') }}/{{ $pro->image_path }}" class="card-img-top mx-auto" style="height: 150px; width: 150px;display: block;" alt="{{ $pro->image_path }}"> -->
                        <img src="{{ route('producto.image',['filename' => $pro->image_path]) }}" class="card-img-top mx-auto my-2" style="height: 150px; width: 150px;display: block;" alt="{{ $pro->image_path }}">
                        <div class="card-body">
                            <a href="">
                                <h4 class="card-title">{{ $pro->name }}</h4>
                            </a>
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
        </div>
    </div>
</div>
@endsection