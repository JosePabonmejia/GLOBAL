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
<!-- Cabecera -->
<div class="header navbar-dark bg-default pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
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

<div class="container-fluid mt--7">
    <div class="header-body">
        <form action="{{ route('producto.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Datos del producto -->
            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card bg-gradient-secondary shadow">
                            <div class="card-header">
                                <h3>Datos del Producto</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <h5>Nombre<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nombre del producto" type="text" name="name" value="{{ old('name', $producto->name) }}" required autofocus maxlength="150">
                                            </div>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('slug') ? ' has-danger' : '' }}">
                                            <h5>Slug<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="Slug *" type="text" name="slug" value="{{ old('slug', $producto->slug) }}" required autofocus maxlength="150">
                                            </div>
                                            @if ($errors->has('slug'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('slug') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('details') ? ' has-danger' : '' }}">
                                            <h5>Detalle<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">

                                                <input class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" placeholder="Detalle *" type="text" name="details" value="{{ old('details', $producto->details) }}" minlength="1" maxlength="10" required autofocus>
                                            </div>
                                            @if ($errors->has('details'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('details') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('category_id ') ? ' has-danger' : '' }}">
                                            <h5>Categoria<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <select class="form-control{{ $errors->has('category_id ') ? ' is-invalid' : '' }}" name="category_id" required autofocus>
                                                    @foreach($categorias as $data)
                                                    <option value="{{ $data->id }}">{{$data->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category_id '))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('category_id ') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <h5>Precio<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="Costo *" type="text" name="price" value="{{ old('price', $producto->price) }}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" minlength="1" maxlength="3" required autofocus>
                                            </div>
                                            @if ($errors->has('price'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('shipping_cost') ? ' has-danger' : '' }}">
                                            <h5>Costo de envío<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('shipping_cost') ? ' is-invalid' : '' }}" placeholder="Costo de envío *" type="text" name="shipping_cost" value="{{ old('shipping_cost', $producto->shipping_cost) }}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" minlength="1" maxlength="3" required autofocus>
                                            </div>
                                            @if ($errors->has('shipping_cost'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('shipping_cost') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <h5>Descripción<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Descripción *" type="text" name="description" value="{{ old('description', $producto->description) }}" required autofocus>
                                            </div>
                                            @if ($errors->has('description'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('image_path') ? ' has-danger' : '' }}">
                                            <h5>Imagen<span style="color: red;">*</span></h5>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('image_path') ? ' is-invalid' : '' }}" placeholder="Descripción *" type="file" name="image_path" value="{{ old('image_path') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('image_path'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('image_path') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('products.index') }}" class="btn btn-dark mt-4">{{ __('Cancelar') }}</a>
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Confirmar') }}</button>
                                    </div>
                                </div>

                            </div>
                            <div class="text-muted font-italic">
                                <small>{{ __('Campos Requeridos') }}: <span class="text-danger font-weight-700">*</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection