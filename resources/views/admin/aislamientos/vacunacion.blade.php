<div class="box box-danger">
    <div class="box-body">
        <div class="row col-sm-12">
            
            <div class="box-body">
                <div class="form-group col-sm-12">

                    {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
        
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="panel-success"> <!--panel-default open-->
                        <div class="panel-heading"> <b>Registro de Inmunizaciones</b> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            Bienvenido: 
                        <b><?php echo "Maly";  ?></b>   
                                            
                        <div id="content"></div>      
                        
                        </div>
                        
                        <div class="panel-body"> 
                            <form action="../../MVC_Controlador/Inmunizaciones/InmunizacionesC.php?acc=GuardarImnunizaciones" method="post" id="login_form">
                                
                                <fieldset>
                                    <legend>I.  NOTIFICACIÓN</legend>            
                                    <div class="form-group">
                                        <label class="control-label col-md-1">Tipo:</label>
                                        <div class="col-md-2"> 
                                            <select class="form-control input-sm" name="TipoNotificacion" id="TipoNotificacion" >
                                                <option value="">SELECCIONE</option>
                                                <option value="SEVERO">SEVERO</option>
                                                <option value="CONGLOMERADO">CONGLOMERADO(LEVE-MODERADO) </option>
                                            </select>
                                        </div>                                      
                                        <label class="control-label col-md-1">Código:</label>
                                        <div class="col-md-2"> 
                                            <input type="text" class="form-control input-sm" name="codigo" id="codigo"  />      
                                        </div>  
                                        <label class="control-label col-md-3">Fecha de identificación local del caso:</label>
                                        <div class="col-md-2"> 
                                            <input type="text" class="form-control input-sm datepicker" name="fecha_iden" id="fecha_iden"  />      
                                        </div>  
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Fecha de notificación de DIRESA/GERESA/DIRIS a CDC/MINSA (notificación nacional):</label>
                                        <div class="col-md-2"> 
                                            <input type="text" class="form-control input-sm datepicker" name="fecha_noti" id="fecha_noti"  />      
                                        </div>  
                                        <label class="control-label col-md-3">Fecha de inicio de investigación:</label>
                                        <div class="col-md-2"> 
                                            <input type="text" class="form-control input-sm datepicker" name="fecha_inve" id="fecha_inve"  />      
                                        </div>  
                                    </div>
                                    
                                </fieldset>
                                
                                <fieldset>
                                    <legend>II. DATOS DEL ESTABLECIMIENTO DE SALUD NOTIFICANTE</legend> 
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Establecimiento:</label>
                                        <div class="col-md-10"> 
                                            <select class="form-control input-sm" name="DatosEstablecimiento" id="DatosEstablecimiento" onchange="cambiarEstablecimiento();">
                                                <option value="">Seleccione</option>
                                                @foreach($establecimientos as $dep)
                                                <option value="{{$dep->id}}" >{{$dep->nombre}}</option>
                                                @endforeach
                                                <?php 
                                                /*$Establecimiento= Establecimiento_medicoM();
                                                if($Establecimiento!=NULL){
                                                foreach ($Establecimiento as $item){
                                                    $DatosEsta=$item["disa"].'|'.$item["red"].'|'.$item["microred"].'|'.$item["cod_unico"].'|'.$item["establecimiento"].'|'. $item["departamento_establecimiento"].'|'.$item["provincia_establecimiento"].'|'.$item["distrito_establecimiento"].'|'.$item["id"]; */
                                                ?>
                                                <!--option value="<?php // echo $DatosEsta ?>"><?php // echo $item["establecimiento"]; ?></option-->
                                                
                                            <?php // }} ?>
                                            </select>
                                            <input type="hidden" name="cod_unico" id="cod_unico"  value="" />
                                            <input type="hidden" name="establecimiento" id="establecimiento" value="" />
                                            <input type="hidden" name="disa" id="disa" value="" />
                                            <input type="hidden" name="red" id="red" value="" />
                                            <input type="hidden" name="microred" id="microred" value="" />
                                            <input type="hidden" name="departamento_establecimiento" id="departamento_establecimiento" value="" />
                                            <input type="hidden" name="provincia_establecimiento" id="provincia_establecimiento" value="" />
                                            <input type="hidden" name="distrito_establecimiento" id="distrito_establecimiento" value="" />                          
                                            <input type="hidden" name="id_establecimiento" id="id_establecimiento" value="" />                          
                                        </div>                                      
                                        
                                    </div>
                                    
                                    
                                </fieldset>
                                
                                <fieldset>
                                    <legend>III.    DATOS DEL PACIENTE</legend> 
                                    <div class="form-group">
                                        <label class="control-label col-md-1">Tipo Doc:</label>
                                        <div class="col-md-2"> 
                                            <select class="form-control input-sm" name="abrev_tipo_doc" id="abrev_tipo_doc">
                                                <option value="DNI">DNI</option>
                                                <option value="Pasaporte">Pasaporte</option>
                                                <option value="Carne de extranjería">Carne de extranjería</option>
                                                <option value="Sin documento">Sin documento</option>       
                                            </select>
                                        </div>
                                        <label class="control-label col-md-1">N°Doc:</label>
                                        <div class="col-md-2">                                              
                                            <input type="text" maxlength="10" class="form-control input-sm" name="num_doc" id="num_doc"  placeholder="Digite y Busque" onkeyup="borrarpaciente();" />      
                                        </div>
                                    
                                        <label class="control-label col-md-1">1er Ape:</label>
                                        <div class="col-md-2">                                              
                                            <input type="text" class="form-control input-sm" name="PrimerApellido" id="PrimerApellido"    />      
                                        </div>
                                        <label class="control-label col-md-1">2do Ape:</label>
                                        <div class="col-md-2">                                              
                                            <input type="text" class="form-control input-sm" name="SegundoApellido" id="SegundoApellido"    />      
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-1">Nombre(s):</label>
                                        <div class="col-md-2">                                              
                                            <input type="text" class="form-control input-sm" name="Nombre" id="Nombre"    />      
                                        </div>
                                        <label class="control-label col-md-1">Sexo:</label>
                                        <div class="col-md-2">                                          
                                            <select class="form-control input-sm" name="desc_genero" id="desc_genero">
                                                <option value="">Seleccione</option>
                                                <option value="FEMENINO">FEMENINO</option>
                                                <option value="MASCULINO">MASCULINO</option>
                                            </select>   
                                        </div>
                                        
                                        <label class="control-label col-md-1">F.Nacim:</label>
                                        <div class="col-md-2">                                              
                                            <input type="text" class="form-control input-sm" name="fecha_nacimiento" id="fecha_nacimiento"  value="" />      
                                        </div>      
                                        <label class="control-label col-md-1">Edad:</label>
                                        <div class="col-md-1">  
                                            <input type="text" class="form-control input-sm" name="Edad" id="Edad"    /> 
                                        </div>      
                                        <div class="col-md-1">                                              
                                            <select class="form-control input-sm" name="tipoEdad" id="tipoEdad">
                                                <option value="1">Años</option>
                                                <option value="2">Meses </option>
                                                <option value="3">Días</option>
                                            </select>     
                                        </div>
                                    </div>
                                    
                                    <div class="form-group espacio">    
                                        
                                        <label class="control-label col-md-1">Domic:</label>
                                        <div class="col-md-2">  
                                            <select class="form-control input-sm" name="departamento_residencia" id="departamento_residencia" onchange="cambiarDepartamentoRes();">
                                                <option value="">Departamento</option>
                                                @foreach($departamentos as $dep)
                                                <option value="{{$dep->id}}" >{{$dep->nombre}}</option>
                                                @endforeach
                                                <?php 
                                                //$Departamentos= ListarDepartamentos();
                                                //if($Departamentos!=NULL){
                                                //foreach ($Departamentos as $item){
                                                ?>
                                                <!--option value="<?php //echo $item["nombre_dpto"] ?>"><?php //echo $item["nombre_dpto"]; ?></option-->
                                                
                                            <?php // }} ?>
                                            </select>
                                            
                                            <!-- <input type="text" class="form-control input-sm" name="departamento_residencia" id="departamento_residencia"  placeholder="Departamento" /> -->
                                            <input type="hidden" name="id_ubigeo_res" id="id_ubigeo_res"  value="" />
                                        </div>
                                        <div class="col-md-2">  
                                            <select class="form-control input-sm" name="provincia_residencia" id="provincia_residencia" onchange="cambiarProvinciaRes();">
                                                <option value="">Provincia</option>
                                            </select>
                                            <!-- <input type="text" class="form-control input-sm" name="provincia_residencia" id="provincia_residencia"  placeholder="Provincia" /> -->      
                                        </div>                                      
                                                                            
                                        <div class="col-md-2"> 
                                            <select class="form-control input-sm" name="distrito_residencia" id="distrito_residencia" >
                                                <option value="">Distrito</option>
                                            </select>
                                            <!-- <input type="text" class="form-control input-sm" name="distrito_residencia" id="distrito_residencia"  placeholder="Distrito" />  -->      
                                        </div>      
                                                                                    
                                        <div class="col-md-3"> 
                                            <input type="text" class="form-control input-sm" name="direccion" id="direccion"  placeholder="Dirección" />       
                                        </div>      
                                        <div class="col-md-2"> 
                                            <input type="text" class="form-control input-sm" name="referencia" id="referencia"  placeholder="Referencia" />       
                                        </div>
                                    </div>
                                    <div class="form-group">    
                                        <label class="control-label col-md-1">Tipo Loc:</label>
                                        <div class="col-md-2">                                              
                                            <select class="form-control input-sm" name="TipoLoc" id="TipoLoc">
                                                <option value="Urbano">Urbano</option>
                                                <option value="Periurbano">Periurbano</option>
                                                <option value="Rural">Rural</option>
                                            </select>     
                                        </div>
                                        <label class="control-label col-md-1">Teléfono:</label>
                                        <div class="col-md-2">                                              
                                             <input class="form-control input-sm" name="telefono" id="telefono"  />     
                                        </div>
                                        <label class="control-label col-md-1">Etnia:</label>
                                        <div class="col-md-2">                                              
                                            <select class="form-control input-sm" name="desc_etn" id="desc_etn">
                                                <option value="MESTIZO">MESTIZO</option>
                                                <option value="QUECHUAS">QUECHUAS</option>
                                                <option value="OTRO">OTRO</option>
                                            </select>     
                                        </div>
                                        
                                        <label class="control-label col-md-1">Gestante:</label>
                                        <div class="col-md-1"> 
                                            <select class="form-control input-sm" name="gestante" id="gestante">
                                                <option value="NO">NO</option>
                                                <option value="SI">SI</option>
                                            </select>  
                                             
                                        </div>                                      
                                        <div class="col-md-1"> 
                                            <input class="form-control input-sm" name="semanas" id="semanas"  placeholder="Semanas" />    
                                             
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">    
                                        <label class="control-label col-md-1">Está Aseg.:</label>
                                        <div class="col-md-1">                                              
                                            <select class="form-control input-sm" name="Asegurado" id="Asegurado">
                                                <option value="No">Si</option>
                                                <option value="No">No</option>
                                            </select>     
                                        </div>
                                        <div class="col-md-2">                                              
                                            <select class="form-control input-sm" name="Tipo_seguro" id="Tipo_seguro">
                                                <option value="SIS">SIS</option>
                                                <option value="EsSalud">EsSalud</option>
                                                <option value="Privado">Privado</option>
                                            </select>     
                                        </div>
                                        
                                        <label class="control-label col-md-1">Ocupación:</label>
                                        <div class="col-md-2"> 
                                            <select class="form-control input-sm" name="Ocupacion" id="Ocupacion">
                                                <option value="Sin ocupación">Sin ocupación</option>
                                                <option value="Estudiante">Estudiante</option>
                                                <option value="Comerciante">Comerciante</option>
                                                <option value="Empleado">Empleado</option>
                                                <option value="Personal de salud">Personal de salud</option>
                                                <option value="Otro">Otro</option>
                                            </select> 
                                             
                                        </div>                                      
                                        <div class="col-md-2"> 
                                            <input class="form-control input-sm" name="OtraOcupación" id="OtraOcupación"  placeholder="Otra Ocupación" />
                                             
                                        </div>
                                    </div>
                                
                                </fieldset>
                                
                                <fieldset>
                                    <legend>IV. DATOS DE LA VACUNACIÓN (colocar códigos)IV. DATOS DE LA VACUNACIÓN (colocar códigos)</legend>   
                                    <table width="100%" class="table table-bordered table-hover" cellspacing="0" style="font-size:14px;" id="dataTables-example"> <!--table-hover-->
                                    <thead>
                                        <tr>
                                            <th>1.Nombre de Vacuna (cód)</th>     
                                            <th>2.Adyuv</th>
                                            <th>3.Dosis</th>
                                            <th>4.Vía.</th> 
                                            <th>5.Sitio</th> 
                                            <th>Fecha de vacunación (Hs:m)</th> 
                                            
                                            <th>EESS que vacunó</th>            
                                            <th>Fabricante</th>
                                            <th>Lote</th>  
                                            <th>Fecha de expiración</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input class="form-control input-sm" name="Vacuna" id="Vacuna"  placeholder="Vacuna" /></td> 
                                            <td><input class="form-control input-sm" name="Adyuv" id="Adyuv"  placeholder="Adyuv" /></td>       
                                            <td><input class="form-control input-sm" name="Dosis" id="Dosis"  placeholder="Dosis" /></td>
                                            <td><input class="form-control input-sm" name="Vía" id="Vía"  placeholder="Vía" /></td>
                                            <td><input class="form-control input-sm" name="Sitio" id="Sitio"  placeholder="Sitio" /></td>
                                            <td><input class="form-control input-sm" name="FVac" id="FVac"  placeholder="F.Vac" /></td>
                                            
                                            <td><input class="form-control input-sm" name="EESS" id="EESS"  placeholder="EESS" /></td>   
                                            <td><input class="form-control input-sm" name="Fabricante" id="Fabricante"  placeholder="Fabricante" /></td>    
                                            <td><input class="form-control input-sm" name="Lote" id="Lote"  placeholder="Lote" /></td>
                                            <td><input class="form-control input-sm" name="FExpiración" id="FExpiración"  placeholder="F.Expiración" /></td>                    
                                        </tr>    
                                    </tbody>                                    
                                    </table>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>V.  ANTECEDENTES</legend>   
                                    <table width="100%" class="table table-bordered" cellspacing="0" style="font-size:14px;" id="dataTables-example"> <!--table-hover-->
                                    
                                        <tr>
                                            <th>PERSONALES</th>     
                                            <th>FAMILIARES</th>
                                            <th>EPIDEMIOLÓGICOS</th>                                    
                                        </tr>
                                   
                                        <tr>
                                            <td>
                                                <div class="form-group">    
                                                    <label class="control-label col-md-2">¿ESAVI previo?</label>
                                                    <div class="col-md-2">                                              
                                                        <select class="form-control input-sm" name="ESAVI" id="ESAVI">
                                                            <option value="No">No</option>
                                                            <option value="Si">Si</option>
                                                        </select>     
                                                    </div>
                                                    <label class="control-label col-md-2">¿Cuál?</label>
                                                    <div class="col-md-4">                                              
                                                        <select class="form-control input-sm" name="DescripcionESAVI" id="DescripcionESAVI">
                                                            <option value="">Seleccione</option>
                                                            <option value="Convulsión">Convulsión</option>
                                                            <option value="Rush">Rush</option>
                                                            <option value="Pérdida conoc">Pérdida conoc</option>
                                                            <option value="Otro">Otra</option>
                                                        </select> 
                                                             
                                                    </div>                                      
                                                    <div class="col-md-4"> 
                                                        <input class="form-control input-sm" name="OtraESAVI" id="OtraESAVI"  placeholder="Otra ESAVI Previo" />
                                                         
                                                    </div>     
                                                    
                                                    
                                                    <label class="control-label col-md-12">Cond.Comorbilidad:</label>
                                                    <div class="col-md-12">                                                          
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox1" value="1">Alergia</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox2" value="2">Enf. Renal</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox3" value="3">Convulsión</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox4" value="4">Daño hepático</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox5" value="5">Asma</label>                                                     
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox6" value="6">Cáncer</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox7" value="7">Diabetes</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox8" value="8">Enf.Pulmonar</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox9" value="9">Obesidad</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox10" value="10">Enf.Reumatol.</label>
                                                        
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox11" value="11">HTA</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox12" value="12">Enf.Cardiovascular</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox13" value="13">Enf. Neurológica o neuromuscular</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cbox14" value="14">Inmunodeficiencia(incluye VIH)</label>
                                                    </div>                                      
                                                    <div class="col-md-6"> 
                                                        <input class="form-control input-sm" name="OtraCondicion" id="OtraCondicion"  placeholder="Otra Cond.Comorbilidad" />
                                                         
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="form-group">    
                                                <label class="control-label col-md-12">Cuadros Patológicos:</label>
                                                    <div class="col-md-12" style="font-weight: normal; !important">                                                          
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp1" value="1">Alergia</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp2" value="2">COVID-19</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp3" value="3">Asma</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp4" value="4">TBC</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp5" value="5">Urticaria</label>                                                      
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp6" value="6">HTA</label>                                                        
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp7" value="7">Epilepsia</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp8" value="8">Enf.Cardiovascular</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp9" value="9">Diabetes</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp10" value="10">Enf.Pulmonar.</label>                                                        
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp11" value="11">Obesidad</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp12" value="12">Enf.Reumatol</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp13" value="13">Cáncer</label>
                                                        
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp14" value="14">Enf.Renal</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp15" value="15">Convulsión febril infancia</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="cp16" value="16">Inmunodeficiencia (incluye VIH)</label>
                                                    </div>                                      
                                                    <div class="col-md-6"> 
                                                        <input class="form-control input-sm" name="OtraPatologia" id="OtraPatologia"  placeholder="Otra Patología" />
                                                         
                                                    </div>
                                                </div>
                                            </td>       
                                            <td>
                                                <div class="form-group">    
                                                <label class="control-label col-md-12">Enf.Prevalentes Región:</label>
                                                    <div class="col-md-12">                                                          
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="epr1" value="1">Dengue</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="epr2" value="2">Malaria</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="epr3" value="3">Zika</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="epr4" value="4">Leptospirosis</label>
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="epr5" value="5">Bartonelosis</label>                                                      
                                                        <label style="font-weight: normal; !important"><input type="checkbox" id="epr6" value="6">Rabia</label>                                             
                                                    </div>                                      
                                                    <div class="col-md-12"> 
                                                        <input class="form-control input-sm" name="OtraCondicion" id="OtraCondicion"  placeholder="Otra Enf.Prevalente" />
                                                         
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>    
                                                                        
                                    </table>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>VI. SIGNOS/SÍNTOMAS</legend>    
                                    <table width="100%" class="table table-bordered" cellspacing="0" style="font-size:14px;" id="dataTables-example"> <!--table-hover-->
                                    <thead>
                                        <tr>
                                            <th></th>     
                                            <th  colspan="3">Tiempo entre vacunación e inicio del cuadro clínico</th>
                                            <th>Fecha de Inicio</th>
                                            <th>Fecha de Término</th>                                   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                       /* $i=0;
                                        $preguntas=ListarPreguntas('P');
                                        if($preguntas!=NULL){
                                        foreach($preguntas as $item){
                                            $i++;
                                            $id_pregunta=$item['id'];
                                            $respuestas=ListarRespuestas($id_pregunta);
                                            */
                                        ?>
                                        <tr>
                                            <td><b><?php //echo $item['nro'].'. '.$item['descripcion'] ?></b></td>
                                            <?php //if($respuestas!=NULL){ ?> 
                                                <td><b>Minuto</b></td> 
                                                <td><b>Hora</b></td> 
                                                <td><b>Días</b></td>    
                                                <td>día / mes / año</td>
                                                <td>día / mes / año</td>
                                            <?php //}else{ ?> 
                                                <td></td> 
                                                <td></td> 
                                                <td></td>   
                                                <td></td>
                                                <td></td>   
                                            <?php // } ?>      
                                        </tr>  
                                        <?php                                       
                                            //if($respuestas!=NULL){
                                            //foreach($respuestas as $item2){                                     
                                        ?>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;<?php //echo $item2['nro'].') '.$item2['descripcion'] ?></td> 
                                            <td></td> 
                                            <td></td> 
                                            <td></td>   
                                            <td>___/____/____</td>
                                            <td>___/____/____</td>
                                        </tr> 
                                        
                                        <?php 
                                        //}}
                                    
                                        //}}
                                        ?>
                                        
                                        <tr>
                                            <td><b><?php //echo ($i+1).'. Otros eventos severos e inusuales especifique' ?></b></td> 
                                            <td><b>Minuto</b></td> 
                                            <td><b>Hora</b></td> 
                                            <td><b>Días</b></td>    
                                            <td>día / mes / año</td>
                                            <td>día / mes / año</td>
                                        </tr> 
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;<label class="control-label col-md-2">¿Cuál?</label> <div class="col-md-4"> <input class="form-control input-sm" name="OtroEvento" id="OtroEvento"  placeholder="Otro Evento" /> </div></td> 
                                            <td></td> 
                                            <td></td> 
                                            <td></td>   
                                            <td>___/____/____</td>
                                            <td>___/____/____</td>
                                        </tr>   
                                    </tbody>                                    
                                    </table>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>VII.    DESCRIPCIÓN DEL CUADRO CLÍNICO</legend> 
                                    <div class="form-group">    
                                        <label class="control-label col-md-2">Fecha Inicio:</label>
                                        <div class="col-md-2">  
                                            <input class="form-control input-sm" name="fecha_inicio" id="fecha_inicio"  placeholder="" />
                                        </div>
                                        <label class="control-label col-md-2">Gravedad del caso:</label>
                                        <div class="col-md-2">  
                                            <input class="form-control input-sm" name="Gravedad" id="Gravedad"  placeholder="" />
                                        </div><br><br>
                                        <label class="control-label col-md-3">Secuencia cronológica de de síntomas:</label>
                                        <div class="col-md-7">  
                                            <input class="form-control input-sm" name="Secuencia" id="Secuencia"  placeholder="" />
                                        </div>
                                        <label class="control-label col-md-3">Exámenes auxiliares:</label>
                                        <div class="col-md-7">  
                                            <input class="form-control input-sm" name="Examenes" id="Examenes"  placeholder="" />
                                        </div>
                                        <label class="control-label col-md-3">Tratamiento recibido:</label>
                                        <div class="col-md-7">  
                                            <input class="form-control input-sm" name="Tratamiento" id="Tratamiento"  placeholder="" />
                                        </div>
                                        <label class="control-label col-md-3">Evolución:</label>
                                        <div class="col-md-7">  
                                            <input class="form-control input-sm" name="Evolucion" id="Evolucion"  placeholder="" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>VIII.   HOSPITALIZACIÓN</legend>    
                                    <table width="100%" class="table table-bordered" cellspacing="0" style="font-size:14px;" id="dataTables-example"> <!--table-hover-->
                                        <tr>
                                            <td>
                                                <div class="form-group">    
                                                    <label class="control-label col-md-4">N°Historia</label>
                                                    <div class="col-md-6">                                              
                                                        <input class="form-control input-sm" name="Historia" id="Historia"  placeholder="" />    
                                                    </div>
                                                    <label class="control-label col-md-4">F.Ingreso</label>
                                                    <div class="col-md-6">                                                      
                                                        <input class="form-control input-sm" name="fecha_ingreso" id="fecha_ingreso"  placeholder="" />  
                                                    </div>  
                                                    <label class="control-label col-md-4">F.Alta</label>    
                                                    <div class="col-md-6"> 
                                                        <input class="form-control input-sm" name="fecha_alta" id="fecha_alta"  placeholder="" />
                                                    </div>      
                                                    
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="form-group">    
                                                    <label class="control-label col-md-4">Diag.Ing.</label>
                                                    <div class="col-md-6">                                              
                                                        <input class="form-control input-sm" name="DIng" id="DIng"  placeholder="" />    
                                                    </div>
                                                    <label class="control-label col-md-4">Diag.Egr.</label>
                                                    <div class="col-md-6">                                                      
                                                        <input class="form-control input-sm" name="DEgr" id="DEgr"  placeholder="" />    
                                                    </div>      
                                                    <label class="control-label col-md-4">Est.Alta</label>
                                                    <div class="col-md-6">                                                      
                                                        <select class="form-control input-sm" name="EstadoAlta" id="EstadoAlta">
                                                            <option value="Mejorado">Mejorado</option>
                                                            <option value="Secuela">Secuela</option>
                                                            <option value="Fallecido">Fallecido</option>
                                                        </select> 
                                                    </div> 
                                                </div>
                                            </td>       
                                            <td>
                                                <div class="form-group">    
                                                <label class="control-label col-md-4">¿Transferido?</label>
                                                    <div class="col-md-6">                                                       
                                                        <select class="form-control input-sm" name="Transferido" id="Transferido">
                                                            <option value="No">No</option>
                                                            <option value="Si">Si</option>
                                                        </select>                                               
                                                    </div>                                      
                                                    <label class="control-label col-md-4">¿Adónde?</label>
                                                    <div class="col-md-6">                                                      
                                                        <input class="form-control input-sm" name="LTransferido" id="LTransferido"  placeholder="" />    
                                                    </div> 
                                                </div>
                                            </td>
                                        </tr>    
                                                                        
                                    </table>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>IX. SEGUIMIENTO DEL PACIENTE</legend>   
                                    <div class="form-group">
                                    <?php 
                                    /*
                                    $preguntas=ListarPreguntas('S');
                                        if($preguntas!=NULL){
                                        foreach($preguntas as $item){
                                    ?>  
                                        <label class="control-label col-md-3" style="font-weight: normal; !important"><input type="checkbox" id="cbox1" value="<?php echo $item["id"] ?>"> <?php echo $item["nro"].'. '.$item["descripcion"] ?></label>
                                    <?php 
                                        }} */
                                    ?>  
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>X.  CLASIFICACION FINAL</legend>    
                                    <div class="form-group espacio">
                                    <?php 
                                    /*$preguntas=ListarPreguntas('C');
                                        if($preguntas!=NULL){
                                        foreach($preguntas as $item){
                                    ?>  
                                        <label class="control-label col-md-5" style="font-weight: normal; !important"><input type="checkbox" id="cbox1" value="<?php echo $item["id"] ?>"> <?php echo $item["nro"].'. '.$item["descripcion"] ?></label>
                                    <?php 
                                        }} */
                                    ?>  
                                    </div><br><br>
                                    
                                    <div class="form-group espacio">    
                                    <label class="control-label col-md-2">Nombre del Investigador</label>
                                        <div class="col-md-4">                                                       
                                            <input class="form-control input-sm" name="Investigador" id="Investigador"  placeholder="" />                                                   
                                        </div>                                      
                                        <label class="control-label col-md-2">Cargo</label>
                                        <div class="col-md-4">                                                      
                                            <input class="form-control input-sm" name="Cargo" id="Cargo"  placeholder="" />  
                                        </div>
                                        <label class="control-label col-md-2">Teléfono</label>
                                        <div class="col-md-4">                                                      
                                            <input class="form-control input-sm" name="Telefono" id="Telefono"  placeholder="" />    
                                        </div>
                                    </div><br>
                                </fieldset>
                                
                                    <div class="form-group">            
                                        <div class="col-md-2 col-md-offset-2"> <!--col-md-3 col-md-offset-4-->
                                            <button class="btn btn-info btn-block" id="enviar" type="button" onclick="Guardar();"> Registrar </button>
                                        </div>
                                        <div class="col-md-2"> 
                                            <button class="btn btn-warning btn-block" id="volver" type="button" onClick="Volver();">Volver</button>
                                        </div>
                                        <div class="col-md-2"> 
                                            <button class="btn btn-danger btn-block" id="sali" type="button" onClick="salir();">Salir</button>
                                        </div>                                  
                                        
                                    </div>
                                    
                        
                                    
                                
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.panel --> 
                
