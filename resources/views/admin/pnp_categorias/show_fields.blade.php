<!-- Nombre Dpto Field -->
<div class="form-group">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{!! $pnp_categoria->nombre_dpto !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado:') !!}
    <p>{!! $pnp_categoria->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Modificado:') !!}
    <p>{!! $pnp_categoria->updated_at !!}</p>
</div>

