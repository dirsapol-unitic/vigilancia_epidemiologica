
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-1">
                                <label>Fecha</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->fecha_reclamacion}}                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Nombre Establecimiento :</label> 
                            </div>
                            <div class="col-md-4">
                                {{$reclamaciones[0]->nombre}} 
                            </div>
                            <div class="col-md-1">
                                <label>Direccion</label> 
                            </div>
                            <div class="col-md-5">                
                                {{$reclamaciones[0]->direccion}} 
                                <br/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Tipo Doc :</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->tipo_doc}} 
                            </div>
                            <div class="col-md-2">
                                <label>Nro Doc :</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nro_doc}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Nombres</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombres}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Apellido Paterno</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->apellido_paterno}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Apellido Materno</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->apellido_materno}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Domicilio</label> 
                            </div>
                            <div class="col-md-10">
                                {{$reclamaciones[0]->domicilio}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Departamento</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombre_dpto}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Provincia</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombre_prov}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Distrito</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombre_dist}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                
                                <label>Email</label> 
                            </div>
                            
                            <div class="col-md-6">
                                
                                {{$reclamaciones[0]->email}} 
                                <br/>
                            </div>
                            
                            <div class="col-md-2">
                                
                                <label>Telefono</label> 
                            </div>

                            <div class="col-md-2">
                                
                                {{$reclamaciones[0]->telefono}} 
                            </div>
                        </div>        
                    </div>
                </div>
                @if($reclamaciones[0]->otro_usuario=='SI')
                <div class="box box-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">USUARIO QUIEN PRESENTA EL RECLAMO (En caso de ser el mismo que el afectado omitir el llenado) Clic en Activar para llenar datos </h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            <br/>
                            <div class="row">
                            <br/>
                            <div class="col-md-2">
                                <label>Tipo Doc :</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->tipo_doc2}} 
                            </div>
                            <div class="col-md-2">
                                <label>Nro Doc :</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nro_doc2}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Nombres</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombres2}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Apellido Paterno</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->apellido_paterno2}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Apellido Materno</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->apellido_materno2}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Domicilio</label> 
                            </div>
                            <div class="col-md-10">
                                {{$reclamaciones[0]->domicilio2}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Departamento</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombre_dpto2}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Provincia</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombre_prov2}} 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <label>Distrito</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nombre_dist2}} 
                                <br/>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-2">
                                <label>Email</label> 
                            </div>                            
                            <div class="col-md-6">                                
                                {{$reclamaciones[0]->email2}} 
                                <br/>
                            </div>                            
                            <div class="col-md-2">                                
                                <label>Telefono</label> 
                            </div>
                            <div class="col-md-2">                                
                                {{$reclamaciones[0]->telefono2}} 
                            </div>
                        </div>                
                    </div>
                </div>
                @endif
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                
                                <label>Descripcion</label> 
                                {{$reclamaciones[0]->reclamo}} 
                                <br/>
                            </div>
                            <!--div class="col-md-12"> 
                                <fieldset>
                                    <label class="radio-label">Autoriza ser notificado a traves de su cuenta de correo electronico</label> 
                                    {{$reclamaciones[0]->autorizar_envio}}
                                </fieldset>
                            </div-->
                        </div>
                    </div>
                </div>
            