<!-- CONTENT -->
	<script defer type="text/javascript" src="/public/assets/js/comprueba-Documento-Identificador.js"></script>
	<script defer type="text/javascript" src="/public/assets/js/adhesion-ils.js"></script>	
	<link rel="stylesheet" type="text/css" href="/public/assets/css/form-adhesion-ils.css"/>

<section id="formulario_solicitud">

	<div id="aviso" class="alert">
		<?php echo lang('message_lang.intro_ils');?>
	</div>

  <?php
  	helper('cookie');
  	$language = \Config\Services::language();
  	$locale = $language->getLocale();
  ?>

  <form name="adhesion_ils" id="adhesion_ils" action="<?php echo base_url('/public/index.php/subirarchivo/store_ils/'.$viaSolicitud.'/'.$locale);?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

  <div class="stepContainer">
    <span class="step">1</span>
	  <span class="step">2</span>
    <span class="step">3</span>
    <span class="step">4</span>
    <span class="step">5</span>
	
	  <div  class="buttonContainer">
    	<button title="<?php echo lang('message_lang.btn_previous');?>" onClick="nextPrev(-1)" type="button" class="buttonAsistente" id="prevBtn"><?php echo lang('message_lang.btn_previous');?></button>
    	<button title="<?php echo lang('message_lang.btn_next');?>"  onClick="nextPrev(1)" disabled class="ocultar" type="button"  id="nextBtn"><?php echo lang('message_lang.btn_next');?></button>
	  </div>
  </div>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="#-1">Previous</a></li>
      <li class="page-item"><a class="page-link" href="#empresa">1</a></li>
      <li class="page-item"><a class="page-link" href="#3">2</a></li>
      <li class="page-item"><a class="page-link" href="#4">3</a></li>
      <li class="page-item"><a class="page-link" href="#5">4</a></li>
      <li class="page-item"><a class="page-link" href="#6">5</a></li>
      <li class="page-item"><a class="page-link" href="#+1">Next</a></li>
    </ul>
  </nav>

<!-- One "tab" for each step in the form: -->
<!-------------------------- 0. INFO DOCUMENTACIÓN NECESARIA y ACEPTA EL RGPD --------------------------------------------------------------------->
<div class="tab">

  <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" role="switch" onChange="javaScript: habilitarNextButton (this.checked);" required value="rgpd" name = "rgpd" id = "rgpd">
    <label class="form-check-label" for="flexSwitchCheckDefault"><?php echo lang('message_lang.rgpd_leido');?> <a href="#"  data-toggle="modal" data-target="#rgpdModal"><abbr title='Reglament general de protecció de dades'>RGPD.</abbr></a></label>
  </div>

  <fieldset>
 		<!-- <h3><?php echo lang('message_lang.documentacion_necesaria');?></h3> -->
			<?php echo lang('message_lang.documentacion_necesaria_pymes_ils');?>
			<?php echo lang('message_lang.documentacion_necesaria_si_no_autoriza');?>
			<h3><?php echo lang('message_lang.documentacion_resultante_cabecera');?></h3>
			<?php echo lang('message_lang.documentacion_resultante_ils');?>
		</fieldset>

</div>

<div id="rgpdModal" class="modal fade" role="dialog">
  			<div class="modal-dialog">
	    		<div class="modal-content">
      				<div class="modal-header">
	        			<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 class="modal-title"><?php echo lang('message_lang.rgpd_leido');?> <abbr title='Reglamento general de protección de datos'>RGPD.</abbr></h4>
      				</div>
      				<div class="modal-body">
	        			<p>
						<?php
						if (get_cookie('CurrentLanguage')==="ca") {
							include 'includes/clausulaProteccionDatos.html';
						} else {
							include 'includes/clausulaProteccionDatos-es.html';
						}
						?>
						</p>
    	  			</div>
      				<div class="modal-footer">
	        			<button type="button" class="btn btn-default" data-dismiss="modal">Tanca</button>
      				</div>
    			</div>
  			</div>
</div>

<!-------------------------- 1. SELECCIONA EL PROGRAMA --------------------------------------------------------------------->


<!-------------------------- 2. TIPO DE EMPRESA ---------------------------------------------------------------------------->
<div class="tab" id="#empresa">
	
  	<div id="formbox2" class="formbox">

    <fieldset><span class="ocultar" id="aviso2"><?php echo lang('message_lang.marque_una_opcion');?></span>
		<h2><?php echo lang('message_lang.solicitante_tipo');?></h2>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="tipo_solicitante" id="pequenya" onchange = "javaScript: tipoSolicitante (this.id);" value="pequenya">
      <label class="form-check-label" for="pequenya">
      <h3><?php echo lang('message_lang.solicitante_tipo_pequenya');?></h3>
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="tipo_solicitante" id="mediana" onchange = "javaScript: tipoSolicitante (this.id);" value="mediana">
      <label class="form-check-label" for="mediana">
      <h3><?php echo lang('message_lang.solicitante_tipo_mediana');?></h3>
      </label>
    </div>

		<label class="container-radio">	
			<span class="tooltiptext_idi"> <?php echo lang('message_lang.info_tipo_empresa');?> </span>
		</label>
   	</fieldset>
   	
	</div>

</div>
<!-------------------------- 3. DATOS GENERALES --------------------------------------------------------------------->
<div class="tab">

	<div id="formbox">
	<fieldset id="interesado">
		<h2><?php echo lang('message_lang.identificacion_sol_ils');?></h2>

  <div class="form-floating mb-3">
    <input class="form-control" type = "text" onfocus="javaScript: limpiaInfo_lbl (this.value);" onBlur = "javaScript: validateFormField(this); averiguaTipoDocumento (this.value);" title="<?php echo lang('message_lang.nif_solicitante');?>" placeholder = "<?php echo lang('message_lang.nif_solicitante');?>" aria-required="true" name = "nif" id = "nif" minlength = "9" maxlength = "9"><span id = "info_lbl"></span>
    <label for="floatingInput">NIF del solicitante</label>
  </div>
  <div class="form-floating">
    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
    <label for="floatingPassword">Dirección postal</label>
  </div>

		<!-- <input class="" type = "text" onfocus="javaScript: limpiaInfo_lbl (this.value);" onBlur = "javaScript: validateFormField(this); averiguaTipoDocumento (this.value); tenemosDatosSolicitante (this.value);" title="<?php echo lang('message_lang.nif_solicitante');?>" placeholder = "<?php echo lang('message_lang.nif_solicitante');?>" aria-required="true" name = "nif" id = "nif" minlength = "9" maxlength = "9"><span id = "info_lbl"></span> -->
		<input class="" type = "text" onfocus="javaScript: limpiaInfo_lbl (this.value);" onBlur = "javaScript: validateFormField(this); averiguaTipoDocumento (this.value);" title="<?php echo lang('message_lang.nif_solicitante');?>" placeholder = "<?php echo lang('message_lang.nif_solicitante');?>" aria-required="true" name = "nif" id = "nif" minlength = "9" maxlength = "9"><span id = "info_lbl"></span>
		<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" aria-required="true" name = "denom_interesado" id = "denom_interesado" size="220">
		<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.direccion_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_sol_idigital');?>" aria-required="true" name="domicilio" id="domicilio">
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/municipios.php';?>
		<input type = "text" onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.cp_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.cp_sol_idigital');?>" aria-required="true" name="cpostal" id="cpostal" pattern="[0-9]{5}" minlength = "5" maxlength = "5" size="9">  
        <input type = "tel" onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.movil_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_sol_idigital');?>" aria-required="true" name = "telefono_cont" id="telefono_cont" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" ><p id="mensaje_tel"></p>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/epigrafeIAE_ils.php';?>
	
		<!-- <input type="date" aria-required="true" name = "fecha_creacion_empresa" id = "fecha_creacion_empresa" title="<?php echo lang('message_lang.fecha_creacion_empresa_ils');?>" placeholder = "<?php echo lang('message_lang.fecha_creacion_empresa_ils');?>" onblur="javaScript: validateFormField(this);"> -->
		<!-- <textarea id="canales_comercializacion_empresa" name="canales_comercializacion_empresa" title="<?php echo lang('message_lang.comercializacion_empresa_ils');?>" placeholder = "<?php echo lang('message_lang.comercializacion_empresa_ils');?>" rows="3" cols="50"></textarea> -->
		<input type="text" name = "sitio_web_empresa" id = "sitio_web_empresa" title="<?php echo lang('message_lang.sitio_web_empresa_ils');?>" placeholder = "<?php echo lang('message_lang.sitio_web_empresa_ils');?>" onblur="javaScript: validateFormField(this);">
		<input type="text" name = "video_empresa" id = "video_empresa" title="<?php echo lang('message_lang.video_empresa_ils');?>" placeholder = "<?php echo lang('message_lang.video_empresa_ils');?>">
		
		<input type="text" aria-required="true" name = "nom_representante" id = "nom_representante" title="<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" onblur="javaScript: validateFormField(this);">
		<input type="text" aria-required="true" name = "nif_representante" id = "nif_representante" title="<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">
<!-- 		<input type="tel" name = "tel_representante" id = "tel_representante" title="<?php echo lang('message_lang.telefono_representante');?>" placeholder = "<?php echo lang('message_lang.telefono_representante');?>" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" onblur="javaScript: validateFormField(this);">
		<input type="email" aria-required="true" name = "mail_representante" id = "mail_representante" title="<?php echo lang('message_lang.mail_representante');?>" placeholder = "<?php echo lang('message_lang.mail_representante');?>" onblur="javaScript: validateFormField(this);">
 -->

	</fieldset> 
	</div>
</div>

<!-------------------------- 4. NOTIFICACIÓN y AUTORIZACIONES --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
    <fieldset>
		<h2><?php echo lang('message_lang.titulo_notificiaciones');?></h2>
		<input type = "tel" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength = "9" size="9" ><p id="mensaje_tel"></p>
		<input type = "email" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" data-error = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" aria-required="true" name = "mail_representante" id="mail_representante" size="220">		 
	</fieldset>
	</div>

	<div id="formbox">
    <fieldset>
		<h2><?php echo lang('message_lang.autorizaciones_solicitud_ils');?></h2>
			<label for = "consentimiento_identificacion" class="main"><?php echo lang('message_lang.consentimiento_identificacion_solicitante');?>
				<input title = "<?php echo lang('message_lang.consentimiento_identificacion_solicitante');?>" checked type="checkbox" name="consentimiento_identificacion" id="consentimiento_identificacion" onchange = "javaScript: muestraSubeArchivo(this.id);">
				<span class = "w3docs"></span>
			</label>
			<div id = "enviardocumentoIdentificacion" class = "ocultar">
				<label for = "file_enviardocumentoIdentificacion"><h5><?php echo lang('message_lang.document_identificativos');?></h5><code>[.pdf]:</code>
			</div>
			
			<label for = "consentimiento_certificadoATIB" class="main"><?php echo lang('message_lang.doy_mi_consentimiento_pdf');?>
				<input title = "<?php echo lang('message_lang.doy_mi_consentimiento');?>" checked type="checkbox" name="consentimiento_certificadoATIB" id="consentimiento_certificadoATIB" onchange = "javaScript: muestraSubeArchivo(this.id);">
				<span class = "w3docs"></span>
			</label>
			<div id = "enviarcertificadoATIB" class = "ocultar">
				<label for = "file_certificadoATIB"><h5><?php echo lang('message_lang.certificado_document_correspon');?></h5><code>[.pdf]:</code> 
			</div>
	</fieldset>
	</div>

	<div id="formbox">
	<fieldset>

		<h2>6. <?php echo lang('message_lang.declaracion_responsable_cabecera_ils');?></h2>

		<label for = "declaracion_responsable_i" class="main"><?php echo lang('message_lang.declaracion_responsable_i_ils');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_i_ils');?>" disabled checked type="checkbox" name="declaracion_responsable_i" id="declaracion_responsable_i" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>

			<label for = "declaracion_responsable_v" class="main"><?php echo lang('message_lang.declaracion_responsable_v_ils');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_v');?>" disabled checked type="checkbox" name="declaracion_responsable_v" id="declaracion_responsable_v" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>
		    
			<label for = "declaracion_responsable_vii" class="main"><?php echo lang('message_lang.declaracion_responsable_vii_ils');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_vii_ils');?>" disabled checked type="checkbox" name="declaracion_responsable_vii" id="declaracion_responsable_vii" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>
		    
			<label for = "declaracion_responsable_ix" class="main"><?php echo lang('message_lang.declaracion_responsable_ix_ils');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_ix_ils');?>" disabled checked type="checkbox" name="declaracion_responsable_ix" id="declaracion_responsable_ix" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>
    						
	</fieldset>
	</div>
	<div  class="buttonContainer">
    	<button title="Anterior" onClick="nextPrev(-1)" type="button" class="buttonAsistente" id="prevBtn"><?php echo lang('message_lang.btn_previous');?></button>
    	<button title="Següent"  onClick="nextPrev(1)"  type="button" class="buttonAsistente" id="nextBtn"><?php echo lang('message_lang.btn_next');?></button>
	</div>
</div>

<!-------------------------- 7. DOCUMENTACIÓN --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
		<fieldset>
			<h2>7. <?php echo lang('message_lang.documentacion_adjunta_requerida_ils');?></h2>
						<!-- <div id="mostrarEscritura"> -->
			<h3><strong><?php echo lang('message_lang.escritura_empresa_ils');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_escritura_empresa" name="file_escritura_empresa[]" title="<?php echo lang('message_lang.escritura_empresa_ils');?>" class="mostrar-siempre" size="50" accept=".pdf" multiple aria-required="true" onblur = "javaScript: validateFormField(this);"/>
			</div>
						<!-- </div> -->
					<!-- 	<div id="mostrarIAE"> -->
			<h3><strong><?php echo lang('message_lang.certificado_IAE');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificadoIAE" name="file_certificadoIAE[]" title="<?php echo lang('message_lang.certificado_IAE');?>" class="mostrar-siempre" size="50" accept=".pdf" multiple aria-required="true" onblur = "javaScript: validateFormField(this);"/>
			</div>
						<!-- </div> -->

		<div class="caja-grupo">
			<label class="container-radio"><h6><?php echo lang('message_lang.presentar_informes_calculo_huella_carbono');?></h6>
				<input type="radio" name="informeOCertificado" title="<?php echo lang('message_lang.informe_resumen_informe_inventario');?>" id="informe" onchange = "javaScript: presentarInformeOCertificado (this.id);">
				<span id="informeCheck" class="checkmark checkmark-caja-grupo"></span>
			</label>		
		</div>
						<div id="mostrarInformes" class="ocultar">			
			<h3><strong><?php echo lang('message_lang.informe_resumen_ils');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_informeResumenIls" name="file_informeResumenIls[]" title="<?php echo lang('message_lang.informe_resumen_ils');?>" size="50" accept=".pdf" multiple/>
			</div>
			<h3><strong><?php echo lang('message_lang.informe_inventario_ils');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_informeInventarioIls" name="file_informeInventarioIls[]" title="<?php echo lang('message_lang.informe_inventario_ils');?>" size="50" accept=".pdf" multiple/>
			</div>
						</div>
		<div class="caja-grupo">						
			<label class="container-radio"><h6><?php echo lang('message_lang.presentar_certificado_verificacion_ISO');?></h6>
				<input type="radio" name="informeOCertificado" title="<?php echo lang('message_lang.prescertificado_verificacion_ISO');?>" id="certificado" onchange = "javaScript: presentarInformeOCertificado (this.id);">
				<span id="certificadoCheck" class="checkmark checkmark-caja-grupo"></span>
			</label>
		</div>					
						<div id="mostrarCertificadoISO" class="ocultar">							
			<h3><strong><?php echo lang('message_lang.certificado_verificacion_ISO');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificado_verificacion_ISO" name="file_certificado_verificacion_ISO[]" title="<?php echo lang('message_lang.certificado_verificacion_ISO');?>" size="50" accept=".pdf" multiple/>
			</div>
						</div>

			<h3><strong><?php echo lang('message_lang.modelo_ejemplo_ils');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_modeloEjemploIls" name="file_modeloEjemploIls[]" title="<?php echo lang('message_lang.modelo_ejemplo_ils');?>" size="50" accept=".pdf" multiple aria-required="true" onblur = "javaScript: validateFormField(this);"/>
			</div>							

			<h3><strong><?php echo lang('message_lang.certificado_itinerario_formativo');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificado_itinerario_formativo" name="file_certificado_itinerario_formativo[]" title="<?php echo lang('message_lang.certificado_itinerario_formativo');?>" size="50" accept=".pdf" multiple aria-required="true" onblur = "javaScript: validateFormField(this);"/>
			</div>						
		</fieldset>
	</div>

	<div id="formbox">
		<fieldset>
			<h2>8. <?php echo lang('message_lang.documentacion_adjunta_opcional_ils');?></h2>
						<div id="mostrarMemoriaTecnica">
		    <h3><strong><?php echo lang('message_lang.memoria_tecnica_ils');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_memoriaTecnica" name="file_memoriaTecnica[]" title="<?php echo lang('message_lang.memoria_tecnica_ils');?>" size="50" accept=".pdf" multiple/>
			</div>
						</div>	
						<div id="mostrarNIF">
			<h3><strong><?php echo lang('message_lang.cif_empresa');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_nifEmpresa" name="file_nifEmpresa[]" title="<?php echo lang('message_lang.cif_empresa');?>" size="50" accept=".pdf" multiple/>
			</div>
						</div>

			<h3><strong><?php echo lang('message_lang.logotipo_empresa_ils');?></strong></h3> <code>[.webp, .jpeg, .svg] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_logotipoEmpresaIls" name="file_logotipoEmpresaIls[]" title="<?php echo lang('message_lang.logotipo_empresa_ils');?>" size="50" accept=".webp, .jpg, .svg" multiple/>
			</div>				
		</fieldset>
	</div>	
	<div id="formbox">	
		<span class="tooltiptext_idi"><h3><?php echo lang('message_lang.upload_multiple');?></h3></span>	
	</div>
</div>
</div>

</form>

<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  let itramitsCookies = document.cookie.split(";");
    console.log ("current tab", n)
    // Loop through the array elements
    for(var i = 0; i < itramitsCookies.length; i++) {
        var cookiePair = itramitsCookies[i].split("=");
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if("itramitsCurrentLanguage" == cookiePair[0].trim()) {
            // Decode the cookie value and return
            let currentLanguage = decodeURIComponent(cookiePair[0].trim()+" "+cookiePair[1]);
        }
    }

  x[n].style.display = "block";

  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  
  let submitBTN = document.getElementById("nextBtn")
  // if (n == (x.length - 1)) {
	if (n === 4) {
		document.getElementById("file_escritura_empresa").style.display = "block";
		document.getElementById("file_certificadoIAE").style.display = "block";

	  submitBTN.innerHTML = "Enviar"
	  submitBTN.setAttribute("title", "Enviar")
	  submitBTN.setAttribute("value", "Submit")
	  submitBTN.setAttribute("form", "adhesion_ils")
	  submitBTN.setAttribute("onclick", "onFormSubmit(this)")
		submitBTN.setAttribute("class", "buttonAsistente buttonEnviar");  
  } else {
		submitBTN.innerHTML = "Següent"
		submitBTN.setAttribute("onclick", "nextPrev(1)")
  }
  //... and run the function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateFormField(field, step=0) {
	var valid = true;
	let inputElement = document.getElementById(field.id)
	let aviso = document.getElementById('aviso')

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
  		case 'fecha_creacion_empresa':
			aviso.innerHTML = ` "${ inputElement.name }" es "${ inputElement.value }".`;
    		break;
  		case 'sitio_web_empresa':
			if (!regexHTTP.test(document.getElementById(field.id).value)) {
				aviso.innerHTML = `falta indicar el "${ inputElement.name }" no es correcto: ${ inputElement.value }.`;
				document.getElementById(field.id).value = ''
				document.getElementById(field.id).focus 
			} else  {
				aviso.innerHTML = `"${ inputElement.value }" es correcto.`;
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

function validateForm() {
  // This function deals with validation of the form fields
  	var tabs, inputs, selects, i, valid = true;
  	tabs = document.getElementsByClassName("tab");
  	inputs = tabs[currentTab].getElementsByTagName("input");
  	// inputs = tabs[currentTab].querySelector("requerido");
  	// A loop that checks every INPUT field in the current tab:
  	for (let cell of inputs) {
	    // If a field is empty and has required attribute ...
		/* if (cell.id != "empresa_consultor") { */
			if ( (!cell.value ) && ( cell.getAttribute('aria-required')) ) {
	   			cell.setAttribute ('class','aviso');
      			valid = false;
    		}
		/* } */
  	}
 
  	selects = tabs[currentTab].getElementsByTagName("select");
  	// Same with every SELECT field in the current tab:
  	for (let cell of selects) {
	    // If a field is empty and has required attribute ...
    	if (cell.value === '') {
	      	// add an "invalid" class to the field:
	  		cell.setAttribute ('class','aviso');
      		// and set the current valid status to false
      		valid = false;
    	} 
  	}

  if (currentTab===1) {
	// Validar que un checkbox de '2. TIPO DE EMPRESA' esté activado
  	if ( !document.getElementById("pequenya").checked && !document.getElementById("mediana").checked && !document.getElementById("autonomo").checked) {
		document.getElementById("aviso2").className = 'aviso-lbl';
		document.getElementById("formbox2").classList.add("aviso");
		valid = false;
  	}
  }

  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    	document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status

}

function fixStepIndicator(n) {
  	// This function removes the "active" class of all steps...
  	var i, x = document.getElementsByClassName("step");
  	for (i = 4; i >= n; i--) {
    	x[i].className = x[i].className.replace(" finish", "");
 	 }	  
  	for (i = 0; i < x.length; i++) {
    	x[i].className = x[i].className.replace(" active", "");
 	 }
  	//... and adds the "active" class on the current step:
	// Para evitar el error Uncaught TypeError: x[n] is undefined que me aparece cuando n==8
	if (n < 7) {
  		x[n].className += " active";
	}
	document.getElementById('aviso').innerHTML = ''
}
</script>
</section>

<!-- The Modal -->
<div id="myModal" class="modal">
	
	<div class="modal-header">
    	<h2><?php echo lang('message_lang.cabecera_modal_form_adhesion_ils');?></h2>
  	</div>
  	<!-- Modal content -->
  	<div class="modal-content">
    	<ol id="info-disponible"></ol>
  	</div>
  	<div class="modal-footer">
	  	<h2><?php echo lang('message_lang.si_no_aprovechar_info_asoc_a_NIF_ils');?></h2>
  	</div>
  	<div class="modal-footer">
  		<button onclick="javaScript: cierraModal()" class="btn btn-secondary btn-lg btn-block">No</button><button onclick="javaScript: actualizoFormConDatosSolicitante()" class="btn btn-success btn-lg btn-block">Si</button>
  	</div>

</div>