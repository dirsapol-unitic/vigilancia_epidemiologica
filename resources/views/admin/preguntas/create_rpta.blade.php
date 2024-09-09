@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Respuesta
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="panel panel-primary filterable" >
       <div class="box box-primary">
           <div class="box-body">
               <div class="row col-sm-12">
                   {!! Form::model($pregunta, ['route' => ['preguntas.create_rpta', $pregunta->id], 'method' => 'patch']) !!}
                        @include('admin.preguntas.fields_rpta')
                   {!! Form::close() !!}
                </div>
           </div>
       </div>
       </div>
       <div class="box box-primary">
           <div class="box-body">
                <div class="row col-sm-12">
                  @if($contar!=0)
                    @include('admin.preguntas.table_rpta')
                  @endif
               </div>
           </div>
       </div>
   </div>
@endsection
