<?php 
ini_set('memory_limit', '-1');
set_time_limit(0);
$rol=Auth::user()->rol;   

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
<script type="text/javascript">
    
    
    
</script>

@endsection
@section('content')
<div class="content">
    <div class="clearfix"></div>    
    <div class="box box-primary">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="panel-body">
                    <div class="col-sm-12">
                        <form class="form-horizontal" method="post" action="{{ route('soluciones.listar_soluciones')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label" for="textinput">DNI :</label>  <br/>
                                    <input id="dni_beneficiario" name="dni_beneficiario" type="text" placeholder="" class="form-control input-sm" maxlength="12" value="<?php echo $dni_beneficiario ?>">
                                </div>                            
                                <div class="col-md-3">
                                    <label class="control-label">Fecha Desde</label><br/>
                                    <input type="date" name="fechaDesde" id="fechaDesde" value="<?php echo date("Y-m-d", strtotime($fechaDesde)); ?>"  class="form-control">

                                    <input value="{{ Auth::user()->id }}" name="id_user" type="hidden">
                                    <input type="hidden" name="id_establecimiento" id="id_establecimiento" value="{{Auth::user()->establecimiento_id}}">  
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Fecha Hasta</label><br/>
                                    <input type="date" name="fechaHasta" id="fechaHasta" value="<?php echo date("Y-m-d", strtotime($fechaHasta)); ?>"  class="form-control">
                                </div>
                                <div class="col-md-2"><br/>
                                    <input class="form-control btn btn-info input-sm" value="Buscar" type="submit">
                                </div>                            
                            </div>
                            <div class="row">
                                <div class="col-md-3"><br/>
                                    <label class="control-label">Estado</label><br/>
                                    <select class="form-control input-sm select2" name="estado"  id="estado" tabindex="15" style="width: 100%">
                                        <option value="">--Seleccionar--</option>                                        
                                        <option value="1" <?php if (isset($estado) && $estado == 1) echo "selected='selected'"; ?>>Fundado</option>
                                        <option value="2" <?php if (isset($estado) && $estado == 2) echo "selected='selected'"; ?>>Infundado</option>
                                        <option value="3" <?php if (isset($estado) && $estado == 3) echo "selected='selected'"; ?>>Concluido</option>
                                        <option value="4" <?php if (isset($estado) && $estado == 4) echo "selected='selected'"; ?>>Improcedente</option>                                        
                                    </select>
                                </div>
                                <div class="col-md-3"><br/>
                                    @if($rol==1)
                                    <label class="control-label">Factor de Riesgo</label>
                                    <select class="form-control input-sm select2" name="f_riesgo" id="f_riesgo" tabindex="16" style="width: 100%">
                                        <option value="">-Seleccionar-</option>
                                        <?php
                                        foreach ($Sintomas as $d) {
                                            echo '<option value="' . $d->id . '"';
                                            if (isset($factor_x)) {
                                                if ($factor_x == $d->id)
                                                    echo " selected";
                                            }
                                            echo '>' . $d->nombre . ' </option>';
                                        }
                                        ?>
                                    </select>
                                    @endif
                                </div>
                                <div class="col-md-3"><br/>
                                    <label class="control-label">Medico</label>
                                    <select class="form-control input-sm select2" name="user_id" id="user_id" tabindex="16" style="width: 100%">
                                        <option value="">-Seleccionar-</option>
                                        <?php
                                        foreach ($users as $d) {
                                            echo '<option value="' . $d->id . '"';
                                            if (isset($user_id)) {
                                                if ($user_id == $d->id)
                                                    echo " selected";
                                            }
                                            echo '>' . $d->name . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2"><br/><br/>
                                    <a class="btn btn-success form-control input-sm" href="javascript:void(0)" onclick="reporteSolucion()" >
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
                                    <th>Fecha Solucion</th>                                    
                                    <th>DNI</th>
                                    <th>Personal PNP</th>   
                                    <th>Factor de Riesgo</th>                                    
                                    <th>Medico</th>
                                    <th>Estado</th>                                                                       
                                    <th>Solucion</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $n = 0; ?>
                                @foreach($aislamientos as $r)
                                <tr>
                                    <td><?php
                                        $n++;
                                        echo $n;
                                        ?></td>                                    
                                    <td>
                                        <?php
                                        $originalDate1 = $r->fecha_solucion;
                                        $fechaE = date("d-m-Y", strtotime($originalDate1));
                                        echo $fechaE;
                                        ?> 
                                    </td>
                                    <td>{{$r->dni}}</td> 
                                    <td>{{$r->nombres}}, {{$r->apellido_paterno}} {{$r->apellido_materno}}</td>
                                    <td><?php 
                                            $Sintomas2 = DB::table('aislados')
                                                            ->join('aislamiento_factor_riesgo', 'aislamiento_factor_riesgo.aislamiento_id', '=', 'aislados.id')
                                                            ->join('sintomas', 'aislamiento_factor_riesgo.factor_riesgo_id', '=', 'sintomas.id')
                                                            ->where('aislamiento_factor_riesgo.aislamiento_id',$r->busca)                    
                                                            ->get();
                                                            
                                            foreach ($Sintomas2 as $d) {
                                                echo $d->descripcion.', ';
                                            }
                                        ?>                                            
                                    </td>
                                    <td>{{$r->medico_solucionador}}</td>
                                    <td><?php
                                        
                                        switch($r->resultado_solucion){
                                            case 1: echo "Fundado"; break;
                                            case 2: echo "Infundado"; break;
                                            case 3: echo "Concluido"; break;
                                            case 4: echo "Improcedente"; break;
                                        }

                                    ?></td>
                                    <td>{{$r->solucion_rpta}}</td>
                                    
                                </tr>
                                @endforeach                      
                            </tbody>
                        </table>   
                    </div>
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
                <h5 class="modal-title">DETALLE DE SOLUCION NRO</h5>
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
    
    $('#datepicker').datepicker({
      autoclose: true
    });

    
</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
@stop
