@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Vacunas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($vacunas, ['route' => ['vacunas.update', $vacunas->id], 'method' => 'patch']) !!}

                        @include('admin.vacunas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection