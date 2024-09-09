<p><b>Extensiones permitidas(jpg,pdf), archivo Max. 5MB:</b></p>
<div class="row">
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">                
                <div class="box-header">
                    <h3 class="box-title">INFORME MEDICO</h3>
                </div>
                <div class="box-body">
                    <div class="row col-sm-12">                             
                        <div class="form-group col-sm-6">
                            {!! Form::model($informes_medicos, ['route' => ['aislamientosite.subir_archivo', $dni, $idaislamiento,1], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}                            
                                <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                <span class="help-block with-errors"></span>
                            {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!}                    
                            {!! Form::close() !!}
                        </div>                    
                        <div class="form-group col-sm-6">                                
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>                                            
                                        <th>Nombre</th>
                                        <th>Descargar</th>                            
                                        <th>Eliminar</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($informes_medicos as $key => $file)
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
                                             <a href="{!! route('aislamientosite.eliminar_archivo',['id'=>$file->id,$idaislamiento, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
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
    </div>    
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">
                <div>
                    <div class="box-header">
                        <h3 class="box-title">CERTIFICADO MEDICO</h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-sm-12">                             
                            <div class="form-group col-sm-6">
                                {!! Form::model($certificado_medicos, ['route' => ['aislamientosite.subir_archivo', $dni, $idaislamiento,2], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}                       
                                
                                    <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                    <span class="help-block with-errors"></span>
                                {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!}                    
                                {!! Form::close() !!}
                            </div>                    
                            <div class="form-group col-sm-6">                                
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                            
                                            <th>Fecha Subida</th>
                                            <th>Descargar</th>                            
                                            <th>Eliminar</th>                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($certificado_medicos as $key => $file)
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
                                                 <a href="{!! route('aislamientosite.eliminar_archivo',['id'=>$file->id,$idaislamiento, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
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
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">                
                <div class="box-header">
                    <h3 class="box-title">EXAMEN DE LABORATORIO</h3>
                </div>
                <div class="box-body">
                    <div class="row col-sm-12">                             
                        <div class="form-group col-sm-6">
                            {!! Form::model($examen_laboratorio, ['route' => ['aislamientosite.subir_archivo', $dni, $idaislamiento,3], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}                       
                            
                                <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                <span class="help-block with-errors"></span>
                            {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!}                    
                            {!! Form::close() !!}
                        </div>                    
                        <div class="form-group col-sm-6">                                
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>                                            
                                        <th>Fecha Subida</th>
                                        <th>Descargar</th>                            
                                        <th>Eliminar</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($examen_laboratorio as $key => $file)
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
                                             <a href="{!! route('aislamientosite.eliminar_archivo',['id'=>$file->id,$idaislamiento, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
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
    </div>    
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">
                <div>
                    <div class="box-header">
                        <h3 class="box-title">EXAMEN DE IMAGENES</h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-sm-12">                             
                            <div class="form-group col-sm-6">
                                {!! Form::model($examen_imagen, ['route' => ['aislamientosite.subir_archivo', $dni, $idaislamiento,4], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}                       
                                
                                    <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                    <span class="help-block with-errors"></span>
                                {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!}                    
                                {!! Form::close() !!}
                            </div>                    
                            <div class="form-group col-sm-6">                                
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                            
                                            <th>Fecha Subida</th>
                                            <th>Descargar</th>                            
                                            <th>Eliminar</th>                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($examen_imagen as $key => $file)
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
                                                 <a href="{!! route('aislamientosite.eliminar_archivo',['id'=>$file->id,$idaislamiento, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
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
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">                
                <div class="box-header">
                    <h3 class="box-title">INFORME DE PROCEDIMIENTO</h3>
                </div>
                <div class="box-body">
                    <div class="row col-sm-12">                             
                        <div class="form-group col-sm-6">
                            {!! Form::model($informe_procedimiento, ['route' => ['aislamientosite.subir_archivo', $dni, $idaislamiento,5], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}                       
                            
                                <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                <span class="help-block with-errors"></span>
                            {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!}                    
                            {!! Form::close() !!}
                        </div>                    
                        <div class="form-group col-sm-6">                                
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>                                            
                                        <th>Fecha Subida</th>
                                        <th>Descargar</th>                            
                                        <th>Eliminar</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($informe_procedimiento as $key => $file)
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
                                             <a href="{!! route('aislamientosite.eliminar_archivo',['id'=>$file->id,$idaislamiento, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
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
    </div>    
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">
                <div>
                    <div class="box-header">
                        <h3 class="box-title">RECETA MEDICA</h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-sm-12">                             
                            <div class="form-group col-sm-6">
                                {!! Form::model($recetas_vales, ['route' => ['aislamientosite.subir_archivo', $dni, $idaislamiento,6], 'method' => 'patch','enctype'=>"multipart/form-data"]) !!}                       
                                
                                    <input id="photo" name="photo" accept="tipo_de_archivo|image/*|media_type" name="archivo" type="file" value="" required="required" />
                                    <span class="help-block with-errors"></span>
                                {!! Form::submit('Subir Archivo', ['class' => 'btn btn-success']) !!}                    
                                {!! Form::close() !!}
                            </div>                    
                            <div class="form-group col-sm-6">                                
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                            
                                            <th>Fecha Subida</th>
                                            <th>Descargar</th>                            
                                            <th>Eliminar</th>                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recetas_vales as $key => $file)
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
                                                 <a href="{!! route('aislamientosite.eliminar_archivo',['id'=>$file->id,$idaislamiento, $dni]) !!}" class='btn bg-red'><i class="fa fa-trash"></i></a>                                
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
        </div>
    </div>
</div>

<p align="center"><a href="{!! route('aislamientosite.mostrar_agradecimiento',[$idaislamiento, $dni]) !!}" class='btn bg-blue'>FINALIZAR</a></p>


