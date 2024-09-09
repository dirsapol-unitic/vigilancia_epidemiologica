<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-sm-10">
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
                    <input type="text" required="" readonly=""  tabindex="4" name="dni" id="dni" value="{{$paciente->nrodocafiliado}}" class="form-control" maxlength="8">
                </div>
                <div class="form-group col-sm-3">
                    <label>Nombres</label> <br/>
                    <input type="text" required="" readonly=""  tabindex="5" name="name" id="name" value="{{$paciente->nomafiliado}}" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Apellido Paterno</label><br/>
                    <input type="text" required="" readonly=""  tabindex="6" name="paterno"  value="{{$paciente->apepatafiliado}}" id="paterno" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Apellido Materno</label><br/>
                    <input type="text" required="" readonly="" tabindex="7" name="materno" value="{{$paciente->apematafiliado}}" id="materno" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Situacion</label><br/>
                    <input readonly="" type="text" tabindex="7" name="situacion" id="situacion" value="{{$paciente->situacion}}" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>CIP</label> <br/>
                    <input type="text"  tabindex="8" name="cip" id="cip" value="{{$paciente->cip}}" class="form-control" maxlength="8">
                </div>
                <div class="form-group col-sm-3">
                    <label>Grado</label><br/>
                    <input type="text"  tabindex="9" name="grado" id="grado" value="{{$paciente->grado}}" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Sexo ('M' o 'F')</label><br/>
                    <select class="form-control select2" tabindex="7" required="" name="sexo" id="sexo">
                        <option value="0">- Seleccione -</option>
                        <option value="M" <?php if($paciente->nomsexo == 'M')echo "selected='selected'";?>> M </option>
                        <option value="F" <?php if($paciente->nomsexo == 'F')echo "selected='selected'";?>> F </option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Fec. Nac.(dd/mm/aaaa)</label><br/>
                    <input type="text" tabindex="11"  required="" name="fecha_nacimiento" value="{{$paciente->fecnacafiliado}}" id="fecha_nacimiento" class="form-control" maxlength="10">
                </div>
                <div class="form-group col-sm-2">
                    <label>Parentesco</label><br/>
                    <input type="text" tabindex="12" name="parentesco" id="parentesco" value="{{$paciente->parentesco}}" class="form-control">
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="form-group col-sm-4">
                    <label>Unidad</label><br/>
                    <input type="text" tabindex="13" name="unidad" id="unidad" value="{{$paciente->unidad}}" class="form-control">
                </div>
                <div class="form-group col-sm-2">
                    <label>Categoria</label><br/>
                    <select class="form-control select2" tabindex="14" required=""  name="id_categoria" id="id_categoria">
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
                    <input type="text" tabindex="16" name="talla" id="talla" value="{{$paciente->estatura}}" class="form-control" maxlength="3">
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
                        <option selected value="1"> Peruano </option>
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
                    <option selected value="NO"> NO </option>
                    
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
                    <input type="text" tabindex="24"  value="{{$paciente->domicilio}}" name="domicilio" id="domicilio" class="form-control">
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
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('aislamientos.buscar_paciente') !!}" class="btn btn-danger">Cancelar</a>
    </div>
</div>