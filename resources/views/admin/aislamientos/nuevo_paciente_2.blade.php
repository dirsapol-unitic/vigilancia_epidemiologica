@extends('layouts.master_ficha')
@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store']) !!}
            <div class="panel panel-primary filterable" >
                <div class="panel-heading">
                    <h3 class="panel-title">DATOS DEL PACIENTE - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row col-sm-12">
                            <div class="form-group <?php  if($paciente->sw==false) echo 'col-sm-6'; else echo'col-sm-10'?>">
                                <label>IPRESS:</label> <br/>
                                @if(Auth::user()->rol!=1)                    
                                    <input type="text" readonly="" tabindex="2" name="ipress" id="ipress" class="form-control" value="{{Auth::user()->nombre_establecimiento}}">
                                @else
                                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="id_establecimiento" id="id_establecimiento">
                                        <option value="">- Seleccione -</option>
                                        @foreach($establecimientos as $dep)
                                            <option value="{{$dep->id}}" <?php if(Auth::user()->establecimiento_id==$dep->id)echo "selected='selected'";?>>{{$dep->nombre}}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <input type="hidden" name="id_establecimiento" id="id_establecimiento" value="{{Auth::user()->establecimiento_id}}">
                                <input type="hidden" name="id_user" id="id_user" value="{{Auth::user()->id}}">
                                <!--input type="hidden" name="age" id="age" value="{{$paciente->age}}"-->
                                
                                <input type="hidden" name="foto" id="foto">
                            </div>
                            @if($paciente->sw==false)
                            <div class="form-group col-sm-2">
                                <!--label>Fecha de Emision DNI:</label><br/>
                                <input readonly type="date" tabindex="3"  required="" name="fecha_emision" id="fecha_emision" class="form-control" value="{{$paciente->fechaExpedicion}}"-->
                                <label>Menor de Edad</label><br/>
                                <select class="form-control select2" tabindex="10" required="" name="menor" onchange="getTutor();" id="menor">
                                    <option value="">- Seleccione -</option>
                                    <option value="SI"> SI </option>
                                    <option value="NO"> NO </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2" id="divmenor">
                                <!--label>Fecha de Emision DNI:</label><br/>
                                <input readonly type="date" tabindex="3"  required="" name="fecha_emision" id="fecha_emision" class="form-control" value="{{$paciente->fechaExpedicion}}" -->
                                <label>Titular del Menor</label><br/>
                                <select class="form-control select2" tabindex="10" name="tutor" id="tutor">
                                    <option value="PADRE"> PADRE </option>
                                    <option value="MADRE"> MADRE </option>
                                </select>
                            </div>
                            @endif
                        </div>
                        <div class="row col-sm-12">
                            <div class="form-group col-sm-2">
                                <label>Documento</label><br/>
                                <input type="text" required="" readonly=""  tabindex="4" name="dni" id="dni" value="{{$paciente->nrodocafiliado}}" class="form-control" maxlength="11">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Nombres</label> <br/>
                                <input type="text" required=""  tabindex="5" name="name" id="name" value="{{$paciente->nomafiliado}}" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Apellido Paterno</label><br/>
                                <input type="text" required="" tabindex="6" name="paterno"  value="{{$paciente->apepatafiliado}}" id="paterno" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Apellido Materno</label><br/>
                                <input type="text" required="" tabindex="7" name="materno" value="{{$paciente->apematafiliado}}" id="materno" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Situacion</label><br/>
                                <input readonly="" type="text" tabindex="7" name="situacion" id="situacion" value="{{$paciente->situacion}}" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>CIP</label> <br/>
                                <input type="text"  tabindex="8" readonly="" name="cip" id="cip" value="{{$paciente->cip}}" class="form-control" maxlength="8">
                            </div>
                        </div>
                        <div class="row col-sm-12">
                            <div class="form-group col-sm-2">
                                <label>Grado</label><br/>
                                <input type="text"  tabindex="9" readonly="" name="grado" id="grado" value="{{$paciente->grado}}" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Sexo ('M' o 'F')</label><br/>
                                <select class="form-control select2" tabindex="10"  required="" name="sexo" id="sexo">
                                    <option value="0">- Seleccione -</option>
                                    <option value="M" <?php if($paciente->nomsexo == 'M')echo "selected='selected'";?>> M </option>
                                    <option value="F" <?php if($paciente->nomsexo == 'F')echo "selected='selected'";?>> F </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Fec. Nac.(dd/mm/aaaa)</label><br/>
                                <input required=""  type="date" tabindex="11" name="fecha_nacimiento" value="{{$paciente->fecnacafiliado}}" id="fecha_nacimiento" class="form-control" maxlength="10">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Edad</label><br/>
                                <input required="" type="text" tabindex="12" name="edad"  value="{{$paciente->age}}" id="edad" class="form-control" maxlength="10">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Usuario</label><br/>
                                <input type="text" tabindex="13" readonly=""  name="parentesco" id="parentesco" value="{{$paciente->parentesco}}" class="form-control">
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
                        </div>
                        <div class="row col-sm-12">
                            <div class="form-group col-sm-8">
                                <label>Unidad</label><br/>
                                <input type="text" tabindex="15" name="unidad" readonly="" id="unidad" value="{{$paciente->unidad}}" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Peso (kilogramos)</label><br/>
                                <input type="text" tabindex="16" name="peso" id="peso" maxlength="5" class="form-control">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Talla (METROS)</label><br/>
                                <input type="text" tabindex="17" name="talla" id="talla" value="{{$paciente->estatura}}" class="form-control" maxlength="3">
                            </div>
                        </div>
                        <div class="row col-sm-12">
                            <div class="form-group col-sm-6">
                                <label>Domicilio Actual:</label><br/>
                                <input type="text" required="" tabindex="18"  value="{{$paciente->domicilio}}" name="domicilio" id="domicilio" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Referencia del Domicilio:</label><br/>
                                <input type="text" tabindex="19"  name="referencia" id="referencia" class="form-control">
                            </div>
                        </div>
                        <div class="row col-sm-12">
                            <div class="row col-sm-10">
                                <div class="row col-sm-12">
                                    <div class="form-group col-sm-2">
                                        <label>Tipo de Localidad:</label><br/>
                                        <select class="form-control select2" tabindex="20" name="tipo_localidad" id="tipo_localidad">
                                            <option value="0">- Seleccione -</option>
                                            <option value="1"> Urbano </option>
                                            <option value="2"> Periurbano </option>
                                            <option value="3"> Rural </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Departamento:</label><br/>
                                        <select class="form-control select2" tabindex="21" required="" name="id_departamento" id="id_departamento">
                                        <option value="">- Seleccione -</option>
                                        @foreach($departamentos as $dep)
                                            <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Provincia:</label><br/>
                                        <select class="form-control select2" tabindex="22" required="" name="id_provincia" id="id_provincia">
                                            <option value="">-Seleccione-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Distrito:</label><br/>
                                        <select class="form-control select2" tabindex="23" required="" name="id_distrito" id="id_distrito">
                                            <option value="">-Seleccione-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Telefono</label> <br/>
                                        <input type="text" name="telefono" tabindex="24" id="telefono" maxlength="9" class="form-control">
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <div class="form-group col-sm-4">
                                        <label>Etnia o raza:</label><br/>
                                        <select class="form-control select2" tabindex="25" onchange="getOtraRaza();" name="etnia" id="etnia">
                                            <option value="0">- Seleccione -</option>
                                            <option value="1"> Mestizo </option>
                                            <option value="2"> Andino </option>
                                            <option value="3"> Afrodescendiente </option>
                                            <option value="4"> Indigena Amazonico </option>
                                            <option value="5"> Asiatico descendiente </option>
                                            <option value="6"> Otro </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Nacionalidad:</label><br/>
                                        <select class="form-control select2" onchange="getOtraNacionalidad();" tabindex="26" name="nacionalidad" id="nacionalidad">
                                            <option value="0">- Seleccione -</option>
                                            <option selected value="1"> Peruano </option>
                                            <option value="2"> Extranjero </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Migrante:</label><br/>
                                        <select class="form-control select2" tabindex="27" onchange="getOtroMigrante();" name="migrante" id="migrante">
                                            <option value="0">- Seleccione -</option>
                                            <option value="SI"> SI </option>
                                            <option selected value="NO"> NO </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <div class="form-group col-sm-4 " id="divetnia" style="display:none">
                                        <label>Registrar Raza:</label><br/>
                                        <input type="text" tabindex="28" name="otra_raza" id="otra_raza" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-4" id="divnacion" style="display:none">
                                        <label>Registrar Nacion:</label><br/>
                                        <input type="text" tabindex="29" name="otra_nacion" id="otra_nacion" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-4" id="divmigrante" style="display:none">
                                        <label>Registrar Migrante:</label><br/>
                                        <input type="text" tabindex="30" name="otro_migrante" id="otro_migrante" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
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
                                                <?php if(($ocupacione->id==1)&&($paciente->est==1)) echo 'checked';?>
                                                name="ocupaciones[]">
                                            </td>
                                            <td>&nbsp;{{ $ocupacione->descripcion }}</td>                            
                                        </tr>
                                    @endforeach
                                </table>
                                <label>Otro, especificar:</label><br/>
                                <input type="text" tabindex="32" name="otra_ocupacion" id="otra_ocupacion" class="form-control">
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
        {!! Form::close() !!}
    </div>

@endsection