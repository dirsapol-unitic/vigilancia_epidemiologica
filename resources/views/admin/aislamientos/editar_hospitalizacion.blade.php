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
      <div class="panel panel-primary filterable" >
        <div class="panel-heading">
            <h3 class="panel-title">HOSPITALIZACION - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
        </div>
        <div class="clearfix"></div>
        @include('flash::message')        
        <div class="clearfix"></div>
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_hospitalizacion']) !!}
          
            <div class="box-body">
              <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                  <label>Referido:</label><br/>
                  <select class="form-control select2" tabindex="11" style="width: 100%" required="" name="referido" id="referido" onchange="getReferido2();">
                      <option value="">- Seleccione -</option>
                      <option value="1" <?php if($referido == 1)echo "selected='selected'";?>>SI</option>
                      <option value="2" <?php if($referido == 2)echo "selected='selected'";?>>NO</option>
                  </select>
                </div>
                @if($referido == 1)
                  <div class="form-group col-sm-10" id="divreferido2" style="display:none">
                    <div   class="form-group col-sm-8">
                      <label>IPRESS de donde Proviene:</label><br/>
                      <select class="form-control select2" style="width: 100%" tabindex="4" name="establecimiento_salud_proviene" id="establecimiento_salud_proviene">
                          <option value="">- Seleccione -</option>
                          @foreach($establecimiento_salud as $dep)
                          <option value="{{$dep->id}}" <?php if($establecimiento_proviene == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Fecha  Referencia</label><br/>
                      <input type="date" tabindex="3" name="fecha_referencia" id="fecha_referencia" class="form-control" value="<?php echo $fecha_referencia; ?>" >
                    </div>
                  </div>
                @else
                  <div class="form-group col-sm-10" id="divreferido" style="display:none">
                    <div   class="form-group col-sm-8">
                      <label>IPRESS de donde Proviene:</label><br/>
                      <select class="form-control select2" style="width: 100%" tabindex="4" name="establecimiento_salud_proviene" id="establecimiento_salud_proviene"> 
                          <option value="">- Seleccione -</option>
                          @foreach($establecimiento_salud as $dep)
                            <option value="{{$dep->id}}" <?php if($establecimiento_proviene == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Fecha  Referencia</label><br/>
                      <input type="date" tabindex="3" name="fecha_referencia" id="fecha_referencia" class="form-control">
                    </div>
                  </div>
                @endif
              </div>
              <div class="row col-sm-12">
                <div class="form-group col-sm-3">
                    <label>Fecha  de Hospitalizacion</label><br/>
                    <input type="date" tabindex="3"  required="" name="fecha_hospitalizacion" id="fecha_hospitalizacion" class="form-control" value="<?php echo $fecha_hospitalizacion; ?>" >
                </div>
                @if($referido == 1)
                <div class="form-group col-sm-6">
                    <label>Ipress donde se encuentra Hospitalizado:</label><br/>
                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="establecimiento_salud" id="establecimiento_salud">
                        <option value="">- Seleccione -</option>
                        @foreach($establecimiento_salud as $dep)
                        <option value="{{$dep->id}}" <?php if($establecimiento_actual == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="form-group col-sm-6">
                    <label>Ipress donde se encuentra Hospitalizado:</label><br/>
                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="establecimiento_salud" id="establecimiento_salud">
                        <option value="">- Seleccione -</option>
                        @foreach($establecimiento_salud as $dep)
                        <option value="{{$dep->id}}" <?php if($establecimiento_actual == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group col-sm-3">
                    <label>Tipo de Nombre Seguro:</label><br/>
                    <select class="form-control select2" tabindex="11" style="width: 100%" required="" name="tipo_seguro" id="tipo_seguro">
                        <option value="1" <?php if($tipo_seguro == 1)echo "selected='selected'";?>>Saludpol</option>
                        <option value="2" <?php if($tipo_seguro == 2)echo "selected='selected'";?>>Essalud</option>
                    </select>
                </div>
              </div>
              <div class="row col-sm-12">
                <div class="form-group col-sm-12">
                  <label>Diagnostico de ingreso:</label><br/>
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
              </div>
              <div class="row col-sm-12">
                <div class="form-group col-sm-4">
                  <br/>
                  <label>Signos</label> 
                  <br/>                
                  <table><?php $x=1; ?>
                    @foreach($signos as $id => $signo)
                    <tr>
                      <td>
                        <input
                          type="checkbox"
                          value="{{ $signo->id }}"
                          {{ $pac_hospitalizado->signohospitalizados->pluck('id')->contains($signo->id) ? 'checked' : '' }}
                          name="signos_hospitalizacion[]">
                      </td>
                      <td>&nbsp;{{ $signo->descripcion }}</td>                            
                    </tr>
                    @endforeach
                  </table>
                  <label>Otro, especificar:</label><br/>
                  <input type="text" tabindex="7" name="otro_signo_ho" value="<?php echo $otro_signo_ho; ?>" id="otro_signo_ho" class="form-control">
                </div>
                 
                <div class="form-group col-sm-4">
                  <label>El caso esta o estuvo intubado en algun momento durante la enfermedad? </label> <br/>
                  <select class="form-control select2" tabindex="9" required="" style="width: 100%" name="intubado" id="intubado">
                      <option value="2" <?php if($intubado == 2)echo "selected='selected'";?>>NO</option>
                      <option value="1" <?php if($intubado == 1)echo "selected='selected'";?>>SI</option>
                  </select>
                     
                      
                  <br/><br/>
                  <label>El paciente estuvo en ventilacion mecanica</label> <br/>
                  <select class="form-control select2" tabindex="10" required="" style="width: 100%" name="ventilacion_mecanica" id="ventilacion_mecanica">
                      <option value="2" <?php if($ventilacion_mecanica == 2)echo "selected='selected'";?>>NO</option>
                      <option value="1" <?php if($ventilacion_mecanica == 1)echo "selected='selected'";?>>SI</option>
                      <option value="3" <?php if($ventilacion_mecanica == 3)echo "selected='selected'";?>>Desconocido</option>
                  </select><br/><br/>
                  
                </div>
                <div class="form-group col-sm-4">
                  <label>El caso tiene o tuvo diasgnotico de neumonia durante la enfermedad?</label> <br/>
                  <select class="form-control select2" tabindex="11" required="" style="width: 100%" name="neumonia" id="neumonia">
                      <option value="2" <?php if($neumonia == 2)echo "selected='selected'";?>>NO</option>
                      <option value="1" <?php if($neumonia == 1)echo "selected='selected'";?>>SI</option>
                  </select><br/><br/>
                  
                  <label>El paciente presento IAAS? </label> <br/>
                  <select class="form-control select2" tabindex="11" style="width: 100%" required="" name="iaas" id="iaas">
                      <option value="2" <?php if($iaas == 2)echo "selected='selected'";?>>NO</option>
                      <option value="1" <?php if($iaas == 1)echo "selected='selected'";?>>SI</option>
                      <option value="3" <?php if($iaas == 3)echo "selected='selected'";?>>Desconocido</option>
                  </select>
                </div>
              </div>
              <div class="row col-sm-12">
                <div class="form-group col-sm-12">
                  <label>Lugar de Hospitalizacion</label> <br/>
                  <div class="row col-sm-12">
                    <div class="form-group col-sm-4">                    
                      <label>UNIDAD DE CUIDADOS INTENSIVOS</label>
                    </div>
                    <div class="form-group col-sm-8">
                      <div class="form-group col-sm-4">
                        <label>Fecha de Ingreso:</label><br/>
                        <input type="date" tabindex="3" name="fecha_ingreso_s2" id="fecha_ingreso_s2" class="form-control" value="<?php echo $fecha_ingreso_s2; ?>" >
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Fecha de Alta:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_alta_s2" id="fecha_alta_s2" class="form-control" value="<?php echo $fecha_alta_s2; ?>" >
                      </div>
                    </div>
                  </div>
                  <div class="row col-sm-12">
                    <div class="form-group col-sm-4">                    
                      <label>UNIDAD DE CUIDADOS INTERMEDIOS</label>
                    </div>
                    <div class="form-group col-sm-8">
                      <div class="form-group col-sm-4">
                        <label>Fecha de Ingreso:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_ingreso_s3" id="fecha_ingreso_s3" class="form-control" value="<?php echo $fecha_ingreso_s3; ?>" >
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Fecha de Alta:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_alta_s3" id="fecha_alta_s3" class="form-control" value="<?php echo $fecha_alta_s3; ?>" >
                      </div>
                    </div>
                  </div>
                  <div class="row col-sm-12">
                    <div class="form-group col-sm-4">                    
                      <label>TRAUMA SHOCK</label> <br/>
                    </div>
                    <div class="form-group col-sm-8">
                      <div class="form-group col-sm-4">
                        <label>Fecha de Ingreso:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_ingreso_s4" id="fecha_ingreso_s4" class="form-control" value="<?php echo $fecha_ingreso_s4; ?>" >
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Fecha de Alta:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_alta_s4" id="fecha_alta_s4" class="form-control" value="<?php echo $fecha_alta_s4; ?>" >
                      </div>
                    </div>
                  </div>
                  <div class="row col-sm-12">
                    <div class="form-group col-sm-4">                    
                      <label>SALA DE AISLAMIENTO</label> <br/>
                    </div>
                    <div class="form-group col-sm-8">
                      <div class="form-group col-sm-4">
                        <label>Fecha de Ingreso:</label><br/>
                        <input type="date" tabindex="3" name="fecha_ingreso_s5" id="fecha_ingreso_s5" class="form-control" value="<?php echo $fecha_ingreso_s5; ?>" >
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Fecha de Alta:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_alta_s5" id="fecha_alta_s5" class="form-control" value="<?php echo $fecha_alta_s5; ?>" >
                      </div>
                    </div>
                  </div>
                  <div class="row col-sm-12">
                    <div class="form-group col-sm-4">                    
                      <label>OTRO</label> <br/>
                      <input type="text" tabindex="7" name="otra_ubicacion" value="<?php echo $otra_ubicacion?>" id="otra_ubicacion" class="form-control">
                    </div>
                    <div class="form-group col-sm-8">
                      <div class="form-group col-sm-4">
                        <label>Fecha de Ingreso:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_ingreso_s6" id="fecha_ingreso_s6" class="form-control" value="<?php echo $fecha_ingreso_s6; ?>" >
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Fecha de Alta:</label><br/>
                        <input type="date" tabindex="3"  name="fecha_alta_s6" id="fecha_alta_s6" class="form-control" value="<?php echo $fecha_alta_s6; ?>" >
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="dni_hospitalizacion" id="dni_hospitalizacion" value="<?php echo $paciente->dni?>">
                  <input type="hidden" name="id_paciente_hospitalizacion" id="id_paciente_hospitalizacion" value="<?php echo $paciente->id?>">
                  <input type="hidden" name="id_hospitalizacion" id="id_hospitalizacion" value="<?php echo $id_hospitalizacion?>">
                  <input type="hidden" name="idficha" id="idficha" value="<?php echo $idficha?>">
                  <input type="hidden" name="opcion" id="opcion" value="hospitalizacion">
                </div>
              </div>
              <div class="col-md-12">                
                <label>Observacion</label> <br/>                                
                <textarea rows="10" type="text" tabindex="44" name="observacion" id="observacion" class="ckeditor"><?php echo $observacion; ?></textarea>
                <br/><br/><br/>
              </div>
            </div>
            <div class="form-group col-sm-12">
              
              <div class="form-group col-sm-6">
                {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
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

