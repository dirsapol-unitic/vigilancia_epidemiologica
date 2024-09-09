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

        .radio-label {
           display: inline-block;
            vertical-align: top;
            margin-right: 3%;
        }
        .radio-input {
           display: inline-block;
            vertical-align: top;
        }

        fieldset {
            text-align: center;
        }
        

    </style>

    @yield('css')
</head>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2021 <a href="#"> DIRSAPOL </a>.</strong> Todos los derechos reservados.
        </footer>

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

        $(document).ready(function () {

            $("#dni").blur(function (event) {
                getPersonalByDni();
            });                       
            
        });


    $cmbid_establecimiento = $("#frm_aislamientos").find("#id_establecimiento");
    $cmbid_departamento = $("#frm_aislamientos").find("#id_departamento");
    $cmbid_provincia = $("#frm_aislamientos").find("#id_provincia");
    $cmbid_distrito = $("#frm_aislamientos").find("#id_distrito");    
    $cmbfactor = $("#frm_aislamientos").find("#id_factor");

    $('#id_departamento_2').prop('disabled', true);
    $('#id_provincia_2').prop('disabled', true);
    $('#id_distrito_2').prop('disabled', true);
    $('#tipo_doc_2').prop('disabled', true);                
    $('#nro_doc_2').val("").attr("readonly", true);
    $('#name_2').val("").attr("readonly", true);
    $('#paterno_2').val("").attr("readonly", true);
    $('#materno_2').val("").attr("readonly", true);
    $('#email_2').val("").attr("readonly", true);
    $('#telefono_2').val("").attr("readonly", true);
    $('#domicilio_2').val("").attr("readonly", true);        

    $cmbid_establecimiento.change(function () {
        var codigo_ipress, nro_reclamacion_ipress;
        $this = $(this);
        cmbid_establecimiento = $cmbid_establecimiento.val();
        $.ajax({
            url: '/cargadireccion/' + cmbid_establecimiento,
            success: function (result) {
                $('#direccion').val("").attr("readonly", false);                
                $('#direccion').val(result[0].direccion).attr("readonly", true);
            }
        });
        $.ajax({
            url: '/carganroreclamacion/' + cmbid_establecimiento,
            success: function (result) {
                $('#nro_reclamacion').val("").attr("readonly", false);                
                $('#nro_reclamacion').val(result).attr("readonly", true);
            }
        });
    });
    
    
    function getPersonalByDni() {
        var nro_doc = $('#dni').val();        
        var valor = '';
        $('.table tbody').html("");
        $.ajax({
            url: '/buscar_personal_dni/' + nro_doc ,
            success: function (result) {
                
                if(result["dni"]!=0){
                    $('#name').val(result["nombre"]).attr("readonly", true);
                    $('#paterno').val(result["paterno"]).attr("readonly", true);
                    $('#materno').val(result["materno"]).attr("readonly", true);
                    $('#grado').val(result["grado"]).attr("readonly", true);
                    $('#sexo').val(result["sexo"]).attr("readonly", true);
                    $('#fecha_nacimiento').val(result["fecha_nacimiento"]).attr("readonly", true);
                    $('#cip').val(result["carne"]).attr("readonly", true);
                } 
                else
                {
                    $('#name').val(result["nombre"]).attr("readonly", false);
                    $('#paterno').val(result["paterno"]).attr("readonly", false);
                    $('#materno').val(result["materno"]).attr("readonly", false);
                    $('#grado').val(result["grado"]).attr("readonly", false);
                    $('#sexo').val(result["sexo"]).attr("readonly", false);
                    $('#fecha_nacimiento').val(result["fecha_nacimiento"]).attr("readonly", false);
                    $('#cip').val(result["carne"]).attr("readonly", false);  
                }
            }
        });
    }
    
    /*
     function getPersonalByDni() {

       var nro_doc = $('#dni').val();
        var valor = '';
        $('.table tbody').html("");
        $.ajax({
            url: '/buscar_personal_dni/' + nro_doc ,
            success: function (result) {

                $('#name').val("").attr("readonly", false);
                $('#paterno').val("").attr("readonly", false);
                $('#materno').val("").attr("readonly", false);
                $('#grado').val("").attr("readonly", false);
                $('#sexo').val("").attr("readonly", false);
                $('#fecha_nacimiento').val("").attr("readonly", false);
                $('#cip').val("").attr("readonly", false);
                $('#name').val(result[0].nombres).attr("readonly", true);
                $('#paterno').val(result[0].nombres).attr("readonly", true);
                $('#materno').val(result[0].nombres).attr("readonly", true);
                $('#grado').val(result[0].grado).attr("readonly", true);                
                if(result[0].sexo=='MASCULINO')
                    $('#sexo').val('M').attr("readonly", true);
                else
                    $('#sexo').val('F').attr("readonly", true);
                $('#fecha_nacimiento').val(result[0].fecha_nacimiento).attr("readonly", true);
                $('#cip').val(result[0].cip).attr("readonly", true);

            }
        });

    }
    */


    

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

    
    $cmbfactor.change(function () {
            $this = $(this);
            cmbfactor = $cmbfactor.val();            
            
            if(cmbfactor!=10){                     
                    $('#otro_riesgo').text('destroy');
                    $('#otro_riesgo').remove();
            }
            else
            {
                var text = document.createElement("input");
               text.setAttribute("id", "otro_riesgo");    
               text.setAttribute("name", "otro_riesgo");           
               text.setAttribute("tabindex", "5");             
               text.setAttribute("class", "form-control");
               text.setAttribute("type", "text");                              
            $('#cargarotroriesgo').append(text); 
            }
        });

    function getOtroRiesgo(){        
        cmbfactor = $cmbfactor.val();
        
        if(cmbfactor!=10){                     
                $('#otro_riesgo').text('destroy');
                $('#otro_riesgo').remove();
            }
                
        var text = document.createElement("input");
           text.setAttribute("id", "otro_riesgo");    
           text.setAttribute("name", "otro_riesgo");           
           text.setAttribute("tabindex", "5");             
           text.setAttribute("class", "form-control");
           text.setAttribute("type", "text");                              
        $('#cargarotroriesgo').append(text);           
    }

    function cargarComboDestino($select, data) {
        $select.html('');
        $(data).each(function (ii, oo) {
            $select.append('<option value="' + oo.id + '">' + oo.nombre + '</option>')
        });
    }

    function soloNumeros(e)
        {
            var key = window.Event ? e.which : e.keyCode;
            //alert(key);
            return ((key >= 48 && key <= 57) || key == 0 || key == 8)
        }
    

    </script>
    <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    @yield('scripts')
</body>
</html>