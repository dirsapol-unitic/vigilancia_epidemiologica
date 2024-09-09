@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Preguntas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pregunta, ['route' => ['preguntas.update', $pregunta->id], 'method' => 'patch']) !!}

                        @include('admin.preguntas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection