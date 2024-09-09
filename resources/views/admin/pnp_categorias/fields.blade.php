<!-- Nombre Dpto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion_pnp', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" value="Guardar" class="btn btn-success">Guardar <i class="fa fa-save"></i></button>
    <a href="{!! route('pnpcategorias.index') !!}" class="btn btn-danger">Cancelar <i class="glyphicon glyphicon-remove"></i></a>
</div>
