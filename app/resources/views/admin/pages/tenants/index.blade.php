@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.index') }}">Empresas</a></li>
    </ol>
    <h1>Empresas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('tenants.search') }}" method="post">
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
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                    <tr>
                        <td>
                            @if(!empty($tenant->logo))
                                <img src="{{ url("storage/".($tenant->logo ?? 'blank.jpg')) }}" class="img-size-50"/>
                            @endif
                        </td>
                        <td>{{ $tenant->name }}</td>
                        <td>{{ $tenant->cnpj }}</td>
                        <td style="width: 390px;">
                            <a href="{{ route('tenants.show',$tenant->id) }}" class="btn btn-info"><i class="fas fa-eye"></i> Ver</a>
                            @can('tenants.edit')
                                <a href="{{ route('tenants.edit',$tenant->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Editar</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $tenants->appends($filters)->links() !!}
            @else
                {!! $tenants->links() !!}
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