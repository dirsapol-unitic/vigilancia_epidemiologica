<div class="box box-success">
    <div class="box-body">
        <div class="row col-sm-12">
            <label>Examenes de Laboratorio:</label><br/>
            @if($count_laboratorio!=0)
                <table class="display" id="tblDiagnosticos" cellspacing="0" width="100%" style="margin-top:5px;">
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
                        <?php foreach($laboratorio as $row):
                            $muestra = "";
                            if($row->tipo_muestra==1)$muestra = "Hisopado Nasofaringeo";
                            if($row->tipo_muestra==2)$muestra = "Hisopado Orofaringeo";
                            if($row->tipo_muestra==3)$muestra = "Tractorespiratorio";

                            $prueba = "";
                            if($row->tipo_prueba==1)$prueba = "Prueba Molecular";
                            if($row->tipo_prueba==2)$prueba = "Prueba Antigena";
                            if($row->tipo_prueba==3)$prueba = "Prueba Serologica";
                            if($row->tipo_prueba==4)$prueba = "Prueba Radiografico";
                            if($row->tipo_prueba==5)$prueba = "Prueba Tomografica";
                            if($row->tipo_prueba==6)$prueba = "Prueba Rapida";
                            if($row->tipo_prueba==7)$prueba = "Sin Informacion";

                            $resultado = "";
                            if($row->resultado_muestra==1)$resultado = "Positivo";
                            if($row->resultado_muestra==2)$resultado = "Negativo";

                            $minsa = "";
                            if($row->enviado_minsa==1)$minsa = "SI";
                            if($row->enviado_minsa==2)$minsa = "NO";
                        ?>
                        <tr>
                            <td><?php echo $row->fecha_muestra?></td>
                            <td><?php echo $muestra?></td>
                            <td><?php echo $prueba?></td>                            
                            <td><?php echo $resultado?></td>
                            <td><?php echo $row->fecha_resultado?></td>
                            <td><?php echo $minsa?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="row col-sm-12">
            <br/><br/>
            <table>
                <tr>
                    <td>
                        <button type="button" id="addExamenLaboratorio" class="btn btn-success" data-toggle="modal" data-target="#addClassModal">Agregar Examen</button>
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

            <input type="hidden" name="id_paciente_lab" id="id_paciente_lab" value="<?php echo $id_paciente_lab?>">
            <input type="hidden" name="dni_lab" id="dni_lab" value="<?php echo $dni?>">
            <input type="hidden" name="opcion" id="opcion" value="laboratorio">
        </div>
    </div>
</div>  
<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Grabar Examenes', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
    </div>
</div>