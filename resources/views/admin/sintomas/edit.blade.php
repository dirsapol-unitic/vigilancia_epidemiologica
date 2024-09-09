@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sintomas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sintomas, ['route' => ['sintomas.update', $sintomas->id], 'method' => 'patch']) !!}

                        @include('admin.sintomas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection