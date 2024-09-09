<div class="form-group col-sm-10">
    {!! Form::label('descripcion', 'Pregunta:') !!}
    {!! Form::text('pregunta', null, ['class' => 'form-control', 'readonly'=>""]) !!}
</div>
<!-- Nombre Dpto Field -->
<div class="form-group col-sm-10">
    {!! Form::label('descripcion', 'Escribir la Respuesta:') !!}
    {!! Form::text('respuesta', null, ['class' => 'form-control']) !!}
</div>
<input type="hidden" name="id_pregunta" id="id_pregunta" value="<?php echo $pregunta->id?>">
<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" value="Guardar" class="btn btn-success">Guardar <i class="fa fa-save"></i></button>
    <a href="{!! route('preguntas.index') !!}" class="btn btn-danger">Cancelar <i class="glyphicon glyphicon-remove"></i></a>
</div>
