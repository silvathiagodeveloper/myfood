@extends('adminlte::page')

@section('title', "Vincular perfis ao plano {$plan->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Planos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plans.show', $plan->id) }}">{{ $plan->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plans.profiles', $plan->id) }}">Perfis</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('plans.profiles.create', $plan->id) }}">Novo</a></li>
    </ol>
    <h1>Vincular Perfis ao Plano {{ $plan->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('plans.profiles.create', $plan->id) }}" method="post">
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
            <form id="frmMain" action="{{ route('plans.profiles.attach', $plan->id) }}" class="form" method="POST">
                @csrf
                @foreach($profiles as $profile) 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="profilesId_{{ $profile->id }}" name="profiles[]" value="{{ $profile->id }}">
                        <label class="form-check-label">{{ $profile->name }}</label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>
            </form>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $profiles->appends($filters)->links() !!}
            @else
                {!! $profiles->links() !!}
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