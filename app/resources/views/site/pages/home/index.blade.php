@extends('site.layouts.app')

@section('body')
<div class="wrapper">
    <div class="content" style="margin-left: 10%; margin-right:10%">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Myfood</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <h3 class="mt-4 mb-4">Escolha seu Plano</h3>
                <div class="row">
                    @foreach($plans as $plan)
                    <div class="col-md-4">
                        <div class="card card-widget widget-user" style="margin-bottom: 50px">
                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username"><b>{{ $plan->name }}</b></h3>
                                <br>
                                <h5 class="widget-user-username"><b>R$ {{ number_format($plan->price, 0, ',', '.') }}</b></h5>
                            </div>
                            <div class="card-footer">
                                @foreach($plan->details as $detail)
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block">
                                            <span class="description-text">{{ $detail->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block">
                                            <button type="button" class="btn btn-block btn-info btn-lg">Assinar</button>
                                        </div>
                                    </div>                         
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop