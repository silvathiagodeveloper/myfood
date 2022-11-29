@extends('adminlte::page')

@section('title', "Empresa - {$tenant->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tenants.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.show', $tenant->id) }}">{{ $tenant->name }}</a></li>
    </ol>
    <h1>Empresa - <b>{{ $tenant->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')
            <ul>
                <li>
                    @if(!empty($tenant->logo))
                        <img src="{{ url("storage/".($tenant->logo ?? 'blank.jpg')) }}" class="img-size-50"/>
                    @endif
                </li>
                <li>
                    <strong>Nome:</strong> {{ $tenant->name }}
                </li>
                <li>
                    <strong>URL:</strong> {{ $tenant->url }}
                </li>
                <li>
                    <strong>CNPJ:</strong> {{ $tenant->cnpj }}
                </li>
                <li>
                    <strong>Descrição:</strong> {{ $tenant->description }}
                </li>
            </ul>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop