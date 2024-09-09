@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Factor Riesgos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($factorriesgos, ['route' => ['factorriesgos.update', $factorriesgos->id], 'method' => 'patch']) !!}

                        @include('admin.factor_riesgos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection