
<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">ANTECEDENTES EPIDEMIOLOGICA</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-4">
                    <label>Clasificacion del caso:</label><br/>
                    <select class="form-control select2" tabindex="1" required="" name="id_clasificacion" id="id_clasificacion">
                        <option value="0">- Seleccione -</option>
                        <option value="1"> Confirmado </option>
                        <option value="2"> Probable </option>
                        <option value="3"> Sospechoso </option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label>Fecha  de inicio de sintomas</label><br/>
                    <input type="date" tabindex="28"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-4">
                    <label>Fecha  de inicio de aislamiento</label><br/>
                    <input type="date" tabindex="29"  name="fecha_aislamiento" id="fecha_aislamiento" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
            </div>
            <div class="row col-sm-12">
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
                                    <input 
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
                    <input type="text" tabindex="34" name="otro_signo" id="otro_signo" class="form-control">
                </div>
                <div class="form-group col-sm-4">
                    <br/>
                    <label>Factor de Riesgo</label> 
                    <br/>                
                    <table><?php $x=1; ?>
                        @foreach($factorriesgos as $idf => $friesgo)
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
                    <input type="text" tabindex="35" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
                </div>
                
                <div class="row col-sm-12">
                    <div class="form-group col-sm-4">
                        <br/>
                        <label>Ocupaciones</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                            @foreach($ocupaciones as $ido => $ocupacione)
                                <tr>
                                    <td>
                                        <input 
                                        type="checkbox" 
                                        value="{{ $ocupacione->id }}"                                         
                                        {{ $antecedentes->ocupacioneantecedentes->pluck('id')->contains($ocupacione->id) ? 'checked' : '' }}
                                        name="ocupaciones[]">
                                    </td>
                                    <td>&nbsp;{{ $ocupacione->descripcion }}</td>                            
                                </tr>
                            @endforeach
                        </table>
                        <label>Otro, especificar:</label><br/>
                        <input type="text" tabindex="36" name="otra_ocupacion" id="otra_ocupacion" class="form-control">
                    </div>
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
                        <label>Es caso de reinfeccion?</label> 
                        <br/>
                        <select class="form-control select2" tabindex="39" name="caso_reinfeccion" id="caso_reinfeccion">
                            <option value="0">- Seleccione -</option>
                            <option value="SI"> SI </option>
                            <option value="NO"> NO </option>
                        </select>
                        <br/><br/>
                        <label>Lugar o Ubicacion actual en la IPRESS</label> <br/>
                        <select class="form-control select2" tabindex="40" name="servicio_hospitalizacion" id="servicio_hospitalizacion">
                                <option value="0">- Seleccione -</option>
                                <option value="1">Emergencia</option>
                                <option value="2">UCI</option>
                                <option value="3">UST</option>
                                <option value="4">UVI</option>
                                <option value="5">Hospitalizado</option>
                        </select><br/><br/>
                    </div>
                </div>
                <div class="col-md-12">                
                    <label>Indicacion de aislamiento</label> <br/>                                
                    <textarea rows="10" type="text" tabindex="41" name="indicacion" id="indicacion" class="ckeditor"></textarea>                                
                    <br/><br/><br/>
                </div>
                <div class="col-md-12">                
                    <label>Motivo del aislamiento</label> <br/>                                
                    <textarea rows="10" type="text" tabindex="42" name="observacion" id="observacion" class="ckeditor"></textarea>                                
                    <br/><br/><br/>
                </div>
                <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
            </div>
        </div>
    </div>  
</div>  
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('aislamientos.listar_antecedentes',[$id, $dni]) !!}" class="btn btn-danger">Cancelar</a>
    </div>
</div>