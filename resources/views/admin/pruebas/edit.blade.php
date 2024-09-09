@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pruebas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pruebas, ['route' => ['pruebas.update', $pruebas->id], 'method' => 'patch']) !!}

                        @include('admin.pruebas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection