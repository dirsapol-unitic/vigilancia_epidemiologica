@extends('layouts.master')
@section('content')
    <section class="content-header">
        <h3 class="pull-left">Manual  </h3>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div>
                            @if($id==1)
                                @include('admin.manual.registros')
                            @endif
                            @if($id==2)
                                @include('admin.manual.usuarios')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center"></div>
    </div>
@endsection