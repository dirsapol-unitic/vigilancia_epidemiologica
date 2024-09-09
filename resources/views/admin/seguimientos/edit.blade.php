@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($seguimientos, ['route' => ['seguimientos.update', $seguimientos->id], 'method' => 'patch']) !!}

                        @include('admin.seguimientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection