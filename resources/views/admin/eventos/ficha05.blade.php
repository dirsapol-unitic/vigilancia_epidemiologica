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
                <div class="form-group col-sm-3">
                    <label>Sexo ('M' o 'F')</label><br/>
                    <input type="text" required="" tabindex="10" name="sexo" id="sexo" class="form-control" maxlength="1">
                </div>
                <div class="form-group col-sm-3">
                    <label>Fec. Nac.(dd/mm/aaaa)</label><br/>
                    <input type="text" tabindex="11"  required="" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" maxlength="10">
                </div>
                <div class="form-group col-sm-3">
                    <label>Correo</label><br/>
                    <input type="text" tabindex="11"  required="" name="correo" id="correo" class="form-control" maxlength="10">
                </div>
                <div class="form-group col-sm-3">
                    <label>Telefono</label> <br/>
                    <input type="text" required="" onKeyPress="return soloNumeros(event)" name="telefono" tabindex="12" id="telefono" maxlength="9" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="row col-sm-12">
                    <div class="form-group col-sm-6">
                        <label>Direccion de residencia actual:</label><br/>
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
                <div class="row col-sm-6">
                    <div class="form-group col-sm-6">
                        <label>Tipo de Contacto:</label><br/>
                        <select class="form-control select2" tabindex="18" required="" onchange="getTipoContacto();" name="contacto" id="contacto">
                            <option value="0">- Seleccione -</option>
                            <option value="1"> Familiar </option>
                            <option value="2"> Centro Laboral </option>
                            <option value="3"> Centro de Estudio </option>
                            <option value="4"> EESS </option>
                            <option value="5"> Evento Social </option>
                            <option value="6"> Atención medica domiciliaria </option>
                            <option value="7"> Otro </option>
                        </select>                            
                        <br/><br/><br/>
                        <label>Fecha  de contacto</label><br/>
                        <input type="date" tabindex="26"  required="" name="fecha_contacto" id="fecha_contacto" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                        <br/><br/>
                        <label>Fecha  de inicio de cuarentena</label><br/>
                        <input type="date" tabindex="26"  required="" name="fecha_cuarentena" id="fecha_aislamiento" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                        <br/><br/>
                        <label>EL CONTACTO ES UN CASO SOSPECHOSO?</label> 
                        <br/>
                        <select class="form-control select2" tabindex="30" onchange="getOtroContacto();" required="" name="contacto_directo" id="contacto_directo">
                            <option value="0">- Seleccione -</option>
                            @foreach($sinos as $si)
                            <option value="{{$si->id}}">{{$si->descripcion}}</option>
                            @endforeach
                            <option value="3">Desconocido</option>
                        </select>

                    </div>
                    <div class="form-group col-sm-6 " id="divcontacto">
                        <label>Otro Tipo de Contacto:</label><br/>
                        <input type="text" required="" tabindex="17" name="tipo_contacto" id="tipo_contacto" class="form-control">
                    </div>
                </div>
                <div class="row col-sm-6">
                    <div class="form-group col-sm-12">
                        <br/>
                        <label>Factor de Riesgo y comorbilidad</label> 
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
                </div>
            </div>
            
            <div class="row col-sm-12">
                
            </div>
            <div class="row col-sm-12">
                
                <div class="form-group col-sm-4">
                    
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