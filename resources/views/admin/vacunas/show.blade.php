@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Vacunas
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.vacunas.show_fields')
                    <a href="{!! route('vacunas.index') !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
