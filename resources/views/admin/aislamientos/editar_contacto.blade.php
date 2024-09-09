@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral_opciones')
    </div>
    <div class="col-md-10">
      <div class="panel panel-primary filterable" >
        <div class="panel-heading">
            <h3 class="panel-title">CONTACTO - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
        </div>
        <div class="clearfix"></div>
        @include('flash::message')        
        <div class="clearfix"></div>
          {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_contacto']) !!}
            <div class="box-body">
              <div class="row col-sm-12">
                  <div class="form-group col-sm-3">
                      <label>DNI</label><br/>
                      <input type="text" required="" tabindex="68" name="dni_contacto" id="dni_contacto" class="form-control" maxlength="8" value="<?php echo $dni_contacto;?>">
                  </div>
                  <div class="form-group col-sm-3">
                      <label>Nombres</label> <br/>
                      <input type="text" required=""  tabindex="69" name="name_contacto" id="name_contacto" class="form-control" value="<?php echo $name_contacto;?>">
                  </div>
                  <div class="form-group col-sm-3">
                      <label>Apellido Paterno</label><br/>
                      <input type="text" required="" tabindex="70" name="paterno_contacto" id="paterno_contacto" class="form-control" value="<?php echo $paterno_contacto;?>">
                  </div>
                  <div class="form-group col-sm-3">
                      <label>Apellido Materno</label><br/>
                      <input type="text" required="" tabindex="71" name="materno_contacto" id="materno_contacto" class="form-control" value="<?php echo $materno_contacto;?>">
                  </div>
              </div>
              <div class="row col-sm-12">
                  <div class="form-group col-sm-2">
                          <label>Sexo</label><br/>
                          <select class="form-control select2" tabindex="72" required="" style="width: 100%" name="sexo_contacto" id="sexo_contacto">
                              <option value="0">- Seleccione -</option>
                              <option value="M" <?php if($sexo_contacto == 'M')echo "selected='selected'";?>> M </option>
                              <option value="F" <?php if($sexo_contacto == 'F')echo "selected='selected'";?>> F </option>
                          </select>
                      </div>
                  <div class="form-group col-sm-3">
                      <label>Fec. Nac.(dd/mm/aaaa)</label><br/>
                      <input type="date" tabindex="73"   name="fecha_nacimiento_contacto" id="fecha_nacimiento_contacto" class="form-control" maxlength="10" value="<?php echo $fecha_nacimiento_contacto;?>">
                  </div>
                  <div class="form-group col-sm-3">
                      <label>Correo</label><br/>
                      <input type="text" tabindex="74"   name="correo_contacto" id="correo_contacto" class="form-control" maxlength="50" value="<?php echo $correo_contacto;?>">
                  </div>
                  <div class="form-group col-sm-3">
                      <label>Telefono</label> <br/>
                      <input type="text"  onKeyPress="return soloNumeros(event)" name="telefono_contacto" tabindex="75" id="telefono_contacto" maxlength="9" class="form-control" value="<?php echo $telefono_contacto;?>">
                  </div>
              </div>
              <div class="row col-sm-12">
                  <div class="row col-sm-12">
                      <div class="form-group col-sm-6">
                          <label>Direccion de residencia actual:</label><br/>
                          <input type="text" tabindex="76" name="domicilio_contacto" id="domicilio_contacto" class="form-control" value="<?php echo $domicilio_contacto;?>">
                      </div>
                      <div class="form-group col-sm-2">
                          <label>Departamento:</label><br/>
                          <select class="form-control select2" tabindex="77" required="" style="width: 100%" name="id_departamento_contacto" id="id_departamento_contacto">
                          <option value="">- Seleccione -</option>
                          @foreach($departamentos3 as $dep)
                          <option value="{{$dep->id}}" <?php if($id_departamento_contacto == $dep->id)echo "selected='selected'";?> >{{$dep->nombre}}</option>
                          @endforeach
                      </select>
                      </div>
                      <div class="form-group col-sm-2">
                          <label>Provincia:</label><br/>
                          <select class="form-control select2" tabindex="78" required="" style="width: 100%" name="id_provincia_contacto" id="id_provincia_contacto">
                              <option value="">-Seleccione-</option>
                              @foreach($provincias3 as $prov)
                              <option value="{{$prov->id}}" <?php if($id_provincia_contacto == $prov->id)echo "selected='selected'";?> >{{$prov->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group col-sm-2">
                          <label>Distrito:</label><br/>
                          <select class="form-control select2" tabindex="79" required="" style="width: 100%" name="id_distrito_contacto" id="id_distrito_contacto">
                              <option value="">-Seleccione-</option>
                              @foreach($distritos3 as $dist)
                                  <option value="{{$dist->id}}" <?php if($id_distrito_contacto == $dist->id)echo "selected='selected'";?> >{{$dist->nombre}}</option>
                              @endforeach
                          </select>
                      </div>

                  </div>
              </div>
              <div class="row col-sm-12">
                  <div class="row col-sm-6">
                      <div class="form-group col-sm-6">
                          <label>Tipo de Contacto:</label><br/>
                          <select class="form-control select2" tabindex="80" required="" style="width: 100%" onchange="getTipoContacto();" name="tipo_contacto" id="tipo_contacto">
                              <option value="0" <?php if($tipo_contacto == "0")echo "selected='selected'";?>>- Seleccione -</option>
                              <option value="1" <?php if($tipo_contacto == "1")echo "selected='selected'";?>> Familiar </option>
                              <option value="2" <?php if($tipo_contacto == "2")echo "selected='selected'";?>> Centro Laboral </option>
                              <option value="3" <?php if($tipo_contacto == "3")echo "selected='selected'";?>> Centro de Estudio </option>
                              <option value="4" <?php if($tipo_contacto == "4")echo "selected='selected'";?>> EESS </option>
                              <option value="5" <?php if($tipo_contacto == "5")echo "selected='selected'";?>> Evento Social </option>
                              <option value="6" <?php if($tipo_contacto == "6")echo "selected='selected'";?>> Atención medica domiciliaria </option>
                              <option value="7" <?php if($tipo_contacto == "7")echo "selected='selected'";?>> Otro </option>
                          </select>                            
                          <br/><br/><br/>
                          <label>Fecha  de contacto</label><br/>
                          <input type="date" tabindex="81"  required="" name="fecha_contacto" id="fecha_contacto" class="form-control" value="<?php echo $fecha_contacto;?>" >
                              <br/><br/>
                          <label>Fecha  de inicio de cuarentena</label><br/>
                          <input type="date" tabindex="82"  name="fecha_cuarentena_contacto" id="fecha_cuarentena_contacto" class="form-control" value="<?php echo $fecha_cuarentena_contacto;?>" >
                              <br/><br/>
                          <label>EL CONTACTO ES UN CASO SOSPECHOSO?</label> 
                              <br/>
                          <select class="form-control select2" tabindex="83" style="width: 100%" onchange="getOtroContacto();" required="" name="contacto_sospechoso" id="contacto_sospechoso">
                              <option value="0" <?php if($contacto_sospechoso =="0")echo "selected='selected'";?>>- Seleccione -</option>
                              @foreach($sinos as $si)
                                  <option value="{{$si->id}}" <?php if($contacto_sospechoso == $si->id)echo "selected='selected'";?> >{{$si->descripcion}}</option>
                                  @endforeach
                              <option value="3" <?php if($contacto_sospechoso == "3")echo "selected='selected'";?>>Desconocido</option>
                          </select>
                      </div>
                      <div class="form-group col-sm-6 " id="divcontacto">
                          <label>Otro Tipo de Contacto:</label><br/>
                          <input type="text" tabindex="84" name="tipo_contacto_sospechoso" id="tipo_contacto_sospechoso" class="form-control" value="<?php echo $tipo_contacto_sospechoso;?>">
                      </div>
                      <input type="hidden" name="dni_paciente_contacto" id="dni_paciente_contacto" value="<?php echo $paciente->dni?>">
                      <input type="hidden" name="id_paciente_contacto" id="id_paciente_contacto" value="<?php echo $paciente->id?>">
                      <input type="hidden" name="id_contacto" id="id_contacto" value="<?php echo $id_contacto?>">
                      <input type="hidden" name="idficha" id="idficha" value="<?php echo $idficha?>">
                      <input type="hidden" name="opcion" id="opcion" value="contacto">
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
                                              
                                              {{ $contacto->factorcontactos->pluck('id')->contains($friesgo->id) ? 'checked' : '' }}
                                              name="factorriesgos_contacto[]">
                                  </td>
                                  <td>&nbsp;{{ $friesgo->descripcion }}</td>                            
                              </tr>
                              @endforeach
                          </table>
                          <label>Otro, especificar:</label><br/>
                          <input type="text" tabindex="86" name="otro_factor_riesgo_contacto" id="otro_factor_riesgo_contacto" class="form-control" value="<?php echo $otro_factor_riesgo_contacto;?>">
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
      </div>
    </div>
  </div>
</div>

@endsection

