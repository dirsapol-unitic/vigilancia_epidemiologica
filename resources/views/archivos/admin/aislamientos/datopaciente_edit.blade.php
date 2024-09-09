<div class="box box-success">
    <div class="box-body">
        <div class="row col-sm-12">
            <div class="form-group col-sm-3">
                <label>DNI</label><br/>
                <input type="text" required="" tabindex="1" name="dni" id="dni" class="form-control" maxlength="8" value="{{$paciente->dni}}">
            </div>
            <div class="form-group col-sm-3">
                <label>Nombres</label> <br/>
                <input type="text" required=""  tabindex="2" name="name" id="name" class="form-control" value="{{$paciente->nombres}}">
            </div>
            <div class="form-group col-sm-3">
                <label>Apellido Paterno</label><br/>
                <input type="text" required="" tabindex="3" name="paterno" id="paterno" class="form-control" value="{{$paciente->paterno}}">
            </div>
            <div class="form-group col-sm-3">
                <label>Apellido Materno</label><br/>
                <input type="text" required="" tabindex="4" name="materno" id="materno" class="form-control" value="{{$paciente->materno}}">
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-3">
                <label>CIP</label> <br/>
                <input type="text" required="" tabindex="5" name="cip" id="cip" class="form-control" maxlength="8" value="{{$paciente->cip}}">
            </div>
            <div class="form-group col-sm-3">
                <label>Grado</label><br/>
                <input type="text" required="" tabindex="6" name="grado" id="grado" class="form-control" value="{{$paciente->grado}}">
            </div>
            <div class="form-group col-sm-2">
                <label>Sexo ('M' o 'F')</label><br/>
                <select class="form-control select2" tabindex="7" required="" name="sexo" id="sexo">
                    <option value="0">- Seleccione -</option>
                    <option value="M" <?php if($paciente->sexo == 'M')echo "selected='selected'";?>> M </option>
                    <option value="F" <?php if($paciente->sexo == 'F')echo "selected='selected'";?>> F </option>
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label>Fec. Nac.(dd/mm/aaaa)</label><br/>
                <input type="text" tabindex="8"  required="" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" maxlength="10" value="{{$paciente->fecha_nacimiento}}">
            </div>
            <div class="form-group col-sm-2">
                <label>Parentesco</label><br/>
                <input type="text" required="" tabindex="9" name="parentesco" id="parentesco" class="form-control" value="{{$paciente->parentesco}}">
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-3">
                <label>Unidad</label><br/>
                <input type="text" required="" tabindex="10" name="unidad" id="unidad" class="form-control" value="{{$paciente->unidad}}">
            </div>
            <div class="form-group col-sm-3">
                <label>Categoria</label><br/>
                <select class="form-control select2" tabindex="11" required="" name="id_categoria" id="id_categoria">
                <option value="">- Seleccione -</option>
                @foreach($pnpcategorias as $cat)
                <option value="{{$cat->id}}" <?php if($paciente->id_categoria == $cat->id)echo "selected='selected'";?>>{{$cat->nombre}}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group col-sm-2">
                <label>Peso (gramos)</label><br/>
                <input type="text" required="" tabindex="12" name="peso" id="peso" maxlength="5" class="form-control" value="{{$paciente->peso}}">
            </div>
            <div class="form-group col-sm-2">
                <label>Talla (centimetros)</label><br/>
                <input type="text" required="" tabindex="13" name="talla" id="talla" class="form-control" maxlength="3" value="{{$paciente->talla}}">
            </div>
            <div class="form-group col-sm-2">
                <label>Telefono</label> <br/>
                <input type="text" name="telefono" tabindex="14" id="telefono" maxlength="9" class="form-control" value="{{$paciente->telefono}}">
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-2">
                <label>Etnia o raza:</label><br/>
                <select class="form-control select2" tabindex="15" required="" name="etnia" id="etnia">
                    <option value="0">- Seleccione -</option>
                    <option value="1" <?php if($paciente->etnia == 1)echo "selected='selected'";?>> Mestizo </option>
                    <option value="2" <?php if($paciente->etnia == 2)echo "selected='selected'";?>> Andino </option>
                    <option value="3" <?php if($paciente->etnia == 3)echo "selected='selected'";?>> Afrodescendiente </option>
                    <option value="4" <?php if($paciente->etnia == 4)echo "selected='selected'";?>> Indigena Amazonico </option>
                    <option value="5" <?php if($paciente->etnia == 5)echo "selected='selected'";?>> Asiatico descendiente </option>
                    <option value="6" <?php if($paciente->etnia == 6)echo "selected='selected'";?>> Otro </option>
                </select>
            </div>
            @if($paciente->etnia == 6)
            <div class="form-group col-sm-2 ">
                <label>Registrar Raza:</label><br/>
                <input type="text" tabindex="16" name="otra_raza" id="otra_raza" class="form-control" value="{{$paciente->otra_raza}}">
            </div>
            @endif
            <div class="form-group col-sm-2">
                <label>Nacionalidad:</label><br/>
                <select class="form-control select2" tabindex="17" required="" name="nacionalidad" id="nacionalidad">
                    <option value="0">- Seleccione -</option>
                    <option value="1" <?php if($paciente->nacionalidad == 1)echo "selected='selected'";?>> Peruano </option>
                    <option value="2" <?php if($paciente->nacionalidad == 2)echo "selected='selected'";?>> Extranjero </option>
                </select>
            </div>
            @if($paciente->otra_nacion == 2)
            <div class="form-group col-sm-2" style="display:none">
                <label>Registrar Nacion:</label><br/>
                <input type="text" tabindex="18" name="otra_nacion" id="otra_nacion" class="form-control" value="{{$paciente->otra_nacion}}">
            </div>
            @endif
            <div class="form-group col-sm-2">
                <label>Migrante:</label><br/>
                <select class="form-control select2" tabindex="19" onchange="getOtroMigrante();"required="" name="migrante" id="migrante">
                <option value="0">- Seleccione -</option>
                <option value="SI" <?php if($paciente->migrante == 'SI')echo "selected='selected'";?>> SI </option>
                <option value="NO" <?php if($paciente->migrante == 'NO')echo "selected='selected'";?>> NO </option>
                
            </select>
            </div>
            @if($paciente->otro_migrante == 'SI')
            <div class="form-group col-sm-2" style="display:none">
                <label>Registrar Nacion:</label><br/>
                <input type="text" tabindex="20" name="otro_migrante" id="otro_migrante" class="form-control" value="{{$paciente->otro_migrante}}">
            </div>
            @endif
        </div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-6">
                <label>Domicilio:</label><br/>
                <input type="text" tabindex="21" name="domicilio" id="domicilio" class="form-control" value="{{$paciente->domicilio}}">
            </div>
            <div class="form-group col-sm-2">
                <label>Departamento:</label><br/>
                <select class="form-control select2" tabindex="22" required="" name="id_departamento" id="id_departamento">
                <option value="">- Seleccione -</option>
                @foreach($departamentos as $dep)
                <option value="{{$dep->id}}" <?php if($paciente->id_departamento == $dep->id)echo "selected='selected'";?> >{{$dep->nombre}}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group col-sm-2">
                <label>Provincia:</label><br/>
                <select class="form-control select2" tabindex="23" required="" name="id_provincia" id="id_provincia">
                    <option value="">-Seleccione-</option>
                    @foreach($provincias as $prov)
                    <option value="{{$prov->id}}" <?php if($paciente->id_provincia == $prov->id)echo "selected='selected'";?> >{{$prov->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label>Distrito:</label><br/>
                <select class="form-control select2" tabindex="24" required="" name="id_distrito" id="id_distrito">
                <option value="">-Seleccione-</option>
                @foreach($distritos as $dist)
                    <option value="{{$dist->id}}" <?php if($paciente->id_distrito == $dist->id)echo "selected='selected'";?> >{{$dist->nombre}}</option>
                @endforeach
            </select>
            </div>
        </div>
    </div>
</div>  
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
    </div>
</div>



 

