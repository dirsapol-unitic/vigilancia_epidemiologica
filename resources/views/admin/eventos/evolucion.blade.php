<div class="box box-danger">
    <div class="box-body">
        <div class="row col-sm-12">
            @if($paciente->evolucion<3 )
                <div class="form-group col-sm-3">
                    <label>Evolucion del paciente</label> <br/>
                    <select class="form-control select2" tabindex="47" required="" style="width: 100%" onchange="getEvolucion();" name="evolucion" id="evolucion">
                        <option value="0" <?php if($paciente->evolucion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                        <option value="1" <?php if($paciente->evolucion == 1)echo "selected='selected'";?>>Favorable</option>
                        <option value="2" <?php if($paciente->evolucion == 2)echo "selected='selected'";?>>Desfavorable</option>
                        <option value="4" <?php if($paciente->evolucion == 4)echo "selected='selected'";?>>Alta</option>
                        <option value="3" <?php if($paciente->evolucion == 3)echo "selected='selected'";?>>Fallecio</option>
                        <input type="hidden" name="dni_evolucion" id="dni_evolucion" value="<?php echo $paciente->dni?>">
                        <input type="hidden" name="id_paciente_evolucion" id="id_paciente_evolucion" value="<?php echo $paciente->id?>">
                        <input type="hidden" name="opcion" id="opcion" value="evolucion_tab">
                    </select><br/><br/>
                </div>
                <div class="form-group col-sm-3 " id="divalta">
                    <label>Fecha  de Alta</label><br/>
                    <input type="date" tabindex="48"   name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo $fecha_alta; ?>" >
                    </div>
                </div>
            @else
                @if($paciente->evolucion==4)
                    <div class="form-group col-sm-3">
                        <label>Evolucion del paciente</label> <br/>
                        <input type="text" tabindex="48" readonly=""  name="alta" id="alta" class="form-control" value="ALTA" >
                        <br/><br/>
                    </div>
                    <div class="form-group col-sm-3 ">
                        <label>Fecha  de Alta</label><br/>
                        <input type="text" tabindex="48" readonly=""  name="fecha_alta" id="fecha_alta" class="form-control" value="<?php echo $fecha_alta; ?>" >
                        </div>
                    </div>
                @endif
            @endif
            @if($paciente->evolucion==3)
                <div class="form-group col-sm-3">
                    <label>Evolucion del paciente</label> <br/>
                    <input type="text" tabindex="48" readonly=""  name="alta" id="alta" class="form-control" value="FALLECIO" >
                    <br/><br/>
                </div>
                <div class="row col-sm-12">
                        <div class="row col-sm-12">
                            <div class="form-group col-sm-4">
                                <label>Clasifica Defuncion</label><br/>
                                <select class="form-control select2" tabindex="49"  style="width: 100%" name="tipo_defuncion" disabled="disabled" id="tipo_defuncion">
                                    <option value="0" <?php if($paciente->tipo_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                                    <option value="1" <?php if($paciente->tipo_defuncion == 1)echo "selected='selected'";?>>Nivel 1 de Certeza Diagnostica</option>
                                    <option value="2" <?php if($paciente->tipo_defuncion == 2)echo "selected='selected'";?>>Nivel 2 de Certeza Diagnostica</option>
                                    <option value="3" <?php if($paciente->tipo_defuncion == 3)echo "selected='selected'";?>>Caso compatible fallecido por Covid-19</option>
                                    <option value="4" <?php if($paciente->tipo_defuncion == 4)echo "selected='selected'";?>>Fallecido sospechoso por Covid-19 en investigacion</option>
                                    <option value="5" <?php if($paciente->tipo_defuncion == 5)echo "selected='selected'";?>>Fallecido por causa no Covid-19</option>
                                </select><br/><br/>
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Fecha  de defuncion</label><br/>
                                <input type="date" tabindex="50"  readonly=""  name="fecha_defuncion" id="fecha_defuncion" class="form-control" value="<?php echo $fecha_defuncion; ?>" >
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Hora de defuncion</label><br/>
                                <input type="text" tabindex="51"  readonly="" name="hora_defuncion" id="hora_defuncion" class="form-control timepicker" value="<?php echo $paciente->hora_defuncion; ?>" >
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Lugar de defuncion:</label><br/>
                                <select class="form-control select2" tabindex="52" style="width: 100%"  name="lugar_defuncion" id="lugar_defuncion" disabled="disabled">
                                    <option value="0" <?php if($paciente->lugar_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                                    <option value="1" <?php if($paciente->lugar_defuncion == 1)echo "selected='selected'";?>>Hospital/Clinica</option>
                                    <option value="2" <?php if($paciente->lugar_defuncion == 2)echo "selected='selected'";?>>Vivienda</option>
                                    <option value="3" <?php if($paciente->lugar_defuncion == 3)echo "selected='selected'";?>>Centro de Aislamiento temporal</option>
                                    <option value="4" <?php if($paciente->lugar_defuncion == 4)echo "selected='selected'";?>>Centro penitenciario</option>
                                    <option value="5" <?php if($paciente->lugar_defuncion == 5)echo "selected='selected'";?>>Via publica</option>
                                    <option value="4" <?php if($paciente->lugar_defuncion == 6)echo "selected='selected'";?>>Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">                
                            <label>Causa de la muerte</label> <br/>                                
                            <textarea rows="10" type="text" tabindex="53" name="causa_muerte" id="causa_muerte" class="ckeditor" disabled="disabled"><?php echo $paciente->causa_muerte?></textarea>
                            
                            <br/><br/><br/>
                        </div>
                        <div class="col-md-12">                
                            <label>Motivo de la Muerte</label> <br/>                                
                            <textarea rows="10" type="text" tabindex="54"  name="motivo_muerte" id="motivo_muerte" class="ckeditor" disabled="disabled"><?php echo $paciente->motivo_muerte?></textarea>                                
                            <br/><br/><br/>
                        </div>
                        <div class="row col-sm-12" id="divdefuncion">
                            <table>
                                <tr>
                                    <td>
                                        <button type="button" id="addCertificado" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Agregar Certificado</button>
                                    </td>
                                </tr>
                            </table>
                            <br />
                            <table class="display" id="tblCertificado" cellspacing="0" width="100%" style="margin-top:5px;">
                                <thead>
                                    <tr>
                                        <th width="15%">Nota/Certificado</th>
                                        <th width="15%">Nro</th>
                                        <th width="20%">Fecha</th>
                                        <th width="20%">Archivo</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
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
            @else
                <div class="row col-sm-12" id="divdefuncion">
                    <div class="row col-sm-12">
                        <div class="form-group col-sm-4">
                            <label>Clasifica Defuncion</label><br/>
                            <select class="form-control select2" tabindex="49"  style="width: 100%" name="tipo_defuncion" id="tipo_defuncion">
                                <option value="0" <?php if($paciente->tipo_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                                <option value="1" <?php if($paciente->tipo_defuncion == 1)echo "selected='selected'";?>>Nivel 1 de Certeza Diagnostica</option>
                                <option value="2" <?php if($paciente->tipo_defuncion == 2)echo "selected='selected'";?>>Nivel 2 de Certeza Diagnostica</option>
                                <option value="3" <?php if($paciente->tipo_defuncion == 3)echo "selected='selected'";?>>Caso compatible fallecido por Covid-19</option>
                                <option value="4" <?php if($paciente->tipo_defuncion == 4)echo "selected='selected'";?>>Fallecido sospechoso por Covid-19 en investigacion</option>
                                <option value="5" <?php if($paciente->tipo_defuncion == 5)echo "selected='selected'";?>>Fallecido por causa no Covid-19</option>
                            </select><br/><br/>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Fecha  de defuncion</label><br/>
                            <input type="date" tabindex="50"   name="fecha_defuncion" id="fecha_defuncion" class="form-control" value="<?php echo $fecha_defuncion; ?>" >
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Hora de defuncion</label><br/>
                            <input type="text" tabindex="51"  name="hora_defuncion" id="hora_defuncion" class="form-control timepicker" value="<?php echo $paciente->hora_defuncion; ?>" >
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Lugar de defuncion:</label><br/>
                            <select class="form-control select2" tabindex="52" style="width: 100%"  name="lugar_defuncion" id="lugar_defuncion">
                                <option value="0" <?php if($paciente->lugar_defuncion == 0)echo "selected='selected'";?>>- Seleccione -</option>
                                <option value="1" <?php if($paciente->lugar_defuncion == 1)echo "selected='selected'";?>>Hospital/Clinica</option>
                                <option value="2" <?php if($paciente->lugar_defuncion == 2)echo "selected='selected'";?>>Vivienda</option>
                                <option value="3" <?php if($paciente->lugar_defuncion == 3)echo "selected='selected'";?>>Centro de Aislamiento temporal</option>
                                <option value="4" <?php if($paciente->lugar_defuncion == 4)echo "selected='selected'";?>>Centro penitenciario</option>
                                <option value="5" <?php if($paciente->lugar_defuncion == 5)echo "selected='selected'";?>>Via publica</option>
                                <option value="4" <?php if($paciente->lugar_defuncion == 6)echo "selected='selected'";?>>Otros</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">                
                        <label>Causa de la muerte</label> <br/>                                
                        <textarea rows="10" type="text" tabindex="53" name="causa_muerte" id="causa_muerte" class="ckeditor"><?php echo $paciente->causa_muerte?></textarea>
                        
                        <br/><br/><br/>
                    </div>
                    <div class="col-md-12">                
                        <label>Motivo de la Muerte</label> <br/>                                
                        <textarea rows="10" type="text" tabindex="54"  name="motivo_muerte" id="motivo_muerte" class="ckeditor"><?php echo $paciente->motivo_muerte?></textarea>                                
                        <br/><br/><br/>
                    </div>
                    <div class="row col-sm-12" id="divdefuncion">
                        <table>
                            <tr>
                                <td>
                                    <button type="button" id="addCertificado" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Agregar Certificado</button>
                                </td>
                            </tr>
                        </table>
                        <br />
                        <table class="display" id="tblCertificado" cellspacing="0" width="100%" style="margin-top:5px;">
                            <thead>
                                <tr>
                                    <th width="15%">Nota/Certificado</th>
                                    <th width="15%">Nro</th>
                                    <th width="20%">Fecha</th>
                                    <th width="20%">Archivo</th>
                                    
                                </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
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
            @endif
            
            @if($paciente->evolucion<3)
            <div class="box-body">
                <div class="form-group col-sm-12">
                    {!! Form::submit('Actualizar', ['class' => 'btn btn-success pull-right btn-block btn-sm']) !!}
        
                </div>
            </div>
            @endif
        </div>
    </div>
</div>