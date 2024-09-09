<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <p>El presente formulario tiene por finalidad, derivar los datos del paciente al especialista, bajo responsabilidad disciplinaria.</p>
            <br/>
            <div class="panel panel-primary filterable" >
                <div class="panel-heading">
                    <h3 class="panel-title">PERSONAL PNP QUE SE REGISTRO, QUE NO PERTENECE A ESTE FACTOR DE RIESGO</h3>
                </div>  

                <div class="box-body">
                    <div class="row">
                        <br/>            
                        <div class="col-md-2">
                            <label>DNI:</label> 
                        </div>
                        <div class="col-md-4">
                            {{$dni}} 
                        </div>
                        <div class="col-md-2">
                            <label>CIP:</label> 
                        </div>
                        <div class="col-md-4">
                            {{$cip}} 
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Nombres:</label> 
                        </div>
                        <div class="col-md-4">
                            {{$nombres}} 
                            <br/>
                        </div>
                        <div class="col-md-2">
                            <label>Apellido Paterno:</label> 
                        </div>
                        <div class="col-md-4">
                            {{$apellido_paterno}} 
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Apellido Materno:</label> 
                        </div>
                        <div class="col-md-4">
                            {{$apellido_materno}} 
                            <br/>
                        </div>   
                        <div class="col-md-2">
                            <label>Grado:</label> 
                        </div>
                        <div class="col-md-4">
                            {{$grado}} 
                            <br/>
                        </div>         
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <br/>
                            <label>Factor de Riesgo:</label> 
                        </div>
                        <div class="col-md-4">
                            <br/><?php $x=1; ?>
                            @foreach($factorriesgos as $id => $fr)
                                <table>
                                    <tr>
                                        <td>
                                            <input 
                                            type="checkbox" 
                                            value="{{ $fr->id }}" 
                                            
                                            {{ $aislamientos->factoraislados->pluck('id')->contains($fr->id) ? 'checked' : '' }}
                                            name="id_factor[]">
                                        </td>
                                        
                                        <td> &nbsp; {{ $fr->descripcion }}</td>                                        
                                        
                                    </tr>
                                </table>
                            @endforeach
                            <?php 
                                if(Auth::user()->rol==2)
                                    $idRiesgo = Auth::user()->factor_id;
                                else
                                    $idRiesgo = 0;
                            ?>  
                            <br/><br/>
                        </div>                        
                        <br/><br/>
                    </div>    
                    <div class="row">
                        <div class="col-md-12">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>                      
                                        <th>DNI</th>
                                        <th>Medico</th>
                                        <th>Celular</th>
                                        <th>Factor de Riesgo Anterior</th>
                                        <th>Factor de Riesgo Actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($derivados as $key => $file)
                                    <tr>
                                        <td>{{$key+1}}</td>                                            
                                        <td>
                                            {!! $file->dni !!} 
                                        </td>
                                        <td>
                                            {!! $file->nombre_medico !!} 
                                        </td>
                                        <td>
                                            {!! $file->celular !!} 
                                        </td>
                                        <td>
                                            {!! $file->factor_anterior !!} 
                                        </td>
                                        <td>
                                            {!! $file->factor_actual !!} 
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table> 
                        </div>
                    </div>                
                </div>
            </div>
            <div class="box-body">
                <div class="form-group col-sm-12">
                    {!! Form::submit('Actualizar', ['class' => 'btn btn-success']) !!}
                    <a href="{!! route('aislamientos.todos_registros',[$idRiesgo]) !!}" class="btn btn-danger">Cancelar <i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
        </div>       
    </div>
</div>
