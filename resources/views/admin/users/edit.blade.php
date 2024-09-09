@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h4>
            Usuarios
        </h4>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                        @include('admin.users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@section('scripts')
<script type="text/javascript">   

$(document).ready(function () {

        $("#dni").blur(function (event) {
            getPersonalByDni();
        });
    });

    /*function getPersonalByDni() {
        var nro_doc = $('#dni').val();
        var tipo_doc = $('#tipo_doc').val();
        var valor = '';
        $('.table tbody').html("");
        $.ajax({
            url: '/buscar_personal_dni/' + nro_doc ,
            success: function (result) {
                
                if(result["dni"]!=0){
                    $('#nombres').val(result["nombre"]).attr("readonly", true);
                    $('#apellido_paterno').val(result["paterno"]).attr("readonly", true);
                    $('#apellido_materno').val(result["materno"]).attr("readonly", true);
                    $('#grado').val(result["grado"]).attr("readonly", true);
                    $('#sexo').val(result["sexo"]).attr("readonly", true);
                    $('#fecha_nacimiento').val(result["fecha_nacimiento"]).attr("readonly", true);
                    $('#cip').val(result["carne"]).attr("readonly", true);
                } 
                else
                {
                    $('#nombres').val(result["nombre"]).attr("readonly", false);
                    $('#apellido_paterno').val(result["paterno"]).attr("readonly", false);
                    $('#apellido_materno').val(result["materno"]).attr("readonly", false);
                    $('#grado').val(result["grado"]).attr("readonly", false);
                    $('#sexo').val(result["sexo"]).attr("readonly", false);
                    $('#fecha_nacimiento').val(result["fecha_nacimiento"]).attr("readonly", false);
                    $('#cip').val(result["carne"]).attr("readonly", false);  
                }
            }
        });
    }
    */
    
    function getPersonalByDni() {
    var nro_doc = $('#dni').val();        
    var valor = '';
    $.ajax({
        url: '/buscar_personal_dni_dirrehum/' + nro_doc,
        dataType: "json",
        success: function(result){
            if(result.sw == false){
                $('#nombres').val("");
                $('#apellido_paterno').val("");
                $('#apellido_materno').val("");
                $('#grado').val("");
                $('#sexo').val("");
                $('#fecha_nacimiento').val("");
                $('#cip').val("");
                return false;
            }

            //var beneficiario = result.beneficiario.apepatafiliado+" "+result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado+", "+result.beneficiario.nomafiliado;
            $('#parentesco').val(result.beneficiario.parentesco);
            $('#nombres').val(result.beneficiario.nomafiliado);
            $('#apellido_paterno').val(result.beneficiario.apepatafiliado);
            $('#apellido_materno').val(result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado);
            $('#cip').val(result.beneficiario.cip);
            $('#grado').val(result.beneficiario.grado);
            $('#fecha_nacimiento').val(result.beneficiario.fecnacafiliado);
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

    $cmbid_establecimiento = $("#frm_usuarios").find("#id_establecimiento");

</script>
@stop
