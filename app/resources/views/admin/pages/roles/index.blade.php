@extends('adminlte::page')

@section('title', 'Funções')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('roles.index') }}">Funções</a></li>
    </ol>
    <h1>Funções <a href="{{ route('roles.create') }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> Adicionar</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('roles.search') }}" method="post">
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
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td style="width:450px;">
                            <a href="{{ route('roles.show',$role->id) }}" class="btn btn-info"><i class="fas fa-eye"></i> Ver</a>
                            <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Editar</a>
                            <a href="{{ route('roles.permissions',$role->id) }}" class="btn btn-warning"><i class="fas fa-fw fa-lock"></i> Permissões</a>
                            <a href="{{ route('roles.users',$role->id) }}" class="btn btn-warning"><i class="fas fa-list-alt"></i> Usuários</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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