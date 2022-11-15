@extends('adminlte::page')

@section('title', "Produto - {$product->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></li>
    </ol>
    <h1>Produto - <b>{{ $product->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')
            <ul>
                <li>
                    @if(!empty($product->image))
                        <img src="{{ url("storage/".($product->image ?? 'blank.jpg')) }}" class="img-size-50"/>
                    @endif
                </li>
                <li>
                    <strong>Nome:</strong> {{ $product->name }}
                </li>
                <li>
                    <strong>URL:</strong> {{ $product->url }}
                </li>
                <li>
                    <strong>Preço:</strong> {{ number_format($product->price, 2, ',', '.') }}
                </li>
                <li>
                    <strong>Descrição:</strong> {{ $product->description }}
                </li>
            </ul>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" id="btnDelete" class="btn btn-danger"><i class="fas fa-trash"></i> Apagar</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop