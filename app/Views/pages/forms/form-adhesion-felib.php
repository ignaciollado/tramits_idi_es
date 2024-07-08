<!-- CONTENT -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="/public/assets/css/form-solicitud-ayuda.css"/>

<section id="formulario_solicitud">

	<?php
		helper('cookie');
		$language = \Config\Services::language();
		$viaSolicitud = "*";
		$locale = $language->getLocale();
	?>
<form name="adhesion_felib" id="adhesion_felib" action="<?php echo base_url('/public/index.php/subirarchivo/store_felib/'.$viaSolicitud.'/'.$locale);?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

<div class="stepContainer">
	<span class="step">1</span>
	<span class="step">2</span>
  <span class="step">3</span>
	
	<div class="buttonContainer">
    	<button title="<?php echo lang('message_lang.btn_previous');?>" onClick="nextPrev(-1)" type="button" class="buttonAsistente" id="prevBtn"><?php echo lang('message_lang.btn_previous');?></button>
    	<button title="<?php echo lang('message_lang.btn_next');?>"  onClick="nextPrev(1)" disabled class="ocultar" type="button"  id="nextBtn"><?php echo lang('message_lang.btn_next');?></button>
	</div>
</div>
<span id='aviso'>*</span>
<!-- One "tab" for each step in the form: -->
<!-------------------------- 0. INFO DOCUMENTACIÓN NECESARIA y ACEPTA EL RGPD --------------------------------------------------------------------->
	<div class="tab">
		<div>
			<fieldset>
				<label for = "rgpd" class="main">
					<span><?php echo lang('message_lang.rgpd_leido');?></span>
					<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal"><abbr title='Reglamento general de protección de datos'>RGPD.</abbr></button>
					<input type="checkbox" class="requerido" onChange="javaScript: habilitarNextButton (this.checked);" required value="rgpd" name = "rgpd" id = "rgpd">
					<span class="w3docs"></span>
				</label>
			</fieldset>
		</div>

 		<fieldset>
			<!-- <?php echo lang('message_lang.documentacion_necesaria_pymes_ils');?>
			<?php echo lang('message_lang.documentacion_necesaria_si_no_autoriza');?> -->
			<h3><?php echo lang('message_lang.documentacion_resultante_cabecera');?></h3>
			<?php echo lang('message_lang.documentacion_resultante_felib');?>
		</fieldset>
	</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reglamento (UE) 2016/679 General de Protección de Datos (RGPD)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<?php echo lang('message_lang.rgpd_txt'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-------------------------- 1. DATOS DEL AYUNTAMIENTO ---------------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
		<fieldset id="interesado">
			<h2><?php echo lang('message_lang.identificacion_felib');?></h2>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.alcalde_felib');?>" placeholder = "<?php echo lang('message_lang.alcalde_felib');?>" aria-required="true" name="alcalde_felib" id="alcalde_felib">	
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/municipios.php';?>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.direccion_felib');?>" placeholder = "<?php echo lang('message_lang.direccion_felib');?>" name="domicilio" id="domicilio">
			<input type = "text" onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.cp_felib');?>" placeholder = "<?php echo lang('message_lang.cp_felib');?>" name="cpostal" id="cpostal" pattern="[0-9]{5}" minlength = "5" maxlength = "5" size="9"> 
			<input type = "email" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.mail_felib');?>" placeholder = "<?php echo lang('message_lang.mail_felib');?>" data-error = "<?php echo lang('message_lang.mail_felib');?>" name = "mail_felib" id="mail_felib" size="220">		 
			<input type = "tel"  onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.tel_felib');?>" placeholder = "<?php echo lang('message_lang.tel_felib');?>" name = "telefono_cont" id="telefono_cont" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" ><p id="mensaje_tel"></p> 
  		<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.responsable_felib');?>" placeholder = "<?php echo lang('message_lang.responsable_felib');?>" aria-required="true" name = "responsable_felib" id = "responsable_felib" size="220">
  		<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.cargo_felib');?>" placeholder = "<?php echo lang('message_lang.cargo_felib');?>" name = "cargo_felib" id = "cargo_felib" size="220">
			<input type = "tel" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.tel_rep_legal_felib');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_felib');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength="9" size="9" ><p id="mensaje_tel"></p>
			<input type = "email" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.mail_rep_legal_felib');?>" placeholder = "<?php echo lang('message_lang.mail_rep_legal_felib');?>" data-error = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" aria-required="true" name = "mail_representante" id="mail_representante" size="220">
		</fieldset> 
	</div>

</div>
<!-------------------------- 3. PROGRAMAS --------------------------------------------------------------------->
<div class="tab" id="programas">
  	<div id="formbox2" class="formbox">
    <fieldset><span class="ocultar" id="aviso2"><?php echo lang('message_lang.marque_una_opcion');?></span>
		<h2><?php echo lang('message_lang.programa_tipo');?></h2>
 		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p1');?></h6>
			<input type="checkbox" name="felib_p1" title="<?php echo lang('message_lang.felib_p1');?>" id="felib_p1" value="felib_p1">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p2');?></h6>
			<input type="checkbox" name="felib_p2" title="<?php echo lang('message_lang.felib_p2');?>" id="felib_p2" value="felib_p2">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p3');?></h6>
			<input type="checkbox" name="felib_p3" title="<?php echo lang('message_lang.felib_p3');?>" id="felib_p3" value="felib_p3">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p4');?></h6>
			<input type="checkbox" name="felib_p4" title="<?php echo lang('message_lang.felib_p4');?>" id="felib_p4" value="felib_p4">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p5');?></h6>
			<input type="checkbox" name="felib_p5" title="<?php echo lang('message_lang.felib_p5');?>" id="felib_p5" value="felib_p5">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p6');?></h6>
			<input type="checkbox" name="felib_p6" title="<?php echo lang('message_lang.felib_p6');?>" id="felib_p6" value="felib_p6">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p7');?></h6>
			<input type="checkbox" name="felib_p7" title="<?php echo lang('message_lang.felib_p7');?>" id="felib_p7" value="felib_p7">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p8');?></h6>
			<input type="checkbox" name="felib_p8" title="<?php echo lang('message_lang.felib_p8');?>" id="felib_p8" value="felib_p8">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p9');?></h6>
			<input type="checkbox" name="felib_p9" title="<?php echo lang('message_lang.felib_p9');?>" id="felib_p9" value="felib_p9">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p10');?></h6>
			<input type="checkbox" name="felib_p10" title="<?php echo lang('message_lang.felib_p10');?>" id="felib_p10" value="felib_p10">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p11');?></h6>
			<input type="checkbox" name="felib_p11" title="<?php echo lang('message_lang.felib_p11');?>" id="felib_p11" value="felib_p11">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p12');?></h6>
			<input type="checkbox" name="felib_p12" title="<?php echo lang('message_lang.felib_p12');?>" id="felib_p12" value="felib_p12">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.felib_p13');?></h6>
			<input type="checkbox" name="felib_p13" title="<?php echo lang('message_lang.felib_p13');?>" id="felib_p13" value="felib_p13">
			<span class="checkmark"></span>
		</label>
   	</fieldset>
	</div>
</div>

<!-------------------------- 4. NOTIFICACIÓN y AUTORIZACIONES --------------------------------------------------------------------->
<!-- <div class="tab">
	<div id="formbox">
  	<fieldset>
			<h2><?php echo lang('message_lang.titulo_notificiaciones');?></h2>
			<input type = "tel" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength="9" size="9" ><p id="mensaje_tel"></p>
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
				<input title = "<?php echo lang('message_lang.doy_mi_consentimiento_pdf');?>" checked type="checkbox" name="consentimiento_certificadoATIB" id="consentimiento_certificadoATIB" onchange = "javaScript: muestraSubeArchivo(this.id);">
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
</div> -->

<!-------------------------- 7. DOCUMENTACIÓN --------------------------------------------------------------------->
<!-- <div class="tab">
	<div id="formbox">
		<fieldset>
			<h2>7. <?php echo lang('message_lang.documentacion_adjunta_requerida_ils');?></h2>
			<h3><strong><?php echo lang('message_lang.escritura_empresa_ils');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_escritura_empresa" name="file_escritura_empresa[]" title="<?php echo lang('message_lang.escritura_empresa_ils');?>" class="mostrar-siempre" size="50" accept=".pdf" multiple aria-required="true" onblur = "javaScript: validateFormField(this);"/>
			</div>

			<h3><strong><?php echo lang('message_lang.certificado_IAE');?></strong></h3> <code>[.pdf] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificadoIAE" name="file_certificadoIAE[]" title="<?php echo lang('message_lang.certificado_IAE');?>" class="mostrar-siempre" size="50" accept=".pdf" multiple aria-required="true" onblur = "javaScript: validateFormField(this);"/>
			</div>


			<div class="caja-grupo">
				<label class="container-radio"><h6><?php echo lang('message_lang.presentar_informes_calculo_huella_carbono');?></h6>
					<input type="radio" name="informeOCertificado" title="<?php echo lang('message_lang.presentar_informes_calculo_huella_carbono');?>" id="informe" onchange = "javaScript: presentarInformeOCertificado (this.id);">
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
				<input type="radio" name="informeOCertificado" title="<?php echo lang('message_lang.presentar_certificado_verificacion_ISO');?>" id="certificado" onchange = "javaScript: presentarInformeOCertificado (this.id);">
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
</div> -->
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
        /* Removing whitespace at the beginning of the cookie name and compare it with the given string */
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
	if (n === 2) {
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
		case 'tel_representante':
			if (!regexTel.test(document.getElementById(field.id).value)) {
				aviso.innerHTML = `El telèfon de notificació no es correcte: "${ inputElement.value }".`;
				document.getElementById(field.id).value = ''
				document.getElementById(field.id).focus 
			} else  {
				aviso.innerHTML += `${ inputElement.value } está OK.`;
			}
    		break;	
  		case 'mail_representante':
			if (!regexMail.test(document.getElementById(field.id).value)) {
				aviso.innerHTML = `La adreça electrònica de notificació no es correcte: "${ inputElement.value }"`;
				document.getElementById(field.id).value = ''
				document.getElementById(field.id).focus 
			} else  {
				aviso.innerHTML += `${ inputElement.value } está OK.`;
			}
    		break;
  		default:
  			aviso.innerHTML = `Aquest valor no es correcte: "${ inputElement.value }" `;
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

  if (currentTab === 2) {
	// Validar que un checkbox de '3. PROGRAMAS' esté activado
  	if ( !document.getElementById("felib_p1").checked && !document.getElementById("felib_p2").checked && !document.getElementById("felib_p3").checked &&
		!document.getElementById("felib_p4").checked && !document.getElementById("felib_p5").checked && !document.getElementById("felib_p6").checked &&
		!document.getElementById("felib_p7").checked && !document.getElementById("felib_p8").checked && !document.getElementById("felib_p9").checked &&
		!document.getElementById("felib_p10").checked && !document.getElementById("felib_p11").checked && !document.getElementById("felib_p12").checked &&
		!document.getElementById("felib_p13").checked ) {
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
  	for (i = 2; i >= n; i--) {
    	x[i].className = x[i].className.replace(" finish", "");
 	 }	  
  	for (i = 0; i < x.length; i++) {
    	x[i].className = x[i].className.replace(" active", "");
 	 }
  	//... and adds the "active" class on the current step:
	// Para evitar el error Uncaught TypeError: x[n] is undefined que me aparece cuando n==8
	if (n < 2) {
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