@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral_opciones')
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <section class="content-header">
        <h1 class="pull-left">Evolucion del Paciente</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="tab-content">
          
          <div class="box-header">
            <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('aislamientos.create_evolucion',[$id, $dni, $idficha]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a> 
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
                              <th width="10%">Fecha Registro</th>
                              <th width="30%">Evolucion</th>
                              <th width="30%">Fecha Alta</th>
                              <th width="30%">Fecha Defuncion</th>
                              <th width="10%">Editar/Eliminar</th>
                          </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                          <?php foreach($evoluciones as $row):?>
                          <tr>
                            <td><?php echo $row->fecha_registro?></td>
                            <?php switch ($row->evolucion) {
                                case '1': $evolucion='Favorable';break;
                                case '2': $evolucion='Desfavorable';break;
                                case '3': $evolucion='Fallecio';break;
                                case '4': $evolucion='Alta Aislamiento';break;
                                case '5': $evolucion='Alta Voluntaria';break;
                                case '6': $evolucion='Referido';break;
                                case '7': $evolucion='Fugado';break;
                                case '8': $evolucion='Alta Médica/Hospitalaria';break;
                                case '9': $evolucion='En Oservación';break;
                                case '10': $evolucion='Estable';break;
                                case '11': $evolucion='Estacionario';break;
                            } ?>
                            <td><?php echo $evolucion?></td>
                            <td><?php 
                                if (is_null($row->fecha_alta))
                                    echo 'sin registro';
                                else{
                                    echo  $row->fecha_alta;
                                }
                                ?>
                            </td>
                            <td>
                              <?php 
                                if (is_null($row->fecha_defuncion))
                                    echo 'sin registro';
                                else{
                                    echo  $row->fecha_defuncion;
                                }
                              ?>      
                            </td>
                            <td>
                              <a href="{!! route('aislamientos.editar_evolucion', [$row->id,$dni, $id, $idficha]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                              <a data-toggle="tooltip" title="Eliminar Evolución!" href="{!! route('aislamientos.eliminar_evolucion', [$row->id,$id, $dni]) !!}" class='btn btn-danger btn-xs'><i class="glyphicon glyphicon-trash"></i></a>
                            </td>
                          </tr>
                          <?php endforeach;?>
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

