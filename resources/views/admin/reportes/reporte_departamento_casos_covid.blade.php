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
                <h3 class="panel-title">Reporte de Casos COVID</h3>
            </div>
            <div class="col-sm-12">
                <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.reporte_casos_covid_fecha')}}">
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
                <table id="exampley" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                    <thead>
                        <tr>
                            <th colspan="2" rowspan="2" style="border:0"></th>
                            <th colspan="6" style="border:1px solid #999999;text-align:center">Titular</th>
                            <th colspan="3" rowspan="2" style="border:1px solid #999999;text-align:center">Familiar</th>
                            <th colspan="3" rowspan="2" style="border:1px solid #999999;text-align:center">Civil</th>
                            <th rowspan="2" style="border:0"></th>
                        </tr>
                        <tr>
                            <th colspan="3" style="border:1px solid #999999;text-align:center">Actividad</th>
                            <th colspan="3" style="border:1px solid #999999;text-align:center">Retiro</th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="border:1px solid #999999">N.</th>
                            <th rowspan="2" style="border:1px solid #999999">@if(Auth::user()->rol==2) Establecimientos @else Departamento @endif</th>
                            <th style="border:1px solid #999999">POSITIVO</th>
                            <th style="border:1px solid #999999">NEGATIVO</th>
                            <th style="border:1px solid #999999">OTRO</th>
                            <th style="border:1px solid #999999">POSITIVO</th>
                            <th style="border:1px solid #999999">NEGATIVO</th>
                            <th style="border:1px solid #999999">OTRO</th>
                            <th style="border:1px solid #999999">POSITIVO</th>
                            <th style="border:1px solid #999999">NEGATIVO</th>
                            <th style="border:1px solid #999999">OTRO</th>
                            <th style="border:1px solid #999999">POSITIVO</th>
                            <th style="border:1px solid #999999">NEGATIVO</th>
                            <th style="border:1px solid #999999">OTRO</th>
                            <th style="border:1px solid #999999">Nro Aislados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $ntitular_actividad_positivo=0;$ntitular_actividad_negativo=0;$ntitular_retiro_positivo=0;$ntitular_retiro_negativo=0;$naislados=0;$ntotal=0; $familiar_positivo=0;$familiar_negativo=0;$civil_positivo=0;$civil_negativo=0;$otro_actividad=0;$otro_retiro=0;$otro_familiar=0;$otro_civil=0;

                           
                        if (isset($resumen)):
                            foreach ($resumen as $key => $rowResumen):
                                ?>
                                <?php
                                        $ntitular_actividad_positivo=$ntitular_actividad_positivo+$rowResumen->_ntitular_actividad_positivo;
                                        $ntitular_actividad_negativo=$ntitular_actividad_negativo+$rowResumen->_ntitular_actividad_negativo;
                                        $ntitular_retiro_positivo=$ntitular_retiro_positivo+$rowResumen->_ntitular_retiro_positivo;
                                        $ntitular_retiro_negativo=$ntitular_retiro_negativo+$rowResumen->_ntitular_retiro_negativo;
                                        $familiar_positivo=$familiar_positivo+$rowResumen->_familiar_positivo;
                                        $familiar_negativo=$familiar_negativo+$rowResumen->_familiar_negativo;
                                        $civil_positivo=$civil_positivo+$rowResumen->_civil_positivo;
                                        $civil_negativo=$civil_negativo+$rowResumen->_civil_negativo;
                                        $otro_actividad=$otro_actividad+$rowResumen->_otro_actividad;
                                        $otro_retiro=$otro_retiro+$rowResumen->_otro_retiro;
                                        $otro_familiar=$otro_familiar+$rowResumen->_otro_familiar;
                                        $otro_civil=$otro_civil+$rowResumen->_otro_civil;
                                        $naislados=$naislados+$rowResumen->_naislados;
                                        $ntotal=$ntotal + $rowResumen->_naislados;
                                       
                                    ?>
                                <tr>
                                    <td><?= ($key + 1) ?></td>
                                    <td align="left"><?= $rowResumen->_nombre_departamento ?></td>
                                    <td align="right"><?= $rowResumen->_ntitular_actividad_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_ntitular_actividad_negativo ?></td>
                                    <td align="right"><?= $rowResumen->_otro_actividad ?></td>
                                    <td align="right"><?= $rowResumen->_ntitular_retiro_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_ntitular_retiro_negativo ?></td>
                                    <td align="right"><?= $rowResumen->_otro_retiro ?></td>
                                    <td align="right"><?= $rowResumen->_familiar_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_familiar_negativo ?></td>
                                    <td align="right"><?= $rowResumen->_otro_familiar ?></td>
                                    <td align="right"><?= $rowResumen->_civil_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_civil_negativo ?></td>
                                    <td align="right"><?= $rowResumen->_otro_civil ?></td>
                                    <td align="right"><?= $rowResumen->_naislados ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td align="right"><strong><?= $ntitular_actividad_positivo ?></strong></td>
                                    <td align="right"><strong><?= $ntitular_actividad_negativo ?></strong></td>
                                    <td align="right"><strong><?= $otro_actividad ?></strong></td>
                                    <td align="right"><strong><?= $ntitular_retiro_positivo ?></strong></td>
                                    <td align="right"><strong><?= $ntitular_retiro_negativo ?></strong></td>
                                    <td align="right"><strong><?= $otro_retiro ?></strong></td>
                                    <td align="right"><strong><?= $familiar_positivo ?></strong></td>
                                    <td align="right"><strong><?= $familiar_negativo ?></strong></td>
                                    <td align="right"><strong><?= $otro_familiar ?></strong></td>
                                    <td align="right"><strong><?= $civil_positivo ?></strong></td>
                                    <td align="right"><strong><?= $civil_negativo ?></strong></td>
                                    <td align="right"><strong><?= $otro_civil ?></strong></td>
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
                <div style="margin: 10px 10px 10px 10px; border-top: 1px solid gray">
                    <div id="container2" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
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

    Highcharts.chart('container2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br><span style="font-size: 17px; font-weight:bold">Casos Positivos por Sexo</span><br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
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
                    format: '<b>{point.name}</b> <br>Casos Positivos:{point.y} <br> {point.percentage:.1f} %',
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
                        y: {{$M}}
                    },{
                        name: 'F',
                        y: {{$F}}
                    }
                ]
        }]
    });  

    Highcharts.chart('container3', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br>Casos de Covid'
        },
        subtitle: {
            text: '<br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        xAxis: {
            
            categories: [
            'Actividad',
            'Retiro',
            'Familiar',
            'Civil',
            ],
            crosshair: true
        },
        yAxis: {
            title: {
                text: 'Cantidad de casos'
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
            data: [{{$ntitular_actividad_positivo}}, {{$ntitular_retiro_positivo}}, {{$familiar_positivo}}, {{$civil_positivo}}]

        }, {
            name: 'Negativo',
            data: [{{$ntitular_actividad_negativo}}, {{$ntitular_retiro_negativo}}, {{$familiar_negativo}}, {{$civil_negativo}}]

        }],


                
    });


});
</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
<script src="{{asset('js/highcharts.js')}}"></script>
@stop