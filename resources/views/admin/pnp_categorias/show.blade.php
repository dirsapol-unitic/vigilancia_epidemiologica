@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            PNP Categorias
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.pnp_categorias.show_fields')
                    <a href="{!! route('pnpcategorias.index') !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
