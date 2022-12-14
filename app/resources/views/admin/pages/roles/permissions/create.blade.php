@extends('adminlte::page')

@section('title', "Vincular Permissões à Função {$role->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Funções</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.permissions', $role->id) }}">Permissões</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('roles.permissions.create', $role->id) }}">Novo</a></li>
    </ol>
    <h1>Vincular Permissões à Função {{ $role->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('roles.permissions.create', $role->id) }}" method="post">
                @csrf
                <div class="input-group input-group-sm">
                    <input type="text" name="filter" id="filter" placeholder="Nome" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-dark btn-flat"><i class="fas fa-search fa-fw"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <div class="card-body">
            @include('admin.includes.alerts')
            <form id="frmMain" action="{{ route('roles.permissions.attach', $role->id) }}" class="form" method="POST">
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