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
    @foreach($informeriesgos as $key => $informeriesgo)
        <tr>
            <td>{{$key+1}}</td>
            <td>{!! $informeriesgo->descripcion !!}</td>
            <td>
                {!! Form::open(['route' => ['informeriesgos.destroy', $informeriesgo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('informeriesgos.edit', [$informeriesgo->id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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
