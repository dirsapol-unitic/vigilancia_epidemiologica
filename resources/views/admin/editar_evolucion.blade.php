@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral')
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <div class="panel panel-primary filterable" >
        <div class="panel-heading">
            <h3 class="panel-title">EVOLUCION - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
        </div>
        <div class="clearfix"></div>
        @include('flash::message')        
        <div class="clearfix"></div>
          {!! Form::model($archivos, ['route' => ['aislamientos.store_evolucion_paciente'], 'method' => 'patch','enctype'=>"multipart/form-data",'id'=>'frm_aislamientos','name'=>'frm_aislamientos']) !!} 
            <div class="box-body">
              <div class="row col-sm-12">
                  @if($evolucion->evolucion<3 )
                      <div class="form-group col-sm-3">
                          <label>Evolucion del paciente</label> <br/>
                          <select class="form-control select2" tabindex="47" required="" style="width: 100%" onchange="getEvolucion();" name="evolucion" id="evolucion">
                              <option value="0" <?php if($evolucion->evolucion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                              <option value="1" <?php if($evolucion->evolucion == 1)echo "selected='selected'";?>>Favorable</option>
                              <option value="2" <?php if($evolucion->evolucion == 2)echo "selected='selected'";?>>Desfavorable</option>
                              <option value="4" <?php if($evolucion->evolucion == 4)echo "selected='selected'";?>>Alta Médica</option>
                              <option value="5" <?php if($evolucion->evolucion == 5)echo "selected='selected'";?>>Alta Voluntaria</option>
                              <option value="6" <?php if($evolucion->evolucion == 6)echo "selected='selected'";?>>Referido</option>
                              <option value="3" <?php if($evolucion->evolucion == 3)echo "selected='selected'";?>>Fallecio</option>
                              <option value="7" <?php if($evolucion->evolucion == 3)echo "selected='selected'";?>>Fugado</option>
                              <input type="hidden" name="dni_evolucion" id="dni_evolucion" value="<?php echo $dni?>">
                              <input type="hidden" name="id_paciente_evolucion" id="id_paciente_evolucion" value="<?php echo $id_paciente?>">
                              <input type="hidden" name="id_evolucion" id="id_evolucion" value="{{$id_evolucion}}">
                          </select><br/><br/>
                      </div>
                      <div class="form-group col-sm-3 " id="divalta">
                          <label>Fecha  de Alta / Referencia / Defuncion</label><br/>
                          <input type="date" tabindex="48"   name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo $fecha_alta; ?>" >
                      </div>
                      <div class="form-group col-sm-6 " id="divdescripcion2">
                          <label>Descripcion Evolucion</label><br/>
                          <input type="text" tabindex="48"   name="descripcion_evolucion" id="descripcion_evolucion" class="form-control" value="<?php echo $evolucion->descripcion_evolucion; ?>" >
                          </div>
                      </div>
                  @else
                      @if($evolucion->evolucion>3)
                          <div class="form-group col-sm-3">
                              <label>Evolucion del paciente</label> <br/>
                              <input type="text" tabindex="48" readonly=""  name="alta" id="alta" class="form-control" value="ALTA" >
                              <br/><br/>
                          </div>
                          <div class="form-group col-sm-3 " id="divalta2">
                              <label>Fecha  de Alta</label><br/>
                              <input type="text" tabindex="48" readonly=""  name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo $fecha_alta; ?>" >
                              </div>
                          </div>
                          <div class="form-group col-sm-6 " id="divdescripcion2">
                          <label>Descripcion Evolucion</label><br/>
                          <input type="text" tabindex="48"   name="descripcion_evolucion" id="descripcion_evolucion" class="form-control" value="<?php echo $evolucion->descripcion_evolucion; ?>" >
                          </div>
                      </div>
                      @endif
                  @endif
                  @if($evolucion->evolucion==3)
                    
                      <div class="form-group col-sm-3">
                          <label>Evolucion del paciente</label> <br/>
                          <input type="text" tabindex="48" readonly=""  name="alta" id="alta" class="form-control" value="FALLECIO" >
                          <br/><br/>
                      </div>
                      <div class="row col-sm-12">
                        <div class="row col-sm-12">
                          <div class="form-group col-sm-4">
                            <label>Clasifica Defuncion</label><br/>
                            <select class="form-control select2" tabindex="49"  style="width: 100%" name="tipo_defuncion" disabled="disabled" id="tipo_defuncion">
                              <option value="0" <?php if($evolucion->tipo_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                              <option value="1" <?php if($evolucion->tipo_defuncion == 1)echo "selected='selected'";?>>Criterio Virologico </option>
                              <option value="2" <?php if($evolucion->tipo_defuncion == 2)echo "selected='selected'";?>>Criterio Serologico </option>
                              <option value="3" <?php if($evolucion->tipo_defuncion == 3)echo "selected='selected'";?>>Criterio Radiologico </option>
                              <option value="4" <?php if($evolucion->tipo_defuncion == 4)echo "selected='selected'";?>>Nexo Epidemiológico </option>
                              <option value="5" <?php if($evolucion->tipo_defuncion == 5)echo "selected='selected'";?>>Criterio Investigacion epidemiologica </option>
                              <option value="6" <?php if($evolucion->tipo_defuncion == 6)echo "selected='selected'";?>>Criterio Clinico </option>
                              <option value="7" <?php if($evolucion->tipo_defuncion == 7)echo "selected='selected'";?>>Criterio SINADEF </option>
                            </select><br/><br/>
                          </div>
                          <div class="form-group col-sm-2">
                            <label>Fecha  de defuncion</label><br/>
                            <input type="date" tabindex="50"  readonly=""  name="fecha_defuncion" id="fecha_defuncion" class="form-control" value="<?php echo $fecha_defuncion; ?>" >
                          </div>
                          <div class="form-group col-sm-2">
                            <label>Hora de defuncion</label><br/>
                            <input type="text" tabindex="51"  readonly="" name="hora_defuncion" id="hora_defuncion" class="form-control timepicker" value="<?php echo $evolucion->hora_defuncion; ?>" >
                          </div>
                          <div class="form-group col-sm-3">
                            <label>Lugar de defuncion:</label><br/>
                            <select class="form-control select2" tabindex="52" style="width: 100%"  name="lugar_defuncion" onchange="getLugarFallecimiento();" id="lugar_defuncion" disabled="disabled">
                              <option value="0" <?php if($evolucion->lugar_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                              <option value="1" <?php if($evolucion->lugar_defuncion == 1)echo "selected='selected'";?>>Hospital/Clinica</option>
                              <option value="2" <?php if($evolucion->lugar_defuncion == 2)echo "selected='selected'";?>>Vivienda</option>
                              <option value="3" <?php if($evolucion->lugar_defuncion == 3)echo "selected='selected'";?>>Centro de Aislamiento temporal</option>
                              <option value="4" <?php if($evolucion->lugar_defuncion == 4)echo "selected='selected'";?>>Centro penitenciario</option>
                              <option value="5" <?php if($evolucion->lugar_defuncion == 5)echo "selected='selected'";?>>Via publica</option>
                              <option value="4" <?php if($evolucion->lugar_defuncion == 6)echo "selected='selected'";?>>Otros</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group col-sm-12"zx>
                          <div class="form-group col-sm-8">
                            <label>Hospital/Clinica Fallecimiento:</label><br/>
                            <select class="form-control select2" style="width: 100%" tabindex="4" name="establecimiento_salud" disabled="disabled" id="establecimiento_salud">
                                <option value="">- Seleccione -</option>
                                @foreach($establecimiento_salud as $dep)
                                <option value="{{$dep->id}}" <?php if($establecimiento_actual == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group col-sm-12" id="divotrolugarf" style="display:none">
                          <div class="form-group col-sm-8">
                            <label>Otro Lugar de defuncion:</label><br/>
                            <input type="text" tabindex="30" name="otro_lugar" id="otro_lugar" class="form-control" value="<?php echo $evolucion->otro_lugar_fallecimiento;?>">
                          </div>
                        </div>
                        <div class="col-md-12">                
                            <label>Observacion</label> <br/>                                
                            <textarea rows="10" type="text" disabled="disabled" tabindex="54"  name="motivo_muerte" id="motivo_muerte" class="ckeditor"><?php echo $evolucion->observacion?></textarea>                                
                            <br/><br/><br/>
                        </div>
                        <div class="row col-sm-12">
                          <div class="form-group col-sm-12">                                
                            <table id="example" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                    <th>#</th>                                            
                                    <th>Tipo de Documento</th>
                                    <th>Numero Doc</th>
                                    <th>Fecha</th>
                                    <th>Nombre Archivo</th>   
                                    <th>Descargar</th>        
                                    @if($paciente->evolucion!='FALLECIO')                    
                                    <th>Eliminar</th>                    
                                    @endif        
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($archivos as $key => $file)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td><?php 
                                          if($file->tipo_defuncion==1){
                                            echo 'Nota Informativa';
                                          }
                                          else
                                          {
                                            echo 'Certificado Defuncion';
                                          }
                                        ?>
                                    </td>
                                    <td>
                                      {!! $file->nro_defuncion !!} 
                                    </td>
                                    <td>
                                      {!! $file->fecha_defuncion !!} 
                                    </td>
                                    <td>
                                      {!! $file->nombre_archivo !!} 
                                    </td>
                                    <td>
                                      <?php 
                                          if($file->extension_archivo=='pdf'){
                                            $imagen='fa fa-file-pdf-o';
                                            $color='bg-red';
                                          }else
                                          {   
                                            if($file->extension_archivo=='xls' || $file->extension_archivo=='xlsx'){
                                              $imagen='fa-file-excel-o';
                                              $color='bg-green';
                                            }
                                            else
                                            {
                                              if($file->extension_archivo=='doc' || $file->extension_archivo=='docx'){
                                                $imagen='fa-file-word-o';
                                                $color='bg-blue';
                                              }
                                              else
                                              {
                                                if($file->extension_archivo=='jpg' || $file->extension_archivo=='gif' || $file->extension_archivo=='jpeg' || $file->extension_archivo=='png' || $file->extension_archivo=='svg' || $file->extension_archivo=='eps' || $file->extension_archivo=='psd' ){
                                                    $imagen='fa-file-image-o';
                                                    $color='bg-purple';
                                                }
                                                else
                                                {
                                                  $imagen='fa-archive';
                                                  $color='bg-orange';
                                                }
                                              }
                                            }
                                          }
                                      ?>
                                      <a target="_blank" href='{{ asset ("$file->descarga_archivo") }}' class='btn <?php echo $color; ?>'><i class="fa <?php echo $imagen; ?>"></i></a>
                                    </td>      
                                    @if($paciente->evolucion!='FALLECIO')                      
                                      <td>                                
                                        <a href="{!! route('aislamientos.eliminar_archivo',['id'=>$file->id,$id, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>
                                      </td>
                                    @endif
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>                                
                            </div>

                          </div>
                        </div>
                  @else
                  6
                      <div class="row col-sm-12" id="divdefuncion">
                          <div class="row col-sm-12">
                              <div class="form-group col-sm-4">
                                  <label>Clasifica Defuncion</label><br/>
                                  <select class="form-control select2" tabindex="49"  style="width: 100%" name="tipo_defuncion" id="tipo_defuncion">
                                      <option value="0" <?php if($evolucion->tipo_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                                          <option value="1" <?php if($evolucion->tipo_defuncion == 1)echo "selected='selected'";?>>Criterio Virologico </option>
                                          <option value="2" <?php if($evolucion->tipo_defuncion == 2)echo "selected='selected'";?>>Criterio Serologico </option>
                                          <option value="3" <?php if($evolucion->tipo_defuncion == 3)echo "selected='selected'";?>>Criterio Radiologico </option>
                                          <option value="4" <?php if($evolucion->tipo_defuncion == 4)echo "selected='selected'";?>>Nexo Epidemiológico </option>
                                          <option value="5" <?php if($evolucion->tipo_defuncion == 5)echo "selected='selected'";?>>Criterio Investigacion epidemiologica </option>
                                          <option value="6" <?php if($evolucion->tipo_defuncion == 6)echo "selected='selected'";?>>Criterio Clinico </option>
                                          <option value="7" <?php if($evolucion->tipo_defuncion == 7)echo "selected='selected'";?>>Criterio SINADEF </option>
                                  </select><br/><br/>
                              </div>
                              <div class="form-group col-sm-2">
                                  <label>Fecha  de defuncion</label><br/>
                                  <input type="date" tabindex="50"   name="fecha_defuncion" id="fecha_defuncion" class="form-control" value="<?php echo $fecha_defuncion; ?>" >
                              </div>
                              <div class="form-group col-sm-2">
                                  <label>Hora de defuncion</label><br/>
                                  <input type="text" tabindex="51"  name="hora_defuncion" id="hora_defuncion" class="form-control timepicker" value="<?php echo $evolucion->hora_defuncion; ?>" >
                              </div>
                              <div class="form-group col-sm-4">
                                  <label>Lugar de defuncion:</label><br/>
                                  <select class="form-control select2" tabindex="52" style="width: 100%"  name="lugar_defuncion" id="lugar_defuncion" onchange="getLugarFallecimiento();">
                                      <option value="0" <?php if($evolucion->lugar_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                                      <option value="1" <?php if($evolucion->lugar_defuncion == 1)echo "selected='selected'";?>>Hospital/Clinica</option>
                                      <option value="2" <?php if($evolucion->lugar_defuncion == 2)echo "selected='selected'";?>>Vivienda</option>
                                      <option value="3" <?php if($evolucion->lugar_defuncion == 3)echo "selected='selected'";?>>Centro de Aislamiento temporal</option>
                                      <option value="4" <?php if($evolucion->lugar_defuncion == 4)echo "selected='selected'";?>>Centro penitenciario</option>
                                      <option value="5" <?php if($evolucion->lugar_defuncion == 5)echo "selected='selected'";?>>Via publica</option>
                                      <option value="6" <?php if($evolucion->lugar_defuncion == 6)echo "selected='selected'";?>>Otros</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group col-sm-12" id="divlfallecimiento" style="display:none">
                            <div class="form-group col-sm-8">
                              <label>Hospital/Clinica Fallecimiento:</label><br/>
                              <select class="form-control select2" style="width: 100%" tabindex="4" name="establecimiento_salud" id="establecimiento_salud">
                                  <option value="">- Seleccione -</option>
                                  @foreach($establecimiento_salud as $dep)
                                  <option value="{{$dep->id}}" <?php if($evolucion->hospital_fallecimiento == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          
                          <div class="form-group col-sm-12" id="divotrolugarf" style="display:none">
                            <div class="form-group col-sm-8">
                              <label>Otro Lugar de defuncion:</label><br/>
                              <input type="text" tabindex="30" name="otro_lugar" id="otro_lugar" class="form-control" value="<?php echo $evolucion->otro_lugar_fallecimiento;?>">
                            </div>
                          </div>

                          <div class="row col-sm-12">
                            <div class="form-group col-sm-12">
                              <label>Diagnosticos:</label><br/>
                              @if($count_diagnostico!=0)
                                <table class="display" id="tblDiagnosticos3" cellspacing="0" width="100%" style="margin-top:5px;">
                                  <thead>
                                      <tr>
                                          <th width="20%">Codigo</th>
                                          <th width="60%">Nombre</th>
                                          <th width="20%">Tipo</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                  </tfoot>
                                  <tbody>
                                    <?php foreach($diagnostico1 as $row):
                                      $tipo_diagnostico = "";
                                      if($row->id_tipo_diagnostico==1)$tipo_diagnostico = "DIAGNOSTICO BASICO";
                                      if($row->id_tipo_diagnostico==2)$tipo_diagnostico = "DIAGNOSTICO INTERMEDIO";
                                      if($row->id_tipo_diagnostico==3)$tipo_diagnostico = "DIAGNOSTICO DEFINITIVO";
                                    ?>
                                    <tr>
                                      <td><?php echo $row->codigo?></td>
                                      <td><?php echo $row->nombre?></td>
                                      <td><?php echo $tipo_diagnostico?></td>
                                    </tr>
                                    <?php endforeach;?>
                                  </tbody>
                                </table>
                              @endif
                            </div>
                            <div class="form-group col-sm-12">
                              <div class="panel-body">
                                <table>
                                  <tr>
                                    <td>
                                        <button type="button" id="addDiagnostico3" class="btn btn-warning" data-toggle="modal" data-target="#addClassModal">Agregar Diagnostico</button>
                                    </td>
                                  </tr>
                                </table>
                                <br />
                                <table class="display" id="tblDiagnostico3" cellspacing="0" width="100%" style="margin-top:5px;">
                                  <thead>
                                    <tr>
                                      <th width="90%"></th>
                                      <th width="10%"></th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                  </tfoot>
                                  <tbody>
                                  </tbody>
                                </table>                    
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">                
                              <label>Observacion</label> <br/>                                
                              <textarea rows="10" type="text" tabindex="54"  name="motivo_muerte" id="motivo_muerte" class="ckeditor"><?php echo $evolucion->observacion?></textarea>                                
                              <br/><br/><br/>
                          </div>

                          <!--div class="row col-sm-12" id="divdefuncion"-->
                              <table>
                                  <tr>
                                      <td>
                                          <button type="button" id="addCertificado" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Agregar Certificado</button>
                                      </td>
                                  </tr>
                              </table>
                              <br />
                              <table class="display" id="tblCertificado" cellspacing="0" width="100%" style="margin-top:5px;">
                                  <thead>
                                      <tr>
                                          <th width="15%">Nota/Certificado</th>
                                          <th width="15%">Nro</th>
                                          <th width="20%">Fecha</th>
                                          <th width="20%">Archivo</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                  </tfoot>
                                  <tbody>
                                  </tbody>
                              </table>
                              <div class="form-group col-sm-12">                                
                                  <table id="example" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>#</th>                                            
                                              <th>Nombre</th>
                                              <th>Fecha</th>
                                              <th>Descargar</th>
                                              @if($paciente->evolucion!='FALLECIO')                            
                                              <th>Eliminar</th>    
                                              @endif                        
                                          </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($archivos as $key => $file)
                                          <tr>
                                              <td>{{$key+1}}</td>                                            
                                              <td>
                                                  {!! $file->nombre_archivo !!} 
                                              </td>
                                              <td>
                                              <?php 
                                                  if($file->extension_archivo=='pdf'){
                                                      $imagen='fa fa-file-pdf-o';
                                                      $color='bg-red';
                                                  }else
                                                  {   if($file->extension_archivo=='xls' || $file->extension_archivo=='xlsx'){
                                                          $imagen='fa-file-excel-o';
                                                          $color='bg-green';
                                                      }
                                                      else
                                                      {
                                                          if($file->extension_archivo=='doc' || $file->extension_archivo=='docx'){
                                                              $imagen='fa-file-word-o';
                                                              $color='bg-blue';
                                                          }
                                                          else
                                                          {
                                                              if($file->extension_archivo=='jpg' || $file->extension_archivo=='gif' || $file->extension_archivo=='jpeg' || $file->extension_archivo=='png' || $file->extension_archivo=='svg' || $file->extension_archivo=='eps' || $file->extension_archivo=='psd' ){
                                                                  $imagen='fa-file-image-o';
                                                                  $color='bg-purple';
                                                              }
                                                              else
                                                              {
                                                                  $imagen='fa-archive';
                                                                  $color='bg-orange';
                                                              }
                                                          }
                                                      }
                                                  }
                                              ?>
                                                  <a target="_blank" href='{{ asset ("$file->descarga_archivo") }}' class='btn <?php echo $color; ?>'><i class="fa <?php echo $imagen; ?>"></i></a>
                                              </td>  
                                              @if($paciente->evolucion!='FALLECIO')                         
                                              <td>                                
                                                  <a href="{!! route('aislamientos.eliminar_archivo',['id'=>$file->id,$id, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>
                                              </td>
                                              @endif
                                          </tr>
                                      @endforeach
                                      </tbody>
                                  </table>                                
                              </div>
                          <!--/div-->
                      </div>
                  @endif
                  @if($paciente->evolucion!='FALLECIO')
                    @if($evolucion->evolucion!=3)
                      <div class="box-body">
                        <div class="form-group col-sm-12">
                          {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}            
                        </div>
                      </div>
                    @endif
                  @endif
              </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
</div>

@endsection

