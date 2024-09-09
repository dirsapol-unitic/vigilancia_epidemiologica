@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fabricantes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($fabricantes, ['route' => ['fabricantes.update', $fabricantes->id], 'method' => 'patch']) !!}

                        @include('admin.fabricantes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection