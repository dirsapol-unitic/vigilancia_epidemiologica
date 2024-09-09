<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-body">
                <?php $x=1; ?>
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha Registro</th>
                            <th>Clasificacion</th>
                            <th>Establecimiento</th>
                            <th><p align="center">Editar/Eliminar</p></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($antecedentes as $ant)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{!! $ant->fecha_registro !!}</td>
                            <td><?php 
                                    switch($ant->id_clasificacion){
                                        case '1': echo 'Confirmado'; break;
                                        case '2': echo 'Probable'; break;
                                        case '3': echo 'Sospechoso'; break;
                                        case '4': echo 'Sin Registro'; break;
                                            
                                    }
                                    ?></td>
                            <td>{!! $ant->nombre !!}</td> 
                            <td><a href="{!! route('aislamientos.editar_antecedente', [$ant->id,$dni]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>            
        </div>        
    </div>    
</div>