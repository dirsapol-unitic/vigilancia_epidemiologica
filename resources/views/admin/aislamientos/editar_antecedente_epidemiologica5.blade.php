@extends('layouts.master_ficha')
@section('content')
<div class="content">
  @include('flash::message')        
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral')
    </div>
    <div class="col-md-10">
      <div class="clearfix"></div>
      <div class="clearfix"></div>
      <div class="panel panel-primary filterable" >
        <div class="panel-heading">
            <h3 class="panel-title">ANTECEDENTE EPIDEMIOLOGICO DEL PACIENTE - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
        </div>    
                      <div class="box-body">
                           {!! Form::model($antecedentes, ['route' => ['aislamientos.update_antecedente_epidemiologico', $antecedentes->id], 'method' => 'patch','id'=>'frm_aislamientos','name'=>'frm_aislamientos']) !!}
                            <div class="box box-primary">
                              <div class="box-body">
                                  <div class="row col-sm-12">
                                    <div class="form-group col-sm-3">
                                      <label>Clasificacion del caso:</label><br/>
                                      <select class="form-control select2" tabindex="1" required="" name="id_clasificacion" id="id_clasificacion">
                                          <option value="">- Seleccione -</option>
                                          <option value="1" <?php if($antecedentes->id_clasificacion == 1)echo "selected='selected'";?>> Confirmado </option>
                                          <option value="2" <?php if($antecedentes->id_clasificacion == 2)echo "selected='selected'";?> > Probable </option>
                                          <option value="3" <?php if($antecedentes->id_clasificacion == 3)echo "selected='selected'";?> > Sospechoso </option>
                                          <option value="4" <?php if($antecedentes->id_clasificacion == 4)echo "selected='selected'";?> > Descartado </option>
                                      </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                      <label>Tipo del caso:</label><br/>
                                      <select class="form-control select2" tabindex="2" required="" onchange="getTipoCaso2();" name="id_tipo_caso" id="id_tipo_caso">
                                          <option value="">- Seleccione -</option>
                                          <option value="1" <?php if($antecedentes->id_tipo_caso == 1)echo "selected='selected'";?>> Sintomatico </option>
                                          <option value="2" <?php if($antecedentes->id_tipo_caso == 2)echo "selected='selected'";?>> Asintomatico </option>
                                      </select>
                                    </div>
                                    @if($antecedentes->id_tipo_caso  == 1)
                                      <div class="form-group col-sm-3" id="divtipocaso2">
                                          <label>Fecha  de inicio de sintomas</label><br/>
                                          <input type="date" tabindex="3"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="{{$antecedentes->fecha_sintoma}}" >
                                      </div>
                                    @else
                                    <div class="form-group col-sm-3" id="divtipocaso">
                                        <label>Fecha  de inicio de sintomas</label><br/>
                                        <input type="date" tabindex="3"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="{{$antecedentes->fecha_sintoma}}" >
                                    </div>
                                    @endif
                                    <div class="form-group col-sm-3">
                                        <label>Fecha  de inicio de aislamiento</label><br/>
                                        <input type="date" tabindex="4"  name="fecha_aislamiento" id="fecha_aislamiento" class="form-control" value="{{$antecedentes->fecha_aislamiento}}" >
                                    </div>
                                  </div>
                                  <div class="row col-sm-12">
                                    <label>Lugar probable de infeccion:</label><br/>
                                    <div class="form-group col-sm-4">
                                        <label>Departamento:</label><br/>
                                        <select class="form-control select2" tabindex="5" style="width: 100%"  required="" name="id_departamento2" id="id_departamento2">
                                        <option value="">- Seleccione -</option>
                                        @foreach($departamentos2 as $dep)
                                        <option value="{{$dep->id}}" <?php if($antecedentes->id_departamento2 == $dep->id)echo "selected='selected'";?> >{{$dep->nombre}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Provincia:</label><br/>
                                        <select class="form-control select2" tabindex="6" style="width: 100%"  required="" name="id_provincia2" id="id_provincia2">
                                            <option value="">-Seleccione-</option>
                                            @foreach($provincias2 as $prov)
                                            <option value="{{$prov->id}}" <?php if($antecedentes->id_provincia2 == $prov->id)echo "selected='selected'";?> >{{$prov->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                      <label>Distrito:</label><br/>
                                      <select class="form-control select2" tabindex="7" style="width: 100%" required="" name="id_distrito2" id="id_distrito2">
                                        <option value="">-Seleccione-</option>
                                        @foreach($distritos2 as $dist)
                                            <option value="{{$dist->id}}" <?php if($antecedentes->id_distrito2 == $dist->id)echo "selected='selected'";?> >{{$dist->nombre}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row col-sm-12">
                                      <div class="form-group col-sm-4">
                                          <br/>
                                          <label>Sintomas</label> 
                                          <br/>                
                                          <table><?php $x=1; 
                                              ?>
                                              @foreach($sintomas as $id => $sintoma)
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
                                          <input type="text" tabindex="8" name="otro_sintoma" id="otro_sintoma" class="form-control">
                                      </div>
                                      <div class="form-group col-sm-4">
                                          <br/>
                                          <label>Signos</label> 
                                          <br/>                
                                          <table><?php $x=1; ?>
                                              @foreach($signos as $id => $signo)
                                                  <tr>
                                                      <td><input 
                                                          type="checkbox" 
                                                          value="{{ $signo->id }}" 
                                                          
                                                          {{ $antecedentes->signoantecedentes->pluck('id')->contains($signo->id) ? 'checked' : '' }}
                                                          name="signos[]">
                                                      </td>
                                                      <td>&nbsp;{{ $signo->descripcion }}</td>                            
                                                  </tr>
                                              @endforeach
                                          </table>
                                          <label>Otro, especificar:</label><br/>
                                          <input type="text" tabindex="9" name="otro_signo" id="otro_signo" class="form-control">
                                      </div>
                                      <div class="form-group col-sm-4">
                                          <br/>
                                          <label>Factor de Riesgo</label> 
                                          <br/>                
                                          <table><?php $x=1; ?>
                                              @foreach($factorriesgos as $id => $friesgo)
                                                  <tr>
                                                      <td>
                                                          <input 
                                                          type="checkbox" 
                                                          value="{{ $friesgo->id }}" 
                                                          
                                                          {{ $antecedentes->factorantecedentes->pluck('id')->contains($friesgo->id) ? 'checked' : '' }}
                                                          name="factorriesgos[]">
                                                      </td>
                                                      <td>&nbsp;{{ $friesgo->descripcion }}</td>                            
                                                  </tr>
                                              @endforeach
                                          </table>
                                          <label>Otro, especificar:</label><br/>
                                          <input type="text" tabindex="10" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
                                      </div>
                                      
                                      <div class="row col-sm-12">
                                          <div class="form-group col-sm-4">
                                            <br/>
                                            <label>Has tenido contacto directo con un caso sospechoso, probable o confirmado en los 14 dias previos al inicio de los sintomas?</label> 
                                            <br/>
                                            <select class="form-control select2" tabindex="11" style="width: 100%" onchange="getOtroContacto2();" name="contacto_directo" id="contacto_directo">
                                                <option value="0">- Seleccione -</option>
                                                <option value="SI" <?php if($antecedentes->contacto_directo == 'SI')echo "selected='selected'";?>> SI </option>
                                                <option value="NO" <?php if($antecedentes->contacto_directo == 'NO')echo "selected='selected'";?>> NO </option>
                                                <option value="3" <?php if($antecedentes->contacto_directo == '3')echo "selected='selected'";?>>Desconocido</option>
                                            </select>
                                            @if($paciente->contacto_directo == 'SI')
                                            <div class="col-md-12 etiqueta" id="divcontacto_directo2"><br/>
                                              <table><?php $x=1; ?>
                                                @foreach($lugares as $id => $lugar)
                                                <tr>
                                                  <td>
                                                      <input 
                                                      type="checkbox" 
                                                      value="{{ $lugar->id }}"
                                                      {{ $antecedentes->lugarantecedentes->pluck('id')->contains($lugar->id) ? 'checked' : '' }}
                                                      name="lugar[]">
                                                  </td>
                                                  <td>&nbsp;{{ $lugar->descripcion }}</td>
                                                </tr>
                                                @endforeach
                                              </table>
                                            </div>
                                            @else
                                            <div class="col-md-12 etiqueta" id="divcontacto_directo"><br/>
                                              <table><?php $x=1; ?>
                                                @foreach($lugares as $id => $lugar)
                                                <tr>
                                                  <td>
                                                      <input 
                                                      type="checkbox" 
                                                      value="{{ $lugar->id }}"
                                                      {{ $antecedentes->lugarantecedentes->pluck('id')->contains($lugar->id) ? 'checked' : '' }}
                                                      name="lugar[]">
                                                  </td>
                                                  <td>&nbsp;{{ $lugar->descripcion }}</td>
                                                </tr>
                                                @endforeach
                                              </table>
                                            </div>
                                            @endif
                                          </div>
                                          <div class="form-group col-sm-4">
                                              <br/>
                                              <label>Ficha de Investigacion Epidemiologica / Ficha Contacto</label> 
                                              <br/>
                                              <select class="form-control select2" tabindex="14" style="width: 100%" name="ficha_contacto" id="ficha_contacto">
                                                  <option value="">- Seleccione -</option>
                                                  <option value="SI" <?php if($antecedentes->ficha_contacto == 'SI')echo "selected='selected'";?>> SI </option>
                                                  <option value="NO" <?php if($antecedentes->ficha_contacto == 'NO')echo "selected='selected'";?>> NO </option>
                                              </select>
                                              <br/><br/>
                                              
                                            </div>
                                          <div class="form-group col-sm-4"><br/>
                                            @if($paciente->sexo=='F')
                                              <label>Gestante ?</label> 
                                              <br/>
                                              <select class="form-control select2" tabindex="15" style="width: 100%" onchange="getGestante2();" name="gestante" id="gestante">
                                                  <option value="0">- Seleccione -</option>
                                                  <option value="1" <?php if($antecedentes->gestante == 1)echo "selected='selected'";?>> SI </option>
                                                  <option value="2" <?php if($antecedentes->gestante == 2)echo "selected='selected'";?>> NO </option>
                                              </select>
                                              <br/><br/>
                                              @if($antecedentes->gestante==1)
                                                <div class="col-md-12 etiqueta" id="divgestacion_directo2"><br/>
                                                  <label>Nro de semana de gestacion:</label><br/>
                                                  <input type="text" tabindex="16" name="semana_gestacion" id="semana_gestacion" value="<?php echo $antecedentes->semana_gestacion; ?>" class="form-control">
                                                </div>
                                              @else
                                                <div class="col-md-12 etiqueta" id="divgestacion"><br/>
                                                  <label>Nro de semana de gestacion:</label><br/>
                                                  <input type="text" tabindex="16" name="semana_gestacion" id="semana_gestacion" value="<?php echo $antecedentes->semana_gestacion; ?>" class="form-control">
                                                </div>
                                              @endif
                                            @endif
                                            <br/><br/>
                                          </div>
                                      </div>
                                      <div class="row col-sm-12">
                                        <div class="form-group col-sm-4">
                                          <label>Vacunado contra la COVID-19?</label>
                                          <br/>
                                          <select required=""  class="form-control select2" tabindex="17" name="covid" id="covid" onchange="getCovid2();">
                                              <option value="">- Seleccione -</option>
                                              <option value="1" <?php if($antecedentes->vacuna_covid == 'SI')echo "selected='selected'";?>> SI </option>
                                              <option value="2" <?php if($antecedentes->vacuna_covid == 'NO')echo "selected='selected'";?>> NO </option>
                                          </select>
                                          <br/><br/>
                                        </div>
                                      </div>

                                      <div class="row col-sm-12">
                                        <div  id="divcovid_directo2" style="display:none">
                                          <div class="table-responsive" >
                                          <br />
                                          <table class="table table-bordered table-striped" id="ejemplo1" cellspacing="0" width="100%" style="margin-top:5px;">
                                            <tbody>
                                                <tr>
                                                  <td><b>1 dosis</b></td>
                                                  <td><b>Fecha de Vacunacion</b></td>
                                                  <td><input type="date" tabindex="18"  name="fecha_vacunacion_1" id="fecha_vacunacion_1" class="form-control" value="<?php echo $antecedentes->fecha_vacunacion_1; ?>"></td>
                                                  <td><b>Tipo de Vacuna</b></td>
                                                  <td>
                                                    <select class="form-control select2" style="width: 100%" tabindex="19" name="fabricante_1" id="fabricante_1">
                                                        <option value="">- Seleccione -</option>
                                                        @foreach($fabricantes as $fabricante)
                                                          <option value="{{$fabricante->descripcion}}" <?php if($antecedentes->fabricante_1 == '$fabricante->descripcion')echo "selected='selected'";?> >{{$fabricante->descripcion}}</option>
                                                          </option>
                                                        @endforeach
                                                    </select>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td><b>2 dosis</b></td>
                                                  <td><b>Fecha de Vacunacion</b></td>
                                                  <td>
                                                    <input type="date" tabindex="20"  name="fecha_vacunacion_2" id="fecha_vacunacion_2" class="form-control" value="<?php echo $antecedentes->fecha_vacunacion_2; ?>">
                                                  </td>
                                                  <td><b>Tipo de Vacuna</b></td>
                                                  <td>
                                                    <select class="form-control select2" style="width: 100%" tabindex="21" name="fabricante_2" id="fabricante_2">
                                                        <option value="">- Seleccione -</option>
                                                        @foreach($fabricantes as $fabricante)
                                                          <option value="{{$fabricante->descripcion}}" <?php if($antecedentes->fabricante_2 == '$fabricante->descripcion')echo "selected='selected'";?> >{{$fabricante->descripcion}}</option>
                                                          </option>
                                                        @endforeach
                                                    </select>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td><b>3 dosis</b></td>
                                                  <td><b>Fecha de Vacunacion</b></td>
                                                  <td>
                                                    <input type="date" tabindex="22"  name="fecha_vacunacion_3" id="fecha_vacunacion_3" class="form-control" value="<?php echo $antecedentes->fecha_vacunacion_3; ?>">
                                                  </td>
                                                  <td><b>Tipo de Vacuna</b></td>
                                                  <td>
                                                    <select class="form-control select2" style="width: 100%" tabindex="23"  name="fabricante_3" id="fabricante_3">
                                                      <option value="">- Seleccione -</option>
                                                      @foreach($fabricantes as $fabricante)
                                                       <option value="{{$fabricante->descripcion}}" <?php if($antecedentes->fabricante_3 == '$fabricante->descripcion')echo "selected='selected'";?> >{{$fabricante->descripcion}}</option>
                                                          </option>
                                                      @endforeach
                                                   </select>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td><b>Dosis adicional</b></td>
                                                  <td><b>Fecha de Vacunacion</b></td>
                                                  <td>
                                                    <input type="date" tabindex="20"  name="fecha_vacunacion_4" id="fecha_vacunacion_4" class="form-control" value="<?php echo $antecedentes->fecha_vacunacion_4; ?>">
                                                  </td>
                                                  <td><b>Tipo de Vacuna</b></td>
                                                  <td>
                                                    <select class="form-control select2" style="width: 100%" tabindex="21" name="fabricante_4" id="fabricante_4">
                                                        <option value="">- Seleccione -</option>
                                                        @foreach($fabricantes as $fabricante)
                                                          <option value="{{$fabricante->descripcion}}" <?php if($antecedentes->fabricante_4 == '$fabricante->descripcion')echo "selected='selected'";?> >{{$fabricante->descripcion}}</option>
                                                          </option>
                                                        @endforeach
                                                    </select>
                                                  </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                      </div>
                                      
                                    </div>
                                    <div class="col-md-4">
                                      <label>Es caso de reinfeccion?</label> 
                                      <br/>
                                      <select class="form-control select2" tabindex="39" name="caso_reinfeccion" id="caso_reinfeccion"  onchange="getReinfeccion2();">
                                          <option value="0">- Seleccione -</option>
                                          <option value="SI" <?php if($antecedentes->caso_reinfeccion == 'SI')echo "selected='selected'";?>> SI </option>
                                          <option value="NO" <?php if($antecedentes->caso_reinfeccion == 'NO')echo "selected='selected'";?>> NO </option>
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
                                              <option value="SI" <?php if($antecedentes->sintoma_reinfeccion == 'SI')echo "selected='selected'";?>> SI </option>
                                              <option value="NO" <?php if($antecedentes->sintoma_reinfeccion == 'NO')echo "selected='selected'";?>> NO </option>
                                            </select>
                                            <br/>
                                          </div>
                                          <div class="form-group col-sm-4">
                                            <label>Fecha  de inicio de sintomas</label><br/>
                                            <input type="date" tabindex="30"  name="fecha_sintoma_reinfeccion" id="fecha_sintoma_reinfeccion" class="form-control" value="<?php echo date("Y-m-d", strtotime($antecedentes->fecha_sintoma_reinfeccion)); ?>" >
                                          </div>
                                        </div>
                                        <div class="col-md-12"> 
                                          <div class="form-group col-sm-4">
                                            <label>Prueba confirmatoria inicial</label>
                                            <br/>
                                            <select class="form-control select2" tabindex="31" style="width: 100%" name="prueba_confirmatoria" id="prueba_confirmatoria">
                                                <option value="0">- Seleccione -</option>
                                                <option value="1" <?php if($antecedentes->prueba_confirmatoria == '1')echo "selected='selected'";?>> Prueba Molecular </option>
                                                <option value="2" <?php if($antecedentes->prueba_confirmatoria == '2')echo "selected='selected'";?>> Prueba Antigeno </option>
                                                <option value="3" <?php if($antecedentes->prueba_confirmatoria == '3')echo "selected='selected'";?>> Prueba Serologica </option>
                                            </select>
                                          </div>
                                          <div class="form-group col-sm-4">
                                              <label>Fecha  de resultado</label><br/>
                                              <input type="date" tabindex="32"  name="fecha_resultado_reinfeccion" id="fecha_resultado_reinfeccion" class="form-control" value="<?php echo date("Y-m-d", strtotime($antecedentes->fecha_resultado_reinfeccion)); ?>" >
                                          </div>
                                          <div class="form-group col-sm-4">
                                              <label>Clasificacion de reinfeccion</label><br/>
                                              
                                            <select class="form-control select2" tabindex="33" style="width: 100%" name="clasificacion_reinfeccion" id="clasificacion_reinfeccion">
                                                <option value="0">- Seleccione -</option>
                                                <option value="1" <?php if($antecedentes->clasificacion_reinfeccion == '1')echo "selected='selected'";?>> Reinfeccion Sospechosa </option>
                                                <option value="2" <?php if($antecedentes->clasificacion_reinfeccion == '2')echo "selected='selected'";?>> Reinfeccion Probable </option>
                                                <option value="3" <?php if($antecedentes->clasificacion_reinfeccion == '3')echo "selected='selected'";?>> Reinfeccion Confirmada </option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">                
                                        <label>Observacion:</label> <br/>                                
                                        <textarea rows="10" type="text" tabindex="34" name="observacion" id="observacion" class="ckeditor"><?php echo $antecedentes->observacion;?></textarea>
                                        <input type="hidden" name="dni_antecedente" id="dni_antecedente" value="<?php echo $antecedentes->dni?>">
                                        <input type="hidden" name="id_paciente" id="id_paciente" value="<?php echo $id_paciente?>">
                                        <input type="hidden" name="opcion" id="opcion" value="antecedentes">
                                        <br/><br/><br/>
                                    </div>
                                  </div>
                              </div>
                          </div>  
                          @if($paciente->evolucion!='FALLECIO')
                          <div class="box-body">
                              <div class="form-group col-sm-12">
                                  {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
                              </div>
                          </div>
                          @endif
                        {!! Form::close() !!}
                      </div>
                  
                  <div class="text-center">
                  </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
