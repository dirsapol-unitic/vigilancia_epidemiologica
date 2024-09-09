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
                {!! Form::open(['id'=>'frm_solucion','name'=>'frm_solucion','route' => 'reclamaciones.editar_solucion']) !!}
                <div class="panel panel-primary filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">REGISTRAR TIPO DE SOLUCION </h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            <br/>                            
                            <div class="col-md-2">
                                <label>Trato Directo</label> 
                                <br/>
                            </div>
                            <div class="col-md-3">
                                <select required="" tabindex="0" class="form-control select2" required="" name="id_tipo" id="id_tipo" style="width: 100%">
                                    <option value="">- Seleccione -</option>

                                    <option value="SI" <?php if($soluciones[0]->trato_directo=='SI') echo 'selected';?>>SI</option>
                                    <option value="NO" <?php if($soluciones[0]->trato_directo=='NO') echo 'selected';?>>NO</option>

                                </select>       
                                <input type="hidden" name="id_reclamacion" id="id_reclamacion" value="{{$soluciones[0]->id_reclamacion}}">  
                                <input type="hidden" name="id" id="id" value="{{$soluciones[0]->id}}">
                                <input type="hidden" name="compara" id="compara" value="EDITAR">  
                            </div>
                            <div class="form-group col-sm-1">
                                <br/>
                                <br/>
                            </div>
                            <div class="col-md-3">
                                <label>Numero de Documento</label> 
                                <br/>
                            </div>
                            <div class="col-md-2">
                                <input readonly="" type="text"  tabindex="29" name="nro_reclamacion" id="nro_reclamacion" value="<?php echo $soluciones[0]->nro_doc ?>" class="form-control">
                                <br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Numero de Notificacion</label> 
                            </div>
                            <div class="col-md-4">
                                <input type="text"  tabindex="29" name="nro_notificacion" id="nro_notificacion" class="form-control" style="width: 100%"; value="<?php echo $soluciones[0]->nro_notificacion ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Fecha de Solucion</label> 
                            </div>
                            <div class="col-md-2">                
                                <input type="date" required="" name="fecha_solucion" id="fecha_solucion" value="<?php echo date("Y-m-d", strtotime($soluciones[0]->fecha_solucion)); ?>"  class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-12">
                                <label>ESTADO DEL RECLAMO</label> 
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="estado_reclamo" id="estado_reclamo1" value="2" class="minimal-red" <?php if($soluciones[0]->estado_reclamo==2) echo 'checked';?> > En trámite
                                    </label>                                    
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="estado_reclamo" id="estado_reclamo2"  value="3" class="minimal-red" <?php if($soluciones[0]->estado_reclamo==3) echo 'checked';?>> Anulado
                                    </label>                                    
                            </div>
                            <div class="col-md-4">
                                    <label>                                      
                                      <input type="radio" name="estado_reclamo" id="estado_reclamo3" value="4" class="minimal-red" <?php if($soluciones[0]->estado_reclamo==4) echo 'checked';?>> Traslado a entidad competente
                                    </label>                                    
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="estado_reclamo" id="estado_reclamo4" value="5" class="minimal-red"<?php if($soluciones[0]->estado_reclamo==5) echo 'checked';?> > Resuelto
                                    </label>                                    
                            </div>

                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-12">
                                <label>RESULTADO DEL RECLAMO</label> 
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado1" value="1" class="minimal-red" <?php if($soluciones[0]->resultado_reclamo==1) echo 'checked';?> > FUNDADO
                                    </label>                                    
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado2" value="2" class="minimal-red" <?php if($soluciones[0]->resultado_reclamo==2) echo 'checked';?> > INFUNDADO
                                    </label>                                    
                            </div>
                            <div class="col-md-4">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado3"  value="3" class="minimal-red" <?php if($soluciones[0]->resultado_reclamo==3) echo 'checked';?> > CONCLUIDO ANTICIPADAMENTE
                                    </label>                                    
                            </div>
                            <div class="col-md-2">
                                    <label>                                      
                                      <input type="radio" name="resultado" id="resultado4" value="4" class="minimal-red"<?php if($soluciones[0]->resultado_reclamo==4) echo 'checked';?> > IMPROCEDENTE
                                    </label>                                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">SOLUCION A SU RECLAMO</h3>
                    </div>  
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                
                                <label>Descripcion</label> <br/>                                
                                <textarea rows="10" type="text" tabindex="25" required="" name="descripcion" id="descripcion" class="ckeditor"><?php echo $soluciones[0]->solucion_rpta;?></textarea>                                
                                <br/><br/><br/>
                            </div>
                            <div class="col-md-12"> 
                                <fieldset>
                                    {!! Form::submit('Enviar', ['tabindex' => '28', 'class' => 'btn btn-primary btn-lg']) !!}
                                    <h1 class="pull-right">
                                    <a href="{!! route('reclamaciones.todas_reclamaciones') !!}" class='btn btn-info'><i class="glyphicon glyphicon-hand-left"></i> Regresar</a>
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
        var trato_directo = '<?php echo $soluciones[0]->trato_directo; ?>';
        var nro_docu = '<?php echo $soluciones[0]->nro_doc; ?>';
        $cmbid_tipo= $("#frm_solucion").find("#id_tipo");
        
        $cmbid_tipo.change(function () {
            
            $this = $(this); 
            cmbid_tipo = $cmbid_tipo.val();
            var nro_reclamacion_ipress;

            if(cmbid_tipo != trato_directo){

                $.ajax({
                    url: '/carganrosolucion/' + '<?php echo $soluciones[0]->id_establecimiento ?>/'  + cmbid_tipo,
                    success: function (result) {
                        codigo_ipress=result[0].cod_ipress;

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
            }
            else
            {
                
                $('#nro_reclamacion').val(nro_docu).attr("readonly", true);
            }
            
            /*if(cmbid_tipo=='SI'){
                $("#estado_reclamo4").prop("checked", true);
                $("#resultado3").prop("checked", true);
                
            }
            else
            {
                $("#estado_reclamo1").prop("checked", true);
                $("#resultado3").prop("checked", false);
            }*/
        }); 

    </script>
@stop
