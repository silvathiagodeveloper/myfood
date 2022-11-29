@extends('adminlte::page')

@section('title', "Empresa {$tenant->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tenants.index') }}">Empresas</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tenants.show', $tenant->id) }}">{{ $tenant->name }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.edit', [$tenant->id]) }}">Editar</a></li>
    </ol>
    <h1>Empresa - {{ $tenant->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('tenants.update', $tenant->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.pages.tenants._partials.form')
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