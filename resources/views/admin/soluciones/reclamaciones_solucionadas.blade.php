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
                                    <label class="control-label" for="textinput">Nro. Documento (DNI)   :</label>  
                                    <input id="dni_beneficiario" name="dni_beneficiario" type="text" placeholder="" class="form-control input-sm" maxlength="12" value="<?php echo $dni_beneficiario ?>">
                                </div>                            
                                <div class="col-md-1">
                                    
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label" for="textinput">Nro. Solucion</label>  <br/>
                                    <input id="nro_solucion" name="nro_solucion" type="text" placeholder="" class="form-control input-sm" value="<?php echo $nro_doc_solucion ?>" onKeyPress="return soloNumeros(event)" maxlength="15">
                                </div>
                                <div class="col-md-3">
                                    
                                </div>
                            

                            <div class="col-md-2"><br/>
                                <input class="form-control btn btn-info input-sm" value="Buscar" type="submit">
                            </div>                            
                        </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <label class="control-label">Estado</label><br/>
                                    <select class="form-control input-sm select2" name="estado"  id="estado" tabindex="15" style="width: 100%">
                                        <option value="0" <?php if (isset($estado) && $estado == 0) echo "selected='selected'"; ?>>Todas</option>
                                        <option value="3" <?php if (isset($estado) && $estado == 3) echo "selected='selected'"; ?>>En tramite</option>
                                        <option value="4" <?php if (isset($estado) && $estado == 4) echo "selected='selected'"; ?>>Anulado</option>
                                        <option value="5" <?php if (isset($estado) && $estado == 5) echo "selected='selected'"; ?>>Traslado a entidad competente</option>
                                        <option value="6" <?php if (isset($estado) && $estado == 6) echo "selected='selected'"; ?>>Resuelto</option>
                                        
                                    </select>
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
                                    <th>Nro. Solucion</th>                                                 
                                    <th>Fecha Solucion</th>                                    
                                    <th>IPRESS</th>
                                    <th>Nro. Reclamacion</th>
                                    <th>Nro. Doc.</th>
                                    <th>Beneficiario</th>                                    
                                    <th>Solucionador</th>
                                    <th>Estado</th>                                    
                                    <th>Resultado</th>                                    
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
                                    <td>{{$r->nro_doc_solucion}}</td> 
                                    <td>
                                        <?php
                                        $originalDate1 = $r->fecha_solucion;
                                        $fechaE = date("d-m-Y", strtotime($originalDate1));
                                        echo $fechaE;
                                        ?> 
                                    </td>
                                    
                                    <td>{{$r->nombre}}</td>
                                    <td>{{$r->nro_reclamacion}}</td>
                                    <td>{{$r->nro_doc}}</td> 
                                    <td>{{$r->apellido_paterno}} {{$r->apellido_materno}}, {{$r->nombres}} </td> 
                                    <td>{{$r->personal_solucionador}}</td> 
                                    <td><?php
                                        
                                        switch($r->estado_reclamo){
                                            case 3: echo "En tramite"; break;
                                            case 4: echo "Anulado"; break;
                                            case 5: echo "Traslado a entidad competente"; break;
                                            case 6: echo "Resuelto"; break;
                                        }

                                    ?></td>   
                                    <td><?php
                                        
                                        switch($r->resultado_reclamo){
                                            case 1: echo "Fundado"; break;
                                            case 2: echo "Infundado"; break;
                                            case 3: echo "Concluido Anticipado"; break;
                                            case 4: echo "Improcedente"; break;
                                        }

                                    ?></td>   
                                    <td class="text-center">
                                        <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Ver detalle solucion</b>">
                                            <button type="button" class="btn btn-success btn-xs" onclick="ver_det_solucion('{{ Auth::user()->id }}','{{$r->nro_doc_solucion}}','{{$r->id}}')"><i class="fa fa-search"></i></button>
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
