
<div class="box box-success">
    <div class="box-body">
        <div class="row col-sm-12">
            <table>
                <tr>
                    <td>
                        <button type="button" id="addExamenLaboratorio" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Agregar Examen</button>
                    </td>
                </tr>
            </table>
            <br />
            <table class="display" id="tblExamenLaboratorio" cellspacing="0" width="100%" style="margin-top:5px;">
                <thead>
                    <tr>
                        <th width="15%">Fecha de muestra</th>
                        <th width="15%">Tipo de muestra</th>
                        <th width="20%">Tipo de Prueba</th>
                        <th width="20%">Resultado</th>
                        <th width="15%">Fecha  de resultado</th>
                        <th width="15%">Enviado MINSA</th>
                    </tr>
                </thead>
                <tfoot>
                </tfoot>
                <tbody>
                </tbody>
            </table>

            <input type="hidden" name="dni_lab" id="dni_lab" value="<?php echo $paciente->dni?>">
            <input type="hidden" name="id_paciente_lab" id="id_paciente_lab" value="<?php echo $paciente->id?>">
            
            <!--div class="form-group col-sm-4">
                <label>Fecha  de muestra</label><br/>
                <input type="date" tabindex="61"  required="" name="fecha_muestra" id="fecha_muestra" class="form-control" value="<?php //echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
            </div>
            <div class="form-group col-sm-4">
            <label>Tipo de muestra</label> <br/>
                <select class="form-control select2" tabindex="62" required="" style="width: 100%" name="tipo_muestra" id="tipo_muestra">
                        <option value="0">- Seleccione -</option>
                        <option value="1">Hisopado Nasofaringeo </option>
                        <option value="2">Hisopado Orofaringeo</option>
                        <option value="3">Tractorespiratorio</option>
                </select><br/><br/>
            </div>
            <div class="form-group col-sm-4">
                <label>Tipo de Prueba:</label><br/>
                <select class="form-control select2" tabindex="63" required="" style="width: 100%" name="tipo_prueba" id="tipo_prueba">
                    <option value="0">- Seleccione -</option>
                    <option value="1">Prueba Molecular</option>
                    <option value="2">Prueba Antigena</option>
                    <option value="3">Prueba Serologica</option>
                    <option value="4">Prueba Radiografico</option>
                    <option value="5">Prueba Tomografica</option>
                    <option value="6">Sin Informacion</option>
                </select>
            </div-->
        </div>
        <!--div class="row col-sm-12">
            <div class="form-group col-sm-4">
                <label>Resultado:</label><br/>
                <select class="form-control select2" tabindex="64" required="" style="width: 100%" name="resultado_muestra" id="resultado_muestra">
                    <option value="0">- Seleccione -</option>
                    <option value="1">Positivo</option>
                    <option value="2">Negativo</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label>Fecha  de resultado</label><br/>
                <input type="date" tabindex="65"  required="" name="fecha_resultado" id="fecha_resultado" class="form-control" value="<?php //echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
            </div>
            <div class="form-group col-sm-4">
                <label>Enviado MINSA:</label><br/>
                <select class="form-control select2" tabindex="66" required="" style="width: 100%" name="enviado_minsa" id="enviado_minsa">
                    <option value="0">- Seleccione -</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
            </div>
        </div-->
    </div>
</div>  
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
    </div>
</div>