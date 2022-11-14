@extends('adminlte::page')

@section('title', 'Cadastrar Novo Categoria')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('categories.create') }}">Novo</a></li>
    </ol>
    <h1>Cadastrar Novo Categoria</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('categories.store') }}" class="form" method="POST">
                @csrf
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