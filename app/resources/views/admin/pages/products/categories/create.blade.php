@extends('adminlte::page')

@section('title', "Vincular categorias ao producto {$product->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.categories', $product->id) }}">Categorias</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.categories.create', $product->id) }}">Novo</a></li>
    </ol>
    <h1>Vincular Categorias ao Produto {{ $product->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('products.categories.create', $product->id) }}" method="post">
                @csrf
                <div class="input-group input-group-sm">
                    <input type="text" name="filter" id="filter" placeholder="Nome" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-dark btn-flat"><i class="fas fa-search fa-fw"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <div class="card-body">
            @include('admin.includes.alerts')
            <form id="frmMain" action="{{ route('products.categories.attach', $product->id) }}" class="form" method="POST">
                @csrf
                @foreach($categories as $category) 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="categoriesId_{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                        <label class="form-check-label">{{ $category->name }}</label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>
            </form>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $categories->appends($filters)->links() !!}
            @else
                {!! $categories->links() !!}
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop