<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Región/Red</th>
                                <th></th>                 
                            </tr>
                            <tr>
                                <td>Código</td>
                                <td>Nombre_Establecimiento</td>
                                <td>Región/Red</td>
                                <td>Operaciones</td>                  
                            </tr>
                        </thead>                
                        <tbody>
                            @foreach($establecimientos as $key => $est)
                                <tr>
                                    <td>{!! $est->cod_ipress !!}</td>
                                    <td>{!! $est->nombre!!}</td>
                                    <td>{!! $est->descripcion!!}</td>
                                    <td>
                                        {!! Form::open(['route' => ['establecimientos.destroy', $est->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a data-toggle="tooltip" title="Ver Establecimiento!"  href="{!! route('establecimientos.show', [$est->id]) !!}" class='btn btn-info btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                        <a data-toggle="tooltip" title="Editar Establecimiento!" href="{!! route('establecimientos.edit', [$est->id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar?')"]) !!}
                                    </div>
                                    {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                    
                    </table>
                </div>
            </div>            
        </div>        
    </div>    
</div>