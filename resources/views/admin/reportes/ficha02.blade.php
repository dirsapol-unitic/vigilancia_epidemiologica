<div class="row form-group col-sm-12">
    <div class="form-group col-sm-1">
        <div class="box-body">
            <div class="form-group col-sm-12">
                <a href="{!! route('aislamientosite.index') !!}" class="btn btn-info">Cancelar</a><br/>
                <a href="{!! route('aislamientosite.index') !!}" class="btn btn-danger">Cancelar</a><br/>
                <a href="{!! route('aislamientosite.index') !!}" class="btn btn-warning">Cancelar</a>
            </div>
        </div>    
    </div>
    <div class="form-group col-sm-11">
        <div class="panel panel-primary filterable" >
            <div class="panel-heading">
                <h3 class="panel-title">PACIENTE COVID-19</h3>
            </div> 
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label>DNI:</label> <br/>
                            <input type="text" readonly="" tabindex="1" name="dni" id="dni" class="form-control" value="<?php echo $dni?>">
                            <input type="hidden" name="id_paciente" id="id_paciente" value="<?php echo $id ?>">
                        </div>
                        <div class="form-group col-sm-8">
                            <label>Nombre:</label> <br/>
                            <input type="text" readonly="" tabindex="1" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre_paciente?>">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Fecha de Registro:</label><br/>
                            <input readonly type="date" tabindex="2"  required="" name="fecha_registro_hospitalizacion" id="fecha_registro_hospitalizacion" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="panel panel-primary filterable" >
            <div class="panel-heading">
                <h3 class="panel-title">HOSPITALIZACION (si fue hospitalizado, complete la siguiente informacion)</h3>
            </div> 
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row col-sm-12">
                        <div class="form-group col-sm-4">
                            <label>IPRESS de donde Proviene:</label><br/>
                            <select class="form-control select2" tabindex="4" required="" name="establecimiento" id="establecimiento">
                            <option value="">- Seleccione -</option>
                            @foreach($establecimientos as $dep)
                            <option value="{{$dep->id}}">{{$dep->nombre}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Fecha  de Hospitalizacion</label><br/>
                            <input type="date" tabindex="3"  required="" name="fecha_hospitalizacion" id="fecha_hospitalizacion" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Nombre del Hospital:</label><br/>
                            <select class="form-control select2" tabindex="4" required="" name="establecimiento_salud" id="establecimiento_salud">
                            <option value="">- Seleccione -</option>
                            @foreach($establecimiento_salud as $dep)
                            <option value="{{$dep->id}}">{{$dep->nombre_establecimiento_salud}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Tipo de Nombre Seguro:</label><br/>
                            <select class="form-control select2" tabindex="11" required="" name="tipo_seguro" id="tipo_seguro">
                                        <option value="0">- Seleccione -</option>
                                        <option value="1">Saludpol</option>
                                        <option value="2">Essalud</option>
                                </select>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="form-group col-sm-12">
                            <label>Ingresar diagnostico:</label><br/>
                            <div class="panel-body">
                                <table>
                                    <tr>
                                        <td>
                                            <button type="button" id="addDiagnostico" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Agregar Diagnostico</button>
                                        </td>
                                    </tr>

                                </table>
                                <br />
                                <table class="display" id="tblDiagnostico" cellspacing="0" width="100%" style="margin-top:5px;">
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
                    <div class="row col-sm-12">
                        <div class="form-group col-sm-4">
                            <br/>
                            <label>Signos</label> 
                            <br/>                
                            <table><?php $x=1; ?>
                                @foreach($signos as $id => $signo)
                                    <tr>
                                        <td>
                                            <input 
                                            type="checkbox" 
                                            value="{{ $signo->id }}" 
                                            
                                            {{ $aislamientos->signoaislados->pluck('id')->contains($signo->id) ? 'checked' : '' }}
                                            name="signos_hospitalizacion[]">
                                        </td>
                                        <td>&nbsp;{{ $signo->descripcion }}</td>                            
                                    </tr>
                                @endforeach
                            </table>
                            <label>Otro, especificar:</label><br/>
                            <input type="text" tabindex="7" name="otro_signo_ho" id="otro_signo_ho" class="form-control">
                        </div>
                        <div class="form-group col-sm-4">
                            <label>servicio de Hospitalizacion</label> <br/>
                            <select class="form-control select2" tabindex="8" required="" name="servicio_hospitalizacion" id="servicio_hospitalizacion">
                                    <option value="0">- Seleccione -</option>
                                    <option value="1">Sala de asilamiento</option>
                                    <option value="2">UCI</option>
                                    <option value="3">Otro</option>
                            </select><br/><br/>
                            <label>El caso esta o estuvo intubado en algun momento durante la enfermedad? </label> <br/>
                            <select class="form-control select2" tabindex="9" required="" name="intubado" id="intubado">
                                    <option value="0">- Seleccione -</option>
                                    @foreach($sinos as $si)
                                    <option value="{{$si->id}}">{{$si->descripcion}}</option>
                                    @endforeach
                                </select>
                            <br/><br/>
                            <label>Estuvo en UCI, UVI, Shock Trauma? </label> <br/>
                            <select class="form-control select2" tabindex="9" required="" name="estuvo" id="estuvo">
                                    <option value="0">- Seleccione -</option>
                                    @foreach($sinos as $si)
                                    <option value="{{$si->id}}">{{$si->descripcion}}</option>
                                    @endforeach
                                </select>
                                
                            
                        </div>
                        <div class="form-group col-sm-4">
                            <label>El paciente estuvo en ventilacion mecanica</label> <br/>
                            <select class="form-control select2" tabindex="10" required="" name="ventilacion_mecanica" id="ventilacion_mecanica">
                                    <option value="0">- Seleccione -</option>
                                    @foreach($sinos as $si)
                                    <option value="{{$si->id}}">{{$si->descripcion}}</option>
                                    @endforeach
                                    <option value="3">Desconocido</option>
                            </select><br/><br/>
                            
                                <label>El caso tiene o tuvo diasgnotico de nueumonia durante la enfermedad?</label> <br/>
                                <select class="form-control select2" tabindex="11" required="" name="diag_neumonia" id="diag_neumonia">
                                        <option value="0">- Seleccione -</option>
                                        @foreach($sinos as $si)
                                        <option value="{{$si->id}}">{{$si->descripcion}}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group col-sm-12">
                {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
                <a href="{!! route('aislamientosite.index') !!}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </div>
</div>

