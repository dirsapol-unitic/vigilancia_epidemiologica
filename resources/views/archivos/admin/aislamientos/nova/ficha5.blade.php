<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">PACIENTE COVID-19</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-sm-7">
                    <label>Nombre:</label> <br/>
                    <input type="text" readonly="" tabindex="1" name="ipress" id="ipress" class="form-control" value="">
                </div>
                <div class="form-group col-sm-2">
                    <label>Fecha de Registro:</label><br/>
                    <input readonly type="date" tabindex="0"  required="" name="fecha_reclamo" id="fecha_reclamo" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
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
                <div class="form-group col-sm-3">
                    <label>DNI</label><br/>
                    <input type="text" required="" tabindex="4" name="dni" id="dni" class="form-control" maxlength="8">
                </div>
                <div class="form-group col-sm-3">
                    <label>Nombres</label> <br/>
                    <input type="text" required=""  tabindex="5" name="name" id="name" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label>Apellido Paterno</label><br/>
                    <input type="text" required="" tabindex="6" name="paterno" id="paterno" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label>Apellido Materno</label><br/>
                    <input type="text" required="" tabindex="7" name="materno" id="materno" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="row col-sm-12">
                    <div class="form-group col-sm-6">
                        <label>Domicilio:</label><br/>
                        <input type="text" required=""tabindex="21" name="domicilio" id="domicilio" class="form-control">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Departamento:</label><br/>
                        <select class="form-control select2" tabindex="22" required="" name="id_departamento" id="id_departamento">
                        <option value="">- Seleccione -</option>
                        @foreach($departamentos as $dep)
                        <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Provincia:</label><br/>
                        <select class="form-control select2" tabindex="23" required="" name="id_provincia" id="id_provincia">
                            <option value="">-Seleccione-</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Distrito:</label><br/>
                        <select class="form-control select2" tabindex="24" required="" name="id_distrito" id="id_distrito">
                            <option value="">-Seleccione-</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>Etnia o raza:</label><br/>
                    <select class="form-control select2" tabindex="18" required="" onchange="getOtraRaza();" name="etnia" id="etnia">
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
                    <input type="text" required="" tabindex="17" name="otra_raza" id="otra_raza" class="form-control">
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
                    <input type="date" tabindex="25"  required="" name="fecha_sintoma" id="fecha_sintoma" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-3">
                    <label>Fecha  de inicio de aislamiento</label><br/>
                    <input type="date" tabindex="26"  required="" name="fecha_aislamiento" id="fecha_aislamiento" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-2">
                    <label>Departamento:</label><br/>
                    <select class="form-control select2" tabindex="27" required="" name="id_departamento2" id="id_departamento2">
                    <option value="">- Seleccione -</option>
                    @foreach($departamentos as $dep)
                    <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Provincia:</label><br/>
                    <select class="form-control select2" tabindex="28" required="" name="id_provincia2" id="id_provincia2">
                        <option value="">-Seleccione-</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Distrito:</label><br/>
                    <select class="form-control select2" tabindex="29" required="" name="id_distrito2" id="id_distrito2">
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
                    <input type="text" required="" tabindex="17" name="otro_sintoma" id="otro_sintoma" class="form-control">
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
                    <input type="text" required="" tabindex="17" name="otro_signo" id="otro_signo" class="form-control">
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
                    <input type="text" required="" tabindex="17" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
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
                        <input type="text" required="" tabindex="17" name="otra_ocupacion" id="otra_ocupacion" class="form-control">
                    </div>
                    <div class="form-group col-sm-8">
                        <br/>
                        <label>Has tenido contacto directo con un caso sospechoso, probable o confirmado en los 14 dias previos al inicio de los sintomas?</label> 
                        <br/>
                        <select class="form-control select2" tabindex="30" onchange="getOtroContacto();" required="" name="contacto_directo" id="contacto_directo">
                            <option value="0">- Seleccione -</option>
                            @foreach($sinos as $si)
                            <option value="{{$si->id}}">{{$si->descripcion}}</option>
                            @endforeach
                            <option value="3">Desconocido</option>
                        </select>
                        <div class="col-md-4 etiqueta" id="divcontacto_directo"><br/>
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