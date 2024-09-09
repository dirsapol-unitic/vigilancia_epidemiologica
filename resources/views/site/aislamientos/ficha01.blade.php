<div class="panel-heading">
        <div class="row">
            <div class="col-md-3">
                <?php $ruta='/images/logo-para-web_1.png'; ?>
                <img height="40%" width="40%" src="{!!url($ruta)!!}" alt="DIRECCIÓN DE SANIDAD POLICIAL - DIRSAPOL">
            </div>
            <div class="col-md-7">
                <br/><br/>
                <p align="center"><span style="font-size: 20pt; color: #00742e;"><strong><em>&nbsp;"Tu salud, nuestro compromiso"</em></strong></span></p>
            </div>
            <div class="col-md-2">                
                <?php $ruta='/images/pnp_logo.png'; ?>
                <img src="{!!url($ruta)!!}" alt="DIRECCIÓN DE SANIDAD POLICIAL - DIRSAPOL">                
            </div>
        </div>
</div>  
    
    <p>El presente formulario tiene por finalidad, la recoleccion de informacion acerca del personal PNP en actividad que se encuentra en aislamiento social por factor de risgo Covid-19. Los datos solicitados deben ser declarados en su totalidad, de manera obligatoria y veraz, bajo responsabilidad disciplinaria.</p>

<div class="col-md-2">
    <label>Fecha del Registro:</label> 
</div>
<div class="col-md-2">
    <input readonly type="date" tabindex="0"  required="" name="fecha_reclamo" id="fecha_reclamo" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
    
</div>
<br/><br/><br/>
<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">PERSONAL PNP EN AISLAMIENTO POR FACTOR DE RIESGO COVID-19</h3>
    </div>  

    <div class="box-body  col-md-6">
        <div class="row">
            <br/>            
            <div class="col-md-4">
                <label>DNI:</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required="" tabindex="1" name="dni" id="dni" class="form-control" maxlength="8">
                <br/>
            </div>
        </div>
        <div class="row">
            <br/>            
            <div class="col-md-4">
                <label>Nombres</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required=""  tabindex="3" name="name" id="name" class="form-control">
                <br/>
            </div>
        </div>
        <div class="row">
            <br/>            
            <div class="col-md-4">
                <label>Apellido Materno</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required="" tabindex="5" name="materno" id="materno" class="form-control">
                <br/>
            </div>
        </div>
        <div class="row">
            <br/>        
            <div class="col-md-4">
                <label>Sexo</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required="" tabindex="7" name="sexo" id="sexo" class="form-control" maxlength="1">
                <br/>
            </div>
        </div>
        <div class="row">
            <br/>
            <div class="col-md-4">
                <label>Departamento</label> 
            </div>
            <div class="col-md-8">
                <select class="form-control select2" tabindex="9" required="" name="id_departamento" id="id_departamento">
                    <option value="">- Seleccione -</option>
                    @foreach($departamentos as $dep)
                    <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                    @endforeach
                </select>
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="col-md-4">
                <br/>
                <label>Distrito</label> 
            </div>
            <div class="col-md-8">
                <br/>
                <select class="form-control select2" tabindex="11" required="" name="id_distrito" id="id_distrito">
                    <option value="">-Seleccione-</option>
                </select>
                <br/>
            </div>
        </div>        
        <br/>
        <div class="row">
            <div class="col-md-4"> <br/>            
                <label>Celular</label> 
            </div>
            <div class="col-md-8">    <br/>            
                <input type="text" required="" onKeyPress="return soloNumeros(event)" name="telefono" tabindex="13" id="telefono" maxlength="9" class="form-control">
                <br/>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-md-4">                
                <label>Categoria</label> 
            </div>
            <div class="col-md-8">                
                <select class="form-control select2" tabindex="15" required="" name="id_categoria" id="id_categoria">
                    <option value="">- Seleccione -</option>
                    @foreach($pnpcategorias as $cat)
                    <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                    @endforeach
                </select>
                <br/>
            </div>            
        </div>
        <br/>
        <div class="row">
            
            <div class="col-md-4">
                <br/>
                <label>Aislamiento con declaracion jurada</label> 
            </div>
            <div class="col-md-8">
                <br/>
                <select class="form-control select2" tabindex="17" required="" name="id_dj" id="id_dj">
                    <option value="">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}">{{$si->descripcion}}</option>
                    @endforeach
                </select>
                <br/>
            </div> 
        </div>
        <br/>

        <div class="row">
            
            <div class="col-md-4">
                <br/>
                <label>Realiza trabajo remoto</label> 
            </div>
            <div class="col-md-8">
                <br/>
                <select class="form-control select2" tabindex="19" required="" name="id_trabajo" id="id_trabajo">
                    <option value="0">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}">{{$si->descripcion}}</option>
                    @endforeach
                </select>
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="col-md-4">
                <br/>
                <label>Consideracion para reincorporacion</label> 
            </div>
            <div class="col-md-8">
                <br/>
                <select class="form-control select2" tabindex="21" required="" name="id_reincorporacion" id="id_reincorporacion">
                    <option value="0">- Seleccione -</option>                    
                    <option value="SI">SI, accedo a la reincorporacion</option>
                    <option value="NO">NO, permanezco en aislamiento</option>
                </select>
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">   
            <div class="col-md-4">
                <br/>
                <label>Atencion medica en establecimiento PNP en año 2020</label> 
            </div>
            <div class="col-md-8">
                <br/>
                <select class="form-control select2" tabindex="18" required="" name="id_atencion" id="id_atencion">
                    <option value="0">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}">{{$si->descripcion}}</option>
                    @endforeach
                </select>
                <br/>
            </div>
        </div>
        
    </div>

    <div class="box-body  col-md-6">
        <br/>
        <div class="row">
            <div class="col-md-4">
                <label>CIP:</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required="" tabindex="2" name="cip" id="cip" class="form-control" maxlength="8">
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-4">
                <label>Apellido Paterno</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required="" tabindex="4" name="paterno" id="paterno" class="form-control">
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="col-md-4">
                <label>Fecha Nacimiento (dd/mm/aaaa)</label> 
            </div>            
            <div class="col-md-8">
                <input type="text" tabindex="6"  required="" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" maxlength="10">
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-4">
                <label>Grado</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required="" tabindex="8" name="grado" id="grado" class="form-control">
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="col-md-4">
                <label>Provincia</label> 
            </div>
            <div class="col-md-8">
                <select class="form-control select2" tabindex="10" required="" name="id_provincia" id="id_provincia">
                    <option value="">-Seleccione-</option>
                </select>
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="col-md-4"> <br/>               
                <label>Email</label> 
            </div>            
            <div class="col-md-8"><br/>           
                <input type="email" required="" tabindex="12" name="email" id="email" class="form-control">
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-4">
                
                <label>Domicilio</label> 
            </div>
            <div class="col-md-8">
                <input type="text" required=""tabindex="14" name="domicilio" id="domicilio" class="form-control">
                <br/>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="col-md-4">
                <br/>
                <label>Fecha de Aislamiento Social</label> 
            </div>
            <div class="col-md-8">
                <br/>
                <input type="date" tabindex="20"  required="" name="fecha_aislamiento" id="fecha_aislamiento" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                <br/>
            </div>
        </div>
        
        <br/>
        <div class="row">
            <div class="col-md-4">
                <br/>
                <label>Factor de Riesgo</label> 
            </div>
            <div class="col-md-8">
                <br/>                
                <table><?php $x=1; ?>
                    @foreach($Sintomas as $id => $friesgo)
                        <tr>
                            <td>
                                <input 
                                type="checkbox" 
                                value="{{ $friesgo->id }}" 
                                
                                {{ $aislamientos->factoraislados->pluck('id')->contains($friesgo->id) ? 'checked' : '' }}
                                name="Sintomax[]">
                            </td>
                            <td>&nbsp;{{ $friesgo->descripcion }}</td>                            
                        </tr>
                    @endforeach
                </table>                
                <br/>
            </div>
            <div class="col-md-4 etiqueta" id="cargarotroriesgo"><br/></div>
        </div>
        
        
    </div>
</div>
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('aislamientosite.index') !!}" class="btn btn-danger">Cancelar</a>
    </div>
</div>