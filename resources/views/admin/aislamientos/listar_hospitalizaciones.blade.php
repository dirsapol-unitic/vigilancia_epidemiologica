@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral')
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <section class="content-header">
        <h1 class="pull-left">Hospitalizacion</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="tab-content">
          @if($paciente->evolucion!='FALLECIO')
            @if(count($hospitalizaciones)<1)
              <div class="box-header">
                <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('aislamientos.create_hospitalizacion',[$dni, $id]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
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
                    <div class="table-responsive">
                      <div class="box-body">
                        <?php $x=1; ?>
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th width="5%">Fecha Registro</th>
                              <th width="15%">Registrador</th>
                              <th width="5%">Fecha Hospitalizacion</th>
                              <th width="20%">Ipress Proviene</th>
                              <th width="20%">Hospital Actual</th>
                              <th width="15%">Actualizador</th>
                              <th width="5%">Fecha Ultima Actualizacion</th>
                              <th width="15%">Usuario Alta</th>
                              <th width="5%">Fecha Alta</th>
                              
                              <th width="5%">Dar Alta</th>
                              <th width="5%">Editar/Eliminar</th>
                              
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <?php foreach($hospitalizaciones as $row):?>
                            <tr>
                              <td><?php echo $row->fecha_registro?></td>
                              <td><?php echo $row->usuario_registro?></td>
                              <td><?php echo $row->fecha_hospitalizacion?></td>
                              <td><?php echo $row->nombre_establecimiento?></td>
                              <td><?php echo $row->nombre_actual?></td>
                              <td><?php echo $row->usuario_update?></td>
                              <td><?php echo $row->updated_at?></td>
                              <td><?php echo $row->usuario_alta?></td>
                              <td><?php echo $row->fecha_alta?></td>
                              
                              <td><a href="{!! route('aislamientos.dar_alta_hospitalizacion', [$row->id,$dni, $id]) !!}" class='btn btn-success btn-xs'><i class="glyphicon glyphicon-thumbs-up"></i></a></td>
                              <td><a href="{!! route('aislamientos.editar_hospitalizacion', [$row->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                <a data-toggle="tooltip" title="Eliminar Hospitalizacion!" href="{!! route('aislamientos.eliminar_hospitalizaciones', [$row->id,$id, $dni]) !!}" class='btn btn-danger btn-xs'><i class="glyphicon glyphicon-trash"></i></a></td>

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
</div>
@endsection

