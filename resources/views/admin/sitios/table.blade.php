<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripcion</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sitios as $key => $sitio)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{!! $sitio->descripcion !!}</td>
                            <td>
                                {!! Form::open(['route' => ['sitios.destroy', $sitio->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{!! route('sitios.edit', [$sitio->id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>               
                            <th>Descripcion</th>
                            <th>Operaciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>            
        </div>        
    </div>    
</div>
