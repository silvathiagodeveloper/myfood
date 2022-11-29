@extends('adminlte::page')

@section('title', "Vincular funções ao usuário {$user->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.roles', $user->id) }}">Funções</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('users.roles.create', $user->id) }}">Novo</a></li>
    </ol>
    <h1>Vincular Funções ao Usuário {{ $user->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('users.roles.create', $user->id) }}" method="post">
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
            <form id="frmMain" action="{{ route('users.roles.attach', $user->id) }}" class="form" method="POST">
                @csrf
                @foreach($roles as $role) 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rolesId_{{ $role->id }}" name="roles[]" value="{{ $role->id }}">
                        <label class="form-check-label">{{ $role->name }}</label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>
            </form>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $roles->appends($filters)->links() !!}
            @else
                {!! $roles->links() !!}
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