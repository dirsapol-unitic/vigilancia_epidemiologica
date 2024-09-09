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
            {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'esavis.store_antecedentes']) !!}
              
                <h2 class="page-header">
                  <i class="fa fa-globe"></i> ANTECEDENTES
                </h2>
                
                <div class="col-md-4">
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">PERSONALES</h3>
                    </div>
                    <div class="box-body">
                      <br/>
                      <label>Condiciones de Comorbilidad o factores de Riesgo</label> 
                      <br/>                
                      <table><?php $x=1; ?>
                        @foreach($factorriesgos as $idf => $friesgo)
                        <tr>
                          <td>
                            <input type="checkbox" value="{{ $friesgo->id }}" {{ $esavis->comorbilidadesavis->pluck('id')->contains($friesgo->id) ? 'checked' : '' }} name="factorriesgos[]">
                          </td>
                          <td>&nbsp;{{ $friesgo->descripcion }}</td>
                        </tr>
                        @endforeach
                      </table>
                      <label>Otro, especificar:</label><br/>
                      <input type="text" tabindex="35" name="otro_factor_riesgo" id="otro_factor_riesgo" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">FAMILIARES</h3>
                    </div>
                    <div class="box-body">
                      <br/>
                      <label>Cuadros Patologicos</label> 
                      <br/>                
                      <table><?php $x=1; ?>
                        @foreach($cuadropatologicos as $idsi => $cuadro)
                        <tr>
                          <td>
                            <input type="checkbox" value="{{ $cuadro->id }}" {{ $esavis->patologicoesavis->pluck('id')->contains($cuadro->id) ? 'checked' : '' }} name="cuadropatologicos[]">
                          </td>
                          <td>&nbsp;{{ $cuadro->descripcion }}</td>                            
                        </tr>
                        @endforeach
                      </table>
                      <label>Otro, especificar:</label><br/>
                      <input type="text" tabindex="34" name="otro_cuadro" id="otro_cuadro" class="form-control">
                    </div>
                  </div>
                </div>
                

                <div class="col-md-4">
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">EPIDEMIOLOGICOS</h3>
                    </div>
                    <div class="box-body">
                      <br/>
                      <label>Enfermedades Prevalentes en la Region</label> 
                      <br/>                
                      <table><?php $x=1; ?>
                        @foreach($enfermedadregiones as $ide => $eregion)
                        <tr>
                          <td>
                            <input type="checkbox" value="{{ $eregion->id }}" {{ $esavis->enfermedadesavis->pluck('id')->contains($eregion->id) ? 'checked' : '' }} name="enfregiones[]">
                          </td>
                          <td>&nbsp;{{ $eregion->descripcion }}</td>
                        </tr>
                        @endforeach
                      </table>
                      <label>Otro, especificar:</label><br/>
                      <input type="text" tabindex="35" name="otro_enfermedad" id="otro_enfermedad" class="form-control">
                    </div>
                  </div>
                </div>
                
              
              <input type="hidden" name="dni" id="dni" value="{{$dni}}">
              <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
              <input type="hidden" name="id_esavi" id="id_esavi" value="{{$id_esavi}}">
              
              <!-- /.box-primary -->
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
                