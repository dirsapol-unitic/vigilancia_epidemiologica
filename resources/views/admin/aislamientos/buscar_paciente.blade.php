<div class="panel panel-primary filterable" >
    <div class="panel-heading">
        <h3 class="panel-title">BUSCAR PERSONAL PNP</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-2">
                    <label>DNI</label><br/>
                    <input type="text" required="" tabindex="1" name="dni" id="dni" class="form-control"  minlength="8" minlength="12">
                </div>
                <div class="form-group col-sm-2"><br/>
                    {!! Form::submit('Buscar', ['class' => 'btn btn-info']) !!}
                </div>
            </div>
        </div>
    </div>  
</div>