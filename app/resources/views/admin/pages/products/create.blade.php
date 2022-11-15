@extends('adminlte::page')

@section('title', 'Cadastrar Novo Produto')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.create') }}">Novo</a></li>
    </ol>
    <h1>Cadastrar Novo Produto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('products.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.pages.products._partials.form')
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