@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Muestras
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($muestras, ['route' => ['muestras.update', $muestras->id], 'method' => 'patch']) !!}

                        @include('admin.muestras.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection