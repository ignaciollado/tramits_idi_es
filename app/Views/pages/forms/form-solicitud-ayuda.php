<!-- CONTENT -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="/public/assets/css/form-solicitud-ayuda.css"/>
	<script type="text/javascript" src="/public/assets/js/comprueba-Documento-Identificador.js"></script>
	<script type="text/javascript" src="/public/assets/js/solicitud-ayuda.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<section id="formulario_solicitud">
	<div class="alert alert-info">
		<?php echo lang('message_lang.intro_sol_idigital');?>
	</div>

<form name="xecs_form" id="xecs_form" action="<?php echo base_url('/public/index.php/subirarchivo/store/'.$viaSolicitud);?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<h1><?php echo lang('message_lang.asistente_de_tramitacion').$viaSolicitud;?></h1>

	<div class="stepContainer">
		<span class="step">0</span>
		<span class="step">1</span>
  	<span class="step">2</span>
  	<span class="step">3</span>
  	<span class="step">4</span>
  	<span class="step">5</span>
  	<span class="step">6</span>
		<span class="step">7</span> 
	<div  class="buttonContainer" >
    	<button title="Anterior" onClick="nextPrev(-1)" type="button" class="buttonAsistente" id="prevBtn" ><?php echo lang('message_lang.btn_previous');?></button>
    	<button title="Següent" onClick="nextPrev(1)" disabled class="ocultar" type="button"  id="nextBtn" ><?php echo lang('message_lang.btn_next');?></button>
	</div>
</div>

<!-- One "tab" for each step in the form: -->
<!-------------------------- 0. INFO DOCUMENTACIÓN NECESARIA y ACEPTA EL RGPD --------------------------------------------------------------------->
	<div class="tab">
		<div class="p-2 bg-white text-center">
		<div class="langtoggle btn-group">
			<a title="Català" href="<?php echo base_url('/public/index.php/home/set_lang/ca'); ?>" class="btn btn-outline-light text-dark" role="button"> Català</a>
			<a title="Castellano" href="<?php echo base_url('/public/index.php/home/set_lang/es'); ?>" class="btn btn-outline-light text-dark" role="button"> Castellano</a>
		</div>
		</div>
		<div>
		<fieldset>
    	<!--<legend><strong><?php echo lang('message_lang.rgpd');?></strong></legend>-->
		<label for = "rgpd" class="main" >
			<span ><?php echo lang('message_lang.rgpd_leido');?> 

			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><abbr title='Reglamento general de protección de datos'>RGPD.</abbr></button>

				<input type="checkbox" class="requerido" onChange="javaScript: habilitarNextButton (this.checked);" required value="rgpd" name = "rgpd" id = "rgpd">
			<span class="w3docs"></span>
		</label>
		</fieldset>
		</div>

		<fieldset>
    	<h3><?php echo lang('message_lang.documentacion_necesaria');?></h3>  
		<?php echo lang('message_lang.documentacion_necesaria_autonomos');?>
		<?php echo lang('message_lang.documentacion_necesaria_pymes');?>
		<!--<?php echo lang('message_lang.documentacion_necesaria_cluster');?>-->
		<?php echo lang('message_lang.documentacion_necesaria_si_no_autoriza');?>
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
			<?php
						if (get_cookie('CurrentLanguage')==="ca") {
							include 'includes/clausulaProteccionDatos.html';
						} else {
							include 'includes/clausulaProteccionDatos-es.html';
						}
						?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-------------------------- 1. SELECCIONA EL PROGRAMA --------------------------------------------------------------------->
<div class="tab" id="programa">
	<div id="formbox" class="formbox">
    <fieldset><span class="ocultar" id="aviso"><?php echo lang('message_lang.marque_una_opcion');?></span>
 		<!--<legend>-->
			 <h2><?php echo lang('message_lang.programa');?></h2>
		<!--</legend>-->
	 	<label class="container-radio"><h6><?php echo lang('message_lang.opc_iDigital');?></h6>
			<input title="<?php echo lang('message_lang.opc_iDigital');?>" onChange="javaScript: opcionMarcada(this)" type="radio" required name="opc_programa" id="Programa_I" value="Programa I">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.opc_iExporta');?></h6>
			<input title="<?php echo lang('message_lang.opc_iExporta');?>" onChange="javaScript: opcionMarcada(this)" type="radio" name="opc_programa" id="Programa_II" value="Programa II">
			<span class="checkmark"></span>
		</label>		
		<label class="container-radio"><h6><?php echo lang('message_lang.opc_iLs');?></h6>
			<input title="<?php echo lang('message_lang.opc_iLs');?>" onChange="javaScript: opcionMarcada(this)" type="radio" name="opc_programa" id="Programa_III" value="Programa III">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio">
			<span class="tooltiptext_idi"> <?php echo lang('message_lang.info_programa');?> </span>
		</label>
   </fieldset>  		
	</div>
</div>

<!-------------------------- 2. TIPO DE EMPRESA --------------------------------------------------------------------->
<div class="tab" id="empresa">
  	<div id="formbox2" class="formbox">
    <fieldset><span class="ocultar" id="aviso2"><?php echo lang('message_lang.marque_una_opcion');?></span>
 	<!--<legend>-->
		 <h2><?php echo lang('message_lang.solicitante_tipo');?></h2>
	<!--</legend>-->  
		<label class="container-radio"><h6><?php echo lang('message_lang.solicitante_tipo_autonomo');?></h6>
			<input type="radio" name="tipo_solicitante" title="<?php echo lang('message_lang.solicitante_tipo_autonomo');?>" id="autonomo" onchange = "javaScript: tipoSolicitante (this.id);" value="autonomo">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio"><h6><?php echo lang('message_lang.solicitante_tipo_pequenya');?></h6>
			<input type="radio" name="tipo_solicitante" title="<?php echo lang('message_lang.solicitante_tipo_pequenya');?>" id="pequenya" onchange = "javaScript: tipoSolicitante (this.id);" value="pequenya">
			<span class="checkmark"></span>
		</label>		
		<label class="container-radio"><h6><?php echo lang('message_lang.solicitante_tipo_mediana');?></h6>
			<input type="radio" name="tipo_solicitante" title="<?php echo lang('message_lang.solicitante_tipo_mediana');?>" id="mediana" onchange = "javaScript: tipoSolicitante (this.id);" value="mediana">
			<span class="checkmark"></span>
		</label>
		<label class="container-radio">	
			<span class="tooltiptext_idi"> <?php echo lang('message_lang.info_tipo_empresa');?> </span>
		</label>
   	</fieldset>
	</div>
</div>

<!-------------------------- 3. INTERESADO --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
	<fieldset id="interesado">
		<h2><?php echo lang('message_lang.identificacion_sol_idigital');?></h2>

		<input name = "nif" id = "nif" type = "text" onfocus="javaScript: limpiaInfo_lbl (this.value);" onBlur = "javaScript: validateFormField(this); averiguaTipoDocumento (this.value); consultaExpediente ( 'dni', this.value );" title="NIF" placeholder = "NIF" aria-required="true" minlength = "9" maxlength = "9"><span id = "info_lbl"></span>
		<span id='rest-result'></span>
		<div id ="spinner-idi-isba" class="spinner-border text-warning ocultar" role="status">
 			<span id ="text-isba" class="visually-hidden">Getting data from ISBA...</span>
		</div>
		<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" aria-required="true" name = "denom_interesado" id = "denom_interesado" size="220">
		<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.direccion_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_sol_idigital');?>" aria-required="true" name="domicilio" id="domicilio">
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/municipios.php';?>
		<input type = "text" onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.cp_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.cp_sol_idigital');?>" aria-required="true" name="cpostal" id="cpostal" pattern="[0-9]{5}" minlength = "5" maxlength = "5" size="9">  
        <input type = "tel" onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.movil_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_sol_idigital');?>" aria-required="true" name = "telefono_cont" id="telefono_cont" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" ><p id="mensaje_tel"></p>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/epigrafeIAE.php';?>
	</fieldset> 
	</div>
</div>

<!-------------------------- 4. NOTIFICACIÓN --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
    <fieldset>
	   	<!--<legend>-->
			   <h2><?php echo lang('message_lang.titulo_notificiaciones');?></h2>
		<!--</legend>-->
		<input type = "tel" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" ><p id="mensaje_tel"></p>
		<input type = "email" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" data-error = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" aria-required="true" name = "mail_representante" id="mail_representante" size="220" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">		 
	</fieldset>
	</div>
</div>

<!-------------------------- 5. DATOS DEL CONSULTOR --------------------------------------------------------------------->
<div class="tab">
	<div  id="formbox">
    <fieldset>
      <!--<legend>-->
			  <h2><?php echo lang('message_lang.datos_cons_sol_idigital');?></h2>
			<!--</legend>-->
			<div id = "verDatosConsultor">
				<div><input type = "text"  onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.empresa_consultor');?>" aria-required="false" placeholder = "<?php echo lang('message_lang.empresa_consultor');?>" name = "empresa_consultor" id = "empresa_consultor"></div>
				<div><input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.nombre_consultor');?>" aria-required="true" placeholder = "<?php echo lang('message_lang.nombre_consultor');?>"  name = "nom_consultor" id = "nom_consultor"></div>
				<div><input type = "tel" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.telefono_consultor');?>" aria-required="true" placeholder = "<?php echo lang('message_lang.telefono_consultor');?>" name = "tel_consultor" id = "tel_consultor" maxlength = "9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}"><p id="mensaje_dni"></p></div>
 				<div><input type = "email" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.mail_consultor');?>" aria-required="true" placeholder = "<?php echo lang('message_lang.mail_consultor');?>" name = "mail_consultor" id = "mail_consultor"></div>
			</div>
	</fieldset>
	</div>
</div>
<!-------------------------- 6. DOCUMENTACIÓN ADJUNTA --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
	<h2><?php echo lang('message_lang.documentacion_adjunta');?></h2><!-- 6. DOCUMENTACIÓN ADJUNTA OBLITATORIA -->
		<fieldset>
			<h3><?php echo lang('message_lang.memoria_tecnica');?></h3>
			<div id = "enviarmemoriaTecnica" class = "">
					<code>[.pdf]:</code>
					<input type = "file" id="file_memoriaTecnica" name="file_memoriaTecnica[]" size="50" accept=".pdf" multiple aria-required="true" onblur="javaScript: validateFormField(this);"/>
			</div>
			<label for = "memoriaTecnicaEnIDI" class="main" >
				<label class="alert alert-warning" role="alert"><?php echo lang('message_lang.documentoEnIDI');?> </label>
					<input type="checkbox" class="requerido" onChange="javaScript: deshabilitarSubidaDocumento (this);" required name = "memoriaTecnicaEnIDI" id = "memoriaTecnicaEnIDI">
				<span class="w3docs"></span>
			</label>

			<label for = "veracidad_datos_bancarios" ><h3><?php echo lang('message_lang.declaracion_datos_bancarios');?></h3>
				<input title = "<?php echo lang('message_lang.declaracion_datos_bancarios');?>" disabled checked value = "on" type="checkbox" name="veracidad_datos_bancarios" id="veracidad_datos_bancarios"/>
			</label>
			<label for = "veracidad_datos_bancarios_1" class="main"><h3><?php echo lang('message_lang.declaracion_datos_bancarios_1');?></h3>
				<input title = "<?php echo lang('message_lang.declaracion_datos_bancarios_1');?>" disabled checked type="checkbox" name="veracidad_datos_bancarios_1" id="veracidad_datos_bancarios_1"/>
				<span class = "w3docs"></span>
			</label>
			<input type="text" title="<?php echo lang('message_lang.nom_entidad');?>" placeholder = "<?php echo lang('message_lang.nom_entidad');?>" aria-required="true" name="nom_entidad" id="nom_entidad" onblur="javaScript: validateFormField(this);"/>
			<input type="text" title="<?php echo lang('message_lang.domicilio_sucursal');?>" placeholder = "<?php echo lang('message_lang.domicilio_sucursal');?>" aria-required="true" name="domicilio_sucursal" id="domicilio_sucursal" onblur="javaScript: validateFormField(this);"/>
			<input type="text" title="<?php echo lang('message_lang.codigo_BIC_SWIFT');?>" placeholder = "<?php echo lang('message_lang.codigo_BIC_SWIFT');?>" data-mask = "AAAA-AA-AA-999" maxlength = "14" aria-required="true" name="codigo_BIC_SWIFT" id="codigo_BIC_SWIFT" onblur="javaScript: validateFormField(this);"/>
		
			<label for = "1_opcion_banco" class="container-radio"><h3 id="1_opcion_banco_h5"><?php echo lang('message_lang.declaracion_datos_bancarios_2');?></h3>
				<input type="radio" name="opcion_banco" id="1_opcion_banco" onchange = "javaScript: opcionBanco (this.value);" value="1" />
				<span class = "checkmark"></span>
			</label>
			<label for = "2_opcion_banco" class="container-radio"><h3 id="2_opcion_banco_h5"><?php echo lang('message_lang.declaracion_datos_bancarios_3');?></h3>		
				<input type="radio" name="opcion_banco" id="2_opcion_banco" onchange = "javaScript: opcionBanco (this.value);" value="2" />
				<span class = "checkmark"></span>
			</label>

			<div id = "verBancoOpcion">
			</div>

			<label for = "veracidad_datos_bancarios_2" class="main"><h3><?php echo lang('message_lang.declaracion_datos_bancarios_4');?></h3>
				<input disabled checked type="checkbox" name="veracidad_datos_bancarios_2" id="veracidad_datos_bancarios_2"/>
				<span class = "w3docs"></span>
			</label>	
			<label for = "veracidad_datos_bancarios_3" class="main"><h3><?php echo lang('message_lang.declaracion_datos_bancarios_5');?></h3>
				<input disabled checked type="checkbox" name="veracidad_datos_bancarios_3" id="veracidad_datos_bancarios_3"/>
				<span class = "w3docs"></span>
			</label>
			<script>
				$('#cc').mask('SS ES 9999 9999 99 9999999999');
				$('#cc2').mask('999999999999999999999999');
				$("#codigo_BIC_SWIFT").mask('AAAA-AA-AA-AAA');
			</script>

			<h3>6.3. <strong><?php echo lang('message_lang.certificado_IAE');?></strong></h3>
			<div id = "file_certificadoIAE_container">
				 <code>[.pdf]:</code>
				<input type = "file" id="file_certificadoIAE" name="file_certificadoIAE[]" title="Selecciona el certificat d'IAE" size="50" accept=".pdf" multiple aria-required="true" onblur="javaScript: validateFormField(this);"/>
			</div>
			<fieldset>
				<label for = "certificadoIAEEnIDI" class="main" >
					<label class="alert alert-warning" role="alert"><?php echo lang('message_lang.documentoEnIDI');?> </label>
					<input type="checkbox" class="requerido" onChange="javaScript: deshabilitarSubidaDocumento (this);" required name = "certificadoIAEEnIDI" id = "certificadoIAEEnIDI">
					<span class="w3docs"></span>
				</label>
			</fieldset>

			<h3 id="pFisica" class="ocultar"><?php echo lang('message_lang.eres_persona_fisica');?></h3>
			<h3 id="pJuridica" class="ocultar"><?php echo lang('message_lang.eres_persona_juridica');?></h3>
			<h3 id="pJuridicaNIFEmpresa" class='ocultar'><?php echo lang('message_lang.eres_persona_juridica_nif_empresa');?></h3>
			<div id="docTipoInteresadoNifEmpresa" class="ocultar">
				<code>[.pdf]:</code>	
			</div>
			<fieldset id="copiaNIFSociedadFieldSet" class="ocultar">
				<label for = "copiaNIFSociedadEnIDI" class="main" >
				<label class="alert alert-warning" role="alert"><?php echo lang('message_lang.documentoEnIDI');?> </label>
						<input type="checkbox" class="requerido" onChange="javaScript: deshabilitarSubidaDocumento (this);" required name = "copiaNIFSociedadEnIDI" id = "copiaNIFSociedadEnIDI">
					<span class="w3docs"></span>
				</label>
			</fieldset>
			<h3 id="pJuridicaDocAcreditativa" class='ocultar'><?php echo lang('message_lang.eres_persona_juridica_doc_acreditativa');?></h3>
			<div id="docTipoInteresado">
				<code>[.pdf]:</code>	
			</div>
			<fieldset id="pJuridicaDocAcreditativaFieldSet" class="ocultar">
				<label for = "pJuridicaDocAcreditativaEnIDI" class="main" >
				<label class="alert alert-warning" role="alert"><?php echo lang('message_lang.documentoEnIDI');?> </label>
						<input type="checkbox" class="requerido" onChange="javaScript: deshabilitarSubidaDocumento (this);" required name = "pJuridicaDocAcreditativaEnIDI" id = "pJuridicaDocAcreditativaEnIDI">
					<span class="w3docs"></span>
				</label>
			</fieldset>

			<h3>6.5. <strong><?php echo lang('message_lang.certificado_corriente_pago_aeat');?></strong></h3>
			<div id = "file_certificadoAEAT_container" class="ocultar">
				 <code>[.pdf]:</code>
				<input type = "file" id="file_certificadoAEAT" name="file_certificadoAEAT[]" size="50" accept=".pdf" multiple required aria-required="true" onblur="javaScript: validateFormField(this);"/>
			</div>		

		</fieldset>		
	</div>
	<div id="formbox">	
		<span class="tooltiptext_idi"><h3><?php echo lang('message_lang.upload_multiple');?></h3></span>	
	</div>
</div>

<!-------------------------- 7. AUTORIZACIONES ------------------------------------------------------------------------------------>
<div class="tab">
	<div id="formbox">
	<fieldset>
		<!--<legend>-->
			<h2><?php echo lang('message_lang.autorizaciones_solicitud');?></h2>
		<!--</legend>-->
			
			<!--<label for = "consentimientocopiaNIF" class = "main"><?php echo lang('message_lang.autorizaciones_personas_fisicas');?>
				<input title = "<?php echo lang('message_lang.copia_dni');?>" checked type = "checkbox" name = "consentimientocopiaNIF" id = "consentimientocopiaNIF" onchange = "javaScript: muestraSubeArchivo(this.id);">
				<span class = "w3docs"></span>
			</label>
			<div id = "enviarcopiaNIF" class = "ocultar">
				<label for = "file_copiaNIF"><h5><?php echo lang('message_lang.documento_copiaNIF');?></h5><code>[.pdf]:</code>
			</div>-->

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

			<!--<label for = "consentimiento_certificadoSegSoc" class="main"><?php echo lang('message_lang.doy_mi_consentimiento_seg_soc');?>
				<input title = "<?php echo lang('message_lang.doy_mi_consentimiento');?>" checked type="checkbox" name="consentimiento_certificadoSegSoc" id="consentimiento_certificadoSegSoc" onchange = "javaScript: muestraSubeArchivo(this.id);">
				<span class = "w3docs"></span>
			</label>
			<div id = "enviarcertificadosegSoc" class = "ocultar">
				<label for = "file_certificadoSegSoc"><h5><?php echo lang('message_lang.certificado_document_correspon');?></h5><code>[.pdf]:</code>
			</div>-->				
	</fieldset>
	</div>
	<div id="formbox">	
		<span class="tooltiptext_idi"><h5><?php echo lang('message_lang.upload_multiple');?></h5></span>	
	</div>
</div>

<!-------------------------- 8. DACLARACIÓN RESPONSABLE --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
	<fieldset>   	
	<!--<legend>-->
		<h2><?php echo lang('message_lang.declaracion_responsable');?></h2>
	<!--</legend>-->
		    <label for = "declaracion_responsable_i" class="main"><?php echo lang('message_lang.declaracion_responsable_i');?>
				<input title = "<?php echo lang('message_lang.declaracion_responsable_i');?>" disabled checked type="checkbox" name="declaracion_responsable_i" id="declaracion_responsable_i" />
				<span class = "w3docs"></span>
			</label>
			<label  for = "declaracion_responsable_ii" class="main"><?php echo lang('message_lang.declaracion_responsable_ii');?>
				<input title = "<?php echo lang('message_lang.declaracion_responsable_ii');?>" type="checkbox" name="declaracion_responsable_ii" id="declaracion_responsable_ii" onchange = "javaScript: muestraSubeArchivo(this.id);" />
				<span class = "w3docs"></span>
			</label>
			<div id="contenedor_importe_minimis" class="ocultar">
			</div>
	</fieldset>

	<fieldset>		
		    <label for = "declaracion_responsable_iii" class="main"><?php echo lang('message_lang.declaracion_responsable_iii');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_iii');?>" disabled checked type="checkbox" name="declaracion_responsable_iii" id="declaracion_responsable_iii" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>
		    
			<label for = "declaracion_responsable_iv" class="main"><?php echo lang('message_lang.declaracion_responsable_iv');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_iv');?>" disabled checked type="checkbox" name="declaracion_responsable_iv" id="declaracion_responsable_iv" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>						
			
			<label for = "declaracion_responsable_v" class="main"><?php echo lang('message_lang.declaracion_responsable_v');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_v');?>" disabled checked type="checkbox" name="declaracion_responsable_v" id="declaracion_responsable_v" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>
		    
			<label for = "declaracion_responsable_vi" class="main"><?php echo lang('message_lang.declaracion_responsable_vi');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_vi');?>" disabled checked type="checkbox" name="declaracion_responsable_vi" id="declaracion_responsable_vi" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>	
		    
			<label for = "declaracion_responsable_vii" class="main"><?php echo lang('message_lang.declaracion_responsable_vii');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_vii');?>" disabled checked type="checkbox" name="declaracion_responsable_vii" id="declaracion_responsable_vii" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>
		    
			<label for = "declaracion_responsable_viii" class="main"><?php echo lang('message_lang.declaracion_responsable_viii');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_viii');?>" disabled checked type="checkbox" name="declaracion_responsable_viii" id="declaracion_responsable_viii" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>	
		    
			<label for = "declaracion_responsable_ix" class="main"><?php echo lang('message_lang.declaracion_responsable_ix');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_ix');?>" disabled checked type="checkbox" name="declaracion_responsable_ix" id="declaracion_responsable_ix" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>

		    <label for = "declaracion_responsable_x" class="main"><?php echo lang('message_lang.declaracion_responsable_x');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_x');?>" disabled checked type="checkbox" name="declaracion_responsable_x" id="declaracion_responsable_x" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
			</label>

		    <label for = "declaracion_responsable_xi" class="main"><?php echo lang('message_lang.declaracion_responsable_xi');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_xi');?>" disabled checked type="checkbox" name="declaracion_responsable_xi" id="declaracion_responsable_xi">
			<span class = "w3docs"></span>
			</label>

		    <label for = "declaracion_responsable_xii" id="declaracion_responsable_xii_lbl" class="main"><?php echo lang('message_lang.declaracion_responsable_xii');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_xii');?>" disabled checked type="checkbox" name="declaracion_responsable_xii" id="declaracion_responsable_xii">
			<span class = "w3docs"></span>
			</label>
		    
			<!--<label for = "declaracion_responsable_xiii" id="declaracion_responsable_xiii_lbl" class="main"><?php echo lang('message_lang.declaracion_responsable_xiii');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_xiii');?>" disabled checked type="checkbox" name="declaracion_responsable_xiii" id="declaracion_responsable_xiii">
			<span class = "w3docs"></span>
			</label>
		    <label for = "declaracion_responsable_xiv" id="declaracion_responsable_xiv_lbl" class="main"><?php echo lang('message_lang.declaracion_responsable_xiv');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_xiv');?>" disabled checked type="checkbox" name="declaracion_responsable_xiv" id="declaracion_responsable_xiv">
			<span class = "w3docs"></span>
			</label>
		    <label for = "declaracion_responsable_xv" id="declaracion_responsable_xv_lbl" class="main"><?php echo lang('message_lang.declaracion_responsable_xv');?>
			<input title = "<?php echo lang('message_lang.declaracion_responsable_xv');?>" disabled checked type="checkbox" name="declaracion_responsable_xv" id="declaracion_responsable_xv">
			<span class = "w3docs"></span>
					</label>-->								
	</fieldset>
<!--</div>-->

<!-------------------------- ENVIAR LA SOLICITUD --------------------------------------------------------------------->
	<!--<div id = "enviardeocumentacion">	
		<button style="width:100%" name="enviar_iDigital" id="enviar_iDigital" onClick="onFormSubmit(this);" type="submit" class="btn btn-success" form="idigital_form" value="Submit">Enviar</button> 	
	</div>-->
</div>
</form>

<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  let itramitsCookies = document.cookie.split(";");
    
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
	if (n === 8) {	 
	  	submitBTN.innerHTML = "Enviar";
	  	submitBTN.setAttribute("title", "Enviar")
	  	submitBTN.setAttribute("value", "Submit")
	  	submitBTN.setAttribute("form", "xecs_form")
	  	submitBTN.setAttribute("onclick", "onFormSubmit(this)")
  	} else {
		// console.log(cookie.value)
		let currentLanguage = getCookie('itramitsCurrentLanguage')
		if (currentLanguage=="ca") {
			submitBTN.innerHTML = "Següent"
		} else {
		  	submitBTN.innerHTML = "Siguiente"
		}
		submitBTN.setAttribute("onclick", "nextPrev(1)")
  	}
  //... and run a function that will display the correct step indicator:
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
		if (cell.id != "empresa_consultor") {
			if ( (!cell.value ) && ( cell.getAttribute('aria-required')) ) {
	   			cell.setAttribute ('class','aviso');
      			valid = false;
    		}
		}

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
  	// Validar que un checkbox de '1. SELECCIONA EL PROGRAMA' esté activado
  	if ( !document.getElementById("Programa_I").checked && !document.getElementById("Programa_II").checked && !document.getElementById("Programa_III").checked) {
		document.getElementById("aviso").className = 'aviso-lbl';
		document.getElementById("formbox").className = 'aviso';
		valid = false;
  	}
  }
  if (currentTab===2) {
	// Validar que un checkbox de '2. TIPO DE EMPRESA' esté activado
  	if ( !document.getElementById("autonomo").checked && !document.getElementById("pequenya").checked && !document.getElementById("mediana").checked /* && !document.getElementById("cluster_ct").checked */) {
		document.getElementById("aviso2").className = 'aviso-lbl';
		document.getElementById("formbox2").classList.add("aviso");
		valid = false;
  	}
  }
  if (currentTab===5) {
	  	// Validar que '5. DATOS DEL CONSULTOR tiene los tres últimos campos con valor

		if ( document.getElementById("nom_consultor").value==='' || document.getElementById("tel_consultor").value==='' || document.getElementById("mail_consultor").value==='' ) {
			document.getElementById("empresa_consultor").className = 'valid';	
			document.getElementById("nom_consultor").className = 'aviso';
			document.getElementById("tel_consultor").className = 'aviso';
			document.getElementById("mail_consultor").className = 'aviso';
			valid = false;
  		}
  }

  if (currentTab===6) {
	if ( !document.getElementById("1_opcion_banco").checked && !document.getElementById("2_opcion_banco").checked) {
		document.getElementById("1_opcion_banco_h5").setAttribute("class", "container-radio-invalid");
		document.getElementById("2_opcion_banco_h5").setAttribute("class", "container-radio-invalid");
		valid = false;
	}
	else {
		document.getElementById("1_opcion_banco_h5").setAttribute("class", "container-radio-valid");
		document.getElementById("2_opcion_banco_h5").setAttribute("class", "container-radio-valid");		
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
  	for (i = 7; i >= n; i--) {
    	x[i].className = x[i].className.replace(" finish", "");
 	 }	  
  	for (i = 0; i < x.length; i++) {
    	x[i].className = x[i].className.replace(" active", "");
 	 }
  	//... and adds the "active" class on the current step:
	// Para evitar el error Uncaught TypeError: x[n] is undefined que me aparece cuando n==8
	if (n < 8) {
  		x[n].className += " active";
	}
}
</script>
</section>