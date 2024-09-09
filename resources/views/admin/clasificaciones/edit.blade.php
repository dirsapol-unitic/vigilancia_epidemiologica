@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Clasificaciones
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($clasificaciones, ['route' => ['clasificaciones.update', $clasificaciones->id], 'method' => 'patch']) !!}

                        @include('admin.clasificaciones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection