
activaDesactivaFormulario (false)
tipoSolicitante ("mediana")

function activaDesactivaFormulario (valor) {
  console.log ( valor )
  var form  = document.getElementById("adhesion_idi_isba")
  var allElements = form.elements
  for (var i = 0, l = allElements.length; i < l; ++i) {
      // allElements[i].readOnly = true;

      if (valor === false) {
        allElements[i].disabled=true;
        allElements[i].style.opacity = "0.5"
      } else {
        allElements[i].disabled=false;
        allElements[i].style.opacity = "1.0"
				document.getElementById("declaro_idi_isba_que_cumple").disabled = true;
				document.getElementById("declaro_idi_isba_que_cumple_no_mas_25").disabled = true;
				document.getElementById("declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom").disabled = true;
      }
  }
}

function limpiaInfo_lbl (valor) {
	document.getElementById("info_lbl").innerHTML = ""
}

function tipoSolicitante (valor)	{
		let element = document.getElementById("interesado")
		console.log (valor)
		document.getElementById("nif").value=""
		switch (valor) {
			case 'autonomo':
				document.getElementById("pFisica").classList.remove('ocultar')
				document.getElementById("nif").placeholder = 'DNI / NIE';
				document.getElementById("nif").title = 'DNI / NIE';
				document.getElementById("denom_interesado").setAttribute("placeholder", "Nom");
				document.getElementById("denom_interesado").setAttribute("title", "Nom");
				break;

			case 'pequenya':
        /* 			document.getElementById("nif").placeholder = 'CIF [Código de Identificación Fiscal]';
				document.getElementById("nif").title = 'CIF [Código de Identificación Fiscal]'; */
				break;

			case 'mediana':
				if (document.contains(document.getElementById("file_altaAutonomos"))) {
					document.getElementById("file_altaAutonomos").remove();
				}
				if (document.contains(document.getElementById("docConstitutivoCluster"))) {
					document.getElementById("docConstitutivoCluster").remove();
				}

        document.getElementById("nif").placeholder = 'CIF [Código de Identificación Fiscal]';
				document.getElementById("nif").title = 'CIF [Código de Identificación Fiscal]';
				break;
		}
}

function validateFormField(field, step=0) {
	var valid = true
	let inputElement = document.getElementById(field.id)
	let aviso = document.getElementById('aviso')
  console.log ( `-${inputElement.value}-` )

	if(inputElement.value === "")
		{
		  inputElement.classList.remove("valid")
		  inputElement.classList.add("invalid")
		  return;
		}

	const regexMail = new RegExp(/^((?!\.)[\w-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/)
	const regexHTTP = new RegExp(/https?:\/\/?[-a-zA-Z0-9]{1,256}\.[a-zA-Z]{2,3}/)
	const regexTel  = new RegExp(/[0-9]{3}[0-9]{3}[0-9]{3}/)
	
	console.log (`Campo actual: ${inputElement.name}`)

	switch (inputElement.name) {
  		case 'nif':
			  if (inputElement.value === '') {
    			aviso.innerHTML = ` "${ inputElement.name }" es "${ inputElement.value }".`;
					inputElement.classList.remove("valid");
					inputElement.classList.add("invalid");
			  } else {
					aviso.innerHTML = ` "${ inputElement.name }" OK `;
					inputElement.classList.remove("invalid");
					inputElement.classList.add("valid");
				}
    		break;

  		case 'nom_representante':
			aviso.innerHTML = `Falta indicar el ${ inputElement.name }, no es correcto: "${ inputElement.value }".`;
    		break;
  		case 'nif_representante':
			aviso.innerHTML = `Falta indicar el ${ inputElement.name }, no es correcto: "${ inputElement.value }".`;
    		break;
		case 'tel_representante':
			if (!regexTel.test(document.getElementById(field.id).value)) {
				aviso.innerHTML = `El teléfono de notificación no es correcto: "${ inputElement.value }".`;
				document.getElementById(field.id).value = ''
				document.getElementById(field.id).focus 
			} else  {
				aviso.innerHTML += `${ inputElement.value } está OK.`;
			}
    		break;	
  		case 'mail_representante':
			if (!regexMail.test(document.getElementById(field.id).value)) {
				aviso.innerHTML = `El correo electrónico de notificación no es correcto: "${ inputElement.value }"`;
				document.getElementById(field.id).value = ''
				document.getElementById(field.id).focus 
			} else  {
				aviso.innerHTML += `${ inputElement.value } está OK.`;
			}
    		break;
  		default:
  			aviso.innerHTML = `Lo lamentamos, este valor no es correcto: "${ inputElement.value }" `;
		}

	let btnSend = document.querySelector(field.id);

	if (Boolean(field.getAttribute('aria-required') == (!field.value))) {
		field.setAttribute('class', 'invalid')
		valid = false;
	} else {
		field.setAttribute('class', 'valid')
		valid = true;
	}
}

function selectorNoSi(field) {
  let inputElement = document.getElementById (field.id)
  let empresa_eco_lbl = document.getElementById("empresa_eco")

  if (inputElement.name === 'tiene_ayudas_subv') {
    if (inputElement.value === 'SI') { 
      document.getElementById("tiene_ayudas_subv_si_no").classList.remove("ocultar")
    } else {
      document.getElementById("tiene_ayudas_subv_si_no").classList.add("ocultar")
      document.getElementById("ayuda_subv_dg_pol_ind").checked = false
      document.getElementById("ayuda_subv_otros").checked = false
      document.getElementById("ayuda_subv_otros_detalle").value = ""

      }

  }

  if (inputElement.name === 'empresa_eco_idi_isba') {
    if (inputElement.value === 'SI') {
      empresa_eco_lbl.innerHTML = "¡¡¡ Tiene una bofificación por ser ECO !!!"
      empresa_eco_lbl.classList.add("valid")
      empresa_eco_lbl.classList.remove("invalid")

    } else {
      empresa_eco_lbl.innerHTML = "No tiene bonificación ECO"
      empresa_eco_lbl.classList.add("invalid")
      empresa_eco_lbl.classList.remove("valid")

    }
  }

  if (inputElement.name === 'ayuda_subv_de') {

    if (inputElement.value === 'otros') {
      document.getElementById("ayuda_subv_otros_detalle").classList.remove("ocultar")
    } else {
      document.getElementById("ayuda_subv_otros_detalle").classList.add("ocultar")
    }

  } 

}

function formatNumber(field) {
  // format number 1000000 to 1,234,567

  let actualFormatNumber = document.getElementById(field.id)
  let newFormatNumber

  newFormatNumber = new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(actualFormatNumber.value)

  actualFormatNumber.value = newFormatNumber

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
			aChild.setAttribute("accept", ".pdf, .jpeg, .png")
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
			bChild.setAttribute("required", true)
			bChild.setAttribute("size" ,"20")
			bChild.setAttribute("type", "file")
			bChild.setAttribute("accept", ".pdf, .jpeg, .png")
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
				copiaNIFChild.setAttribute("required", true)
				copiaNIFChild.setAttribute("size" ,"20")
				copiaNIFChild.setAttribute("type", "file")
				copiaNIFChild.setAttribute("accept", ".pdf, .jpeg, .png")
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
				consentId.setAttribute("required", true)
				consentId.setAttribute("size" ,"20")
				consentId.setAttribute("type", "file")
				consentId.setAttribute("accept", ".pdf, .jpeg, .png")
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
				consentATIB.setAttribute("required", true)
				consentATIB.setAttribute("size" ,"20")
				consentATIB.setAttribute("type", "file")
				consentATIB.setAttribute("accept", ".pdf, .jpeg, .png")
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
		if (id == "consentimiento_TesoreriaSegSoc")
		{
			if (!document.getElementById("consentimiento_TesoreriaSegSoc").checked) {
				document.getElementById("enviarcertificadoSecSoc").remove = 'ocultar';
				document.getElementById("enviarcertificadoSecSoc").className = 'enviararchivo_ver';
				let elemntConsentSegSoc = document.getElementById("enviarcertificadoSecSoc")
				let consentSegSoc = document.createElement('input')
				consentSegSoc.setAttribute("aria-required", true)
				consentSegSoc.setAttribute("required", true)
				consentSegSoc.setAttribute("size" ,"20")
				consentSegSoc.setAttribute("type", "file")
				consentSegSoc.setAttribute("accept", ".pdf, .jpeg, .png")
				consentSegSoc.setAttribute("multiple", "true")
				consentSegSoc.setAttribute("id", "file_certificadoSegSoc")
				consentSegSoc.setAttribute("name", "file_certificadoSegSoc[]")
				consentSegSoc.setAttribute("onblur", "validateFormField(this);")			
				elemntConsentSegSoc.appendChild(consentSegSoc)											
			}
			else
			{
				document.getElementById("enviarcertificadoSecSoc").remove = 'enviararchivo_ver';
				document.getElementById("enviarcertificadoSecSoc").className = 'ocultar';				
				if (document.contains(document.getElementById("file_certificadoSegSoc"))) {
					document.getElementById("file_certificadoSegSoc").remove();
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
				consentSS.setAttribute("required", true)
				consentSS.setAttribute("size" ,"20")
				consentSS.setAttribute("type", "file")
				consentSS.setAttribute("accept", ".pdf, .jpeg, .png")
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
				contenedorImporte.setAttribute("required", true)
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



