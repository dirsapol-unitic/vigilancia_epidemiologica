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
                <h3 class="panel-title">Reporte Casos Positivos COVID</h3>
            </div>
            <hr>
            <div class="col-sm-3">
                <table id="example" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                    <thead>
                        <tr>
                            <th rowspan="2" style="border:1px solid #999999">Semana</th>
                            <th colspan="2" style="border:1px solid #999999;text-align:center">Titular</th>
                            <th rowspan="2" style="border:1px solid #999999;text-align:center">Familiar</th>
                            <th rowspan="2" style="border:1px solid #999999;text-align:center">Civil</th>
                            <th rowspan="2" style="border:0"></th>
                        </tr>
                        <tr>
                            <th style="border:1px solid #999999;text-align:center">Actividad</th>
                            <th style="border:1px solid #999999;text-align:center">Retiro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $ntitular_actividad_positivo=0;$ntitular_retiro_positivo=0;$naislados=0;$ntotal=0; $familiar_positivo=0;$civil_positivo=0;

                        if (isset($resumen)):
                            foreach ($resumen as $key => $rowResumen):
                                ?>
                                <?php
                                        $ntitular_actividad_positivo=$ntitular_actividad_positivo+$rowResumen->_ntitular_actividad_positivo;
                                        $ntitular_retiro_positivo=$ntitular_retiro_positivo+$rowResumen->_ntitular_retiro_positivo;
                                        $familiar_positivo=$familiar_positivo+$rowResumen->_familiar_positivo;
                                        $civil_positivo=$civil_positivo+$rowResumen->_civil_positivo;
                                        //$naislados=$naislados+$rowResumen->_naislados;
                                        //$ntotal=$ntotal + $rowResumen->_naislados;
                                    ?>
                                <tr>
                                    <td align="left"><?= $rowResumen->_semana ?></td>
                                    <td align="right"><?= $rowResumen->_ntitular_actividad_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_ntitular_retiro_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_familiar_positivo ?></td>
                                    <td align="right"><?= $rowResumen->_civil_positivo ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                            <tr>    <td><strong>TOTAL</strong></td>
                                    <td align="right"><strong><?= $ntitular_actividad_positivo ?></strong></td>
                                    <td align="right"><strong><?= $ntitular_retiro_positivo ?></strong></td>
                                    <td align="right"><strong><?= $familiar_positivo ?></strong></td>
                                    <td align="right"><strong><?= $civil_positivo ?></strong></td>
                                    
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-9">
              <!-- LINE CHART -->
                <div class="box-body">
                  <div class="chart">
                    <canvas id="lineChart" style="height:650px"></canvas>
                  </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div style="width: 30px; height: 30px; background-color: rgb(210, 214, 222);" class="jsx-2942312965 card mb-2"></div>TITULARES
                    </div>
                    <div class="col-md-3">
                        <div style="width: 30px; height: 30px; background-color: rgb(114,020,034);" class="jsx-2942312965 card mb-2"></div>RETIRADO
                    </div>
                    <div class="col-md-3">
                        <div style="width: 30px; height: 30px; background-color: rgb(64, 167, 58);" class="jsx-2942312965 card mb-2"></div>FAMILIAR
                    </div>
                    <div class="col-md-3">
                        <div style="width: 30px; height: 30px; background-color: rgb(60,141,188);" class="jsx-2942312965 card mb-2"></div>CIVIL
                    </div>
                </div>
                
                <!-- /.box-body -->
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
<script src="{{asset('js/highcharts.js')}}"></script>

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    //var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    var areaChartCanvas = $("#lineChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas);

    var areaChartData = {
      <?php echo $label; ?>
      datasets: [
        {
          label               : 'TITULARES',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          <?php echo $data_titular; ?>
        },
        {
          label               : 'RETIRADO',
          fillColor           : 'rgba(114,020,034,0.9)',
          strokeColor         : 'rgba(114,020,034,0.8)',
          pointColor          : '#d81b60',
          pointStrokeColor    : 'rgba(114,020,034,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(114,020,034,1)',
          <?php echo $data_retiro; ?>
        },
        {
          label               : 'FAMILIAR',
          fillColor           : 'rgba(64, 167, 58, 0.9)',
          strokeColor         : 'rgba(64, 167, 58, 0.8)',
          pointColor          : '#57A639',
          pointStrokeColor    : 'rgba(64, 167, 58, 1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(64, 167, 58, 1)',
          <?php echo $data_familiar; ?>
        },
        {
          label               : 'CIVIL',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          <?php echo $data_civil; ?>
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Line(areaChartData, lineChartOptions);

  });
</script>
<script src='{{ asset ("/chartjs/Chart.min.js") }}'></script>

@stop