@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            PNP Categorias
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pnpcategorias, ['route' => ['pnpcategorias.update', $pnpcategorias->id], 'method' => 'patch']) !!}

                        @include('admin.pnp_categorias.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection