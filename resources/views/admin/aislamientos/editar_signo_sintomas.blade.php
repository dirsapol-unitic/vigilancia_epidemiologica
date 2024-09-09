<?php use App\Models\Respuesta; 
      use App\Models\SignoSintoma;
?>

@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
       @include('admin.aislamientos.menu_lateral')
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      @include('admin.aislamientos.menu_superior')
      <div class="nav-tabs-custom">
        <div class="content">
          <div class="clearfix"></div>
          @include('flash::message')        
          <div class="clearfix"></div>
          <div class="box-body">
            {!! Form::model($paciente, ['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => ['esavis.update_signo_sintoma', $paciente->id], 'method' => 'patch']) !!}
                <h2 class="page-header">
                  <i class="fa fa-globe"></i> SIGNO/SINTOMAS
                </h2>
                <div class="box box-primary">
                  <div class="box-body">
                    <!-- /.box-col -->
                    <div class="row col-sm-12">
                        <br/>
                        <label>Responder el siguiente cuestionario</label> 
                        <br/>                
                        <table>
                          <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripcion</th>
                                <th colspan="3"><p align="center">Tiempo entre vacunacion e inicio del cuadro clinico</p></th>
                                <th>Fecha Inicio</th>
                                <th>Fecha de Termino</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php $x=1; $cont=0;
                            foreach($preguntas as $idp => $fpregunta):
                              $respuestas = Respuesta::Where('pregunta_id',$fpregunta->id)->get();
                              $nro_rpta = Respuesta::Where('pregunta_id',$fpregunta->id)->count();
                              
                                if($nro_rpta>0):
                              ?>
                              <tr>
                                  <td><b><?php echo $x++; ?></b></td>
                                  <td><b><?php echo $fpregunta->pregunta; ?></b></td>
                                  <td><b>Minuto</b></td>
                                  <td><b>Hora</b></td>
                                  <td><b>Dias</b></td>
                                  <td><b>dia/mes/año</b></td>
                                  <td><b>dia/mes/año</b></td>
                              </tr>
                              <?php 
                                else:  

                                      $paciente_preguntas=SignoSintoma::where('pregunta_id',$fpregunta->id)->where('id_aislado',$id)->where('id_esavi',$id_esavi)->first();
                                      $busca_rpta=SignoSintoma::where('pregunta_id',$fpregunta->id)->where('id_aislado',$id)->where('id_esavi',$id_esavi)->count();
                                      if($busca_rpta>0):
                                        $minutop=$paciente_preguntas->minuto;
                                        $horap=$paciente_preguntas->hora;
                                        $diap=$paciente_preguntas->dia;
                                        $fecha_iniciop=$paciente_preguntas->fecha_inicio;
                                        $fecha_terminop=$paciente_preguntas->fecha_termino;
                                      else:
                                        $minutop='';
                                        $horap='';
                                        $diap='';
                                        $fecha_iniciop='';
                                        $fecha_terminop='';
                                      endif;
                                  ?>
                                <tr>
                                  <td><b><?php echo $x++; ?></b></td>
                                  <td><b><?php echo $fpregunta->pregunta; ?></b></td>
                                  <td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar minuto" name="minutop[]" tabindex="8" id="minutop<?php echo $fpregunta->id; ?>" class="input-sm" style="margin-left:4px; width:100px; text-align:left" value="<?php echo $minutop ?>" /></br></br>
                                    </td> 
                                    <td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar hora" value="<?php echo $horap ?>" name="horap[]" tabindex="8" id="horap<?php echo $fpregunta->id; ?>" class="input-sm" style="margin-left:4px; width:100px; text-align:left" /></br></br>
                                    </td>
                                    <td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar dia" value="<?php echo $diap ?>" name="diap[]" tabindex="8" id="diap<?php echo $fpregunta->id; ?>" class="input-sm" style="margin-left:4px; width:100px; text-align:left" /></br></br>
                                    </td>  
                                    <td><input type="date" data-toggle="tooltip" data-placement="top" title="Fecha inicio" value="<?php echo $fecha_iniciop ?>" name="fecha_iniciop[]" tabindex="8" id="fecha_iniciop<?php echo $fpregunta->id; ?>" class="input-sm" style="width:150px" /></br></br></td>
                                    <td><input type="date" data-toggle="tooltip" data-placement="top" title="Fecha termino" name="fecha_terminop[]" value="<?php echo $fecha_terminop ?>" tabindex="8" id="fecha_terminop<?php echo $fpregunta->id; ?>" class="input-sm" style="width:150px" /></br></br></td>
                                    <input type="hidden" class="form-control id_pregunta typeahead tt-query" id="id_pregunta<?php echo $fpregunta->id; ?>" name="id_pregunta[]" value="<?php echo $fpregunta->id; ?>">
                                </tr>
                              <?php 
                                endif;
                              ?>
                              <?php $y=0; $x=$x-1;
                                    foreach($respuestas as $idr => $frespuesta): 
                                      $paciente_respuestas=SignoSintoma::where('pregunta_id',$fpregunta->id)->where('respuesta_id',$frespuesta->id)->where('id_esavi',$id_esavi)->where('id_aislado',$id)->first();
                                      $busca_rpta=SignoSintoma::where('pregunta_id',$fpregunta->id)->where('respuesta_id',$frespuesta->id)->where('id_esavi',$id_esavi)->where('id_aislado',$id)->count();
                                      if($busca_rpta>0):
                                        $minutor=$paciente_respuestas->minuto;
                                        $horar=$paciente_respuestas->hora;
                                        $diar=$paciente_respuestas->dia;
                                        $fecha_inicior=$paciente_respuestas->fecha_inicio;
                                        $fecha_terminor=$paciente_respuestas->fecha_termino;
                                      else:
                                        $minutor='';
                                        $horar='';
                                        $diar='';
                                        $fecha_inicior='';
                                        $fecha_terminor='';
                                      endif;
                              ?>
                                  <tr>
                                    <td><?php $y++; echo $x.'.'.$y; ?></td>
                                    <td><?php echo $frespuesta->descripcion; ?></td>
                                    <td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar minuto" name="minutor[]" tabindex="8" id="minutor<?php echo $frespuesta->id; ?>" value="<?php echo $minutor ?>" class="input-sm" style="margin-left:4px; width:100px; text-align:left" /></br></br>
                                    </td> 
                                    <td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar hora" name="horar[]" tabindex="8" value="<?php echo $horar ?>"  id="horar<?php echo $frespuesta->id; ?>" class="input-sm" style="margin-left:4px; width:100px; text-align:left" /></br></br>
                                    </td>
                                    <td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar dia" name="diar[]" tabindex="8" value="<?php echo $diar ?>"  id="diar<?php echo $frespuesta->id; ?>" class="input-sm" style="margin-left:4px; width:100px; text-align:left" /></br></br>
                                    </td>  
                                    <td><input type="date" data-toggle="tooltip" data-placement="top" title="Fecha inicio" value="<?php echo $fecha_inicior ?>" name="fecha_inicior[]" tabindex="8" id="fecha_inicior<?php echo $frespuesta->id; ?>" class="input-sm" style="width:150px" /></br></br></td>
                                    <td><input type="date" data-toggle="tooltip" data-placement="top" title="Fecha termino"  value="<?php echo $fecha_terminor ?>"  name="fecha_terminor[]" tabindex="8" id="fecha_terminor<?php echo $frespuesta->id; ?>" class="input-sm" style="width:150px" /></br></br></td>
                                    <input type="hidden" class="form-control id_pregunta typeahead tt-query" id="id_respuesta<?php echo $frespuesta->id; ?>" name="id_respuesta[]" value="<?php echo $frespuesta->id; ?>">
                                    <input type="hidden" class="form-control id_pregunta typeahead tt-query" id="id_preguntar<?php echo $fpregunta->id; ?>" name="id_preguntar[]" value="<?php echo $fpregunta->id; ?>">
                                     
                              <?php
                                  endforeach; 
                                  $x=$x+1;
                                  ?>
                              </tr>    
                            <?php
                            endforeach;
                            ?>
                          </tbody>
                        </table>
                    </div>
                    <!-- /.box-col -->
                    <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
                    <input type="hidden" name="id_esavi" id="id_esavi" value="{{$id_esavi}}">
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box-primary -->
              <!-- /.box-panel -->
              <div class="box-body">
                <div class="form-group col-sm-12">
                  {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
                    <a href="{!! route('esavis.listar_esavis',[$id, $dni]) !!}" class="btn btn-danger">Cancelar</a>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box-content -->
      </div>
      <!-- /.box-tab -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.content -->
@endsection
