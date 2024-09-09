<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FICHA EPIDEMIOLOGICA COVID-19</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
    <!--link rel="stylesheet" src='{{ asset ("/css/bootstrap.min.css") }}'-->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('css/jquery.simple-dtpicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/datepicker3.css')}}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/_all-skins.min.css">
    
    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!--timer -->
    <link rel="stylesheet" href="{{asset('css/timer.css')}}">


    <style type="text/css">
        .main-header .logo2 {
            -webkit-transition: width .3s ease-in-out;
            -o-transition: width .3s ease-in-out;
            transition: width .3s ease-in-out;
            display: block;
            float: left;
            height: 50px;
            font-size: 20px;
            color:yellow;
            line-height: 50px;
            text-align: center;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            padding: 0 15px;
            font-weight: 300;
            overflow: hidden;
        }

    </style>
    @yield('css')
</head>
@if (Auth::user()->rol==1)
    <body class="skin-blue sidebar-mini sidebar-collapse">
@else
    <body class="skin-blue sidebar-mini sidebar-collapse">
@endif    
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>AISLAMIENTO</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Menu</span>
                </a>
                <a href="#" class="logo2">
                    <b>FICHA EPIDEMIOLOGICA COVID-19 - DIRSAPOL</b>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <?php $ruta='/upload/photo/'.Auth::user()->photo; ?>
                                <img class="user-image"  src="{!!url($ruta)!!}" alt="User Image">
                                     
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img class="img-circle"  src="{!!url($ruta)!!}" alt="User Image">
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>Miembro desde {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{!! route('users.editar_clave', Auth::user()->id) !!}" class="btn btn-default btn-flat">Cambiar Contraseña</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Salir
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2020 <a href="#"> DIRSAPOL </a>.</strong> Todos los derechos reservados.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    FICHA EPIDEMIOLOGICA COVID-19
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Inicio</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Registrar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 3.1.1 -->
    <script src='{{ asset ("/js/jquery.min.js") }}'></script>
    <script src='{{ asset ("/js/jquery-ui.min.js") }}'></script>
    <script src='{{ asset ("/js/bootstrap.min.js") }}'></script>
    
    

    <script src='{{ asset ("/datatable/jquery.dataTables.min.js") }}'></script>
    <script src='{{ asset ("/datatable/dataTables.bootstrap.min.js") }}'></script>
    <script src='{{ asset ("/js/adminlte.min.js") }}'></script>
    
    <script src='{{ asset ("/js/app.min.js") }}'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src='{{ asset ("/js/timer.js") }}'></script>



    <script>
      $(function () {
        $('#example1').DataTable()    
        $('#example2').DataTable()    
        $(".select2").select2();   
      })
      
    </script>

    <script>

    //--------------------------------------------------------------------------

$(document).ready(function () {
    function soloNumeros(e) {
        var key = window.Event ? e.which : e.keyCode;
        //alert(key);
        return ((key >= 48 && key <= 57) || key == 0 || key == 8)
    }

    $("#dni").blur(function (event) {
            getPersonalByDni();
    });

    $("#dni_contacto").blur(function (event) {
            getPersonalByDniContacto();
    }); 

    $('#addDiagnostico').on('click',function(){
        AddDiagnostico();
    });
    
    $('#tblDiagnostico tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });

    AddDiagnostico();

    $('#addExamenLaboratorio').on('click',function(){
        AddExamenLaboratorio();
    });
    
    $('#tblExamenLaboratorio tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });

    AddExamenLaboratorio();

    $('#addCertificado').on('click',function(){
        AddCertificado();
    });
    
    $('#tblCertificado tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });

    AddCertificado();

    
});
    

function getPersonalByDni() {
    var nro_doc = $('#dni').val();        
    var valor = '';
    var nacion = '';
    
    $.ajax({
        url: '/buscar_personal_dni/' + nro_doc,
        dataType: "json",
        success: function(result){
            if(result.sw == false){
                $('#name').val("");
                $('#paterno').val("");
                $('#materno').val("");
                $('#cip').val("");
                $('#grado').val("");
                $('#fecha_nacimiento').val("");
                $('#sexo').val("");
                $('#parentesco').val("");
                $('#unidad').val("");
                $('#id_categoria').val(0);
                $("#id_categoria").select2({max_selected_options:4});
                $('#peso').val("");
                $('#talla').val("");
                $('#telefono').val("");
                $('#etnia').val(0);
                $("#etnia").select2({max_selected_options:4});
                $('#otra_raza').val("");
                $('#nacionalidad').val(0);
                $("#nacionalidad").select2({max_selected_options:4});
                $('#otra_nacion').val("");
                $('#migrante').val(0);
                $("#migrante").select2({max_selected_options:4});
                $('#otro_migrante').val("");
                $('#domicilio').val("");
                $('#id_departamento').val(0);
                $("#id_departamento").select2({max_selected_options:4});
                $('#id_provincia').val(0);
                $("#id_provincia").select2({max_selected_options:4});
                $('#id_distrito').val(0);
                $("#id_distrito").select2({max_selected_options:4});
                return false;
            }

            //var beneficiario = result.beneficiario.apepatafiliado+" "+result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado+", "+result.beneficiario.nomafiliado;
            $('#parentesco').val(result.beneficiario.parentesco);
            $('#name').val(result.beneficiario.nomafiliado);
            $('#paterno').val(result.beneficiario.apepatafiliado);
            $('#materno').val(result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado);
            $('#cip').val(result.beneficiario.cip);
            $('#grado').val(result.beneficiario.grado);
            $('#fecha_nacimiento').val(result.beneficiario.fecnacafiliado);
            $('#edad').val(result.beneficiario.edadafiliado);
            $('#situacion').val(result.beneficiario.situacion);
        
            nacion=result.beneficiario.nompaisdelafiliado;
            sexo=result.beneficiario.nomsexo;
            if(nacion=='PER'){
                $("#nacionalidad").val(1);
                $("#migrante").val('NO');
            }
            else{
                $("#nacionalidad").val(2);
                $("#migrante").val('SI');
            }
            $("#nacionalidad").select2({max_selected_options:4});
            $("#migrante").select2({max_selected_options:4});

            if(sexo=='M'){
                $("#sexo").val('M');
            }
            else
            {
                $("#sexo").val('F');
            }
            $("#sexo").select2({max_selected_options:4});
            
            
        }


    });
}

$cmbid_departamento = $("#frm_aislamientos").find("#id_departamento");
$cmbid_provincia = $("#frm_aislamientos").find("#id_provincia");
$cmbid_distrito = $("#frm_aislamientos").find("#id_distrito");    
$cmbid_departamento2 = $("#frm_aislamientos").find("#id_departamento2");
$cmbid_provincia2 = $("#frm_aislamientos").find("#id_provincia2");
$cmbid_distrito2 = $("#frm_aislamientos").find("#id_distrito2");    
    
$('#id_departamento').prop('disabled', false);
$('#id_provincia').prop('disabled', false);
$('#id_distrito').prop('disabled', false);

$('#id_departamento2').prop('disabled', false);
$('#id_provincia2').prop('disabled', false);
$('#id_distrito2').prop('disabled', false);

$cmbid_departamento.change(function () {            
    $this = $(this); 
    cmbid_departamento = $cmbid_departamento.val();
    $cmbid_provincia.html('');
    option = {
        url: '/cargarprovincias/' + cmbid_departamento,
        type: 'GET',
        dataType: 'json',
        data: {}
    };
    $.ajax(option).done(function (data) {  
        cargarComboDestino($cmbid_provincia, data);
        $cmbid_provincia.val(null).trigger("change");                                           
    });
});

$cmbid_provincia.change(function () {
        
    $this = $(this); 
    cmbid_provincia = $cmbid_provincia.val();
    cmbid_departamento = $cmbid_departamento.val();

    $cmbid_distrito.html('');
        option = {
            url: '/cargardistrito/'+ cmbid_departamento + '/' + cmbid_provincia,
            type: 'GET',
            dataType: 'json',
            data: {}
        };
        $.ajax(option).done(function (data) {  
            cargarComboDestino($cmbid_distrito, data);
            $cmbid_distrito.val(null).trigger("change");                                           
        });
});
$cmbid_departamento2.change(function () {            
    $this = $(this); 
    cmbid_departamento2 = $cmbid_departamento2.val();
    $cmbid_provincia2.html('');
    option = {
        url: '/cargarprovincias/' + cmbid_departamento2,
        type: 'GET',
        dataType: 'json',
        data: {}
    };
    $.ajax(option).done(function (data) {  
        cargarComboDestino($cmbid_provincia2, data);
        $cmbid_provincia2.val(null).trigger("change");                                           
    });
});

$cmbid_provincia2.change(function () {
        
    $this = $(this); 
    cmbid_provincia2 = $cmbid_provincia2.val();
    cmbid_departamento2 = $cmbid_departamento2.val();

    $cmbid_distrito2.html('');
        option = {
            url: '/cargardistrito/'+ cmbid_departamento2 + '/' + cmbid_provincia2,
            type: 'GET',
            dataType: 'json',
            data: {}
        };
        $.ajax(option).done(function (data) {  
            cargarComboDestino($cmbid_distrito2, data);
            $cmbid_distrito2.val(null).trigger("change");                                           
        });
});

function cargarComboDestino($select, data) {
    $select.html('');
    $(data).each(function (ii, oo) {
        $select.append('<option value="' + oo.id + '">' + oo.nombre + '</option>')
    });
}

$("#divetnia").hide();
$("#divmigrante").hide();
$("#divnacion").hide();
$("#divsintomas").hide();
$("#divcontacto_directo").hide();

function getOtraRaza(){
    var etnia        = $('#etnia').val();
    if(etnia=='6'){
        $("#divetnia").show();
    }
    else{
        $("#divetnia").hide();
    }
}

function getOtroMigrante(){
    var migrante        = $('#migrante').val();
    if(migrante=='1'){
        $("#divmigrante").show();
    }
    else{
        $("#divmigrante").hide();
    }
}

function getOtraNacionalidad(){
    var nacionalidad        = $('#nacionalidad').val();
    if(nacionalidad=='2'){
        $("#divnacion").show();
    }
    else{
        $("#divnacion").hide();
    }
}

function getOtroContacto(){
    var contacto_directo        = $('#contacto_directo').val();
    if(contacto_directo=='1'){
        $("#divcontacto_directo").show();
    }
    else{
        $("#divcontacto_directo").hide();
    }
}

/**********Hospitalizacion******************/
function AddDiagnostico(){
    var newRow = "";
    var ind = $('#tblDiagnostico tbody tr').length;
    
    if(ind > 0){
        $('.cmbMedicamento').each(function(){
            var ind_tmp = $(this).attr("ind");
            if(ind_tmp => ind){
                ind=Number(ind_tmp)+1;
            }
        });
                    
        fila_medicamentos=$('#tblDiagnostico tbody').children('tr');
        rowIndex=$('#hidden_rowIndex').val();
        var idval = ind - 1;
        fila_medicamento=fila_medicamentos[idval];
        
    }
    
    newRow +='<tr>';
    newRow +='<td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar el diagnostico" name="nombre_diagnostico[]" tabindex="8" required="" id="nombre_diagnostico'+ind+'" class="input-sm" style="margin-left:4px; width:100%; text-align:left" />';
    newRow +='<input type="hidden" class="form-control id_diagnostico typeahead tt-query" id="id_diagnostico'+ind+'" name="id_diagnostico[]" value=""></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';
    $('#tblDiagnostico tbody').append(newRow);
    
    $("#nombre_diagnostico"+ind).autocomplete({
        minLength: 1,
        delay : 400,
        source: function(request, response) {
            $.ajax({
                url: '../../obtener_diagnostico/' + request.term,
                dataType: "json",
                success: function(data)  {
                    response(data);
                }                   
            })
    
        },select:  function(e, ui) {
            var id_diagnostico = ui.item.id;
            $("#id_diagnostico"+ind).val(id_diagnostico);
            $("#nombre_diagnostico"+ind).prop("readonly",true);
        }
    });

    $("#nombre_diagnostico"+ind).on('blur', function() {
        var id_diagnostico = $("#id_diagnostico"+ind).val();
        if(id_diagnostico == ""){
            bootbox.alert("Falta ingresar el diagnostico en esta fila");
            $("#nombre_diagnostico"+ind).val("");
            return false;
        }
    });  
}  

function guardarHo(){
    var ind_diag = $('#tblDiagnostico tbody tr').length;
    if(ind_diag > 0){
        fila_dignosticos=$('#tblDiagnostico tbody').children('tr');
        for (i = 0; i < ind_diag; i++) {
            fila_dignostico=fila_dignosticos[i];
            var id_diagnostico = $(fila_dignostico).find('.id_diagnostico').val();
            var id_tipo_diagnostico = $(fila_dignostico).find('.id_tipo_diagnostico').val();
            if(id_diagnostico == "")msg+="Debe ingresar el nombre de diagnostico<br>";
            if(id_tipo_diagnostico == "0")msg+="Debe ingresar el tipo de diagnostico<br>";
        }
    }else{
        msg+="Debe ingresar minimo un diagnostico<br>";
    }
}

/*****************Evolucion*********************************************/
$("#divalta").hide();
$("#divdefuncion").hide();
    
function getEvolucion(){
    var evolucion        = $('#evolucion').val();
    if(evolucion=='4'){
        $("#divalta").show();
    }
    else{
        $("#divalta").hide();   
    }
    if(evolucion=='3'){
        $("#divdefuncion").show();
    }
    else{
        $("#divdefuncion").hide();
    }
}

//Timepicker
$('.timepicker').timepicker({
  showInputs: false
})

$(document).on('change','input[type="file"]',function(){

    var fileName = this.files[0].name;
    var fileSize = this.files[0].size;

    if(fileSize > 5000000){
        alert('El archivo no debe superar los 5MB');
        this.value = '';
        this.files[0].name = '';
    }else{
        var ext = fileName.split('.').pop();
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'pdf': break;
            default:
                alert('El archivo no tiene la extensión adecuada');
                this.value = ''; // reset del valor
                this.files[0].name = '';
        }
    }
});

/********************Contacto****************************************************/
function getPersonalByDniContacto() {
    var nro_doc = $('#dni_contacto').val();        
    var valor = '';
    var nacion = '';
    
    $.ajax({
        url: '/buscar_personal_dni/' + nro_doc,
        dataType: "json",
        success: function(result){
            if(result.sw == false){
                $('#name_contacto').val("");
                $('#paterno_contacto').val("");
                $('#materno_contacto').val("");
                $('#fecha_nacimiento').val("");
                $('#sexo_contacto').val("");
                $('#telefono_contacto').val("");
                $('#correo_contacto').val("");
                $('#domicilio_contacto').val("");
                $('#id_departamento').val(0);
                $("#id_departamento_contacto").select2({max_selected_options:4});
                $('#id_provincia_contacto').val(0);
                $("#id_provincia_contacto").select2({max_selected_options:4});
                $('#id_distrito_contacto').val(0);
                $("#id_distrito_contacto").select2({max_selected_options:4});
                return false;
            }

            
            $('#name_contacto').val(result.beneficiario.nomafiliado);
            $('#paterno_contacto').val(result.beneficiario.apepatafiliado);
            $('#materno_contacto').val(result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado);
            $('#fecha_nacimiento_contacto').val(result.beneficiario.fecnacafiliado);
            
            sexo=result.beneficiario.nomsexo;
            if(sexo=='M'){
                $("#sexo_contacto").val('M');
            }
            else
            {
                $("#sexo_contacto").val('F');
            }
            $("#sexo_contacto").select2({max_selected_options:4});
        }
    });
}

$cmbid_departamento3 = $("#frm_aislamientos").find("#id_departamento_contacto");
$cmbid_provincia3 = $("#frm_aislamientos").find("#id_provincia_contacto");
$cmbid_distrito3 = $("#frm_aislamientos").find("#id_distrito_contacto");  

$cmbid_departamento3.change(function () {            
    $this = $(this); 
    cmbid_departamento3 = $cmbid_departamento3.val();
    $cmbid_provincia3.html('');
    option = {
        url: '/cargarprovincias/' + cmbid_departamento3,
        type: 'GET',
        dataType: 'json',
        data: {}
    };
    $.ajax(option).done(function (data) {  
        cargarComboDestino($cmbid_provincia3, data);
        $cmbid_provincia3.val(null).trigger("change");                                           
    });
});

$cmbid_provincia3.change(function () {        
    $this = $(this); 
    cmbid_provincia3 = $cmbid_provincia3.val();
    cmbid_departamento3 = $cmbid_departamento3.val();

    $cmbid_distrito3.html('');
        option = {
            url: '/cargardistrito/'+ cmbid_departamento3 + '/' + cmbid_provincia3,
            type: 'GET',
            dataType: 'json',
            data: {}
        };
        $.ajax(option).done(function (data) {  
            cargarComboDestino($cmbid_distrito3, data);
            $cmbid_distrito3.val(null).trigger("change");                                           
        });
});  

$("#divcontacto").hide();
    
function getTipoContacto(){
    var tipo_contacto        = $('#tipo_contacto').val();
    if(tipo_contacto=='7'){
        $("#divcontacto").show();
    }
    else{
        $("#divcontacto").hide();   
    }
    
}

/************************Laboratorio**************************************************/
function AddExamenLaboratorio(){
    var newRow = "";
    var ind = $('#tblExamenLaboratorio tbody tr').length;
    
    if(ind > 0){
        $('.cmbMedicamento').each(function(){
            var ind_tmp = $(this).attr("ind");
            if(ind_tmp => ind){
                ind=Number(ind_tmp)+1;
            }
        });

        fila_medicamentos=$('#tblExamenLaboratorio tbody').children('tr');
        rowIndex=$('#hidden_rowIndex').val();
        var idval = ind - 1;
        fila_medicamento=fila_medicamentos[idval];
    }
    
    var item_tipo_muestra = '';
    item_tipo_muestra+='<option value="0">--Seleccionar--</option>';
    item_tipo_muestra+='<option value="1">Hisopado Nasofaringeo</option>';
    item_tipo_muestra+='<option value="2">Hisopado Orofaringeo</option>';
    item_tipo_muestra+='<option value="3">Tractorespiratorio</option>';

    var item_tipo_prueba = '';
    item_tipo_prueba+='<option value="0">--Seleccionar--</option>';
    item_tipo_prueba+='<option value="1">Prueba Molecular</option>';
    item_tipo_prueba+='<option value="2">Prueba Antigena</option>';
    item_tipo_prueba+='<option value="3">Prueba Serologica</option>';
    item_tipo_prueba+='<option value="4">Prueba Radiografico</option>';
    item_tipo_prueba+='<option value="5">Prueba Tomografica</option>';
    item_tipo_prueba+='<option value="6">Sin Informacion</option>';

    var item_resultado = '';
    item_resultado+='<option value="0">--Seleccionar--</option>';
    item_resultado+='<option value="1">Positivo</option>';
    item_resultado+='<option value="2">Negativo</option>';
    

    var item_minsa = '';
    item_minsa+='<option value="0">--Seleccionar--</option>';
    item_minsa+='<option value="1">SI</option>';
    item_minsa+='<option value="2">NO</option>';

    newRow +='<tr>';
    newRow +='<td><input type="date" data-toggle="tooltip" data-placement="top" title="Ingresar fecha" name="fecha_muestra[]" tabindex="8" required="" id="fecha_muestra'+ind+'" class="input-sm" style="margin-left:4px; text-align:left" />';
    newRow +='<input type="hidden" class="form-control fecha_muestra typeahead tt-query" id="id_fecha_muestra'+ind+'" name="id_fecha_muestra[]" value=""></td>';
    newRow +='<td><select class="form-control id_item_tipo_muestra" id="cmbTipoMuestra'+ind+'" name="id_item_tipo_muestra[]" style="margin:0 20px;width:150px">'+item_tipo_muestra+'</select></td>';
    newRow +='<td><select class="form-control id_item_tipo_prueba" id="cmbTipoPrueba'+ind+'" name="id_item_tipo_prueba[]" style="margin:0 20px;width:150px">'+item_tipo_prueba+'</select></td>';
    newRow +='<td><select class="form-control id_item_resultado" id="cmbResultado'+ind+'" name="id_item_resultado[]" style="margin:0 20px;width:150px">'+item_resultado+'</select></td>';
    newRow +='<td><input type="date" data-toggle="tooltip" data-placement="top" title="Ingresar fecha" name="id_fecha_resultado[]" tabindex="8" required="" id="id_fecha_resultado'+ind+'" class="input-sm" style="margin-left:4px; text-align:left" />';
    newRow +='<td><select class="form-control id_item_minsa" id="cmbMinsa'+ind+'" name="id_item_minsa[]" style="margin:0 20px;width:150px">'+item_minsa+'</select></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';


    $('#tblExamenLaboratorio tbody').append(newRow);
    
    $("#fecha_muestra"+ind).autocomplete({
        minLength: 1,
        delay : 400,
        source: function(request, response) {
            $.ajax({
                url: '../obtener_diagnostico/' + request.term,
                dataType: "json",
                success: function(data)  {
                    response(data);
                }                   
            })
    
    
        },select:  function(e, ui) {
            var item_tipo_muestra = ui.item.id;
            $("#item_tipo_muestra"+ind).val(item_tipo_muestra);
            $("#item_tipo_muestra"+ind).prop("readonly",true);
        }
    });
    
}

/********************Certificado***********************************/
function AddCertificado(){
    var newRow = "";
    var ind = $('#tblCertificado tbody tr').length;
    
    if(ind > 0){
        $('.cmbMedicamento').each(function(){
            var ind_tmp = $(this).attr("ind");
            if(ind_tmp => ind){
                ind=Number(ind_tmp)+1;
            }
        });

        fila_medicamentos=$('#tblCertificado tbody').children('tr');
        rowIndex=$('#hidden_rowIndex').val();
        var idval = ind - 1;
        fila_medicamento=fila_medicamentos[idval];
    }
    
    var item_tipo_certificado= '';
    item_tipo_certificado+='<option value="0">--Seleccionar--</option>';
    item_tipo_certificado+='<option value="1">Nota Informativa</option>';
    item_tipo_certificado+='<option value="2">Certificado DEfuncion</option>';

    newRow +='<tr>';
    newRow +='<td><select class="form-control id_item_tipo_certificado" id="cmbTipoCertificado'+ind+'" name="id_item_tipo_certificado[]" style="margin:0 20px;width:150px">'+item_tipo_certificado+'</select></td>';
    newRow +='<td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar nro" name="nro_doc[]" tabindex="8" required="" id="nro_doc'+ind+'" class="input-sm" style="margin-left:4px; text-align:left" />';
    newRow +='<td><input type="date" data-toggle="tooltip" data-placement="top" title="Ingresar fecha" name="id_fecha_doc[]" tabindex="8" required="" id="id_fecha_doc'+ind+'" class="input-sm" style="margin-left:4px; text-align:left" />';
    newRow +='<input type="hidden" class="form-control fecha_muestra typeahead tt-query" id="id_fecha_muestra'+ind+'" name="id_fecha_muestra[]" value=""></td>';
    newRow +='<td><input type="file" class="form-control photo typeahead tt-query" id="id_photo'+ind+'" name="id_photo[]" value="" accept="tipo_de_archivo|image/*|media_type"></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';


    $('#tblCertificado tbody').append(newRow);
    
    $("#fecha_muestra"+ind).autocomplete({
        minLength: 1,
        delay : 400,
        source: function(request, response) {
            $.ajax({
                url: '../obtener_diagnostico/' + request.term,
                dataType: "json",
                success: function(data)  {
                    response(data);
                }                   
            })
    
    
        },select:  function(e, ui) {
            var item_tipo_muestra = ui.item.id;
            $("#item_tipo_muestra"+ind).val(item_tipo_muestra);
            $("#item_tipo_muestra"+ind).prop("readonly",true);
        }
    });
    
}

</script>

<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    @yield('scripts')
</body>
</html>