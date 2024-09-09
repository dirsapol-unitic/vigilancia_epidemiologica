@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral')
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <section class="content-header">
        <h1 class="pull-left">Signos/Sintomas ESAVI</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="tab-content">
          <div class="box-header">
            <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('esavis.create_signo_sintomas',[$id, $dni]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
          </div>
          <div class="content">
            <div class="clearfix"></div>
            @include('flash::message')        
            <div class="clearfix"></div>
            <div class="box box-primary">
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="box-body">
                      <?php $x=1; ?>
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                              <th>#</th>
                              <th>Fecha Registro</th>
                              <th>Usuario Registro</th>
                              <th><p align="center">Editar/Eliminar</p></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($esavis as $ant)
                          <tr>
                            <td>{{$x++}}</td>
                            <td>{!! $ant->fecha_registro !!}</td>
                            <td>{!! $ant->name !!}</td>
                            <td><a href="{!! route('esavis.editar_signo_sintomas', [$ant->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>            
                  </div>        
                </div>    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

