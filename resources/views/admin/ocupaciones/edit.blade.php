@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ocupaciones
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($ocupaciones, ['route' => ['ocupaciones.update', $ocupaciones->id], 'method' => 'patch']) !!}

                        @include('admin.ocupaciones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection