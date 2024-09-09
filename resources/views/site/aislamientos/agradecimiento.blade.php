@extends('layouts.template')
@section('content')
    <div class="content">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="panel panel-primary filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">Tu salud, nuestro compromiso.</h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-md-12">                                
                                Estimado (a) <b><?php echo $nombre ?></b> con <b> DNI <?php  echo $dni ?></b> se ha registrado al sistema de aislamiento por factor de Riesgo,  muy pronto un personal medico revisara la informacion y se comunicara con usted para corroborar dicha informacion.
                                <?php $ruta='/images/reclamacion_pnp.jpg'; ?><br/><br/>
                                <p align="center">
                                <img src="{!!url($ruta)!!}" alt="DIRECCIÓN DE SANIDAD POLICIAL - DIRSAPOL"></p>
                            </div>     
                            <div class="col-md-12">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-6">
                                    <p align="center">
                                    <a href="{!! route('aislamientosite.pdf_descarga', [$idaislamiento,$dni,1]) !!}" class="btn btn-primary btn-md">Descargar PDF <i class="fa fa-file"></i> </a>
                                    <a href="{!! route('aislamientosite.pdf_descarga', [$idaislamiento,$dni,2]) !!}" class="btn btn-primary btn-md">Imprimir <i class="fa fa-file"></i> </a>                                    
                                </div>
                                <div class="col-md-3">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection