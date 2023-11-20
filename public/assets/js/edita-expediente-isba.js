const mainNode = document.querySelector('body');
mainNode.onload = configuraDetalle_OnLoad;

$(document).ready(function () {

	idExp = document.getElementById("id")
	programa = document.getElementById("programa")
	if (programa.value === "ILS") {
		compruebaEstadoDocumentosRequeridos(idExp.value)
	}
	$("#exped-fase-1").submit(function () {
		$("#send-exped-fase-1", this)
			.html("Actualitzant, un moment per favor.")
			.attr("disabled", "disabled")
			.css("background-color", "orange")
			.css("cursor", " progress");
	});
});

const form = document.getElementById('subir_faseExpedSolicitud');

function openFaseExped(evt, faseName, backgroundColor, id) {
	var i, tabcontent, tablinks;
	localStorage.removeItem("currentTab");
	localStorage.setItem("currentTab", faseName);

	tabcontent = document.getElementsByClassName("tab_fase_exp_content");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	tablinks = document.getElementsByClassName("tablinks");
	console.log ( `Total tabs: ${tablinks.length}` )
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
		tablinks[i].className = tablinks[i].className = "tablinks";
	}
	console.log ( `Current tab: ${faseName}` )
	document.getElementById(faseName).style.display = "block";

	switch(faseName) {
		case 'solicitud_tab':
			evt.currentTarget.className += " solicitud_tab";
		break;
		case 'validacion_tab':
			evt.currentTarget.className += " validacion_tab";
		break;
		case 'ejecucion_tab':
			evt.currentTarget.className += " ejecucion_tab";
		break;
		case 'justificacion_tab':
			evt.currentTarget.className += " justificacion_tab";
		break;
		case 'deses_ren_tab':
			evt.currentTarget.className += " deses_ren_tab";
		break;
		case 'adhesion_tab':
			evt.currentTarget.className += " adhesion_tab";
		break;
		default:
			evt.currentTarget.className += " detall_tab";
	}
}

function logSubmit(btnID) {
	document.getElementById(btnID).style.backgroundColor = "darkgray"
	document.getElementById(btnID).setAttribute("disabled", true)
	document.getElementById(btnID).value = "Un moment, estic pujant la documentació ..."
	for (let step = 0; step < 4; step++) {
		document.getElementsByClassName("form-group desistimiento")[step].style.opacity = "0.5"
	}
	//event.preventDefault();
}

function cambiaEstadoDoc(id) {
	let element = document.getElementById(id)
	let buttonID = id.split("#")[3]
	let elementDel = document.getElementById(id.split("#")[0]+"_del")
	
	switch (buttonID) {
		case 'file_escritura_empresa':
			buttonID = "myBtnEnviarFormularioEscrituraEmpresa"
			break
		case 'file_certificadoIAE':
			buttonID = "myBtnEnviarFormularioCertificadoIAE"
			break
		case 'file_informeResumenIls':
			buttonID = "myBtnEnviarFormularioInformeResumen"
			break
		case 'file_informeInventarioIls':
			buttonID = "myBtnEnviarInformeGEH"
			break
		case 'file_certificado_itinerario_formativo':
			buttonID = "myBtnEnviarFormularioItinerarioFormativo"
			break
		case 'file_modeloEjemploIls':
			buttonID = "myBtnEnviarFormularioCompromisoReduccion"
			break
		case 	'file_enviardocumentoIdentificacion':
			buttonID = "myBtnEnviarFormularioDocumentoIdentificacion"
			break
		case 	'file_certificadoATIB':
			buttonID = "myBtnEnviarFormularioCertificadoATIB"
			break
		case 	'file_certificadoSegSoc':
			buttonID = "myBtnEnviarFormularioCertificadoSegSoc"
			break
		case 'file_altaAutonomos':
			buttonID = "myBtnEnviarFormularioAltaAutonomos"
			break
		case 'file_certificadoAEAT':
			buttonID = "myBtnEnviarFormularioCertAEAT"
			break	
		case 'file_document_acred_como_repres':
			buttonID = "myBtnEnviarFormularioDocAcreditativa";
			break	
		case 'file_memoriaTecnica':
			buttonID = "myBtnEnviarFormularioMemTec";
			break
	}
	let button = document.getElementById(buttonID)
	element.style.color = "yellow";
	let estado = '';
	let stateChanged = false;
	if (element.innerHTML === 'Desconegut' && !stateChanged) {
		element.classList.remove("isa_caducado")
		element.classList.add("isa_info")
		element.innerHTML = "Pendent"
		elementDel.removeAttribute("disabled")
		if (button) {
			button.style.display = 'none'
			button.classList.remove("btn-primary")
		}
		estado = 'Pendent'
		stateChanged = true
	}
	if (element.innerHTML === 'Pendent' && !stateChanged) {
		element.classList.remove("isa_info")
		element.classList.add("isa_success")
		element.innerHTML = "Aprovat"
		elementDel.setAttribute("disabled", true);
		if (button) {
 			button.style.display = 'none'
			button.classList.remove("btn-primary")
		}
		estado = 'Aprovat'
		stateChanged = true
	}
	if (element.innerHTML === 'Aprovat' && !stateChanged) {
		element.classList.remove("isa_success")
		element.classList.add("isa_error")
		element.innerHTML = "Rebutjat"
		elementDel.removeAttribute("disabled")
		if (button) {
			button.style.display = 'block'
			button.classList.add("btn-primary")
		}
		estado = 'Rebutjat'
		stateChanged = true
	}
	if (element.innerHTML === 'Rebutjat' && !stateChanged) {
		element.classList.remove("isa_error")
		element.classList.add("isa_info")
		element.innerHTML = "Pendent"
		elementDel.removeAttribute("disabled")
		if (button) {
			button.style.display = 'none'
			button.classList.remove("btn-primary")
		}
		estado = 'Pendent';
		stateChanged = true;
	}
	stateChanged = false;
	
	urlUpdateDocState = "/public/assets/utils/actualiza_estado_documento.php"

	fetch ( `${urlUpdateDocState}?id=${id.split("#")[0]}&estado=${estado}`, {
		method: 'POST',
		headers: {
		  'Content-Type': 'application/json;charset=utf-8'
		}} ).then(
		data => {
			if (data) {
			send_fase_0.innerHTML = "Actualitzar"
			send_fase_0.className = "btn-itramits bth-success-itramits"
			send_fase_0.disabled = false
							}
		}
	)
}

function generaRequerimiento(idExp) {
	console.log ( "estoy en generar requerimiento" )
		$.post(
			"/public/assets/utils/obtiene_nombre_documentos.php",
			{ id: idExp },
			function (data) {
					$.post(
						"/public/assets/utils/actualiza_motivo_requerimiento_ils_en_expediente.php",
						{ id: idExp, textoMotivoReq: data },
						// 'data' contiene los nombres de los documentos en estado 'Rebutjat'
						// actualiza el campo 'motivoRequerimientoIls' con los nombres de los documentos rechazados para, luego, generar el requerimiento
						// actualizar el campo 'situación expediente' a "Requeriment signat"
						function (data) {
								window.open(`https://tramits.idi.es/public/index.php/expedientes/generaInformeILS/${idExp}/${convocatoria.value}/ILS/${nif.value}/doc_requeriment_ils`, "_self", "width=300, height=300")
								}
								)
			}
		)

}

function cambiaEstadoDocJustificacion(id) {
	
	let element = document.getElementById(id);
	let estado = '';
	let stateChanged = false;

	if (element.innerHTML === 'Desconegut' && !stateChanged) {
		element.classList.remove("isa_caducado");
		element.classList.add("isa_info"); 
		element.innerHTML = "Pendent";
		estado = 'Pendent';
		stateChanged = true;
	}
	if (element.innerHTML === 'Pendent' && !stateChanged) {
		element.classList.remove("isa_info");
		element.classList.add("isa_success"); 
		element.innerHTML = "Aprovat";
		estado = 'Aprovat';
		stateChanged = true;
	}
	 if (element.innerHTML === 'Aprovat' && !stateChanged) {
		element.classList.remove("isa_success");
		element.classList.add("isa_error"); 
		element.innerHTML = "Rebutjat";
		estado = 'Rebutjat';
		stateChanged = true;
	}
	if (element.innerHTML === 'Rebutjat' && !stateChanged) {
		element.classList.remove("isa_error");
		element.classList.add("isa_info"); 
		element.innerHTML = "Pendent";
		estado = 'Pendent';
		stateChanged = true;
	}
	stateChanged = false;

	$.post(
		"/public/assets/utils/actualiza_estado_documento_justificacion.php",
		{ id: id, estado: estado },
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_0.innerHTML = "Actualitzar";
				send_fase_0.className = "btn-itramits btn-success-itramits";
				send_fase_0.disabled = false;
			}
			for (let step = 0; step < 22; step++) {
				document.getElementsByClassName("form-group general")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_0_expediente_idi_isba(formName) {  //SE EMPLEA
	console.log("fase_0_idi_isba")
	if (!validateForm(formName)) {
		return;
	}

	let id = document.getElementById("id").value;

	let telefono_rep = document.getElementById("telefono_rep").value; // Mòbil a efectes de notificacions
	let email_rep = document.getElementById("email_rep").value; // Adreça electrònica a efectes de notificacions

	let tecnicoAsignado = document.getElementById("tecnicoAsignado").value; // Tècnica asignada
	let situacion_exped = document.getElementById("situacion_exped").value; // Situació


	for (let step = 0; step < 26; step++) {
		document.getElementsByClassName("form-group general")[step].style.opacity = "0.1";
	}
	
	let send_fase_0 = document.getElementById("send_fase_0");
	send_fase_0.innerHTML = "Un moment ...";
	send_fase_0.className = "btn-itramits warning-msg";
	send_fase_0.disabled = true;
	send_fase_0.ariaReadOnly = true;

	$.post(
		"/public/assets/utils/actualiza_fase_0_expediente_idi_isba.php",
		{ id: id, telefono_rep: telefono_rep, email_rep: email_rep,
			tecnicoAsignado: tecnicoAsignado, 
			situacion_exped: situacion_exped },
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_0.innerHTML = "Actualitzar";
				send_fase_0.className = "btn-itramits btn-success-itramits";
				send_fase_0.disabled = false;
			}
			for (let step = 0; step < 26; step++) {
				document.getElementsByClassName("form-group general")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_1_solicitud_expediente_idi_isba(formName) {  //SE EMPLEA
	console.log("fase_1_idi_isba")
	if (!validateForm(formName)) {
		alert ("nada que actualizar")
		return
	}

	let id = document.getElementById("id").value;
	let fecha_solicitud = document.getElementById("fecha_solicitud").value; // Data REC sol·licitud
	let fecha_completado = document.getElementById("fecha_completado").value; // Data complert
	let fecha_REC = document.getElementById("fecha_REC").value; // Data REC sol·licitud
	let ref_REC = document.getElementById("ref_REC").value; // Referència REC sol·licitud
	let fecha_REC_enmienda = document.getElementById("fecha_REC_enmienda").value; // Data REC esmena
	let ref_REC_enmienda = document.getElementById("ref_REC_enmienda").value; // ref_REC_enmienda
	let fecha_requerimiento = document.getElementById("fecha_requerimiento").value; // Data firma requeriment
	let fecha_requerimiento_notif = document.getElementById("fecha_requerimiento_notif").value; // Data notificació requeriment
	let fecha_maxima_enmienda  = document.getElementById("fecha_maxima_enmienda").value; // Data màxima per esmenar

	for (let step = 0; step < 6; step++) {
		document.getElementsByClassName("form-group solicitud")[step].style.opacity = "0.1";
	}

	let send_fase_1 = document.getElementById("send_fase_1");
	send_fase_1.innerHTML = "Un moment ...";
	send_fase_1.className = "btn-itramits warning-msg";
	send_fase_1.disabled = true;
	console.log("actualizando ...")
	$.post(
		"/public/assets/utils/actualiza_fase_1_solicitud_expediente_ils.php",
		{ id: id, fecha_solicitud: fecha_solicitud, fecha_completado: fecha_completado, fecha_REC: fecha_REC, ref_REC: ref_REC, 
			fecha_REC_enmienda: fecha_REC_enmienda, ref_REC_enmienda: ref_REC_enmienda,
			fecha_requerimiento: fecha_requerimiento, fecha_requerimiento_notif: fecha_requerimiento_notif, fecha_maxima_enmienda: fecha_maxima_enmienda },
		
		function (data) {
			console.log(`${data}`)
			$(".result").html(data);
			if (data == 1) {
				send_fase_1.innerHTML = "Actualitzar";
				send_fase_1.className = "btn-itramits btn-success-itramits";
				send_fase_1.disabled = false;
			}
			for (let step = 0; step < 6; step++) {
				document.getElementsByClassName("form-group solicitud")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_2_validacion_expediente_idi_isba(formName) {  //SE EMPLEA
	console.log("fase_2_idi_isba")
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_infor_fav = document.getElementById("fecha_infor_fav").value; // Data firma informe favorable
	let fecha_infor_desf = document.getElementById("fecha_infor_desf").value; // Data firma informe desfavorable
	let fecha_resolucion = document.getElementById("fecha_resolucion").value; // Data firma resolución
	let fecha_notificacion_resolucion = document.getElementById("fecha_notificacion_resolucion").value; // Data notificació resolució

	for (let step = 0; step < 4; step++) {
		document.getElementsByClassName("form-group validacion")[step].style.opacity = "0.1";
	}

	let send_fase_2 = document.getElementById("send_fase_2");
	send_fase_2.innerHTML = "Un moment ...";
	send_fase_2.className = "btn-itramits warning-msg";
	send_fase_2.disabled = true;
	$.post(
		"/public/assets/utils/actualiza_fase_2_validacion_expediente_ils.php",
		{ id: id, fecha_infor_fav: fecha_infor_fav, fecha_infor_desf: fecha_infor_desf, 
			fecha_resolucion: fecha_resolucion, fecha_notificacion_resolucion: fecha_notificacion_resolucion },
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_2.innerHTML = "Actualitzar";
				send_fase_2.className = "btn-itramits btn-success-itramits";
				send_fase_2.disabled = false;
			}
			for (let step = 0; step < 4; step++) {
				document.getElementsByClassName("form-group validacion")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_3_ejecucion_expediente_idi_isba(formName) {  //SE EMPLEA
	console.log("fase_3_idi_isba")
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_adhesion_ils = document.getElementById("fecha_adhesion_ils").value; // Data adhesió
	let fecha_seguimiento_adhesion_ils = document.getElementById("fecha_seguimiento_adhesion_ils").value; // Data seguiment
	let fecha_limite_presentacion = document.getElementById("fecha_limite_presentacion").value; // Data límit presentació
	let fecha_rec_informe_seguimiento = document.getElementById("fecha_rec_informe_seguimiento").value; // Data REC informe seguiment
	let ref_REC_informe_seguimiento = document.getElementById("ref_REC_informe_seguimiento").value; //Ref. REC informe seguiment 

	for (let step = 0; step < 5; step++) {
		document.getElementsByClassName("form-group ejecucion")[step].style.opacity = "0.1";
	}

	let send_fase_3 = document.getElementById("send_fase_3");
	send_fase_3.innerHTML = "Un moment ...";
	send_fase_3.className = "btn-itramits warning-msg";
	send_fase_3.disabled = true;

	$.post(
		"/public/assets/utils/actualiza_fase_3_ejecucion_expediente_ils.php",
		{ id: id, fecha_adhesion_ils: fecha_adhesion_ils, fecha_seguimiento_adhesion_ils: fecha_seguimiento_adhesion_ils,
			fecha_limite_presentacion: fecha_limite_presentacion, fecha_rec_informe_seguimiento: fecha_rec_informe_seguimiento,
			ref_REC_informe_seguimiento: ref_REC_informe_seguimiento
		 },
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_3.innerHTML = "Actualitzar";
				send_fase_3.className = "btn-itramits btn-success-itramits";
				send_fase_3.disabled = false;
			}
			for (let step = 0; step < 5; step++) {
				document.getElementsByClassName("form-group ejecucion")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_4_justificacion_expediente_idi_isba(formName) {  //SE EMPLEA
	console.log("fase_0_idi_isba")
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_solicitud = document.getElementById("fecha_solicitud").value; // Data REC sol·licitud
	let fecha_completado = document.getElementById("fecha_completado").value; // Data complert
	let fecha_REC_justificacion = document.getElementById("fecha_REC_justificacion").value; // Data REC justificació
	let ref_REC_justificacion = document.getElementById("ref_REC_justificacion").value; // Referència REC justificació
	let fecha_res_liquidacion = document.getElementById("fecha_res_liquidacion").value; // Data informe liquidació
	let fecha_not_liquidacion = document.getElementById("fecha_not_liquidacion").value; // Data notificació liquidació
	let fecha_firma_requerimiento_justificacion = document.getElementById("fecha_firma_requerimiento_justificacion").value; // Data firma requeriment justificació
	let fecha_REC_requerimiento_justificacion = document.getElementById("fecha_REC_requerimiento_justificacion").value; // Data REC requeriment justificació
	let ref_REC_requerimiento_justificacion = document.getElementById("ref_REC_requerimiento_justificacion").value; // Referència REC requeriment justificació

	for (let step = 0; step < 7; step++) {
		document.getElementsByClassName("form-group justificacion")[step].style.opacity = "0.1";
	}

	let send_fase_4 = document.getElementById("send_fase_4");
	send_fase_4.innerHTML = "Un moment ...";
	send_fase_4.className = "btn-itramits warning-msg";
	send_fase_4.disabled = true;
	$.post(
		"/public/assets/utils/actualiza_fase_4_justificacion_expediente.php",
		{ id: id, fecha_solicitud: fecha_solicitud, fecha_completado: fecha_completado, fecha_REC_justificacion: fecha_REC_justificacion, 
			ref_REC_justificacion:ref_REC_justificacion,
			fecha_res_liquidacion: fecha_res_liquidacion, fecha_not_liquidacion: fecha_not_liquidacion,
			fecha_firma_requerimiento_justificacion: fecha_firma_requerimiento_justificacion,
			fecha_REC_requerimiento_justificacion: fecha_REC_requerimiento_justificacion,
			ref_REC_requerimiento_justificacion: ref_REC_requerimiento_justificacion
		},
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_4.innerHTML = "Actualitzar";
				send_fase_4.className = "btn-itramits btn-success-itramits";
				send_fase_4.disabled = false;
			}
			for (let step = 0; step < 7; step++) {
				document.getElementsByClassName("form-group justificacion")[step].style.opacity = "1.0";
			}			
		}
	);
}

function validateForm(formName) {
	for(i=0; i < document.getElementById(formName).elements.length; i++){
		if(document.getElementById(formName).elements[i].value == "" && document.getElementById(formName).elements[i].required){
			alert("Falta rellenar algún campo")
			document.forms[formName].elements[i].focus()
			return false		
		}
	}
	return true
}

function avisarCambiosEnFormulario(fase, elemento) {
	let respuesta = false;
	return
	if (elemento === "porcentajeConcedido") {
			let actualizaimporteAyuda = "/public/assets/utils/actualiza_importe_ayuda.php?"+document.getElementById("programa").value+"/"+document.getElementById("porcentajeConcedido").value+"/"+document.getElementById("id").value;
			fetch(actualizaimporteAyuda)
				.then((response) => response.text())
				.then((data) => {
					document.getElementById("importeAyuda").value = data;
				});
	}

	if (elemento === "ordenDePago") {
		if (document.getElementById(elemento).value === "SI") {
			let dateObj = new Date();
			let month = String(dateObj.getMonth() + 1).padStart(2, '0');
			let year = dateObj.getFullYear();
			let day = String(dateObj.getDate()).padStart(2, '0');
			date = year+"-"+month+"-"+day;
			console.log(elemento +"-"+ date)
			document.getElementById("fechaEnvioAdministracion").value = date;
		} else {
			document.getElementById("fechaEnvioAdministracion").value = '';
		}
		document.getElementById("fechaEnvioAdministracion").style.backgroundColor = "#000dff";
		document.getElementById("fechaEnvioAdministracion").style.color = "#fff";

	}

	document.getElementById(fase).className = "error-msg";
}

function actualizaFechas(fechaCierre, dias) {
	let d = new Date(fechaCierre);
	d.setDate(d.getDate() + dias);
	if (d.getDay() == 6) {  //La fecha cae en Sábado hay que pasar la al primer lunes (+2 días)
		d.setDate(d.getDate()+2);
	}
	if (d.getDay() == 0) {  //La fecha cae en Domingo hay que pasar la al primer lunes (+1 días)
		d.setDate(d.getDate()+1);
	}

	document.getElementById("fecha_reunion_cierre_modal").value = fechaCierre;
	document.getElementById("fecha_limite_justificacion").value = d.toISOString().substr(0, 10);
	document.getElementById("fecha_limite_justificacion_modal").value = d.toISOString().substr(0, 10);

	let valorFechaJustificacion = document.getElementById("fecha_limite_justificacion").value;
	let actualizaKickOff = "/public/assets/utils/actualiza_fechas_Cierre.php?"+ fechaCierre+"/"+valorFechaJustificacion+"/"+document.getElementById("id").value;
	fetch(actualizaKickOff)
		.then((response) => response.text())
		.then((data) => {
			let resultadoP = document.getElementById("fecha_kick_off");
			let cell = document.createElement("span");
			let cellText = document.createTextNode(data);
			cell.appendChild(cellText);
			resultadoP.appendChild(cell);
			resultadoP.setAttribute("border", "2");
		});
}

function actualizaRequired(valor) {

}

function actualizaMotivoRequerimiento_idi_isba_click() {  //SE EMPLEA
	let textoMotivoReq = document.getElementById("motivoRequerimientoIdiIsba").value;
	let id = document.getElementById("id").value;
	/* let modal = document.getElementById("myRequerimientoIdiIsba"); */
	if ( textoMotivoReq === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_requerimiento_en_expediente.php",
		{ id: id, textoMotivoReq: textoMotivoReq },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoRequerimientoIdiIsba").remove = "ocultar";
				document.getElementById("wrapper_motivoRequerimientoIdiIsba").className = "btn btn-primary";
				//modal.style.display = "none";
				//$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				//document.getElementById("wrapper_generaRequerimiento").style.display = "none";
			}
		}
	);
}

function actualizaMotivoInicioRequerimiento_click() {  //SE EMPLEA
	let textoMotivoReq = document.getElementById("motivoInicioRequerimiento").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("myInicioRequerimiento");
	if ( textoMotivoReq === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_inicio_requerimiento_en_expediente.php",
		{ id: id, textoMotivoReq: textoMotivoReq },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_inicio_req_subsanacion").remove = "ocultar";
				document.getElementById("wrapper_inicio_req_subsanacion").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function actualizaMotivoRequerimientoJustificacion_click() {  //SE EMPLEA
	let textoMotivoReq = document.getElementById("motivoRequerimientoJustificacion").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("myRequerimientoJustificacion");
	if ( textoMotivoReq === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}	
	$.post(
		"/public/assets/utils/actualiza_motivo_requerimiento_justificacion_en_expediente.php",
		{ id: id, textoMotivoReq: textoMotivoReq },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_generadoc_req_justificacion").remove = "ocultar";
				document.getElementById("wrapper_generadoc_req_justificacion").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				//document.getElementById("wrapper_generaRequerimiento").style.display = "none";
			}
		}
	);
}

function actualizaMotivoInformeSobreSubsanacion_click() { //SE EMPLEA
	let textoMotivoInforme = document.getElementById("motivoSobreSubsanacion").value;
	let propuestaTecnicoSobreSubsanacion = document.getElementById("propuestaTecnicoSobreSubsanacion").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("mySobreSubsanacionRequerimiento");
	if ( textoMotivoInforme === "" || propuestaTecnicoSobreSubsanacion === "" ) {
		alert ("Falta indicar el que exposa y/o el que proposa.")
		return;
	}	
	$.post(
		"/public/assets/utils/actualiza_motivo_informe_sobre_subsanacion_en_expediente.php",
		{ id: id, textoMotivoInforme: textoMotivoInforme, propuestaTecnicoSobreSubsanacion: propuestaTecnicoSobreSubsanacion },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_informe_sobre_subsanacion").remove = "ocultar";
				document.getElementById("wrapper_informe_sobre_subsanacion").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				//document.getElementById("wrapper_generaRequerimiento").style.display = "none";
			}
		}
	);
}

function actualizaMotivoDesestimientoRenuncia_click() {  //SE EMPLEA
	let textoMotivoRenuncia = document.getElementById("motivoDesestimientoRenuncia").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("myDesestimientoRenuncia");
	if ( textoMotivoRenuncia === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_desestimiento_renuncia_en_expediente.php",
		{ id: id, textoMotivoRenuncia: textoMotivoRenuncia },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoDesestimientoRenuncia").remove = "ocultar";
				document.getElementById("wrapper_motivoDesestimientoRenuncia").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				//document.getElementById("wrapper_generaRequerimiento").style.display = "none";
			}
		}
	);
}

function actualizaMotivoRevocacionPorNoJustificar_click() {  //SE EMPLEA
	let textoRevocacionPorNoJustificar = document.getElementById("textoRevocacionPorNoJustificar").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("myDesestimientoRenuncia");
	if ( textoRevocacionPorNoJustificar === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}
	console.log (textoRevocacionPorNoJustificar, id, modal)
	$.post(
		"/public/assets/utils/actualiza_motivo_revocacion_por_no_justificar_en_expediente.php",
		{ id: id, textoRevocacionPorNoJustificar: textoRevocacionPorNoJustificar },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoRevocacionPorNoJustificar").remove = "ocultar";
				document.getElementById("wrapper_motivoRevocacionPorNoJustificar").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				//document.getElementById("wrapper_generaRequerimiento").style.display = "none";
			}
		}
	);
}

function actualizaMotivoDenegacion_click() {  //SE EMPLEA
	let textoMotivoDenegacion = document.getElementById("motivoDenegacion_7").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("myDenegacion_7");
	if ( textoMotivoDenegacion === "") {
		alert ("Falta indicar el motiu de la denegació")
		return
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_denegacion_en_expediente.php",
		{ id: id, textoMotivoDenegacion: textoMotivoDenegacion },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoDenegacion_7").remove = "ocultar";
				document.getElementById("wrapper_motivoDenegacion_7").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				document.getElementById("wrapper_generaDenegacion_7").style.display = "none";
			}
		}
	);
}

function actualizaMotivoDenegacionSinReq_click() {  //SE EMPLEA
	let textoMotivoDenegacion = document.getElementById("motivoDenegacion_8").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("myDenegacion_8");
	if ( textoMotivoDenegacion === "") {
		alert ("Falta indicar el motiu de la denegació")
		return
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_denegacion_en_expediente.php",
		{ id: id, textoMotivoDenegacion: textoMotivoDenegacion },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoDenegacion_8").remove = "ocultar";
				document.getElementById("wrapper_motivoDenegacion_8").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
				document.getElementById("wrapper_generaDenegacion_8").style.display = "none";
			}
		}
	);
}

function actualizaMotivoResolucionRevocacionPorNoJustificar_click() {  //SE EMPLEA
	let textoMotivoRevocacion = document.getElementById("motivoResolucionRevocacionPorNoJustificar").value;
	let id = document.getElementById("id").value;
	if ( textoMotivoRevocacion === "") {
		alert ("Falta indicar el motiu de la revocació")
		return
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_Revocacion_en_expediente.php",
		{ id: id, textoMotivoRevocacion: textoMotivoRevocacion },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoResolucionRevocacionPorNoJustificar").remove = "ocultar";
				document.getElementById("wrapper_motivoResolucionRevocacionPorNoJustificar").className = "btn btn-primary";
			}
		}
	);
}

function actualizaMotivoDesfavorable_click() {
	let textoMotivo = document.getElementById("motivogeneraInformeDesfSinReq").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("mygeneraInformeDesfSinReq");
	if ( textoMotivo === "" ) {
		alert ("Falta indicar el motiu")
		return
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_generaInformeDesfReq_en_expediente.php",
		{ id: id, textoMotivo: textoMotivo },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_generaInformeDesfSinReq").remove = "ocultar";
				document.getElementById("wrapper_generaInformeDesfSinReq").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function actualizaMotivoDesfavorableConReqIls_click() {
	let textoMotivo = document.getElementById("motivogeneraInformeDesfConReqIls").value;
	let id = document.getElementById("id").value;
	var modal = document.getElementById("mygeneraInformeDesfConReqIls");

	$.post(
		"/public/assets/utils/actualiza_motivo_generaInformeDesfReq_ils_en_expediente.php",
		{ id: id, textoMotivo: textoMotivo },
		function (data) {
			$(".result").html(data);
			console.log("## " + data + " ##");
			if (data == 1) {
				document.getElementById("wrapper_generaInformeDesfConReqIls").remove = "ocultar";
				document.getElementById("wrapper_generaInformeDesfConReqIls").className = "btn btn-primary";				
				document.getElementById("wrapper_motivogeneraInformeDesfConReqIls").remove = "ocultar";
				document.getElementById("wrapper_motivogeneraInformeDesfConReqIls").className = "enviararchivo_ver";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function actualizaMotivoDesfavorableConReq_click() {
	let textoMotivo = document.getElementById("motivogeneraInformeDesfConReq").value;
	let id = document.getElementById("id").value;
	var modal = document.getElementById("mygeneraInformeDesfConReq");
	if ( textoMotivo === "") {
		alert ( "Falta indicar el motiu")
		return
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_generaInformeDesfReq_en_expediente.php",
		{ id: id, textoMotivo: textoMotivo },
		function (data) {
			$(".result").html(data);
			console.log("##" + data + "##");
			if (data == 1) {
				document.getElementById("wrapper_generaInformeDesfConReq").remove = "ocultar";
				document.getElementById("wrapper_generaInformeDesfConReq").className = "btn btn-primary";				
				document.getElementById("wrapper_motivogeneraInformeDesfConReq").remove = "ocultar";
				document.getElementById("wrapper_motivogeneraInformeDesfConReq").className = "enviararchivo_ver";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function enviaAFirmaRequerimiento_click(parametro) {
	$("#enviaAFirmaRequerimiento", parametro)
		.html("Actualitzant, un moment per favor.")
		.attr("disabled", "disabled")
		.css("background-color", "orange")
		.css("cursor", " progress");
}

function actualizaMotivoactaDeKickOff_click() {
	let actaNumKickOff = document.getElementById("actaNumKickOff").value;
	let fecha_kick_off = document.getElementById("fecha_kick_off_modal").value;
	let horaInicioSesionKickOff = document.getElementById("horaInicioSesionKickOff").value;
	let horaFinSesionKickOff = document.getElementById("horaFinSesionKickOff").value;
	let lugarSesionKickoff = document.getElementById("lugarSesionKickoff").value;
	let asistentesKickOff = document.getElementById("asistentesKickOff").value;
	let tutorKickOff = document.getElementById("tutorKickOff").value;
	let plazoRealizacionPlan = document.getElementById("plazoRealizacionPlan").value;
	let fecha_HastaRealizacionPlan = document.getElementById("fecha_HastaRealizacionPlan").value;
	let observacionesKickOff = document.getElementById("observacionesKickOff").value;
	let id = document.getElementById("id").value;
	var modal = document.getElementById("myactaDeKickOff");

	$.post(
		"/public/assets/utils/actualiza_acta_kickOff_en_expediente.php",
		{ id: id, actaNumKickOff: actaNumKickOff, fecha_kick_off: fecha_kick_off, horaInicioSesionKickOff: horaInicioSesionKickOff,  
			horaFinSesionKickOff: horaFinSesionKickOff, lugarSesionKickoff: lugarSesionKickoff, asistentesKickOff: asistentesKickOff,
			tutorKickOff: tutorKickOff, plazoRealizacionPlan:plazoRealizacionPlan, 
			fecha_HastaRealizacionPlan: fecha_HastaRealizacionPlan, observacionesKickOff: observacionesKickOff},
		function (data) {
			//$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_actaDeKickOff").remove = "ocultar";
				document.getElementById("wrapper_actaDeKickOff").className = "btn btn-primary";	
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in064
			}
		}
	);
}

function actualizaActaCierre_click() {
	let actaNumCierre = document.getElementById("actaNumCierre").value;
	let fecha_reunion_cierre = document.getElementById("fecha_reunion_cierre_modal").value;
	let horaInicioActaCierre = document.getElementById("horaInicioActaCierre").value;
	let horaFinActaCierre = document.getElementById("horaFinActaCierre").value;
	let lugarActaCierre = document.getElementById("lugarActaCierre").value;
	let asistentesActaCierre = document.getElementById("asistentesActaCierre").value;
	let fecha_limite_justificacion_modal = document.getElementById("fecha_limite_justificacion_modal").value;
	let observacionesActaCierre = document.getElementById("observacionesActaCierre").value;
	let id = document.getElementById("id").value;
	var modal = document.getElementById("myActaDeCierre");

	$.post(
		"/public/assets/utils/actualiza_acta_cierre_en_expediente.php",
		{ id: id, actaNumCierre: actaNumCierre, fecha_reunion_cierre: fecha_reunion_cierre, horaInicioActaCierre: horaInicioActaCierre,  
			horaFinActaCierre: horaFinActaCierre, lugarActaCierre: lugarActaCierre,
			asistentesActaCierre: asistentesActaCierre, fecha_limite_justificacion_modal: fecha_limite_justificacion_modal, 
			observacionesActaCierre: observacionesActaCierre},
		function (data) {
			//$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_ActaDeCierre").remove = "ocultar";
				document.getElementById("wrapper_ActaDeCierre").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function enviaMailJustificacion_click() {
	let id = document.getElementById("id").value;
	var modal = document.getElementById("myEnviarJustificador");
	document.getElementById("spinner_151").classList.remove("ocultar");
	document.getElementById("enviaMailJustificacion").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoJustificacion.php",
		{ id: id },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_151").classList.add("ocultar");
				document.getElementById("enviaMailJustificacion").style.display = "none";
				document.getElementById("mensaje").classList.remove("ocultar");
				document.getElementById("mensaje").innerHTML = data;
				//$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function enviaMailFormEmpresa_click() {
	let id = document.getElementById("id").value;
	var modal = document.getElementById("myEnviarFormularioEmpresa");
	document.getElementById("spinner_17ils1").classList.remove("ocultar");
	document.getElementById("enviaMailFormEmpresa").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoFormEmpresa.php",
		{ id: id },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_17ils1").classList.add("ocultar");
				document.getElementById("enviaMailFormEmpresa").style.display = "none";
				document.getElementById("mensaje").classList.remove("ocultar");
				document.getElementById("mensaje").innerHTML = data;
			}
		}
	);
}

function enviaMailEscrituraEmpresa_click() {
	let id = document.getElementById("id").value;
	let id_doc = document.getElementById("id_doc_ESCRITURA").value;

	var modal = document.getElementById("myEnviarFormularioEscrituraEmpresa");
	document.getElementById("spinner_EscrituraEmpresa").classList.remove("ocultar");
	document.getElementById("enviaMailEscrituraEmpresa").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoEscrituraEmpresa.php",
		{ id: id, id_doc:id_doc },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_EscrituraEmpresa").classList.add("ocultar");
				document.getElementById("enviaMailEscrituraEmpresa").style.display = "none";
				document.getElementById("mensajeEscrituraEmpresa").classList.remove("ocultar");
				document.getElementById("mensajeEscrituraEmpresa").innerHTML = data;
			}
		}
	);
}

function enviaMailCertificadoIAE_click() {
	let id = document.getElementById("id").value;
	let id_doc = document.getElementById("id_doc_IAE").value;

	var modal = document.getElementById("myEnviarFormularioCertificadoIAE");
	document.getElementById("spinner_CertificadoIAE").classList.remove("ocultar");
	document.getElementById("enviaMailCertificadoIAE").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoCertificadoIAE.php",
		{ id: id, id_doc:id_doc },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_CertificadoIAE").classList.add("ocultar");
				document.getElementById("enviaMailCertificadoIAE").style.display = "none";
				document.getElementById("mensajeCertificadoIAE").classList.remove("ocultar");
				document.getElementById("mensajeCertificadoIAE").innerHTML = data;
			}
		}
	);
}

function enviaMailDocumentoIdentificacion_click() {
	let id = document.getElementById("id").value;
	let id_doc = document.getElementById("id_doc_IDSOL").value;

	var modal = document.getElementById("myEnviarFormularioDocumentoIdentificacion");
	document.getElementById("spinner_DocumentoIdentificacion").classList.remove("ocultar");
	document.getElementById("enviaMailDocumentoIdentificacion").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoDocumentoIdentificacion.php",
		{ id: id, id_doc:id_doc },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_DocumentoIdentificacion").classList.add("ocultar");
				document.getElementById("enviaMailDocumentoIdentificacion").style.display = "none";
				document.getElementById("mensajeDocumentoIdentificacion").classList.remove("ocultar");
				document.getElementById("mensajeDocumentoIdentificacion").innerHTML = data;
			}
		}
	);
}

function enviaMailCertificadoSegSoc_click() {
	let id = document.getElementById("id").value;
	let id_doc = document.getElementById("id_doc_TGSS").value;

	var modal = document.getElementById("myEnviarFormularioCertificadoSegSoc");
	document.getElementById("spinner_CertificadoSegSoc").classList.remove("ocultar");
	document.getElementById("enviaMailCertificadoSegSoc").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoCertificadoSegSoc.php",
		{ id: id, id_doc:id_doc },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_CertificadoSegSoc").classList.add("ocultar");
				document.getElementById("enviaMailCertificadoSegSoc").style.display = "none";
				document.getElementById("mensajeCertificadoSegSoc").classList.remove("ocultar");
				document.getElementById("mensajeCertificadoSegSoc").innerHTML = data;
			}
		}
	);
}

function enviaMailCertificadoATIB_click() {
	let id = document.getElementById("id").value;
	let id_doc = document.getElementById("id_doc_ATIB").value;

	var modal = document.getElementById("myEnviarFormularioCertificadoATIB");
	document.getElementById("spinner_CertificadoATIB").classList.remove("ocultar");
	document.getElementById("enviaMailCertificadoATIB").disabled.true;
	$.post(
		"/public/assets/utils/enviaCorreoElectronicoCertificadoATIB.php",
		{ id: id, id_doc:id_doc },
		function (data) {
			console.log(data);
			if (data) {
				document.getElementById("spinner_CertificadoATIB").classList.add("ocultar");
				document.getElementById("enviaMailCertificadoATIB").style.display = "none";
				document.getElementById("mensajeCertificadoATIB").classList.remove("ocultar");
				document.getElementById("mensajeCertificadoATIB").innerHTML = data;
			}
		}
	);
}

async function insertaMejoraEnSolicitud() {
	let addMejora = document.getElementById('addMejora')
	let idSol = document.getElementById('id')
	let fechaRecMejora = document.getElementById('fechaRecMejora')
	let refRecMejora = document.getElementById('refRecMejora')

		if (!fechaRecMejora.value || !refRecMejora.value) {
			return
		}

	let API_URI = `/public/assets/utils/inserta_mejora_solicitud.php?id_sol=${idSol.value}&fechaRecMejora=${fechaRecMejora.value}&refRecMejora=${refRecMejora.value}`;

	addMejora.innerHTML = "<div class='.info-msg'>Un moment, <br>afegint ...</div>"
	await fetch(API_URI)
		.then((response) => response.text())
		.then((data) => {
			location.reload();
		})

}

function myFunction_docs_IDI_click (id, nombre) {
	localStorage.setItem("documento_actual", id);
}

function opcion_seleccionada_click(respuesta) {
	document.cookie = "respuesta = " + respuesta;
}

function eliminaArchivoDocIDI_click() {
	let id = getCookie("documento_actual");
	let corresponde_documento = "file_resguardoREC";
	$.post(
		"/public/assets/utils/delete_documento_expediente.php",
		{ id: id, corresponde_documento: corresponde_documento },
		function (data) {
			location.reload();
		}
	);
}

function myFunction_click(id, nombre) {
	document.cookie = "documento_actual = " + id;
	console.log("++" + id + "++");
}

function eliminaArchivo_click() {
	console.log(getCookie("documento_actual"));
	let id = getCookie("documento_actual");
	console.log(getCookie("nuevo_estado"));
	let corresponde_documento = "file_resguardoREC";
	$.post(
		"/public/assets/utils/delete_documento_expediente.php",
		{ id: id, corresponde_documento: corresponde_documento },
		function (data) {
			location.reload();
		}
	);
}

function checkCookie() { 
	var username = getCookie("username");
	if (username != "") {
		alert("Welcome again " + username);
	} else {
		username = prompt("Please enter your name:", "");
		if (username !== "" && username !== null) {
			setCookie("username", username, 365);
		}
	}
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/" + ";SameSite=Strict";
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(";");
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === " ") {
			c = c.substring(1);
		}
		if (c.indexOf(name) === 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function goBack() {   //SE EMPLEA
	window.history.back()
}

async function configuraDetalle_OnLoad () {

	let obtieneSello, estadoFirma;
	let i=0, src, publicId;
	console.log ("estoy en onload")
	
	tabcontent = document.getElementsByClassName("tab_fase_exp_content");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
		tablinks[i].className = tablinks[i].className = "tablinks";
	}

	document.getElementById(localStorage.getItem("currentTab")).style.display = "block";
	switch(localStorage.getItem("currentTab")) {
		case 'solicitud_tab':
			document.getElementById('solicitud_tab_selector').className += " solicitud_tab";
			break;
		case 'validacion_tab':
			document.getElementById('validacion_tab_selector').className += " validacion_tab";
			break;
		case 'ejecucion_tab':
			document.getElementById('ejecucion_tab_selector').className += " ejecucion_tab";
			break;
		case 'justificacion_tab':
			document.getElementById('justifiacion_tab_selector').className += " justificacion_tab";
			break;
		case 'deses_ren_tab':
			document.getElementById('deses_ren_tab_selector').className += " deses_ren_tab";
			break;
		default:
			document.getElementById('detall_tab_selector').className += " detall_tab";
	}

	/**
	 * añado el evento onchange a todos los input tipo file para el control caracteres extendidos en el nombre del archivo
	 *  
	 * */
	const inputs = document.querySelectorAll('input.fileLoader');
	for(let i = 0; i < inputs.length ; i++) {
		inputs[i].addEventListener('change', function(){
			detectExtendedASCII(this.id, this.files);
		}, false);
		inputs[i].style.backgroundColor = "white";
		inputs[i].style.color = "black";
	}

	/**
	 * fase_0: añado el evento oninput a todos los input text, date y number y a los select para detectar que se ha cambiado algo y avisar que se tiene que guardar
	 *  
	 * */
	const inputsform_f0 = document.querySelectorAll('input.send_fase_0');
	for(let i = 0; i < inputsform_f0.length ; i++) {
		inputsform_f0[i].addEventListener('input', function(){
			avisarCambiosEnFormulario('send_fase_0', this.id);
		}, false);
		inputsform_f0[i].style.backgroundColor = "#cccccc";
		inputsform_f0[i].style.border = "1px solid #000";
	}
	
	const selectform_f0 = document.querySelectorAll('select.send_fase_0');
	for(let i = 0; i < selectform_f0.length ; i++) {
		selectform_f0[i].addEventListener('input', function(){
			 avisarCambiosEnFormulario('send_fase_0', this.id);
		 }, false);
		 selectform_f0[i].style.backgroundColor = "#cccccc";
		 selectform_f0[i].style.border = "1px solid #000";
		 selectform_f0[i].style.color = "white";
	}
	
	/**
	 * fase_1: añado el evento oninput a todos los input text, date y number para detectar que se ha cambiado algo y avisar que se tiene que guardar
	 *  
	 * */
	 const inputsform_f1 = document.querySelectorAll('input.send_fase_1');
	 for(let i = 0; i < inputsform_f1.length ; i++) {
		inputsform_f1[i].addEventListener('input', function(){
			 avisarCambiosEnFormulario('send_fase_1', this.id);
		 }, false);
		 inputsform_f1[i].style.backgroundColor = "#080081";
		 inputsform_f1[i].style.color = "white";
		}
	/**
	 * fase_2: añado el evento oninput a todos los input text, date y number para detectar que se ha cambiado algo y avisar que se tiene que guardar
	 *  
	 * */
	 const inputsform_f2 = document.querySelectorAll('input.send_fase_2');
	 for(let i = 0; i < inputsform_f2.length ; i++) {
		inputsform_f2[i].addEventListener('input', function(){
			 avisarCambiosEnFormulario('send_fase_2', this.id);
		 }, false);
		 inputsform_f2[i].style.backgroundColor = "#b23cfd";
		 inputsform_f2[i].style.color = "white";
		  }
	
	/**
	 * fase_3: añado el evento oninput a todos los input text, date y number para detectar que se ha cambiado algo y avisar que se tiene que guardar
	 *  
	 * */
		 const inputsform_f3 = document.querySelectorAll('input.send_fase_3');
		 for(let i = 0; i < inputsform_f3.length ; i++) {
			inputsform_f3[i].addEventListener('input', function(){
				 avisarCambiosEnFormulario('send_fase_3', this.id);
			 }, false);
			 inputsform_f3[i].style.backgroundColor = "#fffb0b";
			 inputsform_f3[i].style.color = "black";
			  }
	
	/**
	 * fase_4: añado el evento oninput a todos los input text, date y number para detectar que se ha cambiado algo y avisar que se tiene que guardar
	 *  
	 * */
		 const inputsform_f4 = document.querySelectorAll('input.send_fase_4');
		 for(let i = 0; i < inputsform_f4.length ; i++) {
			inputsform_f4[i].addEventListener('input', function(){
				 avisarCambiosEnFormulario('send_fase_4', this.id);
			 }, false);
			 inputsform_f4[i].style.backgroundColor = '#f37020';
			 inputsform_f4[i].style.color = "white";
			  }
	/**
	 * fase_5: añado el evento oninput a todos los input text, date y number para detectar que se ha cambiado algo y avisar que se tiene que guardar
	 *  
	 * */
		 const inputsform_f5 = document.querySelectorAll('input.send_fase_5');
		 for(let i = 0; i < inputsform_f5.length ; i++) {
			inputsform_f5[i].addEventListener('input', function(){
				 avisarCambiosEnFormulario('send_fase_5', this.id);
			 }, false);
			 inputsform_f5[i].style.backgroundColor = '#782400';
			 inputsform_f5[i].style.color = "white";
			  }
}

async function obtieneEstadoDelSello (publicId) {
	let API_URI = "/public/assets/utils/comprobarEstadoSello.php?publicAccessId="+ publicId;
	await fetch(API_URI)
		.then((response) => response.text())
		.then((data) => {
			switch (data)
		{
		case 'NOT_STARTED':
			estadoFirma = "<div class='info-msg'><i class='fa fa-info-circle'></i> Document Pendent de custodiar</div>";				
			break;
		case 'REJECTED':
			estadoFirma = "<div class = 'warning-msg'><i class='fa fa-warning'></i> Document rebutjat</div>";			
			break;
		case 'COMPLETED':
			estadoFirma = "<div class='success-msg'><i class='fa fa-check'></i> Document custodiat</div>";						
			break;
		case 'IN_PROCESS':
			estadoFirma = "<div class='info-msg'><i class='fa fa-info-circle'></i> En curs</div>";
			break;					
		default:
			estadoFirma = "<div class='info-msg'><i class='fa fa-info-circle'></i> Desconegut</div>";
		}
		document.getElementById (publicId).innerHTML = estadoFirma;
		});
}

function detectExtendedASCII(tipoDoc, files) {
	for (var i = 0; i < files.length; i++) { 
		console.log(tipoDoc+" "+files[i].name +" "+ files[i].lastModified)+" "+files[i].size+" "+files[i].type; 
		if(! /^[\x00-\x7F]*$/.test(files[i].name)) {
			alert ("Per favor, normalitzi el nom de l'arxiu: \n\n"+files[i].name);
			document.getElementById(tipoDoc).value="";
		}
	}
}

async function obtieneEstadoDelaFirma (publicId) {
	console.log (publicId);
	let API_URI = "/public/assets/utils/comprobarEstadoSello.php?publicAccessId="+ publicId;
	await fetch(API_URI)
		.then((response) => response.text())
		.then((data) => {
		switch (data)
		{
		case 'NOT_STARTED':
			estadoFirma = "<div class = 'info-msg'><i class='fa fa-info-circle'></i> Sol·licitud Pendent de signar</div>";				
			break;
		case 'REJECTED':
			estadoFirma = "<div class = 'warning-msg'><i class='fa fa-warning'></i> Sol·licitud rebutjada</div>";			
			break;
		case 'COMPLETED':
			estadoFirma = "<div class = 'success-msg'><i class='fa fa-check'></i> Sol·licitud signada</div>";						
			break;
		case 'IN_PROCESS':
			estadoFirma = "<div class = 'info-msg'><i class='fa fa-info-circle'></i> En curs</div>";
			break;					
		default:
			estadoFirma = "<div class = 'info-msg'><i class='fa fa-info-circle'></i> Desconegut</div>";
		}
		document.getElementById ("estat_signatura").innerHTML = estadoFirma;
		});
}

function docNoRequerido_click (id, nombre) {
	localStorage.setItem("documento_actual", id);
}

function eliminaDocNoRequerido_click() {
	let id = localStorage.getItem("documento_actual")
    let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
    document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	let corresponde_documento = 'file_resguardoREC';
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
	location.reload();
});
}

function eliminaDocRequerido_click() {
	let id = localStorage.getItem("documento_actual")
    let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
    document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	let corresponde_documento = 'file_resguardoREC';
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
	    location.reload();
    });
}

function eliminaDocValidacion_click() {
	let id = localStorage.getItem("documento_actual")
    let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
    document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	let corresponde_documento = 'file_resguardoREC';
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		location.reload();
	});	
}

function eliminaDocJustificacion_click() {
	let id = localStorage.getItem("documento_actual")
    let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
    document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	let corresponde_documento = 'file_resguardoREC';
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		location.reload();
	});	
}
function eliminaDocSolicitud_click() {
	let id = localStorage.getItem("documento_actual")
    let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
    document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	let corresponde_documento = 'file_resguardoREC';
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		location.reload();
	});	
}

function activarUploadBtn(element, btnToActivate) {
	localStorage.setItem("requiredDocumentToUpload", element.id)
	document.getElementById(btnToActivate).removeAttribute("disabled")
}

function actualizaMotivoRequerimientoIdiIsba_click() {  //SE EMPLEA
	let textoMotivoReq = document.getElementById("motivoRequerimientoIdiIsba").value;
	let id = document.getElementById("id").value;
	/* let modal = document.getElementById("myRequerimientoIdiIsba"); */
	if ( textoMotivoReq === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_requerimiento_en_expediente.php",
		{ id: id, textoMotivoReq: textoMotivoReq },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoRequerimientoIdiIsba").classList.remove("ocultar");
			}
		}
	);
}