            <div class="panel panel-primary">
                <div class="panel-heading">
                        <h5 class="panel-title">Libro de Reclamaciones</h5>
                </div>                
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Fecha</label> 
                        </div>
                        <div class="col-md-2">
                            {{$reclamaciones[0]->fecha_reclamacion}}                                
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="col-md-1">
                            <label>Nro</label> 
                        </div>
                        <div class="col-md-5">                
                            {{$reclamaciones[0]->nro_reclamacion}} 
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Establecimiento :</label> 
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    @if($reclamaciones[0]->otro_usuario=='SI')
                        <h5 class="panel-title">Usuario Demandante</h5>
                    @else
                        <h5 class="panel-title">Usuario Afectado</h5>
                    @endif
                </div>   
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
                            <label>Domicilio</label> 
                        </div>
                        <div class="col-md-10">
                            {{$reclamaciones[0]->domicilio}} 
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
            @if($reclamaciones[0]->otro_usuario=='SI')
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title">Usuario Afectado</h5>
                </div>                 
                <div class="box-body">
                    <div class="row">
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
                    <div class="row">
                        <div class="col-md-2">
                            <label>Departamento</label> 
                        </div>
                        <div class="col-md-2">
                            {{$reclamaciones2[0]->nombre_dpto}} 
                            <br/>
                        </div>
                        <div class="col-md-2">
                            <label>Provincia</label> 
                        </div>
                        <div class="col-md-2">
                            {{$reclamaciones2[0]->nombre_prov}} 
                            <br/>
                        </div>
                        <div class="col-md-2">
                            <label>Distrito</label> 
                        </div>
                        <div class="col-md-2">
                            {{$reclamaciones2[0]->nombre_dist}} 
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
                </div>
            </div>
            @endif
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title">Detalle</h5>
                </div> 
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">                
                            <label>Descripcion</label> 
                            {{$reclamaciones[0]->reclamo}} 
                            <br/>
                        </div>
                        <div class="col-md-12"> 
                            <fieldset>
                                <label class="radio-label">Autoriza ser notificado a traves de su cuenta de correo electronico</label> 
                                {{$reclamaciones[0]->autorizar_envio}}
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            @if($reclamaciones[0]->otro_usuario=='SI')
                <a target="_blank" href="/descargar_pdf/{{$reclamaciones[0]->id}}/1" class="btn btn-primary">Imprimir</a>
            @else
                <a target="_blank" href="/descargar_pdf/{{$reclamaciones[0]->id}}/0" class="btn btn-primary">Imprimir</a>
            @endif