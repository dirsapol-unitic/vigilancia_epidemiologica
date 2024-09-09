<!-- Nombre Prov Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion_label', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>
<input type="hidden" name="id_pregunta" id="id_pregunta" value="<?php echo $respuesta->pregunta_id?>">
<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" value="Guardar" class="btn btn-success">Guardar <i class="fa fa-save"></i></button>
    <a href="{!! route('preguntas.create_rpta',[$respuesta->pregunta_id]) !!}" class="btn btn-danger">Cancelar <i class="glyphicon glyphicon-remove"></i></a>
</div>
