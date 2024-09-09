@extends('layouts.app')
@section('renderjs')
<style>
    .table {
        padding: 8px;
        line-height: 1.428571429;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    .center {
        margin-top:50px;   
    }

    .modal-header {
        padding-bottom: 5px;
    }

    .modal-footer {
        padding: 0;
    }

    .modal-footer .btn-group button {
        height:40px;
        border-top-left-radius : 0;
        border-top-right-radius : 0;
        border: none;
        border-right: 1px solid #ddd;
    }

    .modal-footer .btn-group:last-child > button {
        border-right: 0;
    }
    td{
        padding-left: 10px;
        padding-right: 10px
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="clearfix"></div>    
    <div class="box box-primary">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                {!! Form::open(['id'=>'frm_solucion','name'=>'frm_solucion','route' => 'soluciones.editar_solucion']) !!}
                <div class="panel panel-primary filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">REGISTRAR TIPO DE SOLUCION </h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            <table id="" class="display" border="0" width="100%">                                     
                                <tbody>
                                    <tr>
                                        <td width="20%"> <b>Fecha Registro</b></td>
                                        <td width="30%"> : {{$fecha_registro}} </td>
                                        <td width="20%"> <b>Nro Doc</b></td>
                                        <td width="30%"> : {{$dni}}</td>
                                    </tr>
                                    <tr>
                                        <td> <b>Nombres</b></td>
                                        <td> : {{$nombres}} </td>
                                        <td> <b>Ap. Paterno</b></td>
                                        <td> : {{$apellido_paterno}}</td>
                                    </tr>
                                    <tr>                    
                                        <td> <b>Ap. Materno</b></td>
                                        <td> : {{$apellido_materno}}</td>
                                        <td> <b>Celular</b></td>
                                        <td> : {{$celular}}</td>                
                                    </tr>
                                    <tr>                    
                                        <td> <b>Sexo</b></td>
                                        <td> : {{$sexo}} </td>
                                        <td> <b>Factor de Riesgo</b></td>
                                        <td> @foreach($mostrar_fr as $key => $riesgo)
                                                    <table>                                                     
                                                        <tr>
                                                            <td>{{$key+1}}.- </td>                                                      
                                                            <td>{!! $riesgo->descripcion !!}</td>                                                       
                                                        </tr>
                                                    </table>                                                    
                                                    @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <input type="hidden" name="id_factor" id="id_factor" value="{{$id_factor}}">   
                        <input type="hidden" name="id_aislado" id="id_aislado" value="{{$id_aislado}}">    
                        <input type="hidden" name="dni" id="dni" value="{{$dni}}">            
                        <input type="hidden" name="compara" id="compara" value="NUEVO"> 
                        <div class="row">
                            <div class="col-md-3">
                                <br/>
                                <label>Fecha de Solucion</label> 
                            </div>
                            <div class="col-md-2">     
                                <br/>           
                                <input type="date" readonly required="" name="fecha_solucion" id="fecha_solucion" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>"  class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-12">
                                <label>RESULTADO DE LA EVALUACION</label> 
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado1" value="1" class="minimal-red"> FUNDADO
                                    </label>                                    
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado2" value="2" class="minimal-red"> INFUNDADO
                                    </label>                                    
                            </div>                            
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado4" value="4" class="minimal-red"> IMPROCEDENTE
                                    </label>                                    
                            </div>
                            <div class="col-md-4">
                                    <label>                                      
                                      <input checked="checked" type="radio" name="resultado" id="resultado3"  value="3" class="minimal-red"> CONCLUIDO
                                    </label>                                    
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    if(Auth::user()->rol==2)
                        $idRiesgo = Auth::user()->factor_id;
                    else
                        $idRiesgo = 0;
                ?>
                <div class="panel panel-success filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">EVALUACION A LOS EXPEDIENTES PRESENTADOS</h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                
                                <label>Descripcion</label> <br/>
                                <textarea rows="10" type="text" tabindex="25" required="" name="descripcion" id="descripcion" class="ckeditor"></textarea>
                                <br/><br/><br/>
                            </div>
                            <div class="col-md-12"> 
                                <fieldset>
                                    {!! Form::submit('Enviar', ['tabindex' => '28', 'class' => 'btn btn-primary btn-lg']) !!}
                                    <h1 class="pull-right">
                                    <a href="{!! route('aislamientos.todos_registros',[$idRiesgo]) !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
                                    </h1>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>                
                {!! Form::close() !!}
            </div>              
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $cmbid_tipo= $("#frm_solucion").find("#id_tipo");
        //$('#id_tipo').prop('disabled', true);

        $cmbid_tipo.change(function () {
            var nro_reclamacion_ipress;
            $this = $(this); 
            cmbid_tipo = $cmbid_tipo.val();

            $.ajax({
                    url: '/carganrosolucion/' + '<?php echo $id_factor ?>/'  + cmbid_tipo,
                    success: function (result) {

                        $('#nro_reclamacion').val("").attr("readonly", false);
                        codigo_ipress=result[0].cod_ipress;
                        //nro_reclamacion_ipress=codigo_ipress+'-S'+result[0].numero;
                        //$('#nro_reclamacion').val(nro_reclamacion_ipress).attr("readonly", true);

                        if(cmbid_tipo=='SI'){
                            $("#estado_reclamo4").prop("checked", true);
                            $("#resultado3").prop("checked", true);
                            nro_reclamacion_ipress=codigo_ipress+'-SD'+result[0].numero;
                            $('#nro_reclamacion').val(nro_reclamacion_ipress).attr("readonly", true);
                            
                        }
                        else
                        {
                            $("#estado_reclamo1").prop("checked", true);
                            $("#resultado3").prop("checked", false);
                            nro_reclamacion_ipress=codigo_ipress+'-S'+result[0].numero;
                            $('#nro_reclamacion').val(nro_reclamacion_ipress).attr("readonly", true);
                        }

                    }
            });

                        

        }); 

    </script>


@stop
