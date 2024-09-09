@extends('layouts.master_ficha')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-2">
      @include('admin.aislamientos.menu_lateral_opciones')
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <div class="panel panel-primary filterable" >
        <div class="panel-heading">
            <h3 class="panel-title">EXAMENES DE APOYO AL DIAGNOSTICO - FICHA DE INVESTIGACION CLINICO EPIDEMIOLOGICO COVID-19 </h3>
        </div>
        <!--h2 class="page-header">
            <i class="fa fa-globe"></i> HOSPITALIZACION ESAVI
          </h2-->
        <div class="clearfix"></div>
        @include('flash::message')        
        <div class="clearfix"></div>
        {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_laboratorio']) !!}
          <div class="box-body">
            <div class="row col-sm-12">
                @if($count_laboratorio!=0)
                    <table class="display" id="tblDiagnosticos" cellspacing="0" width="100%" style="margin-top:5px;">
                        <thead>
                            <tr>
                                <th width="10%">Eliminar</th>
                                <th width="15%">Fecha toma muestra</th>
                                <th width="15%">Tipo de muestra</th>
                                <th width="20%">Tipo de Prueba</th>
                                <th width="20%">Resultado</th>
                                <th width="10%">Fecha  de resultado</th>
                                <th width="10%">Enviado MINSA</th>
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
                                    <div class='btn-group'>
                                        <a data-toggle="tooltip" title="Eliminar Registro!" href="/eliminar_laboratorio/{{$row->id}}/{{$id_paciente_lab}}/{{$dni}}/{{$idficha}}" class='btn btn-danger btn-xs'><i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    if($row->fecha_muestra!=''){
                                        $originalDate1 = $row->fecha_muestra;
                                        $fechaE = date("d-m-Y", strtotime($originalDate1));
                                        echo $fechaE;
                                    }
                                    else
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
                                        if($row->fecha_muestra!=''){
                                            $originalDate2 = $row->fecha_resultado;
                                            $fechaR = date("d-m-Y", strtotime($originalDate2));
                                            echo $fechaR;
                                        }
                                        else{
                                            echo '';
                                        }
                                    ?>  
                                </td>
                                <td><?php echo $minsa?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                @endif

            </div>
            @if($paciente->evolucion!='FALLECIO')
                <div class="row col-sm-12">
                    <br /><br />
                    <table class="display" id="ejemplo" cellspacing="0" width="100%" style="margin-top:5px;">
                        <thead>
                            <tr>
                                <th width="15%">Fecha toma muestra</th>
                                <th width="15%">Tipo de muestra</th>
                                <th width="20%">Tipo de Prueba</th>
                                <th width="20%">Resultado</th>
                                <th width="15%">Fecha  de resultado</th>
                                <th width="15%">Enviado MINSA</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td width="15%">
                                    <input type="date" tabindex="3"  required="" name="fecha_muestra" id="fecha_muestra" class="form-control" value="<?php echo $fechaServidor; ?>" >
                                </td>
                                <td width="15%">
                                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="muestra" id="muestra">
                                        <option value="">- Seleccione -</option>
                                        @foreach($muestras as $muestra)
                                            <option value="{{$muestra->id}}" >{{$muestra->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="20%">
                                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="prueba" id="prueba">
                                        <option value="">- Seleccione -</option>
                                        @foreach($pruebas as $prueba)
                                            <option value="{{$prueba->id}}" >{{$prueba->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="20%">
                                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="resultado" id="resultado">
                                        <option value="">- Seleccione -</option>
                                        @foreach($resultados as $resultado)
                                            <option value="{{$resultado->id}}" >{{$resultado->nombre}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="15%">
                                    <input type="date" tabindex="3"  name="fecha_resultado" id="fecha_resultado" class="form-control" value="<?php echo $fechaServidor; ?>" >
                                </td>
                                <td width="20%">
                                    <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="minsa" id="minsa">
                                        <option value="">- Seleccione -</option>
                                        <option value="1">SI</option>
                                        <option value="2">NO</option>
                                        <option value="3">Sin Informacion</option>
                                    </select>
                                </td>
                                
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                    <input type="hidden" name="id_paciente_lab" id="id_paciente_lab" value="<?php echo $id_paciente_lab?>">
                    <input type="hidden" name="dni_lab" id="dni_lab" value="<?php echo $dni?>">
                    <input type="hidden" name="id_ficha" id="id_ficha" value="<?php echo $idficha?>">
                </div>

                <div class="row col-sm-12">
                    <br/>
                     @if($count_laboratorio!=0)
                    <table class="display" id="ejemplo" cellspacing="0" width="100%" style="margin-top:5px;">
                        <thead>
                            <tr>
                                <th width="25%">Secuenciamento Genético</th>
                                <th width="25%">Linaje</th>
                                <th width="25%">Tomografia Computarizada</th>
                                <th width="25%">Radiografia de Tórax</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <?php foreach($laboratorio as $row):?>
                            <tr>
                                <td width="25%">
                                    <?php echo $row->sg;?>
                                </td>
                                <td width="25%">
                                    <?php echo $row->linaje;?>
                                </td>
                                <td width="25%">
                                    <?php echo $row->tomografia;?>
                                </td>
                                <td width="25%">
                                    <?php echo $row->radiografia;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                    @endif
                    <br/>
                    <div class="form-group col-sm-3">
                        <label>Secuenciamento Genético</label><br/>
                        <select class="form-control select2" tabindex="10" required="" name="sg" id="sg">
                            <option value="">- Seleccione -</option>
                            <option value="SI"> SI </option>
                            <option value="NO"> NO </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Linaje</label><br/>
                        <input type="text" name="linaje" id="linaje" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Tomografia Computarizada</label><br/>
                        <select class="form-control select2" tabindex="10" required="" name="tomografia" id="tomografia">
                            <option value="">- Seleccione -</option>
                            <option value="Compatible"> Compatible </option>
                            <option value="No compatible"> No Compatible </option>
                            <option value="Sin Información"> Sin Información </option>
                        </select>
                    </div>
                     <div class="form-group col-sm-3">
                        <label>Radiografia de Tórax</label><br/>
                        <select class="form-control select2" tabindex="10" required="" name="radiografia" id="radiografia">
                            <option value="">- Seleccione -</option>
                            <option value="Sugestivo"> Sugestivo </option>
                            <option value="No Sugestivo"> No Sugestivo </option>
                            <option value="Sin Información"> Sin Información </option>
                        </select>
                    </div>
                </div>
                
            @endif
        </div>
        
        <div class="box-body">
            <div class="form-group col-sm-12">
                {!! Form::submit('Grabar Examenes', ['class' => 'btn btn-success']) !!}
                @if($ficha->hospitalizado=='NO')
                    @if($existe_ficha_contacto=='NO')
                        @if($nro_lab>0)
                            @if($nro_lab>0)
                                <a href="{!! route('aislamientos.cerrar_ficha',[$idficha, $id_paciente_lab, $dni]) !!}" class="btn btn-primary">Cerrar Ficha</a>
                            @endif
                        @endif
                    @else
                        @if($nro_contacto>0)
                            @if($nro_lab>0)
                                <a href="{!! route('aislamientos.cerrar_ficha',[$idficha, $id_paciente_lab, $dni]) !!}" class="btn btn-primary">Cerrar Ficha</a>
                            @endif
                        @endif
                    @endif
                @else
                    @if($paciente->evolucion=='FALLECIO')
                    <a href="{!! route('aislamientos.cerrar_ficha',[$idficha, $id_paciente_lab, $dni]) !!}" class="btn btn-primary">Cerrar Ficha</a>
                    @endif            
                @endif
            </div>
        </div>
        
        {!! Form::close() !!}
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
</div>
@endsection

