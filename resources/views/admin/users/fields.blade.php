<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<!-- DNI -->
<div class="form-group col-sm-2">
    {!! Form::label('dni', 'DNI:') !!}    
    {!! Form::text('dni', null, ['id'=>'dni','name'=>'dni','class' => 'form-control','maxlength'=>'8','required'=>'required']) !!}
     
</div>

<!-- NOMBRES -->
<div class="form-group col-sm-4">
    {!! Form::label('nombres', 'Nombres:') !!}
    {!! Form::text('nombres', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- APELLIDO PATERNO -->
<div class="form-group col-sm-3">
    {!! Form::label('apellido_paterno', 'Apellido Paterno:') !!}
    {!! Form::text('apellido_paterno', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- APELLIDO MATERNO -->
<div class="form-group col-sm-3">
    {!! Form::label('apellido_materno', 'Apellido Materno:') !!}
    {!! Form::text('apellido_materno', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- DNI -->
<div class="form-group col-sm-2">
    {!! Form::label('cip', 'CIP:') !!}
    {!! Form::text('cip', null, ['class' => 'form-control','maxlength'=>'8']) !!}
     
</div>

<!-- EMAIL -->
<div class="form-group col-sm-4">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- GRADO -->
<div class="form-group col-sm-3">
    {!! Form::label('grado', 'Grado:') !!}
    {!! Form::text('grado', null, ['class' => 'form-control']) !!}

</div>

<!-- TELEFONO -->
<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control','maxlength'=>'9','required'=>'required']) !!}
</div>

<!-- ESTABLECIMIENTO -->
<div class="form-group col-sm-4">
    {!! Form::label('establecimient', 'Establecimiento:') !!}
    {!! Form::select('establecimiento_id',[''=>'--- Seleccione ---']+$establecimientos,null,['class'=>'form-control select2','id'=>'riesgo_id','required'=>'required']) !!}          
</div>

<!-- CONTRASEÑA -->
@if ($tipo==1)
<div class="form-group col-sm-4">
    {!! Form::label('password', 'Contraseña:') !!}
    {!! Form::password('password',['class' => 'form-control ','required'=>'required']) !!}
</div>
@else
<div class="form-group col-sm-4">
    {!! Form::label('password', 'Contraseña:') !!}
    {!! Form::password('password',['class' => 'form-control']) !!}
</div>
@endif
@if($tipo==2)
<div class="form-group col-sm-4">
    <label class="col-lg-2 control-label">Activo</label><br/>
    <div class="col-lg-1">
        <input type="checkbox" value="1" name="status" <?php if($user->estado == 1)echo 'checked="checked"';?>  />
    </div>
</div>
@endif
<!-- Establecimiento Field -->
<div class="form-group col-sm-6">
    <input 
        type="radio"  
        value="1" 
        @if ($tipo==1)
            name="rol" checked="checked">
        @else
            {{ $user->rol==1 ? 'checked' : '' }}
            name="rol">
        @endif
    {!! Form::label('administrador', 'Administrador') !!}
    <br>
    <input 
        type="radio"  
        value="3" 
        @if ($tipo==1)
            name="rol" checked="checked">
        @else
            {{ $user->rol==3 ? 'checked' : '' }}
            name="rol">
        @endif
    {!! Form::label('reporte', 'Ver Reportes') !!}
    <br>
    <input 
        type="radio"  
        value="2" 
        @if ($tipo==1)
            name="rol" checked="checked">
        @else
            {{ $user->rol==2 ? 'checked' : '' }}
            name="rol">
        @endif
    {!! Form::label('responsable', 'Responsable') !!}
    <br>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" value="Guardar" class="btn btn-success">Guardar <i class="fa fa-save"></i></button>
    <a href="{!! route('users.index') !!}" class="btn btn-danger">Cancelar <i class="glyphicon glyphicon-remove"></i></a>
</div>

<script type="text/javascript">
  $("#establecimiento_id").change(event => {
  $.get(`midivision/${event.target.value}`, function(res, sta){
    if (event.target.value==1 || event.target.value==2 || event.target.value==3 || event.target.value==30 || event.target.value==69){
        var x=1;
        $("#division_id").empty();
        $("#unidad_id").empty();
        $("#servicio_id").empty();
        res.forEach(element => {
          if(x==1){
            $("#division_id").append(`<option value='0'> --- Seleccione --- </option>`);  
            $("#division_id").append(`<option value=${element.id}> ${element.nombre_division} </option>`);
          }
          else
          {
            $("#division_id").append(`<option value=${element.id}> ${element.nombre_division} </option>`);    
          }  
          x++;

        });

    }
    else
    {
        $("#division_id").empty();
        $("#unidad_id").empty();
        $("#servicio_id").empty();
        var x=1;
        res.forEach(element => {
            $("#servicio_id").append(`<option value=${element.rubro_id}> ${element.descripcion} </option>`);
          x++;

        });

    }    
    
    
  });
});

$("#division_id").change(event => {
  $.get(`miunidad/${event.target.value}`, function(res, sta){
    var x=1;
    $("#unidad_id").empty();
    $("#servicio_id").empty();
    
    if (event.target.value>0){

        res.forEach(element => {
          if(x==1){
            $("#unidad_id").append(`<option value='0'> --- Seleccione --- </option>`);  
            $("#unidad_id").append(`<option value=${element.id}> ${element.nombre_unidad} </option>`);
            
            }
            else
            {
                $("#unidad_id").append(`<option value=${element.id}> ${element.nombre_unidad} </option>`);
            }    
        x++;

        });
    }    
  });
});

$("#unidad_id").change(event => {
  $.get(`miservicio/${event.target.value}`, function(res, sta){
    $("#servicio_id").empty();
    res.forEach(element => {
       $("#servicio_id").append(`<option value=${element.servicio_id}> ${element.nombre_servicio} </option>`); 
    });
  });
});
</script>
