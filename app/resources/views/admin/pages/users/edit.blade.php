@extends('adminlte::page')

@section('title', "Usuário {$user->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('users.edit', [$user->id]) }}">Editar</a></li>
    </ol>
    <h1>Usuário - {{ $user->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmMain" action="{{ route('users.update', $user->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.users._partials.form')
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