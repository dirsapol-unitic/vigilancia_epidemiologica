@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Respuesta
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($respuesta, ['route' => ['respuestas.update', $respuesta->id], 'method' => 'patch']) !!}

                        @include('admin.respuestas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection