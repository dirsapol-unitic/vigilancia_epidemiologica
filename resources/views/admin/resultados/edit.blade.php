@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Resultados
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($resultados, ['route' => ['resultados.update', $resultados->id], 'method' => 'patch']) !!}

                        @include('admin.resultados.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection