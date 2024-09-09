<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>VIGILANCIA EPIDEMIOLOGICA COVID-19</title>
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

.modal-dialog {
    width: 90%;
  }
          
.title-dialog {
  font-size: 18px;
  font-family:Arial, Helvetica, sans-serif;
}
    
.ui-autocomplete {
  position: absolute;
  top: 56%;
  left: 24%;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 160px;
  padding: 5px 7px;
  margin: 2px 0 0;
  list-style: none;
  font-size: 15px;
  font-family:Arial, Helvetica, sans-serif;
  text-align: left;
  background-color: #ffffff;
  border: 1px solid #cccccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  background-clip: padding-box;
}

.ui-autocomplete > li > div {
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: normal;
  line-height: 1.42857143;
  color: #333333;
  white-space: nowrap;
}

.ui-state-hover,
.ui-state-active,
.ui-state-focus {
  text-decoration: none;
  color: #FFFFFF!important;
  background: #1d71b8!important;
  cursor: pointer;
}

.ui-helper-hidden-accessible {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
}

input[readonly]{
    background-color:#eeeeee;
    text-align: center
}


span:focus,
textarea:focus,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
.uneditable-input:focus{   
  border-color: #2196F3;
  box-shadow: 0 1px 1px #2196F3 inset, 0 0 8px #2196F3;
  outline: 0 none;
}

/*.fc-event-container{margin:20px!important}*/
.fc-day-grid-event{/*width:150px;*/margin:10px;text-align:center;margin-top:40px;/*background:#5cb85c*/background:transparent;color:#009966}
.fc-day-grid-event :hover{color:#009966}
.fc-content{padding:5px!important;}
.fc-title{text-align:center;font-size:12px}
/*
.select2-container:focus {
    border-color: rgba(126, 239, 104, 0.8);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
    outline: 0 none;
}
*/
/*
.select2-container-active .select2-choice {
  border: 1px solid #999;
  box-shadow: inset 0 2px 3px 0 rgba(0,0,0,.06);
  border-radius: 4px;
} 
 
.select2-container-active.select2-dropdown-open .select2-choice {
  border-bottom: 2px solid #ccc;
  border-left: 1px solid #ccc;
  border-right: 1px solid #ccc;
  border-top: 1px solid #ccc;
  box-shadow: none;
}
*/



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
                <b>COVID-19</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Menu</span>
                </a>
                <a href="#" class="logo2">
                    <b>VIGILANCIA EPIDEMIOLOGICA COVID-19 - DIRSAPOL</b>
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
            <strong>Copyright © 2021 <a href="#"> DIRSAPOL </a>.</strong> Todos los derechos reservados.
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

    $('#addDiagnostico2').on('click',function(){
        AddDiagnostico2();
    });

    $('#addDiagnostico3').on('click',function(){
        AddDiagnostico3();
    });
    
    $('#tblDiagnostico tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });

    $('#tblDiagnostico2 tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });

    $('#tblDiagnostico3 tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });

    AddDiagnostico();

    AddDiagnostico2();

    AddDiagnostico3();

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

    //AddCertificado();

    $('#addVacunas').on('click',function(){
        AddVacunas();
    });

    AddVacunas();

    $('#tblVacunas tbody').on('click', 'button.deleteFila', function () {
        var obj = $(this);
        obj.parent().parent().remove();
    });
    
});
    

function getPersonalByDni() {
    var nro_doc = $('#dni').val();        
    var valor = '';
    var nacion = '';
    
    $.ajax({
        url: '/buscar_personal_dni_dirrehum/' + nro_doc,
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
                $('#situacion').val("");
                $('#unidad').val("");
                $('#id_categoria').val(0);
                $("#id_categoria").select2({max_selected_options:4});
                $('#peso').val("");
                $('#foto').val("");
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
                $('#edad').val("");
                $('#id_categoria').val(0);
                $("#id_categoria").select2({max_selected_options:4});
                $('#id_departamento').val(0);
                $("#id_departamento").select2({max_selected_options:4});
                $('#id_provincia').val(0);
                $("#id_provincia").select2({max_selected_options:4});
                $('#id_distrito').val(0);
                $("#id_distrito").select2({max_selected_options:4});                
                return false;
            }
            else
            {
                parentesco=result.beneficiario.parentesco;
                situacion=result.beneficiario.situacion;
                $('#parentesco').val(result.beneficiario.parentesco);
                $('#name').val(result.beneficiario.nomafiliado);
                $('#paterno').val(result.beneficiario.apepatafiliado);
                $('#materno').val(result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado);
                $('#cip').val(result.beneficiario.cip);
                $('#grado').val(result.beneficiario.grado);
                $('#fecha_nacimiento').val(result.beneficiario.fecnacafiliado);
                $('#edad').val(result.beneficiario.edadafiliado);
                $('#situacion').val(result.beneficiario.situacion);
                $('#unidad').val(result.beneficiario.unidad);
                $('#domicilio').val(result.beneficiario.domicilio);
                $('#talla').val(result.beneficiario.estatura);
                $('#foto').val(result.beneficiario.foto);
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

                if(situacion=='' && parentesco == ''){
                    $("#id_categoria").val(7);
                    $("#id_categoria").select2({max_selected_options:4});
                }
                else{
                    if(parentesco != 'TITULAR'){
                        $("#id_categoria").val(8);
                        $("#id_categoria").select2({max_selected_options:4});
                    }
                    else
                    {
                        $("#id_categoria").val(0);
                        $("#id_categoria").select2({max_selected_options:4});
                    }
                }
            }
        }
    });
}

$cmbid_departamento = $("#frm_aislamientos").find("#id_departamento");
$cmbid_provincia = $("#frm_aislamientos").find("#id_provincia");
$cmbid_distrito = $("#frm_aislamientos").find("#id_distrito");    
$cmbid_departamento2 = $("#frm_aislamientos").find("#id_departamento2");
$cmbid_provincia2 = $("#frm_aislamientos").find("#id_provincia2");
$cmbid_distrito2 = $("#frm_aislamientos").find("#id_distrito2");   

$cmbVacuna = $("#frm_aislamientos").find("#nombre_vacuna");
$cmbAdy = $("#frm_aislamientos").find("#adyunta");
$cmbDosis = $("#frm_aislamientos").find("#dosis");
$cmbVia = $("#frm_aislamientos").find("#via");
$cmbSitio = $("#frm_aislamientos").find("#sitio");

$cmbid_muestra = $("#frm_aislamientos").find("#muestra");
$cmbid_prueba = $("#frm_aislamientos").find("#prueba");
$cmbid_resultado = $("#frm_aislamientos").find("#resultado");

$cmbid_prueba.change(function () {     
    $this = $(this); 
    cmbid_prueba = $cmbid_prueba.val();
    $cmbid_resultado.html('');
    option = {
        url: '/cargarresultados/' + cmbid_prueba,
        type: 'GET',
        dataType: 'json',
        data: {}
    };
    $.ajax(option).done(function (data) {  
        cargarComboDestino($cmbid_resultado, data);
        $cmbid_resultado.val(null).trigger("change");                                           
    });
});
    
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

$("#divmenor").hide();
$("#divetnia").hide();
$("#divetnia2").show();
$("#divmigrante").hide();
$("#divmigrante2").show();
$("#divnacion").hide();
$("#divnacion2").show();
$("#divsintomas").hide();
$("#divcontacto_directo").hide();
$("#divcontacto_directo2").show();
$("#divgestacion").hide();
$("#divgestacion_directo2").show();
$("#divhosp").hide();
$("#divhosp2").show();
$("#divreferido").hide();
$("#divreferido2").show();
$("#divreinfeccion").hide();
$("#divreinfeccion2").show();
$("#divlfallecimiento").hide();
$("#divotrolugarf").hide();
$("#divesaviprevio").hide();
$("#divesaviprevio2").show();
$("#divtransferido").hide();
$("#divtransferido2").show();
$("#divcovid_directo").hide();
$("#divcovid_directo2").show();
$("#divtipocaso").hide();
$("#divtipocaso2").show();

function getLugarFallecimiento(){
    var lfallecimiento = $('#lugar_defuncion').val();

    if(lfallecimiento=='1'){
        $("#divlfallecimiento").show();
        $("#divotrolugarf").hide();
    }
    else{
        if(lfallecimiento=='6'){
            $("#divotrolugarf").show();
            $("#divlfallecimiento").hide();
        }
        else
        {
            $("#divlfallecimiento").hide();
            $("#divotrolugarf").hide();
        }
    }
}

function getTipoCaso(){
    var tipocaso = $('#id_tipo_caso').val();

    if(tipocaso=='1'){
        $("#divtipocaso").show();
    }
    else{
        $("#divtipocaso").hide();
    }
}

function getTipoCaso2(){
    var tipocaso = $('#id_tipo_caso').val();

    if(tipocaso=='1'){
        $("#divtipocaso").show();
        $("#divtipocaso2").show();
    }
    else{
        $("#divtipocaso").hide();
        $("#divtipocaso2").hide();
    }
}

function getEsaviPrevio(){
    var previo = $('#esavi_previo').val();

    if(previo=='1'){
        $("#divesaviprevio").show();
    }
    else{
        $("#divesaviprevio").hide();
    }
}

function getEsaviPrevio2(){
    var previo = $('#esavi_previo').val();

    if(previo=='1'){
        $("#divesaviprevio").show();
        $("#divesaviprevio2").show();
    }
    else{
        $("#divesaviprevio").hide();
        $("#divesaviprevio2").hide();
    }
}

function getTransferido(){
    var transferido = $('#transferido').val();

    if(transferido=='1'){
        $("#divtransferido").show();
    }
    else{
        $("#divtransferido").hide();
    }
}

function getTransferido2(){
    var transferido = $('#transferido').val();

    if(transferido=='1'){
        $("#divtransferido").show();
        $("#divtransferido2").show();
    }
    else{
        $("#divtransferido").hide();
        $("#divtransferido2").hide();
    }
}

function getLugarIpress(){
    var servicio_hospitalizacion        = $('#servicio_hospitalizacion').val();

    if(servicio_hospitalizacion=='6'){
        $("#divhosp").show();
    }
    else{
        $("#divhosp").hide();
    }
}

function getLugarIpress2(){
    var servicio_hospitalizacion        = $('#servicio_hospitalizacion').val();

    if(servicio_hospitalizacion=='7'){
        $("#divhosp").show();
        $("#divhosp2").show();
    }
    else{
        $("#divhosp").hide();
        $("#divhosp2").hide();
    }
}



function getOtraRaza(){
    var etnia        = $('#etnia').val();

    if(etnia=='6'){
        $("#divetnia").show();
    }
    else{
        $("#divetnia").hide();
    }
}

function getOtraRaza2(){
    var etnia        = $('#etnia').val();

    if(etnia=='6'){
        $("#divetnia").show();
        $("#divetnia2").show();
    }
    else{
        $("#divetnia").hide();
        $("#divetnia2").hide();
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

function getOtraNacionalidad2(){
    var nacionalidad        = $('#nacionalidad').val();
    if(nacionalidad=='2'){
        $("#divnacion").show();
        $("#divnacion2").show();
    }
    else{
        $("#divnacion").hide();
        $("#divnacion2").hide();
    }
}

function getReinfeccion(){
    var caso_reinfeccion        = $('#caso_reinfeccion').val();

    if(caso_reinfeccion=='SI'){
        $("#divreinfeccion").show();
    }
    else{
        $("#divreinfeccion").hide();
    }
}

function getReinfeccion2(){
    var caso_reinfeccion        = $('#caso_reinfeccion').val();

    if(caso_reinfeccion=='SI'){
        $("#divreinfeccion").show();
        $("#divreinfeccion2").show();
    }
    else{
        $("#divreinfeccion").hide();
        $("#divreinfeccion2").hide();
    }
}
function getOtroMigrante(){
    var migrante = $('#migrante').val();
    //alert(migrante);
    if(migrante=='SI'){
        $("#divmigrante").show();
    }
    else{
        $("#divmigrante").hide();
    }
}

function getOtroMigrante2(){
    var migrante = $('#migrante').val();
    //alert(migrante);
    if(migrante=='SI'){
        $("#divmigrante").show();
        $("#divmigrante2").show();
    }
    else{
        $("#divmigrante").hide();
        $("#divmigrante2").hide();
    }
}


function getGestante(){
    var gestante = $('#gestante').val();
    //alert(migrante);
    if(gestante=='1'){
        $("#divgestacion").show();
    }
    else{
        $("#divgestacion").hide();
    }
}
function getGestante2(){
    var gestante = $('#gestante').val();
    //alert(migrante);
    if(gestante=='1'){
        $("#divgestacion").show();
        $("#divgestacion_directo2").show();
    }
    else{
        $("#divgestacion").hide();
        $("#divgestacion_directo2").hide();
    }
}

function getReferido(){
    var referido = $('#referido').val();
    //alert(migrante);
    if(referido=='1'){
        $("#divreferido").show();
    }
    else{
        $("#divreferido").hide();
    }
}

function getReferido2(){
    var referido = $('#referido').val();
    //alert(migrante);
    if(referido=='1'){
        $("#divreferido").show();
        $("#divreferido2").show();
    }
    else{
        $("#divreferido").hide();
        $("#divreferido2").hide();
    }
}

function getTutor(){
    var menor = $('#menor').val();
    //alert(migrante);
    if(menor=='SI'){
        $("#divmenor").show();
    }
    else{
        $("#divmenor").hide();
    }
}

function getCovid(){
    var covid = $('#covid').val();
    if(covid==1){
        $("#divcovid").show();
    }
    else{
        $("#divcovid").hide();
    }
}

function getCovid2(){
    var covid = $('#covid').val();
    
    if(covid==1){
        $("#divcovid_directo2").show();
        $("#divcovid").show();
    }
    else{
        $("#divcovid_directo2").hide();
        $("#divcovid").hide();
    }
}



function getOtroContacto(){
    var contacto_directo        = $('#contacto_directo').val();
    if(contacto_directo=='SI'){
        $("#divcontacto_directo").show();
    }
    else{
        $("#divcontacto_directo").hide();
    }
}

function getOtroContacto2(){
    var contacto_directo        = $('#contacto_directo').val();
    if(contacto_directo=='SI'){
        $("#divcontacto_directo").show();
        $("#divcontacto_directo2").show();
    }
    else{
        $("#divcontacto_directo").hide();
        $("#divcontacto_directo2").hide();
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
    
    var item_tipo_diagnostico = '';
    item_tipo_diagnostico+='<option value="0">--Seleccionar--</option>';
    item_tipo_diagnostico+='<option value="1">PRESUNTIVO</option>';
    item_tipo_diagnostico+='<option value="2">DEFINITIVO</option>';
    item_tipo_diagnostico+='<option value="3">REITERATIVO</option>';
    newRow +='<tr>';
    newRow +='<td><input required="required" type="text" data-toggle="tooltip" data-placement="top" title="Ingresar el diagnostico" name="nombre_diagnostico[]" tabindex="8" id="nombre_diagnostico'+ind+'" class="input-sm" style="margin-left:4px; width:100%; text-align:left" />';
    newRow +='<input type="hidden" class="form-control id_diagnostico typeahead tt-query" id="id_diagnostico'+ind+'" name="id_diagnostico[]" value=""></td>';
    newRow +='<td><select required="required" class="form-control id_tipo_diagnostico" id="cmbTipoDiagnostico'+ind+'" name="id_tipo_diagnostico[]" style="margin:0 20px;width:150px">'+item_tipo_diagnostico+'</select></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';
    $('#tblDiagnostico tbody').append(newRow);
    
    $("#nombre_diagnostico"+ind).autocomplete({
        minLength: 1,
        delay : 400,
        source: function(request, response) {
            $.ajax({
                url: '../../../obtener_diagnostico/' + request.term,
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
    
    /*$("#nombre_diagnostico"+ind).on('blur', function() {
        var id_diagnostico = $("#id_diagnostico"+ind).val();
        if(id_diagnostico == ""){
            bootbox.alert("Falta ingresar el diagnostico en esta fila");
            $("#nombre_diagnostico"+ind).val("");
            return false;
        }
    });
    */
    
}  

function AddDiagnostico2(){
    var newRow = "";
    var ind = $('#tblDiagnostico2 tbody tr').length;
    
    if(ind > 0){
        $('.cmbMedicamento').each(function(){
            var ind_tmp = $(this).attr("ind");
            if(ind_tmp => ind){
                ind=Number(ind_tmp)+1;
            }
        });
                    
        fila_medicamentos=$('#tblDiagnostico2 tbody').children('tr');
        rowIndex=$('#hidden_rowIndex').val();
        var idval = ind - 1;
        fila_medicamento=fila_medicamentos[idval];
        
    }
    
    var item_tipo_diagnostico = '';
    item_tipo_diagnostico+='<option value="0">--Seleccionar--</option>';
    item_tipo_diagnostico+='<option value="1">PRESUNTIVO</option>';
    item_tipo_diagnostico+='<option value="2">DEFINITIVO</option>';
    item_tipo_diagnostico+='<option value="3">REITERATIVO</option>';
    newRow +='<tr>';
    newRow +='<td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar el diagnostico" name="nombre_diagnostico2[]" tabindex="8" id="nombre_diagnostico2'+ind+'" class="input-sm" style="margin-left:4px; width:100%; text-align:left" />';
    newRow +='<input type="hidden" class="form-control id_diagnostico2 typeahead tt-query" id="id_diagnostico2'+ind+'" name="id_diagnostico2[]" value=""></td>';
    newRow +='<td><select class="form-control id_tipo_diagnostico2" id="cmbTipoDiagnostico2'+ind+'" name="id_tipo_diagnostico2[]" style="margin:0 20px;width:150px">'+item_tipo_diagnostico+'</select></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';
    $('#tblDiagnostico2 tbody').append(newRow);
    
    $("#nombre_diagnostico2"+ind).autocomplete({
        minLength: 1,
        delay : 400,
        source: function(request, response) {
            $.ajax({
                url: '../../../obtener_diagnostico/' + request.term,
                dataType: "json",
                success: function(data)  {
                    response(data);
                }                   
            })
    
        },select:  function(e, ui) {
            var id_diagnostico2 = ui.item.id;
            $("#id_diagnostico2"+ind).val(id_diagnostico2);
            $("#nombre_diagnostico2"+ind).prop("readonly",true);
        }
    });
    
    /*$("#nombre_diagnostico2"+ind).on('blur', function() {
        var id_diagnostico = $("#id_diagnostico2"+ind).val();
        if(id_diagnostico == ""){
            bootbox.alert("Falta ingresar el diagnostico en esta fila");
            $("#nombre_diagnostico2"+ind).val("");
            return false;
        }
    });
    */
    
}

/**********Hospitalizacion******************/
function AddDiagnostico3(){
    var newRow = "";
    var ind = $('#tblDiagnostico3 tbody tr').length;
    
    if(ind > 0){
        $('.cmbMedicamento').each(function(){
            var ind_tmp = $(this).attr("ind");
            if(ind_tmp => ind){
                ind=Number(ind_tmp)+1;
            }
        });
                    
        fila_medicamentos=$('#tblDiagnostico3 tbody').children('tr');
        rowIndex=$('#hidden_rowIndex').val();
        var idval = ind - 1;
        fila_medicamento=fila_medicamentos[idval];
        
    }
    
    var item_tipo_diagnostico = '';
    item_tipo_diagnostico+='<option value="0">--Seleccionar--</option>';
    item_tipo_diagnostico+='<option value="1">DIAGNOSTICO BASICO</option>';
    item_tipo_diagnostico+='<option value="2">DIAGNOSTICO INTERMEDIO</option>';
    item_tipo_diagnostico+='<option value="3">DIAGNOSTICO DEFINITIVO</option>';
    newRow +='<tr>';
    newRow +='<td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar el diagnostico" name="nombre_diagnostico3[]" tabindex="8" id="nombre_diagnostico3'+ind+'" class="input-sm" style="margin-left:4px; width:100%; text-align:left" />';
    newRow +='<input type="hidden" class="form-control id_diagnostico typeahead tt-query" id="id_diagnostico3'+ind+'" name="id_diagnostico3[]" value=""></td>';
    newRow +='<td><select class="form-control id_tipo_diagnostico3" id="cmbTipoDiagnostico'+ind+'" name="id_tipo_diagnostico3[]" style="margin:0 20px;width:150px">'+item_tipo_diagnostico+'</select></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';
    $('#tblDiagnostico3 tbody').append(newRow);
    
    $("#nombre_diagnostico3"+ind).autocomplete({
        minLength: 1,
        delay : 400,
        source: function(request, response) {
            $.ajax({
                url: '../../../obtener_diagnostico/' + request.term,
                dataType: "json",
                success: function(data)  {
                    response(data);
                }                   
            })
    
        },select:  function(e, ui) {
            var id_diagnostico3 = ui.item.id;
            $("#id_diagnostico3"+ind).val(id_diagnostico3);
            $("#nombre_diagnostico3"+ind).prop("readonly",true);
        }
    });
    
    /*$("#nombre_diagnostico"+ind).on('blur', function() {
        var id_diagnostico = $("#id_diagnostico"+ind).val();
        if(id_diagnostico == ""){
            bootbox.alert("Falta ingresar el diagnostico en esta fila");
            $("#nombre_diagnostico"+ind).val("");
            return false;
        }
    });
    */
    
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
$("#divalta2").show();
$("#divdescripcion").hide();
$("#divdescripcion2").show();
$("#divdefuncion").hide();
    
function getEvolucion(){
    var evolucion        = $('#evolucion').val();
    
    switch(evolucion){
        case '1' : $("#divdescripcion").show(); $("#divdescripcion2").show(); $("#divalta").hide();$("#divalta2").hide();$("#divdefuncion").hide();break;
        case '2' : $("#divdescripcion").show();$("#divdescripcion2").show(); $("#divalta").hide();$("#divalta2").hide();$("#divdefuncion").hide();break;
        case '3' : $("#divdefuncion").show(); $("#divdescripcion").hide(); $("#divdescripcion2").hide();$("#divalta").hide(); $("#divalta2").hide();  break;
        case '4' : $("#divalta").show(); $("#divalta2").show(); $("#divdescripcion").show(); $("#divdescripcion2").show();$("#divdefuncion").hide(); break;
        case '5' : $("#divalta").show(); $("#divalta2").show(); $("#divdescripcion").show(); $("#divdescripcion2").show();$("#divdefuncion").hide(); break;
        case '6' : $("#divalta").show(); $("#divalta2").show(); $("#divdescripcion").show(); $("#divdescripcion2").show();$("#divdefuncion").hide(); break;
        case '7' : $("#divalta").show(); $("#divalta2").show(); $("#divdescripcion").show(); $("#divdescripcion2").show();$("#divdefuncion").hide(); break;
        case '8' : $("#divalta").show(); $("#divalta2").show(); $("#divdescripcion").show(); $("#divdescripcion2").show();$("#divdefuncion").hide(); break;
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
        url: '/buscar_personal_dni_dirrehum2/' + nro_doc,
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
function AddVacunas(){
    var newRow = "";
    var ind = $('#tblVacunas tbody tr').length;
    
    if(ind > 0){
        $('.cmbMedicamento').each(function(){
            var ind_tmp = $(this).attr("ind");
            if(ind_tmp => ind){
                ind=Number(ind_tmp)+1;
            }
        });

        fila_medicamentos=$('#tblVacunas tbody').children('tr');
        rowIndex=$('#hidden_rowIndex').val();
        var idval = ind - 1;
        fila_medicamento=fila_medicamentos[idval];
    }
    
    var item_nombre_vacuna = '';
    item_nombre_vacuna+='<option value="0">--Seleccionar--</option>';
    item_nombre_vacuna+='<option value="BCG">BCG</option>';item_nombre_vacuna+='<option value="APO">APO</option>';item_nombre_vacuna+='<option value="Hepatitis">Hepatitis</option>';
    item_nombre_vacuna+='<option value="Hib">Hib</option>';item_nombre_vacuna+='<option value="Pentavalente">Pentavalente</option>';item_nombre_vacuna+='<option value="SPR">SPR</option>';
    item_nombre_vacuna+='<option value="Fiebre Amarilla">Fiebre Amarilla</option>';item_nombre_vacuna+='<option value="SR">SR</option>';item_nombre_vacuna+='<option value="DT">DT</option>';
    item_nombre_vacuna+='<option value="Influenza estacional">Influenza estacional</option>';item_nombre_vacuna+='<option value="Anti-sarampion">Anti-sarampion</option>';item_nombre_vacuna+='<option value="Contra neumococo">Contra neumococo</option>';
    item_nombre_vacuna+='<option value="Contra rotavirus">Contra rotavirus</option>';item_nombre_vacuna+='<option value="Contra VPH">Contra VPH</option>';item_nombre_vacuna+='<option value="IPV">IPV</option>';
    item_nombre_vacuna+='<option value="Contra varicela">Contra varicela</option>';item_nombre_vacuna+='<option value="dTpa">dTpa</option>';item_nombre_vacuna+='<option value="Anti COVID-19">Anti COVID-19</option>';
    item_nombre_vacuna+='<option value="Otro">Otro</option>';

    var item_ady = '';
    item_ady+='<option value="0"> Elige </option>';
    item_ady+='<option value="SI">SI</option>';
    item_ady+='<option value="NO">NO</option>';

    var item_dosis = '';
    item_dosis+='<option value="0"> Elige </option>';
    item_dosis+='<option value="Primera">Primera</option>';
    item_dosis+='<option value="Segunda">Segunda</option>';
    item_dosis+='<option value="Tercera">Tercera</option>';
    item_dosis+='<option value="Adicional">Adicional</option>';
    item_dosis+='<option value="Unica">Unica</option>';
    item_dosis+='<option value="Refuerzo">Refuerzo</option>';
    
    var item_via = '';
    item_via+='<option value="0"> Elige </option>';
    item_via+='<option value="Oral">Oral</option>';
    item_via+='<option value="Intradermica">Intradermica</option>';
    item_via+='<option value="Subcutanea">Subcutanea</option>';
    item_via+='<option value="Intramuscular">Intramuscular</option>';
    
    var item_sitio='';
    item_sitio+='<option value="0">--Seleccionar--</option>';
    item_sitio+='<option value="Hombro derecho">Hombro derecho</option>';
    item_sitio+='<option value="Hombro izquierdo">Hombro izquierdo</option>';
    item_sitio+='<option value="Brazo derecho">Brazo derecho</option>';
    item_sitio+='<option value="Brazo izquierdo">Brazo izquierdo</option>';
    item_sitio+='<option value="Vasto externo de muslo derecho">Vasto externo de muslo derecho</option>';
    item_sitio+='<option value="Vasto externo de muslo derechoizquierdo">Vasto externo de muslo derechoizquierdo</option>';
    item_sitio+='<option value="Oral">Oral</option>';

    newRow +='<tr>';
    newRow +='<input type="hidden" class="form-control fecha_vacunacion typeahead tt-query" id="id_fecha_vacunacion'+ind+'" name="id_fecha_vacunacion[]" value=""></td>';
    newRow +='<td><p><b>Nombre de Vacuna</b></p><select class="form-control nombre_vacuna" id="cmbVacuna'+ind+'" name="nombre_vacuna[]" style="width:200px">'+item_nombre_vacuna+'</select><br/><p><b>Fecha de Vacunacion</b></p><input type="date" data-toggle="tooltip" data-placement="top" title="Fecha Vacunacion" name="fecha_vacunacion[]" tabindex="8" required="" id="fecha_vacunacion'+ind+'" class="input-sm" style="width:150px" text-align:left" /><br/><br/></td>';
    newRow +='<td><p><b>Adyuvante</b></p><select class="form-control adyunta" id="cmbAdy'+ind+'" name="adyunta[]" style="width:150px">'+item_ady+'</select><br/><p><b>EESS que vacuno</b></p><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar de Establecimiento" name="nombre_establecimiento[]" tabindex="8" required="" id="nombre_establecimiento'+ind+'" class="input-sm" style="width:150px" /><br/><br/></td>';
    newRow +='<td><p><b>Dosis</b></p><select class="form-control dosis" id="cmbDosis'+ind+'" name="dosis[]" style="width:150px">'+item_dosis+'</select><br/><p><b>Fabricante</b></p><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar Fabricante" name="fabricante[]" tabindex="8" required="" id="fabricante'+ind+'" class="input-sm" style="width:150px" /><br/><br/></td>';
    newRow +='<td><p><b>Via</b></p><select class="form-control via" id="cmbVia'+ind+'" name="via[]" style="width:150px">'+item_via+'</select><br/><p><b>Lote</b></p><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar Lote" name="lote[]" tabindex="8" required="" id="lote'+ind+'" class="input-sm" style="width:150px" /><br/><br/></td>';
    newRow +='<td><p><b>Sitio</b></p><select class="form-control sitio" id="cmbSitio'+ind+'" name="sitio[]" style="width:250px">'+item_sitio+'</select><br/><p><b>Fecha de Expiracion</b<p><br/><input type="date" data-toggle="tooltip" data-placement="top" title="Fecha Expiracion" name="fecha_expiracion[]" tabindex="8" required="" id="fecha_expiracion'+ind+'" class="input-sm" style="width:150px" /><br/><br/></td>';
    
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';

    $('#tblVacunas tbody').append(newRow);
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
    item_tipo_muestra+='<option value="4">Sangre</option>';
    item_tipo_muestra+='<option value="5">Sin Informacion</option>';

    var item_tipo_prueba = '';
    item_tipo_prueba+='<option value="0">--Seleccionar--</option>';
    item_tipo_prueba+='<option value="1">Prueba Molecular</option>';
    item_tipo_prueba+='<option value="2">Prueba Antigena</option>';
    item_tipo_prueba+='<option value="3">Prueba Serologica</option>';
    item_tipo_prueba+='<option value="4">Prueba Rápida</option>';
    item_tipo_prueba+='<option value="5">Sin Informacion</option>';

    var item_resultado = '';
    item_resultado+='<option value="0">--Seleccionar--</option>';
    item_resultado+='<option value="1">Positivo</option>';
    item_resultado+='<option value="2">Negativo</option>';
    item_resultado+='<option value="3">Sin Informacion</option>';
    

    var item_minsa = '';
    item_minsa+='<option value="0">--Seleccionar--</option>';
    item_minsa+='<option value="1">SI</option>';
    item_minsa+='<option value="2">NO</option>';
    item_minsa+='<option value="3">NO</option>';

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
    item_tipo_certificado+='<option value="2">Certificado Defuncion</option>';

    newRow +='<tr>';
    newRow +='<td><select class="form-control id_tipo_certificado" id="cmbTipoCertificado'+ind+'" name="id_tipo_certificado[]" style="margin:0 20px;width:150px">'+item_tipo_certificado+'</select></td>';
    newRow +='<td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar nro" name="nro_doc[]" tabindex="8" id="nro_doc'+ind+'" class="input-sm" style="margin-left:4px; text-align:left" />';
    newRow +='<td><input type="date" data-toggle="tooltip" data-placement="top" title="Ingresar fecha" name="id_fecha_doc[]" tabindex="8" id="id_fecha_doc'+ind+'" class="input-sm" style="margin-left:4px; text-align:left" />';
    newRow +='<td><input type="file" class="form-control photo typeahead tt-query" id="photo'+ind+'" name="photo[]" value="" accept="tipo_de_archivo|image/*|media_type"></td>';
    newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
    newRow +='</tr>';


    $('#tblCertificado tbody').append(newRow);
    
}

</script>

<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    @yield('scripts')
</body>
</html>