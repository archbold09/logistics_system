// $(document).keypress(function(event){
// 	if (event.which == '13') {
// 		event.preventDefault();
// 	}
// });

//Expresion Regular
function expresionVal( form , expre ) {
	var expresiones1,resp;
	var minimo = 0;
	$("#"+form).find('input[type=number]').each(function(){

		campo = $(this).val();

		expresiones1 = expre;

		if(!expresiones1.test(campo)){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			minimo += 1;

		}
		else{
			$(this).removeAttr("style");
		}
	})
	if(minimo > 0){
		resp = false;
	}
	else{
		resp = true;
	}

	return resp;
}
//Only Int
function onlyInt(e) {
	let charCode = e.keyCode;
	return !(charCode > 31 && (charCode < 48 || charCode > 57));
}
//Funcion para validar campos TEXTAREAS 
function textareaVal( form ) {
	var res = "";
	var vacio = 0;
	$("#"+form).find('textarea').each(function(){
		if( $(this).val() == "" ){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			vacio += 1;
		}
		else{
			$(this).removeAttr("style");
		}
	});

	if(vacio > 0){
		res = false;
	}
	else{
		res = true;
	}

	return res; 
}

//Funcion para validar campos TXT
function txtVal( form ) {
	var res = "";
	var vacio = 0;
	$("#"+form).find('input[type=text]').each(function(){
		if( $(this).val() == "" ){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			vacio += 1;
		}
		else{
			$(this).removeAttr("style");
		}
	});

	if(vacio > 0){
		res = false;
	}
	else{
		res = true;
	}

	return res; 
}

//Funcion para validar campos NUMBER
function numberVal( form ) {
	var res = "";
	var vacio = 0;
	$("#"+form).find('input[type=number]').each(function(){
		if( $(this).val() == "" || $(this).val() < 1 ){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			vacio += 1;
		}
		else{
			$(this).removeAttr("style");
		}
	});

	if(vacio > 0){
		res = false;
	}
	else{
		res = true;
	}
	
	return res; 
}

//Funcion para validar campos SELECT
function selectVal( form ) {
	var res = "";
	var vacio = 0;
	$("#"+form).find('select').each(function(){
		if( $(this).val() < 1 ){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			vacio += 1;
		}
		else{
			$(this).removeAttr("style");
		}
	});

	if(vacio > 0){
		res = false;
	}
	else{
		res = true;
	}

	return res; 
}

//Funcion para validar campos DATE
function txtDate( form ) {
	var res = "";
	var vacio = 0;
	$("#"+form).find('input[type=date]').each(function(){
		if( $(this).val() == "" ){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			vacio += 1;
		}
		else{
			$(this).removeAttr("style");
		}
	});

	if(vacio > 0){
		res = false;
	}
	else{
		res = true;
	}

	return res; 
}

//Funcion para validar campos CHECK
function checkVal( form ) {
	var res = "";
	var vacio = 0;
	$("#"+form).find('input[type=checkbox]').each(function(){
		if( $(this).is(':checked') ){
			vacio += 1;
		}	
	});

	if(vacio > 0){
		res = true;
	}
	else{
		res = false;
	}

	return res; 
}

//Funcion para validar correos
function valcorreo( form ) {
	var expresiones1,resp = "";
	var minimo = 0;
	$("#"+form).find('input[type=email]').each(function(){

		correo = $(this).val();

		expresiones1 = /^[a-zA-Z]+\w*\.*-*_*\w*\.*-*_*\w*\.*-*_*\w*\.*-*_*\w*\.*-*_*\w*@(gmail)?(hotmail)?(outlook)?(sena)?(misena)?\.(es)?(com)?(co)?(com\.co)?(edu\.co)?/;

		if(!expresiones1.test(correo)||correo.length < 13){
			$(this).css('border-style','solid');
			$(this).css('border-color','red');
			minimo += 1;

		}
		else{
			$(this).removeAttr("style");
		}
	})
	if(minimo > 0){
		resp = false;
	}
	else{
		resp = true;
	}

	
	return resp;
}

//Funciones para cada tipo de alerta e(error),w(warning),s(success)

function alert_success( msg,alertConfig ) {
	toastr.success(msg);
}
function alert_error( msg,alertConfig ) {
	toastr.error(msg);
}
function alert_warning( msg,alertConfig ) {
	toastr.warning(msg);
}

function alert_info( msg,alertConfig ) {
	toastr.info(msg);
}

function alertas_e( msg ) {
	alertify.error(msg);
}

function alertas_w( msg ) {
	alertify.warning(msg);
}

function alertas_s( msg ) {
	alertify.success(msg);
}
//Funcion Eliminar con Framework Alertify Js
function deleteds( $title, $msjConfirm, $functionSi, $functionNo ){
	if( $functionNo == null ){
		alertify.confirm( $title, $msjConfirm, $functionSi, function(){} );
	}else{
		alertify.confirm( $title, $msjConfirm, $functionSi, $functionNo );
	}
}
//Configuracion alertas Toastr
toastr.options.preventDuplicates = true;
var alertConfig = toastr.options = {
	"closeButton": false,
	"debug": false,
	"newestOnTop": false,
	"progressBar": false,
	"positionClass": "toast-bottom-right",
	"preventDuplicates": true,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
  }