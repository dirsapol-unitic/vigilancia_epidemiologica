@extends('frontend.layouts.master')
@section('renderjs')
{!! HTML::script("plugins/jQuery/jquery-ui.js") !!}
{!! HTML::script("plugins/jQuery/jquery-ui.css") !!}

<style>

.modal-dialog {
	width: 90%;
  }
		  
.title-dialog {
  font-size: 18px;
  font-family:Arial, Helvetica, sans-serif;
}
    
.ui-autocomplete {
  position: absolute;
  top: 100%;
  left: 0;
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

<script>

$(document).ready(function() {
	/*
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	fullCalendar();
	*/
	//calendar.render();
	
	$('#fecha_atencion').datepicker();
	
	/*$(".fc-event-container").on("click", function (e) {
		alert("cssc");
	});*/

	$("#id_establecimiento").select2({
        width: 'resolve'
    });
	
	$('input[name="parent"]').on("change", function (e) {
		getServicio();
	});
	
	$('#id_servicio').on("change", function (e) {
		$('#calendar').fullCalendar('destroy'); 
		fullCalendar();
		modalTurnos();
		modalHistorial();
	});
	
	
	$('#btnPrestacion').on("click", function (e) {
		guardarPrestacion();
	});
	
	$('#addDiagnostico').on('click',function(){
		AddDiagnostico();
	});
	
	$('#addProcedimiento').on('click',function(){
		AddProcedimiento();
	});
	
	$('#addProducto').on('click', function () {
		AddProducto();
	});
	
	$('#addDerivarServicio').on('click', function () {
		var addDerivarServicio = $('#addDerivarServicio').attr("aria-pressed");
		$("#divServicio").hide();
		if(addDerivarServicio == "false"){
			$("#divServicio").show();
		}
	});
	
	$('#addRecetaVale').on('click', function () {
		var addRecetaVale = $('#addRecetaVale').attr("aria-pressed");
		$("#fsRecetaVale").hide();
		if(addRecetaVale == "false"){
			$("#fsRecetaVale").show();
		}
	});
	
	$('#example tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
	});
	
	$('#tblDiagnostico tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
	});
	
	$('#tblProcedimiento tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
	});
	
    $("#id_servicio_derivar").select2({
        width: 'resolve'
    });
	
	$("#id_farmacia_receta").select2({
        width: 'resolve'
    });
	
	//AddDiagnostico();
	//AddProcedimiento();
	
});

function guardarPrestacion(){
    
    var msg = "";
    /*
	var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
    var fecha_atencion = $('#fecha_atencion').val();
    var dni_beneficiario = $("#dni_beneficiario").val();
	if(dni_beneficiario == "")msg += "Debe ingresar el numero de documento <br>";
    if(id_ipress==""){msg+="Debe ingresar una Ipress<br>";}
    if(id_consultorio==""){msg+="Debe ingresar un Consultorio<br>";}
    if(fecha_atencion==""){msg+="Debe ingresar una fecha de atencion<br>";}
   	
	var horario = $('input[name=horario]:checked').val();
	var data = horario.split("#");
	var fecha_cita = data[0];
	var id_medico = data[1];
	*/
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        //fn_save_prestacion();
		$("#frmBloque").submit();
    }
}

function fn_save_prestacion(){
    
    //var fecha_atencion_original = $('#fecha_atencion').val();
	
    $.ajax({
            url: "../registrar_prestacion",
            type: "POST",
			//data : $("#frmPrestacion").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
			data : $("#frmPrestacion").serialize(),
            success: function (result) {  
					//modalTurnos();
					//modalHistorial();

            }
    });
}


function obtenerBeneficiario(){
		
	var id_tiporeceta = 1;
	var tipodoc_beneficiario = $("#tipodoc_beneficiario_bus").val();
	var dni_beneficiario = $("#dni_beneficiario").val();
	var msg = "";
	
	//if(id_tiporeceta == "")msg += "Debe seleccionar el tipo de receta <br>";
	//if(dni_beneficiario == "")msg += "Debe ingresar el numero de documento <br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	$.ajax({
		url: '../obtener_beneficiario/' + id_tiporeceta + '/' + tipodoc_beneficiario + '/' + dni_beneficiario,
		dataType: "json",
		success: function(result){
			if(result.sw == false){
				bootbox.alert(result.msg);
				$('#beneficiario').val("");
				$('#tipo_beneficiario').val("");
				$('#nombre_beneficiario').val("");
				$('#paterno_beneficiario').val("");
				$('#materno_beneficiario').val("");
				$('#tipodoc_beneficiario').val("");
				$('#cip_beneficiario').val("");
				$('#grado').val("");
				return false;
			}
			
			var beneficiario = result.beneficiario.apepatafiliado+" "+result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado+", "+result.beneficiario.nomafiliado;
			$('#nrodocafiliado').val(result.beneficiario.nrodocafiliado);
			$('#beneficiario').val(beneficiario);
			$('#tipo_beneficiario').val(result.beneficiario.parentesco);
			$('#nombre_beneficiario').val(result.beneficiario.nomafiliado);
			$('#paterno_beneficiario').val(result.beneficiario.apepatafiliado);
			$('#materno_beneficiario').val(result.beneficiario.apematafiliado+" "+result.beneficiario.apecasafiliado);
			$('#tipodoc_beneficiario').val(result.beneficiario.nomtipdocafiliado);
			$('#cip_beneficiario').val(result.beneficiario.cip);
			$('#grado').val(result.beneficiario.grado);
			
			var parentesco 	= result.beneficiario.parentesco;
			var ubigeo 		= result.beneficiario.ubigeo;
			
			obtenerEstablecimiento(parentesco,ubigeo);
			//alert(ubigeo);
			/*
			if(id_tiporeceta == 3){	
				ShowByServicioAndId_farmacia();
			}
			*/
		}
		
	});
	
}


function obtenerEstablecimiento(parentesco,ubigeo){

	var newOption = "";
	newOption = "<option value=''>--Seleccionar--</option>";
	$('#id_establecimiento').html(newOption);
	
	$.ajax({
		url: '../obtener_establecimiento/'+parentesco+"/"+ubigeo,
		success: function(result){                    
			var newOption = "";
			newOption = "<option value=''>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='"+oo.id+"'>"+oo.nombre+"</option>";
			});                 
			$('#id_establecimiento').html(newOption);
			$("#id_establecimiento").select2({max_selected_options: 4});
		
		}
	});
}





function limpiarBeneficiario(){
		
	var dni_beneficiario = $('#dni_beneficiario').val();
	var nrodocafiliado = $('#nrodocafiliado').val();
	if(dni_beneficiario!=nrodocafiliado){
		$('#beneficiario').val("");
		$('#tipo_beneficiario').val("");
		$('#nombre_beneficiario').val("");
		$('#paterno_beneficiario').val("");
		$('#materno_beneficiario').val("");
		$('#grado').val("");
		$('#nro_historia').val("");
		$('#tipodoc_beneficiario').val("");
		$('#cip_beneficiario').val("");
		$('#id_admision').val("");
		$('#grado').val("");
	}
	
	obtenerBeneficiario();

}


function getServicio(){

	var newOption = "";
	newOption = "<option value=''>--Seleccionar--</option>";
	$('#id_servicio').html(newOption);
	//$("#id_servicio").val('').trigger("change");
	var parent = $('input[name="parent"]:checked').val();
	//var parent	= $('#parent').val();
	
	$.ajax({
		url: '../obtener_consultorio_parent/'+parent,
		success: function(result){                    
			var newOption = "";
			newOption = "<option value=''>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='"+oo.id+"'>"+oo.nombre+"</option>";
			});                 
			$('#id_servicio').html(newOption);
			$("#id_servicio").select2({max_selected_options: 4});
		
		}
	});
	
}


function fullCalendar(){
	//var SITEURL = "{{url('/')}}";
	var iIdMovimientoCompra = $('#hdIdMovimientoCompra').val();
	var iIdTipoCompra		= $('#hdIdTipoCompra').val();

	var id_servicio	= $('#id_servicio').val();
	var id_ipress	= $('#id_establecimiento').val();
	$("#divHorario").html("");
	
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			/*right: 'month,agendaWeek,agendaDay'*/
		},
		editable: false,
		//events: "submit/cronogramaCompraData.php?iIdMovimientoCompra="+iIdMovimientoCompra,
		//events: "cronograma_cita",
		events: "cronograma_cita/"+id_ipress+"/"+id_servicio,
		//data: {id_ipress:id_ipress,id_servicio:id_servicio},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			dateObj = new Date(start); /* Or empty, for today */
			dateIntNTZ = dateObj.getTime() + dateObj.getTimezoneOffset() * 60 * 1000;
			dateObjNTZ = new Date(dateIntNTZ);
			start = dateObjNTZ.toISOString().slice(0, 10);
			start = $.trim(start);
			var sValidaciones = "";
				modalDelegar(start)
	
		}
	});	
		
}

function fn_RegistrarNuevoCronograma(start,iIdMovimientoCompra,iIdTipoCompra) {
	/*
    var oBotones = {
		"Pagar": function () {
            var btnGrabar = $("#ifrModal").contents().find("input[id='btnGrabar']");
            btnGrabar.click();
        },
        "Cerrar": function () {
            $(this).dialog("close");
            $(this).remove();
        }
    };
    var sRuta = "frmCronogramaCompraDetalle.php?param=" + iIdMovimientoCompra + "&param1=" + iIdTipoCompra + "&param2=" + start;
    fn_util_AbreModalNew("Agendar Pago", sRuta, '40', 150, null, oBotones);
	*/
	$('#showAtencionesMensual').modal();
}


function modalDelegar___(start,iIdMovimientoCompra,iIdTipoCompra){
	
	$(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	//$('#openOverlayOpc').modal();
	$('#openOverlayOpc .modal-body').css('height', 'auto');
	//alert(start);
	$.ajax({
			url: "../modal_cita_medico/"+start,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
			}
	});

}

function modalDelegar(start){
	
	//$(".modal-dialog").css("width","80%");
	//$('#openOverlayOpc').modal('show');
	//$('#openOverlayOpc .modal-body').css('height', 'auto');
	
	var id_servicio	= $('#id_servicio').val();
	var id_ipress	= $('#id_establecimiento').val();;
			
	$.ajax({
			url: "../modal_cita_medico/"+id_ipress+"/"+id_servicio+"/"+start,
			type: "GET",
			success: function (result) {  
					$("#divHorario").html(result);
			}
	});

}


function modalTurnos(){
	
	//$(".modal-dialog").css("width","80%");
	//$('#openOverlayOpc').modal('show');
	//$('#openOverlayOpc .modal-body').css('height', 'auto');
	
	var id_servicio	= $('#id_servicio').val();
	var id_ipress	= $('#id_establecimiento').val();;
	//var start = '2019-10-24';
	var start = "<?php //echo $fechaServidor?>";
	//alert(start);
	$.ajax({
			url: "../modal_turnos/"+id_ipress+"/"+id_servicio+"/"+start,
			type: "GET",
			success: function (result) {  
					$("#divTurno").html(result);
			}
	});

}

function modalHistorial(){
	/*
	var id_servicio	= $('#id_servicio').val();
	var id_ipress	= $('#id_establecimiento').val();;
	var start = '2019-10-24';
	*/
	var dni_beneficiario = $("#dni_beneficiario").val();
	$.ajax({
			url: "../modal_historial_cita/"+dni_beneficiario,
			type: "GET",
			success: function (result) {  
					$("#divHistorial").html(result);
			}
	});

}


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
	newRow +='<input type="hidden" class="form-control typeahead tt-query" id="id_diagnostico'+ind+'" name="id_diagnostico[]" value=""></td>';
	newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
	newRow +='</tr>';
	$('#tblDiagnostico tbody').append(newRow);
	
	$("#nombre_diagnostico"+ind).autocomplete({
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

function AddProcedimiento(){
	var newRow = "";
	var ind = $('#tblProcedimiento tbody tr').length;
	
	if(ind > 0){
		$('.cmbMedicamento').each(function(){
			var ind_tmp = $(this).attr("ind");
			if(ind_tmp => ind){
				ind=Number(ind_tmp)+1;
			}
		});
					
		fila_medicamentos=$('#tblProcedimiento tbody').children('tr');
		rowIndex=$('#hidden_rowIndex').val();
		var idval = ind - 1;
		fila_medicamento=fila_medicamentos[idval];
		
	}
	
	newRow +='<tr>';
	newRow +='<td><input type="text" data-toggle="tooltip" data-placement="top" title="Ingresar el procedimiento" name="nombre_procedimiento[]" tabindex="8" required="" id="nombre_procedimiento'+ind+'" class="input-sm" style="margin-left:4px; width:100%; text-align:left" />';
	newRow +='<input type="hidden" class="form-control typeahead tt-query" id="id_procedimiento'+ind+'" name="id_procedimiento[]" value=""></td>';
	newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
	newRow +='</tr>';
	$('#tblProcedimiento tbody').append(newRow);
	
	$("#nombre_procedimiento"+ind).autocomplete({
		minLength: 1,
		delay : 400,
		source: function(request, response) {
			$.ajax({
				url: '../obtener_procedimiento/' + request.term,
				dataType: "json",
				success: function(data)  {
					response(data);
				}					
			})
	
		},select:  function(e, ui) {
			var id_procedimiento = ui.item.id;
			$("#id_procedimiento"+ind).val(id_procedimiento);
			$("#nombre_procedimiento"+ind).prop("readonly",true);
		}
	});
	
	$("#nombre_procedimiento"+ind).on('blur', function() {
		var id_procedimiento = $("#id_procedimiento"+ind).val();
		if(id_procedimiento == ""){
			bootbox.alert("Falta ingresar el procedimiento en esta fila");
			$("#nombre_procedimiento"+ind).val("");
			return false;
		}
	});
	
} 


function AddProducto(){
	var tipo_receta = $('#tipo_receta').val();
	var id_consultorio = $('#id_consultorio').val();
        var id_farmacia = $('#id_farmacia_receta').val();
	if(tipo_receta == ""){
		bootbox.alert("Seleccione el tipo atención");
		return false;
	}		
	if(id_consultorio == ""){
		bootbox.alert("Seleccione un servicio");
		return false;
	}
	var newRow = "";
	var ind = $('#example tbody tr').length;
	var tabindex = 11;
		var nuevalperiodo = "";
	if(ind > 0){
	$('.cmbMedicamento').each(function(){
		var ind_tmp = $(this).attr("ind");
		if(ind_tmp => ind){
							ind=Number(ind_tmp)+1;
							tabindex+=3;
		}
	});
			
			fila_medicamentos=$('#example tbody').children('tr');
			rowIndex=$('#hidden_rowIndex').val();
			var idval = ind - 1;
		<?php //if ($modo_registro == 2 || ($modo_registro == 1 && $tipo_registro == 2)):?>    
			fila_medicamento=fila_medicamentos[idval];
			var valante = $(fila_medicamento).find('#nro_med_entregados').val();
			if(valante == ""){
				bootbox.alert("Ingrese cantidad entregada en el producto anterior");
				return false;
			}
		<?php //endif;?>
			
		nuevalperiodo = document.getElementById('tiempo_periodo'+idval).value;
	}
	
	var item_producto 	= "";
	$('#cmbMedicamentoTemp option').each(function(){
	item_producto += "<option value="+$(this).val()+" ru='"+$(this).attr("ru")+"'>"+$(this).html()+"</option>"	
	});
	
	newRow +='<tr>';
	newRow +='<td><select class="form-control cmbMedicamento" id="cmbMedicamento'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="id_producto[]" style="width: 400px">'+item_producto+'</select></td>';
	
	newRow +='<td><input type="text" name="nro_stocks_almacen[]" required id="nro_stocks_almacen" class="limpia_text nro_solicitado input-sm" style="margin-left:4px; width:100px" readonly=""/>';
	newRow +='<td><input type="text" name="nro_stocks_establecimiento[]" required id="nro_stocks_establecimiento" class="limpia_text nro_solicitado input-sm" style="margin-left:4px; width:100px" readonly=""/>';
	
	newRow +='<td><input type="text" name="nro_stocks[]" required id="nro_stocks" class="limpia_text nro_solicitado input-sm" style="margin-left:4px; width:100px" readonly=""/>';
	<?php //if(isset($flag_receta_dias) && $flag_receta_dias == 1):?>
	newRow +='<td><input onkeypress="return soloNumerosMenosCero(event)" type="text" name="tiempo_periodo[]" tabindex="'+(tabindex+1)+'" required="" id="tiempo_periodo'+ind+'" class="nro_solicitado tiempo_periodo input-sm" style="margin-left:4px; width:100px" value="'+nuevalperiodo+'"/>';
	
	newRow +='<td><input type="text" name="posologia[]" tabindex="'+(tabindex+1)+'" required="" id="posologia'+ind+'" class="nro_solicitado posologia input-sm" style="margin-left:4px; width:200px" value=""/>';
	
	<?php //endif;?>
	newRow +='<input type="hidden" name="lotes_lote[]" id="lotes_lote" value=""/>';
	newRow +='<input type="hidden" name="lotes_registro_sanitario[]" id="lotes_registro_sanitario" value=""/>';
	newRow +='<input type="hidden" name="lotes_fecha_vencimiento[]" id="lotes_fecha_vencimiento" value=""/>';
		newRow +='<input type="hidden" name="lotes_precio_unitario[]" id="lotes_precio_unitario" value=""/>';
	newRow +='<input type="hidden" name="lotes_cantidad[]" id="lotes_cantidad" value=""/></td>';
	newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="nro_med_solictados[]" required="" id="nro_med_solictados'+ind+'" class="limpia_text nro_solicitado nro_med_solictados input-sm" style="margin-left:4px; width:100px" /></td>';
	
	<?php //if ($modo_registro == 2 || ($modo_registro == 1 && $tipo_registro == 2)):?>
	//newRow +='<td><input onKeyPress="return soloNumeros(event)" type="text" name="nro_med_entregados[]" required="" id="nro_med_entregados" class="limpia_text nro_solicitado input-sm" style="margin-left:4px; width:100px" readonly=""/></td>';
	<?php //endif;?>
	
	newRow +='<td><input type="hidden" name="exit" id="exit" id="" style="width:10px" value=""/></td>';
	newRow +='<td><button type="button"  class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
	newRow +='</tr>';
	$('#example tbody').append(newRow);
	$("#cmbMedicamento"+ind).select2({max_selected_options: 4}).focus();
	
	$("#nro_med_solictados"+ind).keypress(function(e){
	if(e.which == 13) {
		<?php //if ($modo_registro == 1 && ($tipo_registro == 1 || $tipo_registro == 3)):?>
			AddProducto();
		<?php //else:?>
			//validproductoseleccionado({{Auth::user()->id_farmacia}},this);
		<?php //endif;?>
	}
	});
	
	
	$("#cmbMedicamento"+ind).on("change", function (e) {
	var flagx = 0;
	cmb = $(this);
	id_producto = $("#cmbMedicamento"+ind).val();
	id_user={{Auth::user()->id}};
	
	$('.cmbMedicamento').each(function(){
		var ind_tmp = $(this).val();
		if($(this).val() == id_producto)flagx++;
	});
	
	if(flagx > 1){
		bootbox.alert("El producto farmaceutico ya ha sido ingresado");
		$("#cmbMedicamento"+ind).val("").trigger("change");
						return false;
	}
	
	option = {
		url: '/cargarstock_porfarmacia/' + id_producto+ '/' + id_farmacia,
		type: 'GET',
		dataType: 'json',
		data: {}
	};
		$.ajax(option).done(function (data) {
			
			var cantidad = data.cantidad;
			var cantidadEstablecimiento = data.cantidadEstablecimiento;
			var cantidadAlmacen = data.cantidadAlmacen;
			$(cmb).closest("tr").find(".limpia_text").val("");                
			//$(cmb).closest("tr").find("#nro_stocks").val(data);
			$(cmb).closest("tr").find("#nro_stocks").val(cantidad);
			$(cmb).closest("tr").find("#nro_stocks_establecimiento").val(cantidadEstablecimiento);
			$(cmb).closest("tr").find("#nro_stocks_almacen").val(cantidadAlmacen);
			<?php //if(isset($flag_receta_dias) && $flag_receta_dias == 1):?>
			$(cmb).closest("tr").find(".tiempo_periodo").focus();
			<?php //endif;?>
			$(cmb).closest("tr").find("#nro_med_solictados").val("");  
			$(cmb).closest("tr").find("#nro_med_entregados").val("");
			$(cmb).closest("tr").find("#lotes_lote").val("");
			$(cmb).closest("tr").find("#lotes_cantidad").val("");
			$(cmb).closest("tr").find("#lotes_registro_sanitario").val("");
			$(cmb).closest("tr").find("#lotes_fecha_vencimiento").val("");
		});
	
	});
	
}

function soloNumerosMenosCero(e){

	var key = window.Event ? e.which : e.keyCode;
	//alert(key);
	return ((key >= 48 && key <= 57) || key == 0 || key == 8)       
}

function firmar(){

	//var rowindex = $('#Grd2 tbody tr td').length;
	//$('#btnLiquidacionFirmarPdf').attr("disabled",true);
	//if (rowindex > 0) {
	
		$.ajax({
			url: "<?php echo url()?>/genera_csv",
			type: "post",
			//data: p,
			data: $("#frmBloque").serialize(),
			//timeout: 30000,
			dataType: 'json'
		})
		.done(function (resultado) {
			
			if (resultado.sw) {
				var csv = "<?php echo url()?>/tmp/csv/"+resultado.csv+".csv"; 
				//location.href='bpsign:?batch_csv='+csv;
				SinTokens();
			} else {
				//$("#dialogError").html('<p>Ocurrio un error en el sistema</p>');
				//dialogError(function () {});
			}
			$('#btnLiquidacionFirmarPdf').attr("disabled",false);

		})
		.fail(function () {
			//$("#dialogError").html('<p>Error de Coneccion, verifique si tiene Internet</p>');
			//dialogError(function () {});
		})
		.always(function () {
			//bootbox.hideAll();
		});
	
	//} else {

		//dialogWarning("Debe hacer check en minimo una solicitud");
	//}	
	

}

function SinTokens(){

	var batchSignatureProcessPoller = setInterval(function () {
		$.ajax({
			url: "<?php echo url()?>/sinTokens",
			type: "post",
			cache: false,
			dataType: 'json',
			data: $("#frmBloque").serialize(),
			success: function (completed) {
				if (completed) {
					location.href='/all_atenciones_medico_ipress';
					clearInterval(batchSignatureProcessPoller);					
				}
			}
		});
	}, 3000);
	

}


function validarFirma(){

	//$('.loader').show();
	var batchSignatureProcessPoller = setInterval(function () {
		$.ajax({
			url: "<?php echo url()?>/validarFirma",
			type: "post",
			cache: false,
			dataType: 'json',
			data: $("#frmBloque").serialize(),
			success: function (completed) {
				if (completed) {
					//$('.loader').hide();
					//cargarSolicitudes();
					//$('#Grd2 tbody tr').html("");
					//$('#spanContador').html("");
					clearInterval(batchSignatureProcessPoller);
					
				}
			}
		});
	}, 3000);
	

}

function enviarReceta(id){
	
	$("#id_receta").val(id);

}

function agregarReceta(){
	
	var flag = $('#btnNuevoReceeta').attr("flag");
	if(flag == 0){
		$('#btnNuevoReceeta').attr("flag",1).html("Ocultar Receta");
		$("#fsNuevaRecetaVale").show();
		$("#divGuardar").show();
		$("#divFirmar").hide();
	}else{
		$('#btnNuevoReceeta').attr("flag",0).html("Agregar Receta");;
		$("#fsNuevaRecetaVale").hide();
		$("#divGuardar").hide();
		$("#divFirmar").show();
	}
	
}

function getProducto(){
	
	$('#example tbody').html('');
	
	$.ajax({
		url: '/obtener_producto_por_idipress_idconsultorio_idfarmacia/' + 76 +'/'+ 3 +'/218',
		success: function(result){                    
			var newOption = "";
			newOption = "<option value=''>--Seleccionar-</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='"+oo.id+"' ru='"+oo.ru+"' >"+oo.codigo+" - "+oo.nombre+", "+oo.abreviatura+"</option>";
			});                 
			$('#cmbMedicamentoTemp').html(newOption);
		}
	});
	
}

function nro_interconsulta(){
	var dni_beneficiario = $('#dni_beneficiario').val();
	var id_farmacia = $('#id_farmacia').val();
	var x = 0;
	if(dni_beneficiario!=""){
        $.ajax({
                url: '/obtenerCantInterconsultas/' + dni_beneficiario+ '/' + id_farmacia,
                success: function (result) {
					if(result != null && result != ""){
		                for(var key in result) {
		                  x++;
		                }
					} 
                }
               
        });
        
        return x;
    }
}
	
	function getFarmacia() {

        var id_establecimiento = $('#id_establecimiento').val();
        var valor=0;
        $.ajax({
            url: '/obtener_farmacia_por_id_establecimiento_atencion/' + id_establecimiento + '/' + 1,
            success: function (result) {
                
                var newOption = "";
                newOption = "<option value='0'>--Seleccionar-</option>";
                
                $(result).each(function (ii, oo) {
                    newOption += "<option value='" + oo.id + "'>" + oo.nombre + "</option>";
                });

                $('#id_farmacia_receta').html(newOption);
                $("#id_farmacia_receta").select2({max_selected_options: 4});
            }
        });
    }

</script>
<style>
    .modal-dialog{
        width: 1200px !important;
    }    
    .suggest-element{
        margin-left:5px;
        margin-top:5px;
        width:350px;
        cursor:pointer;
    }
    #suggestions {
        width:350px;
        height:150px;
        overflow: auto;
    }
    
        
    .alert {
        padding: 10px;
background-position: 2% 7px;
background-repeat: no-repeat;
background-size: auto 35px;
/*background-color: rgba(0, 0, 0, 0);*/
border: 0;
min-width: auto !important;
text-align: left;
padding-left: 68px;
font-size: 14px;
margin-bottom: 10px;
}
.alert.alert-danger {
background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAARVBMVEX////7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0P7y0NAQECdhUHYsUKGdEG1l0JLSEBuYkHkukPKU8NPAAAADnRSTlMA4EDAoCAQ8IBgkDDQUFItelQAAAC0SURBVHherZBLDsMwCAVD7Nj5gvPr/Y/a0FpGLTibdnbozQJN829agPZu7/CiuxE8C76+T/hiqgruLbjqh5ip/TljZrb3AQuDKYAIYO09L3TBRq/3EHk4shCDEkZkTqITmdGMLIIO7r8FbzfaiDappSNjIkpZcCqyCDo4WAJYkR8prTp4ADSBUCIX9uPY5epL5AJdyBWDRDYFHCWyCiXBObKwrh+nl4g2TiLVhSXW97g0v/MEHIQbCYeFmYAAAAAASUVORK5CYII=);
border-top: 1px solid rgba(140, 0, 0, 0.4);
border-bottom: 1px solid rgba(140, 0, 0, 0.4);
}
.alert.alert-info {
background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAADBklEQVR42u3YyWsTURwHcP8aQUWtWlu7JEbtpngQvIqXevDWm1fXehO12BTErdQiVMFQ8ODBusWkmSa1lVrTxdrG0FA9WJtkljfL19/LTDKMibl0EorkwReSCQ8+fN+bl2G2AdhSqYH+P1CpAS0DfXUI+ufzUCfaoQptYMIxsMhRsE/d0L4/BNR0qcnug4y159CmTkOLdkKNdnBQAaNEjkAZ90EOH4YcOQ51dQQVBRnLN6DHuqDFOqGZGEpbaVDICynkAVvoRUVAxuqQE8PjXC7C/AX64KG0gq3ch6sgQ1zkEBtTph2FY8JeApkYKdgCMdgMPTMP10D64kUOsTDtDsw/27FAIge9b4Y8e8EdELS0jTAh5TF2Ow5Q9l0TDDWNTYOMjSkLQREcEAdGCRfvHdFcLgI1EegQtPXY5kFactAE2JDyGHvvONrhILZ81w3QIxNQCEfw2JvYxpRYKrMdSqNLoNSzPMBGTJwEmz4HuSSGMnkWYrgjv1Rm3jZATQ5vHqT//sgRVhtmI8p0NwADbOF6EUaOX4GiZCHGzhAkD2ogUD20XxNw5baXhRN2G2EvR+QwhqFDme91YJgiQfpyCTamkTAHaQm97p1DauIBR1jxWI14CHMNuqZCmbsKmcKYBLkYQzkA9m3APRA/P6TxrvztbCfYkoOoqgKVydTQ5ZIYMdgKQ91wD8SHvj7JAYXb2T5jmqEkhiEnHnNIESb7po72joCK/Ntray8sRD7UBkVeGoBEIQilwYFRUwFU9HmIrdzjCHtpKNJXP48FqSfIfspe2jf+Sj4P2UOMnOKQfCOE6Ye0eMdqZR+yr/fwc8icXA2QmnzCD7pCI+JiH8SFPt4KYXYjO7YTLDFYPZCensu3QakjzC2I8zcJsguZsR3IvNoOfWO2eiA+tJ9jfI9Q+qEkn1JGoCz1UW5D+/HSnFhNUCqVQjwezyUajSIUChW+02/VB42OjqJMaqCtB5qZmUEgEIDf73eEXxMEofogPtLpNHp6euDz+Xhyn+lauUm1tx81UMXzBw5wT9JYWi53AAAAAElFTkSuQmCC);
border-top:1px solid rgba(255, 165, 0,0.4);
border-bottom:1px solid rgba(255, 165, 0,0.4);
color:  rgb(225, 75, 0);
}
.alert.alert-success {
background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAqFBMVEX////w8PDw8PDw8PDw8PDw8PDw8PDw8PDW1tbn5+ff398PnVjd3d3i4uIPnVjk5OQPnVjg4OAPnVgzqW8PnVgPnVjT09Pw8PDG4NOp1sBjvJHu7u4PmVYqp2ri6+YcomFHsn4bmlzHzsoPnFeuxbl9tJk0n2t/xqSVvqqNzK1ZqYKJuaJVt4c4rHQnnWPl5eXj4+MPm1fe3t6b0bfc3NxBo3TY2NjX19eKj23kAAAAFXRSTlMA8BCwcFCgkP4f3NDnrzCHoM8Qc/Avz3otAAAA9klEQVR4Xq2T2XKDMAwAMRACNGdbyUDus/d9/f+f1VHEiFamfcm+7qIZGTs4IWEcGeswURz6dGIbJCrp0MeC6QTBCADO2Hetokv+vNXbyvnLAc9v8cA+NH4/veAFEr/f7HIe0OJvETMKYhLlLw8fiNinICKxnHHCfr92QY8CcwwAloX41cFjSoElCnBU89pvkeCAeAPH4or89Bp1YG+g5uUOPQEP5wWbgZzjPRDiU1mTmD/wggyvGVspZgCP4rGvjrpYuAWFTP+sounzwPO7n8SnNEBdmGesGZLUV+6V/ZilLt7F+6/95BMxHf71cCZfefbf0zsl3w3QOjVy6QFpAAAAAElFTkSuQmCC);
border-top:1px solid limegreen;
border-bottom:1px solid limegreen;
}

.form-control{
    height: 28px;
	text-align:left!important;
}

.form-group{
    margin-bottom: 10px;
}

#divHorariox{
	/*height: 200px!important;;*/
	/*background-color: #fed9ff; */
      /*width: 600px; */
	  width: 100%; 
      height: 550px; 
      overflow-x: hidden;
      overflow-y: auto; 
      text-align: center; 
      padding: 0px!important;
}


/********************/

body {
  font-family: 'Montserrat', 'Lato', 'Open Sans', 'Helvetica Neue', Helvetica, Calibri, Arial, sans-serif;
  color: #6b7381;
  background: #f2f2f2;
}
.jumbotron {
  background: #6b7381;
  color: #bdc1c8;
}
.jumbotron h1 {
  color: #fff;
}
.example {
  margin: 4rem auto;
}
.example > .row {
  margin-top: 2rem;
  height: 5rem;
  vertical-align: middle;
  text-align: center;
  border: 1px solid rgba(189, 193, 200, 0.5);
}
.example > .row:first-of-type {
  border: none;
  height: auto;
  text-align: left;
}
.example h3 {
  font-weight: 400;
}
.example h3 > small {
  font-weight: 200;
  font-size: 0.75em;
  color: #939aa5;
}
.example h6 {
  font-weight: 700;
  font-size: 0.65rem;
  letter-spacing: 3.32px;
  text-transform: uppercase;
  color: #bdc1c8;
  margin: 0;
  line-height: 5rem;
}
.example .btn-toggle {
  top: 50%;
  transform: translateY(-50%);
}
.btn-toggle {
  margin: 0 4rem;
  padding: 0;
  position: relative;
  border: none;
  height: 1.5rem;
  width: 3rem;
  border-radius: 1.5rem;
  color: #6b7381;
  background: #bdc1c8;
}
.btn-toggle:focus,
.btn-toggle.focus,
.btn-toggle:focus.active,
.btn-toggle.focus.active {
  outline: none;
}
.btn-toggle:before,
.btn-toggle:after {
  line-height: 1.5rem;
  width: 4rem;
  text-align: center;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: absolute;
  bottom: 0;
  transition: opacity 0.25s;
}
.btn-toggle:before {
  content: 'NO';
  left: -4rem;
}
.btn-toggle:after {
  content: 'SI';
  right: -4rem;
  opacity: 0.5;
}
.btn-toggle > .handle {
  position: absolute;
  top: 0.1875rem;
  left: 0.1875rem;
  width: 1.125rem;
  height: 1.125rem;
  border-radius: 1.125rem;
  background: #fff;
  transition: left 0.25s;
}
.btn-toggle.active {
  transition: background-color 0.25s;
}
.btn-toggle.active > .handle {
  left: 1.6875rem;
  transition: left 0.25s;
}
.btn-toggle.active:before {
  opacity: 0.5;
}
.btn-toggle.active:after {
  opacity: 1;
}
.btn-toggle.btn-sm:before,
.btn-toggle.btn-sm:after {
  line-height: -0.5rem;
  color: #fff;
  letter-spacing: 0.75px;
  left: 0.4125rem;
  width: 2.325rem;
}
.btn-toggle.btn-sm:before {
  text-align: right;
}
.btn-toggle.btn-sm:after {
  text-align: left;
  opacity: 0;
}
.btn-toggle.btn-sm.active:before {
  opacity: 0;
}
.btn-toggle.btn-sm.active:after {
  opacity: 1;
}
.btn-toggle.btn-xs:before,
.btn-toggle.btn-xs:after {
  display: none;
}
.btn-toggle:before,
.btn-toggle:after {
  color: #6b7381;
}
.btn-toggle.active {
  background-color: #29b5a8;
}
.btn-toggle.btn-lg {
  margin: 0 5rem;
  padding: 0;
  position: relative;
  border: none;
  height: 2.5rem;
  width: 5rem;
  border-radius: 2.5rem;
}
.btn-toggle.btn-lg:focus,
.btn-toggle.btn-lg.focus,
.btn-toggle.btn-lg:focus.active,
.btn-toggle.btn-lg.focus.active {
  outline: none;
}
.btn-toggle.btn-lg:before,
.btn-toggle.btn-lg:after {
  line-height: 2.5rem;
  width: 5rem;
  text-align: center;
  font-weight: 600;
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: absolute;
  bottom: 0;
  transition: opacity 0.25s;
}
.btn-toggle.btn-lg:before {
  content: 'NO';
  left: -5rem;
}
.btn-toggle.btn-lg:after {
  content: 'SI';
  right: -5rem;
  opacity: 0.5;
}
.btn-toggle.btn-lg > .handle {
  position: absolute;
  top: 0.3125rem;
  left: 0.3125rem;
  width: 1.875rem;
  height: 1.875rem;
  border-radius: 1.875rem;
  background: #fff;
  transition: left 0.25s;
}
.btn-toggle.btn-lg.active {
  transition: background-color 0.25s;
}
.btn-toggle.btn-lg.active > .handle {
  left: 2.8125rem;
  transition: left 0.25s;
}
.btn-toggle.btn-lg.active:before {
  opacity: 0.5;
}
.btn-toggle.btn-lg.active:after {
  opacity: 1;
}
.btn-toggle.btn-lg.btn-sm:before,
.btn-toggle.btn-lg.btn-sm:after {
  line-height: 0.5rem;
  color: #fff;
  letter-spacing: 0.75px;
  left: 0.6875rem;
  width: 3.875rem;
}
.btn-toggle.btn-lg.btn-sm:before {
  text-align: right;
}
.btn-toggle.btn-lg.btn-sm:after {
  text-align: left;
  opacity: 0;
}
.btn-toggle.btn-lg.btn-sm.active:before {
  opacity: 0;
}
.btn-toggle.btn-lg.btn-sm.active:after {
  opacity: 1;
}
.btn-toggle.btn-lg.btn-xs:before,
.btn-toggle.btn-lg.btn-xs:after {
  display: none;
}
.btn-toggle.btn-sm {
  margin: 0 0.5rem;
  padding: 0;
  position: relative;
  border: none;
  height: 1.5rem;
  width: 3rem;
  border-radius: 1.5rem;
}
.btn-toggle.btn-sm:focus,
.btn-toggle.btn-sm.focus,
.btn-toggle.btn-sm:focus.active,
.btn-toggle.btn-sm.focus.active {
  outline: none;
}
.btn-toggle.btn-sm:before,
.btn-toggle.btn-sm:after {
  line-height: 1.5rem;
  width: 0.5rem;
  text-align: center;
  font-weight: 600;
  font-size: 0.55rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: absolute;
  bottom: 0;
  transition: opacity 0.25s;
}
.btn-toggle.btn-sm:before {
  content: 'NO';
  left: -0.5rem;
}
.btn-toggle.btn-sm:after {
  content: 'SI';
  right: -0.5rem;
  opacity: 0.5;
}
.btn-toggle.btn-sm > .handle {
  position: absolute;
  top: 0.1875rem;
  left: 0.1875rem;
  width: 1.125rem;
  height: 1.125rem;
  border-radius: 1.125rem;
  background: #fff;
  transition: left 0.25s;
}
.btn-toggle.btn-sm.active {
  transition: background-color 0.25s;
}
.btn-toggle.btn-sm.active > .handle {
  left: 1.6875rem;
  transition: left 0.25s;
}
.btn-toggle.btn-sm.active:before {
  opacity: 0.5;
}
.btn-toggle.btn-sm.active:after {
  opacity: 1;
}
.btn-toggle.btn-sm.btn-sm:before,
.btn-toggle.btn-sm.btn-sm:after {
  line-height: -0.5rem;
  color: #fff;
  letter-spacing: 0.75px;
  left: 0.4125rem;
  width: 2.325rem;
}
.btn-toggle.btn-sm.btn-sm:before {
  text-align: right;
}
.btn-toggle.btn-sm.btn-sm:after {
  text-align: left;
  opacity: 0;
}
.btn-toggle.btn-sm.btn-sm.active:before {
  opacity: 0;
}
.btn-toggle.btn-sm.btn-sm.active:after {
  opacity: 1;
}
.btn-toggle.btn-sm.btn-xs:before,
.btn-toggle.btn-sm.btn-xs:after {
  display: none;
}
.btn-toggle.btn-xs {
  margin: 0 0;
  padding: 0;
  position: relative;
  border: none;
  height: 1rem;
  width: 2rem;
  border-radius: 1rem;
}
.btn-toggle.btn-xs:focus,
.btn-toggle.btn-xs.focus,
.btn-toggle.btn-xs:focus.active,
.btn-toggle.btn-xs.focus.active {
  outline: none;
}
.btn-toggle.btn-xs:before,
.btn-toggle.btn-xs:after {
  line-height: 1rem;
  width: 0;
  text-align: center;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: absolute;
  bottom: 0;
  transition: opacity 0.25s;
}
.btn-toggle.btn-xs:before {
  content: 'NO';
  left: 0;
}
.btn-toggle.btn-xs:after {
  content: 'SI';
  right: 0;
  opacity: 0.5;
}
.btn-toggle.btn-xs > .handle {
  position: absolute;
  top: 0.125rem;
  left: 0.125rem;
  width: 0.75rem;
  height: 0.75rem;
  border-radius: 0.75rem;
  background: #fff;
  transition: left 0.25s;
}
.btn-toggle.btn-xs.active {
  transition: background-color 0.25s;
}
.btn-toggle.btn-xs.active > .handle {
  left: 1.125rem;
  transition: left 0.25s;
}
.btn-toggle.btn-xs.active:before {
  opacity: 0.5;
}
.btn-toggle.btn-xs.active:after {
  opacity: 1;
}
.btn-toggle.btn-xs.btn-sm:before,
.btn-toggle.btn-xs.btn-sm:after {
  line-height: -1rem;
  color: #fff;
  letter-spacing: 0.75px;
  left: 0.275rem;
  width: 1.55rem;
}
.btn-toggle.btn-xs.btn-sm:before {
  text-align: right;
}
.btn-toggle.btn-xs.btn-sm:after {
  text-align: left;
  opacity: 0;
}
.btn-toggle.btn-xs.btn-sm.active:before {
  opacity: 0;
}
.btn-toggle.btn-xs.btn-sm.active:after {
  opacity: 1;
}
.btn-toggle.btn-xs.btn-xs:before,
.btn-toggle.btn-xs.btn-xs:after {
  display: none;
}
.btn-toggle.btn-secondary {
  color: #6b7381;
  background: #bdc1c8;
}
.btn-toggle.btn-secondary:before,
.btn-toggle.btn-secondary:after {
  color: #6b7381;
}
.btn-toggle.btn-secondary.active {
  background-color: #ff8300;
}


</style>
@endsection
@section('content')

<?php $grados = array("NINGUNO","ALUMNO","CADETE","ALFÉREZ DE SERVICIO","ALFÉREZ MAESTRO ARMERO","CAPITÁN","CAPITÁN DE SERVICIO","CAPITÁN MAESTRO ARMERO","COMANDANTE","COMANDANTE DE SERVICIO","COMANDANTE MAESTRO ARMERO","CORONEL","CORONEL DE SERVICIO","ESPECIALISTA BRIGADIER","ESPECIALISTA DE PRIMERA","ESPECIALISTA DE SEGUNDA","ESPECIALISTA DE TERCERA","ESPECIALISTA SUPERIOR","ESPECIALISTA TÉCNICO DE 1RA","ESPECIALISTA TÉCNICO DE 2DA","ESPECIALISTA TÉCNICO DE 3RA","GENERAL","GENERAL DE SERVICIO","MAYOR","MAYOR DE SERVICIO","MAYOR MAESTRO ARMERO","SUBOFICIAL BRIGADIER","SUBOFICIAL BRIGADIER DE SERVICIO","SUBOFICIAL DE PRIMERA","SUBOFICIAL DE PRIMERA DE SERVICIO","SUBOFICIAL DE SEGUNDA","SUBOFICIAL DE SEGUNDA DE SERVICIO","SUBOFICIAL DE TERCERA","SUBOFICIAL DE TERCERA DE SERVICIO","SUBOFICIAL SUPERIOR","SUBOFICIAL SUPERIOR DE SERVICIO","SUBOFICIAL TECNICO DE 1RA","SUBOFICIAL TECNICO DE 1RA DE SERVICIO","SUBOFICIAL TECNICO DE 2DA","SUBOFICIAL TECNICO DE 2DA DE SERVICIO","SUBOFICIAL TECNICO DE 3RA","SUBOFICIAL TECNICO DE 3RA DE SERVICIO","TENIENTE","TENIENTE DE SERVICIO","TENIENTE GENERAL","TENIENTE MAESTRO ARMERO");
?>

<div class="container" style="width:90%">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="row">
                <div class="panel panel-primary filterable">            
                    <div class="panel-heading">
                        <h3 class="panel-title">MÓDULO DE GESTIÓN DE ATENCIONES MEDICAS</h3>      
                    </div>
					
                    <div class="panel-body" >
					
						
						<!--<div class="panel panel-info panel-bordered panel-sm panel-body">-->
    
		
					<form class="form-horizontal" method="post" id="frmBloque" action="{{ route('registrar_receta_prestacion')}}"> 
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id_nivel" id="id_nivel" value="<?php //echo $id_nivel?>">
							<input type="hidden" value="{{ Auth::user()->id }}" name="id_user" id="id_user">
							<input type="hidden" value="{{Auth::user()->id_farmacia}}" name="id_farmacia" id="id_farmacia">
							<input type="hidden" value="<?php echo $id_prestacion?>" name="id_prestacion" id="id_prestacion">
							
							<input type="hidden" value="<?php echo $prestacion->id_cita?>" name="id_cita" id="id_cita">
							<input type="hidden" value="<?php echo $prestacion->id_asegurado?>" name="id_asegurado" id="id_asegurado">
							
							<input type="hidden" value="<?php echo $prestacion->id_sub_consultorio?>" name="id_sub_consultorio" id="id_sub_consultorio">
							<input type="hidden" value="<?php echo $prestacion->id_medico?>" name="id_medico" id="id_medico">
							<input type="hidden" value="<?php echo $id_prestacion?>" name="id_tipo_atencion" id="id_tipo_atencion">
							<input type="hidden" value="<?php echo $prestacion->id_consultorio?>" name="id_servicio" id="id_servicio">

<div class="panel panel-info panel-bordered panel-sm panel-body">
<fieldset>

	<legend>
		<b>DATOS DE LA ATENCI&Oacute;N</b>
	</legend>
	
	<div>
	
		<div class="form-group">
		
			<div class="col-md-4">
				<label for="tipo">TIPO DE ATENCI&Oacute;N</label>
				<p><?php echo $prestacion->tipo_atencion?></p>
			</div>
			
			<div class="col-md-2">
				<label for="dni_beneficiario">FECHA DE ATENCION</label>
				<p><?php echo $prestacion->fecha_atencion?></p>
			</div>
			
			<div class="col-md-2">
				<label>N° HISTORIA CLINICA</label>
				<p><?php echo $prestacion->nro_historia?></p>
			</div>
		
		</div>
		
		<div class="form-group">
		
			<div class="col-md-4">
				<label for="tipo">NOMBRE DE LA IPRESS</label>
				<p><?php echo $prestacion->establecimiento?></p>
			</div>
			
			<div class="col-md-4">
				<label for="dni_beneficiario">SERVICIO</label>
				<p><?php echo $prestacion->servicio?></p>
			</div>
		</div>
	
	</div>
</fieldset>
</div>

<fieldset>

	<div class="panel panel-info panel-bordered panel-sm">
		<div class="panel-heading">
			<div class="panel-title text-center">
				<b>INFORMACIÓN DEL PACIENTE</b>
			</div>
		</div>
		<div class="panel-body" id="collapseprestacionespaciente">
			
			
			<div class="form-group">
							
				<div class="col-md-4">
					<label for="tipo">TIPO DE DOCUMENTO DE IDENTIDAD</label>
					<p><?php echo $prestacion->tipo_doc_ident?></p>
				</div>
				
				<div class="col-md-4">
					<label for="dni_beneficiario">N° DE DOCUMENTO DE IDENTIDAD</label>
					<p><?php echo $prestacion->nro_doc_ident?></p>
				</div>
				
				<div class="col-md-4">
					<label for="dni_beneficiario">SEXO</label>
					<p><?php echo $prestacion->sexo?></p>
				</div>
			</div>
							
			<div class="form-group">	
				<div class="col-md-4">
					<label>APELLIDO PATERNO</label>
					<p><?php echo $prestacion->asegurado_paterno?></p>
				</div>
				
				<div class="col-md-4">
					<label>APELLIDO MATERNO</label>
					<p><?php echo $prestacion->asegurado_materno?></p>
				</div>
				
				<div class="col-md-4">
					<label>NOMBRES</label>
					<p><?php echo $prestacion->asegurado_nombre?></p>
				</div>
			</div>
			
			<div class="form-group">	
				<div class="col-md-4">
					<label>FECHA DE NACIMIENTO</label>
					<p><?php echo $prestacion->fecha_nac?></p>
				</div>
				<div class="col-md-4">
					<label>PARENTESCO &nbsp;</label>
					<p><?php echo $prestacion->parentesco?></p>
				</div>
				
				<div class="col-md-4">
					<label>GRADO &nbsp;</label>
					<p><?php echo $prestacion->grado?></p>
				</div>
			</div>
			
		</div>
	</div>

</fieldset>

<fieldset>

	<div class="panel panel-info panel-bordered panel-sm">
		<div class="panel-heading">
			<div class="panel-title text-center">
				<b>INFORMACIÓN DEL RESPONSABLE DE ATENCION</b>
			</div>
		</div>
		<div class="panel-body">

			<div class="form-group">
							
				<div class="col-md-4">
					<label for="tipo">TIPO DE DOCUMENTO DE IDENTIDAD</label>
					<p>DNI</p>
										
				</div>
				
				<div class="col-md-4">
					<label for="dni_beneficiario">N° DE DOCUMENTO DE IDENTIDAD</label>
					<p><?php echo $prestacion->dni?></p>
				</div>
				
			</div>
							
			<div class="form-group">	
				<div class="col-md-4">
					<label>APELLIDO PATERNO</label>
					<p><?php echo $prestacion->medico_paterno?></p>
				</div>
				
				<div class="col-md-4">
					<label>APELLIDO MATERNO</label>
					<p><?php echo $prestacion->medico_materno?></p>
				</div>
				
				<div class="col-md-4">
					<label>NOMBRES</label>
					<p><?php echo $prestacion->medico_nombre?></p>
				</div>
			</div>
			<div class="form-group">	
				<div class="col-md-2">
					<label>N° COLEGIATURA</label>
					<p><?php echo $prestacion->colegiatura?></p>
				</div>
				<div class="col-md-2">
					<label>N° RNE</label>
					<p><?php echo $prestacion->rne?></p>
				</div>
				<div class="col-md-4">
					<label>PROFESION</label>
					<p><?php echo $prestacion->profesion?></p>
				</div>
				<div class="col-md-4">
					<label>ESPECIALIDAD</label>
					<p><?php echo $prestacion->especializacion?></p>
				</div>
			</div>
		</div>
	</div>
</fieldset>


<fieldset>

	<div class="panel panel-info panel-bordered panel-sm">
		<div class="panel-heading">
			<div class="panel-title text-center">
				<b>DIAGNOSTICOS</b>
			</div>
		</div>
		<div class="panel-body">
			<table class="display" id="tblDiagnostico" cellspacing="0" width="100%" style="margin-top:5px;">
				<thead>
					<tr>
						<th width="20%">Codigo</th>
						<th width="80%">Nombre</th>
					</tr>
				</thead>
				<tfoot>
				</tfoot>
				<tbody>
					<?php foreach($diagnostico as $row):
					?>
					<tr>
						<td><?php echo $row->codigo?></td>
						<td><?php echo $row->nombre?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</fieldset>

<fieldset id="fsRecetaVale">

	<div class="panel panel-info panel-bordered panel-sm">
		<div class="panel-heading">
			<div class="panel-title text-center">
				<b>PRODUCTOS MEDICOS</b>
			</div>
		</div>
		<div class="panel-body">
			<?php foreach($receta as $rowReceta):
				$model_productos_receta = new \App\Models\Producto_receta;
				$medicamentos = $model_productos_receta->ShowMedicinasById_receta_vale($rowReceta->id);
			?>
			<div class="col-md-12" style="margin-bottom:10px;padding-left:0px">
				<?php if($rowReceta->estado=="2"){?>
					<a data-toggle="modal" data-target="#squarespaceModal" onclick="enviarReceta(<?php echo $rowReceta->id?>)" class="btn btn-danger">
						<i class="fa fa-xing"></i> Invalidar Receta
					</a>
				<?php }else{ ?>
					<button class="btn btn-danger" disabled="disabled"><i class="fa fa-xing"></i> Invalidar Receta</button>
				<?php } ?>
			</div>
			<br />
			
			<div style="clear:both"></div>
			<fieldset>
			<div class="panel panel-info panel-bordered panel-sm">
			<div class="panel-body">
			
			<div class="form-group">
				<div class="col-md-12">
				<label class="col-md-2" style="padding-left:0px">RECETA VALE N°</label>
				<div class="col-md-1"><p><?php echo $rowReceta->nro_receta; ?></p></div>
				<label class="col-md-2" style="padding-left:0px;text-align:right">FEC. EXPEDICIÓN</label>
				<div class="col-md-2"><p><?php echo date("d-m-Y", strtotime($rowReceta->fecha_registro)); ?></p></div>
				<label class="col-md-1" style="padding-left:0px">FARMACIA</label>
				<div class="col-md-4" style="padding:0px"><p><?php echo $rowReceta->farmacia; ?></p></div>
				</div>
			</div>
			
			<table class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="15%">Codigo</th>
						<th width="30%">Producto farmacéutico o dispositivo médico</th>
						<th width="15%">Unidad Medida</th>
						<th width="10%">Tiempo(Dias)</th>
						<th width="15%">Posologia</th>
						<th width="15%">Cantidad Prescrita</th>
					</tr>
				</thead>
				<tfoot>
				</tfoot>
					<?php foreach($medicamentos as $row):?>
					<tr>
						<td><?php echo $row->codigo?></td>
						<td><?php echo $row->nombre?></td>
						<td><?php echo $row->abreviatura?></td>
						<td><?php echo $row->tiempo_periodo?></td>
						<td><?php echo $row->posologia?></td>
						<td><?php echo $row->cantidad_prescrita?></td>
					</tr>
					<?php endforeach;?>
				<tbody>
				</tbody>
			</table>
			</div>
			</div>
			</fieldset>
			
			<?php endforeach;?>

			<?php if($prestacion->condicion==0): ?>
				
				<div class="col-md-12" style="margin-bottom:10px;padding-left:0px">
					<a onclick="agregarReceta()" id="btnNuevoReceeta" flag="0" class="btn btn-success">Agregar Receta</a>
				</div>
			<?php endif; ?>
			
			<div style="clear:both"></div>
			
			<fieldset id="fsNuevaRecetaVale" style="display:none">

				<div class="panel panel-info panel-bordered panel-sm">
					<div class="panel-body">
						
						<div class="form-group">
								<div class="col-md-2">
								<label>FEC. EXPEDICIÓN (A)</label>
								<input type="text" class="form-control datepicker" value="<?php echo date("d-m-Y", strtotime($fechaServidor)); ?>" name="fecha_expedicion" id="fecha_expedicion" tabindex="2" autocomplete="off"/>
								</div>
								<div class="col-md-5">
									<label for="tipo">NOMBRE DEL ESTABLECIMIENTO</label><br/>
					                <select class="form-control" name="id_establecimiento" id="id_establecimiento" onchange="getFarmacia();" style="width:100%" required="" placeholder="Seleccionar un Hospital">
					                        <option value="0">-Seleccionar-</option>
					                        @foreach($establecimientos as $f)
					                        	<option value="{{$f->id}}" <?php if($f->id == Auth::user()->id_establecimiento)echo "selected='selected'";?> >{{$f->codigo}} - {{$f->nombre}}</option>
					                        @endforeach
					                </select>
								</div>
								<div class="col-md-5">
								<label>FARMACIA</label>								
								<select class="form-control" name="id_farmacia_receta" id="id_farmacia_receta" style="width:100%" onchange="getProducto()" >
									<option value="">-Seleccionar-</option>
									<?php foreach($farmacias as $row):?>
										<option value="<?php echo $row->id?>" ><?php echo $row->nombre?></option>
									<?php endforeach;?>
								</select> 
								</div>
							</div>
							<br />
							<table>
							<tr>
								<td>
									<button type="button" id="addProducto" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Agregar Producto</button>
								</td>
							</tr>
						</table>
						<br />
						<div style="display: none">
							<select class="form-control" id="cmbMedicamentoTemp" tabindex="16" style="width: 500px">
								<option value="">Seleccionar Producto</option>
								@foreach($producto as $p)                                                                                                
								<option value="{{$p->id}}" ru="{{$p->ru}}">{{$p->codigo}} - {{$p->nombre}}, {{$p->abreviatura}}</option>
								@endforeach
							</select>  
						</div>
						<input type="hidden" value="0" name="hidden_rowIndex" id="hidden_rowIndex">
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Producto farmacéutico o dispositivo médico</th>
								<th style="width:10%">Stock Almacen</th>
								<th style="width:10%">Stock <?php //echo $establecimiento->nombre?></th>
								<th style="width:10%">Stock <?php //echo $farma->nombre?></th>
								<th>Tiempo(Dias)</th>
								<th>Posologia</th>
								<th>Cantidad Prescrita</th>
								<th></th>
								<th>Eliminar</th>
							</tr>
						</thead>
						<tfoot>
						</tfoot>
						<tbody>
						</tbody>
					</table>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</fieldset>
			<div id="divGuardar" style="display:none">
			<input class="btn btn-primary input-sm pull-right" value="GUARDAR" name="crea" type="button" form="prestacionescrea" id="btnPrestacion" />&nbsp;&nbsp; 
			</div>			
			<div id="divFirmar">			
			<input name="mov[]" id="mov[]" value="<?php echo $id_prestacion?>" type="hidden" />
			<?php if($prestacion->condicion==0): ?>
				<input class="btn btn-info input-sm pull-right" value="FIRMAR" type="button" onclick="firmar()" style="margin-left:20px" />
			<?php endif; ?>
			<a class="btn btn-primary btn-sm hidden-print pull-right" href="/all_atenciones_medico_ipress"> <span class="glyphicon glyphicon-list"></span> &nbsp; LISTADO</a>
			</div>
			
			</form>
															
		</div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel">Invalidar Receta</h3>
            </div>
            <div class="modal-body">
                <!-- content goes here -->
                <form class="" method="post" action="{{ route('invalidar_receta_digital')}}" id="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Escribir el motivo para invalidar el registro de esta receta</label>
                        <input type="text" class="form-control" id="motivo" name="motivo" placeholder="" required="">
                        <input type="hidden" class="form-control" id="id_farmacia" name="id_farmacia" value="{{Auth::user()->id_farmacia}}">
                        <input type="hidden" class="form-control" id="id_receta" name="id_receta" value="<?php //echo $prestacion->id_receta?>">
                        <input type="hidden" class="form-control" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
						<input type="hidden" name="id_prestacion" id="id_prestacion" value="<?php echo $id_prestacion?>">
                    </div>
                    <div class="form-group">
                        <input id="btnInvalidar" class="btn btn-danger" type="submit" value="Invalidar">                        
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal___" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="">
    <div class="modal-dialog">
        <div class="modal-content">            
            <form method="post" action="{{ route('reasignar_lotes')}}" id="frmlotizar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header" id="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>-->
                    <h4 class="modal-title" id="lineModalLabel">Dispensar</h4>
                    <div id="alerta" class="alert alert-danger"></div>
                </div>
                <div class="modal-body">
                    <table border="0px" id="tabla_lote">
                        <thead>
                            <tr>
                                <th style="width:10%">CÓdigo</th>   
                                <th style="width:40%">Nombre</th> 
                                <th style="width:10%">Lote</th> 
                                <th style="width:10%">Reg. San.</th> 
                                <th style="width:10%">Precio</th>
                                <th style="width:10%">Fec. ven.</th>
                                <th style="width:10%">Cant. Actual.</th> 
                                <th style="width:10%">Cant. Entregar</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>                        
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">                        
                        <div class="btn-group" role="group">
                            <div class="col-md-6 text-center">
                                <button type="button" onclick="sumarCantidadLotes(0)" id="saveImage" class="btn btn-success btn-hover-green" data-action="save" role="button">Guardar</button>
                            </div>
                            <div class="col-md-6 text-center">
                                <button type="button" onclick="sumarCantidadLotes(1)" id="saveImage" class="btn btn-success btn-hover-green" data-action="save" role="button">Guardar y Agregar Nueva Fila</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="openOverlayOpc" class="modal fade" role="dialog">
  <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
		
		<div class="modal-body">

      		<div id="diveditpregOpc"></div>

      	</div>
	
    </div>

  </div>
</div>

<div class="modal fade" id="showAtencionesMensual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="width: 900px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><small style="color: #fff">Nro. Recetas dispensadas y atenciones en el mes actual</small></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><small>Atenciones</small></th>
                                <th><small>Fecha <br/>Dispensación</small></th>
                                <th><small>Fecha <br/>Expedición</small></th>
                                <th><small>Consultorio</small></th>
                                <th><small>Farmacia</small></th>
                                <th><small>Médico</small></th>
                                <th><small>Diagnóstico</small></th>
                                <th><small>Nro. Aten-<br>ciones</small></th>
                                <th><small>Detalle<br/>Producto</small></th>
                            </tr>
                        </thead>
                        <tbody id="muestra-atenciones"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showAtencionesDetMensual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="width: 900px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-size: 22px; color: #fff">Nro. Atenciones según fecha de expedición</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th><small>Nro. <br/>Atención</small></th>
                                <th><small>Farmacia</small></th>
                                <th><small>Fecha <br/>Expedición</small></th>
                                <th><small>Consultorio</small></th>
                                <th><small>Médico</small></th>
                                <th><small>Nro Receta</small></th>
                                <th><small>Fecha <br/>Dispensación</small></th>
                                <th><small>Detalle<br/>Producto</small></th>
                            </tr>
                        </thead>
                        <tbody id="muestra-det-atenciones"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showProductosReceta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detalle de Recetas</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><small>Código</small></th>
                                <th><small>Descipción</small></th>
                                <th><small>Unidad</small></th>
                                <th><small>Pedido</small></th>
                                <th><small>Despachado</small></th>
                            </tr>
                        </thead>
                        <tbody id="muestra-productos"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showStockEstablecimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="width: 900px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><small style="color: #fff">PROD. FARMACÉUTICOS Y DISPOSITIVOS MÉDICOS</small></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
								<th><small>Nro</small></th>
								<th><small>Farmacia</small></th>
                                <th><small>Código</small></th>
                                <th><small>Producto Farmacéutico o Dispositivo Médico</small></th>
                                <th><small>Unidad</small></th>
                                <th><small>Stock Actual</small></th>
                            </tr>
                        </thead>
                        <tbody id="muestra-stock"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


@include('frontend.includes.footer')
@endsection
