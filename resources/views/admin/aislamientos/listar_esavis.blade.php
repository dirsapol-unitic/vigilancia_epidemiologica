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
        <h1 class="pull-left">Listado de Esavi</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="box-header"><br/><br/>
          <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('esavis.create_esavis',[$id, $dni]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
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
                            <th>Esavi</th>
                            <th>Fecha Registro</th>
                            <th>Usuario Registro</th>
                            <th><p align="center">Opciones</p></th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($esavis as $ant)
                        <tr>
                          <td>{{$x++}}</td>
                          <td><?php 
                                  switch($ant->tipo_esavi){
                                      case '1': echo 'Severo'; break;
                                      case '2': echo 'Leve-Moderado'; break;
                                  }
                              ?>
                          </td>
                          <td>{!! $ant->fecha_registro !!}</td>
                          <td>{!! $ant->name !!}</td>
                          <td><a data-toggle="tooltip" data-placement="top" title="Editar ESAVI" href="{!! route('esavis.editar_esavis', [$ant->id,$dni, $id]) !!}" class='btn bg-olive btn-md'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Editar Vacunacion" href="{!! route('esavis.editar_vacunacion', [$ant->id,$dni, $id]) !!}" class='btn btn-danger btn-md'><i class="glyphicon glyphicon-pushpin"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Registrar Antecedente" href="{!! route('esavis.create_antecedente', [$ant->id,$dni, $id]) !!}" class='btn btn-warning btn-md'><i class="glyphicon glyphicon-user"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Registrar Signo y Sintomas" href="{!! route('esavis.create_signo_sintomas', [$ant->id,$dni, $id]) !!}" class='btn bg-navy btn-md'><i class="glyphicon glyphicon-folder-close"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Registrar Hospitalizacion" href="{!! route('esavis.create_hospitalizado_esavi', [$ant->id,$dni, $id]) !!}" class='btn btn-primary btn-md'><i class="glyphicon glyphicon glyphicon-tags"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Registrar Cuadro Clinico" href="{!! route('esavis.create_cuadro_clinicos', [$ant->id,$dni, $id]) !!}" class='btn bg-purple btn-md'><i class="glyphicon glyphicon-indent-left"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Seguimiento ESAVI" href="{!! route('esavis.create_seguimiento_esavi', [$ant->id,$dni, $id]) !!}" class='btn bg-maroon btn-md'><i class="glyphicon glyphicon-list-alt"></i></a>
                          </td>
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
@endsection

