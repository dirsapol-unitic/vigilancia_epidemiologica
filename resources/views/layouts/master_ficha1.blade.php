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
    <body class="skin-blue sidebar-mini">
@else
    <body class="skin-blue sidebar-mini sidebar-collapse">
@endif    
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            
            <script src="{{asset('js/highcharts.js')}}"></script>
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
                $('#cip}').val("");
                $('#grado').val("");
                $('#fecha_nacimiento').val("");
                $('#sexo').val("");
                $('#parentesco').val("");
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
            $('#sexo').val(result.beneficiario.nomsexo);
            $('#edad').val(result.beneficiario.edadafiliado);
            $('#situacion').val(result.beneficiario.situacion);
            
            nacion=result.beneficiario.nompaisdelafiliado;
            if(nacion=='PER'){
                $("#nacionalidad").val(1);
                $("#migrante").val(2);
            }
            else{
                $("#nacionalidad").val(2);
                $("#migrante").val(1);
            }
            $("#nacionalidad").select2({max_selected_options:4});
            $("#migrante").select2({max_selected_options:4});
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

    $("#divetnia").hide();
    $("#divmigrante").hide();
    $("#divnacion").hide();
    $("#divsintomas").hide();
    $("#divcontacto_directo").hide();

    function cargarComboDestino($select, data) {
        $select.html('');
        $(data).each(function (ii, oo) {
            $select.append('<option value="' + oo.id + '">' + oo.nombre + '</option>')
        });
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


</script>
<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    @yield('scripts')
</body>
</html>