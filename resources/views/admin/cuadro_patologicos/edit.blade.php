@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cuadro Patologicos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($cuadropatologicos, ['route' => ['cuadropatologicos.update', $cuadropatologicos->id], 'method' => 'patch']) !!}

                        @include('admin.cuadro_patologicos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection