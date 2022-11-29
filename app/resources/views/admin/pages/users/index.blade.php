@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">Usuários</a></li>
    </ol>
    <h1>Usuários <a href="{{ route('users.create') }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> Adicionar</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('users.search') }}" method="post">
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
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td style="width:450px;">
                            <a href="{{ route('users.show',$user->id) }}" class="btn btn-info"><i class="fas fa-eye"></i> Ver</a>
                            <a href="{{ route('users.edit',$user->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Editar</a>
                            <a href="{{ route('users.roles',$user->id) }}" class="btn btn-warning"><i class="fas fa-tags"></i> Funções</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $users->appends($filters)->links() !!}
            @else
                {!! $users->links() !!}
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