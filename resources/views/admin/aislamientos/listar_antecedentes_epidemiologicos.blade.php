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
        <h1 class="pull-left">Antecedentes Epidemiologica</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="tab-content">
          <div class="active tab-pane" id="antecedentes">
            @if($paciente->evolucion!='FALLECIO')
              @if(count($antecedentes)<1)
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
                                <th>Clasificacion</th>
                                <th>Establecimiento</th>
                                <th>Fecha Registro</th>
                                <th>Usuario Registro</th>
                                
                                <th><p align="center">Editar/Eliminar</p></th>
                                
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($antecedentes as $ant)
                            <tr>
                              <td>{{$x++}}</td>
                              <td><?php 
                                      switch($ant->id_clasificacion){
                                          case '1': echo 'Confirmado'; break;
                                          case '2': echo 'Probable'; break;
                                          case '3': echo 'Sospechoso'; break;
                                          case '4': echo 'Descartado'; break;
                                              
                                      }
                                      ?></td>
                              <td>{!! $ant->nombre !!}</td> 
                              <td>{!! $ant->fecha_registro !!}</td>
                              <td>{!! $ant->name !!}</td>
                              
                              <td>
                                @if($paciente->evolucion!='FALLECIO')
                                  <a href="{!! route('aislamientos.editar_antecedentes_epidemiologico', [$ant->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                  <a data-toggle="tooltip" title="Eliminar Antecedente!" href="{!! route('aislamientos.eliminar_antecedente', [$ant->id,$id, $dni]) !!}" class='btn btn-danger btn-xs'><i class="glyphicon glyphicon-trash"></i></a>
                                @else
                                  <a href="#" disabled='disabled' class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                  <a  disabled='disabled' data-toggle="tooltip" title="Eliminar Antecedente!" href="" class='btn btn-danger btn-xs'><i class="glyphicon glyphicon-trash"></i></a>
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

