@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral')
    </div>
    <div class="col-md-10">
      @include('admin.aislamientos.menu_superior')
      <div class="nav-tabs-custom">
        <div class="content">
          <div class="clearfix"></div>
          @include('flash::message')        
          <div class="clearfix"></div>
          <div class="box-body">
            {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'esavis.store_cuadro_clinicos']) !!}
                <h2 class="page-header">
                  <i class="fa fa-globe"></i> CUADRO CLINICO ESAVI
                </h2>
                <div class="box box-primary">
                  <div class="box-body">
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-4">
                          <label>Fecha  de inicio de sintomas</label><br/>
                          <input type="date" tabindex="28"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="<?php echo date("Y-m-d", strtotime($esavis->fecha_sintoma)); ?>" >
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Gravedad del caso:</label><br/>
                        <select class="form-control select2" tabindex="1" required="" name="gravedad_caso" id="gravedad_caso">
                            <option value="0">- Seleccione -</option>
                            <option value="1" <?php if($esavis->gravedad_caso==1) echo 'selected';?>> Confirmado </option>
                            <option value="2" <?php if($esavis->gravedad_caso==2) echo 'selected';?>> Probable </option>
                            <option value="3" <?php if($esavis->gravedad_caso==3) echo 'selected';?>> Sospechoso </option>
                        </select>
                      </div>
                    </div>
                    <div class="row col-sm-12">
                        <label>Secuencia cronologica de instalacion de signos / sintomas</label> <br/>
                        <textarea rows="10" type="text" tabindex="41" name="secuencia_cronologica" id="secuencia_cronologica" class="ckeditor"><?php echo $esavis->secuencia_cronologica?></textarea>
                        <br/><br/><br/>
                    </div>
                    <div class="row col-sm-12">
                        <label>Examenes Auxiliares</label> <br/>                                
                        <textarea rows="10" type="text" tabindex="42" name="examen_auxiliar" id="examen_auxiliar" class="ckeditor"><?php echo $esavis->examen_auxiliar?></textarea>                                
                        <br/><br/><br/>
                    </div>
                    <div class="row col-sm-12">
                        <label>Tratamiento recibido</label> <br/>                                
                        <textarea rows="10" type="text" tabindex="42" name="tratamiento_recibido" id="tratamiento_recibido" class="ckeditor"><?php echo $esavis->tratamiento_recibido?></textarea>                                
                        <br/><br/><br/>
                    </div>
                    <div class="row col-sm-12">
                        <label>Evolucion</label> <br/>                                
                        <textarea rows="10" type="text" tabindex="42" name="evolucion" id="evolucion" class="ckeditor"><?php echo $esavis->evolucion?></textarea>                                
                        <br/><br/><br/>
                    </div>
                    <!-- /.box-col -->
                    <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
                    <input type="hidden" name="id_esavi" id="id_esavi" value="{{$id_esavi}}">
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box-primary -->
              <!-- /.box-panel -->
              <div class="box-body">
                <div class="form-group col-sm-12">
                  {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
                    <a href="{!! route('esavis.listar_esavis',[$id, $dni]) !!}" class="btn btn-danger">Cancelar</a>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box-content -->
      </div>
      <!-- /.box-tab -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.content -->
@endsection

