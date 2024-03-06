$(document).ready(function(){
		
		$("#info_insercion").hide();
		$("#cuantia_ayuda").focus();
		if ($('#ILS').is(':checked')) {
			document.getElementById("declaracion_responsable_xvi").checked = true;
		} else {
			//document.getElementById("declaracion_responsable_xvi").checked = false;
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

let x = "Total Width: " + screen.width;
let importeFacturaTotal = 0
console.log (x);
x = "Available Width: " + screen.availWidth;
console.log (x);
x = "Color Resolution: " + screen.pixelDepth; 
console.log (x);

function onFormSubmit(param){
  console.log ("Se ha pulsado submit... desde: "+param.id)
  document.getElementById("declaracion_responsable_xii").setAttribute("disabled", false);
  let theElement = document.getElementById("nextBtn")
  let theForm = document.getElementById("xecs_form")
	let theSpinnger = document.getElementById("spinner-loading")
	theSpinnger.classList.remove("ocultar")
  theElement.value = "Enviant, un moment per favor... "
  theElement.disabled = true;
  theElement.style.backgroundColor= "orange";
  theElement.style.cursor="progress";
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

function tipoSolicitante (valor) {
	let element = document.getElementById("interesado")

	let elementDoc = document.getElementById("docTipoInteresado")
	let elementDocNifEmpresa = document.getElementById("docTipoInteresadoNifEmpresa")
	let elementDocAcreditativoRepresentatividad = document.getElementById("docAcreditativoRepresentatividad")

	let aChild = document.createElement('input')/* Campos del representante legal */
	aChild.setAttribute("id", "nom_representante")
	aChild.setAttribute("name", "nom_representante")
	aChild.setAttribute("placeholder", "Nom del representant legal")
	aChild.setAttribute("title", "Nom del representant legal")
	aChild.setAttribute("aria-required", true)
	aChild.setAttribute("size" ,"220")
	aChild.setAttribute("type", "text")
	aChild.setAttribute("onblur", "validateFormField(this);")    

	let bChild = document.createElement('input')
	bChild.setAttribute("id", "nif_representante")
	bChild.setAttribute("name", "nif_representante")
	bChild.setAttribute("placeholder", "NIF del representant legal")
	bChild.setAttribute("title", "NIF del representant legal")
	bChild.setAttribute("aria-required", true)
	bChild.setAttribute("minlength", "9")
	bChild.setAttribute("maxlength", "9")
	bChild.setAttribute("type", "text")
	bChild.setAttribute("onBlur", "validateFormField(this);")

	let dChild = document.createElement('input') 
	dChild.setAttribute("aria-required", true)
	dChild.setAttribute("size" ,"50")
	dChild.setAttribute("type", "file")
	dChild.setAttribute("accept", ".pdf")
	dChild.setAttribute("multiple", "true")
	dChild.setAttribute("onblur", "validateFormField(this);")

	let eChild = document.createElement('input') 
	eChild.setAttribute("aria-required", true)
	eChild.setAttribute("size" ,"50")
	eChild.setAttribute("type", "file")
	eChild.setAttribute("accept", ".pdf")
	eChild.setAttribute("multiple", "true")
	eChild.setAttribute("onblur", "validateFormField(this);")

	let fChild = document.createElement('input') 
	fChild.setAttribute("aria-required", true)
	fChild.setAttribute("size" ,"50")
	fChild.setAttribute("type", "file")
	fChild.setAttribute("accept", ".pdf")
	fChild.setAttribute("multiple", "true")
	fChild.setAttribute("onblur", "validateFormField(this);")
		
	if (document.contains(document.getElementById("nif_representante"))) {
		document.getElementById("nif_representante").remove();
	}
	if (document.contains(document.getElementById("nom_representante"))) {
		document.getElementById("nom_representante").remove();
	}
 	if (document.contains(document.getElementById("file_document_acred_como_repres"))) {
		document.getElementById("file_document_acred_como_repres").remove();
	}
	if (document.contains(document.getElementById("file_altaAutonomos"))) {
		document.getElementById("file_altaAutonomos").remove();
	}

	console.log (valor);
	document.getElementById("nif").value="";
	if (document.contains(document.getElementById("file_altaAutonomos"))) {
		document.getElementById("file_altaAutonomos").remove();
	}
	if (document.contains(document.getElementById("file_nifEmpresa"))) {
		document.getElementById("file_nifEmpresa").remove();
	}
	if (document.contains(document.getElementById("file_document_acred_como_repres"))) {
		document.getElementById("file_document_acred_como_repres").remove();
	}
	switch (valor) {
		case 'autonomo':
			document.getElementById("pFisica").classList.remove('ocultar')
			document.getElementById("pJuridica").classList.add('ocultar')
			document.getElementById("copiaNIFSociedadFieldSet").classList.add('ocultar')
			document.getElementById("pJuridicaDocEscritura").classList.add('ocultar')
			document.getElementById("pJuridicaDocAcreditativa").classList.add('ocultar')
			document.getElementById("pJuridicaDocAcreditativaFieldSet").classList.add('ocultar')
			dChild.setAttribute("id", "file_altaAutonomos")
			dChild.setAttribute("name", "file_altaAutonomos[]")
			dChild.setAttribute("placeholder", "Selecciona l'alta en el RETA o en un règim alternatiu equivalent")
			dChild.setAttribute("title", "Selecciona l'alta en el RETA o en un règim alternatiu equivalent")

			document.getElementById("declaracion_responsable_xii").checked = true;
			document.getElementById("declaracion_responsable_xii_lbl").style.display = "block";
			document.getElementById("nif").placeholder = 'DNI / NIE';
			document.getElementById("nif").title = 'DNI / NIE';
			if (document.contains(document.getElementById("file_escritura_empresa"))) {
				document.getElementById("file_escritura_empresa").remove();
			}
			if (document.contains(document.getElementById("file_document_acred_como_repres"))) {
				document.getElementById("file_document_acred_como_repres").remove();
			}
			break;
		case 'pequenya':
		case 'mediana':
			elementDocNifEmpresa.classList.remove('ocultar')
			elementDocAcreditativoRepresentatividad.classList.remove('ocultar')
			element.appendChild(aChild) /* Añado campo nombre representante */
			element.appendChild(bChild) /* Añado campo nif representante */
			document.getElementById("pFisica").classList.add('ocultar')
			document.getElementById("pJuridica").classList.remove('ocultar')
			document.getElementById("copiaNIFSociedadFieldSet").classList.remove('ocultar')
			document.getElementById("pJuridicaDocEscritura").classList.remove('ocultar')
			document.getElementById("pJuridicaDocAcreditativa").classList.remove('ocultar')
			document.getElementById("pJuridicaDocAcreditativaFieldSet").classList.remove('ocultar')

			dChild.setAttribute("id", "file_escritura_empresa")
			dChild.setAttribute("name", "file_escritura_empresa[]")
			dChild.setAttribute("placeholder", "Selecciona las escrituras de la empresa")
			dChild.setAttribute("title", "Selecciona las escrituras de la empresa")

			eChild.setAttribute("id", "file_nifEmpresa")
			eChild.setAttribute("name", "file_nifEmpresa[]")
			eChild.setAttribute("placeholder", "Selecciona el document NIF de l'empresa")
			eChild.setAttribute("title", "Selecciona el document NIF de l'empresa")

			fChild.setAttribute("id", "file_document_acred_como_repres")
			fChild.setAttribute("name", "file_document_acred_como_repres[]")
			fChild.setAttribute("placeholder", "Selecciona el document acreditatiu de representació de l'empresa")
			fChild.setAttribute("title", "Selecciona el document acreditatiu de representació de l'empresa")

			document.getElementById("declaracion_responsable_xii").checked = true;
			document.getElementById("declaracion_responsable_xii_lbl").style.display = "block";
			document.getElementById("nif").placeholder = 'NIF';
			document.getElementById("nif").title = 'NIF';
			document.getElementById("denom_interesado").setAttribute("placeholder", "Raó social");
			document.getElementById("denom_interesado").setAttribute("title", "Raó social");	
				
			elementDocNifEmpresa.appendChild(eChild)
			elementDocAcreditativoRepresentatividad.appendChild(fChild)
			break;
	}
	elementDoc.appendChild(dChild)
	document.getElementById("formbox2").className = 'formbox'
}

function limpiaInfo_lbl (valor) {
	document.getElementById("info_lbl").innerHTML = ""
}

function tieneRepresentanteLegal (valor) {
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

function tieneConsultor (valor) {
	console.log (valor);
}
	
function opcionBanco (valor) {
	document.getElementById("1_opcion_banco_h5").setAttribute("class", "container-radio-valid");
	document.getElementById("2_opcion_banco_h5").setAttribute("class", "container-radio-valid");	
	let eelement = document.getElementById("verBancoOpcion")
	let cChild = document.createElement('input')
	let cChildCountry = document.createElement('input')

	cChild.setAttribute("aria-required", true)
	cChild.setAttribute("type", "text")
	cChild.setAttribute("onblur", "validateFormField(this);")    

	cChildCountry.setAttribute("aria-required", true)
	cChildCountry.setAttribute("type", "text")
	cChildCountry.setAttribute("onblur", "validateFormField(this);")    
	if (document.contains(document.getElementById("cc2Country"))) {
		document.getElementById("cc2Country").remove();
	}	
	if (valor == "1") {
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
	else {
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
		cChildCountry.setAttribute("id", "cc2Country")
		cChildCountry.setAttribute("name", "cc2Country")
		cChildCountry.setAttribute("size" ,"100")
		cChildCountry.setAttribute("maxlength" ,"100")
		cChildCountry.setAttribute("placeholder", "País")	
		cChildCountry.setAttribute("pattern", "[a-z]{100}")
		eelement.appendChild(cChildCountry)
	}
}	
	
function activaayudasSubvenSICuales_dec_resp (valor) {
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
	
function muestraSubeArchivo (id) {
		console.log ("-"+id+"-")
		let elementA = document.getElementById("enviarnifEmpresa")
		let aChild = document.createElement('input')

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
				aChild.setAttribute("onblur", "validateFormField(this);")   
				elementA.appendChild(aChild) 
			}
			else
			{
				let childA = document.getElementById("file_nifEmpresa");
				elementA.removeChild(childA)
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
				contenedorImporte.setAttribute("placeholder" ,"Importe minimis recibido")
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
				// if (document.getElementById("nifEmpresa").checked || document.getElementById("nifRepresentante").checked || document.getElementById("document_acred_como_repres").checked) {
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
					// document.getElementsByName("file_nifRepresentante").focus();				
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

function consultaExpediente ( buscaPor, identificador ) {
		let end_point = ""
		let baseUrl = window.location
	
		if (baseUrl ==='Location https://tramits.idi.es/public/index.php/home/solicitud_ayuda') {
			baseUrl = ""
			return; /* es entorno producción y no debe mostrar datos de empresas/autónomos al poner el DNI/CIF */
		}
		identificador = identificador.split(" ").join("") /* quito posibles espacios en blanco */
	
		if (buscaPor === 'expediente') {
			end_point = `https://${baseUrl.hostname}/public/index.php/expediente/${identificador}/IDI-ISBA`
		}
		if (buscaPor === 'nif' || buscaPor === 'dni') {
			end_point = `https://${baseUrl.hostname}/public/index.php/nifExpediente/${identificador}`
		}
		
		return
		
		let spinner = document.querySelector('#spinner-idi-isba')
		let textIsba = document.querySelector('#text-isba')
	
		spinner.classList.remove("ocultar")
		textIsba.classList.add("ocultar")

		fetch(`${end_point}`)
		.then(response => response.json())
		.then(data => {
		spinner.classList.add("ocultar")
		textIsba.classList.remove("ocultar")

		data.forEach( solicitante => {
			console.log(solicitante.id, solicitante.nif, solicitante.empresa, buscaPor)

			document.getElementById("nif").value = solicitante.nif
			document.getElementById("denom_interesado").value = solicitante.empresa
			document.getElementById("domicilio").value = solicitante.domicilio
			document.getElementById("localidad").value = solicitante.localidad
			document.getElementById("codigoIAE").value = solicitante.iae
			document.getElementById("telefono_cont").value = solicitante.telefono
			document.getElementById("cpostal").value = solicitante.cpostal

			if ( buscaPor === 'nif' ) {
				document.getElementById("nom_representante").value = solicitante.nombre_rep
				document.getElementById("nif_representante").value = solicitante. nif_rep
			}
			document.getElementById("mail_representante").value = solicitante.email_rep
			document.getElementById("tel_representante").value = solicitante.telefono_rep

			document.getElementById("empresa_consultor").value = solicitante.empresa_consultor
			document.getElementById("nom_consultor").value = solicitante.nom_consultor
			document.getElementById("tel_consultor").value = solicitante.tel_consultor
			document.getElementById("mail_consultor").value = solicitante.mail_consultor

			document.getElementById("nom_entidad").value = solicitante.nom_entidad
			document.getElementById("domicilio_sucursal").value = solicitante.domicilio_sucursal
			document.getElementById("codigo_BIC_SWIFT").value = solicitante.codigo_BIC_SWIFT
			
		 /* 	if (document.getElementById("opcion_banco").value === 1) {
				document.getElementById("1_opcion_banco").checked = true
			} else  {
				document.getElementById("2_opcion_banco").checked = true
			} */

	})

	if (buscaPor === 'nif') {
		//restResultDialog.open = true
	}
	}).catch(function(error) {
		console.log('Hubo un problema con la petición:' + error.message, baseUrl.hostname)
		spinner.classList.add("ocultar")
	});

}

function deshabilitarSubidaDocumento (checkObj) {
		console.log (checkObj.name, checkObj.checked)
		switch (checkObj.name) {
			case 'memoriaTecnicaEnIDI':
				if (checkObj.checked) {
					document.getElementById('file_memoriaTecnica').removeAttribute("required")
				 	document.getElementById('file_memoriaTecnica').removeAttribute("aria-required")
				 	document.getElementById('enviarmemoriaTecnica').classList.add("ocultar")
			 	} else {
				 	document.getElementById('file_memoriaTecnica').setAttribute('required', '')
				 	document.getElementById('file_memoriaTecnica').setAttribute('aria-required', 'true')
					document.getElementById('enviarmemoriaTecnica').classList.remove("ocultar")
			 	}
				break
			case 'altaRETA_docAcredEnIDI':
				if (checkObj.checked) {
					document.getElementById('file_altaAutonomos').removeAttribute("required")
				 	document.getElementById('file_altaAutonomos').removeAttribute("aria-required")
				 	document.getElementById('docTipoInteresado').classList.add("ocultar")
			 	} else {
				 	document.getElementById('file_altaAutonomos').setAttribute('required', '')
				 	document.getElementById('file_altaAutonomos').setAttribute('aria-required', 'true')
					document.getElementById('docTipoInteresado').classList.remove("ocultar")
			 	}
				break
			case 'certificadoIAEEnIDI':
				if (checkObj.checked) {
					document.getElementById('file_certificadoIAE').removeAttribute("required")
				 	document.getElementById('file_certificadoIAE').removeAttribute("aria-required")
				 	document.getElementById('file_certificadoIAE_container').classList.add("ocultar")
			 	} else {
				 	document.getElementById('file_certificadoIAE').setAttribute('required', '')
				 	document.getElementById('file_certificadoIAE').setAttribute('aria-required', 'true')
					document.getElementById('file_certificadoIAE_container').classList.remove("ocultar")
			 	}
				break
			case 'copiaNIFSociedadEnIDI':
				if (checkObj.checked) {
					document.getElementById('file_nifEmpresa').removeAttribute("required")
					document.getElementById('file_nifEmpresa').removeAttribute("aria-required")
					document.getElementById('docTipoInteresadoNifEmpresa').classList.add("ocultar")
			  } else {
					document.getElementById('file_nifEmpresa').setAttribute('required', '')
					document.getElementById('file_nifEmpresa').setAttribute('aria-required', 'true')
					document.getElementById('docTipoInteresadoNifEmpresa').classList.remove("ocultar")
			  }
				break
			case 'pJuridicaDocAcreditativaEnIDI':
				if (checkObj.checked) {
					document.getElementById('file_document_acred_como_repres').removeAttribute("required")
				 	document.getElementById('file_document_acred_como_repres').removeAttribute("aria-required")
				 	document.getElementById('docTipoInteresado').classList.add("ocultar")
				} else {
				 	document.getElementById('file_document_acred_como_repres').setAttribute('required', '')
				 	document.getElementById('file_document_acred_como_repres').setAttribute('aria-required', 'true')
					document.getElementById('docTipoInteresado').classList.remove("ocultar")
				}
				break
		}
}

function addInvoiceLine() {
	let numFactura = document.getElementById("num-factura")
	let fechaFacturaInput = document.getElementById("fecha-factura")
	let proveedor = document.getElementById("proveedor")
	let concepto = document.getElementById("concepto")
	let baseImponible = document.getElementById("base-imponible")
	let importeIVA = document.getElementById("importe-iva")
	let importeFactura = document.getElementById("importe-factura")
	let fechaPagoInput = document.getElementById("fecha-pago")

	const fechaFactura = new Date(fechaFacturaInput.value)
	const fechaPago = new Date(fechaPagoInput.value)

	const node = document.createElement("div")
	const textnode = document.createTextNode(numFactura.value+" " + formatDate(fechaFactura).toString()+" " + proveedor.value+" " + concepto.value+" " + baseImponible.value+" " + importeIVA.value+" " + importeFactura.value+" " + formatDate(fechaPago).toString())
	node.appendChild(textnode)
	document.getElementById("container-lines").appendChild(node)
	document.getElementById('invoice-lines').value = document.getElementById('container-lines').innerHTML

	numFactura.value = ""
	fechaFacturaInput.value = ""
	proveedor.value = ""
	concepto.value = ""
	baseImponible.value = 0
	importeIVA.value = 0
	importeFactura.value = 0
	fechaPagoInput.value = ""
	document.getElementById('total-invoice-lines').value = parseFloat(importeFacturaTotal)
	setTotalInvoice()
}

function setTotalInvoice() {
	let baseImponible = document.getElementById("base-imponible")
	let importeIVA = document.getElementById("importe-iva")
	let importeFactura = document.getElementById("importe-factura")
	
	importeFactura.value = parseFloat(baseImponible.value) + parseFloat(importeIVA.value)
	importeFacturaTotal += parseFloat(baseImponible.value)
}

function formatDate(date) {
	return [
	  padTo2Digits(date.getDate()),
	  padTo2Digits(date.getMonth() + 1),
	  date.getFullYear(),
	].join('/');
}

function padTo2Digits(num) {
	return num.toString().padStart(2, '0');
}