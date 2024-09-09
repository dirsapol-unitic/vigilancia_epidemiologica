<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-body">
                <?php $x=1; ?>
                <table class="display" id="tblHospitalizaciones" cellspacing="0" width="100%" style="margin-top:5px;">
                    <thead>
                        <tr>
                            <th width="10%">Fecha Registro</th>
                            <th width="30%">Ipress Proviene</th>
                            <th width="30%">Hospital Actual</th>
                            <th width="10%">Fecha Hospitalizacion</th>
                            <th width="10%">Editar</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                        <?php foreach($hospitalizaciones as $row):?>
                        <tr>
                            <td><?php echo $row->fecha_registro?></td>
                            <td><?php echo $row->nombre_establecimiento?></td>
                            <td><?php echo $row->nombre_actual?></td>
                            <td><?php echo $row->fecha_hospitalizacion?></td>
                            <td></td> 
                            <td><a href="{!! route('aislamientos.editar_hospitalizacion', [$row->id,$dni, $id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>            
        </div>        
    </div>    
</div>