@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">Produtos</a></li>
    </ol>
    <h1>Produtos <a href="{{ route('products.create') }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> Adicionar</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('products.search') }}" method="post">
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
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if(!empty($product->image))
                                <img src="{{ url("storage/".($product->image ?? 'blank.jpg')) }}" class="img-size-50"/>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2, ',', '.') }}</td>
                        <td style="width: 390px;">
                            <a href="{{ route('products.show',$product->url) }}" class="btn btn-info"><i class="fas fa-eye"></i> Ver</a>
                            <a href="{{ route('products.edit',$product->url) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Editar</a>
                            <a href="{{ route('products.categories',$product->id) }}" class="btn btn-warning"><i class="fas fa-tags"></i> Categorias</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $products->appends($filters)->links() !!}
            @else
                {!! $products->links() !!}
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