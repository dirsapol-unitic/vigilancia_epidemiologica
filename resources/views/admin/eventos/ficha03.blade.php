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
        <h3 class="panel-title">EVOLUCION</h3>
    </div> 
    <div class="box box-primary">
        <div class="box-body">
            <div class="row col-sm-12">
                <div class="form-group col-sm-3">
                <label>Evolucion del paciente</label> <br/>
                    <select class="form-control select2" tabindex="19" required="" onchange="getEvolucion();" name="evolucion" id="evolucion">
                            <option value="0">- Seleccione -</option>
                            <option value="1">Favorable</option>
                            <option value="2">Desfavorable</option>
                            <option value="3">Fallecio</option>
                            <option value="4">Alta</option>
                    </select><br/><br/>
                </div>
                <div class="form-group col-sm-3 " id="divalta">
                    <label>Fecha  de Alta</label><br/>
                    <input type="date" tabindex="20"  required="" name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                </div>
            </div>
            <div class="row col-sm-12" id="divdefuncion">
                <div class="row col-sm-12">
                    <div class="form-group col-sm-3">
                        <label>Clasifica Defuncion</label><br/>
                        <select class="form-control select2" tabindex="19" required="" onchange="getEvolucion();" name="evolucion" id="evolucion">
                            <option value="0">- Seleccione -</option>
                            <option value="1">Nivel 1 de Certeza Diagnostica</option>
                            <option value="2">Nivel 2 de Certeza Diagnostica</option>
                            <option value="3">Caso compatible fallecido por Covid-19</option>
                            <option value="4">Fallecido sospechoso por Covid-19 en investigacion</option>
                            <option value="5">Fallecido por causa no Covid-19</option>
                        </select><br/><br/>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Fecha  de defuncion</label><br/>
                        <input type="date" tabindex="20"  required="" name="fecha_defuncion" id="fecha_defuncion" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Hora de defuncion</label><br/>
                        <input type="text" tabindex="20"  required="" name="hora_defuncion" id="hora_defuncion" class="form-control timepicker" value="" >
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Lugar de defuncion:</label><br/>
                        <select class="form-control select2" tabindex="9" required="" name="id_lugar_defuncion" id="id_lugar_defuncion">
                            <option value="0">- Seleccione -</option>
                            <option value="1">Hospital/Clinica</option>
                            <option value="2">Vivienda</option>
                            <option value="3">Centro de Aislamiento temporal</option>
                            <option value="4">Centro penitenciario</option>
                            <option value="5">Via publica</option>
                            <option value="4">Otros</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">                
                    <label>Causa de la muerte</label> <br/>                                
                    <textarea rows="10" type="text" tabindex="25" required="" name="causa_muerte" id="causa_muerte" class="ckeditor"></textarea>                                
                    <br/><br/><br/>
                </div>
                <div class="col-md-12">                
                    <label>Observacion</label> <br/>                                
                    <textarea rows="10" type="text" tabindex="25" required="" name="observacion" id="observacion" class="ckeditor"></textarea>                                
                    <br/><br/><br/>
                </div>
                <div class="row col-sm-12" id="divdefuncion">
                    
                        
                            {!! Form::model($nota_informativa, ['route' => ['aislamientos.subir_archivo', $dni, $id,1], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}
                            <div class="form-group col-sm-2">
                                <label>Nota/Certificado</label><br/>
                                <select class="form-control select2" tabindex="9" required="" name="id_lugar_defuncion" id="id_lugar_defuncion">
                                    <option value="0">- Seleccione -</option>
                                    <option value="1">Nota Informativa</option>
                                    <option value="2">Certificado Defuncion</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Nro</label><br/>
                                <input type="text" tabindex="20"  required="" name="nro_doc" id="nro_doc" class="form-control" value="">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Fecha</label><br/>
                                <input type="date" tabindex="20"  required="" name="fecha_doc" id="fecha_doc" class="form-control" value="<?php echo date("Y-m-d", strtotime($fechaServidor)); ?>" >
                            </div>
                            <div class="form-group col-sm-4">
                                <label></label><br/>
                                <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                <span class="help-block with-errors"></span>
                                
                            </div>
                            <div class="form-group col-sm-2">
                                {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!} 
                            </div>

                                               
                            {!! Form::close() !!}
                                            
                        <div class="form-group col-sm-12">                                
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>                                            
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Descargar</th>                            
                                        <th>Eliminar</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($nota_informativa as $key => $file)
                                    <tr>
                                        <td>{{$key+1}}</td>                                            
                                        <td>
                                            {!! $file->nombre_archivo !!} 
                                        </td>
                                        <td>
                                            <?php 
                                                if($file->extension_archivo=='pdf'){
                                                    $imagen='fa fa-file-pdf-o';
                                                    $color='bg-red';
                                                }else
                                                {   if($file->extension_archivo=='xls' || $file->extension_archivo=='xlsx'){
                                                        $imagen='fa-file-excel-o';
                                                        $color='bg-green';
                                                    }
                                                    else
                                                    {
                                                        if($file->extension_archivo=='doc' || $file->extension_archivo=='docx'){
                                                            $imagen='fa-file-word-o';
                                                            $color='bg-blue';
                                                        }
                                                        else
                                                        {
                                                            if($file->extension_archivo=='jpg' || $file->extension_archivo=='gif' || $file->extension_archivo=='jpeg' || $file->extension_archivo=='png' || $file->extension_archivo=='svg' || $file->extension_archivo=='eps' || $file->extension_archivo=='psd' ){
                                                                $imagen='fa-file-image-o';
                                                                $color='bg-purple';
                                                            }
                                                            else
                                                            {
                                                                $imagen='fa-archive';
                                                                $color='bg-orange';
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                            <a target="_blank" href='{{ asset ("$file->descarga_archivo") }}' class='btn <?php echo $color; ?>'><i class="fa <?php echo $imagen; ?>"></i></a>
                                        </td>                            
                                        <td>                                
                                             <a href="{!! route('aislamientos.eliminar_archivo',['id'=>$file->id,$id, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
                                        </td>                            
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>                                
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