@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral')
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <div class="nav-tabs-custom">
        <div class="content">
          <div class="clearfix"></div>
          @include('flash::message')        
          <div class="clearfix"></div>
          <div class="box-body">
            {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_antecedentes']) !!}
              <div class="panel panel-primary filterable" >
                <div class="panel-heading">
                    <h3 class="panel-title">ANTECEDENTES EPIDEMIOLOGICA</h3>
                </div> 
                <div class="box box-primary">
                  <div class="box-body">
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-3">
                        <label>Clasificacion del caso:</label><br/>
                        <select class="form-control select2" tabindex="1" required="" name="id_clasificacion" id="id_clasificacion">
                            <option value="0">- Seleccione -</option>
                            <option value="1"> Confirmado </option>
                            <option value="2"> Probable </option>
                            <option value="3"> Sospechoso </option>
                            <option value="4"> Descartado </option>
                        </select>
                      </div>
                      <div class="form-group col-sm-3">
                        <label>Tipo del caso:</label><br/>
                        <select class="form-control select2" tabindex="1" required="" name="id_tipo_caso" id="id_tipo_caso" onchange="getTipoCaso();">
                            <option value="0">- Seleccione -</option>
                            <option value="1"> Sintomatico </option>
                            <option value="2"> Asintomatico </option>
                        </select>
                      </div>
                      <div class="form-group col-sm-3" id="divtipocaso">
                          <label>Fecha  de inicio de sintomas</label><br/>
                          <input type="date" tabindex="28"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                      </div>
                      <div class="form-group col-sm-3">
                          <label>Fecha  de inicio de aislamiento</label><br/>
                          <input type="date" tabindex="29"  name="fecha_aislamiento" id="fecha_aislamiento" class="form-control">
                      </div>
                    </div>
                    <!-- /.box-col -->
                    <div class="row col-sm-12">
                      <label>Lugar probable de infeccion:</label><br/>
                      <div class="form-group col-sm-4">
                        <label>Departamento:</label><br/>
                        <select class="form-control select2" tabindex="30" required="" name="id_departamento" id="id_departamento">
                          <option value="">- Seleccione -</option>
                          @foreach($departamentos2 as $dep)
                          <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Provincia:</label><br/>
                        <select class="form-control select2" tabindex="31" required="" name="id_provincia" id="id_provincia">
                            <option value="">-Seleccione-</option>
                        </select>
                      </div>
                      <div class="form-group col-sm-4">
                        <label>Distrito:</label><br/>
                        <select class="form-control select2" tabindex="32" required="" name="id_distrito" id="id_distrito">
                          <option value="">-Seleccione-</option>
                        </select>
                      </div>
                    </div>
                    <!-- /.box-col -->
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Sintomas</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($sintomas as $ids => $sintoma)
                            <tr>
                              <td>
                                <input 
                                  type="checkbox" 
                                  value="{{ $sintoma->id }}" 
                                  
                                  {{ $antecedentes->sintomaantecedentes->pluck('id')->contains($sintoma->id) ? 'checked' : '' }}
                                  name="sintomas[]">
                              </td>
                              <td>&nbsp;{{ $sintoma->descripcion }}</td>                            
                            </tr>
                          @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="33" name="otro_sintoma" id="otro_sintoma" class="form-control">
                      </div>
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Signos</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($signos as $idsi => $signo)
                          <tr>
                            <td>
                              <input type="checkbox" value="{{ $signo->id }}" {{ $antecedentes->signoantecedentes->pluck('id')->contains($signo->id) ? 'checked' : '' }} name="signos[]">
                            </td>
                            <td>&nbsp;{{ $signo->descripcion }}</td>                            
                          </tr>
                          @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="34" name="otro_signo" id="otro_signo" class="form-control">
                      </div>
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Condiciones de Comorbilidad o factores de Riesgo</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($factorriesgos as $idf => $friesgo)
                          <tr>
                            <td>
                              <input type="checkbox" value="{{ $friesgo->id }}" {{ $antecedentes->factorantecedentes->pluck('id')->contains($friesgo->id) ? 'checked' : '' }} name="factorriesgos[]">
                            </td>
                            <td>&nbsp;{{ $friesgo->descripcion }}</td>
                          </tr>
                          @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="35" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
                      </div>
                    </div>
                    <!-- /.box-col -->
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-4">
                        <br/>
                        <label>Has tenido contacto directo con un caso sospechoso, probable o confirmado en los 14 dias previos al inicio de los sintomas?</label> 
                        <br/>
                        <select class="form-control select2" tabindex="37" onchange="getOtroContacto();" name="contacto_directo" id="contacto_directo">
                          <option value="0">- Seleccione -</option>
                          <option value="SI"> SI </option>
                          <option value="NO"> NO </option>
                          <option value="3">Desconocido</option>
                        </select>
                        <div class="col-md-12 etiqueta" id="divcontacto_directo"><br/>
                          <table><?php $x=1; ?>
                            @foreach($lugares as $idl => $lugar)
                            <tr>
                              <td>
                                <input type="checkbox" value="{{ $lugar->id }}" {{ $antecedentes->lugarantecedentes->pluck('id')->contains($lugar->id) ? 'checked' : '' }} name="lugar[]">
                              </td>
                              <td>&nbsp;{{ $lugar->descripcion }}</td>
                            </tr>
                            @endforeach
                          </table>
                        </div>
                      </div>
                      <div class="form-group col-sm-4">
                          <br/>
                          <label>Ficha de Investigacion Epidemiologica / Ficha Contacto</label> 
                          <br/>
                          <select class="form-control select2" tabindex="38" name="ficha_contacto" id="ficha_contacto">
                              <option value="0">- Seleccione -</option>
                              <option value="SI"> SI </option>
                              <option value="NO"> NO </option>
                          </select>
                          <br/><br/>
                      </div>
                      <div class="form-group col-sm-4">
                        @if($paciente->sexo=='F')
                          <label>Gestante ?</label> 
                          <br/>
                          <select class="form-control select2" tabindex="43" style="width: 100%" name="gestante" id="gestante" onchange="getGestante();">
                              <option value="0">- Seleccione -</option>
                              <option value="1" > SI </option>
                              <option value="2" > NO </option>
                          </select>
                          <br/><br/>
                          <div  id="divgestacion" style="display:none">
                            <label>Nro de semana de gestacion:</label><br/>
                            <input type="text" tabindex="43" name="semana_gestacion" maxlength="2" id="semana_gestacion" class="form-control">
                          </div>
                        @endif
                      </div>
                    </div>
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-4">
                        <label>Vacunado contra la COVID-19?</label>
                        <br/>
                        <select class="form-control select2" tabindex="43" name="covid" id="covid" onchange="getCovid();">
                            <option value="0">- Seleccione -</option>
                            <option value="1" > SI </option>
                            <option value="2" > NO </option>
                        </select>
                        <br/><br/>
                      </div>
                    </div>
                    <div class="row col-sm-12">
                      <div  id="divcovid" style="display:none">
                        <div class="table-responsive" >
                        <br />
                        <table class="table table-bordered table-striped" id="ejemplo1" cellspacing="0" width="100%" style="margin-top:5px;">
                          <tbody>
                              <tr>
                                <td><b>1 dosis</b></td>
                                <td><b>Fecha de Vacunacion</b></td>
                                <td><input type="date" tabindex="3"   name="fecha_vacunacion_1" id="fecha_vacunacion_1" class="form-control"></td>
                                <td><b>Tipo de Vacuna</b></td>
                                <td>
                                  <select class="form-control select2" style="width: 100%" tabindex="4" name="fabricante_1" id="fabricante_1">
                                      <option value="">- Seleccione -</option>
                                      @foreach($fabricantes as $fabricante)
                                          <option value="{{$fabricante->descripcion}}">{{$fabricante->descripcion}}</option>
                                      @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td><b>2 dosis</b></td>
                                <td><b>Fecha de Vacunacion</b></td>
                                <td>
                                  <input type="date" tabindex="3"  name="fecha_vacunacion_2" id="fecha_vacunacion_2" class="form-control">
                                </td>
                                <td><b>Tipo de Vacuna</b></td>
                                <td>
                                  <select class="form-control select2" style="width: 100%" tabindex="4" name="fabricante_2" id="fabricante_2">
                                      <option value="">- Seleccione -</option>
                                      @foreach($fabricantes as $fabricante)
                                          <option value="{{$fabricante->descripcion}}">{{$fabricante->descripcion}}</option>
                                      @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td><b>3 Dosis</b></td>
                                <td><b>Fecha de Vacunacion</b></td>
                                <td>
                                  <input type="date" tabindex="3"  name="fecha_vacunacion_3" id="fecha_vacunacion_3" class="form-control">
                                </td>
                                <td><b>Tipo de Vacuna</b></td>
                                <td>
                                  <select class="form-control select2" style="width: 100%" tabindex="4" name="fabricante_3" id="fabricante_3">
                                    <option value="">- Seleccione -</option>
                                    @foreach($fabricantes as $fabricante)
                                     <option value="{{$fabricante->descripcion}}">{{$fabricante->descripcion}}</option>
                                    @endforeach
                                 </select>
                                </td>
                              </tr>
                              <tr>
                                <td><b>Dosis adicional</b></td>
                                <td><b>Fecha de Vacunacion</b></td>
                                <td>
                                  <input type="date" tabindex="3"  name="fecha_vacunacion_4" id="fecha_vacunacion_4" class="form-control">
                                </td>
                                <td><b>Tipo de Vacuna</b></td>
                                <td>
                                  <select class="form-control select2" style="width: 100%" tabindex="4" name="fabricante_4" id="fabricante_4">
                                    <option value="">- Seleccione -</option>
                                    @foreach($fabricantes as $fabricante)
                                     <option value="{{$fabricante->descripcion}}">{{$fabricante->descripcion}}</option>
                                    @endforeach
                                 </select>
                                </td>
                              </tr>
                          </tbody>
                      </table>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>Es caso de reinfeccion?</label> 
                      <br/>
                      <select class="form-control select2" tabindex="39" name="caso_reinfeccion" id="caso_reinfeccion"  onchange="getReinfeccion();">
                          <option value="0">- Seleccione -</option>
                          <option value="SI"> SI </option>
                          <option value="NO"> NO </option>
                      </select>
                      <br/>
                      <br/>
                    </div>
                    <div class="col-md-12">
                      <div  id="divreinfeccion" style="display:none">
                        <div class="form-group col-sm-12">
                          <div class="form-group col-sm-4">
                            <label>Presento sintomas</label>
                            <br/>
                            <select class="form-control select2" tabindex="29" style="width: 100%" name="sintoma_reinfeccion" id="sintoma_reinfeccion">
                                  <option value="">- Seleccione -</option>
                                  <option value="SI"> SI </option>
                                  <option value="NO"> NO </option>
                            </select>
                            <br/>
                          </div>
                          <div class="form-group col-sm-4">
                            <label>Fecha  de inicio de sintomas</label><br/>
                            <input type="date" tabindex="30"  name="fecha_sintoma_reinfeccion" id="fecha_sintoma_reinfeccion" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                          </div>
                        </div>
                        <div class="form-group col-sm-12">
                          <div class="form-group col-sm-4">
                            <label>Prueba confirmatoria inicial</label>
                            <br/>
                            <select class="form-control select2" tabindex="31" style="width: 100%" name="prueba_confirmatoria" id="prueba_confirmatoria">
                                <option value="0">- Seleccione -</option>
                                <option value="1"> Prueba Molecular </option>
                                <option value="2"> Prueba Antigeno </option>
                                <option value="3"> Prueba Serologica </option>
                            </select>
                          </div>
                          <div class="form-group col-sm-4">
                            <label>Fecha  de resultado</label><br/>
                            <input type="date" tabindex="32"  name="fecha_resultado_reinfeccion" id="fecha_resultado_reinfeccion" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                          </div>
                          <div class="form-group col-sm-4">
                            <label>Clasificacion de reinfeccion</label><br/>
                            <select class="form-control select2" tabindex="33" style="width: 100%" name="clasificacion_reinfeccion" id="clasificacion_reinfeccion">
                              <option value="0">- Seleccione -</option>
                              <option value="1"> Reinfeccion Sospechosa </option>
                              <option value="2"> Reinfeccion Probable </option>
                              <option value="3"> Reinfeccion Confirmada </option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row col-sm-12">
                        <label>Observaciones</label> <br/>                                
                        <textarea rows="10" type="text" tabindex="41" name="observacion" id="observacion" class="ckeditor"></textarea>                                
                        <br/><br/><br/>
                    </div>
                    <!-- /.box-col -->
                    <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box-primary -->
              </div>
              <!-- /.box-panel -->
              <div class="box-body">
                <div class="form-group col-sm-12">
                  {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
                    <a href="{!! route('aislamientos.listar_antecedentes_epidemiologicos',[$id, $dni]) !!}" class="btn btn-danger">Cancelar</a>
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

