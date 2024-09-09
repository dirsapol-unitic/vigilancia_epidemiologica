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
          <div class="box-header">
            <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('esavis.create_hospitalizacion_esavi',[$dni, $id]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
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
                            <th width="10%">Fecha Ingreso</th>
                            <th width="30%">Fecha alta</th>
                            <th width="30%">Estado Alta</th>
                            <th width="10%">Registrador</th>
                            <th width="10%">Editar</th>
                          </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                          <?php foreach($hospitalizaciones as $row):?>
                          <tr>
                            <td><?php echo $row->fecha_ingreso?></td>
                            <td><?php echo $row->fecha_alta?></td>
                            <td><?php echo $row->estado_alta?></td>
                            <td><?php echo $row->fecha_ingreso?></td>
                            <td><a href="{!! route('esavis.editar_hospitalizacion_esavi', [$row->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
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

