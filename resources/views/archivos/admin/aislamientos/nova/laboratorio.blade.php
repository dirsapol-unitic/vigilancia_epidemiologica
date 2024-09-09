@extends('layouts.master')


@section('content')

    <div class="content">

        @include('adminlte-templates::common.errors')
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store']) !!}

            @include('admin.aislamientos.ficha04')

        {!! Form::close() !!}
    </div>

@endsection

