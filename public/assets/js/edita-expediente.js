const mainNode = document.querySelector('body');
/* let currentExpSituation = document.getElementById("situacion_exped").selectedIndex */
const actualBaseUrl = window.location.origin
let base_url = actualBaseUrl+'/public/index.php/expedientes/generaInforme'

mainNode.onload = configuraDetalle_OnLoad;

$(document).ready(function () {

	idExp = document.getElementById("id")
	programa = document.getElementById("programa")

	$("#exped-fase-1").submit(function () {
		$("#send-exped-fase-1", this)
			.html("Actualitzant, un moment per favor.")
			.attr("disabled", "disabled")
			.css("background-color", "orange")
			.css("cursor", " progress");
	});

	$("#generaInfFavSinReq").click(function () {
		$("#spinner_2").removeClass("ocultar");
		$("#btn_2").addClass("ocultar");
	});
	$("#generadoc_res_conces_sin_req").click(function () {
		$("#spinner_11").removeClass("ocultar");
		$("#btn_11").addClass("ocultar");
	});
	$("#generadoc_res_denegacion_con_req").click(function () {
		$("#spinner_12").removeClass("ocultar");
		$("#btn_12").addClass("ocultar");
	});
	$("#generadoc_res_denegacion_sin_req").click(function () {
		$("#spinner_13").removeClass("ocultar");
		$("#btn_13").addClass("ocultar");
	});
	$("#generadoc_el_desestimiento").click(function () {
		$("#spinner_14").removeClass("ocultar");
		$("#btn_14").addClass("ocultar");
	});
	$("#wrapper_actaDeKickOff").click(function () {
		$("#spinner_14").removeClass("ocultar");
		$("#btn_14").addClass("ocultar");
	});
	$("#generadoc_res_denegacion_con_req").click(function () {
		$("#spinner_16").removeClass("ocultar");
		$("#btn_16").addClass("ocultar");
	});
	$("#wrapper_ActaDeCierre").click(function () {
		$("#spinner_15").removeClass("ocultar");
		$("#btn_15").addClass("ocultar");
	});
	$("#wrapper_inicio_req_subsanacion").click(function () {
		$("#spinner_177").removeClass("ocultar");
		$("#btn_177").addClass("ocultar");
	});
	$("#generaAcuerdoConfidencialidad").click(function () {
		$("#spinner_18").removeClass("ocultar");
	});	
	$("#generadoc_res_conces_sin_req").click(function (e) {
		$("#spinner_11").removeClass("ocultar");
		$("#btn_11").addClass("ocultar");
	});
});

const form = document.getElementById('subir_faseExpedSolicitud');

function openFaseExped(evt, faseName, backgroundColor, id) {
	var i, tabcontent, tablinks;
	localStorage.removeItem("currentTab");
	localStorage.setItem("currentTab", faseName);

	console.log (faseName)


	/* compruebaEstadoDocumentosRequeridos(id); */

	tabcontent = document.getElementsByClassName("tab_fase_exp_content");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	tablinks = document.getElementsByClassName("tablinks");
	console.log ( `--------${tablinks.length}--------` )
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
		tablinks[i].className = tablinks[i].className = "tablinks";
	}

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
	document.getElementById(btnID).style.backgroundColor = "darkgray";
	document.getElementById(btnID).disabled = true;
	document.getElementById(btnID).value = "Un moment, estic pujant la documentació ...";
	for (let step = 0; step < 4; step++) {
		document.getElementsByClassName("form-group desistimiento")[step].style.opacity = "0.5";
	}
	//event.preventDefault();
}

function cambiaEstadoDoc(id) {
	console.log (id)
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
		case 'file_certificado_itinerario_formativo':
			buttonID = "myBtnEnviarFormularioItinerarioFormativo"
			break
		case 'file_enviardocumentoIdentificacion':
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
		if(document.body.contains(document.getElementById(id.split("#")[0]+"_del"))){
			elementDel.removeAttribute("disabled")
		} 
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
		if(document.body.contains(document.getElementById(id.split("#")[0]+"_del"))){
			elementDel.setAttribute("disabled", true);
		}
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
		if(document.body.contains(document.getElementById(id.split("#")[0]+"_del"))){
			elementDel.removeAttribute("disabled")
		}
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
		if(document.body.contains(document.getElementById(id.split("#")[0]+"_del"))){
			elementDel.removeAttribute("disabled")
		}
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

function compruebaEstadoDocumentosRequeridos (idExp) { // no se usa en XECS
	/* 
		Si TODOS los estados de los documentos obligatorios del expediente están en situación
		'Aprovat' entonces -> GENERAR INFORME FAVORABLE ¿con req / sin req? y cambiar situación expediente a 'IF+Resolució emesa'
	   	Si ALGUNO de los estados de los documentos obligatorios del expediente están en situación
		'Rebutjat' entonces -> GENERAR REQUERIMIENTO y cambiar situación expediente a  'Requeriment signat'
	*/
	let autoGeneradoRequerimiento = document.getElementById ('doc_requeriment_auto_ils')
	let requerimentButton = document.getElementById ('requeriment-button')
	let adhesionButton = document.getElementById ('adhesion-button')
	let autoGeneradoResolucionConcesionConReg = document.getElementById ('doc_res_concesion_adhesion_con_req_auto_ils')
	let autoGeneradoResolucionConcesionSinReg = document.getElementById ('doc_res_concesion_adhesion_sin_req_auto_ils')

	let nif = document.getElementById ('nif')
	let convocatoria = document.getElementById ('convocatoria')

	let respuesta
	$.post(
			"/public/assets/utils/comprueba_estado_documentos.php",
			{ id: idExp },
			
			function (data) {
				$(".result").html(data);

				/* Generar Requerimiento si alguno está 'Rebutjat' y ninguno esta 'Pendent' */
				// ( `OK 1. Hay que actualizar el campo 'motivoRequerimientoIls' de 'pindust_expediente' con una lista que contenga los nombres de los documentos en estado 'Rebutjat'.` )
				// ( `2. Hay que enviar al técnico el documento de Requerimiento para que lo firme electrónicamente.` )
				// ( `3. Hay que actualizar el campo 'doc_requeriment_ils' de 'pindust_expediente' con ????????.` )

				if ( data.split(',').some( item => item === 'Rebutjat') && !data.split(',').some( item => item === 'Pendent' ) ) {
					if(document.body.contains(document.getElementById(requeriment-button))){
						requerimentButton.classList.remove ("hide-button")
						requerimentButton.classList.add ("show-button")
					}
				} else {
					if(document.body.contains(document.getElementById(requeriment-button))){
						requerimentButton.classList.add ("hide-button")
						requerimentButton.classList.remove ("show-button")
					}
				}

				/* Generar Informe favorable [determinar si con requerimiento o sin requerimiento] si todos están 'Aprovats' */
				if ( data.split(',').every( item => item === 'Aprovat') )  {
					adhesionButton.classList.remove ("hide-button")
					adhesionButton.classList.add ("show-button")
				} else {
					adhesionButton.classList.add ("hide-button")
					adhesionButton.classList.remove ("show-button")
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

function actualiza_fase_0_expediente(formName) {  //SE EMPLEA
	console.log("fase_0")
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let empresa = document.getElementById("empresa").value; // Nom o raó social
	let empresa_consultor = document.getElementById("empresa_consultor").value; //Empresa del consultor
	let nif = document.getElementById("nif").value; // nif
	let telefono_rep = document.getElementById("telefono_rep").value; // Mòbil a efectes de notificacions
	let email_rep = document.getElementById("email_rep").value; // Adreça electrònica a efectes de notificacions
	let nom_consultor = document.getElementById("nom_consultor").value; // Nom del consultor
	let mail_consultor = document.getElementById("mail_consultor").value; // Adreça electrònica
	let tel_consultor = document.getElementById("tel_consultor").value; // Telèfon mòbil
	let tecnicoAsignado = document.getElementById("tecnicoAsignado").value; // Tècnica asignada
	let nombre_rep = document.getElementById("nombre_rep").value; // Representant legal
	let nif_rep = document.getElementById("nif_rep").value; // Representant legal NIF
	let comments = document.getElementById("comments").value; // Comentarios
	let situacion_exped = document.getElementById("situacion_exped").value; // Situació
	let importeAyuda = document.getElementById("importeAyuda").value; // Import de l'ajuda
	let porcentajeConcedido = document.getElementById("porcentajeConcedido").value; // Percentatje de l'ajuda
	let cc_datos_bancarios = document.getElementById("cc_datos_bancarios").value; // CC
	let ordenDePago = document.getElementById("ordenDePago").value; // Enviar a pagament
	let fechaEnvioAdministracion = document.getElementById("fechaEnvioAdministracion").value; // Data enviament a administració
	let fecha_de_pago = document.getElementById("fecha_de_pago").value; // Pagament

	for (let step = 0; step < 25; step++) {
		document.getElementsByClassName("form-group general")[step].style.opacity = "0.1";
	}
	
	let send_fase_0 = document.getElementById("send_fase_0");
	send_fase_0.innerHTML = "Un moment ...";
	send_fase_0.className = "btn-itramits warning-msg";
	send_fase_0.disabled = true;

	$.post(
		"/public/assets/utils/actualiza_fase_0_expediente.php",
		{ id: id, empresa: empresa, empresa_consultor: empresa_consultor, nif: nif, telefono_rep: telefono_rep, email_rep: email_rep, nom_consultor: nom_consultor, mail_consultor: mail_consultor,
			tel_consultor: tel_consultor, tecnicoAsignado: tecnicoAsignado, nombre_rep: nombre_rep, nif_rep, nif_rep,
			comments: comments,
			situacion_exped: situacion_exped, importeAyuda: importeAyuda, porcentajeConcedido: porcentajeConcedido, cc_datos_bancarios: cc_datos_bancarios, 
			ordenDePago: ordenDePago, fechaEnvioAdministracion: fechaEnvioAdministracion, fecha_de_pago: fecha_de_pago },
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_0.innerHTML = "Actualitzar";
				send_fase_0.className = "btn-itramits btn-success-itramits";
				send_fase_0.disabled = false;
			}
			for (let step = 0; step < 25; step++) {
				document.getElementsByClassName("form-group general")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_1_solicitud_expediente(formName) {  //SE EMPLEA
	if (!validateForm(formName)) {
		return;
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

	for (let step = 0; step < 6; step++) {
		document.getElementsByClassName("form-group solicitud")[step].style.opacity = "0.1";
	}

	let send_fase_1 = document.getElementById("send_fase_1");
	send_fase_1.innerHTML = "Un moment ...";
	send_fase_1.className = "btn-itramits warning-msg";
	send_fase_1.disabled = true;

	$.post(
		"/public/assets/utils/actualiza_fase_1_solicitud_expediente.php",
		{ id: id, fecha_solicitud: fecha_solicitud, fecha_completado: fecha_completado, fecha_REC: fecha_REC, ref_REC: ref_REC, 
			fecha_REC_enmienda: fecha_REC_enmienda, ref_REC_enmienda: ref_REC_enmienda,
			fecha_requerimiento: fecha_requerimiento, fecha_requerimiento_notif: fecha_requerimiento_notif },
		
		function (data) {
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

function actualiza_fase_2_validacion_expediente(formName) {  //SE EMPLEA
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_infor_fav_desf = document.getElementById("fecha_infor_fav_desf").value; // Data firma informe favorable / desfavorable
	let fecha_firma_propuesta_resolucion_prov = document.getElementById("fecha_firma_propuesta_resolucion_prov").value; // Data firma proposta resolució
	let fecha_not_propuesta_resolucion_prov = document.getElementById("fecha_not_propuesta_resolucion_prov").value; // Data notificació resolució
	let fecha_firma_propuesta_resolucion_def = document.getElementById("fecha_firma_propuesta_resolucion_def").value; // Data firma poposta resolució definitiva
	let fecha_not_propuesta_resolucion_def = document.getElementById("fecha_not_propuesta_resolucion_def").value; // Data notificació poposta resolució definitiva
	let fecha_firma_res = document.getElementById("fecha_firma_res").value; // Data notificació proposta resolució
	let fecha_notificacion_resolucion = document.getElementById("fecha_notificacion_resolucion").value; // ref_REC_enmienda
	

	for (let step = 0; step < 5; step++) {
		document.getElementsByClassName("form-group validacion")[step].style.opacity = "0.1";
	}

	let send_fase_2 = document.getElementById("send_fase_2");
	send_fase_2.innerHTML = "Un moment ...";
	send_fase_2.className = "btn-itramits warning-msg";
	send_fase_2.disabled = true;
	$.post(
		"/public/assets/utils/actualiza_fase_2_validacion_expediente.php",
		{ id: id, fecha_infor_fav_desf: fecha_infor_fav_desf, 
			fecha_firma_propuesta_resolucion_prov: fecha_firma_propuesta_resolucion_prov, 
			fecha_not_propuesta_resolucion_prov: fecha_not_propuesta_resolucion_prov,
			fecha_firma_propuesta_resolucion_def: fecha_firma_propuesta_resolucion_def,
			fecha_not_propuesta_resolucion_def: fecha_not_propuesta_resolucion_def,
			fecha_firma_res: fecha_firma_res,
			fecha_notificacion_resolucion: fecha_notificacion_resolucion
		},
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_2.innerHTML = "Actualitzar";
				send_fase_2.className = "btn-itramits btn-success-itramits";
				send_fase_2.disabled = false;
			}
			for (let step = 0; step < 7; step++) {
				document.getElementsByClassName("form-group validacion")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_3_ejecucion_expediente(formName) {  //SE EMPLEA
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_solicitud = document.getElementById("fecha_solicitud").value; // Data REC sol·licitud
	let fecha_completado = document.getElementById("fecha_completado").value; // Data complert
	let fecha_kick_off = document.getElementById("fecha_kick_off").value; // Data de kick-off
	let fecha_limite_consultoria = document.getElementById("fecha_limite_consultoria").value; // Data límit per realitzar la consultoria
	let fecha_reunion_cierre = document.getElementById("fecha_reunion_cierre").value; //Data reunió tancament 
	let fecha_limite_justificacion = document.getElementById("fecha_limite_justificacion").value; // Data límit per justificar
	let fecha_max_desp_ampliacion = document.getElementById("fecha_max_desp_ampliacion").value; // Data màxima després d'ampliació
	let fecha_REC_amp_termino = document.getElementById("fecha_REC_amp_termino").value; // Data REC ampliació termini
	let ref_REC_amp_termino = document.getElementById("ref_REC_amp_termino").value; // Referència REC ampliació termini
	let fecha_amp_termino = document.getElementById("fecha_amp_termino").value; // Data notificació ampliació termini

	for (let step = 0; step < 8; step++) {
		document.getElementsByClassName("form-group ejecucion")[step].style.opacity = "0.1";
	}

	let send_fase_3 = document.getElementById("send_fase_3");
	send_fase_3.innerHTML = "Un moment ...";
	send_fase_3.className = "btn-itramits warning-msg";
	send_fase_3.disabled = true;

	document.getElementById("fecha_kick_off_modal").value = document.getElementById("fecha_kick_off").value;
	document.getElementById("fecha_HastaRealizacionPlan").value = document.getElementById("fecha_limite_consultoria").value;
	document.getElementById("fecha_reunion_cierre_modal").value = document.getElementById("fecha_reunion_cierre").value;
	document.getElementById("fecha_limite_justificacion_modal").value = document.getElementById("fecha_limite_justificacion").value;

	$.post(
		"/public/assets/utils/actualiza_fase_3_ejecucion_expediente.php",
		{ id: id, fecha_solicitud: fecha_solicitud, fecha_completado: fecha_completado, fecha_kick_off: fecha_kick_off, fecha_limite_consultoria: fecha_limite_consultoria, fecha_reunion_cierre: fecha_reunion_cierre,
			fecha_limite_justificacion: fecha_limite_justificacion, fecha_max_desp_ampliacion: fecha_max_desp_ampliacion,
			fecha_REC_amp_termino: fecha_REC_amp_termino, ref_REC_amp_termino: ref_REC_amp_termino, fecha_amp_termino: fecha_amp_termino
		 },
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_3.innerHTML = "Actualitzar";
				send_fase_3.className = "btn-itramits btn-success-itramits";
				send_fase_3.disabled = false;
			}
			for (let step = 0; step < 8; step++) {
				document.getElementsByClassName("form-group ejecucion")[step].style.opacity = "1.0";
			}
		}
	);
}

function actualiza_fase_4_justificacion_expediente(formName) {  //SE EMPLEA
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_solicitud = document.getElementById("fecha_solicitud").value; // Data REC sol·licitud
	let fecha_completado = document.getElementById("fecha_completado").value; // Data complert
	let fecha_REC_justificacion = document.getElementById("fecha_REC_justificacion").value; // Data SEU justificació
	let ref_REC_justificacion = document.getElementById("ref_REC_justificacion").value; // Referència SEU justificació
	let fecha_firma_res_pago_just = document.getElementById("fecha_firma_res_pago_just").value; // Data notificació resolucio de pagament
	let fecha_not_res_pago = document.getElementById("fecha_not_res_pago").value; // Data firma resolució de pagament / justificació
	let fecha_firma_requerimiento_justificacion = document.getElementById("fecha_firma_requerimiento_justificacion").value; // Data firma requeriment justificació
	let fecha_not_req_just = document.getElementById("fecha_not_req_just").value // Data notificació requeriment justificació
	let fecha_REC_requerimiento_justificacion = document.getElementById("fecha_REC_requerimiento_justificacion").value; // Data REC requeriment justificació
	let ref_REC_requerimiento_justificacion = document.getElementById("ref_REC_requerimiento_justificacion").value; // Referència REC requeriment justificació
	let fecha_propuesta_rev = document.getElementById("fecha_propuesta_rev").value; // Data propuesta revocació
	let fecha_resolucion_rev = document.getElementById("fecha_resolucion_rev").value; // Data resolución revocació
	
	for (let step = 0; step < 10; step++) {
		document.getElementsByClassName("form-group justificacion")[step].style.opacity = "0.1";
	}

	let send_fase_4 = document.getElementById("send_fase_4");
	send_fase_4.innerHTML = "Un moment ...";
	send_fase_4.className = "btn-itramits warning-msg";
	send_fase_4.disabled = true;
	$.post(
		"/public/assets/utils/actualiza_fase_4_justificacion_expediente.php",
		{ id: id, fecha_solicitud: fecha_solicitud, fecha_completado: fecha_completado, 
			fecha_REC_justificacion: fecha_REC_justificacion, 
			ref_REC_justificacion:ref_REC_justificacion, fecha_firma_res_pago_just: fecha_firma_res_pago_just,
			fecha_not_res_pago: fecha_not_res_pago, 
			fecha_firma_requerimiento_justificacion: fecha_firma_requerimiento_justificacion,
			fecha_not_req_just: fecha_not_req_just,
			fecha_REC_requerimiento_justificacion: fecha_REC_requerimiento_justificacion,
			ref_REC_requerimiento_justificacion: ref_REC_requerimiento_justificacion,
			fecha_propuesta_rev: fecha_propuesta_rev,
			fecha_resolucion_rev: fecha_resolucion_rev
		},
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_4.innerHTML = "Actualitzar";
				send_fase_4.className = "btn-itramits btn-success-itramits";
				send_fase_4.disabled = false;
			}
			for (let step = 0; step < 10; step++) {
				document.getElementsByClassName("form-group justificacion")[step].style.opacity = "1.0";
			}			
		}
	);
}

function actualiza_fase_5_desestimiento_expediente(formName) {  //SE EMPLEA
	if (!validateForm(formName)) {
		return;
	}
	let id = document.getElementById("id").value;
	let fecha_solicitud = document.getElementById("fecha_solicitud").value; // Data REC sol·licitud
	let fecha_completado = document.getElementById("fecha_completado").value; // Data complert
	let fecha_REC_desestimiento = document.getElementById("fecha_REC_desestimiento").value; // Data REC desistiment
	let ref_REC_desestimiento = document.getElementById("ref_REC_desestimiento").value; // Referència REC desistiment
	let fecha_firma_resolucion_desestimiento = document.getElementById("fecha_firma_resolucion_desestimiento").value; // Data firma resolució de desistiment
	let fecha_notificacion_desestimiento = document.getElementById("fecha_notificacion_desestimiento").value; // Data notificació desistiment

	for (let step = 0; step < 4; step++) {
		document.getElementsByClassName("form-group desistimiento")[step].style.opacity = "0.5";
	}
	let send_fase_5 = document.getElementById("send_fase_5");
	send_fase_5.innerHTML = "Un moment ...";
	send_fase_5.className = "btn-itramits warning-msg";
	send_fase_5.disabled = true;
	$.post(
		"/public/assets/utils/actualiza_fase_5_desestimiento_expediente.php",
		{ id: id, fecha_solicitud: fecha_solicitud, fecha_completado: fecha_completado, fecha_REC_desestimiento: fecha_REC_desestimiento, ref_REC_desestimiento: ref_REC_desestimiento,
			fecha_firma_resolucion_desestimiento: fecha_firma_resolucion_desestimiento, fecha_notificacion_desestimiento: fecha_notificacion_desestimiento},
		
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				send_fase_5.innerHTML = "Actualitzar";
				send_fase_5.className = "btn-itramits btn-success-itramits";
				send_fase_5.disabled = false;
			}
			for (let step = 0; step < 4; step++) {
				document.getElementsByClassName("form-group desistimiento")[step].style.opacity = "1.0";
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

function compruebaExistenciaFecha(fase, elemento) {
	let theElement = document.getElementById(elemento)
	let selectedIndexElement = theElement.selectedIndex
	let currentExpSituation = document.getElementById("situacion_exped").selectedIndex
	console.log ("compruebaExistenciaFecha: ", fase, theElement.value, selectedIndexElement, currentExpSituation, document.getElementById("fecha_not_propuesta_resolucion_prov").value, document.getElementById("fecha_not_propuesta_resolucion_prov").value.length)
	if (theElement.value === "emitidoIFPRProvPago") {
		if (document.getElementById("fecha_not_propuesta_resolucion_prov").value.length === 0) {
			theElement.selectedIndex = currentExpSituation
			alert (`Falta la data: 'Notificació proposta resolució provisional' de la fase de VALIDACIÓ`)
		}
	}
}

function cambiarSituacionExpediente (fase, elemento) {
	let theElement = document.getElementById(elemento)
	let idExp = document.getElementById("id")
	let nuevoEstado = ""
	let itemID = 0
	if (elemento === "fecha_limite_justificacion") {
		nuevoEstado = "pendienteJustificar"
		itemID = 28
	}
	if (elemento === "fecha_not_propuesta_resolucion_prov") {
		nuevoEstado = "notificadoIFPRProvPago"
		itemID = 13
	}
	if (elemento === "fecha_limite_consultoria") {
		nuevoEstado = "inicioConsultoria"
		itemID = 20
	}

	if (theElement.value.length > 0) {
		let nuevaSituacion = `/public/assets/utils/actualiza_situacion_del_expediente.php?${nuevoEstado}/${idExp.value}`;
			fetch(nuevaSituacion)
				.then((response) => response.text())
				.then((data) => {
					document.getElementById("situacion_exped").options.item(itemID).selected = 'selected';
				});
	}
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

function actualizaFechaConsultoria(kickOffDate, addMonths) {
	document.getElementById("fecha_kick_off").value = kickOffDate
	document.getElementById("fecha_kick_off_modal").value = kickOffDate

	console.log (kickOffDate, addMonths)

	let d = new Date(kickOffDate)
  // A partir del día siguiente de la fecha
  d.setDate(d.getDate()+1)
	// añadimos meses de plazo según convo y programa
	d.setMonth(d.getMonth() + addMonths)
	if (d.getDay() == 6) {  //La fecha cae en Sábado hay que pasarla al primer lunes (+2 días)
		d.setDate(d.getDate()+2)
	}
	if (d.getDay() == 0) {  //La fecha cae en Domingo hay que pasarla al primer lunes (+1 días)
		d.setDate(d.getDate()+1)
	}
	
	let valorFechaLimite = d
	let fechaTopeSegunConvo = new Date("2025-10-03")

	if ( valorFechaLimite > fechaTopeSegunConvo ) {
		valorFechaLimite = fechaTopeSegunConvo
	}

	const kickOff = new Date(kickOffDate)
	const diaKickOff = kickOff.getDate().toString().padStart(2, '0')
	const mesKickOff = (kickOff.getMonth() + 1).toString().padStart(2, '0')
	const añoKickOff = kickOff.getFullYear()

	const diavalorFechaLimite = valorFechaLimite.getDate().toString().padStart(2, '0')
	const mesvalorFechaLimite = (valorFechaLimite.getMonth() + 1).toString().padStart(2, '0')
	const añovalorFechaLimite = valorFechaLimite.getFullYear()
	const valorFechaLimiteFormateada = `${añovalorFechaLimite}-${mesvalorFechaLimite}-${diavalorFechaLimite}`
	const fechaKickOffFormateadaSQL = `${añoKickOff}-${mesKickOff}-${diaKickOff}`

	document.getElementById("fecha_limite_consultoria").value = valorFechaLimiteFormateada

	let actualizaKickOff = "/public/assets/utils/actualiza_fechas_KickOff.php?"+ fechaKickOffFormateadaSQL+"/"+valorFechaLimiteFormateada+"/"+document.getElementById("id").value;
	fetch(actualizaKickOff)
		.then((response) => response.text())
		.then((data) => {
		});
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
	let textoMotivoDenegacion = document.getElementById("motivoDenegacion_10").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("modalMotivoDenegacion10");
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
				document.getElementById("btnPropResProvDesfavConReq").remove = "ocultar";
				document.getElementById("btnPropResProvDesfavConReq").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}

function actualizaMotivoDenegacionSinReq_click() {  //SE EMPLEA
	let textoMotivoDenegacion = document.getElementById("motivoDenegacion_9").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("modalMotivoDenegacion9");
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
				document.getElementById("btnPropResProvDesfavSinReq").remove = "ocultar";
				document.getElementById("btnPropResProvDesfavSinReq").className = "btn btn-primary";
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
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
	const now = new Date();
	const newState = "pendienteJustificar"
	now.setDate(now.getDate() + 20);
	console.log("nueva fecha ", `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`)
	document.getElementById("spinner_151").classList.remove("ocultar");
	document.getElementById("enviaMailJustificacion").disabled.true;
	$.post( "/public/assets/utils/enviaCorreoElectronicoJustificacion.php",
		{ id: id },
		function (data) {
			if (data) {
				document.getElementById("spinner_151").classList.remove("ocultar");
				document.getElementById("enviaMailJustificacion").style.display = "none";
				document.getElementById("mensaje").classList.remove("ocultar");
				document.getElementById("mensaje").innerHTML = data;

				/* const newState = "pendienteJustificar" */
				const itemID = 28 /*  es el ID de la situación 'Pendiente de justificar */
				let newSituation = `/public/assets/utils/actualiza_situacion_del_expediente.php?${newState}/${idExp.value}`;
				fetch(newSituation)
					.then((response) => console.log(response.text()))
					.then((data) => {
						let newJustificationDate = `/public/assets/utils/actualiza_fecha_justificacion.php?${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}/${idExp.value}`;
						fetch(newJustificationDate)
							.then((response) => response.text())
							.then((data) => {
							document.getElementById("nueva_fecha_limite_justificacion").innerHTML = `${String(now.getDate()).padStart(2, '0')}/${String(now.getMonth() + 1).padStart(2, '0')}/${now.getFullYear()}`
							document.getElementById('nueva_fecha_limite_justificacion').classList.remove("ocultar")
							document.getElementById("fecha_limite_justificacion").setAttribute("hidden", true) 
							document.getElementById("situacion_exped").options.item(itemID).selected = 'selected';
						});
					});
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

function myFunction_docs_IDI_click(id, nombre) {
	localStorage.setItem("documento_actual", id);
}
function opcion_seleccionada_click(respuesta) {
	document.cookie = "respuesta = " + respuesta;
}
function eliminaArchivoDocIDI_click() {

	/* let id = getCookie("documento_actual"); */
	let id = localStorage.getItem("documento_actual")
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
		 inputsform_f2[i].style.backgroundColor = "#1ecbe1";
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
		console.log (estadoFirma);
		document.getElementById ("estat_signatura").innerHTML = estadoFirma;
		});
}

function docNoRequerido_click (id, nombre) {
	localStorage.setItem("documento_actual", id)
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

function eliminaDocSolicitud_click() {
	let id = localStorage.getItem("documento_actual")
	let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
	document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>"
	let corresponde_documento = 'file_resguardoREC'
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		location.reload()
	});	
}

function eliminaDocJustificacion_click() {
	let id = localStorage.getItem("documento_actual")
	let idDoc = id.replace("_del", "")
	console.log (id, idDoc)
	document.getElementById(id).setAttribute("disabled", true);
	document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>"
	let corresponde_documento = 'file_resguardoREC'
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		location.reload()
	});	
}

function eliminaMejoraSolicitud_click() {
	let id = localStorage.getItem("documento_actual")
	let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true);
	document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	let corresponde_documento = 'file_resguardoREC';
	$.post("/public/assets/utils/delete_mejora_solicitud.php",{ id: idDoc }, function(data){
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

function eliminaDocEjecucion_click() {
	let id = localStorage.getItem("documento_actual")
	let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true)
	document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>"
	let corresponde_documento = 'file_resguardoREC'
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		unlink('prueba.html');
		location.reload()
	});	
}

function eliminaDocDesestimiento_click() {
	let id = localStorage.getItem("documento_actual")
	let idDoc = id.replace("_del", "")
	document.getElementById(id).setAttribute("disabled", true)
	document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>"
	let corresponde_documento = 'file_resguardoREC'
	$.post("/public/assets/utils/delete_documento_expediente.php",{ id: idDoc, corresponde_documento: corresponde_documento}, function(data){
		location.reload();
	});	
}

