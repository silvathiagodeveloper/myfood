@extends('adminlte::page')

@section('title', 'Cadastrar Novo Plano')

@section('content_header')
    <h1>Cadastrar Novo Plano</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('plans.store') }}" class="form" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nome:">
                </div>
                <div class="form-group">
                    <label for="price">Preço:</label>
                    <input type="text" id="price" name="price" class="form-control" placeholder="Preço:">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <input type="text" id="description" name="description" class="form-control" placeholder="Descrição:">
                </div>
                <button type="submit" class="btn btn-dark" id="btnSend">Enviar</button>
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