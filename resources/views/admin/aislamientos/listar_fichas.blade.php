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
        <h1 class="pull-left">Fichas Registradas</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="tab-content">
          <div class="active tab-pane" id="antecedentes">
            @if($paciente->evolucion!='FALLECIO')
              @if($activo==0) 
              <div class="box-header">
                <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('aislamientos.create_antecedente_epidemiologico',[$id, $dni]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
              </div>
              @endif
            @endif
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
                                <th>Fecha de Notificación</th>
                                <th>Nombre Registrador</th>
                                <th>Establecimiento que registro</th>
                                <th>Hospitalizado</th>
                                <th>Estado</th>
                                <th><p align="center">Editar/Ver/Eliminar</p></th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($fichas as $fi)
                            <tr>
                              <td>{{$x++}}</td>
                              <td>{!! $fi->fecha_reg_ficha !!}</td>
                              <td>
                                <?php
                                  $originalDate1 = $fi->fecha_notificacion;
                                  $fechaE = date("d-m-Y", strtotime($originalDate1));
                                  echo $fechaE;
                                ?>
                              </td>
                              <td>{!! $fi->name !!}</td> 
                              <td>{!! $fi->nombre !!}</td> 
                              <td>{!! $fi->hospitalizado !!}</td> 
                              <td>
                                <?php 
                                    if($fi->activo==1) echo 'ACTIVO'; else echo 'CERRADO';
                                ?>
                              </td> 
                              <td>
                                @if($fi->id_establecimiento == Auth::user()->establecimiento_id || Auth::user()->rol == 1)
                                  <a href="{!! route('aislamientos.editar_antecedentes_epidemiologico', [$fi->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                  <a href="{!! route('aislamientos.ver_ficha', [$fi->id,$dni, $id]) !!}" class='btn btn-info btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                  <a href="{!! route('aislamientos.eliminar_ficha', [$fi->id,$dni, $id]) !!}" class='btn btn-danger btn-xs'><i class="glyphicon glyphicon-trash"></i></a>
                                @else
                                  <a href="{!! route('aislamientos.ver_ficha', [$fi->id,$dni, $id]) !!}" class='btn btn-info btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                @endif
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
  </div>
</div>
@endsection

