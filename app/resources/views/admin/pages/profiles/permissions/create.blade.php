@extends('adminlte::page')

@section('title', "Vincular Permissões ao Perfil {$profile->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profiles.index') }}">Perfis</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profiles.show', $profile->id) }}">{{ $profile->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profiles.permissions.index', $profile->id) }}">Permissões</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('profiles.permissions.create', $profile->id) }}">Novo</a></li>
    </ol>
    <h1>Vincular Permissões ao Perfil {{ $profile->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')
            <form id="frmMain" action="{{ route('profiles.permissions.store', $profile->id) }}" class="form" method="POST">
                @csrf
                @foreach($permissions as $permission) 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="permissionsId_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}">
                        <label class="form-check-label">{{ $permission->name }}</label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>
            </form>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $permissions->appends($filters)->links() !!}
            @else
                {!! $permissions->links() !!}
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop