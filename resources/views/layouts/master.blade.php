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

            <!-- Logo -->
            <a href="#" class="logo">
                <b>COVID-19
                </b>
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
                    VIGILANCIA EPIDEMIOLOGICA COVID-19
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

        $('#fechaDesde').appendDtpicker({
        "dateOnly": true,
                "autodateOnStart": false,
                "minuteInterval": 5,
                "amPmInTimeList": false,
                "locale": "es",
                "closeOnSelected": true,
                "dateFormat": "DD-MM-YYYY"
        });
        $('#fechaHasta').appendDtpicker({
        "dateOnly": true,
                "autodateOnStart": false,
                "minuteInterval": 5,
                "amPmInTimeList": false,
                "locale": "es",
                "closeOnSelected": true,
                "dateFormat": "DD-MM-YYYY"
                //"dateFormat": "YYYY-MM-DD hh:mm",
        });
        $('#fechaDesde').click(function () {
            var fechaDesdeIni = $('#fechaDesde').val();
            $('#fechaDesde').change(function () {
                var fechaDesde = $('#fechaDesde').val();
                var fechaHasta = $('#fechaHasta').val();
                f1 = fechaDesde.split("-");
                f2 = fechaHasta.split("-");
                f3 = new Date();
                var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
                var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

                if (f1 > f2) {
                    bootbox.alert("La Fecha Desde no debe ser mayor a la Fecha Hasta");
                    $('#fechaDesde').val(fechaDesdeIni);
                    return false;
                }
            });
        });
        $('#fechaHasta').click(function () {
            var fechaHastaIni = $('#fechaHasta').val();
            $('#fechaHasta').change(function () {
                var fechaDesde = $('#fechaDesde').val();
                var fechaHasta = $('#fechaHasta').val();
                f1 = fechaDesde.split("-");
                f2 = fechaHasta.split("-");
                f3 = new Date();
                var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
                var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

                if (f2 < f1) {
                    bootbox.alert("La Fecha Hasta no debe ser menor a la Fecha Desde");
                    $('#fechaHasta').val(fechaHastaIni);
                    return false;
                }

                if (f2 > f3) {
                    bootbox.alert("La Fecha Hasta no debe ser mayor a la Fecha Actual");
                    $('#fechaHasta').val(fechaHastaIni);
                    return false;
                }
            });
        });
        $('#fechaHasta').trigger('change');
        $('#fechaDesde').trigger('change');
        var activeSystemClass = $('.list-group-item.active');
    });
    
    function reporteAislados(){
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();
        var dni_beneficiario = $('#dni_beneficiario').val();
        var id_departamento = $('#departamento').val();
        
        if (fechaDesde == "")fechaDesde = 0;
        if (fechaHasta == "")fechaHasta = 0;
        if (dni_beneficiario == "")dni_beneficiario = 0;
        if (id_departamento == "")id_departamento = 0;
        
        location.href = 'exportar_reporte_aislamientos/' + fechaDesde + '/' + fechaHasta  + '/' + id_departamento + '/' + dni_beneficiario;

    }

    function reporteAisladosR(){
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();
        var dni_beneficiario = $('#dni_beneficiario').val();
        var id_establecimiento = <?php echo Auth::user()->establecimiento_id ?>;
        
        if (fechaDesde == "")fechaDesde = 0;
        if (fechaHasta == "")fechaHasta = 0;
        if (dni_beneficiario == "")dni_beneficiario = 0;
        if (id_establecimiento == "")id_establecimiento = 0;
        
        location.href = 'exportar_reporte_aislamientos/' + fechaDesde + '/' + fechaHasta  + '/' + id_establecimiento + '/' + dni_beneficiario;

    }

    function reporteHospitalizados(){
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();
        var dni_beneficiario = $('#dni_beneficiario').val();
        var id_departamento = $('#departamento').val();
        
        if (fechaDesde == "")fechaDesde = 0;
        if (fechaHasta == "")fechaHasta = 0;
        if (dni_beneficiario == "")dni_beneficiario = 0;
        if (id_departamento == "")id_departamento = 0;
        
        location.href = 'exportar_reporte_hospitalizados/' + fechaDesde + '/' + fechaHasta  + '/' + id_departamento + '/' + dni_beneficiario;

    }

    function reporteHospitalizadosR(){
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();
        var dni_beneficiario = $('#dni_beneficiario').val();
        var id_establecimiento = <?php echo Auth::user()->establecimiento_id ?>;
        
        if (fechaDesde == "")fechaDesde = 0;
        if (fechaHasta == "")fechaHasta = 0;
        if (dni_beneficiario == "")dni_beneficiario = 0;
        if (id_establecimiento == "")id_establecimiento = 0;
        
        location.href = 'exportar_reporte_hospitalizados/' + fechaDesde + '/' + fechaHasta  + '/' + id_establecimiento + '/' + dni_beneficiario;

    }


    

    function ver_det_personal_aislado(idaislamiento, dni){
        $('#nrorecmodal').text(dni);
        $.ajax({
        url: '/ver_paciente/' + dni + '/' + idaislamiento ,
                async: false,
                success: function(result){
                $("#muestra-det-reclamacion").html(result);
                },
                complete: function () {
                $("#myModalDetR").modal();
                }
        });
    }


    function ver_det_solucion( dni, id_solucion){
        $('#nrorecmodal').text(dni);
        $.ajax({
        url: '/ver_solucion_atendida/' + dni + '/' + id_solucion,
                async: false,
                success: function(result){
                $("#muestra-det-reclamacion").html(result);
                },
                complete: function () {
                $("#myModalDetR").modal();
                }
        });
    }

    function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode;
    //alert(key);
    return ((key >= 48 && key <= 57) || key == 0 || key == 8)
    }

    
</script>

    @yield('scripts')
</body>
</html>