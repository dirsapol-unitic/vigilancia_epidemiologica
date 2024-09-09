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
                        <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.busca_reporte_general')}}">
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
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 20px 20px 20px 20px"></div>
                </div>
                <div class="col-sm-6">
                    <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 20px 20px 20px 20px"></div>
                </div>
            </div>
            @if(Auth::user()->rol==1)
                <div class="col-sm-12">
                    <div style="margin: 10px 10px 10px 10px; border-top: 1px solid gray">
                        <div id="container3" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            @endif
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
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br><span style="font-size: 17px; font-weight:bold">Personal PNP Aislados por parentesco</span><br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
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
                    format: '<b>{point.name}</b> <br>Aislados:{point.y} <br> {point.percentage:.1f} %',
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
                        name: 'TITULARES',
                        y: {{$titular}}
                    },
                    {
                        name: 'PADRE',
                        y: {{$padre}}
                    },
                    {
                        name: 'MADRE',
                        y: {{$madre}}
                    },
                    {
                        name: 'HIJO',
                        y: {{$hijo}}
                    },
                    {
                        name: 'HIJA',
                        y: {{$hija}}
                    },
                    {
                        name: 'EX-CONYUGE',
                        y: {{$ex_conyugue}}
                    },
                    {
                        name: 'ESPOSA',
                        y: {{$esposa}}
                    },
                    {
                        name: 'ESPOSO',
                        y: {{$esposo}}
                    },
                    {
                        name: 'OTRO',
                        y: {{$otro}}
                    }
                ]
        }]
    });        

    
    
    Highcharts.chart('container2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br><span style="font-size: 17px; font-weight:bold">Personal PNP Atendidos por sexo</span><br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
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
                    format: '<b>{point.name}</b> <br>Atenciones:{point.y} <br> {point.percentage:.1f} %',
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
                        y: {{$M[0]->contador}}
                    },{
                        name: 'F',
                        y: {{$F[0]->contador}}
                    }
                ]
        }]
    });        

    Highcharts.chart('container4', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br>Aislados por Clasificacion'
        },
        subtitle: {
            text: '<br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        xAxis: {
            
            categories: [
            'CONFIRMADO',
            'PROBABLE',
            'SOSPECHOSO',
            'DESCARTADO',
            'SIN REGITRO',
            ],
            crosshair: true
        },
        yAxis: {
            title: {
                text: 'Cantidad de aislados'
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
            pointFormat: '{point.y}</b> cantidad aislados<br/>'
        },

        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                        name: 'Confirmado',
                        y: {{$confirmado[0]->contador}}
                    },{
                        name: 'Probable',
                        y: {{$probable[0]->contador}}
                    },{
                        name: 'sospechoso',
                        y: {{$sospechoso[0]->contador}}
                    },{
                        name: 'Descartado',
                        y: {{$descartado[0]->contador}}
                    },{
                        name: 'Sin Registro',
                        y: {{$sr[0]->contador}}
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


    Highcharts.chart('container3', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<span style="text-transform: uppercase; font-size:13px"></span><br>TOP 10 de Departamentos con mas Aislados'
        },
        subtitle: {
            text: '<br><span style="font-size:15px">Del {{$fechaDesde}} al {{$fechaHasta}}</span>'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Cantidad de aislados'
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
            pointFormat: '{point.y}</b> cantidad aislados<br/>'
        },

        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [
                {{-- */$x=0;/* --}}
                @foreach($nro_departamentos as $p)
                {{-- */$x++;/* --}}
                    @if($x<=1)
                    {   name: '<span style="font-size:8px">{{$p->nombre_dpto}}</span>',
                        y: {{$p->saldo}},
                        drilldown: '{{$p->nombre_dpto}}'},
                    @endif
                @endforeach
            ]
        }],        
    });


});


</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
<script src="{{asset('js/highcharts.js')}}"></script>
@stop
