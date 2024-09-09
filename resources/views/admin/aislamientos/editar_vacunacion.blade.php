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
             {!! Form::model($paciente, ['route' => ['esavis.update_vacunacion_esavi', $paciente->id], 'method' => 'patch','id'=>'frm_aislamientos','name'=>'frm_aislamientos']) !!}
              <h2 class="page-header">
                  <i class="fa fa-globe"></i> REGISTRO DE VACUNA
              </h2>
                <div class="box box-success">
                  <div class="box-body">
                      <div class="row col-sm-12">
                          <div class="table-responsive" >
                              @if($count_esavi_vacunas!=0)
                                  <?php $x=1;?>
                                  <table class="table table-bordered table-striped" id="ejemplo1" cellspacing="0" width="100%" style="margin-top:5px;">
                                      <thead>
                                          <tr>
                                              <th>#</th>
                                              <th>Nombre de Vacuna</th>
                                              <th>Adyuv</th>
                                              <th>Dosis</th>
                                              <th>Via</th>
                                              <th>Sitio</th>
                                              <th>Fecha de Vacunacion</th>
                                              <th>EESS que vacunó</th>            
                                              <th>Fabricante</th>
                                              <th>Lote</th>  
                                              <th>Fecha de expiración</th>
                                          </tr>
                                      </thead>
                                      <tfoot>
                                      </tfoot>
                                      <tbody>
                                          <?php foreach($esavi_vacunas as $row):?>
                                          <tr>
                                              <td><?php echo $x++?></td>
                                              <td><?php echo $row->nombre_vacuna?></td>
                                              <td><?php echo $row->adyuvante?></td>                            
                                              <td><?php echo $row->dosis?></td>
                                              <td><?php echo $row->via?></td>
                                              <td><?php echo $row->sitio?></td>
                                              <td><?php echo $row->fecha_vacunacion?></td>
                                              <td><?php echo $row->nombre_ipress?></td>
                                              <td><?php echo $row->fabricante?></td>
                                              <td><?php echo $row->lote?></td>
                                              <td><?php echo $row->fecha_expiracion?></td>
                                          </tr>
                                          <?php endforeach;?>
                                      </tbody>
                                  </table>
                              @endif
                          </div>        
                      </div>
                      <div class="row col-sm-12">
                          <div class="table-responsive" >
                          <br />
                          <table class="table table-bordered table-striped" id="ejemplo1" cellspacing="0" width="100%" style="margin-top:5px;">
                                      <tbody>
                                          <tr>
                                                <td><b>Nombre de Vacuna</b></td>
                                                <td><b>Adyuvante</b></td>
                                                <td><b>Dosis</b></td>
                                                <td><b>Via</b></td>
                                                <td><b>Sitio</b></td>
                                            </tr>
                                          <tr>
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="vacunas" id="vacunas">
                                                    <option value="">- Seleccione -</option>
                                                    @foreach($vacunas as $vac)
                                                        <option value="{{$vac->descripcion}}">{{$vac->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="adyuvante" id="adyuvante">
                                                    <option value="">- Seleccione -</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                                </select>  
                                              </td>                            
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="dosis" id="dosis">
                                                    <option value="">- Seleccione -</option>
                                                    @foreach($dosis as $dosi)
                                                        <option value="{{$dosi->descripcion}}">{{$dosi->descripcion}}</option>
                                                    @endforeach
                                                </select>    
                                              </td>
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="vias" id="vias">
                                                    <option value="">- Seleccione -</option>
                                                    @foreach($vias as $via)
                                                        <option value="{{$via->descripcion}}">{{$via->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="sitios" id="sitios">
                                                    <option value="">- Seleccione -</option>
                                                    @foreach($sitios as $sitio)
                                                        <option value="{{$sitio->descripcion}}">{{$sitio->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><b>Fecha de Vacunacion</b></td>
                                              <td><b>EESS que vacunó</b></td>            
                                              <td><b>Fabricante</b></td>
                                              <td><b>Lote</b></td>  
                                              <td><b>Fecha de expiración</b></td>
                                          </tr>
                                          <tr>
                                              <td>
                                                <input type="date" tabindex="3"  required="" name="fecha_vacunacion" id="fecha_vacunacion" class="form-control" value="<?php echo $fechaServidor; ?>">
                                              </td>
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="establecimiento_salud" id="establecimiento_salud">
                                                    <option value="">- Seleccione -</option>
                                                    @foreach($establecimiento_salud as $establecimiento)
                                                        <option value="{{$establecimiento->nombre_establecimiento_salud}}">{{$establecimiento->nombre_establecimiento_salud}}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="fabricantes" id="fabricantes">
                                                    <option value="">- Seleccione -</option>
                                                    @foreach($fabricantes as $fabricante)
                                                        <option value="{{$fabricante->descripcion}}">{{$fabricante->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                              <td>
                                                  <input type="text" tabindex="3"  required="" name="lote" id="lote" class="form-control" >
                                              </td>
                                              <td>
                                                <input type="date" tabindex="3"  required="" name="fecha_expiracion" id="fecha_expiracion" class="form-control" value="<?php echo $fechaServidor; ?>" >
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                          </div>
                      </div>
                  </div>
              </div>  
              <input type="hidden" name="paciente_id" id="paciente_id" value="<?php echo $id?>">
              <input type="hidden" name="dni" id="dni" value="<?php echo $dni?>">
              <input type="hidden" name="id_esavi" id="id_esavi" value="{{$id_esavi}}">
              <div class="box-body">
                  <div class="form-group col-sm-12">
                      {!! Form::submit('Grabar Vacunas', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
                  </div>
              </div>
              {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

