@extends('layouts.master_ficha3')


@section('content')

    <div class="content">

        @include('adminlte-templates::common.errors')
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_evolucion']) !!}

            @include('admin.aislamientos.ficha03')

        {!! Form::close() !!}
    </div>

@endsection

