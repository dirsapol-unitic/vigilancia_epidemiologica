<?php 
ini_set('memory_limit', '-1');
set_time_limit(0);
?>
@extends('layouts.master')
@section('renderjs')

<style>
    .table-sortable tbody tr {
        cursor: move;
    }
    
    #global {
        min-height: 650px !important;
        /*width: auto;*/
        width: 100%;
        border: 1px solid #ddd;
        margin:15px
    }

    .margin{

        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }

    .row{
        margin-top:10px;
        padding: 0 10px;
    }
    .clickable{
        cursor: pointer;   
    }

    .panel-heading div {
        margin-top: -18px;
        font-size: 15px;        
    }
    .panel-heading div span{
        margin-left:5px;
    }
    .panel-body{
        display: block;
    }

    .dataTables_filter {
        display: none;
    }
    
    .help-block {
        display: block;
        margin-top: 1px;
        margin-bottom: 10px;
        color: #737373;
    }

</style>


@endsection
@section('content')
<div class="content">
    <div class="clearfix"></div>    
    <div class="box box-primary">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="panel-body">
                    <div class="col-sm-12">
                        <form class="form-horizontal" method="post" action="{{ route('reclamaciones.listar_reclamaciones')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label" for="textinput">Nro. Documento</label>  
                                    <input id="dni_beneficiario" name="dni_beneficiario" type="text" placeholder="" class="form-control input-sm" maxlength="12" value="<?php echo $dni_beneficiario ?>">
                                </div>                            
                                <div class="col-md-3">
                                    <label class="control-label" for="textinput">Nro. Reclamacion</label>  
                                    <input id="nro_reclamacion" name="nro_reclamacion" type="text" placeholder="" class="form-control input-sm" value="<?php echo $nro_reclamacion ?>" onKeyPress="return soloNumeros(event)" maxlength="15">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Tiempo</label>
                                    <select class="form-control input-sm select2" name="tiempo"  id="tiempo" tabindex="15" style="width: 100%">
                                        <option value="4"> Todas </option>
                                        <option value="1" <?php if (isset($tiempo) && $tiempo == 1) echo "selected='selected'"; ?>>01-10 dias </option>
                                        <option value="2" <?php if (isset($tiempo) && $tiempo == 2) echo "selected='selected'"; ?>>11-20 dias </option>
                                        <option value="3" <?php if (isset($tiempo) && $tiempo == 3) echo "selected='selected'"; ?>>21-30 dias </option>
                                    </select>
                                </div>
                                <div class="col-md-3"><br/>
                                    <input class="form-control btn btn-info input-sm" value="Buscar" type="submit">
                                </div>

                            </div>
                            <div class="row">                                
                                <div class="col-md-3">
                                    <label class="control-label"> Fecha Desde </label><br/> 
                                    <input type="date" name="fechaDesde" id="fechaDesde" value="<?php echo date("Y-m-d", strtotime($fechaDesde)); ?>"  class="form-control">
                                    <input value="{{ Auth::user()->id }}" name="id_user" type="hidden">
                                    <input value="{{ Auth::user()->id_establecimiento }}" name="id_establecimiento" type="hidden">
                                    <input value="D1" name="tipo_consulta" type="hidden">
                                </div>
                                <div class="col-md-3">                                    
                                    <label class="control-label"> Fecha Hasta </label><br/> 
                                    <input type="date" name="fechaHasta" id="fechaHasta" value="<?php echo date("Y-m-d", strtotime($fechaHasta)); ?>"  class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Estado</label>
                                    <select class="form-control input-sm select2" name="estado"  id="estado" tabindex="15" style="width: 100%">   
                                        <option value="3"> Todas </option>                                     
                                        <option value="1" <?php if (isset($estado) && $estado == 1) echo "selected='selected'"; ?>>Pendiente</option>
                                        <option value="2" <?php if (isset($estado) && $estado == 2) echo "selected='selected'"; ?>>En tramite</option>
                                        <option value="0" <?php if (isset($estado) && $estado == 0) echo "selected='selected'"; ?>>Invalidados</option>
                                    </select>
                                </div>
                                <div class="col-md-3"><br/>
                                    <a class="btn btn-success form-control input-sm" href="javascript:void(0)" onclick="reporteReclamacion()" >
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Reporte
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <legend>

                        </legend>
                    </div>                
                    <div class="clearfix"><br/><br/></div>    
                    
                    <div class="col-md-12" style="margin-top: 10px"  id="global">
                        <!--<table  class="table table-list-search">-->
                        <table id="example" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Nro. Reclamacion</th>
                                    <th>Hora</th>
                                    <th>Fecha</th>                                    
                                    <th>Doc.</th>
                                    <th>Nro. Doc.</th>
                                    <th>Beneficiario</th>                                                       
                                    <th>IPRESS</th>
                                    <th>Estado</th>
                                    <th>Tiempo</th>
                                    <th>Invalidar</th>
                                    <th>Solucionar</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $n = 0; ?>
                                @foreach($reclamaciones as $r)
                                <tr>
                                    <td><?php
                                        $n++;
                                        echo $n;
                                        ?></td>
                                    <td>{{$r->nro_reclamacion}}</td> 
                                    <td>
                                        <?php
                                        $originalDate3 = $r->created_at;
                                        $horaR = date("H:i:s", strtotime($originalDate3));
                                        echo $horaR;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        $originalDate1 = $r->fecha_reclamacion;
                                        $fechaE = date("d-m-Y", strtotime($originalDate1));
                                        echo $fechaE;
                                        ?> 
                                    </td>
                                    <td>{{$r->tipo_doc}}</td> 
                                    <td>{{$r->nro_doc}}</td> 
                                    <td>{{$r->apellido_paterno}} {{$r->apellido_materno}}, {{$r->nombres}} </td> 
                                    <td>{{$r->nombre}}</td>   
                                    <td><?php
                                        
                                        switch($r->estado){
                                            case 1: echo "Pendiente"; break;
                                            case 2: echo "En trámite"; break;
                                        }

                                    ?></td>   
                                    <?php 

                                        $color = "";
                                        $situacionTemp = "";
                                        if ($r->tiempo < 10):
                                            $color = "#FF0000"; //rojo
                                            $situacionTemp = 1;
                                        else:
                                            if ($r->tiempo >= 10 && $r->tiempo <= 20):
                                                $color = "#FFC000"; // amarillo
                                                $situacionTemp = 4;
                                            endif;
                                            if ($r->tiempo > 20 && $r->tiempo <= 31):
                                                $color = "#70AD47"; //verde
                                                $situacionTemp = 3;
                                            endif;

                                        endif;
                                        /*
                                        $fechaSalida = Carbon::parse($hospitalizado->fecha_salida);
                                        $fechaActual = Carbon::parse($fecha);
                                        //dado de alta
                                        $diasDiferencia = $fechaActual->diffInDays($fechaSalida);
                                        */

                                    ?>
                                    <td align="left" style="padding-right:0px;padding-left:0px;margin-left:0px;margin-right:0px">
                                    <?php //echo $r['egresos']."|".$r['recetas_devueltas']."|".$cpma;  ?>
                                    <i class="fa fa-flag fa-2x" style="color:<?php echo $color ?>;position:relative">
                                    </i>
                                    <div style="color:<?php echo $color ?>;float:right;margin-right:0%;font-size:11px">{{ $r->tiempo }} dias</div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $id_reclamacion = (isset($r->id) && $r->id > 0) ? $r->id : "";
                                        if (isset($estado) && $estado == 2) {
                                            ?>
                                            <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Invalidar Receta</b>">
                                                <button type="button" class="btn btn-danger btn-xs" disabled=""><i class="fa fa-xing"></i></button>
                                            </div>
                                        <?php } else
                                                { ?>
                                                    <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Invalidar Reclamacion</b>">
                                                        <a href="/ver_reclamacion_atendida/1/{{ Auth::user()->id }}/{{$r->nro_reclamacion}}/{{$r->id}}/{{$r->id_establecimiento}}" class="btn btn-danger btn-xs"><i class="fa fa-xing"></i></a>
                                                    </div>
                                        <?php   } ?>
                                    </td>
                                    <td class="text-center">
                                        <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Solucionar reclamacion</b>">
                                            <a href="/solucionar_reclamacion/{{ Auth::user()->id }}/{{$r->nro_reclamacion}}/{{$r->id}}/{{$r->id_establecimiento}}" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Ver detalle reclamacion</b>">
                                            <button type="button" class="btn btn-success btn-xs" onclick="ver_det_reclamacion('{{ Auth::user()->id }}','{{$r->nro_reclamacion}}','{{$r->id}}','{{$r->id_establecimiento}}')"><i class="fa fa-search"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach                      
                            </tbody>
                        </table>   
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="myModalDetR" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">DETALLE DE RECLAMACION</h5>
            </div>
            <div class="modal-body">
                <div id="muestra-det-reclamacion"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$('#example').dataTable( {
  "pageLength": 1000
} );
//Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
@stop
