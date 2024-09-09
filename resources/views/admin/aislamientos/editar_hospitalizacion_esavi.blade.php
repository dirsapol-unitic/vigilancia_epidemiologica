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
      @include('admin.aislamientos.menu_superior')
      <div class="nav-tabs-custom">
        <div class="content">
          <div class="clearfix"></div>
          @include('flash::message')        
          <div class="clearfix"></div>
          {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'esavis.store_hospitalizacion_esavi']) !!}
          <h2 class="page-header">
            <i class="fa fa-globe"></i> HOSPITALIZACION ESAVI
          </h2>
          <div class="box-body">
            <div class="row col-sm-12">
              <div class="form-group col-sm-4">
                <label>Numero Historia Clinica</label><br/>
                <input type="text" tabindex="3"  required="" name="nro_historia_clinica" id="nro_historia_clinica" class="form-control" value="<?php echo $nro_historia_clinica; ?>" >
              </div>
              <div class="form-group col-sm-4">
                <label>Fecha  de Ingreso</label><br/>
                <input type="date" tabindex="3"  required="" name="fecha_ingreso" id="fecha_ingreso" class="form-control" value="<?php echo $fecha_ingreso; ?>" >
              </div>
              <div class="form-group col-sm-4">
                <label>Fecha  de Alta</label><br/>
                <input type="date" tabindex="3"  required="" name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo $fecha_alta; ?>" >
              </div>
            </div>
            <div class="row col-sm-12">
              <div class="form-group col-sm-12">
                <label>Diagnosticos Ingreso:</label><br/>
                @if($count_diagnostico1!=0)
                  <table class="display" id="tblDiagnosticos" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                        <tr>
                            <th width="20%">Codigo</th>
                            <th width="60%">Nombre</th>
                            <th width="20%">Tipo</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                      <?php foreach($diagnostico1 as $row):
                        $tipo_diagnostico = "";
                        if($row->id_tipo_diagnostico==1)$tipo_diagnostico = "PRESUNTIVO";
                        if($row->id_tipo_diagnostico==2)$tipo_diagnostico = "DEFINITIVO";
                        if($row->id_tipo_diagnostico==3)$tipo_diagnostico = "REITERATIVO";
                      ?>
                      <tr>
                        <td><?php echo $row->codigo?></td>
                        <td><?php echo $row->nombre?></td>
                        <td><?php echo $tipo_diagnostico?></td>
                      </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                @endif
              </div>
              <div class="form-group col-sm-12">
                <div class="panel-body">
                  <table>
                    <tr>
                      <td>
                          <button type="button" id="addDiagnostico" class="btn btn-warning" data-toggle="modal" data-target="#addClassModal">Agregar Diagnostico</button>
                      </td>
                    </tr>
                  </table>
                  <br />
                  <table class="display" id="tblDiagnostico" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                      <tr>
                        <th width="90%"></th>
                        <th width="10%"></th>
                      </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    </tbody>
                  </table>                    
                </div>
              </div>
            </div>

            <div class="row col-sm-12">
              <div class="form-group col-sm-12">
                <label>Diagnosticos Salida:</label><br/>
                @if($count_diagnostico2!=0)
                  <table class="display" id="tblDiagnosticos2" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                        <tr>
                            <th width="20%">Codigo</th>
                            <th width="60%">Nombre</th>
                            <th width="20%">Tipo</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                      <?php foreach($diagnostico2 as $row):
                        $tipo_diagnostico = "";
                        if($row->id_tipo_diagnostico==1)$tipo_diagnostico = "PRESUNTIVO";
                        if($row->id_tipo_diagnostico==2)$tipo_diagnostico = "DEFINITIVO";
                        if($row->id_tipo_diagnostico==3)$tipo_diagnostico = "REITERATIVO";
                      ?>
                      <tr>
                        <td><?php echo $row->codigo?></td>
                        <td><?php echo $row->nombre?></td>
                        <td><?php echo $tipo_diagnostico?></td>
                      </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                @endif
              </div>
              <div class="form-group col-sm-12">
                <div class="panel-body">
                  <table>
                    <tr>
                      <td>
                          <button type="button" id="addDiagnostico2" class="btn btn-warning" data-toggle="modal" data-target="#addClassModal">Agregar Diagnostico</button>
                      </td>
                    </tr>
                  </table>
                  <br />
                  <table class="display" id="tblDiagnostico2" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                      <tr>
                        <th width="90%"></th>
                        <th width="10%"></th>
                      </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    </tbody>
                  </table>                    
                </div>
              </div>
            </div>
            <div class="row col-sm-12">
              
              <div class="form-group col-sm-4">
                <label>Estado de Alta</label> <br/>
                <select class="form-control select2" tabindex="8" required="" style="width: 100%" name="estado_alta" id="estado_alta">
                    <option value="0" <?php if($estado_alta == 0)echo "selected='selected'";?>>- Seleccione -</option>
                    <option value="1" <?php if($estado_alta == 1)echo "selected='selected'";?>>Mejorado</option>
                    <option value="2" <?php if($estado_alta == 2)echo "selected='selected'";?>>Secuela</option>
                    <option value="3" <?php if($estado_alta == 3)echo "selected='selected'";?>>Fallecido</option>
                </select><br/><br/>
              </div>
              <div class="form-group col-sm-4">
                <label>Transferido</label> <br/>
                <select class="form-control select2" tabindex="8" required="" style="width: 100%" name="transferido" id="transferido"  onchange="getTransferido2();">
                    <option value="0" <?php if($transferido == 0)echo "selected='selected'";?>>- Seleccione -</option>
                    <option value="1" <?php if($transferido == 1)echo "selected='selected'";?>>SI</option>
                    <option value="2" <?php if($transferido == 2)echo "selected='selected'";?>>NO</option>
                </select><br/><br/>
              </div>
              @if($transferido == 1 )
                <div class="form-group col-sm-4" id="divtransferido2">
              @else
                <div class="form-group col-sm-4" id="divtransferido">
              @endif
                <label>Hospital/Clinica:</label><br/>
                <select class="form-control select2" style="width: 100%" tabindex="4" name="establecimiento_transferido" id="establecimiento_transferido">
                    <option value="">- Seleccione -</option>
                    @foreach($establecimiento_salud as $dep)
                    <option value="{{$dep->id}}" <?php if($establecimiento_transferido == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                    @endforeach
                </select>
              </div>
              <input type="hidden" name="dni_hospitalizacion" id="dni_hospitalizacion" value="<?php echo $paciente->dni?>">
              <input type="hidden" name="id_paciente_hospitalizacion" id="id_paciente_hospitalizacion" value="<?php echo $paciente->id?>">
              <input type="hidden" name="id_hospitalizacion" id="id_hospitalizacion" value="<?php echo $id_hospitalizacion?>">
              <input type="hidden" name="esavi_id" id="esavi_id" value="<?php echo $esavi_id?>">
              
            </div>
            <div class="form-group col-sm-12">
                {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
            </div>    
            <br/>
            <br/>
          </div>
          <!--BOX-BODY!-->
        {!! Form::close() !!}
        </div><!--CONTENT-->
      </div> <!--TAB--> 
    </div><!--MD-->
  </div>
</div>

@endsection

