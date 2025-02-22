@extends('layouts.template')

@section('content')
    <section class="content-header">
        <h1>
            Establecimientos
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'establecimientos.store']) !!}

                        @include('admin.establecimientos.fields')

                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
@endsection

