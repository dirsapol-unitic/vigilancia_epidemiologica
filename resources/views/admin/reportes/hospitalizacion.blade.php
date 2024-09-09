<div class="box box-primary">
    <div class="box-body">
        <div class="row col-sm-12">
            <div class="form-group col-sm-8">
                <label>IPRESS de donde Proviene:</label><br/>
                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="establecimiento" id="establecimiento">
                    <option value="">- Seleccione -</option>
                    @foreach($establecimientos as $dep)
                    <option value="{{$dep->id}}" <?php if($establecimiento_proviene == $dep->id)echo "selected='selected'";?> >{{$dep->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label>Fecha  de Hospitalizacion</label><br/>
                <input type="date" tabindex="3"  required="" name="fecha_hospitalizacion" id="fecha_hospitalizacion" class="form-control" value="<?php echo $fecha_hospitalizacion; ?>" >
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-8">
                <label>Nombre del Hospital:</label><br/>
                <select class="form-control select2" style="width: 100%" tabindex="4" required="" name="establecimiento_salud" id="establecimiento_salud">
                    <option value="">- Seleccione -</option>
                    @foreach($establecimiento_salud as $dep)
                    <option value="{{$dep->id}}" <?php if($establecimiento_actual == $dep->id)echo "selected='selected'";?> >{{$dep->nombre_establecimiento_salud}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label>Tipo de Nombre Seguro:</label><br/>
                <select class="form-control select2" tabindex="11" style="width: 100%" required="" name="tipo_seguro" id="tipo_seguro">
                    <option value="">- Seleccione -</option>
                    <option value="1" <?php if($tipo_seguro == 1)echo "selected='selected'";?>>Saludpol</option>
                    <option value="2" <?php if($tipo_seguro == 2)echo "selected='selected'";?>>Essalud</option>
                </select>
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-12">
                <label>Diagnosticos:</label><br/>
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
            <div class="form-group col-sm-12">   
                
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
                                {{ $pac_hospitalizado->signohospitalizados->pluck('id')->contains($signo->id) ? 'checked' : '' }}
                                name="signos_hospitalizacion[]">
                            </td>
                            <td>&nbsp;{{ $signo->descripcion }}</td>                            
                        </tr>
                    @endforeach
                </table>
                <label>Otro, especificar:</label><br/>
                <input type="text" tabindex="7" name="otro_signo_ho" value="<?php echo $otro_signo_ho; ?>" id="otro_signo_ho" class="form-control">
            </div>
            <div class="form-group col-sm-4">
                <label>servicio de Hospitalizacion</label> <br/>
                <select class="form-control select2" tabindex="8" required="" style="width: 100%" name="servicio_hospitalizacion" id="servicio_hospitalizacion">
                    <option value="">- Seleccione -</option>
                    <option value="1" <?php if($servicio_hospitalizacion == 1)echo "selected='selected'";?>>Sala de asilamiento</option>
                    <option value="2" <?php if($servicio_hospitalizacion == 2)echo "selected='selected'";?>>UCI</option>
                    <option value="3" <?php if($servicio_hospitalizacion == 3)echo "selected='selected'";?>>Otro</option>
                </select><br/><br/>
                <label>El caso esta o estuvo intubado en algun momento durante la enfermedad? </label> <br/>
                <select class="form-control select2" tabindex="9" required="" style="width: 100%" name="intubado" id="intubado">
                    <option value="">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}" <?php if($intubado == $si->id)echo "selected='selected'";?> >{{$si->descripcion}}</option>
                    @endforeach
                    </select>
                <br/><br/>
                <label>Estuvo en UCI, UVI, Shock Trauma? </label> <br/>
                <select class="form-control select2" tabindex="9" required="" style="width: 100%" name="uci" id="uci">
                    <option value="">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}" <?php if($uci == $si->id)echo "selected='selected'";?>>{{$si->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label>El paciente estuvo en ventilacion mecanica</label> <br/>
                <select class="form-control select2" tabindex="10" required="" style="width: 100%" name="ventilacion_mecanica" id="ventilacion_mecanica">
                    <option value="">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}" <?php if($ventilacion_mecanica == $si->id)echo "selected='selected'";?>>{{$si->descripcion}}</option>
                    @endforeach
                    <option value="3" <?php if($ventilacion_mecanica == 3)echo "selected='selected'";?>>Desconocido</option>
                </select><br/><br/>
                <label>El caso tiene o tuvo diasgnotico de nueumonia durante la enfermedad?</label> <br/>
                <select class="form-control select2" tabindex="11" required="" style="width: 100%" name="neumonia" id="neumonia">
                    <option value="">- Seleccione -</option>
                    @foreach($sinos as $si)
                    <option value="{{$si->id}}" <?php if($neumonia == $si->id)echo "selected='selected'";?>>{{$si->descripcion}}</option>
                    @endforeach
                </select>
                <input type="hidden" name="dni_hospitalizacion" id="dni_hospitalizacion" value="<?php echo $paciente->dni?>">
                <input type="hidden" name="id_paciente_hospitalizacion" id="id_paciente_hospitalizacion" value="<?php echo $paciente->id?>">
                <input type="hidden" name="id_hospitalizacion" id="id_hospitalizacion" value="<?php echo $id_hospitalizacion?>">
                <input type="hidden" name="opcion" id="opcion" value="hospitalizacion">
            </div>
        </div>
    </div>
</div>
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
    </div>
</div>

