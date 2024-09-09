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
                            <th>Pregunta</th>
                            <th>Operaciones</th>
                            <th>Registrar Rpta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preguntas as $key => $pregunta)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{!! $pregunta->pregunta !!}?</td>
                                <td>
                                    {!! Form::open(['route' => ['preguntas.destroy', $pregunta->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{!! route('preguntas.edit', [$pregunta->id]) !!}" class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar?')"]) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                                <td>
                                    <div class='btn-group'>
                                        <a href="{!! route('preguntas.create_rpta', [$pregunta->id]) !!}" class='btn btn-warning btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>   
                            <th>#</th>               
                            <th>Pregunta</th>
                            <th>Operaciones</th>
                            <th>Registrar Rpta</th>
                        </tr>
                    </tfoot>
                </table>
            </div>            
        </div>        
    </div>    
</div>
