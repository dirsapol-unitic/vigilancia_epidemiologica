<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">PACIENTE COVID-19</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-sm-2">
                    <label>DNI:</label> <br/>
                    <input type="text" readonly="" tabindex="1" name="dni" id="dni" class="form-control" value="<?php echo $dni?>">
                    <input type="hidden" name="id_paciente" id="id_paciente" value="<?php echo $id ?>">
                </div>
                <div class="form-group col-sm-8">
                    <label>Nombre:</label> <br/>
                    <input type="text" readonly="" tabindex="1" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre_paciente?>">
                </div>
                <div class="form-group col-sm-2">
                    <label>Fecha de Registro:</label><br/>
                    <input readonly type="date" tabindex="2"  required="" name="fecha_registro_evolucion" id="fecha_registro_evolucion" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
            </div>
        </div>
    </div>  
</div>

<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">LABORATORIO</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>Fecha  de muestra</label><br/>
                    <input type="date" tabindex="20"  required="" name="fecha_muestra" id="fecha_muestra" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-2">
                <label>Tipo de muestra</label> <br/>
                    <select class="form-control select2" tabindex="19" required="" name="tipo_muestra" id="tipo_muestra">
                            <option value="0">- Seleccione -</option>
                            <option value="1">Hisopado Nasofaringeo </option>
                            <option value="2">Hisopado Orofaringeo</option>
                            <option value="3">Tractorespiratorio</option>
                    </select><br/><br/>
                </div>
                <div class="form-group col-sm-2">
                    <label>Tipo de Prueba:</label><br/>
                    <select class="form-control select2" tabindex="9" required="" name="id_prueba" id="id_prueba">
                        <option value="0">- Seleccione -</option>
                        <option value="1">Prueba Molecular</option>
                        <option value="2">Prueba Antigena</option>
                        <option value="3">Prueba Serologica</option>
                        <option value="4">Prueba Radiografico</option>
                        <option value="5">Prueba Tomografica</option>
                        <option value="6">Sin Informacion</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Resultado:</label><br/>
                    <select class="form-control select2" tabindex="9" required="" name="id_resultado" id="id_resultado">
                        <option value="0">- Seleccione -</option>
                        <option value="1">Positivo</option>
                        <option value="2">Negativo</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Fecha  de resultado</label><br/>
                    <input type="date" tabindex="20"  required="" name="fecha_resultado" id="fecha_resultado" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
                <div class="form-group col-sm-2">
                    <label>Enviado MINSA:</label><br/>
                    <select class="form-control select2" tabindex="9" required="" name="id_resultado" id="id_resultado">
                        <option value="0">- Seleccione -</option>
                        <option value="1">SI</option>
                        <option value="2">NO</option>
                    </select>
                </div>
            </div>
        </div>
    </div>  
</div>  

 

<div class="box-body">
    <div class="form-group col-sm-12">
        {!! Form::submit('Continuar', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('aislamientosite.index') !!}" class="btn btn-danger">Cancelar</a>
    </div>
</div>