@extends('adminlte::page')

@section('title', 'Cadastrar Nova Função')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Funções</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('roles.create') }}">Novo</a></li>
    </ol>
    <h1>Cadastrar Nova Função</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('roles.store') }}" class="form" method="POST">
                @csrf
                @include('admin.pages.roles._partials.form')
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