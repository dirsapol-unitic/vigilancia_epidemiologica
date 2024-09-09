@extends('layouts.app')
@section('renderjs')
<style>
    .table {
        padding: 8px;
        line-height: 1.428571429;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    .center {
        margin-top:50px;   
    }

    .modal-header {
        padding-bottom: 5px;
    }

    .modal-footer {
        padding: 0;
    }

    .modal-footer .btn-group button {
        height:40px;
        border-top-left-radius : 0;
        border-top-right-radius : 0;
        border: none;
        border-right: 1px solid #ddd;
    }

    .modal-footer .btn-group:last-child > button {
        border-right: 0;
    }
    td{
        padding-left: 10px;
        padding-right: 10px
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="clearfix"></div>    
    <div class="box box-primary">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="panel panel-primary filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">LIBRO DE RECLAMACIONES </h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            <br/>
                            <!-- Codigo Field -->
                            <div class="col-md-1">
                                <label>Fecha</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->fecha_reclamacion}}                                
                            </div>
                            <div class="form-group col-sm-4">
                                <br/>
                            </div>
                            <div class="col-md-3">
                                <label>Hoja de Reclamación en Salud</label> 
                            </div>
                            <div class="col-md-2">
                                {{$reclamaciones[0]->nro_reclamacion}} 
                                <br/>
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
                <div class="panel panel-primary filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">USUARIO AFECTADO </h3>
                    </div>  

                    <div class="box-body">
                        <div class="row">
                            <br/>
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
                <div class="panel panel-primary filterable" >
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
                <div class="panel panel-success filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">DETALLE DEL RECLAMO </h3>
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
                @if($reclamaciones[0]->estado==1) 
                    <div class="col-md-12" style="margin-bottom:10px">
                        <a data-toggle="modal" data-target="#squarespaceModal" class="btn btn-danger">
                            <i class="fa fa-xing"></i>Invalidar Reclamacion
                        </a>      
                        <h1 class="pull-right">
                        <a href="{!! route('reclamaciones.todas_reclamaciones') !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
                        </h1>
                    </div>
                    @else
                    <div class="col-md-12">
                        <button class="btn btn-danger" disabled="">
                            Registro de Reclamacion invalidada
                        </button>
                        <h1 class="pull-right">
                        <a href="{!! route('reclamaciones.todas_reclamaciones') !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
                        </h1>
                    </div>
                    <div class="col-md-8" style="border: 1px solid red; margin-top: 10px; background-color: #FFDA6A">
                        Motivo: {{$reclamaciones[0]->motivo}}<br>
                        <?php
                        $originalDate8 = $reclamaciones[0]->fecha_eliminacion;
                        $fecha_eliminacion = date("d-m-Y", strtotime($originalDate8));
                        ?>
                        Fecha de Invalidaci&oacute;n: <?php echo $fecha_eliminacion ?><br>
                        Usuario Invalidador: {{$reclamaciones[0]->usuario_invalidador}}
                    </div>
                @endif

            </div>              
        </div>
    </div>
</div>

<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel">Invalidar Reclamacion</h3>
            </div>
            <div class="modal-body">
                <!-- content goes here -->
                <form class="" method="post" action="{{ route('reclamaciones.invalidar_reclamacion')}}" id="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Escribir el motivo para invalidar el registro de esta reclamacion</label>
                        <input type="text" class="form-control" id="motivo" name="motivo" placeholder="" required="">
                        <input type="hidden" class="form-control" id="id_establecimiento" name="id_establecimiento" value="{{$reclamaciones[0]->id_establecimiento}}">
                        <input type="hidden" class="form-control" id="nro_reclamacion" name="nro_reclamacion" value="{{$reclamaciones[0]->nro_reclamacion}}">
                        <input type="hidden" class="form-control" id="id_reclamacion" name="id_reclamacion" value="{{$reclamaciones[0]->id}}">
                        <!--Se añadio la fecha -->
                        <input type="hidden" class="form-control" id="fecha_reclamacion" name="fecha_reclamacion" value="{{$reclamaciones[0]->fecha_reclamacion}}">                        
                        <!-- fin -->
                        <input type="hidden" class="form-control" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
                    </div>                    
                    <div class="form-group">
                        <input id="btnInvalidar" class="btn btn-danger" type="submit" value="Invalidar">                        
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection




