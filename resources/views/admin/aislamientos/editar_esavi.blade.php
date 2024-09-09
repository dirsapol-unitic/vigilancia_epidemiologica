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
            {!! Form::model($esavis, ['route' => ['esavis.update_esavis', $esavis->id], 'method' => 'patch','id'=>'frm_aislamientos','name'=>'frm_aislamientos']) !!}
              <h2 class="page-header">
                  <i class="fa fa-globe"></i> EDITAR ESAVI
              </h2>
                <div class="box box-primary">
                  <div class="box-body">
                    <div class="row col-sm-12">
                      <div class="row col-sm-12">
                        <div class="form-group col-sm-3">
                          <label>ESAVI:</label><br/>
                          <select class="form-control select2" tabindex="1" required="" name="tipo_esavi" id="tipo_esavi">
                              <option value="0">- Seleccione -</option>
                              <option value="1" <?php if($esavis->tipo_esavi==1) echo 'selected'; ?>> Severo </option>
                              <option value="2" <?php if($esavis->tipo_esavi==2) echo 'selected'; ?>> Leve-Moderado </option>
                          </select>
                        </div>
                        <div class="form-group col-sm-3">
                          <label>ESAVI previo:</label><br/>
                          <select class="form-control select2" tabindex="1" required="" name="esavi_previo" id="esavi_previo" onchange="getEsaviPrevio2();" >
                              <option value="0">- Seleccione -</option>
                              <option value="1" <?php if($esavis->esavi_previo==1) echo 'selected'; ?>> SI </option>
                              <option value="2" <?php if($esavis->esavi_previo==2) echo 'selected'; ?>> NO </option>
                          </select>
                          @if($esavis->esavi_previo==1)
                          <div id="divesaviprevio2"><br/>
                          @else
                          <div id="divesaviprevio"><br/>
                          @endif
                            <table><?php $x=1; ?>
                              @foreach($esavi_previos as $id => $previo)
                              <tr>
                                <td>
                                    <input 
                                    type="checkbox" 
                                    value="{{ $previo->id }}"
                                    {{ $esavis->previoesavis->pluck('id')->contains($previo->id) ? 'checked' : '' }}
                                    name="previos[]">
                                </td>
                                <td>&nbsp;{{ $previo->descripcion }}</td>
                              </tr>
                              @endforeach
                            </table>
                            <label>Otro:</label><br/>
                            <input type="text" tabindex="43" name="otro_esavi_previo" id="otro_esavi_previo" value="<?php echo $esavis->otro_esavi_previo?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Fecha  de Notificacion</label><br/>
                            <input type="date" tabindex="26"  name="fecha_notificacion" id="fecha_notificacion" class="form-control" value="<?php echo date("Y-m-d", strtotime($esavis->fecha_notificacion)); ?>" >
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Fecha  de registro</label><br/>
                            <input type="date" readonly="" tabindex="27"  name="fecha_registro" id="fecha_registro" class="form-control" value="<?php echo date("Y-m-d", strtotime($esavis->fecha_registro)); ?>" >
                        </div>
                      </div>
                    </div>
                    <!-- /.box-col -->
                    <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id_paciente}}">
                    
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box-primary -->
              
              <!-- /.box-panel -->
              <div class="box-body">
                <div class="form-group col-sm-12">
                  {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
                    <a href="{!! route('esavis.listar_esavis',[$id_paciente, $dni]) !!}" class="btn btn-danger">Cancelar</a>
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
