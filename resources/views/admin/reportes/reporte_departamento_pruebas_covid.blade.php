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
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Pruebas COVID</h3>
            </div>
            <div class="col-sm-12">
                <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.reporte_pruebas_covid_fecha')}}">
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
                <table id="examplex" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                    <thead>
                        <tr>
                            <th colspan="2" style="border:0"></th>
                            <th colspan="6" style="border:1px solid #999999;text-align:center">Prueba Molecular</th>
                            <th colspan="6" style="border:1px solid #999999;text-align:center">Prueba Antigena</th>
                            <th style="border:0"></th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="border:1px solid #999999">N.</th>
                            <th rowspan="2" style="border:1px solid #999999">@if(Auth::user()->rol==2) Establecimientos @else Departamento @endif</th>
                            <th style="border:1px solid #999999">POSITIVO</th>
                            <th style="border:1px solid #999999">NEGATIVO</th>
                            <th style="border:1px solid #999999">PENDIENTE</th>
                            <th style="border:1px solid #999999">RECHAZADO</th>
                            <!--th style="border:1px solid #999999">NO HAY PRUEBA</th-->
                            <th style="border:1px solid #999999">SIN INFORMACION</th>
                            <th style="border:1px solid #999999">NO NETLAB</th>
                            <th style="border:1px solid #999999">POSITIVO</th>
                            <th style="border:1px solid #999999">NEGATIVO</th>
                            <th style="border:1px solid #999999">PENDIENTE</th>
                            <th style="border:1px solid #999999">RECHAZADO</th>
                            <!--th style="border:1px solid #999999">NO HAY PRUEBA</th-->
                            <th style="border:1px solid #999999">SIN INFORMACION</th>
                            <th style="border:1px solid #999999">NO NETLAB</th>
                            <th style="border:1px solid #999999">Nro Pruebas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $mpositivo=0;$mnegativo=0;$mpendiente=0;$mrechazado=0;$mnetlab=0;$mnoprueba=0;$msininfo=0;$naislados=0;$ntotal=0;
                            $apositivo=0;$anegativo=0;$apendiente=0;$arechazado=0;$anetlab=0;$anoprueba=0;$asininfo=0;
                        if (isset($resumen)):
                            foreach ($resumen as $key => $rowResumen):
                                ?> 
                                <?php 
                                        $mpositivo=$mpositivo+$rowResumen->_mpositivo;
                                        $mnegativo=$mnegativo+$rowResumen->_mnegativo;
                                        $mpendiente=$mpendiente+$rowResumen->_mpendiente;
                                        $mrechazado=$mrechazado+$rowResumen->_mrechazado;
                                        $mnoprueba=$mnoprueba+$rowResumen->_mnoprueba;
                                        $msininfo=$msininfo+$rowResumen->_msininfo;
                                        $mnetlab=$mnetlab+$rowResumen->_mnetlab;
                                        $apositivo=$apositivo+$rowResumen->_apositivo;
                                        $anegativo=$anegativo+$rowResumen->_anegativo;
                                        $apendiente=$apendiente+$rowResumen->_apendiente;
                                        $arechazado=$arechazado+$rowResumen->_arechazado;
                                        $anoprueba=$anoprueba+$rowResumen->_anoprueba;
                                        $asininfo=$asininfo+$rowResumen->_asininfo;
                                        $anetlab=$anetlab+$rowResumen->_anetlab;

                                        $naislados=$naislados+$rowResumen->_naislados;
                                        $ntotal=$ntotal + $rowResumen->_naislados;
                                        
                                    ?>
                                <tr>
                                    <td><?= ($key + 1) ?></td>
                                    <td align="left"><?= $rowResumen->_nombre_departamento ?></td>
                                    <td align="right"><?= $rowResumen->_mpositivo ?></td>
                                    <td align="right"><?= $rowResumen->_mnegativo ?></td>
                                    <td align="right"><?= $rowResumen->_mpendiente ?></td>
                                    <td align="right"><?= $rowResumen->_mrechazado ?></td>
                                    <!--td align="right"><?= $rowResumen->_mnoprueba ?></td-->
                                    <td align="right"><?= $rowResumen->_msininfo ?></td>
                                    <td align="right"><?= $rowResumen->_mnetlab ?></td>
                                    <td align="right"><?= $rowResumen->_apositivo ?></td>
                                    <td align="right"><?= $rowResumen->_anegativo ?></td>
                                    <td align="right"><?= $rowResumen->_apendiente ?></td>
                                    <td align="right"><?= $rowResumen->_arechazado ?></td>
                                    <!--td align="right"><?= $rowResumen->_anoprueba ?></td-->
                                    <td align="right"><?= $rowResumen->_asininfo ?></td>
                                    <td align="right"><?= $rowResumen->_anetlab ?></td>
                                    <td align="right"><?= $rowResumen->_naislados ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td align="right"><strong><?= $mpositivo ?></strong></td>
                                    <td align="right"><strong><?= $mnegativo ?></strong></td>
                                    <td align="right"><strong><?= $mpendiente ?></strong></td>
                                    <td align="right"><strong><?= $mrechazado ?></strong></td>
                                    <!--td align="right"><strong><?= $mnoprueba ?></strong></td-->
                                    <td align="right"><strong><?= $msininfo ?></strong></td>
                                    <td align="right"><strong><?= $mnetlab ?></strong></td>                                    
                                    <td align="right"><strong><?= $apositivo ?></strong></td>
                                    <td align="right"><strong><?= $anegativo ?></strong></td>
                                    <td align="right"><strong><?= $apendiente ?></strong></td>
                                    <td align="right"><strong><?= $arechazado ?></strong></td>
                                    <!--td align="right"><strong><?= $anoprueba ?></strong></td-->
                                    <td align="right"><strong><?= $asininfo ?></strong></td>
                                    <td align="right"><strong><?= $anetlab ?></strong></td>
                                    <td align="right"><strong><?= $naislados ?></strong></td>
                                    
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12">
                <div style="margin: 10px 10px 10px 10px; border-top: 1px solid gray">
                    <div id="container3" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div id="container1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 20px 20px 20px 20px"></div>
                </div>
                <div class="col-sm-6">
                    <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 20px 20px 20px 20px"></div>
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
    Highcharts.chart('container3', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br>Pruebas Covid'
        },
        subtitle: {
            text: '<br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        xAxis: {
            
            categories: [
            'Molecular',
            'Antigena',
            ],
            crosshair: true
        },
        yAxis: {
            title: {
                text: 'Cantidad de pruebas'
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

       
        

        series: [{
            name: 'Positivos',
            data: [{{$mmpositivo}}, {{$nnpositivo}}]

        }, {
            name: 'Negativos',
            data: [{{$mmnegativo}}, {{$nnnegativo}}]

        }, {
            name: 'Pendiente',
            data: [{{$mmpendiente}}, {{$nnpendiente}}]

        }, {
            name: 'Rechazado',
            data: [{{$mmrechazado}}, {{$nnrechazado}}]

        }, {
            name: 'Sin Informacion',
            data: [{{$mmsininfo}}, {{$nnsininfo}}]

        }, {
            name: 'Netlab',
            data: [{{$mmnetlab}}, {{$nnnetlab}}]

        }],


                
    });

    Highcharts.chart('container2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br><span style="font-size: 17px; font-weight:bold">Pruebas Positivos por Sexo - Antigeno</span><br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> <br>Pruebas Positivos Antigeno:{point.y} <br> {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [{
                        name: 'M',
                        y: {{$AM}}
                    },{
                        name: 'F',
                        y: {{$AF}}
                    }
                ]
        }]
    });  

    Highcharts.chart('container1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br><span style="font-size: 17px; font-weight:bold">Pruebas Positivos por Sexo - Molecular</span><br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> <br>Pruebas Positivos Molecular:{point.y} <br> {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [{
                        name: 'M',
                        y: {{$MM}}
                    },{
                        name: 'F',
                        y: {{$MF}}
                    }
                ]
        }]
    });  


});
</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
<script src="{{asset('js/highcharts.js')}}"></script>
@stop
