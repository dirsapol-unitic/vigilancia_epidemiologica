@extends('layouts.master')
@section('content')     

<div class="flex-center position-ref full-height">  

      

<div class="content"> 
    <div class="panel panel-primary filterable" >
        <div class="box-body">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">PERSONAL REGISTRADO</h3>
                </div>
            </div>
            <h1 class="pull-right">
            <a class="btn btn-app" href="/solucionar_expedientes/{{$idaislamiento}}/{{$dni}}">
                                <i class="fa fa-edit"></i> Evaluar
            </a>
            </h1><br/>
            <div class="row">                
                <table id="" class="display" border="0" width="100%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    
                                            <tbody>
                                            <tr>
                                                <td width="20%"> <b>Fecha Registro</b></td>
                                                <td width="30%"> : {{$fecha_registro}} </td>
                                                <td width="20%"> <b>Nro Doc</b></td>
                                                <td width="30%"> : {{$dni}}</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Nombres</b></td>
                                                <td> : {{$nombres}} </td>
                                                <td> <b>Ap. Paterno</b></td>
                                                <td> : {{$apellido_paterno}}</td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Ap. Materno</b></td>
                                                <td> : {{$apellido_materno}}</td>
                                                <td> <b>Celular</b></td>
                                                <td> : {{$celular}}</td>                
                                            </tr>
                                            <tr>                    
                                                <td> <b>CIP</b></td>
                                                <td> : {{$cip}} </b></td>
                                                <td> <b>Edad</b></td>
                                                <td> : {{$edad}}</td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Departamento</b></td>
                                                <td> : {{$nombre_dpto}} </b></td>
                                                <td> <b>Provincia</b></td>
                                                <td> : {{$nombre_prov}}</td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Distrito</b></td>
                                                <td> : {{$nombre_dist}} </td>
                                                <td> <b>Email</b></td>
                                                <td> : {{$email}} </td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Sexo</b></td>
                                                <td> : {{$sexo}} </td>
                                                <td> <b>Grado</b></td>
                                                <td> : {{$grado}} </td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Categoria</b></td>
                                                <td> : {{$categoriapnp}} </td>
                                                <td> <b>Aislamiento con declaracion jurada</b></td>
                                                <td> : {{$dj}} </td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Atencion medica en establecimiento PNP en año 2020</b></td>
                                                <td> : {{$atencion}} </td>
                                                <td> <b>Realiza trabajo remoto</b></td>
                                                <td> : {{$trabajo_remoto}} </td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Fecha de Aislamiento Social</b></td>
                                                <td> : {{$fecha_aislamiento}} </td>
                                                <td> <b>Consideracion para reincorporacion</b></td>
                                                <td> : {{$reincorporacion}} </td>
                                            </tr>
                                            <tr>                    
                                                <td> <b>Domicilio</b></td>
                                                <td colspan="3"> : {{$domicilio}} </td>
                                            </tr>   
                                            <tr>
                                                <td> <b>Factor de Riesgos</b></td>
                                                <td>
                                                    @foreach($riesgos as $key => $riesgo)
                                                    <table>                                                     
                                                        <tr>
                                                            <td>{{$key+1}}.- </td>                                                      
                                                            <td>{!! $riesgo->descripcion !!}</td>                                                       
                                                        </tr>
                                                    </table>                                                    
                                                    @endforeach
                                                </td>
                                            </tr>                                          
                                            
                                            
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>     
                <br/><br/><br/>      
                <table id="" class="display" border="0" width="90%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="text-align:center;">INFORME MEDICO<br/><br/></th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <tr><td>
                                            @if($contar_im>0)
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>                                            
                                                            <th>Nombre</th> 
                                                            <th>Descargar</th>            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($informes_medicos as $key => $file)
                                                        <tr>
                                                            <td>{{$key+1}}</td>                                            
                                                            <td>
                                                                {!! $file->nombre_archivo !!} 
                                                            </td>
                                                            <td><?php 
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> 
                                            @else
                                                No subio ningun documento
                                            @endif
                                           </td>
                                        </tr>                                            
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table id="" class="display" border="0" width="90%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="text-align:center;">CERTIFICADO MEDICO<br/><br/></th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                            @if($contar_cm>0)
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>                                            
                                                            <th>Nombre</th>   
                                                            <th>Descargar</th>           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($certificado_medicos as $key => $file)
                                                        <tr>
                                                            <td>{{$key+1}}</td>                                            
                                                            <td>
                                                                {!! $file->nombre_archivo !!} 
                                                            </td> 
                                                            <td><?php 
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> 
                                            @else
                                                No subio ningun documento
                                            @endif
                                           </td>
                                        </tr>                                            
                                    </tbody>
                                </table>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table id="" class="display" border="0" width="90%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="text-align:center;">EXAMEN DE LABORATORIO<br/><br/></th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <tr><td>
                                            @if($contar_el>0)
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>                                            
                                                            <th>Nombre</th>   
                                                            <th>Descargar</th>           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($examen_laboratorio as $key => $file)
                                                        <tr>
                                                            <td>{{$key+1}}</td>                                            
                                                            <td>
                                                                {!! $file->nombre_archivo !!} 
                                                            </td>   
                                                            <td><?php 
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> 
                                            @else
                                                No subio ningun documento
                                            @endif
                                           </td>
                                        </tr>                                            
                                    </tbody>
                                </table>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table id="" class="display" border="0" width="90%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="text-align:center;">EXAMEN DE IMAGENES<br/><br/></th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <tr><td>
                                            @if($contar_ei>0)
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>                                            
                                                            <th>Nombre</th> 
                                                            <th>Descargar</th>             
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($examen_imagen as $key => $file)
                                                        <tr>
                                                            <td>{{$key+1}}</td>                                            
                                                            <td>
                                                                {!! $file->nombre_archivo !!} 
                                                            </td>
                                                            <td><?php 
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> 
                                            @else
                                                No subio ningun documento
                                            @endif
                                           </td>
                                        </tr>                                            
                                    </tbody>
                                </table>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table id="" class="display" border="0" width="90%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="text-align:center;">INFORME DE PROCEDIMIENTO<br/><br/></th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <tr><td>
                                            @if($contar_ip>0)
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>                                            
                                                            <th>Nombre</th>  
                                                            <th>Descargar</th>            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($informe_procedimiento as $key => $file)
                                                        <tr>
                                                            <td>{{$key+1}}</td>                                            
                                                            <td>
                                                                {!! $file->nombre_archivo !!} 
                                                            </td>  
                                                            <td><?php 
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> 
                                            @else
                                                No subio ningun documento
                                            @endif
                                           </td>
                                        </tr>                                            
                                    </tbody>
                                </table>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table id="" class="display" border="0" width="90%"> 
                    <tbody>     
                        <tr>
                            <td width="5%"></td>                        
                            <td>
                                <table id="" class="display" border="0" width="100%"> 
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="text-align:center;">RECETAS VALES<br/><br/></th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <tr><td>
                                            @if($contar_ip>0)
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>                                            
                                                            <th>Nombre</th>    
                                                            <th>Descargar</th>          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($recetas_vales as $key => $file)
                                                        <tr>
                                                            <td>{{$key+1}}</td>                                            
                                                            <td>
                                                                {!! $file->nombre_archivo !!} 
                                                            </td>
                                                            <td><?php 
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> 
                                            @else
                                                No subio ningun documento
                                            @endif
                                           </td>
                                        </tr>                                            
                                    </tbody>
                                </table>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
</div>
@endsection
        




