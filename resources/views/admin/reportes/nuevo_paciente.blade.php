<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label>Clasificacion del caso:</label><br/>
                    <select class="form-control select2" tabindex="1" required="" name="id_clasificacion" id="id_clasificacion">
                        <option value="0">- Seleccione -</option>
                        <option value="1"> Confirmado </option>
                        <option value="2"> Probable </option>
                        <option value="3"> Sospechoso </option>
                    </select>
                </div>
                <div class="form-group col-sm-7">
                    <label>IPRESS:</label> <br/>
                    <input type="text" readonly="" tabindex="2" name="ipress" id="ipress" class="form-control" value="{{Auth::user()->nombre_establecimiento}}">
                    <input type="hidden" name="id_establecimiento" id="id_establecimiento" value="{{Auth::user()->establecimiento_id}}">
                    <input type="hidden" name="id_user" id="id_user" value="{{Auth::user()->id}}">
                    <input type="hidden" name="edad" id="edad">
                    <input type="hidden" name="foto" id="foto">
                </div>
                <div class="form-group col-sm-2">
                    <label>Fecha de Notificacion:</label><br/>
                    <input readonly type="date" tabindex="3"  required="" name="fecha_registro" id="fecha_registro" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
            </div>
        </div>
    </div>  
</div>
<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">DATOS DEL PACIENTE</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>DNI</label><br/>
                    <input type="text" required="" tabindex="4" name="dni" id="dni" class="form-control" maxlength="8">
                </div>
                <div class="form-group col-sm-3">
                    <label>Nombres</label> <br/>
                    <input type="text" required=""  tabindex="5" name="name" id="name" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Apellido Paterno</label><br/>
                    <input type="text" required="" tabindex="6" name="paterno" id="paterno" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Apellido Materno</label><br/>
                    <input type="text" required="" tabindex="7" name="materno" id="materno" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Situacion</label><br/>
                    <input readonly="" type="text" tabindex="7" name="situacion" id="situacion" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>CIP</label> <br/>
                    <input type="text"  tabindex="8" name="cip" id="cip" class="form-control" maxlength="8">
                </div>
                <div class="form-group col-sm-3">
                    <label>Grado</label><br/>
                    <input type="text"  tabindex="9" name="grado" id="grado" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Sexo</label><br/>
                    <select class="form-control select2" tabindex="10" required="" name="sexo" id="sexo">
                        <option value="0">- Seleccione -</option>
                        <option value="M"> Masculino </option>
                        <option value="F"> Femenino </option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Fec. Nac.(dd/mm/aaaa)</label><br/>
                    <input type="text" tabindex="11"  required="" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" maxlength="10">
                </div>
                <div class="form-group col-sm-2">
                    <label>Parentesco</label><br/>
                    <input type="text" tabindex="12" name="parentesco" id="parentesco" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-4">
                    <label>Unidad</label><br/>
                    <input type="text" tabindex="13" name="unidad" id="unidad" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Categoria</label><br/>
                    <select class="form-control select2" tabindex="14" required="" name="id_categoria" id="id_categoria">
                    <option value="">- Seleccione -</option>
                    @foreach($pnpcategorias as $cat)
                    <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Peso (gramos)</label><br/>
                    <input type="text" tabindex="15" name="peso" id="peso" maxlength="5" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Talla (METROS)</label><br/>
                    <input type="text" tabindex="16" name="talla" id="talla" class="form-control" maxlength="10">
                </div>
                <div class="form-group col-sm-2">
                    <label>Telefono</label> <br/>
                    <input type="text" name="telefono" tabindex="17" id="telefono" maxlength="9" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>Etnia o raza:</label><br/>
                    <select class="form-control select2" tabindex="18" onchange="getOtraRaza();" name="etnia" id="etnia">
                        <option value="0">- Seleccione -</option>
                        <option value="1"> Mestizo </option>
                        <option value="2"> Andino </option>
                        <option value="3"> Afrodescendiente </option>
                        <option value="4"> Indigena Amazonico </option>
                        <option value="5"> Asiatico descendiente </option>
                        <option value="6"> Otro </option>
                    </select>
                </div>
                <div class="form-group col-sm-2 " id="divetnia">
                    <label>Registrar Raza:</label><br/>
                    <input type="text" tabindex="19" name="otra_raza" id="otra_raza" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Nacionalidad:</label><br/>
                    <select class="form-control select2" onchange="getOtraNacionalidad();" tabindex="20" name="nacionalidad" id="nacionalidad">
                        <option value="0">- Seleccione -</option>
                        <option value="1"> Peruano </option>
                        <option value="2"> Extranjero </option>
                    </select>
                </div>
                <div class="form-group col-sm-2" id="divnacion" style="display:none">
                    <label>Registrar Nacion:</label><br/>
                    <input type="text" tabindex="21" name="otra_nacion" id="otra_nacion" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Migrante:</label><br/>
                    <select class="form-control select2" tabindex="22" onchange="getOtroMigrante();" name="migrante" id="migrante">
                    <option value="0">- Seleccione -</option>
                    <option value="SI"> SI </option>
                    <option value="NO"> NO </option>
                    
                </select>
                </div>
                <div class="form-group col-sm-2" id="divmigrante" style="display:none">
                    <label>Registrar Nacion:</label><br/>
                    <input type="text" tabindex="23" name="otro_migrante" id="otro_migrante" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-6">
                    <label>Domicilio:</label><br/>
                    <input type="text" tabindex="24" name="domicilio" id="domicilio" class="form-control">
                </div>
                
                <div class="form-group col-sm-2">
                    <label>Departamento:</label><br/>
                    <select class="form-control select2" tabindex="25" required="" name="id_departamento" id="id_departamento">
                    <option value="">- Seleccione -</option>
                    @foreach($departamentos as $dep)
                    <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Provincia:</label><br/>
                    <select class="form-control select2" tabindex="26" required="" name="id_provincia" id="id_provincia">
                        <option value="">-Seleccione-</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Distrito:</label><br/>
                    <select class="form-control select2" tabindex="27" required="" name="id_distrito" id="id_distrito">
                    <option value="">-Seleccione-</option>
                </select>
                </div>
            </div>
        </div>
    </div>  
</div>  

<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">ANTECEDENTES EPIDEMIOLOGICA</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-3">
                    <label>Fecha  de inicio de sintomas</label><br/>
                    <input type="date" tabindex="28"  name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-3">
                    <label>Fecha  de inicio de aislamiento</label><br/>
                    <input type="date" tabindex="29"  name="fecha_aislamiento" id="fecha_aislamiento" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-2">
                    <label>Departamento:</label><br/>
                    <select class="form-control select2" tabindex="30" required="" name="id_departamento2" id="id_departamento2">
                    <option value="">- Seleccione -</option>
                    @foreach($departamentos as $dep)
                    <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Provincia:</label><br/>
                    <select class="form-control select2" tabindex="31" required="" name="id_provincia2" id="id_provincia2">
                        <option value="">-Seleccione-</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Distrito:</label><br/>
                    <select class="form-control select2" tabindex="32" required="" name="id_distrito2" id="id_distrito2">
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
                        @foreach($sintomas as $id => $sintoma)
                            <tr>
                                <td>
                                    <input 
                                    type="checkbox" 
                                    value="{{ $sintoma->id }}" 
                                    
                                    {{ $aislamientos->sintomaaislados->pluck('id')->contains($sintoma->id) ? 'checked' : '' }}
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
                        @foreach($signos as $id => $signo)
                            <tr>
                                <td>
                                    <input 
                                    type="checkbox" 
                                    value="{{ $signo->id }}" 
                                    
                                    {{ $aislamientos->signoaislados->pluck('id')->contains($signo->id) ? 'checked' : '' }}
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
                                    
                                    {{ $aislamientos->factoraislados->pluck('id')->contains($friesgo->id) ? 'checked' : '' }}
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
                            @foreach($ocupaciones as $id => $ocupacione)
                                <tr>
                                    <td>
                                        <input 
                                        type="checkbox" 
                                        value="{{ $ocupacione->id }}"                                         
                                        {{ $aislamientos->ocupacioneaislados->pluck('id')->contains($ocupacione->id) ? 'checked' : '' }}
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
                                @foreach($lugares as $id => $lugar)
                                    <tr>
                                        <td>
                                            <input 
                                            type="checkbox" 
                                            value="{{ $lugar->id }}"
                                            {{ $aislamientos->lugaraislados->pluck('id')->contains($lugar->id) ? 'checked' : '' }}
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
                
            </div>
        </div>
    </div>  
</div>  

 

<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('aislamientosite.index') !!}" class="btn btn-danger">Cancelar</a>
    </div>
</div>