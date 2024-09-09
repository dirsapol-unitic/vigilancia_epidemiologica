<?php 
//use DB;
use App\Models\Sintoma;

ini_set('memory_limit', '-1');
set_time_limit(0);

$rol=Auth::user()->rol;   

?>
@extends('layouts.master_ficha1')
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
            <div class="col-sm-12">
                <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.reporte_departamento_hospitalizados_fecha')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="control-label"> Fecha Desde </label><br/>
                            <input type="date" name="fechaDesde" id="fechaDesde" value="<?php echo date("Y-m-d", strtotime($fechaDesde)); ?>"  class="form-control">
                            <input value="{{ Auth::user()->id }}" name="id_user" type="hidden">
                            
                        </div>
                        <div class="col-md-2">    
                            <label class="control-label"> Fecha Hasta </label><br/> 
                            <input type="date" name="fechaHasta" id="fechaHasta" value="<?php echo date("Y-m-d", strtotime($fechaHasta)); ?>"  class="form-control">
                        </div>
                        <div class="col-md-3">
                            <br/>
                            <input class="form-control btn btn-info input-sm" value="Buscar" type="submit">
                        </div>
                    </div>
                </form>
                <br/>
            </div>
            <hr>
            <div class="col-sm-12">
                <table id="examplez" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                    <thead>
                        <tr>
                            <th colspan="2" style="border:0"></th>
                            <th colspan="6" style="border:1px solid #999999;text-align:center">Personal Hospitalizados</th>
                            <th style="border:0"></th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="border:1px solid #999999">N.</th>
                            <th rowspan="2" style="border:1px solid #999999">@if(Auth::user()->rol==2) Establecimientos @else Departamento @endif</th>
                            <th style="border:1px solid #999999">Actividad</th>
                            <th style="border:1px solid #999999">Retiro</th>
                            <th style="border:1px solid #999999">Nro Titular</th>
                            <th style="border:1px solid #999999">Familiares</th>
                            <th style="border:1px solid #999999">Civiles</th>
                            <th style="border:1px solid #999999">Nro Hospitalizados</th>
                            <!--th style="border:1px solid #999999">Total</th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $nractividad=0;$nretiro=0;$naislados=0;$ntitulares=0;$nfamiliares=0;$ntotal=0;$nciviles=0;
                        if (isset($resumen_ho)):
                            foreach ($resumen_ho as $key => $rowResumen):
                                ?>
                                <?php 
                                        $nractividad=$nractividad+$rowResumen->_nactividad;
                                        $nretiro=$nretiro+$rowResumen->_nretiro;
                                        //$naislados=$naislados+$rowResumen->_naislados;
                                        $ntitulares=$ntitulares+$rowResumen->_ntitulares;
                                        $nfamiliares=$nfamiliares+$rowResumen->_nfamiliares;
                                        $nciviles=$nciviles+ $rowResumen->_ncivil;
                                        $naislados=$rowResumen->_nactividad + $rowResumen->_nretiro + $rowResumen->_nfamiliares+ $rowResumen->_ncivil;
                                        $ntotal = $ntotal + $naislados ;
                                        
                                    ?>
                                <tr>
                                    <td><?= ($key + 1) ?></td>
                                    <td align="left"><?= $rowResumen->_nombre_departamento ?></td>
                                    <td align="right"><?= $rowResumen->_nactividad ?></td>
                                    <td align="right"><?= $rowResumen->_nretiro ?></td>
                                    <td align="right"><?= $rowResumen->_ntitulares ?></td>
                                    <td align="right"><?= $rowResumen->_nfamiliares ?></td>
                                    <td align="right"><?= $rowResumen->_ncivil ?></td>
                                    <td align="right"><?= $naislados ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                            <tr>    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td align="right"><strong><?= $nractividad ?></strong></td>
                                    <td align="right"><strong><?= $nretiro ?></strong></td>
                                    <td align="right"><strong><?= $ntitulares ?></strong></td>
                                    <td align="right"><strong><?= $nfamiliares ?></strong></td>
                                    <td align="right"><strong><?= $nciviles ?></strong></td>
                                    <td align="right"><strong><?= $ntotal ?></strong></td>
                                    
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12">
                <div style="margin: 10px 10px 10px 10px; border-top: 1px solid gray">
                    <div id="container4" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
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
$(function () {
        

    Highcharts.chart('container4', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br>Hospitalizados'
        },
        subtitle: {
            text: '<br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        xAxis: {
            
            categories: [
            'ACTIVIDAD',
            'RETIRO',
            'FAMILIAR',
            'CIVIL'
            ],
            crosshair: true
        },
        yAxis: {
            title: {
                text: 'Cantidad de Hospitalizados'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {           
            pointFormat: '{point.y}</b> Cantidad Hospitalizados<br/>'
        },

        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                        name: 'Actividad',
                        y: {{$nroactividad}}
                    },{
                        name: 'Retiro',
                        y: {{$nroretiro}}
                    },{
                        name: 'Familiar',
                        y: {{$nrofamiliares}}
                    },{
                        name: 'Civil',
                        y: {{$nrociviles}}
                    }
                ]
        }],

        

                
    });

    


    


});
</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
<script src="{{asset('js/highcharts.js')}}"></script>
@stop
