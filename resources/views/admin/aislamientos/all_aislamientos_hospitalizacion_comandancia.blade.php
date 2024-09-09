<?php 
//use DB;
use App\Models\Sintoma;

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


@endsection
@section('content')
<div class="content">
    <div class="clearfix"></div>    
    <div class="box box-primary">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="panel-body">
                    <div class="col-sm-12">
                        <form id="frm_asilamientos_pnp" class="form-horizontal" method="post" action="{{ route('aislamientos.reporte_listar_aislamientos_hospitalizacion')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label">DNI</label>  <br/>
                                    <input id="dni_beneficiario" name="dni_beneficiario" type="text" placeholder="" class="form-control input-sm" maxlength="8" value="<?php echo $dni_beneficiario ?>">
                                </div> 
                                <div class="col-md-3">
                                    <label class="control-label">Departamento Origen</label>
                                    <select class="form-control input-sm select2" name="departamento" id="departamento" tabindex="16" style="width: 100%">
                                        <option value="">-Seleccionar-</option>
                                        <?php
                                        foreach ($departamentos as $d) {
                                            echo '<option value="' . $d->id . '"';
                                            if (isset($id_departamento)) {
                                                if ($id_departamento == $d->id)
                                                    echo " selected";
                                            }
                                            echo '>' . $d->nombre . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </div> 
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
                                    <a class="btn btn-success form-control input-sm" href="javascript:void(0)" onclick="reporteHospitalizados()" >
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Reporte
                                    </a>
                                
                                    
                                    <input class="form-control btn btn-info input-sm" value="Buscar" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <hr>
                    <div class="clearfix"><br/><br/></div>
                    <div class="col-md-12" style="margin-top: 10px"  id="global">
                        <!--<table  class="table table-list-search">-->
                        <table id="example" class="table table-list-search table-hover" style="font-size: 11px !important;" >
                            <thead>
                                <tr>
                                    <th>N</th>                                                                        
                                    <th>Fecha</th>
                                    <th>DNI</th>
                                    <th>Beneficiario</th>
                                    <th>Dpto Origen</th>
                                    <th>Dpto Actual</th>
                                    <th>Ventilacion Mecanica</th>
                                    <th>Intubado</th>
                                    <th>Tenia/Tuvo Neumonia</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $n = 0; ?>
                                @foreach($aislamientos as $r)
                                <tr>
                                    <td><?php
                                        $n++;
                                        echo $n;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $originalDate1 = $r->fecha_hospitalizacion;
                                            $fechaE = date("d-m-Y", strtotime($originalDate1));
                                            echo $fechaE;
                                        ?>
                                    </td>                                    
                                    <td>{{$r->dni}}</td> 
                                    <td>{{$r->paterno}} {{$r->materno}}, {{$r->nombres}} </td> 
                                    <td>{{$r->nombre_dpto}}</td> 
                                    <td>{{$r->dpto}}</td> 
                                    <td>
                                        <?php 
                                            switch ($r->ventilacion_mecanica) {
                                                case '1':
                                                    echo "SI"; 
                                                    break;
                                                case '2':
                                                    echo "NO"; 
                                                    break;
                                                case '3':
                                                    echo "DESCONOCIDO"; 
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td><?php 
                                            switch ($r->intubado) {
                                                case '1':
                                                    echo "SI"; 
                                                    break;
                                                case '2':
                                                    echo "NO"; 
                                                    break;
                                                case '3':
                                                    echo "DESCONOCIDO"; 
                                                    break;
                                            }
                                        ?></td>  
                                    <td><?php 
                                            switch ($r->neumonia) {
                                                case '1':
                                                    echo "SI"; 
                                                    break;
                                                case '2':
                                                    echo "NO"; 
                                                    break;
                                                case '3':
                                                    echo "DESCONOCIDO"; 
                                                    break;
                                            }
                                        ?></td>  
                                    <td class="text-center">
                                        <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Ver Fichas</b>">
                                            <a target="_blank" href="/ver_fichas/{{$r->idficha}}/{{$r->dni}}/{{$r->id}}" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a>
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
</div>

<div class="modal fade" id="myModalDetR" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">DETALLE DE PERSONAL AISLADO</h5>
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
<script type="text/javascript">  
    $cmbid_departamento = $("#frm_asilamientos_pnp").find("#departamento");
    $cmbid_provincia = $("#frm_asilamientos_pnp").find("#provincia");
    $cmbid_distrito = $("#frm_asilamientos_pnp").find("#distrito");
    

    $cmbid_departamento.change(function () {
            
        $this = $(this); 
        cmbid_departamento = $cmbid_departamento.val();

        $cmbid_provincia.html('');
            option = {
                url: '/cargarprovincias/' + cmbid_departamento,
                type: 'GET',
                dataType: 'json',
                data: {}
            };
            $.ajax(option).done(function (data) {  
                cargarComboDestino($cmbid_provincia, data);
                $cmbid_provincia.val(null).trigger("change");                                           
            });
    });        
    $cmbid_provincia.change(function () {
            
        $this = $(this); 
        cmbid_provincia = $cmbid_provincia.val();
        cmbid_departamento = $cmbid_departamento.val();

        $cmbid_distrito.html('');
            option = {
                url: '/cargardistrito/'+ cmbid_departamento + '/' + cmbid_provincia,
                type: 'GET',
                dataType: 'json',
                data: {}
            };
            $.ajax(option).done(function (data) {  
                cargarComboDestino($cmbid_distrito, data);
                $cmbid_distrito.val(null).trigger("change");                                           
            });
    });

    
    function cargarComboDestino($select, data) {
        $select.html('');
        $(data).each(function (ii, oo) {
            $select.append('<option value="' + oo.id + '">' + oo.nombre + '</option>')
        });
    }   
</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
@stop

