@extends('layouts.master_ficha')


@section('content')

    <div class="content">

        @include('adminlte-templates::common.errors')
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store']) !!}

            @include('admin.aislamientos.nuevo_paciente')

        {!! Form::close() !!}
    </div>

@endsection

