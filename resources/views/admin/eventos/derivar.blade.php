@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>
            Derivar Personal con FICHA EPIDEMIOLOGICA COVID-19
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    
                    {!! Form::model($aislamientos, ['route' => ['aislamientos.update_riesgo', $aislamientos->id,$aislamientos->dni,$riesgos], 'method' => 'patch']) !!}

                        @include('admin.aislamientos.fields')

                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
@endsection

