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
            {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'esavis.store_seguimiento_esavi']) !!}
              <h2 class="page-header">
                <i class="fa fa-globe"></i> SEGUIMIENTO DEL PACIENTE/ CLASIFICACION FINAL
              </h2>
              <div class="box box-primary">
                <div class="box-body">
                  <div class="row col-sm-12">
                    <div class="row col-sm-6">
                        <br/>
                        <label>SEGUIMIENTO DEL PACIENTE</label> 
                        <br/>                
                        <table><?php $x=1; ?>
                          @foreach($seguimientos as $idf => $seguimiento)
                          <tr>
                            <td>
                              <input type="checkbox" value="{{ $seguimiento->id }}" {{ $esavis->seguimientoesavis->pluck('id')->contains($seguimiento->id) ? 'checked' : '' }} name="seguimientos[]">
                            </td>
                            <td>&nbsp;{{ $seguimiento->descripcion }}</td>
                          </tr>
                          @endforeach
                        </table>
                        <br/>
                    </div>
                  </div>
                  <div class="row col-sm-12">
                    <div class="row col-sm-6">
                      <br/>
                      <label>CLASIFICACION FINAL</label> 
                      <br/>                
                      <table><?php $x=1; ?>
                        @foreach($clasificaciones as $idf => $clasificacion)
                        <tr>
                          <td>
                            <input type="checkbox" value="{{ $clasificacion->id }}" {{ $esavis->clasificacionesavis->pluck('id')->contains($clasificacion->id) ? 'checked' : '' }} name="clasificaciones[]">
                          </td>
                          <td>&nbsp;{{ $clasificacion->descripcion }}</td>
                        </tr>
                        @endforeach
                      </table>
                      <br/>
                    </div>
                  </div>
                  <input type="hidden" name="dni" id="dni" value="{{$dni}}">
                  <input type="hidden" name="id_paciente" id="id_paciente" value="{{$id}}">
                  <input type="hidden" name="id_esavi" id="id_esavi" value="{{$id_esavi}}">
                </div>
              </div>
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

