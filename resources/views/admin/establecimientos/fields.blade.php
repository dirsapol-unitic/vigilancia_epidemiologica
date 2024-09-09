<!-- Codigo Field -->
<div class="form-group col-sm-2">
    {!! Form::label('codigo_establecimiento', 'Código:') !!}
    {!! Form::text('codigo_eess', null, ['class' => 'form-control']) !!}
</div>
<!-- Codigo Field -->
<div class="form-group col-sm-2">
    {!! Form::label('codigo_ipress', 'Código:') !!}
    {!! Form::text('cod_ipress', null, ['class' => 'form-control']) !!}
</div>
<!-- Nombre Establecimiento Field -->
<div class="form-group col-sm-8">
    {!! Form::label('nombre_establecimiento', 'Nombre Establecimiento:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>
<!-- Region Red Field -->
<div class="form-group col-sm-4">
    {!! Form::label('region_red', 'Región/Red:') !!}
    <select class="form-control select2" tabindex="9" required="" name="region" id="region">
        <option value="0">- Seleccione -</option>
        @foreach($region as $reg)
        <option value="{{$reg->id}}" <?php if($reg->id==$id_region) echo 'selected'; ?>>{{$reg->descripcion}}</option>
        @endforeach
    </select>
    <br/>
</div>
<!-- Region Nivel Field -->
<div class="form-group col-sm-4">
    {!! Form::label('nivel', 'Nivel :') !!}
    <select class="form-control select2" tabindex="9" required="" name="nivel" id="nivel">
        <option value="0">- Seleccione -</option>
        @foreach($nivel as $niv)
        <option value="{{$niv->id}}"<?php if($niv->id==$id_nivel) echo 'selected'; ?>>{{$niv->descripcion}}</option>
        @endforeach
    </select>
    <br/>
</div>
<!-- Categoria Field -->
<div class="form-group col-sm-4">
    {!! Form::label('categoria', 'Categoría:') !!}
    <select class="form-control select2" tabindex="9" required="" name="categoria" id="categoria">
        <option value="0">- Seleccione -</option>
        @foreach($categoria as $cat)
        <option value="{{$cat->id}}"  <?php if($cat->id==$id_categoria) echo 'selected'; ?>>{{$cat->descripcion}}</option>
        @endforeach
    </select>
    <br/>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('id_departamento', 'Departamento:') !!}
    <?php ?>
    <select class="form-control select2" tabindex="9" required="" name="departamento" id="departamento">
        <option value="0">- Seleccione -</option>        
            @foreach($departamentos as $dep)
                <option value="{{$dep->id}}"<?php if($dep->id==$id_departamento) echo 'selected'; ?>>{{$dep->nombre}}</option>
            @endforeach
        
    </select>
    <br/>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('id_provincia', 'Provincia:') !!}
    <select class="form-control select2" tabindex="10" required="" name="provincia" id="provincia">
        <option value="0">- Seleccione -</option>
    </select>
    <br/>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('id_distrito', 'Distrito:') !!}
    <select class="form-control select2" tabindex="11" required="" name="distrito" id="distrito">
        <option value="0">- Seleccione -</option>
    </select>
    <br/>
</div>
<!-- Disa Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ubigeo', 'UBIGEO:') !!}
    {!! Form::text('ubigeo', null, ['class' => 'form-control']) !!}
</div>

<!-- Disa Field -->
<div class="form-group col-sm-3">
    {!! Form::label('disa', 'DISA:') !!}
    {!! Form::text('disa', null, ['class' => 'form-control']) !!}
</div>
        
<!-- Disa Field -->
<div class="form-group col-sm-3">
    {!! Form::label('coddisa', 'CODDISA:') !!}
    {!! Form::text('coddisa', null, ['class' => 'form-control']) !!}
</div>

<!-- Norte Field -->
<div class="form-group col-sm-3">
    {!! Form::label('norte', 'Norte:') !!}
    {!! Form::text('norte', null, ['class' => 'form-control']) !!}
</div>

<!-- Este Field -->
<div class="form-group col-sm-3">
    {!! Form::label('este', 'Este:') !!}
    {!! Form::text('este', null, ['class' => 'form-control']) !!}
</div>

<!-- Tipo Ipress Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cota', 'Cota:') !!}
    {!! Form::text('cota', null, ['class' => 'form-control']) !!}
</div>

<!-- Tipo Internamiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
    <a href="{!! route('establecimientos.index') !!}" class="btn btn-danger">Cancelar</a>
</div>
