@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral_comandancia')
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <section class="content-header">
        <h1 class="pull-left">Fichas Registradas</h1>
          <br/><br/>
      </section>
      <div class="nav-tabs-custom">
        <div class="tab-content">
          <div class="active tab-pane" id="antecedentes">
            <div class="content">
              <div class="clearfix"></div>
              @include('flash::message')        
              <div class="clearfix"></div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-12">
                      <!-- Main content -->
                      <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                          <div class="col-12">
                            <h4>
                              <i class="fas fa-globe"></i> {{$dato_paciente->dni}} : {{$dato_paciente->nombres}} {{$dato_paciente->paterno}} {{$dato_paciente->materno}}
                              
                            </h4>
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                          <div class="col-sm-4 invoice-col">
                            
                            <address>
                              <strong>Parentesco: {{$dato_paciente->parentesco}}</strong><br>
                              {{$dato_paciente->domicilio}}<br>
                              {{$dato_paciente->nombre_dist}}, {{$dato_paciente->nombre_prov}} - {{$dato_paciente->nombre_dpto}}<br>
                              Telefono: {{$dato_paciente->telefono}}
                            </address>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 invoice-col">
                            
                            <address>
                              <strong>Sexo: {{$dato_paciente->sexo}}</strong><br>
                              Edad : {{$dato_paciente->edad}}<br>
                              Fecha Nacimiento : {{$dato_paciente->fecha_nacimiento}}<br>
                              Grado: {{$dato_paciente->grado}}<br>
                              
                            </address>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 invoice-col">
                            
                            <address>
                            <strong>Situación: {{$dato_paciente->situacion}}</strong><br>
                            Categoría: {{$dato_paciente->descripcion}}<br>
                            CIP: {{$dato_paciente->cip}}<br>
                            
                            </address>
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        @if($existe_antecedente=='SI')
                        <!-- Table row -->
                        <div class="row">
                          <div class="col-12 table-responsive">
                            <div class="box box-primary">
                              <div class="box-body">
                                <div class="callout callout-info">
                                  <h5><i class="fas fa-info"></i> Antecedentes:</h5>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-4">
                                      <label>Fecha de Notificacion:</label> 
                                      <?php
                                        if($ficha->fecha_notificacion!=''){
                                          $originalDateN = $ficha->fecha_notificacion;
                                          $fechaN = date("d-m-Y", strtotime($originalDateN));
                                          echo $fechaN;  
                                        }
                                        else
                                        {
                                          echo '';
                                        }
                                        
                                      ?>
                                  </div>
                                  <div class="form-group col-sm-4">
                                    <label>Clasificacion del caso:</label> 
                                    <?php 
                                      switch($antecedentes->id_clasificacion){
                                        case 1 : echo 'Confirmado'; break; 
                                        case 2 : echo 'Probable'; break; 
                                        case 3 : echo 'Sospechoso'; break; 
                                        case 4 : echo 'Descartado'; break; 
                                      }
                                    ?>
                                  </div>
                                  <div class="form-group col-sm-4">
                                    <label>Tipo del caso:</label> 
                                    <?php 
                                      switch($antecedentes->id_tipo_caso){
                                        case 1 : echo 'Sintomatico'; break; 
                                        case 2 : echo 'Asintomatico'; break; 
                                      }
                                    ?>
                                  </div>
                                  @if($antecedentes->id_tipo_caso  == 1)
                                  <div class="form-group col-sm-4">
                                      <label>Fecha  de inicio de sintomas</label>
                                      <?php
                                        if($antecedentes->fecha_sintoma!=''){
                                          $originalDate1 = $antecedentes->fecha_sintoma;
                                          $fechaE = date("d-m-Y", strtotime($originalDate1));
                                          echo $fechaE;
                                        }
                                        else{
                                            echo '';
                                        }
                                      ?>
                                  </div>
                                  @endif
                                  <div class="form-group col-sm-4">
                                      <label>Fecha  de inicio de aislamiento</label>
                                      <?php
                                        if($antecedentes->fecha_aislamiento!=''){
                                          $originalDate2 = $antecedentes->fecha_aislamiento;
                                          $fecha2 = date("d-m-Y", strtotime($originalDate2));
                                          echo $fecha2;  
                                        }
                                        else{
                                          echo '';
                                        }
                                        
                                      ?>
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Lugar probable de infeccion</label><br/>
                                    <div class="form-group col-sm-12">
                                      <label>Departamento:</label>
                                      @foreach($departamentos2 as $dep)
                                      <?php if($antecedentes->id_departamento2 == $dep->id) echo $dep->nombre;?>
                                      @endforeach
                                      <br/>
                                      <label>Provincia:</label>
                                          @foreach($provincias2 as $prov)
                                          <?php if($antecedentes->id_provincia2 == $prov->id)echo $prov->nombre;?>
                                          @endforeach
                                      
                                      <br/>
                                      <label>Distrito:</label>
                                        @foreach($distritos2 as $dist)
                                         <?php if($antecedentes->id_distrito2 == $dist->id)echo $dist->nombre;?>
                                        @endforeach
                                    </div>
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Sintomas</label> 
                                    <br/>                
                                    <table><?php $x=0; 
                                        ?>
                                        @foreach($sintomas as $id => $sintoma)
                                          <?php $x++;?>
                                            <tr>
                                                <td>
                                                    {{ $antecedentes->sintomaantecedentes->pluck('id')->contains($sintoma->id) ? $sintoma->descripcion : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    @if ($antecedentes->otro_sintoma!='')
                                      <label>Otro, especificar:</label>{{$antecedentes->otro_sintoma}}
                                    @else
                                      No Tiene
                                    @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Signos</label> 
                                    <br/>                
                                    <table><?php $y=0; ?>
                                        @foreach($signos as $id => $signo)
                                          <?php $y++;?>
                                            <tr>
                                                <td>
                                                    {{ $antecedentes->signoantecedentes->pluck('id')->contains($signo->id) ? $signo->descripcion : '' }}
                                                </td>                 
                                            </tr>
                                        @endforeach
                                    </table>
                                    @if ($antecedentes->otro_signo!='')
                                      <label>Otro, especificar:</label>{{$antecedentes->otro_signo}}
                                    @else
                                      No Tiene
                                    @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Factor de Riesgo</label> 
                                    <br/>                
                                    <table><?php $z=0; ?>
                                        @foreach($factorriesgos as $id => $friesgo)
                                          <?php $z++;?>
                                            <tr>
                                                <td>
                                                    {{ $antecedentes->factorantecedentes->pluck('id')->contains($friesgo->id) ? $friesgo->descripcion : '' }}
                                                </td>                   
                                            </tr>
                                        @endforeach
                                    </table>
                                    @if ($antecedentes->otro_factor_riesgo!='')
                                      <label>Otro, especificar:</label>{{$antecedentes->otro_factor_riesgo}}
                                    @else
                                      No Tiene
                                    @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <br/>
                                    <label>Has tenido contacto directo con un caso sospechoso, probable o confirmado en los 14 dias previos al inicio de los sintomas?</label> 
                                    <br/>
                                    <?php 
                                      switch($antecedentes->contacto_directo){
                                        case 'SI' : echo 'SI'; break; 
                                        case 'NO' : echo 'NO'; break; 
                                        case  3   : echo 'Desconocido'; break; 
                                      }
                                    ?>
                                    @if($paciente->contacto_directo == 'SI')
                                      <table><?php $x=1; ?>
                                        @foreach($lugares as $id => $lugar)
                                        <tr>
                                          <td>
                                              {{ $antecedentes->lugarantecedentes->pluck('id')->contains($lugar->id) ? $lugar->descripcion : '' }}
                                          </td>
                                        </tr>
                                        @endforeach
                                      </table>
                                    @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Ficha de Investigacion Epidemiologica / Ficha Contacto</label> 
                                    <br/>
                                    <?php 
                                      switch($antecedentes->ficha_contacto){
                                        case 'SI' : echo 'SI'; break; 
                                        case 'NO' : echo 'NO'; break; 
                                      }
                                    ?>
                                  </div>
                                  <div class="form-group col-sm-12">
                                    @if($paciente->sexo=='F')
                                      <label>Gestante ?</label> 
                                      <br/>
                                      <?php 
                                        switch($antecedentes->gestante){
                                          case 1 : echo 'SI'; break; 
                                          case 2 : echo 'NO'; break; 
                                        }
                                      ?>
                                    </div>
                                      @if($antecedentes->gestante==1)
                                        <div class="form-group col-sm-12"><br/>
                                          <label>Nro de semana de gestacion:</label><?php echo $antecedentes->semana_gestacion; ?>
                                        </div>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-4">
                                    <label>Vacunado contra la COVID-19?</label>
                                    <br/>
                                      <?php 
                                          switch($antecedentes->vacuna_covid){
                                            case 'SI' : echo 'SI'; break; 
                                            case 'NO' : echo 'NO'; break; 
                                          }
                                      ?>
                                  </div>
                                </div>
                                @if($antecedentes->vacuna_covid == 'SI')
                                <div class="row col-sm-12">
                                  <div  id="divcovid_directo2">
                                    <div class="table-responsive" >
                                      <table class="table table-bordered table-striped" id="ejemplo1" cellspacing="0" width="100%" style="margin-top:5px;">
                                        <thead>
                                          <tr>
                                            <th>Dosis</th>
                                            <th>Fecha de Vacunacion</th>
                                            <th>Tipo de Vacuna</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                              <td><b>1 dosis</b></td>
                                              <td><?php
                                                    if($antecedentes->fecha_vacunacion_1!=''){
                                                      $originalDate1 = $antecedentes->fecha_vacunacion_1;
                                                      $fechaE = date("d-m-Y", strtotime($originalDate1));
                                                    }
                                                    else{
                                                     $fechaE =''; 
                                                    }
                                                    echo $fechaE;
                                                  ?>
                                              </td>
                                              <td>
                                                    @foreach($fabricantes as $fabricante)
                                                      <?php if($antecedentes->fabricante_1 == $fabricante->descripcion) echo $fabricante->descripcion;?>
                                                    @endforeach
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><b>2 dosis</b></td>
                                              <td><?php
                                                    if($antecedentes->fecha_vacunacion_2!=''){
                                                      $originalDate1 = $antecedentes->fecha_vacunacion_2;
                                                      $fechaE = date("d-m-Y", strtotime($originalDate1));
                                                    }
                                                    else{
                                                     $fechaE =''; 
                                                    }
                                                    echo $fechaE;
                                                  ?></td>
                                              <td>
                                                    @foreach($fabricantes as $fabricante)
                                                      <?php if($antecedentes->fabricante_2 == $fabricante->descripcion) echo $fabricante->descripcion;?>
                                                    @endforeach
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><b>3 dosis</b></td>
                                              <td><?php
                                                    if($antecedentes->fecha_vacunacion_3!=''){
                                                      $originalDate1 = $antecedentes->fecha_vacunacion_3;
                                                      $fechaE = date("d-m-Y", strtotime($originalDate1));
                                                    }
                                                    else{
                                                     $fechaE =''; 
                                                    }
                                                    echo $fechaE;
                                                  ?></td>
                                              <td>
                                                    @foreach($fabricantes as $fabricante)
                                                      <?php if($antecedentes->fabricante_3 == $fabricante->descripcion) echo $fabricante->descripcion;?>
                                                    @endforeach
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><b>Dosis adicional</b></td>
                                              <td><?php
                                                    if($antecedentes->fecha_vacunacion_4!=''){
                                                      $originalDate1 = $antecedentes->fecha_vacunacion_4;
                                                      $fechaE = date("d-m-Y", strtotime($originalDate1));  
                                                    }
                                                    else{
                                                     $fechaE =''; 
                                                    }
                                                    
                                                    echo $fechaE;
                                                  ?></td>
                                              <td>
                                                    @foreach($fabricantes as $fabricante)
                                                      <?php if($antecedentes->fabricante_4 == $fabricante->descripcion) echo $fabricante->descripcion;?>
                                                    @endforeach
                                              </td>
                                            </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Es caso de reinfeccion?</label> 
                                    <br/>
                                    <?php 
                                        
                                        switch($antecedentes->caso_reinfeccion){
                                          case 'NO' : echo 'NO'; break; 
                                          case 'SI' : echo 'SI'; break; 
                                          case 'NN' : echo 'Desconocido'; break;
                                        }
                                    ?>
                                  </div>
                                </div>
                                <?php if($antecedentes->caso_reinfeccion!=0 and $antecedentes->caso_reinfeccion=='SI'): ?> 
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <div class="form-group col-sm-6">
                                      <label>Presento sintomas</label>
                                      <br/>
                                      <?php 
                                          switch($antecedentes->sintoma_reinfeccion){
                                            case 'SI' : echo 'SI'; break; 
                                            case 'NO' : echo 'NO'; break; 
                                          }
                                      ?>
                                      <br/>
                                    </div>
                                    <div class="form-group col-sm-6">
                                      <label>Fecha  de inicio de sintomas</label><br/>
                                      <?php
                                        if($antecedentes->fecha_sintoma_reinfeccion!=''){
                                          $originalDate1 = $antecedentes->fecha_sintoma_reinfeccion;
                                          $fechaE = date("d-m-Y", strtotime($originalDate1));
                                          echo $fechaE;  
                                        }
                                        else
                                        {
                                          echo '';
                                        }
                                        
                                      ?>
                                    </div>
                                  </div>
                                  <div class="col-md-12"> 
                                    <div class="form-group col-sm-4">
                                      <label>Prueba confirmatoria inicial</label>
                                      <br/>
                                      <?php 
                                          switch($antecedentes->prueba_confirmatoria){
                                            case 1 : echo 'Prueba Molecular'; break; 
                                            case 2 : echo 'Prueba Antigeno'; break; 
                                            case 3 : echo 'Prueba Serologica'; break; 
                                          }
                                      ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Fecha  de resultado</label><br/>
                                        <?php
                                          if($antecedentes->fecha_resultado_reinfeccion!=''){
                                            $originalDate1 = $antecedentes->fecha_resultado_reinfeccion;
                                            $fechaE = date("d-m-Y", strtotime($originalDate1));
                                            echo $fechaE;
                                          }
                                          else
                                          {
                                            echo ''; 
                                          }
                                          
                                        ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Clasificacion de reinfeccion</label><br/>
                                        <?php 
                                          switch($antecedentes->id_clasificacion){
                                            case 1 : echo 'Reinfeccion Sospechosa'; break; 
                                            case 2 : echo 'Reinfeccion Probable'; break; 
                                            case 3 : echo 'Reinfeccion Confirmada'; break; 
                                          }
                                        ?>
                                    </div>
                                  </div>
                                </div> 
                                <?php endif; ?>
                                <div class="row col-sm-12">
                                  <div class="col-md-12"><br/>
                                    <label>Está Hospitalizado?</label> 
                                    <br/>
                                    <?php 
                                        switch($ficha->hospitalizado){
                                          case 'SI' : echo 'SI'; break; 
                                          case 'NO' : echo 'NO'; break; 
                                        }
                                    ?>
                                  </div>
                                  <div class="col-md-12"><br/>                
                                    <label>Observacion:</label> <br/>                                
                                    <?php echo $antecedentes->observacion;?>
                                  </div>
                                </div>
                              </div>
                              <!--box-body-->
                            </div>
                            <!--box-primary-->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        @endif


                        @if($existe_hospitalizacion=='SI')
                        <!-- Table row -->
                        <div class="row">
                          <div class="col-12 table-responsive">
                            <div class="box box-primary">
                              <div class="box-body">
                                <div class="callout callout-info">
                                  <h5><i class="fas fa-info"></i> Hospitalizacion:</h5>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-3">
                                    <label>Referido:</label><br/>
                                    <?php 
                                      switch($pac_hospitalizado->referido){
                                        case 1 : echo 'SI'; break; 
                                        case 2 : echo 'NO'; break; 
                                      }
                                    ?>
                                  </div>
                                  @if($pac_hospitalizado->referido == 1)
                                    <div   class="form-group col-sm-6">
                                      <label>IPRESS de donde Proviene:</label><br/>
                                          @foreach($establecimiento_salud as $dep)
                                            <?php if($pac_hospitalizado->establecimiento_proviene == $dep->id)echo $dep->nombre_establecimiento_salud;?> 
                                          @endforeach
                                    </div>
                                    <div class="form-group col-sm-3">
                                      <label>Fecha  Referencia</label><br/>
                                      <?php
                                        if($pac_hospitalizado->fecha_referencia!=''){
                                          $originalDate1 = $pac_hospitalizado->fecha_referencia;
                                          $fechaE = date("d-m-Y", strtotime($originalDate1));
                                          echo $fechaE;
                                        }
                                        else
                                        {
                                          echo '';
                                        }
                                      ?>
                                    </div>
                                  @endif
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-3">
                                      <label>Fecha  de Hospitalizacion</label><br/>
                                      <?php
                                        if($pac_hospitalizado->fecha_hospitalizacion!=''){
                                          $originalDate1 = $pac_hospitalizado->fecha_hospitalizacion;
                                          $fechaE = date("d-m-Y", strtotime($originalDate1));
                                          echo $fechaE;
                                        }
                                        else
                                        {
                                            echo '';
                                        }
                                          
                                        ?>
                                  </div>
                                  <div class="form-group col-sm-6">
                                      <label>Ipress donde se encuentra Hospitalizado:</label><br/>
                                          @foreach($establecimiento_salud as $dep)
                                          <?php if($pac_hospitalizado->establecimiento_actual == $dep->id) echo $dep->nombre_establecimiento_salud; ?>
                                          @endforeach
                                      
                                  </div>
                                  <div class="form-group col-sm-3">
                                      <label>Tipo de Nombre Seguro:</label><br/>
                                      <?php 
                                      switch($pac_hospitalizado->tipo_seguro){
                                        case 1 : echo 'Saludpol'; break; 
                                        case 2 : echo 'Essalud'; break; 
                                      }
                                    ?>
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Diagnosticos de ingreso:</label><br/>
                                    @if($count_diagnostico!=0)
                                      <table class="display" id="tblDiagnosticos" cellspacing="0" width="100%" style="margin-top:5px;">
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
                                          <?php foreach($diagnostico as $row):
                                            $tipo_diagnostico = "";
                                            if($row->id_tipo_diagnostico==1)$tipo_diagnostico = "PRESUNTIVO";
                                            if($row->id_tipo_diagnostico==2)$tipo_diagnostico = "DEFINITIVO";
                                            if($row->id_tipo_diagnostico==3)$tipo_diagnostico = "REITERATIVO";
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
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-4">
                                    <br/>
                                    <label>Signos</label> 
                                    <br/>                
                                    <table><?php $x=1; ?>
                                      @foreach($signos as $id => $signo)
                                      <tr>
                                        <td>
                                            {{ $pac_hospitalizado->signohospitalizados->pluck('id')->contains($signo->id) ? $signo->descripcion : '' }}
                                        </td>
                                                                 
                                      </tr>
                                      @endforeach
                                    </table>
                                      @if ($pac_hospitalizado->otro_signo_ho!='')
                                        <label>Otro, especificar:</label><br/>{{$pac_hospitalizado->otro_signo_ho}}
                                      @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>El caso esta o estuvo intubado en algun momento durante la enfermedad? </label> <br/>
                                        @foreach($sinos as $si)
                                         <?php if($pac_hospitalizado->intubado == $si->id) echo $si->descripcion; ?>
                                        @endforeach
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12"><br/>
                                    <label>El paciente estuvo en ventilacion mecanica</label> <br/>
                                    @foreach($sinos as $si)
                                      <?php if($pac_hospitalizado->ventilacion_mecanica == $si->id)echo $si->descripcion;?>
                                    @endforeach
                                    <?php if($pac_hospitalizado->ventilacion_mecanica == 3) echo "Desconocido";?>
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12"><br/>
                                    <label>El caso tiene o tuvo diasgnotico de neumonia durante la enfermedad?</label> <br/>
                                        @foreach($sinos as $si)
                                          <?php if($pac_hospitalizado->neumonia == $si->id)echo $si->descripcion;?>
                                        @endforeach
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12"><br/>
                                    <label>El paciente presento IAAS? </label> <br/>
                                    <?php 
                                      switch($iaas){
                                        case 1 : echo 'SI'; break; 
                                        case 2 : echo 'NO'; break; 
                                        case 3 : echo 'Desconocido'; break; 
                                      }
                                    ?>
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12">
                                    <label>Lugar de Hospitalizacion</label> <br/>
                                    @if($pac_hospitalizado->fecha_ingreso_s2!='')
                                    <div class="row col-sm-12">
                                      <div class="form-group col-sm-4">                    
                                        <label>UNIDAD DE CUIDADOS INTENSIVOS</label>
                                      </div>
                                      <div class="form-group col-sm-8">
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Ingreso:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_ingreso_s2;?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Alta:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_alta_s2; ?>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                    @if($pac_hospitalizado->fecha_ingreso_s3!='')
                                    <div class="row col-sm-12">
                                      <div class="form-group col-sm-4">                    
                                        <label>UNIDAD DE CUIDADOS INTERMEDIOS</label>
                                      </div>
                                      <div class="form-group col-sm-8">
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Ingreso:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_ingreso_s3;?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Alta:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_alta_s3; ?>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                    @if($pac_hospitalizado->fecha_ingreso_s4!='')
                                    <div class="row col-sm-12">
                                      <div class="form-group col-sm-4">                    
                                        <label>TRAUMA SHOCK</label> <br/>
                                      </div>
                                      <div class="form-group col-sm-8">
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Ingreso:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_ingreso_s4;?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Alta:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_alta_s4; ?>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                    @if($pac_hospitalizado->fecha_ingreso_s5!='')
                                    <div class="row col-sm-12">
                                      <div class="form-group col-sm-4">                    
                                        <label>SALA DE AISLAMIENTO</label> <br/>
                                      </div>
                                      <div class="form-group col-sm-8">
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Ingreso:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_ingreso_s5;?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Alta:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_alta_s5; ?>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                    @if($pac_hospitalizado->fecha_ingreso_s6!='')
                                    <div class="row col-sm-12">
                                      <div class="form-group col-sm-4">                    
                                        <label>OTRO</label> <br/>
                                        <?php echo $pac_hospitalizado->otra_ubicacion?>
                                      </div>
                                      <div class="form-group col-sm-8">
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Ingreso:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_ingreso_s6;?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                          <label>Fecha de Alta:</label><br/>
                                          <?php echo $pac_hospitalizado->fecha_alta_s6; ?>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="col-md-12">                
                                    <label>Observacion</label> <br/>
                                    <?php echo $pac_hospitalizado->observacion; ?><br/>
                                  </div>
                                </div>
                              
                              </div> 
                              <!--body-->
                            </div>
                            <!--primary-->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        @endif
                        
                        <!-- Table row -->
                        <div class="row">
                          <div class="col-12 table-responsive">
                            <div class="box box-primary">
                              <div class="box-body">
                                <div class="callout callout-info">
                                  <h5><i class="fas fa-info"></i> Examen de Apoyo al Diagnostico</h5>
                                </div>
                                <div class="row col-sm-12">
                                  <div class="form-group col-sm-12"> 
                                    <table class="table" id="tblDiagnosticos" cellspacing="0" width="100%" style="margin-top:5px;">
                                      <thead>
                                          <tr>
                                              <th width="10%">F. Muestra</th>
                                              <th width="10%">T. Muestra</th>
                                              <th width="10%">T. Prueba</th>
                                              <th width="10%">Resultado</th>
                                              <th width="10%">F Resultado</th>
                                              <th width="10%">Enviado MINSA</th>
                                              <th width="10%">S. Genético</th>
                                              <th width="10%">Linaje</th>
                                              <th width="10%">Tomografia</th>
                                              <th width="10%">RX Tórax</th>
                                          </tr>
                                      </thead>
                                      <tfoot>
                                      </tfoot>
                                      <tbody>
                                          <?php foreach($laboratorio as $row):
                                              $minsa = "";
                                              if($row->enviado_minsa==1)$minsa = "SI";
                                              if($row->enviado_minsa==2)$minsa = "NO";
                                              if($row->enviado_minsa==3)$minsa = "Sin Información";
                                          ?>
                                          <tr>
                                              <td>
                                                  <?php
                                                    if($row->fecha_muestra!=''){
                                                      $originalDate1 = $row->fecha_muestra;
                                                      $fechaE = date("d-m-Y", strtotime($originalDate1));
                                                      echo $fechaE;
                                                    }else
                                                    {
                                                      echo '';
                                                    }
                                                    
                                                  ?>
                                              </td>
                                              <td><?php echo $row->muestra?></td>
                                              <td><?php echo $row->prueba?></td>                            
                                              <td><?php echo $row->resultado?></td>
                                              <td>
                                                  <?php
                                                    if($row->fecha_resultado!=''){
                                                      $originalDate2 = $row->fecha_resultado;
                                                      $fechaR = date("d-m-Y", strtotime($originalDate2));
                                                      echo $fechaR;
                                                    }
                                                    else
                                                    {
                                                      echo '';
                                                    }
                                                  ?>
                                              </td>
                                              <td><?php echo $minsa?></td>
                                              <td><?php echo $row->sg;?></td>
                                              <td><?php echo $row->linaje;?></td>
                                              <td><?php echo $row->tomografia;?></td>
                                              <td><?php echo $row->radiografia;?></td>
                                          </tr>
                                          <?php endforeach;?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      @if($existe_hospitalizacion=='SI')
                        <?php
                          $diagnostico = App\Models\Diagnostico::GetDiagnosticoByHosp($id,1);
                          $count_diagnostico = count($diagnostico);

                          $establecimiento_salud = App\Models\EstablecimientoSalud::getAllEstablecimientoSalud();
                          //$establecimiento_actual=0;
                        $date =  Carbon\Carbon::now();
                        ?>
                        <!-- Table row -->
                        <div class="row">
                          <div class="col-12 table-responsive">
                            <div class="box box-primary">
                              <div class="box-body">
                                <div class="callout callout-info">
                                  <h5><i class="fas fa-info"></i> Evolucion</h5>
                                </div>
                                <div class="row col-sm-12">
                                  <table class="table" id="tblEvolucion" cellspacing="0" width="100%" style="margin-top:5px;">
                                    <thead>
                                      <tr>
                                        <th width="10%">Evolucion</th>
                                        <th width="10%">Descripcion</th>
                                        <th width="10%">Fecha Alta</th>
                                        <th width="70%">Datos Fallecimiento</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($evoluciones as $row):?>
                                        <tr>
                                        <?php switch ($row->evolucion) {
                                            case '0': $evolucion='';break;
                                            case '1': $evolucion='Favorable';break;
                                            case '2': $evolucion='Desfavorable';break;
                                            case '3': $evolucion='Fallecio';break;
                                            case '4': $evolucion='Alta Aislamiento';break;
                                            case '5': $evolucion='Alta Voluntaria';break;
                                            case '6': $evolucion='Referido';break;
                                            case '7': $evolucion='Fugado';break;
                                            case '8': $evolucion='Alta Médica/Hospitalaria';break;
                                            case '9': $evolucion ='En Observación' ; break;
                                            case '10': $evolucion ='Estable' ; break;
                                            case '11': $evolucion ='Estacionario' ; break;
                                        } ?>
                                          <td>{{$evolucion}}</td>
                                          <td>{{$row->descripcion_evolucion}}</td>
                                          <td>{{$row->fecha_alta}}</td>
                                          <td>
                                          <?php 
                                              //use DB;
                                            $evolucion = App\Models\Evolucion::where('id', $row->id)->Where('dni',$dni)->Where('idficha',$idficha)->first();

                                            $fecha_alta = $evolucion->fecha_alta;
                                            $fecha_defuncion = $evolucion->fecha_defuncion;
                                            if(is_null($fecha_alta))
                                                $fecha_alta=$date->format('Y-m-d');
                                            
                                            if(is_null($fecha_defuncion))
                                                $fecha_defuncion=$date->format('Y-m-d');

                                            $establecimiento_actual=$evolucion->hospital_fallecimiento;
                                            $otro_lugar=$evolucion->otro_lugar_fallecimiento;
                                            $observacion=$evolucion->observacion;
                                              
                                            $archivos= DB::table('defunciones')
                                                          ->where('aislado_id','=',$id)
                                                          ->where('estado',1)
                                                          ->get();
                                            $nota_informativa= DB::table('archivos')
                                                          ->where('dni','=',$dni)
                                                          ->where('aislado_id','=',$id)
                                                          ->where('estado',1)
                                                          ->where('tipo_archivo',1)
                                                          ->get();
                                            $certificado_defuncion= DB::table('archivos')
                                                          ->where('dni','=',$dni)
                                                          ->where('aislado_id','=',$id)
                                                          ->where('estado',1)
                                                          ->where('tipo_archivo',2)
                                                          ->get();
                                          ?>
                                          @if($evolucion->evolucion==3)
                                            <table>
                                              <tr>
                                                <td>
                                                  <label>Clasifica Defuncion</label><br/>
                                                  <?php 
                                                    switch($evolucion->evolucion){
                                                      case 1: echo "Criterio Virologico";break;
                                                      case 2: echo "Criterio Serologico";break;
                                                      case 3: echo "Criterio Radiologico";break;
                                                      case 4: echo "Nexo Epidemiológico";break;
                                                      case 5: echo "Criterio Investigacion epidemiologica";break;
                                                      case 6: echo "Criterio Clinico";break;
                                                      case 7: echo "Criterio SINADEF";break;
                                                    } 
                                                  ?>
                                                </td>
                                                <td>
                                                  <label>Fecha  de defuncion</label><br/>
                                                  {{$fecha_defuncion}}
                                                </td>
                                                <td>
                                                  <label>Hora de defuncion</label><br/>
                                                  {{$evolucion->hora_defuncion}}
                                                </td>
                                                <td>
                                                  <label>Lugar de defuncion:</label><br/>
                                                  <?php 
                                                    switch($evolucion->evolucion){
                                                      case 1: echo "Hospital/Clinica";break;
                                                      case 2: echo "Vivienda";break;
                                                      case 3: echo "Centro de Aislamiento temporal";break;
                                                      case 4: echo "Centro penitenciario";break;
                                                      case 5: echo "Via publica";break;
                                                      case 6: echo "Otros";break;
                                                    } 
                                                  ?>
                                                  @if($evolucion->otro_lugar_fallecimiento!='')
                                                    {{$evolucion->otro_lugar_fallecimiento}}
                                                  @endif
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="4">
                                                  <label>Hospital/Clinica Fallecimiento:</label><br/>
                                                  @foreach($establecimiento_salud as $dep)
                                                    <?php if($establecimiento_actual == $dep->id)echo $dep->nombre_establecimiento_salud;?>
                                                  @endforeach
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="4">
                                                  <label>Observacion</label> <br/>
                                                  {{$evolucion->observacion}}
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="4">
                                                  <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>#</th>                                            
                                                        <th>Tipo de Documento</th>
                                                        <th>Numero Doc</th>
                                                        <th>Fecha</th>
                                                        <th>Nombre Archivo</th>   
                                                        <th>Descargar</th>  
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
                                                      </tr>
                                                      @endforeach
                                                    </tbody>
                                                  </table>
                                                </td> 
                                              </tr>
                                            </table>
                                          @endif
                                        </td>
                                      </tr>
                                      <?php endforeach;?>
                                    </tbody>
                                </table>
                              </div><!--body-->
                            </div><!--primary-->
                          </div> 
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                        <!-- /.row -->
                      @endif

                      @if($existe_ficha_contacto=='SI')
                        <?php
                          $diagnostico = App\Models\Diagnostico::GetDiagnosticoByHosp($id,1);
                          $count_diagnostico = count($diagnostico);

                          $establecimiento_salud = App\Models\EstablecimientoSalud::getAllEstablecimientoSalud();
                          //$establecimiento_actual=0;
                        $date =  Carbon\Carbon::now();
                        ?>
                        <!-- Table row -->
                        <div class="row">
                          <div class="col-12 table-responsive">
                            <div class="box box-primary">
                              <div class="box-body">
                                <div class="callout callout-info">
                                  <h5><i class="fas fa-info"></i> Contacto</h5>
                                </div>
                                <div class="row col-sm-12">
                                  <table class="table" id="tblEvolucion" cellspacing="0" width="100%" style="margin-top:5px;">
                                    <thead>
                                      <tr>
                                        <th width="5%">#</th>
                                        <th width="95%">Contacto</th>
                                      </tr>
                                    </thead>
                                    <tbody><?php $x=1?>
                                      <?php foreach($contactos as $row):
                                          $contacto = App\Models\Contacto::where('id', $row->id)->Where('dni_aislado',$dni)->Where('idficha',$idficha)->first();
                                          
                                          $departamentos3 = App\Models\Departamento::getDpto();
                                          $provincias3 = App\Models\Provincia::getProv($contacto->id_departamento_contacto);
                                          $distritos3 = App\Models\Distrito::getDist($contacto->id_departamento_contacto,$contacto->id_provincia_contacto); 
                                      ?>


                                        <tr>
                                          <td>
                                            {{$x++}}
                                          </td>
                                          <td>
                                            <table class="table" id="tblEvolucion" cellspacing="0" width="100%" style="margin-top:5px;">
                                              <thead>
                                                <tr>
                                                  <th width="10%">DNI</th>
                                                  <th width="40%">Nombre</th>
                                                  <th width="10%">Sexo</th>
                                                  <th width="10%">Fecha Nacimiento</th>
                                                  <th width="30%">Correo</th>
                                                </tr>
                                                <tr>
                                                  <td><?php echo $row->dni_contacto?></td>
                                                  <td><?php echo $row->nombres_contacto.', '.$row->paterno_contacto.' '.$row->materno_contacto; ?></td>
                                                  <td><?php echo $row->sexo_contacto?></td>
                                                  <td><?php echo $row->fecha_nacimiento_contacto?></td>
                                                  <td><?php echo $row->correo_contacto?></td>
                                                </tr>
                                                <tr>
                                                  <th>Telefono</th>
                                                  <th>Tipo Contacto</th>
                                                  <th>F. Contacto</th>
                                                  <th>F. Inicio Cuarentena</th>
                                                  <th>El contacto es un caso sospechoso</th>
                                                </tr>
                                                <tr>
                                                  <?php 
                                                    switch ($row->tipo_contacto) {
                                                      case '1': $tipo_contacto='Familiar';break;
                                                      case '2': $tipo_contacto='Centro Laboral';break;
                                                      case '3': $tipo_contacto='Centro de Estudio';break;
                                                      case '4': $tipo_contacto='EESS';break;
                                                      case '5': $tipo_contacto='Evento Social ';break;
                                                      case '6': $tipo_contacto='Atención medica domiciliaria ';break;
                                                      case '7': $tipo_contacto='Otro';break;
                                                    }
                                                    
                                                    switch ($row->contacto_sospechoso) {
                                                      case '1': $contacto_sospechoso='SI';break;
                                                      case '2': $contacto_sospechoso='NO';break;
                                                      case '3': $contacto_sospechoso='Desconocido';break;
                                                      
                                                      
                                                    } 
                                                  ?>
                                                  <td><?php echo $row->telefono_contacto?></td>
                                                  <td><?php echo $tipo_contacto?></td>
                                                  <td><?php
                                                        if($row->fecha_contacto!=''){
                                                          $originalDate2 = $row->fecha_contacto;
                                                          $fechaR = date("d-m-Y", strtotime($originalDate2));
                                                          echo $fechaR;
                                                        }
                                                        else
                                                        {
                                                          echo '';
                                                        }
                                                      ?> 
                                                  </td>
                                                  <td><?php
                                                        if($row->fecha_cuarentena_contacto!=''){
                                                          $originalDate2 = $row->fecha_cuarentena_contacto;
                                                          $fechaR = date("d-m-Y", strtotime($originalDate2));
                                                          echo $fechaR;
                                                        }
                                                        else
                                                        {
                                                          echo '';
                                                        }
                                                      ?>
                                                  </td>
                                                  <td><?php echo $contacto_sospechoso?></td>
                                                </tr>
                                                <tr><td colspan="5"><b>Dirección:</b> {{$row->domicilio_contacto}}</td></tr>
                                                <tr>
                                                  <td colspan="2">
                                                    <label>Factor de Riesgo y comorbilidad</label> 
                                                    <br/>                
                                                    <table><?php $x=1; ?>
                                                        @foreach($factorriesgos as $id => $friesgo)
                                                        <tr>
                                                            <td>
                                                              {{ $contacto->factorcontactos->pluck('id')->contains($friesgo->id) ? $friesgo->descripcion : '' }}
                                                            </td>                    
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                  </td>
                                                  <td><b>Departamento</b><br/>
                                                    @foreach($departamentos3 as $dep)
                                                      <?php if($contacto->id_departamento_contacto == $dep->id)echo $dep->nombre;?>
                                                    @endforeach
                                                  </td>
                                                  <td><b>Provincia</b><br/>
                                                    @foreach($provincias3 as $prov)
                                                      <?php if($contacto->id_provincia_contacto == $prov->id)echo $prov->nombre;?>
                                                    @endforeach
                                                  </td>
                                                  <td><b>Distrito</b><br/>
                                                    @foreach($distritos3 as $dist)
                                                      <?php if($contacto->id_distrito_contacto == $dist->id)echo $dist->nombre;?>
                                                    @endforeach
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                      </tr>
                                      <?php endforeach;?>
                                    </tbody>
                                </table>
                              </div><!--body-->
                            </div><!--primary-->
                          </div> 
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                        <!-- /.row -->
                      @endif

                        
                        

                        
                      </div>
                      <!-- /.invoice -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->   
                </div>
              </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

