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
			<!-- <input type='hidden' id="tipo_solicitante" name="tipo_solicitante" value="mediana"> -->
	</fieldset>

<!-- Modal -->
<div class="modal fade" id="rgpdModal" tabindex="-1" aria-labelledby="rgpdModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

		<div id="formbox">
			<fieldset>
				<div class="form-check"> 
  				<input class="form-check-input" type="checkbox"  onChange="javaScript: activaDesactivaFormulario (this.checked);" required value="rgpd" name = "rgpd" id = "rgpd">
  				<label class="form-check-label" for="flexCheckDefault">
					<?php echo lang('message_lang.rgpd_leido');?><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rgpdModal">RGPD</button>
  				</label>
				</div>
				<span id='aviso'></span>
			</fieldset>
		</div>	

<form name="adhesion_idi_isba" id="adhesion_idi_isba" action="<?php echo base_url('/public/index.php/subirarchivo/store_idi_isba/'.$viaSolicitud.'/'.$locale);?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<!-------------------------- 0. TIPO DE SOLICITANTE --------------------------------------------------------------------->
  	<div id="formbox">
    	<fieldset><span class="ocultar" id="aviso2"><?php echo lang('message_lang.marque_una_opcion');?></span>
		 		<h2><?php echo lang('message_lang.solicitante_tipo');?></h2>
				<div class="form-check form-check-inline">
  				<input class="form-check-input" type="radio" name="tipo_solicitante" checked id="autonomo" value="autonomo" onchange = "javaScript: tipoSolicitante (this.id);">
  				<label class="form-check-label" for="condicion_rep_admin">
						<?php echo lang('message_lang.solicitante_tipo_autonomo');?>
			  	</label>
				</div>
				<div class="form-check form-check-inline">
  				<input class="form-check-input" type="radio" name="tipo_solicitante" id="pequenya" value="pequenya" onchange = "javaScript: tipoSolicitante (this.id);">
  				<label class="form-check-label" for="condicion_rep_apoderado">
						<?php echo lang('message_lang.solicitante_tipo_pequenya');?>
  				</label>
				</div>
				<div class="form-check form-check-inline">
  				<input class="form-check-input" type="radio" name="tipo_solicitante" id="mediana" value="mediana" onchange = "javaScript: tipoSolicitante (this.id);">
  				<label class="form-check-label" for="condicion_rep_apoderado">
						<?php echo lang('message_lang.solicitante_tipo_mediana');?>
  				</label>
				</div>
   		</fieldset>
	</div>
<!-------------------------- 1. IDENTIFICACIÓN DEL SOLICITANTE --------------------------------------------------------------------->
	<div id="formbox">
		<fieldset id="interesado">
			<h2>1. <?php echo lang('message_lang.identificacion_sol_idi_isba');?></h2>

			<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
				<div class="input-group">
						<input type = "text" aria-label="Input group example" aria-describedby="btnGroupAddon" onfocus="javaScript: limpiaInfo_lbl (this.value);" required onBlur = "javaScript: averiguaTipoDocumento (this.value);" title="<?php echo lang('message_lang.nif_solicitante');?>" placeholder = "<?php echo lang('message_lang.nif_solicitante');?>" name = "nif" id = "nif" minlength = "9" maxlength = "9" aria-required="true"><small id = "info_lbl" class="alert alert-danger ocultar" role="alert"></small>
  			</div>
   			<button title="Obtener los datos desde ISBA,SGR" type="button" class="btn btn-outline-secondary ocultar" id="rest-to-isba">
					<div id ="spinner-idi-isba" class="spinner-border text-primary ocultar" role="status">
 						<span id ="text-isba" class="visually-hidden">Getting data...</span>
					</div>
					<span>Obtener datos desde ISBA,SGR</span>
				</button>
				<button title="Obtener los datos desde IDI" type="button" class="btn btn-outline-secondary ocultar" id="rest-to-idi">
					<div id ="spinner-idi-isba" class="spinner-border text-primary ocultar" role="status">
 						<span id ="text-idi" class="visually-hidden">Getting data...</span>
					</div>
					<span>Obtener datos desde IDI</span>
				</button>
				<span id='rest-result'></span>

			</div>

			<input type = "text" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" name = "denom_interesado" id = "denom_interesado" size="220" aria-required="true">
			<input type = "text" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.direccion_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_sol_idigital');?>" name="domicilio" id="domicilio" aria-required="true">
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/municipios.php';?>
			<input type = "text" onblur="javaScript: validateFormField(this);" required title="<?php echo lang('message_lang.cp_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.cp_sol_idigital');?>" name="cpostal" id="cpostal" pattern="[0-9]{5}" minlength = "5" maxlength = "5" size="9" aria-required="true">  
    	<input type = "tel" onblur="javaScript: validateFormField(this);" title="<?php echo lang('message_lang.movil_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_sol_idigital');?>" name = "telefono_cont" id="telefono_cont" maxlength = "9" size="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" aria-required="true"><p id="mensaje_tel"></p>
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/public/assets/utils/epigrafeIAE_idi_isba.php';?>
			<input type="text" aria-required="true" name = "nom_representante" id = "nom_representante" title="<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nom_rep_legal_sol_idigital');?>" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "nif_representante" id = "nif_representante" title="<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.nif_rep_legal_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "domicilio_rep" id = "domicilio_rep" title="<?php echo lang('message_lang.direccion_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.direccion_rep_legal_sol_idigital');?>" onblur="javaScript: validateFormField(this);">
			<input type="text" aria-required="true" name = "telefono_rep" id = "telefono_rep" title="<?php echo lang('message_lang.movil_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.movil_sol_idigital');?>" minlength = "9" maxlength = "9" onblur="javaScript: validateFormField(this);">

			<div class="form-check form-check-inline">
  			<input class="form-check-input" type="radio" name="condicion_rep" id="condicion_rep_admin" value="administrador">
  			<label class="form-check-label" for="condicion_rep_admin">
					<?php echo lang('message_lang.condicion_rep_admin');?>
			  </label>
			</div>
			<div class="form-check form-check-inline">
  			<input class="form-check-input" type="radio" name="condicion_rep" id="condicion_rep_apoderado" value="apoderado">
  			<label class="form-check-label" for="condicion_rep_apoderado">
					<?php echo lang('message_lang.condicion_rep_apoderado');?>
  			</label>
			</div>
		</fieldset> 
	</div>

<!-------------------------- 2. NOTIFICACIÓN y AUTORIZACIONES --------------------------------------------------------------------->
	<div id="formbox">
    <fieldset>
			<h2>2. <?php echo lang('message_lang.titulo_notificiaciones');?></h2>
			<input type = "tel" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.tel_rep_legal_sol_idigital');?>" aria-required="true" name = "tel_representante" id="tel_representante" maxlength = "9" size="9" ><p id="mensaje_tel"></p>
			<input type = "email" onblur="javaScript: validateFormField(this);" required title = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" placeholder = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" data-error = "<?php echo lang('message_lang.mail_rep_legal_sol_idigital');?>" aria-required="true" name = "mail_representante" id="mail_representante" size="220">
		</fieldset>
	</div>

<!-------------------------- 3. OPERACIÓN FINANCIERA --------------------------------------------------------------------->
	<div id="formbox">
    <fieldset>
			<h2>3. <?php echo lang('message_lang.operacion_financiera_idi_isba');?></h2>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.entidad_financiera_idi_isba');?>" placeholder = "<?php echo lang('message_lang.entidad_financiera_idi_isba');?>" data-error = "<?php echo lang('message_lang.entidad_financiera_idi_isba');?>" aria-required="true" name = "nom_entidad" id="nom_entidad" size="220" required>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba');?>" placeholder = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba');?>" data-error = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba');?>" data-type="currency" aria-required="true" name = "importe_prestamo" id="importe_prestamo" required>
			<input type = "number" min="0" max="60" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba');?>" placeholder = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba');?>" data-error = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba');?>" aria-required="true" name = "plazo_prestamo" id="plazo_prestamo" required>
			<input type = "number" min="0" max="60" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.carencia_prestamo_entidad_idi_isba');?>" placeholder = "<?php echo lang('message_lang.carencia_prestamo_entidad_idi_isba');?>" data-error = "<?php echo lang('message_lang.carencia_prestamo_entidad_idi_isba');?>" name = "carencia_prestamo" id="carencia_prestamo" value="0" required>
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba');?>" placeholder = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba');?>" data-error = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba');?>" data-type="currency" aria-required="true" name = "cuantia_aval_isba" id="cuantia_aval_isba" required>
			<input type = "number" min="0" max="60" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.plazo_prestamo_idi_isba');?>" placeholder = "<?php echo lang('message_lang.plazo_prestamo_idi_isba');?>" data-error = "<?php echo lang('message_lang.plazo_prestamo_idi_isba');?>" aria-required="true" name = "plazo_aval_isba" id="plazo_aval_isba" required>
			<input type = "date" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.fecha_del_aval_idi_isba');?>" placeholder = "<?php echo lang('message_lang.fecha_del_aval_idi_isba');?>" aria-required="true" name = "fecha_aval_isba" id="fecha_aval_isba" required>
		</fieldset>
	</div>

<!-------------------------- 4. PROYECTO DE INVERSIÓN ---------------------------------------------------------------------------------->
	<div id="formbox">
    <fieldset>
			<h2>4. <?php echo lang('message_lang.proyecto_de_inversion_idi_isba');?></h2>
			<input type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.proyecto_de_inversion_idi_isba_finalidad');?>" placeholder = "<?php echo lang('message_lang.proyecto_de_inversion_idi_isba_finalidad');?>" required aria-required="true" name = "finalidad_inversion_idi_isba" id="finalidad_inversion_idi_isba" maxlength = "220" size="220" required>
		</fieldset>
<!-------------------------- SOLICITA AYUDA  ---------------------------------------------------------------------------------------->
		<fieldset>
			<h2>5. <?php echo lang('message_lang.adherido_a_ils_si_no');?></h2>
			<div class="form-check form-check-inline">
  			<input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_no" onchange="javaScript: selectorNoSi(this);" value="NO">
  			<label class="form-check-label" for="empresa_eco_idi_isba_no">
					NO
			  </label>
			</div>
			<div class="form-check form-check-inline">
  			<input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_si" onchange="javaScript: selectorNoSi(this);" value="SI">
  			<label class="form-check-label" for="empresa_eco_idi_isba_si">
					SI
  			</label>
			</div>
			<span id="empresa_eco"></span>
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
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba');?>" placeholder = "<?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba');?>" aria-required="true" name = "coste_aval_solicita_idi_isba" id="coste_aval_solicita_idi_isba" maxlength = "9" size="9" >
			<input type = "text" min="0" onblur="javaScript: validateFormField(this); formatNumber(this)" title = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba');?>" placeholder = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba');?>" aria-required="true" name = "gastos_aval_solicita_idi_isba" id="gastos_aval_solicita_idi_isba" maxlength = "9" size="9" required>
		</fieldset>
	</div>
	<!------------------------------------- 6. DECLARO ------------------------------------------------------------------------->
	<div id="formbox">
		<fieldset>
		<h2>6. <?php echo lang('message_lang.declaro');?></h2>
		<ol>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple');?>" checked name="declaro_idi_isba_que_cumple" id="declaro_idi_isba_que_cumple">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple');?>
  					</label>
				</div>
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_no_mas_25');?>" checked name="declaro_idi_isba_que_cumple_no_mas_25" id="declaro_idi_isba_que_cumple_no_mas_25">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_no_mas_25">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_no_mas_25');?>
  					</label>
					</div>
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.declaro_idi_isba_que_cumple_no_incurre_prohibicion_incompatibilidad');?>" checked name="declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom" id="declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom">
  					<label class="form-check-label" for="declaro_idi_isba_que_cumple_no_incurre_prohibicion_incompatibilidad">
							<?php echo lang('message_lang.declaro_idi_isba_que_cumple_no_incurre_prohibicion_incompatibilidad');?>
  					</label>
				</div>					
			</li>
			<li>
				<?php echo ucfirst(lang('message_lang.declaro_idi_isba_que_cumple_no_si_tiene_ayudas_solicitadas'));?>
							<ul>
								<li>
									<div class="form-check form-check-inline">
  									<input class="form-check-input" type="radio" name="tiene_ayudas_subv" onchange="javaScript: selectorNoSi(this);" id="tiene_ayudas_subv_no" value="NO">
  									<label class="form-check-label" for="tiene_ayudas_subv_no">
											NO
			  						</label>
									</div>
									<div class="form-check form-check-inline">
  									<input class="form-check-input" type="radio" name="tiene_ayudas_subv" onchange="javaScript: selectorNoSi(this);" id="tiene_ayudas_subv_si" value="SI">
  									<label class="form-check-label" for="tiene_ayudas_subv_si">
											SI
  									</label>
									</div>
									<ul id="tiene_ayudas_subv_si_no" class ="ocultar">
										<li>
											<div class="form-check form-check-inline">
  											<input class="form-check-input" type="radio" name="ayuda_subv_de" onchange="javaScript: selectorNoSi(this);" id="ayuda_subv_dg_pol_ind" value="dg_pol_ind">
  											<label class="form-check-label" for="ayuda_subv_dg_pol_ind">
													<?php echo lang('message_lang.direccion_general_politica_industrial_idi_isba');?>
  											</label>
											</div>
											<div class="form-check form-check-inline">
	  										<input class="form-check-input" type="radio" name="ayuda_subv_de" onchange="javaScript: selectorNoSi(this);" id="ayuda_subv_otros" value ="otros">
  											<label class="form-check-label" for="ayuda_subv_otros">
													<?php echo lang('message_lang.otros_declaro_idi_isba');?>
  											</label>
											</div>
											<input class="ocultar" type = "text" onblur="javaScript: validateFormField(this);" title = "<?php echo lang('message_lang.otros_declaro_detallar_idi_isba');?>" placeholder = "<?php echo lang('message_lang.otros_declaro_idi_isba');?>" aria-required="true" name = "ayuda_subv_otros_detalle" id="ayuda_subv_otros_detalle">
										</li>
									</ul>
								</li>
							</ul>
			</li>
			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.consentimiento_identificacion_solicitante');?>" checked readonly name="consentimiento_identificacion" id="consentimiento_identificacion" onchange = "javaScript: muestraSubeArchivo(this.id);">
  					<label class="form-check-label" for="consentimiento_identificacion">
							<?php echo lang('message_lang.consentimiento_identificacion_solicitante');?>
  					</label>
				</div>
				<div id = "enviardocumentoIdentificacion" class = "ocultar">
					<label for = "file_enviardocumentoIdentificacion"><h5><?php echo lang('message_lang.document_identificativos');?></h5><code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
				</div>
			</li>

			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.doy_mi_consentimiento_aeat_atib');?>" checked readonly name="consentimiento_certificadoATIB" id="consentimiento_certificadoATIB" onchange = "javaScript: muestraSubeArchivo(this.id);">
  					<label class="form-check-label" for="consentimiento_certificadoATIB">
							<?php echo lang('message_lang.doy_mi_consentimiento_aeat_atib');?>
  					</label>
				</div>
				<div id = "enviarcertificadoATIB" class = "ocultar">
					<label for = "file_certificadoATIB"><h5><?php echo lang('message_lang.certificado_document_correspon');?></h5><code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code> 
				</div>
			</li>

			<li>
				<div class="form-check">
  				<input class="form-check-input" type="checkbox" title = "<?php echo lang('message_lang.doy_mi_consentimiento_seg_soc');?>" checked readonly name="consentimiento_TesoreriaSegSoc" id="consentimiento_TesoreriaSegSoc" onchange = "javaScript: muestraSubeArchivo(this.id);">
  					<label class="form-check-label" for="consentimiento_TesoreriaSegSoc">
							<?php echo lang('message_lang.doy_mi_consentimiento_seg_soc');?>
  					</label>
				</div>
				<div id = "enviarcertificadoSecSoc" class = "ocultar">
					<label for = "file_certificadoSegSoc"><h5><?php echo lang('message_lang.certificado_document_correspon');?></h5><code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code> 
				</div>
			</li>

		</ol>
		</fieldset>
	</div>

	<!-------------------------- 7. DOCUMENTACIÓN --------------------------------------------------------------------->

	<div id="formbox">
		<fieldset>
			<h2>7. <?php echo lang('message_lang.documentacion_adjunta_requerida_idi_isba');?></h2>

			<h3><strong><?php echo lang('message_lang.copia_dni');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_copiaNIF" name="file_copiaNIF[]" title="<?php echo lang('message_lang.copia_dni');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
			</div>

			<h3><strong><?php echo lang('message_lang.escritura_empresa_idi_isba');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_escritura_empresa" name="file_escritura_empresa[]" title="<?php echo lang('message_lang.escritura_empresa_idi_isba');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
			</div>

			<h3><strong><?php echo lang('message_lang.certificado_IAE');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificadoIAE" name="file_certificadoIAE[]" title="<?php echo lang('message_lang.certificado_IAE');?>" class="mostrar-siempre" size="50" accept=".pdf, .jpeg, .png" multiple/>
			</div>						
					
		</fieldset>

		<!-- <fieldset>
			<h2><?php echo lang('message_lang.ayuda_superior_3000');?></h2>

		  <h3><strong><?php echo lang('message_lang.certificado_corriente_pago_aeat');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificadoATIB" name="file_certificadoATIB[]" title="<?php echo lang('message_lang.certificado_corriente_pago_aeat');?>" size="50" accept=".pdf, .jpeg, .png" multiple/>
			</div>

			<h3><strong><?php echo lang('message_lang.certificado_corriente_pago_ttss');?></strong></h3> <code>[.pdf, .jpeg, .png] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</code>
			<div>
				<input type = "file" id="file_certificadoSegSoc" name="file_certificadoSegSoc[]" title="<?php echo lang('message_lang.certificado_corriente_pago_ttss');?>" size="50" accept=".pdf, .jpeg, .png" multiple/>
			</div>			
		</fieldset> -->
		<span><?php echo lang('message_lang.documentos_opcionales_si_ya_los_tiene_admin');?></span>
	</div>	
	<div id="formbox">	
		<span class="tooltiptext_idi"><h3><?php echo lang('message_lang.upload_multiple');?></h3></span>	
	</div>

<button type="submit" name="sendForm" id="sendForm" class="btn btn-primary">Enviar</button>
</form>

<script>

var currentTab = 0; // Current tab is set to be the first tab (0)
// showTab(currentTab); // Display the current tab

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
	if (n === 4) {
		document.getElementById("file_escritura_empresa").style.display = "block";
		document.getElementById("file_certificadoIAE").style.display = "block";

	  submitBTN.innerHTML = "Enviar"
	  submitBTN.setAttribute("title", "Enviar")
	  submitBTN.setAttribute("value", "Submit")
	  submitBTN.setAttribute("form", "adhesion_idi_isba")
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