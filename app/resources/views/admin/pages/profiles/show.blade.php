@extends('adminlte::page')

@section('title', "Perfil - {$profile->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Perfis</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('profile.show', $profile->id) }}">{{ $profile->name }}</a></li>
    </ol>
    <h1>Perfil - <b>{{ $profile->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')
            <ul>
                <li>
                    <strong>Nome:</strong> {{ $profile->name }}
                </li>
                <li>
                    <strong>Descrição:</strong> {{ $profile->description }}
                </li>
            </ul>
            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST">
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