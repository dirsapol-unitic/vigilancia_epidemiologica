@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Informe Riesgos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($informeriesgos, ['route' => ['informeriesgos.update', $informeriesgos->id], 'method' => 'patch']) !!}

                        @include('admin.informe_riesgos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection