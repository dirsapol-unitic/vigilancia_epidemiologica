@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
       @include('admin.aislamientos.menu_lateral')
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      @include('admin.aislamientos.menu_superior')
      <div class="nav-tabs-custom">
        <div class="content">
          <div class="clearfix"></div>
          @include('flash::message')        
          <div class="clearfix"></div>
          <div class="box-body">
            {!! Form::model($esavis, ['route' => ['esavis.update_antecedente', $esavis->id], 'method' => 'patch','id'=>'frm_aislamientos','name'=>'frm_aislamientos']) !!}
              <div class="panel panel-primary filterable" >
                <div class="panel-heading">
                    <h3 class="panel-title">ANTECEDENTES</h3>
                </div> 
                <div class="box box-primary">
                  <div class="box-body">
                    <div class="row col-sm-12">
                      <div class="row col-sm-12">
                        <div class="form-group col-sm-4">
                          <label>ESAVI:</label><br/>
                          <select class="form-control select2" tabindex="1" required="" name="tipo_esavi" id="tipo_esavi">
                              <option value="0">- Seleccione -</option>
                              <option value="1" <?php if($esavis->tipo_esavi == 1)echo "selected='selected'";?>> SI </option>
                              <option value="2" <?php if($esavis->tipo_esavi == 2)echo "selected='selected'";?> > NO </option>
                          </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Fecha  de Notificacion</label><br/>
                            <input type="date" tabindex="26"  name="fecha_notificacion" id="fecha_notificacion" class="form-control" value="<?php echo date("Y-m-d", strtotime($esavis->fecha_notificacion)); ?>" >
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Fecha  de registro</label><br/>
                            <input type="date" readonly="" tabindex="27"  name="fecha_registro" id="fecha_registro" class="form-control" value="<?php echo date("Y-m-d", strtotime($esavis->fecha_registro)); ?>" >
                        </div>
                      </div>
                    </div>
                    <!-- /.box-col -->
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Condiciones de Comorbilidad o factores de Riesgo</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($factorriesgos as $idf => $friesgo)
                          <tr>
                            <td>
                              <input type="checkbox" value="{{ $friesgo->id }}" {{ $esavis->comorbilidadesavis->pluck('id')->contains($friesgo->id) ? 'checked' : '' }} name="factorriesgos[]">
                            </td>
                            <td>&nbsp;{{ $friesgo->descripcion }}</td>
                          </tr>
                          @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="35" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
                      </div>
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Cuadros Patologicos</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($cuadropatologicos as $idsi => $cuadro)
                          <tr>
                            <td>
                              <input type="checkbox" value="{{ $cuadro->id }}" {{ $esavis->patologicoesavis->pluck('id')->contains($cuadro->id) ? 'checked' : '' }} name="cuadropatologicos[]">
                            </td>
                            <td>&nbsp;{{ $cuadro->descripcion }}</td>                            
                          </tr>
                          @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="34" name="otro_cuadro" id="otro_cuadro" class="form-control">
                      </div>
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Enfermedades Prevalentes en la Region</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($enfermedadregiones as $ide => $eregion)
                          <tr>
                            <td>
                              <input type="checkbox" value="{{ $eregion->id }}" {{ $esavis->enfermedadesavis->pluck('id')->contains($eregion->id) ? 'checked' : '' }} name="enfregiones[]">
                            </td>
                            <td>&nbsp;{{ $eregion->descripcion }}</td>
                          </tr>
                          @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="35" name="otro_enfermedad" id="otro_enfermedad" class="form-control">
                      </div>
                    </div>
                    <!-- /.box-col -->
                    <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
                    <input type="hidden" name="id_esavi" id="id_esavi" value="{{$id_esavi}}">
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box-primary -->
              </div>
              <!-- /.box-panel -->
              <div class="box-body">
                <div class="form-group col-sm-12">
                  {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
                    <a href="{!! route('esavis.listar_antecedentes',[$id, $dni]) !!}" class="btn btn-danger">Cancelar</a>
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
