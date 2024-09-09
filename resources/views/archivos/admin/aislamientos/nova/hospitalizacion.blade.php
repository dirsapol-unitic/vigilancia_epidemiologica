@extends('layouts.master_ficha2')


@section('content')

    <div class="content">

        @include('adminlte-templates::common.errors')
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_hospitalizacion']) !!}

            @include('admin.aislamientos.ficha02')

        {!! Form::close() !!}
    </div>

@endsection

