<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-body">
                <?php $x=1; ?>
                <table class="display" id="tblHospitalizaciones" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                        <tr>
                            <th width="10%">Fecha Registro</th>
                            <th width="30%">Evolucion</th>
                            <th width="30%">Fecha Alta</th>
                            <th width="30%">Fecha Defuncion</th>
                            <th width="10%">Editar</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                        <?php foreach($evoluciones as $row):?>
                        <tr>
                            <td><?php echo $row->fecha_registro?></td>
                            <?php switch ($row->evolucion) {
                                case '1': $evolucion='Favorable';break;
                                case '2': $evolucion='Desfavorable';break;
                                case '3': $evolucion='Fallecio';break;
                                case '4': $evolucion='Alta';break;
                            } ?>
                            <td><?php echo $evolucion?></td>
                            <td><?php 
                                if (is_null($row->fecha_alta))
                                    echo 'sin registro';
                                else{
                                    echo  $row->fecha_alta;
                                }
                                ?></td>
                            <td>
                                <?php 
                                if (is_null($row->fecha_defuncion))
                                    echo 'sin registro';
                                else{
                                    echo  $row->fecha_defuncion;
                                }
                            ?>      
                            </td>
                            <td></td> 
                            <td><a href="{!! route('aislamientos.editar_evolucion', [$row->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>            
        </div>        
    </div>    
</div>