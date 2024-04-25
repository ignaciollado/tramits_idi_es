<section id="formulario_solicitud">
  <?php
  	helper('cookie');
  	$language = \Config\Services::language();
  	$locale = $language->getLocale();
  ?>
<fieldset>
	<?php echo lang('message_lang.documentacion_necesaria_pymes_idi_isba');?>
	<h3><?php echo lang('message_lang.documentacion_resultante_cabecera_idi_isba');?></h3>
	<?php echo lang('message_lang.documentacion_resultante_idi_isba');?>
</fieldset>

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

<div id="formbox">
	<fieldset>
		<div class="form-check"> 
  			<input class="form-check-input" type="checkbox"  onChange="javaScript: activaDesactivaFormulario (this.checked);" required value="rgpd" name = "rgpd" id = "rgpd">
  			<label class="form-check-label" for="flexCheckDefault">
				<?php echo lang('message_lang.rgpd_leido');?><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rgpdModal"><abbr title='Reglamento general de protección de datos'>RGPD.</abbr></button>
  			</label>
		</div>
		<span id='aviso'></span>
	</fieldset>
</div>	

<form name="adhesion_idi_isba" id="adhesion_idi_isba" class="needs-validation" action="<?php echo base_url('/public/index.php/subirarchivo/store_idi_isba/'.$viaSolicitud.'/'.$locale);?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<!-------------------------- 1. TIPO DE SOLICITANTE --------------------------------------------------------------------->


<div id="formbox">
  <fieldset>
		<span class="ocultar" id="aviso2"><?php echo lang('message_lang.marque_una_opcion');?></span>
		<h2>1. <?php echo lang('message_lang.solicitante_tipo');?></h2>
		<div class="form-check form-check-inline">
  		<input class="form-check-input" type="radio" name="tipo_solicitante" id="autonomo" value="autonomo" onchange = "javaScript: tipoSolicitante (this.id);" required>
  		<label class="form-check-label" for="autonomo"><?php echo lang('message_lang.solicitante_tipo_autonomo');?></label>
		</div>
		<div class="form-check form-check-inline">
  		<input class="form-check-input" type="radio" name="tipo_solicitante" id="pequenya" value="pequenya" onchange = "javaScript: tipoSolicitante (this.id);">
  		<label class="form-check-label" for="pequenya"><?php echo lang('message_lang.solicitante_tipo_pequenya');?></label>
		</div>
		<div class="form-check form-check-inline">
  		<input class="form-check-input" type="radio" name="tipo_solicitante" id="mediana" value="mediana" onchange = "javaScript: tipoSolicitante (this.id);">
  		<label class="form-check-label" for="mediana"><?php echo lang('message_lang.solicitante_tipo_mediana');?></label>
		</div>	
  </fieldset>
</div>
<!-------------------------- 2. IDENTIFICACIÓN DEL SOLICITANTE ------------------------------------------------------------>
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

			<input type = "text" name = "denom_interesado" id = "denom_interesado" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" size="220" aria-required="true">
			
			<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
				<div class="input-group">
					<input type = "text" name = "nif" id = "nif" aria-label="Input group nif" aria-describedby="btnGroupAddon" 
					onfocus="javaScript: limpiaInfo_lbl (this.value);" required onBlur = "javaScript: averiguaTipoDocumento (this.value);" 
					title="<?php echo lang('message_lang.nif_solicitante');?>" placeholder = "<?php echo lang('message_lang.nif_solicitante');?>" minlength = "9" maxlength = "9" 
					aria-required="true">
				</div>
				<span id='rest-result'></span>
				<div id ="spinner-idi-isba" class="spinner-border text-warning ocultar" role="status">
 						<span id ="text-isba" class="visually-hidden">Getting data from ISBA...</span>
				</div>
			</div>	
			
			<input type = "text" required title = "<?php echo lang('message_lang.direccion_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_sol_idigital');?>" name="domicilio" id="domicilio" aria-required="true">
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/municipios.php';?>
			<input type = "text" onblur="javaScript: validateFormField(this);" required title="<?php echo lang('message_lang.cp_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.cp_sol_idigital');?>" name="cpostal" id="cpostal" pattern="[0-9]{5}" minlength = "5" maxlength = "5" size="9" aria-required="true">  
    	<input type = "tel"  onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.movil_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_sol_idigital');?>" name = "telefono_cont" id="telefono_cont" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" aria-required="true"><p id="mensaje_tel"></p>
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/epigrafeIAE_idi_isba.php';?>
			<input type="text" aria-required="true" name = "nom_representante" id = "nom_representante" title="<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "nif_representante" id = "nif_representante" title="<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "domicilio_rep" id = "domicilio_rep" title="<?php echo lang('message_lang.direccion_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_rep_legal_sol_idigital');?>" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "telefono_contacto_rep" id = "telefono_contacto_rep" title="<?php echo lang('message_lang.movil_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_rep_legal_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "cp_rep" id = "cp_rep" title="<?php echo lang('message_lang.cp_sol_rep_legal_idigital');?>" placeholder = "<?php echo lang('message_lang.cp_sol_rep_legal_idigital');?>" minlength = "5" maxlength = "5" onblur="javaScript: validateFormField(this);">
		</fieldset> 
	</div>
<!-------------------------- xx. FORMA DE ACREDITACIÓN DE LA REPRESENTACIÓN--------------------------------------------------------->
<div id="formbox">
    	<fieldset>
			<h2>xx. <?php echo lang('message_lang.acreditacion_de_la_representacion');?></h2>
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="forma_acred_represent" id="forma_acred_represent1" value="reaNum" onchange="javaScript: getReaNum(this);">
  				<label class="form-check-label" for="forma_acred_represent1">REA núm.</label>
			</div>
			<div class="form_check">
				<input type="hidden" placeholder="REA num" id="reaNum">
			</div>
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="forma_acred_represent" id="forma_acred_represent2" value="Otros" onchange="javaScript: getReaNum(this);">
  				<label class="form-check-label" for="forma_acred_represent2">Otros</label>
			</div>
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="forma_acred_represent" id="forma_acred_represent3" value="expedISBA" onchange="javaScript: getReaNum(this);">
  				<label class="form-check-label" for="forma_acred_represent3">Ya consta en el expediente de ISBA-SGR</label>
			</div>
			<div class="form_check">
				<input type="hidden" placeholder="Num. exped ISBA-SGR" id="expedISBA">
			</div>
		</fieldset>
	</div>
<!-------------------------- 3. NOTIFICACIÓN y AUTORIZACIONES --------------------------------------------------------------------->
	<div id="formbox">
    	<fieldset>
			<h2>3. <?php echo lang('message_lang.titulo_notificiaciones');?></h2>
			<input type = "email" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" data-error = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" aria-required="true" name = "mail_representante" id="mail_representante" size="220">
			<input type = "tel" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength = "9" size="9" ><p id="mensaje_tel"></p>
		</fieldset>
	</div>
<!-------------------------- 4. OPERACIÓN FINANCIERA --------------------------------------------------------------------->
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
<!-------------------------- 5. PROYECTO DE INVERSIÓN ---------------------------------------------------------------------------------->
	<div id="formbox">
    <fieldset>
			<h2>5. <?php echo lang('message_lang.proyecto_de_inversion_idi_isba');?></h2>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.proyecto_de_inversion_idi_isba_finalidad');?>" placeholder = "<?php echo lang('message_lang.proyecto_de_inversion_idi_isba_finalidad');?>" required aria-required="true" name = "finalidad_inversion_idi_isba" id="finalidad_inversion_idi_isba" maxlength = "220" size="220" required>
		</fieldset>
		<!-------------------------- 6. SOLICITA AYUDA  -------------------------------------------------------------------------------------------->
		<fieldset>
			<h2>6. <?php echo lang('message_lang.adherido_a_ils_si_no');?></h2>
			<div class="form-check form-check-inline">
  			<input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_no" onchange="javaScript: selectorNoSi(this);" value="NO" required>
  			<label class="form-check-label" for="empresa_eco_idi_isba_no"><?php echo lang('message_lang.no_adherido_a_ils');?></label>
			</div>
			<div class="form-check form-check-inline">
  			<input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_si" onchange="javaScript: selectorNoSi(this);" value="SI">
  			<label class="form-check-label" for="empresa_eco_idi_isba_si"><?php echo lang('message_lang.adherido_a_ils');?></label>
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
	<!------------------------ 7. DECLARO ----------------------------------------------------------------------------------------------------->
	<div id="formbox">
		<fieldset>
		<h2>7. <?php echo lang('message_lang.declaro');?></h2>
		<ol>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_1');?>" checked="checked" name="declaro_idi_isba_que_cumple_1[]" id="declaro_idi_isba_que_cumple_1" value="SI">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_1">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_1');?>
  					</label>
				</div>
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_2');?>" checked="checked" name="declaro_idi_isba_que_cumple_2[]" id="declaro_idi_isba_que_cumple_2">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_2">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_2');?>
  					</label>
					</div>
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_3');?>" checked="checked" name="declaro_idi_isba_que_cumple_3[]" id="declaro_idi_isba_que_cumple_3"  onchange = "javaScript: muestraSubeArchivo(this.id);">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_3">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_3');?>
  					</label>
				</div>					
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_4');?>" checked="checked" name="declaro_idi_isba_que_cumple_4" id="declaro_idi_isba_que_cumple_4" onchange = "javaScript: muestraSubeArchivo(this.id);">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_4">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_4');?>
  					</label>
				</div>
				<div id = "contenedorAyudasRecibidas" class="">
						<label for = "ayudasSubvenSICuales_dec_resp"><h5><?php echo lang('message_lang.declaro_idi_isba_ayudas_recibidas');?></h5></label>
						<input type="text" title = "<?php echo lang('message_lang.declaro_idi_isba_ayudas_recibidas');?>" name="ayudasSubvenSICuales_dec_resp" id="ayudasSubvenSICuales_dec_resp">
				</div>	
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_5');?>" checked="checked" name="declaro_idi_isba_que_cumple_5" id="declaro_idi_isba_que_cumple_5">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_5">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_5');?>
  					</label>
				</div>		
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_6');?>" checked="checked" name="declaro_idi_isba_que_cumple_6[]" id="declaro_idi_isba_que_cumple_6">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_6">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_6');?>
  					</label>
				</div>		
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_7');?>" checked="checked" name="declaro_idi_isba_que_cumple_7[]" id="declaro_idi_isba_que_cumple_7">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_7">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_7');?>
  					</label>
				</div>		
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_8');?>" checked="checked" name="declaro_idi_isba_que_cumple_8[]" id="declaro_idi_isba_que_cumple_8">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_8">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_8');?>
  					</label>
				</div>		
			</li>
		</ol>
		</fieldset>
	</div>
	<!------------------------ 8. DOCUMENTACIÓN --------------------------------------------------------------------->
	<div id="formbox">
		<fieldset>
			<h2>8. <?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba');?></h2>
			<ol style="list-style-type: lower-alpha;">
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_a');?>" checked="checked" name="documentacion_adjunta_requerida_idi_isba_a[]" id="documentacion_adjunta_requerida_idi_isba_a" value="SI">
  					<label class="form-check-label" for="documentacion_adjunta_requerida_idi_isba_a">
							<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_a');?>
  					</label>
				</div>
			</li>

			<li>
				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_b');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_b" name="documentacion_adjunta_requerida_idi_isba_b[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_b');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div> 
			</li>

			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_c');?>" checked="checked" name="documentacion_adjunta_requerida_idi_isba_c[]" id="documentacion_adjunta_requerida_idi_isba_c" value="SI">
  					<label class="form-check-label" for="documentacion_adjunta_requerida_idi_isba_c">
							<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_c');?>
  					</label>
				</div>
			</li>
		
			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_d');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				 <div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_d" name="documentacion_adjunta_requerida_idi_isba_d[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_d');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>

			<li class="ocultar" id="es-p-fisica">
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_e');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_e" name="documentacion_adjunta_requerida_idi_isba_e[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_e');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>	

			<li class="ocultar" id="es-p-juridica">
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_f');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_f" name="documentacion_adjunta_requerida_idi_isba_f[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_f');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>	
			
			<li>
				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_g');?></strong></h3>
				<div id = "enviaridi_isba_g" class = "">
					<code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_g" name="documentacion_adjunta_requerida_idi_isba_g[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_g');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>
				<div class="form-check">
					<input type="checkbox" id="idi_isba_g_EnIDI" name="idi_isba_g_EnIDI" class="form-check-input" onChange="javaScript: deshabilitarSubidaDocumento (this);" required>
					<label class="form-check-label alert alert-warning" role="alert" for="idi_isba_g_EnIDI"><?php echo lang('message_lang.documentoEnIDI');?> </label>
				</div>
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_h');?></strong></h3>
				<div id = "enviaridi_isba_h" class = "">
					<code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_h" name="documentacion_adjunta_requerida_idi_isba_h[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_h');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>
				<div class="form-check">
					<input type="checkbox" id="idi_isba_h_EnIDI" name="idi_isba_h_EnIDI" class="form-check-input" onChange="javaScript: deshabilitarSubidaDocumento (this);" required>
					<label class="form-check-label alert alert-warning" role="alert" for="idi_isba_h_EnIDI"><?php echo lang('message_lang.documentoEnIDI');?> </label>
				</div>				
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_i');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_i" name="documentacion_adjunta_requerida_idi_isba_i[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_i');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_j');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_j" name="documentacion_adjunta_requerida_idi_isba_j[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_j');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_k');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_k" name="documentacion_adjunta_requerida_idi_isba_k[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_k');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>	

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_l');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_l" name="documentacion_adjunta_requerida_idi_isba_l[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_l');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>	

			<li>
 				<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_m');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input type = "file" id="documentacion_adjunta_requerida_idi_isba_m" name="documentacion_adjunta_requerida_idi_isba_m[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_m');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	
			</li>
			
			<li>
			<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_n');?>" checked="checked" name="documentacion_adjunta_requerida_idi_isba_n[]" id="documentacion_adjunta_requerida_idi_isba_n" value="SI">
  					<label class="form-check-label" for="documentacion_adjunta_requerida_idi_isba_n">
							<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_n');?>
  					</label>
				</div>
 			<!-- 	<h3><strong><?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_n');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="badge text-bg-info">(Max. file size: 10.0 M)</span>:</code>
				<div>
					<input readonly disabled type = "file" id="documentacion_adjunta_requerida_idi_isba_n" name="documentacion_adjunta_requerida_idi_isba_n[]" title="<?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba_n');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" required multiple/>
				</div>	 -->
			</li>			
			</ol>
		</fieldset>
		<!-- <span><?php //echo lang('message_lang.documentos_opcionales_si_ya_los_tiene_admin');?></span> -->
	</div>	
	<div id="formbox">	
		<span class="tooltiptext_idi"><h3><?php echo lang('message_lang.upload_multiple');?></h3></span>	
	</div>
	<button type="submit" name="sendFormIDIISBA" id="sendFormIDIISBA" 
				class="btn btn-primary" 
				data-bs-toggle="tooltip" 
				data-bs-placement="top"
        data-bs-title="Premi per enviar la sol·licitud del beneficiari a l'IDI."
				onClick="onFormSubmit(event)"
				>Enviar

				<div class="spinner-border text-primary ocultar" role="status" id="spinnerSendRequestIDIISBA">
  				<span class="visually-hidden">Sending request, please wait...</span>
				</div>
	</button>
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