@extends('adminlte::page')

@section('title', "Categoria - {$category->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('categories.show', $category->url) }}">{{ $category->name }}</a></li>
    </ol>
    <h1>Categoria - <b>{{ $category->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')
            <ul>
                <li>
                    <strong>Nome:</strong> {{ $category->name }}
                </li>
                <li>
                    <strong>Url:</strong> {{ $category->url }}
                </li>
                <li>
                    <strong>Descrição:</strong> {{ $category->description }}
                </li>
            </ul>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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