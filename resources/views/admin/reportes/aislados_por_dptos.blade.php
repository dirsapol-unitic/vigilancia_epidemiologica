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
                        <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.reporte_departamentos_fecha')}}">
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
                    </div>
                    <hr>

                    <hr>
            <div class="col-sm-12">
                <br/>
                <table id="examplex" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                    <thead>
                        <tr>
                            <th colspan="2" style="border:0"></th>
                            @if(Auth::user()->rol==2)
                                <th colspan="6" style="border:1px solid #999999;text-align:center">Personal Atendidos
                                    registrados en el {{Auth::user()->nombre_establecimiento}}
                                </th>
                            @else
                                <th colspan="6" style="border:1px solid #999999;text-align:center">Personal Atendidos
                                    registrados a nivel nacional
                                </th>
                            @endif
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
                            <th style="border:1px solid #999999">Nro Aislados</th>
                            <!--th style="border:1px solid #999999">Total</th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $nractividad=0;$nretiro=0;$naislados=0;$ntitulares=0;$nfamiliares=0;$ntotal=0;$nciviles=0;
                        if (isset($resumen)):
                            foreach ($resumen as $key => $rowResumen):
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
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br>Aislados Atendidos'
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
                text: 'Cantidad de Atendidos'
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
            pointFormat: '{point.y}</b> cantidad atendidos<br/>'
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

        /*

        series: [{
            name: 'Tokyo',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'New York',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }, {
            name: 'London',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

        }, {
            name: 'Berlin',
            data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

        }],
*/

                
    });

    


    


});


</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
<script src="{{asset('js/highcharts.js')}}"></script>
@stop
