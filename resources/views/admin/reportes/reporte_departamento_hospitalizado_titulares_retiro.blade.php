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
                <h3 class="panel-title">Reporte de Hospitalizados Titulares en Retiro</h3>
            </div>
            <div class="col-sm-12">
                <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.reporte_departamento_hospitalizado_titulares_retiro_fecha')}}">
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
                <table id="example" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                    <thead>
                        <tr>
                            <th colspan="2" style="border:0"></th>
                            <th colspan="5" style="border:1px solid #999999;text-align:center">Personal Hospitalizados Ventilacion Mecanico</th>
                            <th colspan="5" style="border:1px solid #999999;text-align:center">Personal Hospitalizados Sin Ventilacion Mecanico</th>
                            <th style="border:0"></th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="border:1px solid #999999">N.</th>
                            <th rowspan="2" style="border:1px solid #999999">Departamento</th>
                            <th style="border:1px solid #999999">UCI</th>
                            <th style="border:1px solid #999999">UCIN</th>
                            <th style="border:1px solid #999999">UST</th>
                            <th style="border:1px solid #999999">UVI</th>
                            <th style="border:1px solid #999999">OTROS</th>
                            <th style="border:1px solid #999999">UCI</th>
                            <th style="border:1px solid #999999">UCIN</th>
                            <th style="border:1px solid #999999">UST</th>
                            <th style="border:1px solid #999999">UVI</th>
                            <th style="border:1px solid #999999">OTROS</th>
                            <th style="border:1px solid #999999">Nro Hospitalizados</th>
                            <!--th style="border:1px solid #999999">Total</th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $uci=0;$ucin=0;$uvi=0;$ust=0;$nhospitalizados=0;$ntotal=0;$otro=0;
                            $nmuci=0;$nmucin=0;$nmuvi=0;$nmust=0;$nmotro=0;
                        if (isset($resumen)):
                            foreach ($resumen as $key => $rowResumen):
                                ?> 
                                <?php 
                                        $uci=$uci+$rowResumen->_uci;
                                        $ucin=$ucin+$rowResumen->_ucin;
                                        $uvi=$uvi+$rowResumen->_uvi;
                                        $ust=$ust+$rowResumen->_ust;
                                        $otro=$otro+$rowResumen->_otro;
                                        $nmuci=$uci+$rowResumen->_nmuci;
                                        $nmucin=$ucin+$rowResumen->_nmucin;
                                        $nmuvi=$uvi+$rowResumen->_nmuvi;
                                        $nmust=$ust+$rowResumen->_nmust;
                                        $nmotro=$otro+$rowResumen->_nmotro;
                                        $nhospitalizados=$nhospitalizados+$rowResumen->_nhospitalizados;
                                        $ntotal=$ntotal + $rowResumen->_nhospitalizados;
                                        
                                    ?>
                                <tr>
                                    <td><?= ($key + 1) ?></td>
                                    <td align="left"><?= $rowResumen->_nombre_departamento ?></td>
                                    <td align="right"><?= $rowResumen->_uci ?></td>
                                    <td align="right"><?= $rowResumen->_ucin ?></td>
                                    <td align="right"><?= $rowResumen->_uvi ?></td>
                                    <td align="right"><?= $rowResumen->_ust ?></td>
                                    <td align="right"><?= $rowResumen->_otro ?></td>
                                    <td align="right"><?= $rowResumen->_nmuci ?></td>
                                    <td align="right"><?= $rowResumen->_nmuci ?></td>
                                    <td align="right"><?= $rowResumen->_nmuvi ?></td>
                                    <td align="right"><?= $rowResumen->_nmust ?></td>
                                    <td align="right"><?= $rowResumen->_nmotro ?></td>
                                    <td align="right"><?= $rowResumen->_nhospitalizados ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td align="right"><strong><?= $uci ?></strong></td>
                                    <td align="right"><strong><?= $ucin ?></strong></td>
                                    <td align="right"><strong><?= $uvi ?></strong></td>
                                    <td align="right"><strong><?= $ust ?></strong></td>
                                    <td align="right"><strong><?= $otro ?></strong></td>
                                    <td align="right"><strong><?= $nmuci ?></strong></td>
                                    <td align="right"><strong><?= $nmucin ?></strong></td>
                                    <td align="right"><strong><?= $nmuvi ?></strong></td>
                                    <td align="right"><strong><?= $nmust ?></strong></td>
                                    <td align="right"><strong><?= $nmotro ?></strong></td>
                                    <td align="right"><strong><?= $nhospitalizados ?></strong></td>
                                    
                        <?php endif; ?>
                    </tbody>
                </table>
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
@stop
