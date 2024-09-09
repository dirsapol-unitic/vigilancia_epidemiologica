 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-3">
                    <label>Fecha  de inicio de sintomas</label><br/>
                    <input type="date" tabindex="26"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="<?php echo date("Y-m-d", strtotime($antecedentes->fecha_sintoma)); ?>" >
                </div>
                <div class="form-group col-sm-3">
                    <label>Fecha  de inicio de aislamiento</label><br/>
                    <input type="date" tabindex="27"  name="fecha_aislamiento" id="fecha_aislamiento" class="form-control" value="<?php echo date("Y-m-d", strtotime($antecedentes->fecha_aislamiento)); ?>" >
                </div>
                <div class="form-group col-sm-2">
                    <label>Departamento:</label><br/>
                    <select class="form-control select2" tabindex="28" style="width: 100%"  required="" name="id_departamento2" id="id_departamento2">
                    <option value="">- Seleccione -</option>
                    @foreach($departamentos2 as $dep)
                    <option value="{{$dep->id}}" <?php if($antecedentes->id_departamento2 == $dep->id)echo "selected='selected'";?> >{{$dep->nombre}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Provincia:</label><br/>
                    <select class="form-control select2" tabindex="29" style="width: 100%"  required="" name="id_provincia2" id="id_provincia2">
                        <option value="">-Seleccione-</option>
                        @foreach($provincias2 as $prov)
                        <option value="{{$prov->id}}" <?php if($antecedentes->id_provincia2 == $prov->id)echo "selected='selected'";?> >{{$prov->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Distrito:</label><br/>
                    <select class="form-control select2" tabindex="30" style="width: 100%" required="" name="id_distrito2" id="id_distrito2">
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
                    <input type="text" tabindex="32" name="otro_sintoma" id="otro_sintoma" class="form-control">
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
                    <input type="text" tabindex="34" name="otro_signo" id="otro_signo" class="form-control">
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
                    <input type="text" tabindex="36" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
                </div>
                
                <div class="row col-sm-12">
                    <div class="form-group col-sm-4">
                        <br/>
                        <label>Ocupaciones</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                            @foreach($ocupaciones as $id => $ocupacione)
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
                        <input type="text" tabindex="38" name="otra_ocupacion" id="otra_ocupacion" class="form-control">
                    </div>
                    <div class="form-group col-sm-4">
                        <br/>
                        <label>Has tenido contacto directo con un caso sospechoso, probable o confirmado en los 14 dias previos al inicio de los sintomas?</label> 
                        <br/>
                        <select class="form-control select2" tabindex="39" style="width: 100%" onchange="getOtroContacto();" name="contacto_directo" id="contacto_directo">
                            <option value="0">- Seleccione -</option>
                            <option value="SI" <?php if($antecedentes->contacto_directo == 'SI')echo "selected='selected'";?>> SI </option>
                            <option value="NO" <?php if($antecedentes->contacto_directo == 'NO')echo "selected='selected'";?>> NO </option>
                            <option value="3" <?php if($antecedentes->contacto_directo == '3')echo "selected='selected'";?>>Desconocido</option>
                        </select>
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
                    </div>
                    <div class="form-group col-sm-4">
                        <br/>
                        <label>Ficha de Investigacion Epidemiologica / Ficha Contacto</label> 
                        <br/>
                        <select class="form-control select2" tabindex="41" style="width: 100%" name="ficha_contacto" id="ficha_contacto">
                            <option value="0">- Seleccione -</option>
                            <option value="SI" <?php if($antecedentes->ficha_contacto == 'SI')echo "selected='selected'";?>> SI </option>
                            <option value="NO" <?php if($antecedentes->ficha_contacto == 'NO')echo "selected='selected'";?>> NO </option>
                        </select>
                        <br/><br/>
                        <label>Es caso de reinfeccion?</label> 
                        <br/>
                        <select class="form-control select2" tabindex="42" style="width: 100%" name="caso_reinfeccion" id="caso_reinfeccion">
                            <option value="0">- Seleccione -</option>
                            <option value="SI" <?php if($antecedentes->caso_reinfeccion == 'SI')echo "selected='selected'";?>> SI </option>
                            <option value="NO" <?php if($antecedentes->caso_reinfeccion == 'NO')echo "selected='selected'";?>> NO </option>
                        </select>
                        <br/><br/>
                        <label>Lugar o Ubicacion actual en la IPRESS</label> <br/>
                        <select class="form-control select2" tabindex="43" style="width: 100%" name="ubicacion_hospitalizacion" id="ubicacion_hospitalizacion">
                                <option value="0">- Seleccione -</option>
                                <option value="1" <?php if($antecedentes->ubicacion_hospitalizacion == 1) echo "selected='selected'";?>>Emergencia</option>
                                <option value="2" <?php if($antecedentes->ubicacion_hospitalizacion == 2) echo "selected='selected'";?>>UCI</option>
                                <option value="3" <?php if($antecedentes->ubicacion_hospitalizacion == 3) echo "selected='selected'";?>>UST</option>
                                <option value="4" <?php if($antecedentes->ubicacion_hospitalizacion == 4) echo "selected='selected'";?>>UVI</option>
                                <option value="5" <?php if($antecedentes->ubicacion_hospitalizacion == 5) echo "selected='selected'";?>>Hospitalizado</option>
                        </select><br/><br/>
                    </div>
                </div>
                <div class="col-md-12">                
                    <label>Indicacion de aislamiento</label> <br/>                                
                    <textarea rows="10" type="text" tabindex="44" name="indicacion" id="indicacion" class="ckeditor"><?php echo $antecedentes->indicacion;?></textarea>                                
                    <br/><br/><br/>
                </div>
                <div class="col-md-12">                
                    <label>Motivo del aislamiento</label> <br/>                                
                    <textarea rows="10" type="text" tabindex="45" name="observacion" id="observacion" class="ckeditor"><?php echo $antecedentes->motivo;?></textarea> 
                    <input type="hidden" name="dni_antecedente" id="dni_antecedente" value="<?php echo $antecedentes->dni?>">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="<?php echo $id_paciente?>">
                    <input type="hidden" name="opcion" id="opcion" value="antecedentes">
                    <br/><br/><br/>
                </div>
                
            </div>
        </div>
    </div>  
    <div class="box-body">
        <div class="form-group col-sm-12">
            {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
        </div>
    </div>



 

