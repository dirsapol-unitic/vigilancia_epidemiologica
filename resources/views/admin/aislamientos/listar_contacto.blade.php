@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral_opciones')
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <section class="content-header">
        <h1 class="pull-left">Listado de Contactos</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        @if($paciente->evolucion!='FALLECIO')
          <div class="box-header"><br/><br/>
            <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('aislamientos.create_contacto',[$id, $dni, $idficha]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
          </div>
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
                            <th width="10%">Fecha Registro</th>
                            <th width="10%">DNI</th>
                            <th width="40%">Nombre</th>
                            <th width="10%">Fecha Nacimiento</th>
                            <th width="20%">Tipo Contacto</th>
                            
                            <th width="10%">Editar</th>
                            
                          </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                          <?php foreach($contactos as $row):?>
                          <tr>
                            <td><?php echo $row->fecha_registro?></td>
                            <td><?php echo $row->dni_contacto?></td>
                            <td><?php echo $row->nombres_contacto.', '.$row->paterno_contacto.' '.$row->materno_contacto; ?></td>
                            <td><?php echo $row->fecha_nacimiento_contacto?></td>
                            <?php switch ($row->tipo_contacto) {
                                case '1': $tipo_contacto='Familiar';break;
                                case '2': $tipo_contacto='Centro Laboral';break;
                                case '3': $tipo_contacto='Centro de Estudio';break;
                                case '4': $tipo_contacto='EESS';break;
                                case '5': $tipo_contacto='Evento Social ';break;
                                case '6': $tipo_contacto='Atención medica domiciliaria ';break;
                                case '7': $tipo_contacto='Otro';break;
                            } ?>
                            <td><?php echo $tipo_contacto?></td>
                            
                            <td><a href="{!! route('aislamientos.editar_contacto', [$row->id,$dni, $id, $idficha]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
                            
                          </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>    
                  </div>    
                </div>
              </div>
            </div>
            <!--box primary-->
          </div>
          <!--box content-->
        
      </div>
    </div>
  </div>
</div>
@endsection

