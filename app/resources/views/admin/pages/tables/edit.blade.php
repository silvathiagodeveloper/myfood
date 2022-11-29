@extends('adminlte::page')

@section('title', "Mesa {$table->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tables.index') }}">Mesas</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tables.show', $table->url) }}">{{ $table->name }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tables.edit', [$table->url]) }}">Editar</a></li>
    </ol>
    <h1>Mesa - {{ $table->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('tables.update', $table->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.tables._partials.form')
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