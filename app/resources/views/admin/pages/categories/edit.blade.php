@extends('adminlte::page')

@section('title', "Categoria {$category->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.show', $category->url) }}">{{ $category->name }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('categories.edit', [$category->url]) }}">Editar</a></li>
    </ol>
    <h1>Categoria - {{ $category->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('categories.update', $category->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.categories._partials.form')
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