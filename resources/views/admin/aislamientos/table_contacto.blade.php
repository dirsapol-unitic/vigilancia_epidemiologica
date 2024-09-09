<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-body">
                <?php $x=1; ?>
                <table class="display" id="tblHospitalizaciones" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                        <tr>
                            <th width="10%">Fecha Registro</th>
                            <th width="10%">DNI</th>
                            <th width="40%">Nombre</th>
                            <th width="10%">Fecha Nacimiento</th>
                            <th width="20%">Tipo Contacto</th>
                            <th width="10%">Editar</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                        <?php foreach($contactos as $row):?>
                        <tr>
                            <td><?php echo $row->fecha_registro?></td>
                            <td><?php echo $row->dni_contacto?></td>
                            <td><?php echo $row->nombres_contacto.', '.$row->paterno_contacto.' '.$row->materno_contacto; ?></td>
                            <td><?php echo $row->fecha_nacimiento_contacto?></td>
                            <?php switch ($row->tipo_contacto) {
                                case '1': $tipo_contacto='Familiar';break;
                                case '2': $tipo_contacto='Centro Laboral';break;
                                case '3': $tipo_contacto='Centro de Estudio';break;
                                case '4': $tipo_contacto='EESS';break;
                                case '5': $tipo_contacto='Evento Social ';break;
                                case '6': $tipo_contacto='Atención medica domiciliaria ';break;
                                case '7': $tipo_contacto='Otro';break;
                            } ?>
                            <td><?php echo $tipo_contacto?></td>
                            <td><a href="{!! route('aislamientos.editar_contacto', [$row->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>            
        </div>        
    </div>    
</div>