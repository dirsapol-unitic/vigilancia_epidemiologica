@extends('layouts.app')
@section('css')
    <style type="text/css">
        th, td { font-size: 10px;}
        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }        

        .form-control {
            font-size: 10px;
        }
    </style>
@stop
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Establecimiento Salud</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('establecimientosalud.create') !!}">Nuevo <i class="glyphicon glyphicon-file"></i></a>
        </h1>
        <br/><br/>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    @include('admin.establecimiento_salud.table')
                </div>    
            </div>
        </div>
        <div class="text-center">
        
        </div>
        
    </div>
@endsection
@section('scripts')

@stop