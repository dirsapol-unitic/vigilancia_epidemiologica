<!-- Nombre Dpto Field -->
<div class="form-group">
    {!! Form::label('descripcion', 'Pregunta:') !!}
    <p>{!! $pregunta->pregunta !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado:') !!}
    <p>{!! $pregunta->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Modificado:') !!}
    <p>{!! $pregunta->updated_at !!}</p>
</div>

