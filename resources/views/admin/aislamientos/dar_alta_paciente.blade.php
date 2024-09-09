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
      <div class="panel panel-primary filterable" >
        <div class="panel-heading">
            <h3 class="panel-title">ALTA HOSPITALIZACION - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
        </div>
        <div class="clearfix"></div>
        @include('flash::message')        
        <div class="clearfix"></div>
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_alta_hospitalizacion']) !!}
            <div class="box-body">
              <!--div class="row col-sm-12">
                <div class="form-group col-sm-3">
                    <label>Motivo de Egreso</label><br/>
                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="motivo_egreso" id="motivo_egreso">
                        <option value="">- Seleccione -</option>
                        <option value="1" <?php //if($motivo_egreso == 1)echo "selected='selected'";?>>Alta Medica</option>
                          <option value="2" <?php //if($motivo_egreso == 2)echo "selected='selected'";?>>Alta Voluntaria</option>
                          <option value="3" <?php //if($motivo_egreso == 3)echo "selected='selected'";?>>Referido</option>
                          <option value="3" <?php //if($motivo_egreso == 4)echo "selected='selected'";?>>Defuncion</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label>Fecha  de Alta / Referencia / Defuncion</label><br/>
                    <input type="date" tabindex="3"  required="" name="fecha_alta" id="fecha_alta" class="form-control" value="<?php //echo $fecha_alta; ?>" >
                </div>
              </div-->
              <div class="row col-sm-12">
                <div class="form-group col-sm-12">
                  <label>Diagnostico de egreso:</label><br/>
                  @if($count_diagnostico!=0)
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
                        <?php foreach($diagnostico as $row):
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
                <input type="hidden" name="dni_hospitalizacion" id="dni_hospitalizacion" value="<?php echo $paciente->dni?>">
                <input type="hidden" name="id_paciente_hospitalizacion" id="id_paciente_hospitalizacion" value="<?php echo $paciente->id?>">
                <input type="hidden" name="id_hospitalizacion" id="id_hospitalizacion" value="<?php echo $id_hospitalizacion?>">
                <input type="hidden" name="idficha" id="idficha" value="<?php echo $idficha?>">
              </div>
              
              <div class="box-body">
                
                <div class="form-group col-sm-4">
                    {!! Form::submit('Cerrar Ficha', ['class' => 'btn btn-primary pull-right btn-block btn-md']) !!}                    
                </div>
             </div>
              
              <br/>
              <br/>
            </div>
          </div>
        {!! Form::close() !!}
      
    </div>
  </div>
</div>

@endsection

