@extends('layouts.template')

@section('content')

    <div class="content">

        @include('adminlte-templates::common.errors')
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientosite.store']) !!}

            @include('site.aislamientos.fields')

        {!! Form::close() !!}
    </div>

@endsection

