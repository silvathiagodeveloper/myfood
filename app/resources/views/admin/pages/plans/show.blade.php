@extends('adminlte::page')

@section('title', "Plano - {{ $plan->name }}")

@section('content_header')
    <h1>Plano - <b>{{ $plan->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome:</strong> {{ $plan->name }}
                </li>
                <li>
                    <strong>Url:</strong> {{ $plan->url }}
                </li>
                <li>
                    <strong>Preço:</strong> {{ number_format($plan->price, 2, ',', '.') }}
                </li>
                <li>
                    <strong>Descrição:</strong> {{ $plan->description }}
                </li>
            </ul>
            <form action="{{ route('plans.destroy', $plan->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" id="btnDelete" class="btn btn-danger">Apagar</button>
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