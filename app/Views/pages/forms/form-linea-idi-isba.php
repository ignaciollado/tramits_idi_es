<section id="formulario_solicitud">
  <?php
  	helper('cookie');
  	$language = \Config\Services::language();
  	$locale = $language->getLocale();
  ?>

<div class="modal fade" id="rgpdModal" tabindex="-1" aria-labelledby="rgpdModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="rgpdModalLabel">Reglamento (UE) 2016/679 General de Protección de Datos (RGPD)</h1>
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

<!-- Dialog con el listado de beneficiarios que ya constan en otros expedientes -->
<dialog id="theDialog">
	<h3>Aquests son els expedients que coincideixen amb el <br>número de document identificador que ens ha facilitat:</h3>
	<br>
	<div id='resultContainer'>Those are the founded files</div>
	<br>
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="javaScript: document.querySelector('#theDialog').open = false">Close</button>
</dialog>

<form name="adhesion_idi_isba" id="adhesion_idi_isba" class="needs-validation" action="<?php echo base_url('/public/index.php/subirarchivo/store_idi_isba/'.$viaSolicitud.'/'.$locale);?>" method="POST" accept-charset="utf-8" enctype="multipart/form-data">

<div class="stepContainer">
	<span class="step">1</span>
	<span class="step">2</span>
  <span class="step">3</span>
  <span class="step">4</span>
  <span class="step">5</span>
	<span class="step">6</span>
	<span class="step">7</span>

	<div class="buttonContainer">
    <button title="<?php echo lang('message_lang.btn_previous');?>" onClick="nextPrev(-1)" type="button" class="buttonAsistente" id="prevBtn"><?php echo lang('message_lang.btn_previous');?></button>
    <button title="<?php echo lang('message_lang.btn_next');?>"  onClick="nextPrev(1)" disabled class="ocultar" type="button"  id="nextBtn"><?php echo lang('message_lang.btn_next');?></button>
	</div>
</div>

<!-------------------------- 0. INFO DOCUMENTACIÓN NECESARIA y ACEPTA EL RGPD --------------------------------------------->
<div class="tab">
	<div>
		<fieldset>
  			<label for = "rgpd" class="main">
					<span><?php echo lang('message_lang.rgpd_leido');?><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rgpdModal"><abbr title='Reglamento general de protección de datos'>RGPD.</abbr></button></span>
					<input type="checkbox" class="requerido" onChange="javaScript: habilitarNextButton (this.checked);" required value="rgpd" name = "rgpd" id = "rgpd">
					<span class="w3docs"></span>
				</label>
		</fieldset>
	</div>
	<fieldset>
	<?php echo lang('message_lang.documentacion_necesaria_pymes_idi_isba');?>
	<h3><?php echo lang('message_lang.documentacion_resultante_cabecera_idi_isba');?></h3>
	<?php echo lang('message_lang.documentacion_resultante_idi_isba');?>
</fieldset>
</div>
<!-------------------------- 1. TIPO DE SOLICITANTE ----------------------------------------------------------------------->
<div class="tab" id="empresa">
	<div id="formbox2" class="formbox">
  	<fieldset><span class="ocultar" id="aviso2"><?php echo lang('message_lang.marque_una_opcion');?></span>
			<h2>1. <?php echo lang('message_lang.solicitante_tipo');?></h2>
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
<!-------------------------- 2. IDENTIFICACIÓN DEL SOLICITANTE ------------------------------------------------------------>
<div class="tab">
	<div id="formbox">
		<fieldset id="interesado">
			<h2>2. <?php echo lang('message_lang.identificacion_sol_idi_isba');?></h2>

			<div aria-live="polite" aria-atomic="true" class="position-relative">
				<div class="toast-container top-0 end-0 p-3">
					<div id="liveToast" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
	  					<div class="toast-body">
								<strong class="me-auto"><?php echo lang('message_lang.sol_linea_idi_isba_menu');?></strong>
								<div id="toastMessage" class="toast-body">
	      					This is a toast message.
    					</div>
    					<div class="mt-2 pt-2 border-top">
	    					<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Tanca</button>
  				  	</div>
  						</div>
					</div>
				</div>
			</div>

			<input type="text" onblur="javaScript: validateFormField(this);" required aria-required="true" name = "denom_interesado" id = "denom_interesado" title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" size="220">
			
			<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
				<div class="input-group">
					<input type = "text" name = "nif" id = "nif" aria-label="Input group nif" aria-describedby="btnGroupAddon" 
					onfocus="javaScript: limpiaInfo_lbl (this.value);" required onBlur = "javaScript: averiguaTipoDocumento (this.value);" 
					title="<?php echo lang('message_lang.nif_solicitante');?>" placeholder = "<?php echo lang('message_lang.nif_solicitante');?>" minlength = "9" maxlength = "9" 
					aria-required="true"><span id = "info_lbl"></span>
				</div>
				<span id='rest-result'></span>
				<div id ="spinner-idi-isba" class="spinner-border text-warning ocultar" role="status">
 					<span id ="text-isba" class="visually-hidden">Getting data from ISBA...</span>
				</div>
			</div>	
			
			<input type = "text" onblur="javaScript: validateFormField(this);" required aria-required="true" name="domicilio" id="domicilio" title = "<?php echo lang('message_lang.direccion_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_sol_idigital');?>">
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/municipios.php';?>
			<input type = "text" onblur="javaScript: validateFormField(this);" required aria-required="true" title="<?php echo lang('message_lang.cp_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.cp_sol_idigital');?>" name="cpostal" id="cpostal" pattern="[0-9]{5}" minlength = "5" maxlength = "5" size="9">  
    	<input type = "tel"  onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.movil_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_sol_idigital');?>" name = "telefono_cont" id="telefono_cont" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" aria-required="true"><p id="mensaje_tel"></p>
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/epigrafeIAE_idi_isba.php';?>
			<input type="text" required aria-required="true" name = "nom_representante" id = "nom_representante" title="<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" onblur="javaScript: validateFormField(this);">
			<input type="text" required aria-required="true" name = "nif_representante" id = "nif_representante" title="<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">
			<input type="text" required aria-required="true" name = "telefono_contacto_rep" id = "telefono_contacto_rep" title="<?php echo lang('message_lang.movil_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_rep_legal_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">
		</fieldset> 
	</div>
</div>	
<!-------------------------- 3. CANAL NOTIFICACIÓN y AUTORIZACIONES ------------------------------------------------------->
<div class="tab">	
	<div id="formbox">
    	<fieldset>
			<h2>3. <?php echo lang('message_lang.titulo_notificiaciones');?></h2>
			<input type = "email" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" data-error = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" aria-required="true" name = "mail_representante" id="mail_representante" size="220">
			<input type = "tel" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength = "9" size="9" ><p id="mensaje_tel"></p>
		</fieldset>
	</div>
</div>
<!-------------------------- 4. OPERACIÓN FINANCIERA ---------------------------------------------------------------------->
<div class="tab">	
	<div id="formbox">
    <fieldset>
			<h2>4. <?php echo lang('message_lang.operacion_financiera_idi_isba');?></h2>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.entidad_financiera_idi_isba');?>" placeholder = "<?php echo lang('message_lang.entidad_financiera_idi_isba');?>" data-error = "<?php echo lang('message_lang.entidad_financiera_idi_isba');?>" aria-required="true" name = "nom_entidad" id="nom_entidad" size="220" required>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba');?>" placeholder = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba');?>" data-error = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba');?>" data-type="currency" aria-required="true" name = "importe_prestamo" id="importe_prestamo" required>
			<input type = "number" min="0" max="7" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba');?>" placeholder = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba');?>" data-error = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba');?>" aria-required="true" name = "plazo_prestamo" id="plazo_prestamo" required>
			<!-- 			<input type = "number" min="0" max="7" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.carencia_prestamo_entidad_idi_isba');?>" placeholder = "<?php echo lang('message_lang.carencia_prestamo_entidad_idi_isba');?>" data-error = "<?php echo lang('message_lang.carencia_prestamo_entidad_idi_isba');?>" name = "carencia_prestamo" id="carencia_prestamo" required> -->
			<label class="form-label" for="fecha_aval_isba"><?php echo lang('message_lang.fecha_del_aval_idi_isba');?></label>
			<input type = "date" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.fecha_del_aval_idi_isba');?>" placeholder = "<?php echo lang('message_lang.fecha_del_aval_idi_isba');?>" aria-required="true" name = "fecha_aval_isba" id="fecha_aval_isba" required>
			<input type = "number" min="0" max="7" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.plazo_prestamo_idi_isba');?>" placeholder = "<?php echo lang('message_lang.plazo_prestamo_idi_isba');?>" data-error = "<?php echo lang('message_lang.plazo_prestamo_idi_isba');?>" aria-required="true" name = "plazo_aval_isba" id="plazo_aval_isba" required>
			<input type = "text" min="0" max="7" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba');?>" placeholder = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba');?>" data-error = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba');?>" data-type="currency" aria-required="true" name = "cuantia_aval_isba" id="cuantia_aval_isba" required>
			<!-- <input type = "number" min="0" max="60" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.carencia_idi_isba');?>" placeholder = "<?php echo lang('message_lang.carencia_idi_isba');?>" data-error = "<?php echo lang('message_lang.carencia_idi_isba');?>" name = "carencia_idi_isba" id="carencia_idi_isba" required> -->
		</fieldset>
	</div>
</div>
<!-------------------------- 5. PROYECTO DE INVERSIÓN --------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
    <fieldset>
			<h2>5. <?php echo lang('message_lang.proyecto_de_inversion_idi_isba');?></h2>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.proyecto_de_inversion_idi_isba_finalidad');?>" placeholder = "<?php echo lang('message_lang.proyecto_de_inversion_idi_isba_finalidad');?>" required aria-required="true" name = "finalidad_inversion_idi_isba" id="finalidad_inversion_idi_isba" maxlength = "220" size="220" required>
		</fieldset>
		<!-------------------------- 6. SOLICITA AYUDA  -------------------------------------------------------------------------------------------->
		<fieldset>
			<h2>6. <?php echo lang('message_lang.adherido_a_ils_si_no');?></h2>
			<div class="form-check form-check-inline">
				<label class="container-radio" for="empresa_eco_idi_isba_no"><?php echo lang('message_lang.no_adherido_a_ils');?>
					<input type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_no" onchange="javaScript: selectorNoSi(this);" value="NO" required>
  				<span class="checkmark"></span>
				</label>
			</div>
			<div class="form-check form-check-inline">
				<label class="container-radio" for="empresa_eco_idi_isba_si"><?php echo lang('message_lang.adherido_a_ils');?>
  				<input type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_si" onchange="javaScript: selectorNoSi(this);" value="SI">
  				<span class="checkmark"></span>
				</label>
			</div>
			<div class="alert alert-primary ocultar" role="alert" id="empresa_eco"></div>
		</fieldset>
		<fieldset>
			<h2><?php echo lang('message_lang.presupuesto_proyecto_de_inversion_idi_isba');?></h2>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.importe_del_presupuesto_idi_isba');?>" placeholder = "<?php echo lang('message_lang.importe_del_presupuesto_idi_isba');?>" required aria-required="true" name = "importe_presupuesto_idi_isba" id="importe_presupuesto_idi_isba" maxlength = "9" size="9" required>
		</fieldset>
    <fieldset>
			<h2><?php echo lang('message_lang.solicita_ayuda_idi_isba');?></h2>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.solicita_ayuda_importe_idi_isba');?>" placeholder = "<?php echo lang('message_lang.solicita_ayuda_importe_idi_isba');?>" required aria-required="true" name = "importe_ayuda_solicita_idi_isba" id="importe_ayuda_solicita_idi_isba" maxlength = "9" size="9" required>
			<h3 for=''><?php echo lang('message_lang.detalle_importe_ayuda_solicitado_idi_isba');?></h3>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba');?>" placeholder = "<?php echo lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba');?>" aria-required="true" name = "intereses_ayuda_solicita_idi_isba" id="intereses_ayuda_solicita_idi_isba" maxlength = "9" size="9" required>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba');?>" placeholder = "<?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba');?>" aria-required="true" name = "coste_aval_solicita_idi_isba" id="coste_aval_solicita_idi_isba" maxlength = "9" size="9" required>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba');?>" placeholder = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba');?>" aria-required="true" name = "gastos_aval_solicita_idi_isba" id="gastos_aval_solicita_idi_isba" maxlength = "9" size="9" required>
		</fieldset>
	</div>
</div>
<!-------------------------- 6. DECLARO ----------------------------------------------------------------------------------->
<div class="tab">	
	<div id="formbox">
		<fieldset>
		<h2>7. <?php echo lang('message_lang.declaro');?></h2>
		<ol>
			<li>
				<div class="form-check">
					<label class="container-radio" for="declaro_idi_isba_que_cumple_1">
						<?php echo lang('message_lang.declaro_idi_isba_que_cumple_1');?>
  					<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_1');?>" checked="checked" name="declaro_idi_isba_que_cumple_1[]" id="declaro_idi_isba_que_cumple_1" value="SI">
						<span class="w3docs"><i class="bi bi-check-lg"></i></span>
					</label>
				</div>
			</li>
			<li>
				<div class="form-check">
					<label class="container-radio" for="declaro_idi_isba_que_cumple_2">
						<?php echo lang('message_lang.declaro_idi_isba_que_cumple_2');?>
  					<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_2');?>" checked="checked" name="declaro_idi_isba_que_cumple_2[]" id="declaro_idi_isba_que_cumple_2">
						<span class="w3docs"><i class="bi bi-check-lg"></i></span>
					</label>
					</div>
			</li>
			<li>
				<div class="form-check">
  					<label class="container-radio" for="declaro_idi_isba_que_cumple_3">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_3');?>
							<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_3');?>" checked="checked" name="declaro_idi_isba_que_cumple_3[]" id="declaro_idi_isba_que_cumple_3"  onchange = "javaScript: muestraSubeArchivo(this.id);">							
							<span class="w3docs"><i class="bi bi-check-lg"></i></span>
						</label>
				</div>					
			</li>
			<li>
				<div class="form-check">
  					<label class="container-radio" for="declaro_idi_isba_que_cumple_4">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_4');?>
							<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_4');?>" checked="checked" name="declaro_idi_isba_que_cumple_4" id="declaro_idi_isba_que_cumple_4" onchange = "javaScript: muestraSubeArchivo(this.id);">							
							<span class="w3docs"><i class="bi bi-check-lg"></i></span>
						</label>
				</div>
				<div id = "contenedorAyudasRecibidas" class="">
						<label for = "ayudasSubvenSICuales_dec_resp"><h5><?php echo lang('message_lang.declaro_idi_isba_ayudas_recibidas');?></h5></label>
						<input type="text" title = "<?php echo lang('message_lang.declaro_idi_isba_ayudas_recibidas');?>" name="ayudasSubvenSICuales_dec_resp" id="ayudasSubvenSICuales_dec_resp">
				</div>	
			</li>
			<li>
				<div class="form-check">
  					<label class="container-radio" for="declaro_idi_isba_que_cumple_5">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_5');?>
							<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_5');?>" checked="checked" name="declaro_idi_isba_que_cumple_5" id="declaro_idi_isba_que_cumple_5">							
							<span class="w3docs"><i class="bi bi-check-lg"></i></span>
						</label>
				</div>		
			</li>
			<li>
				<div class="form-check">
  					<label class="container-radio" for="declaro_idi_isba_que_cumple_6">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_6');?>
							<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_6');?>" checked="checked" name="declaro_idi_isba_que_cumple_6[]" id="declaro_idi_isba_que_cumple_6">							
							<span class="w3docs"><i class="bi bi-check-lg"></i></span>
						</label>
				</div>		
			</li>
			<li>
				<div class="form-check">
  					<label class="container-radio" for="declaro_idi_isba_que_cumple_7">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_7');?>
							<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_7');?>" checked="checked" name="declaro_idi_isba_que_cumple_7[]" id="declaro_idi_isba_que_cumple_7">							
							<span class="w3docs"><i class="bi bi-check-lg"></i></span>
						</label>
				</div>		
			</li>
			<li>
				<div class="form-check">
  					<label class="container-radio" for="declaro_idi_isba_que_cumple_8">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_8');?>
							<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_8');?>" checked="checked" name="declaro_idi_isba_que_cumple_8[]" id="declaro_idi_isba_que_cumple_8">							
							<span class="w3docs"><i class="bi bi-check-lg"></i></span>
						</label>
				</div>		
			</li>
		</ol>
		</fieldset>
	</div>
</div>
<!-------------------------- 7. DOCUMENTACIÓN ----------------------------------------------------------------------------->
<div class="tab">
	<div id="formbox">
		<fieldset>
			<h2>8. <?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba');?></h2>
			<ol style="list-style-type: lower-alpha;">
			<li>
				<div class="form-check">
					<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_a');?></strong>						
  					<input class="requerido" disabled type="checkbox" title = "<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_a');?>" checked="checked" name="documentacion_adjunta_requerida_idi_isba_a[]" id="documentacion_adjunta_requerida_idi_isba_a" value="SI">
  					<span class="w3docs"><i class="bi bi-check-lg"></i></span>
  				</h3>
				</div>
			</li>

			<li>
				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_b');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type="file" id="documentacion_adjunta_requerida_idi_isba_b" name="documentacion_adjunta_requerida_idi_isba_b[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_b');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div> 
			</li>

			<li>
				<div class="form-check">
					<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_c');?></strong>
  					<input class="requerido" disabled type="checkbox" title = "<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_c');?>" checked="checked" name="documentacion_adjunta_requerida_idi_isba_c[]" id="documentacion_adjunta_requerida_idi_isba_c" value="SI">
  					<span class="w3docs"><i class="bi bi-check-lg"></i></span>
  				</h3>
				</div>
			</li>
		
			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_d');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				 <div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type = "file" id="documentacion_adjunta_requerida_idi_isba_d" name="documentacion_adjunta_requerida_idi_isba_d[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_d');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>

			<div id="es-p-fisica">
				<li>
	 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_e');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
					<div>
						<input type = "file" id="documentacion_adjunta_requerida_idi_isba_e" name="documentacion_adjunta_requerida_idi_isba_e[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_e');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
					</div>	
				</li>	
			</div>

			<div id="es-p-juridica">
				<li >
	 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_f');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
					<div>
						<input type = "file" id="documentacion_adjunta_requerida_idi_isba_f" name="documentacion_adjunta_requerida_idi_isba_f[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_f');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
					</div>	
				</li>	
			</div>
			
			<li>
				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_g');?></strong></h3>
				<div id = "enviaridi_isba_g" class = "">
					<code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_g" name="documentacion_adjunta_requerida_idi_isba_g[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_g');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_h');?></strong></h3>
				<div id = "enviaridi_isba_h" class = "">
					<code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_h" name="documentacion_adjunta_requerida_idi_isba_h[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_h');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_i');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type = "file" id="documentacion_adjunta_requerida_idi_isba_i" name="documentacion_adjunta_requerida_idi_isba_i[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_i');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_j');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type = "file" id="documentacion_adjunta_requerida_idi_isba_j" name="documentacion_adjunta_requerida_idi_isba_j[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_j');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_k');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type = "file" id="documentacion_adjunta_requerida_idi_isba_k" name="documentacion_adjunta_requerida_idi_isba_k[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_k');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>	

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_l');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type = "file" id="documentacion_adjunta_requerida_idi_isba_l" name="documentacion_adjunta_requerida_idi_isba_l[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_l');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>	

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_m');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input onblur="javaScript: validateFormField(this);" required aria-required="true" type = "file" id="documentacion_adjunta_requerida_idi_isba_m" name="documentacion_adjunta_requerida_idi_isba_m[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_m');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
				</div>	
			</li>
			
			<li>
			<div class="form-check">
  				<input class="requerido" type="checkbox" title = "<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_n');?>" checked="checked" name="documentacion_adjunta_requerida_idi_isba_n[]" id="documentacion_adjunta_requerida_idi_isba_n" value="SI">
  					<label class="form-check-label" for="documentacion_adjunta_requerida_idi_isba_n">
							<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_n');?>
  					</label>
				</div>
			</li>			
			</ol>
		</fieldset>
	
	</div>	
	<div id="formbox">	
		<span class="tooltiptext_idi"><h3><?php echo lang('message_lang.upload_multiple');?></h3></span>	
	</div>
</div>
</form>
</section>

<!-- The Modal -->
<div id="myModal" class="modal">
	<div class="modal-header">
    	<h2><?php echo lang('message_lang.cabecera_modal_form_adhesion_idi_isba');?></h2>
  	</div>
  	<!-- Modal content -->
  	<div class="modal-content">
    	<ol id="info-disponible"></ol>
  	</div>
  	<div class="modal-footer">
	  	<h2><?php echo lang('message_lang.si_no_aprovechar_info_asoc_a_NIF_idi_isba');?></h2>
  	</div>
  	<div class="modal-footer">
  		<button onclick="javaScript: cierraModal()" class="btn btn-secondary btn-lg btn-block">No</button><button onclick="javaScript: actualizoFormConDatosSolicitante()" class="btn btn-success btn-lg btn-block">Si</button>
  	</div>
</div>


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
	if (n === 7) {
		console.log ("pestaña final IDI-ISBA: "+ n)
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
    //document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateFormField(field, step=0) {
	var valid = true;
	let inputElement = document.getElementById(field.id)

	const regexMail = new RegExp(/^((?!\.)[\w-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/)
	const regexHTTP = new RegExp(/https?:\/\/?[-a-zA-Z0-9]{1,256}\.[a-zA-Z]{2,3}/)
	const regexTel  = new RegExp(/[0-9]{3}[0-9]{3}[0-9]{3}/)
	
	console.log (`Campo actual es : ${inputElement.name} y su valor: ${inputElement.value}`)
	if (!inputElement.value) {
		inputElement.classList.remove("valid");
		inputElement.classList.add("invalid");
	} else {
		inputElement.classList.remove("invalid");
		inputElement.classList.add("valid");
	}

	let btnSend = document.querySelector(field.id);
	if (Boolean(field.getAttribute('aria-required') === (!field.value))) {
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
  	for (let cell of inputs) {
			if ( (cell.value === '') && (cell.getAttribute('aria-required')) ) {
	   		cell.setAttribute ('class','aviso');
      	valid = false;
				console.log (cell.name)
				if (document.getElementById("autonomo").checked && ((cell.name === "nom_representante") || cell.name === "nif_representante" || cell.name === "telefono_contacto_rep")) {
					cell.removeAttribute ('class','aviso');
					valid = true
				}
    	}
  	}
 
  	selects = tabs[currentTab].getElementsByTagName("select");
  	for (let cell of selects) {
    	if (cell.value === '') {
	  		cell.setAttribute ('class','aviso');
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

	console.log ("**"+valid+"**")
  return valid; // return the valid status

}

function fixStepIndicator(n) {
  	// This function removes the "active" class of all steps...
  	var i, x = document.getElementsByClassName("step");
  	for (i = 6; i >= n; i--) {
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
	/* document.getElementById('aviso').innerHTML = '' */
}
</script>