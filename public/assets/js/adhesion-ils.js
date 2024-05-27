$(document).ready(function(){
		
		$("#info_insercion").hide();
		$("#cuantia_ayuda").focus();
		if ($('#ILS').is(':checked')) {
			// document.getElementById("declaracion_responsable_xvi").checked = true;
		} else {
			// document.getElementById("declaracion_responsable_xvi").checked = false;
		}
			
	$('#nif').on('change', function() {
		var currentNIF = $(this).val();
	}); 

	$("#nif").focusout(function() 
		{
		var currentNIF = $(this).val();
		})
			
	$("#nif").keyup(function() 
		{
		var currentNIF = $(this).val();
		});			

	$( "#rgpd" ).change(function() {
		if ($(this).is(":checked"))
		{
		$('#enviar_iDigital').prop('disabled', false);
		}
		else
		{
		$('#enviar_iDigital').prop('disabled', true);	
		}
	});
	
    $('#iDigital').click(function() {
	    $( "#declaracion_responsable_xvi" ).prop( "checked", false );
    });
    $('#iExporta').click(function() {
	    $( "#declaracion_responsable_xvi" ).prop( "checked", false );
    });
    $('#ILS').click(function() {
	    $( "#declaracion_responsable_xvi" ).prop( "checked", true );
    });
});	

let spanInforme = document.getElementById("informeCheck")
let spanCertificado = document.getElementById("certificadoCheck")

var x = "Total Width: " + screen.width;
console.log (x);
x = "Available Width: " + screen.availWidth;
console.log (x);
x = "Color Resolution: " + screen.pixelDepth; 
console.log (x);

function onFormSubmit(param){
  
  console.log ("Se ha pulsado submit... desde: "+param.id, localStorage.getItem('file_escritura_empresa'))

  if ( ( localStorage.getItem('file_escritura_empresa') === 'NO' || localStorage.getItem('file_escritura_empresa') === null ) && document.getElementById("file_escritura_empresa").value === '' ) {
	document.getElementById("file_escritura_empresa").setAttribute ('class','aviso');
	return
  };


  if ( ( localStorage.getItem('file_certificadoIAE') === 'NO' || localStorage.getItem('file_certificadoIAE') === null ) && document.getElementById("file_certificadoIAE").value === '' ) {
	document.getElementById("file_certificadoIAE").setAttribute ('class','aviso');
	return
  };

  let informe = document.getElementById("informe")
  let certificado = document.getElementById("certificado")

  if (!informe.checked && !certificado.checked) {
	console.log ( "Estado de los checks: " + informe.checked, certificado.checked )
	spanInforme.style.backgroundColor = "red";
	spanCertificado.style.backgroundColor = "red";
	return
  } else {
	spanInforme.style.backgroundColor = "green";
	spanCertificado.style.backgroundColor = "green";
  }

  if (informe.checked) {
	spanInforme.style.backgroundColor = "green";
	spanCertificado.style.backgroundColor = "white";
	if ( document.getElementById("file_informeResumenIls").value === '' ) {
		document.getElementById("file_informeResumenIls").setAttribute ('class','aviso');
		return
  } else {
		document.getElementById("file_informeResumenIls").style.backgroundColor = "#04aa6d";
		document.getElementById("file_informeResumenIls").classList.remove('aviso');
	}
  if ( document.getElementById("file_informeInventarioIls").value === '' ) {
		document.getElementById("file_informeInventarioIls").setAttribute ('class','aviso');
		return
  } else {
		document.getElementById("file_informeInventarioIls").style.backgroundColor = "#04aa6d";
		document.getElementById("file_informeInventarioIls").classList.remove('aviso');
	}
  }

  if (certificado.checked) {
	spanInforme.style.backgroundColor = "white";
	spanCertificado.style.backgroundColor = "green";
	if ( document.getElementById("file_certificado_verificacion_ISO").value === '' ) {
		document.getElementById("file_certificado_verificacion_ISO").setAttribute ('class','aviso');
		return
  	} else {
		document.getElementById("file_certificado_verificacion_ISO").style.backgroundColor = "#04aa6d";
		document.getElementById("file_certificado_verificacion_ISO").classList.remove('aviso');
	}
  }
  
  if ( document.getElementById("file_modeloEjemploIls").value === '' ) {
	document.getElementById("file_modeloEjemploIls").setAttribute ('class','aviso');
	return
  }

  if ( document.getElementById("file_certificado_itinerario_formativo").value === '' ) {
	document.getElementById("file_certificado_itinerario_formativo").setAttribute ('class','aviso');
	return
  }

console.log("Envío la solicitud de adhesión ... ");
 
let theElement=document.getElementById("nextBtn");
let theForm=document.getElementById("adhesion_ils");
if ( getCookie("itramitsCurrentLanguage")==='ca') {
	theElement.innerHTML="Enviant la sol·licitud, un moment per favor ... ";
} else {
	theElement.innerHTML="Enviando la solicitud, un momento por favor ... ";
}
theElement.disabled=true;
theElement.style.backgroundColor= "orange";
theForm.style.cursor="progress";
theForm.disabled = true;
theForm.style.opacity =".2";
theForm.submit();
}

function opcionMarcada(valor) {
	document.getElementById("aviso").remove('aviso');
	document.getElementById("formbox").className = 'formbox';
	}

function habilitarNextButton (valor) {
	if (!valor) {
		document.getElementById("nextBtn").className = 'ocultar';
		document.getElementById("nextBtn").disabled = true;
	} else {
		document.getElementById("nextBtn").remove = 'ocultar';
		document.getElementById("nextBtn").className = 'buttonAsistente';
		document.getElementById("nextBtn").disabled = false;
	}
	}

function tipoSolicitante (valor)
	{
		let element = document.getElementById("interesado")
		console.log (valor);
		document.getElementById("nif").value="";
		switch (valor) {
			case 'autonomo':
				document.getElementById("pFisica").classList.remove('ocultar')
				document.getElementById("nif").placeholder = 'DNI / NIE';
				document.getElementById("nif").title = 'DNI / NIE';
				document.getElementById("denom_interesado").setAttribute("placeholder", "Nom");
				document.getElementById("denom_interesado").setAttribute("title", "Nom");
				break;

			case 'pequenya':
/* 				document.getElementById("nif").placeholder = 'CIF [Código de Identificación Fiscal]';
				document.getElementById("nif").title = 'CIF [Código de Identificación Fiscal]'; */
				break;

			case 'mediana':
				if (document.contains(document.getElementById("file_altaAutonomos"))) {
					document.getElementById("file_altaAutonomos").remove();
				}
				if (document.contains(document.getElementById("docConstitutivoCluster"))) {
					document.getElementById("docConstitutivoCluster").remove();
				}

/* 				document.getElementById("nif").placeholder = 'CIF [Código de Identificación Fiscal]';
				document.getElementById("nif").title = 'CIF [Código de Identificación Fiscal]'; */
				break;
		}
		document.getElementById("aviso2").remove('aviso')
		document.getElementById("formbox2").className = 'formbox'
	}

function presentarInformeOCertificado (valor) {
	let mostrarInformes = document.getElementById("mostrarInformes")
	let mostrarCertificado = document.getElementById("mostrarCertificadoISO")

	if (valor === 'informe') {
		document.getElementById("file_informeResumenIls").addEventListener ("blur", () => { validateFormField(this) });
		document.getElementById("file_informeInventarioIls").addEventListener ("blur", () => { validateFormField(this) });

		mostrarInformes.classList.remove('ocultar');
		mostrarInformes.classList.add('isa_info');
		mostrarCertificado.classList.add('ocultar');
	} else if (valor === 'certificado') {
		mostrarInformes.classList.add('ocultar');
		mostrarCertificado.classList.remove('ocultar');
		mostrarCertificado.classList.add('isa_info');
	}
}	

function limpiaInfo_lbl (valor) {
	document.getElementById("info_lbl").innerHTML = ""
}

function tieneRepresentanteLegal (valor)
	{
	if (valor == "representanteLegal")
		{
		if (document.getElementById("representanteLegal").checked) {
			document.getElementById("verRepresentanteLegal").remove = 'ocultar';
			document.getElementById("verRepresentanteLegal").className = 'enviararchivo_ver';
			document.getElementById("nom_representante").focus();				
		}
		else
		{
			document.getElementById("verRepresentanteLegal").remove = 'enviararchivo_ver';
			document.getElementById("verRepresentanteLegal").className = 'ocultar';		
		}
		}
	}

function tieneConsultor (valor) 
	{
		console.log (valor);
	}
	
function opcionBanco (valor) 
	{
		document.getElementById("1_opcion_banco_h5").setAttribute("class", "container-radio-valid");
		document.getElementById("2_opcion_banco_h5").setAttribute("class", "container-radio-valid");	
		let eelement = document.getElementById("verBancoOpcion")
		let cChild = document.createElement('input')
		cChild.setAttribute("aria-required", true)
		cChild.setAttribute("type", "text")
		cChild.setAttribute("onblur", "validateFormField(this);")    

		if (valor == "1") 
		{
		if (document.contains(document.getElementById("cc2"))) {
				document.getElementById("cc2").remove();
			}	
		cChild.setAttribute("id", "cc")
		cChild.setAttribute("name", "cc")
		cChild.setAttribute("size" ,"24")
		cChild.setAttribute("maxlength" ,"24")
		cChild.setAttribute("data-mask", "ES 99 9999 9999 99 9999999999")
		cChild.setAttribute("placeholder", "ES9999999999999999999999")	
		cChild.setAttribute("pattern", "[A-Z]{2}[0-9]{24}")
		cChild.setAttribute("invalid", function(evt) {
			var elem = evt.srcElement;
			alert (elem);
			elem.nextSibling.innerText = elem.validationMessage;
		  }) 
		eelement.appendChild(cChild)
		}
		else
		{
		if (document.contains(document.getElementById("cc"))) {
				document.getElementById("cc").remove();
			}	
		cChild.setAttribute("id", "cc2")
		cChild.setAttribute("name", "cc2")
		cChild.setAttribute("size" ,"24")
		cChild.setAttribute("maxlength" ,"24")
		cChild.setAttribute("placeholder", "999999999999999999999999")	
		cChild.setAttribute("pattern", "[0-9]{24}")
		eelement.appendChild(cChild)
		}

	}	
	
function activaayudasSubvenSICuales_dec_resp (valor)
	{
		console.log (valor);
		if (valor == "si") 
		{
		document.getElementById("ayudasSubvenSICuales_dec_resp").disabled = false;
		document.getElementById("ayudasSubvenSICuales_dec_resp").focus();
		}
		else
		{
		document.getElementById("ayudasSubvenSICuales_dec_resp").disabled = true;
		}
	}
	
function muestraSubeArchivo (id) 
	{
		// enviar_iDigital.disabled = true
		console.log ("-"+id+"-")
		let elementA = document.getElementById("enviarnifEmpresa")
		let aChild = document.createElement('input')
		let elementB = document.getElementById("enviarConstitucionCluster")
		let bChild = document.createElement('input')

		if (id == "nifEmpresa")
		{	
			aChild.setAttribute("aria-required", true)
			aChild.setAttribute("size" ,"20")
			aChild.setAttribute("type", "file")
			aChild.setAttribute("accept", ".pdf")
			aChild.setAttribute("multiple", "true")
			if (document.getElementById("nifEmpresa").checked) 
			{
				aChild.setAttribute("id", "file_nifEmpresa")
				aChild.setAttribute("name", "file_nifEmpresa[]")
				elementA.appendChild(aChild) 
				document.getElementById("docConstitutivoCluster").checked = false;
				document.getElementById("docConstitutivoCluster").disabled = true;
			}
			else
			{
				let childA = document.getElementById("file_nifEmpresa");
				elementA.removeChild(childA)
				document.getElementById("docConstitutivoCluster").disabled = false;
			}
		}
		if (id == "docConstitutivoCluster")
		{
			bChild.setAttribute("aria-required", true)
			bChild.setAttribute("size" ,"20")
			bChild.setAttribute("type", "file")
			bChild.setAttribute("accept", ".pdf")
			bChild.setAttribute("multiple", "true")
			if (document.getElementById("docConstitutivoCluster").checked) 
			{
				bChild.setAttribute("id", "file_docConstitutivoCluster")
				bChild.setAttribute("name", "file_docConstitutivoCluster[]")
				elementB.appendChild(bChild)
				document.getElementById("nifEmpresa").checked = false;
				document.getElementById("nifEmpresa").disabled = true;
			}
			else
			{
				let childB = document.getElementById("file_docConstitutivoCluster");
				elementB.removeChild(childB)
				document.getElementById("nifEmpresa").disabled = false;
			}
		}
		if (id == "consentimientocopiaNIF")
		{
			if (!document.getElementById("consentimientocopiaNIF").checked) {
				document.getElementById("enviarcopiaNIF").remove = 'ocultar';
				document.getElementById("enviarcopiaNIF").className = 'enviararchivo_ver';
				let elementCopiaNIF = document.getElementById("enviarcopiaNIF")
				let copiaNIFChild = document.createElement('input')
				copiaNIFChild.setAttribute("aria-required", true)
				copiaNIFChild.setAttribute("size" ,"20")
				copiaNIFChild.setAttribute("type", "file")
				copiaNIFChild.setAttribute("accept", ".pdf")
				copiaNIFChild.setAttribute("multiple", "true")
				copiaNIFChild.setAttribute("id", "file_copiaNIF")
				copiaNIFChild.setAttribute("name", "file_copiaNIF[]")	
				copiaNIFChild.setAttribute("onblur", "validateFormField(this);")	
				elementCopiaNIF.appendChild(copiaNIFChild)					
			}
			else
			{
				document.getElementById("enviarcopiaNIF").remove = 'enviararchivo_ver';
				document.getElementById("enviarcopiaNIF").className = 'ocultar';				
				if (document.contains(document.getElementById("file_copiaNIF"))) {
					document.getElementById("file_copiaNIF").remove();
				}			
			}
		}	
		if (id == "consentimiento_identificacion")
		{
			if (!document.getElementById("consentimiento_identificacion").checked) {
				document.getElementById("enviardocumentoIdentificacion").remove = 'ocultar';
				document.getElementById("enviardocumentoIdentificacion").className = 'enviararchivo_ver';
				let elementConsentId = document.getElementById("enviardocumentoIdentificacion")
				let consentId = document.createElement('input')
				consentId.setAttribute("aria-required", true)
				consentId.setAttribute("size" ,"20")
				consentId.setAttribute("type", "file")
				consentId.setAttribute("accept", ".pdf")
				consentId.setAttribute("multiple", "true")
				consentId.setAttribute("id", "file_enviardocumentoIdentificacion")
				consentId.setAttribute("name", "file_enviardocumentoIdentificacion[]")
				consentId.setAttribute("onblur", "validateFormField(this);")
				elementConsentId.appendChild(consentId)											
			}
			else
			{
				document.getElementById("enviardocumentoIdentificacion").remove = 'enviararchivo_ver';
				document.getElementById("enviardocumentoIdentificacion").className = 'ocultar';				
				if (document.contains(document.getElementById("file_enviardocumentoIdentificacion"))) {
					document.getElementById("file_enviardocumentoIdentificacion").remove();
				}							
			}
		}
		if (id == "consentimiento_certificadoATIB")
		{
			if (!document.getElementById("consentimiento_certificadoATIB").checked) {
				document.getElementById("enviarcertificadoATIB").remove = 'ocultar';
				document.getElementById("enviarcertificadoATIB").className = 'enviararchivo_ver';
				let elementConsentATIB = document.getElementById("enviarcertificadoATIB")
				let consentATIB = document.createElement('input')
				consentATIB.setAttribute("aria-required", true)
				consentATIB.setAttribute("size" ,"20")
				consentATIB.setAttribute("type", "file")
				consentATIB.setAttribute("accept", ".pdf")
				consentATIB.setAttribute("multiple", "true")
				consentATIB.setAttribute("id", "file_certificadoATIB")
				consentATIB.setAttribute("name", "file_certificadoATIB[]")
				consentATIB.setAttribute("onblur", "validateFormField(this);")			
				elementConsentATIB.appendChild(consentATIB)											
			}
			else
			{
				document.getElementById("enviarcertificadoATIB").remove = 'enviararchivo_ver';
				document.getElementById("enviarcertificadoATIB").className = 'ocultar';				
				if (document.contains(document.getElementById("file_certificadoATIB"))) {
					document.getElementById("file_certificadoATIB").remove();
				}					
			}
		}
		if (id == "file_escritura_empresa")
			{
			console.log(document.getElementById("file_escritura_empresa").value)
			}
		if (id == "consentimiento_certificadoSegSoc")
			{
			if (!document.getElementById("consentimiento_certificadoSegSoc").checked) {
				document.getElementById("enviarcertificadosegSoc").remove = 'ocultar';
				document.getElementById("enviarcertificadosegSoc").className = 'enviararchivo_ver';	
				let elementConsentSS = document.getElementById("enviarcertificadosegSoc")
				let consentSS = document.createElement('input')
				consentSS.setAttribute("aria-required", true)
				consentSS.setAttribute("size" ,"20")
				consentSS.setAttribute("type", "file")
				consentSS.setAttribute("accept", ".pdf")
				consentSS.setAttribute("multiple", "true")
				consentSS.setAttribute("id", "file_certificadoSegSoc")
				consentSS.setAttribute("name", "file_certificadoSegSoc[]")
				consentSS.setAttribute("onblur", "validateFormField(this);")
				elementConsentSS.appendChild(consentSS)						
			}
			else
			{
				document.getElementById("enviarcertificadosegSoc").remove = 'enviararchivo_ver';
				document.getElementById("enviarcertificadosegSoc").className = 'ocultar';				
				if (document.contains(document.getElementById("file_certigicadoSegSoc"))) {
					document.getElementById("file_certigicadoSegSoc").remove();
				}						
			}
			}
		if (id == "declaracion_responsable_ii") {
			if (document.getElementById("declaracion_responsable_ii").checked) {
				document.getElementById("contenedor_importe_minimis").remove = 'ocultar';
				document.getElementById("contenedor_importe_minimis").className = 'enviararchivo_ver';
				let elementContenedorImporte = document.getElementById("contenedor_importe_minimis")
				let contenedorImporte = document.createElement('input')
				contenedorImporte.setAttribute("aria-required", true)
				contenedorImporte.setAttribute("placeholder" ,"10000.0")
				contenedorImporte.setAttribute("minlength" ,"1")
				contenedorImporte.setAttribute("maxlength" ,"6")
				contenedorImporte.setAttribute("step" ,"0.01")
				contenedorImporte.setAttribute("max" ,"200000")
				contenedorImporte.setAttribute("pattern" ,"[0-9]*")
				contenedorImporte.setAttribute("type", "number")
				contenedorImporte.setAttribute("id", "importe_minimis")
				contenedorImporte.setAttribute("name", "importe_minimis")
				contenedorImporte.setAttribute("onblur", "validateFormField(this, step=8);")
				elementContenedorImporte.appendChild(contenedorImporte)					
			}
			else
			{
				document.getElementById("contenedor_importe_minimis").remove = 'enviararchivo_ver';
				document.getElementById("contenedor_importe_minimis").className = 'ocultar';				
				if (document.contains(document.getElementById("importe_minimis"))) {
					document.getElementById("importe_minimis").remove();
				}						
			}
		}

		if (id == "certigicadoSegSoc")
				{
				if (document.getElementById("certigicadoSegSoc").checked) {
					document.getElementById("enviarcertigicadoSegSoc").remove = 'ocultar';
					document.getElementById("enviarcertigicadoSegSoc").className = 'enviararchivo_ver';
					document.getElementById("file_certigicadoSegSoc").focus();			
				}
				else
				{
					document.getElementById("enviarcertigicadoSegSoc").remove = 'enviararchivo_ver';
					document.getElementById("enviarcertigicadoSegSoc").className = 'ocultar';
					file_certigicadoSegSoc.value = "";				
				}
				}
			
			if (id == "certificadoATIB")
				{
				if (document.getElementById("certificadoATIB").checked) {
					document.getElementById("enviarcertificadoATIB").remove = 'ocultar';
					document.getElementById("enviarcertificadoATIB").className = 'enviararchivo_ver';
					document.getElementById("file_certificadoATIB").focus();				
				}
				else
				{
					document.getElementById("enviarcertificadoATIB").remove = 'enviararchivo_ver';
					document.getElementById("enviarcertificadoATIB").className = 'ocultar';
					file_certificadoATIB.value = "";
				}
				}
			
			if (id == "copiaNIF")
				{
				if (!document.getElementById("copiaNIF").checked) 
				{
				document.getElementById("nifEmpresa").disabled = true;
				document.getElementById("enviarcopiaNIF").remove = 'ocultar';
				document.getElementById("enviarcopiaNIF").className = 'enviararchivo_ver';
				}
				else
				{	
				document.getElementById("nifEmpresa").disabled = false;
				document.getElementById("enviarcopiaNIF").remove = 'enviararchivo_ver';
				document.getElementById("enviarcopiaNIF").className = 'ocultar';
				document.getElementsByName("file_copiaNIF").value = "";			
				}
				}

			if (id == "nifRepresentante")
				{
				if (document.getElementById("nifEmpresa").checked || document.getElementById("nifRepresentante").checked) {
					document.getElementById("copiaNIF").disabled = true;		
				}
				else
				{
					document.getElementById("copiaNIF").disabled = false;			
				}
			
				if (document.getElementById("nifRepresentante").checked) {
					document.getElementById("enviarnifRepresentante").remove = 'ocultar';
					document.getElementById("enviarnifRepresentante").className = 'enviararchivo_ver';
				}
				else
				{
					document.getElementById("enviarnifRepresentante").remove = 'enviararchivo_ver';
					document.getElementById("enviarnifRepresentante").className = 'ocultar';
					document.getElementsByName("file_nifRepresentante").value = "";				
				}
				}
	}
			
$("#telefono_cont").focusout(function() {
		var inputValue = $(this).val();
		var txt = "";
		if (inputValue == "" || document.getElementById("telefono_cont").validity.patternMismatch)
			{
			txt = "Hauria de ser un telèfon vàlid !!!";
			document.getElementById("mensaje_tel").innerHTML = txt;			
			$("#telefono_cont").focus();
			$("#telefono_cont").addClass("form-control is-not-valid");
			}
		else
			{
			txt = "";
			document.getElementById("mensaje_tel").innerHTML = txt;		
			}
	})
			
$("#telefono_cont").keyup(function() {
			if( jQuery(this).val() == "" || document.getElementById("telefono_cont").validity.patternMismatch)
				{
				txt = "Hauria de ser un telèfon vàlid !!!";
				document.getElementById("mensaje_tel").innerHTML = txt;		
				$("#telefono_cont").focus();
				}
			else
				{
				txt = "";
				document.getElementById("mensaje_tel").innerHTML = txt;				
				}
	});

function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(";");
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == " ") {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

function cierraModal() {
	document.getElementById("myModal").style.display = "none"; 
}