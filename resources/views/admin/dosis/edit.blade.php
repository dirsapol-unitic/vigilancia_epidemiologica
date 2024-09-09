@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Dosis
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($dosis, ['route' => ['dosis.update', $dosis->id], 'method' => 'patch']) !!}

                        @include('admin.dosis.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection