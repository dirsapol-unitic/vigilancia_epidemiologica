@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Factor Riesgos
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.factor_riesgos.show_fields')
                    <a href="{!! route('factorriesgos.index') !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
