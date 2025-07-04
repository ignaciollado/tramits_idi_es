<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/public/assets/css/style-idi-isba.css"/>
<script type="text/javascript" src="/public/assets/js/edita-expediente-isba.js"></script>
<script>
    const mainNodeISBA = document.querySelector('body');
    mainNodeISBA.onload = configuraDetalle_OnLoad;
    const form = document.getElementById('subir_faseExpedSolicitud');
</script>
<?php
    use App\Models\DocumentosGeneradosModel;
    use App\Models\DocumentosJustificacionModel;
    use App\Models\MejorasExpedienteModel;
    use App\Models\ExpedientesModel;

    $modelDocumentosGenerados = new DocumentosGeneradosModel();
    $modelMejorasSolicitud = new MejorasExpedienteModel();
    $modelExp = new ExpedientesModel();
    $modelJustificacion = new DocumentosJustificacionModel();

    $session = session();
	$convocatoria = $expedientes['convocatoria'];
	$programa = $expedientes['tipo_tramite'];
	$id = $expedientes['id'];
	$nifcif = $expedientes['nif'];
    $convocatoriaEnCurso = $configuracion['convocatoria'];
    $esAdmin = ($session->get('rol') == 'admin');
    $esConvoActual = ($convocatoria == $convocatoriaEnCurso);

    $expedienteID = [
        'id'  => $id,
        'programa' => $programa
    ];
    $session->set($expedienteID);
    $base_url = $_SERVER['USER'];
?>

    <!---------------------- Para poder consultar el estado de firma de los documentos ------->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/execute-curl.php';?>
    <!---------------------------------------------------------------------------------------->

<div class="tab_fase_exp">
    <button id="detall_tab_selector" class="tablinks" onclick="openFaseExped(event, 'detall_tab', ' #ccc', <?php echo $expedientes['id'];?>)">General</button>  
    <?php if ( $session->get('rol') !== 'adr-isba' ) {?>
        <button id="solicitud_tab_selector" class="tablinks" onclick="openFaseExped(event, 'solicitud_tab', '#f6b26b', <?php echo $expedientes['id'];?>)">Sol·licitud</button>
        <button id="validacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'validacion_tab', '#b23cfd', <?php echo $expedientes['id'];?>)">Validació</button>
    <?php } ?>    
    <button id="justifiacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'justificacion_tab', '#a64d79', <?php echo $expedientes['id'];?>)">Justificació</button>
    <?php if ( $session->get('rol') !== 'adr-isba' ) {?>
        <button id="deses_ren_tab_selector" class="tablinks" onclick="openFaseExped(event, 'deses_ren_tab', '#8e7cc3')">Desistiment o renúncia</button>
    <?php } ?> 
</div>
<?php echo "Data sol·licitud: ". $expedientes['fecha_solicitud'];?> <?php echo "Data complert: ". $expedientes['fecha_completado'];?>

<div id="detall_tab" class="tab_fase_exp_content" style="display:block;" onload="javaScript:alert(id);">
    <div class="row">
        <div class="col docsExpediente">
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" name="exped-fase-0" id="exped-fase-0" method="post" accept-charset="utf-8">
	        <div class = "row">	
	            <div class="col">
     			    <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $expedientes['id']; ?>">
     			    <input type="hidden" name="convocatoria" class="form-control" id="convocatoria" value="<?php echo $expedientes['convocatoria']; ?>">
                    <div class="form-group general">
                        <label class="label-negativo" for="empresa">Empresa:</label>
                        <input type="text" name="empresa" class="form-control" id = "empresa" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> readonly disabled placeholder="Nom del sol·licitant" value="<?php echo $expedientes['empresa']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="nif">NIF:</label>
                        <input type="text" name="nif" class="form-control" id = "nif" readonly disabled placeholder="NIF del sol·licitant" value="<?php echo $expedientes['nif']; ?>">
                    </div>     
    		        <div class="form-group general">
                        <label class="label-negativo" for="fecha_completado">Data de la sol·licitud:</label>
                        <strong><?php echo date_format(date_create($expedientes['fecha_solicitud']), 'd/m/Y H:i:s'); ?></strong>
		        	    <input type="hidden" name="fecha_completado" class="form-control" id = "fecha_completado" value="<?php echo $expedientes['fecha_completado']; ?>">
			            <input type="hidden" name="fecha_solicitud" class="form-control" id = "fecha_solicitud" value="<?php echo $expedientes['fecha_solicitud']; ?>">
                    </div>
    		        <div class="form-group general">
                        <label class="label-negativo" for="programa">Programa:</label>
		    	        <input type="text" name="programa" list="listaProgramas" class="form-control" readonly disabled id = "programa" value="<?php echo $expedientes['tipo_tramite'];?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="telefono_rep"><strong>Mòbil a efectes de notificacions:</strong></label>
                        <input type="tel"  readonly disabled name="telefono_rep" class="form-control" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "telefono_rep" placeholder = "Mòbil a efectes de notificacions" minlength = "9" maxlength = "9" value = "<?php echo $expedientes['telefono_rep']; ?>">
                    </div>
              	    <div class="form-group general">
                        <label class="label-negativo" for="email_rep"><strong>Adreça electrònica a efectes de notificacions:</strong></label>
                        <input type="email"  readonly disabled name="email_rep" class="form-control" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "email_rep" placeholder="Adreça electrònica a efectes de notificacions" value="<?php echo $expedientes['email_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="domicilio">Adreça:</label>
                        <input type="text" name="domicilio" class="form-control" readonly disabled id = "domicilio" required placeholder="Adreça del sol·licitant" value="<?php echo $expedientes['domicilio']; ?>">
                    </div>
		            <div class="form-group general">
                        <label class="label-negativo" for="localidad">Població:</label>
				            <?php
    					        $localidad = explode ("#", $expedientes['localidad']);		
				            ?>
			            <input type="text" name="Poblacio" class="form-control" readonly disabled id = "Poblacio" placeholder="Població" value="<?php echo $localidad[1].' ('.$localidad[0].')';?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="cpostal">Codi postal:</label>
                        <input type="text" name="cpostal" class="form-control" readonly disabled id = "cpostal" maxlength = "5" size="5" required placeholder="Codi postal del sol·licitant" value="<?php echo $expedientes['cpostal']; ?>">
                    </div>   
                    <div class="form-group general">
                        <label class="label-negativo" for="telefono">Telèfon de contacte:</label>
                        <input type="tel" name="telefono" class="form-control" readonly disabled id = "telefono" placeholder="Telèfon del sol·licitant" value="<?php echo $expedientes['telefono']; ?>">
                    </div> 
                    <div class="form-group general">
                        <label class="label-negativo" for="iae">Activitat econòmica (IAE):</label>
                        <input type="text" name="iae" class="form-control" readonly disabled id = "iae" maxlength = "4" size="4" placeholder="IAE" value="<?php echo $expedientes['iae']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="nombre_rep">Representant legal:</label>
                        <input type="text" name="nombre_rep" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nombre_rep" placeholder = "Nom del representant" value = "<?php echo $expedientes['nombre_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="nif_rep">NIF representant legal:</label>
                        <input type="text" name="nif_rep" class="form-control" readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nif_rep" minlength = "9" maxlength = "9" placeholder = "NIF del representant" value = "<?php echo $expedientes['nif_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="nif_rep">Adreça representant legal:</label>
                        <input type="text" name="domicilio_rep" class="form-control" readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "domicilio_rep" minlength = "9" maxlength = "9" placeholder = "Adreça del representant" value = "<?php echo $expedientes['domicilio_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="nif_rep">Telèfon representant legal:</label>
                        <input type="text" name="telefono_contacto_rep" class="form-control" readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "telefono_contacto_rep" minlength = "9" maxlength = "9" placeholder = "Telèfon del representant" value = "<?php echo $expedientes['telefono_contacto_rep']; ?>">
                    </div>
                    <h3>Autoritza a consultar:</h3>
                <h4 for = "file_copiaNIF" class="main" >
					<span >Document identificatiu de la persona sol·licitant o persona autoritzada:</span>
						<input type="checkbox" <?php if ($expedientes['file_copiaNIF'] === "SI") { echo "checked";}?> disabled readonly name = "file_copiaNIF" id = "file_copiaNIF">
					<span class="w3docs"></span>
				</h4>

                <h4 for = "file_certificadoATIB" class="main" >
					<span >Certificat de l'Agència Tributària de les Illes Balears:</span>
						<input type="checkbox" <?php if ($expedientes['file_certificadoATIB'] === "SI") { echo "checked";}?> disabled readonly name = "file_certificadoATIB" id = "file_certificadoATIB">
					<span class="w3docs"></span>
				</h4>

                <h4 for = "file_certificadoSegSoc" class="main" >
					<span >Certificat de la Tresoreria General de la Seguretat Social:</span>
						<input type="checkbox" <?php if ($expedientes['file_certificadoSegSoc'] === "SI") { echo "checked";}?> disabled readonly name = "file_certificadoSegSoc" id = "file_certificadoSegSoc">
					<span class="w3docs"></span>
				</h4>
                </div>
                <div class="col">
                <div class="form-group general">
                    <label for="comments" style="color:#000;">Comentaris:</label>
                    <textarea id="comments" name="comments" rows="15" cols="80" placeholder="Escribe tus comentarios aquí..."><?php echo $expedientes['comments']; ?></textarea>                       
                </div>                     	     
                <fieldset>
			        <h3><?php echo lang('message_lang.adherido_a_ils_si_no');?></h3>
			        <div class="form-check form-check-inline">
  			            <input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_no" <?php if ($expedientes['empresa_eco_idi_isba']=='NO') { echo 'checked';} ?> disabled readonly>
  			            <label class="form-check-label label-negativo" for="empresa_eco_idi_isba_no"><?php echo lang('message_lang.no_adherido_a_ils');?></label>
			        </div>
			        <div class="form-check form-check-inline">
  			            <input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_si" <?php if ($expedientes['empresa_eco_idi_isba']=='SI') { echo 'checked';} ?> disabled readonly>
  			            <label class="form-check-label label-negativo" for="empresa_eco_idi_isba_si"><?php echo lang('message_lang.adherido_a_ils');?></label>
			        </div>
			        <div class="alert alert-primary ocultar" role="alert" id="empresa_eco"></div>
		        </fieldset>
                <hr>

                    <div class="form-group general">
                        <label style="width: 100%;" class="alert alert-success" role="alert" for=''><?php echo lang('message_lang.operacion_financiera_idi_isba') ?>:<br><strong><?php echo $expedientes['finalidad_inversion_idi_isba']; ?></strong></label>
                    </div>
                    <div class="form-group general">
                        <label class="alert alert-secondary" for=''><u><?php echo lang('message_lang.operacion_financiera_prestamo_idi_isba') ?></u></label>
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="nom_entidad"><?php echo lang('message_lang.entidad_financiera_idi_isba') ?>:</label>
                        <input type="text" name="nom_entidad" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "nom_entidad" placeholder = "<?php echo lang('message_lang.entidad_financiera_idi_isba') ?>" value = "<?php echo $expedientes['nom_entidad']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="importe_prestamo"><?php echo lang('message_lang.importe_prestamo_entidad_idi_isba') ?>:</label>
                        <input type="text" name="importe_prestamo" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "importe_prestamo" placeholder = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba') ?>" value = "<?php echo $expedientes['importe_prestamo']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="plazo_prestamo"><?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba') ?>:</label>
                        <input type="text" name="plazo_prestamo" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "plazo_prestamo" placeholder = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba') ?>" value = "<?php echo $expedientes['plazo_prestamo']; ?>">
                    </div>
                    <label for=''><u><?php echo lang('message_lang.operacion_financiera_aval_idi_isba') ?></u></label>
                    <div class="form-group general">
                        <label class="label-negativo" for="cuantia_aval_isba"><?php echo lang('message_lang.cuantia_prestamo_idi_isba') ?>:</label>
                        <input type="text" name="cuantia_aval_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "cuantia_aval_isba" placeholder = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba') ?>" value = "<?php echo $expedientes['cuantia_aval_idi_isba']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="label-negativo" for="plazo_aval_isba"><?php echo lang('message_lang.plazo_prestamo_idi_isba') ?>:</label>
                        <input type="text" name="plazo_aval_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "plazo_aval_isba" placeholder = "<?php echo lang('message_lang.plazo_prestamo_idi_isba') ?>" value = "<?php echo $expedientes['plazo_aval_idi_isba']; ?>">
                    </div>            
                    <div class="form-group general">
                        <label class="label-negativo" for="fecha_aval_isba"><?php echo lang('message_lang.fecha_del_aval_idi_isba') ?>:</label>
                        <input type="text" name="fecha_aval_isba" class="form-control" readonly disabled  oninput = "javaScript: actualizaRequired(this.value);" readonly id = "fecha_aval_isba" placeholder = "<?php echo lang('message_lang.fecha_del_aval_idi_isba') ?>" value = "<?php echo $expedientes['fecha_aval_idi_isba']; ?>">
                    </div>
                    <div class="form-group general">
                        <label class="alert alert-dark" for="importe_ayuda_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_importe_idi_isba') ?>:</label>
                        <input type="text" name="importe_ayuda_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "importe_ayuda_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_importe_idi_isba') ?>" value = "<?php echo $expedientes['importe_ayuda_solicita_idi_isba']; ?>">
                        <br><h4>Amb el següent detall:</h4>
                    </div>
                    <div class="form-group general alert alert-dark">
                        <ol class="inv-detalle">
                            <li>
                            <label class="label-negativo" for="intereses_ayuda_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba') ?>:</label>
                            <input type="text" name="intereses_ayuda_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "intereses_ayuda_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba') ?>" value = "<?php echo $expedientes['intereses_ayuda_solicita_idi_isba']; ?>">
                            </li>
                            <li>
                            <label class="label-negativo" for="coste_aval_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba') ?>:</label>
                            <input type="text" name="coste_aval_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "coste_aval_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba') ?>" value = "<?php echo $expedientes['coste_aval_solicita_idi_isba']; ?>">
                            </li>
                            <li>
                            <label class="label-negativo" for="gastos_aval_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba') ?>:</label>
                            <input type="text" name="gastos_aval_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "gastos_aval_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba') ?>" value = "<?php echo $expedientes['gastos_aval_solicita_idi_isba']; ?>">
                            </li>
                        </ol>
                    </div>
        
                    <div class="form-group general">
                        <label class="label-negativo" for="ayudasSubvenSICuales_dec_resp"><?php echo lang('message_lang.declaro_idi_isba_ayudas_recibidas') ?>:</label>
                        <input type="text" name="ayudasSubvenSICuales_dec_resp" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "ayudasSubvenSICuales_dec_resp" placeholder = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba') ?>" value = "<?php echo $expedientes['ayudasSubvenSICuales_dec_resp']; ?>">
                    </div>

    		        <div class="form-group general">
                        <label class="label-negativo" for="tecnicoAsignado">Tècnica asignada:</label>
                        <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type="text" name="tecnicoAsignado" onChange="avisarCambiosEnFormulario('send_fase_0')" list="listaTecnicos" class="form-control send_fase_0" id = "tecnicoAsignado" min="0" placeholder="Tècnica asignada" value="<?php echo $expedientes['tecnicoAsignado']; ?>">
			            <datalist id="listaTecnicos">
    			            <option value="Vittoria">
				            <option value="Caterina Mas">
				            <option value="María del Carmen Muñoz Adrover">
				            <option value="Marta Riutord">
				            <option value="Pilar Jordi Amorós">
  			            </datalist>
		            </div>

		            <div class="form-group general">
                        <label class="label-negativo" for = "situacion_exped"><strong>Situació:</strong></label>
                        <select class="form-control send_fase_0" id = "situacion_exped" name = "situacion_exped" required <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> onchange="compruebaExistenciaFecha('send_fase_0', this.id)">
    		    		<option disabled <?php if ($expedientes['situacion'] == "") { echo "selected"; }?> value = ""><span>Selecciona una opció:</span></option>
                        <optgroup style="background-color:#F51720;color:#000;" label="Fase sol·licitud:">
                            <option <?php if ($expedientes['situacion'] === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitSolicitud"> No ha passat per la SEU electrònica</option>
                            <option <?php if ($expedientes['situacion'] === "pendiente") { echo "selected";}?> value = "pendiente" class="sitSolicitud"> Pendent de validar</option>
                            <option <?php if ($expedientes['situacion'] === "comprobarAnt") { echo "selected";}?> value = "comprobarAnt" class="sitSolicitud"> Comprovar Antonia</option>
                            <option <?php if ($expedientes['situacion'] === "comprobarAntReg") { echo "selected";}?> value = "comprobarAntReg" class="sitSolicitud"> Comprovar Antonia amb requeriment pendent</option>
                            <option <?php if ($expedientes['situacion'] === "emitirReq") { echo "selected";}?> value = "emitirReq" class="sitSolicitud"> Emetre requeriment</option>
                            <option <?php if ($expedientes['situacion'] === "firmadoReq") { echo "selected";}?> value = "firmadoReq" class="sitSolicitud"> Requeriment signat pendent de notificar</option>
                            <option <?php if ($expedientes['situacion'] === "notificadoReq") { echo "selected";}?> value = "notificadoReq" class="sitSolicitud"> Requeriment notificat</option>
                            <option <?php if ($expedientes['situacion'] === "emitirDesEnmienda") { echo "selected";}?> value = "emitirDesEnmienda" class="sitSolicitud"> Emetre desistiment per esmena</option>
                            <option <?php if ($expedientes['situacion'] === "emitidoDesEnmienda") { echo "selected";}?> value = "emitidoDesEnmienda" class="sitSolicitud"> Desistiment per esmena emès</option>
							<option <?php if ($expedientes['situacion'] === "Desestimiento") { echo "selected";}?> value = "Desestimiento" class="sitSolicitud"> Desistiment</option>
                        </optgroup>
                        <optgroup style="background-color:#1ecbe1;color:#000;" label="Fase validació:">
                            <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients favorables:">
                                <option <?php if ($expedientes['situacion'] === "emitirIFPRProvPago") { echo "selected";}?> value = "emitirIFPRProvPago" class="sitValidacion"> IF + PR Provisional emetre</option>
    				            <option <?php if ($expedientes['situacion'] === "emitidoIFPRProvPago") { echo "selected";}?> value = "emitidoIFPRProvPago" class="sitValidacion"> IF + PR Provisional emesa</option>
    				            <option <?php if ($expedientes['situacion'] === "notificadoIFPRProvPago") { echo "selected";}?> value = "notificadoIFPRProvPago" class="sitValidacion"> PR Provisional NOTIFICADA (DATA) AUT</option>
                                <option <?php if ($expedientes['situacion'] === "firmadoIFPRProvPago") { echo "selected";}?> value = "firmadoIFPRProvPago" class="sitValidacion">PR Prov. signada pendent de notificar</option>
	    			            <option <?php if ($expedientes['situacion'] === "emitirPRDefinitiva") { echo "selected";}?> value = "emitirPRDefinitiva" class="sitValidacion"> PR definitiva Enviada a firma</option>
							    <option <?php if ($expedientes['situacion'] === "emitidaPRDefinitiva") { echo "selected";}?> value = "emitidaPRDefinitiva" class="sitValidacion"> PR definitiva signada PENDENT de notificar</option>
							    <option <?php if ($expedientes['situacion'] === "emitidaPRDefinitivaNotificada") { echo "selected";}?> value = "emitidaPRDefinitivaNotificada" class="sitValidacion"> PR definitiva NOTIFICADA</option>
                        	    <option <?php if ($expedientes['situacion'] === "emitirResConcesion") { echo "selected";}?> value = "emitirResConcesion" class="sitValidacion"> Resolució de concessió enviada a firma</option>
                        	    <option <?php if ($expedientes['situacion'] === "emitidaResConcesion") { echo "selected";}?> value = "emitidaResConcesion" class="sitValidacion"> Resolució de concessió signada PENDENT de notificar</option>
                        	    <option <?php if ($expedientes['situacion'] === "notificadaResConcesion") { echo "selected";}?> value = "notificadaResConcesion" class="sitValidacion"> Resolució de concessió NOTIFICADA</option>
            		            <option <?php if ($expedientes['situacion'] === "inicioExpediente") { echo "selected";}?> value = "inicioExpediente" class="sitValidacion"> Inici expedient</option>
                            </optgroup>   
                            <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients NO favorables:">
                                <option <?php if ($expedientes['situacion'] === "emitirIDPDenProv") { echo "selected";}?> value = "emitirIDPDenProv" class="sitValidacion"> ID + P denegació provisional emetre</option>
				                <option <?php if ($expedientes['situacion'] === "emitidoIDPDenProv") { echo "selected";}?> value = "emitidoIDPDenProv" class="sitValidacion"> ID + P denegació provisional emesa</option>
    				            <option <?php if ($expedientes['situacion'] === "emitirPDenDef") { echo "selected";}?> value = "emitirPDenDef" class="sitValidacion"> P denegació definitiva emetre</option>
            		            <option <?php if ($expedientes['situacion'] === "emitidoPDenDef") { echo "selected";}?> value = "emitidoPDenDef" class="sitValidacion"> P denegació definitiva emesa</option>
            		            <option <?php if ($expedientes['situacion'] === "emitirResDen") { echo "selected";}?> value = "emitirResDen" class="sitValidacion"> Resolució de denegació emetre</option>	
                                <option <?php if ($expedientes['situacion'] === "emitidoResDen") { echo "selected";}?> value = "emitidoResDen" class="sitValidacion"> Resolució de denegació emesa</option>
                                <option <?php if ($expedientes['situacion'] === "Denegado") { echo "selected";}?> value = "Denegado" class="sitValidacion"> Denegat</option>
                            </optgroup>
                        </optgroup>
                        <optgroup style="background-color:#6d9eeb;color:#000;" label="Fase justificació pagament:">
                            <optgroup  style="background-color:#fff;color:#6d9eeb;" label="Justificació correcta:">
                                <option <?php if ($expedientes['situacion'] === "pendienteJustificar") { echo "selected";}?> value = "pendienteJustificar" class="sitEjecucion"> Pendent de justificar</option>
                		        <option <?php if ($expedientes['situacion'] === "pendienteRECJustificar") { echo "selected";}?> value = "pendienteRECJustificar" class="sitEjecucion"> Pendent SEU justificant</option>
            	    	        <option <?php if ($expedientes['situacion'] === "Justificado") { echo "selected";}?> value = "Justificado" class="sitEjecucion"> Justificat</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitirResPagoyJust") { echo "selected";}?> value = "emitirResPagoyJust" class="sitEjecucion"> Resolució de pagament i justificació emetre</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitidoResPagoyJust") { echo "selected";}?> value = "emitidoResPagoyJust" class="sitEjecucion"> Resolució de pagament i justificació emesa</option>
        	    	            <option <?php if ($expedientes['situacion'] === "Finalizado") { echo "selected";}?> value = "Finalizado" class="sitEjecucion"> Finalitzat</option>
                            </optgroup>   
                            <optgroup  style="background-color:#fff;color:#6d9eeb;" label="En cas de requeriment:">
            		            <option <?php if ($expedientes['situacion'] === "emitirReqJust") { echo "selected";}?> value = "emitirReqJust" class="sitEjecucion"> Requeriment de justificació emetre</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitidoReqJust") { echo "selected";}?> value = "emitidoReqJust" class="sitEjecucion"> Requeriment de justificació emes</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitirPropRevocacion") { echo "selected";}?> value = "emitirPropRevocacion" class="sitEjecucion"> Proposta de revocació emetre</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitidoPropRevocacion") { echo "selected";}?> value = "emitidoPropRevocacion" class="sitEjecucion"> Proposta de revocació emesa</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitirResRevocacion") { echo "selected";}?> value = "emitirResRevocacion" class="sitEjecucion"> Resolució de revocació emetre</option>
        	    	            <option <?php if ($expedientes['situacion'] === "emitidoResRevocacion") { echo "selected";}?> value = "emitidoResRevocacion" class="sitEjecucion"> Resolució de revocació emesa</option>
        	    	            <option <?php if ($expedientes['situacion'] === "revocado") { echo "selected";}?> value = "revocado" class="sitEjecucion"> Revocat</option>
                            </optgroup>                          
                        </optgroup>
			        </select>
		            </div>
                
                    <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                    <?php }
                    else {?>
                        <div class="form-group">
                            <button type="button" onclick = "javaScript: actualiza_fase_0_expediente_idi_isba('exped-fase-0');" id="send_fase_0" class="btn-itramits btn-success-itramits">Actualitzar</button>
                        </div>
                    <?php }?>
                </div>
            </div>
        </form>
    </div>    
    <div class="col docsExpediente">
        <div>  
            <input type="hidden" name="doc_requeriment_auto_ils" class="form-control" id="doc_requeriment_auto_ils" value="<?php echo $expedientes['doc_requeriment_auto_ils']; ?>">
            <!-- Documentación requerida -->
            <h3>Documentació <strong>requerida</strong> de l'expedient:</h3>
            <div class="docsExpediente">
  	            <div class = "header-wrapper-docs header-wrapper-docs-solicitud">
        	        <div>Rebut el</div>
			        <div>Document</div>
    		        <div>Tràmit</div>
			        <div>Estat</div>
			        <div>Acció</div>
  		        </div>
                <?php if($documentosDetalle){ 
                    foreach($documentosDetalle as $docs_item): 
			            $path = $docs_item->created_at;
                        $id_doc = $docs_item->id;
			            $parametro = explode ("/",$path);
			            $tipoMIME = $docs_item->type;
			            switch ($docs_item->corresponde_documento) {
                            case 'file_memoriaTecnica':
					            $nom_doc = "Descripció de l'empresa i la seva activitat, model de negoci i detall de la inversió/Inversions previstes";
					            break;
                            case 'file_document_acred_como_repres':
                                $nom_doc = "Documentació acreditativa de les facultats de representació de la persona que firma la sol·licitud d'ajut";
                                break;
				            case 'file_certificadoATIB':
					            $nom_doc = "Certificat estar al corrent de les obligacions amb la ATIB i la TGSS";
					            break;
				            case 'file_escrituraConstitucion':	
					            $nom_doc = "Còpia escriptures de constitució de l'entitat sol·licitant";
					            break;
				            case 'file_nifRepresentante':	
					            $nom_doc = "DNI/NIE de la persona sol·licitant i/o de la persona que li representi";
					            break;
                            case 'file_certificadoAEAT':	
                                $nom_doc = "Certificat d'estar al corrent de pagament amb la AEAT";
                                break;
                            case 'file_certificadoIAE':	
                                $nom_doc = "Certificat de l'IAE actualitzat en el moment de la sol·licitud";
                                break;
                            case 'file_certificadoSGR':
                                $nom_doc = "Certificat de la societat de garantia recíproca";
                                break;
                            case 'file_copiaNIF':
                                $nom_doc = "La fotocòpia del DNI de la persona que signa la sol.licitud";
                                break;
                            case 'file_certificadoLey382003':
                                $nom_doc = "Certificat que estableix l'article 13.3 bis de la Llei 38/2003";
                                break;
                            case 'file_document_veracidad_datos_bancarios':
                                $nom_doc = "Declaració responsable de la veracitat de les dades bancàries segons model CAIB";
                                break;
                            case 'file_altaAutonomos':
                                $nom_doc = "El certificat d'estar en el règim especial de treballadors autònoms o en un règim alternatiu equivalent";
                                break;
                            case 'file_contratoOperFinanc':
                                $nom_doc = "Contracte operació finançera";
                                break;
                            case 'file_avalOperFinanc':
                                $nom_doc = "Aval operació finançera";
                                break;
                            case 'file_declaracionResponsable':
                                $nom_doc = "Declaració responsable de l'empresa";
                                break;
			                default:
					            $nom_doc = "¿ ".$docs_item->corresponde_documento." ?"; 
			            } 
                    ?>
                   
  			        <div id ="fila" class = "detail-wrapper-docs general">
    				    <span id = "convocatoria" class = "detail-wrapper-docs-col date-docs-col"><?php echo str_replace ("_", "-", $docs_item->selloDeTiempo); ?></span>
				        <span id = "tipoTramite" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docs_item->name.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
      			        <span id = "fechaCompletado" class = "detail-wrapper-docs-col"><?php echo $docs_item->tipo_tramite;?></span>
                        <?php
                        switch ($docs_item->estado) {
				            case 'Pendent':
                               if ($esAdmin) {
                                    $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
                                } else {
                                    $estado_doc = '<span class = "btn btn-itramits isa_info" title="Aquesta documentació està pendent de revisió">Pendent</span>';
                                }
					            break;
    				        case 'Aprovat':
                                if ($esAdmin) {
                                    $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
                                } else {
                                    $estado_doc = '<span class = "btn btn-itramits isa_success" title="Es una documentació correcta">Aprovat</span>';
                                }
					            break;
	    			        case 'Rebutjat':
                                if ($esAdmin) {
                                    $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
                                } else {
                                    $estado_doc = '<span class = "btn btn-itramits isa_error" title="Es una documentació equivocada">Rebutjat</span>';
                                }
					            break;
                            default:
                            if ($esAdmin) {
                                $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            } else {
                                $estado_doc = '<span class = "btn btn-itramits isa_caducado" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }                            
                            }
                            ?>
                            <span id = "estado-doc-requerido" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                            <span class="detail-wrapper-docs-col">
                                <button  <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> <?php if ($docs_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: setLocalStorage (this.id, this.name);" id="<?php echo $docs_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#eliminaDocRequeridoISBA"><strong>Elimina</strong></button>
                            </span>
  			            </div>
                  
                <?php endforeach; ?>

                <div class="modal" id="eliminaDocRequeridoISBA">
			        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Atenció: aquesta acció no es podrá desfer!</h4>
                            <button type="button" class="close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
           			            <h5 class="modal-title">Eliminar definitivament aquest document?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocRequerido_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } else { 
                    echo "<div class='alert alert-warning'>Cap documentació.</div>";
                    }   
                ?>

                <button  name = "uploadRequiredISBADocument" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#uploadDocRequeridoISBA"><strong>Afegir un document</strong></button>
                <div class="modal" id="uploadDocRequeridoISBA">
			        <div class="modal-dialog">
                        <div class="modal-content" style="width:125%;">
                            <div class="modal-header">
            		            <h3>Quin tipus de document vols pujar?</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_memoriaTecnica">
                                    <label class="form-check-label" for="file_memoriaTecnica">Descripció de l'empresa i la seva activitat, model de negoci i detall de la inversió/Inversions previstes</label>
                                </div> 
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_declaracionResponsable">
                                    <label class="form-check-label" for="file_declaracionResponsable">Declaració responsable de l'empresa</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_document_acred_como_repres">
                                    <label class="form-check-label" for="file_document_acred_como_repres">Documentació acreditativa de les facultats de representació de la persona que firma la sol·licitud d'ajut</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoATIB">
                                    <label class="form-check-label" for="file_certificadoATIB">Certificat estar al corrent obligacions amb AEAT i ATIB</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_escrituraConstitucion">
                                    <label class="form-check-label" for="file_escrituraConstitucion">Còpia escriptures de constitució de l'entitat sol·licitant</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_nifRepresentante">
                                    <label class="form-check-label" for="file_nifRepresentante">DNI/NIE de la persona sol·licitant i/o de la persona que li representi</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoAEAT">
                                    <label class="form-check-label" for="file_certificadoAEAT">Certificat d'estar al corrent de pagament amb la AEAT</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoIAE">
                                    <label class="form-check-label" for="file_certificadoIAE">Documentació acreditativa alta cens IAE</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoSGR">
                                    <label class="form-check-label" for="file_certificadoSGR">Certificat de la societat de garantia recíproca</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_contratoOperFinanc">
                                    <label class="form-check-label" for="file_contratoOperFinanc">El contracte de l'operació financera</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_avalOperFinanc">
                                    <label class="form-check-label" for="file_avalOperFinanc">El contracte o document d'aval de l'operació financera</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_copiaNIF">
                                    <label class="form-check-label" for="file_copiaNIF">La fotocòpia del DNI de la persona que signa la sol.licitud</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoLey382003">
                                    <label class="form-check-label" for="file_certificadoLey382003">Certificat que estableix l'article 13.3 bis de la Llei 38/2003</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_document_veracidad_datos_bancarios">
                                    <label class="form-check-label" for="file_document_veracidad_datos_bancarios">Declaració responsable de la veracitat de les dades bancàries segons model CAIB</label>
                                </div>
                                <div class="form-check">
                                    <input onclick="activarUploadBtn(this, 'subeDocsDetalleRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_altaAutonomos">
                                    <label class="form-check-label" for="file_altaAutonomos">El certificat d'estar en el règim especial de treballadors autònoms o en un règim alternatiu equivalent</label>
                                </div>                      
                            </div>
                            <div class="modal-footer">
                                <h5 class ="upload-docs-type-label">[.pdf]:</h5>
                                <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/DetalleRequerido');?>" onsubmit="logSubmit('subeDocsDetalleRequeridoBtn')" name="subir_faseExpedDetalleRequerido" id="subir_faseExpedDetalleRequerido" method="post" accept-charset="utf-8" enctype="multipart/form-data">      
                                    <?php
                                    if ( !$esAdmin && !$esConvoActual ) {?>
                                    <?php }
                                    else {?>
                                    <div class = "content-file-upload">
                                        <div>
                                            <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedDetalleRequerido[]" id="nombrefaseExpedDetalleRequerido" size="20" accept=".pdf" multiple />
                                        </div>
                                        <div>
                                            <input type='text' class='form-control' id="selectedDocToUpload" name="selectedDocToUpload">
                                        </div>
                                        <div>
                                            <input id="subeDocsDetalleRequeridoBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" disabled/>
                                        </div>
                                    </div>
                                    <?php }?>                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>

            <!-- Documentación opcional-->
           <!--  <h3>Documentació <strong>opcional</strong> de l'expedient:</h3>
            <div class="docsExpediente">
  	                <div class = "header-wrapper-docs header-wrapper-docs-solicitud">
        	            <div>Rebut el</div>
			            <div>Document</div>
    		            <div>Tràmit</div>
			            <div>Estat</div>
                        <div>Acció</div>
  		            </div>
                    <?php if($documentosDetalle){ ?>
                        <?php foreach($documentosDetalle as $docs_opc_item): 
			                $path = $docs_opc_item->created_at;
			                $parametro = explode ("/",$path);
			                $tipoMIME = $docs_opc_item->type;
			                switch ($docs_opc_item->corresponde_documento) {
				                case 'file_copiaNIF':
					                $nom_doc = "Còpia del NIF al no autoritzar a IDI per comprobar";
					                break;
                                case 'file_resguardoREC':	
                                    $nom_doc = "Justificant de presentació pel SEU";
                                    break;
                                case 'file_DocumentoIDI':	
                                    $nom_doc = "Document pujat des-de l'IDI";
                                    break;
                                case 'file_certificadoInverECO':
                                    $nom_doc = "Certificat inversions verdes segons taxonomia europea";
                                    break;
                                case 'file_contratoOperFinanc':
                                    $nom_doc = "El contracte de l'operació financera";
                                    break;
                                case 'file_avalOperFinanc':
                                    $nom_doc = "El contracte o document d'aval de l'operació financera";
                                    break;
			                    default:
					            $nom_doc = $docs_opc_item->corresponde_documento;
			                } 
                        ?>
                        <?php if ($docs_opc_item->docRequerido == 'NO') {?>
  			            <div id ="fila" class = "detail-wrapper-docs general">
    				        <span id = "convocatoria" class = "detail-wrapper-docs-col date-docs-col"><?php echo str_replace ("_", " / ", $docs_opc_item->selloDeTiempo); ?></span>
				            <span id = "tipoTramite" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docs_opc_item->name.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
      			            <span id = "fechaCompletado" class = "detail-wrapper-docs-col"><?php echo $docs_opc_item->tipo_tramite; ?></span>
                            <?php
                            switch ($docs_opc_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docs_opc_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docs_opc_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docs_opc_item->id.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docs_opc_item->id.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                                }
                            ?>
                            <span id = "estado-doc-no-requerido" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
	        		        <span class = "detail-wrapper-docs-col">
                                <button <?php if ($docs_opc_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: setLocalStorage (this.id, this.name);" id="<?php echo $docs_opc_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#eliminaDocNoRequeridoISBA"><strong>Elimina</strong></button>
                            </span>
  			            </div>
                    <?php }?>
                    
                    <?php endforeach; ?>
                    <button  name = "uploadNotRequiredISBADocument" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#uploadDocNoRequeridoISBA"><strong>Afegir un document</strong></button>
                    <div class="modal" id="uploadDocNoRequeridoISBA">
			            <div class="modal-dialog">
                            <div class="modal-content" style="width:125%;">
                                <div class="modal-header">
                		            <h3>Quin tipus de document vols pujar?</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check">
                                        <input onclick="activarUploadBtn(this, 'subeDocsDetalleNoRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoIAE">
                                        <label class="form-check-label" for="file_certificadoIAE">Documentació acreditativa alta cens IAE</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="file_certificadoSGR">
                                        <label class="form-check-label" for="file_certificadoSGR">Certificat de la societat de garantia recíproca</label>
                                    </div>

                                    <div class="form-check">
                                        <input onclick="activarUploadBtn(this, 'subeDocsDetalleNoRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_contratoOperFinanc">
                                        <label class="form-check-label" for="file_contratoOperFinanc">El contracte de l'operació financera</label>
                                    </div>
                                    <div class="form-check">
                                        <input onclick="activarUploadBtn(this, 'subeDocsDetalleNoRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_avalOperFinanc">
                                        <label class="form-check-label" for="file_avalOperFinanc">El contracte o document d'aval de l'operació financera</label>
                                    </div>
                                    <div class="form-check">
                                        <input onclick="activarUploadBtn(this, 'subeDocsDetalleNoRequeridoBtn')" class="form-check-input" type="radio" name="flexRadioDefault" id="file_copiaNIF">
                                        <label class="form-check-label" for="file_copiaNIF">La fotocòpia del DNI de la persona que signa la sol.licitud</label>
                                    </div>                                  
                                </div>
                                <div class="modal-footer">
                                    <h5 class ="upload-docs-type-label">[.pdf]:</h5>
                                    <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/DetalleNoRequerido');?>" onsubmit="logSubmit('subeDocsDetalleNoRequeridoBtn')" name="subir_faseExpedDetalleNoRequerido" id="subir_faseExpedDetalleNoRequerido" method="post" accept-charset="utf-8" enctype="multipart/form-data">      
                                        <?php
                                            if ( !$esAdmin && !$esConvoActual ) {?>
                                        <?php }
                                        else {?>
                                        <div class = "content-file-upload">
                                            <div>
                                                <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedDetalleNoRequerido[]" id="nombrefaseExpedDetalleNoRequerido" size="20" accept=".pdf" multiple />
                                            </div>
                                            <div>
                                                <input id="subeDocsDetalleNoRequeridoBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" disabled/>
                                            </div>
                                        </div>
                                        <?php }?>                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="modal" id="eliminaDocNoRequeridoISBA">
			        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
            		            <h4>Aquesta acció no es podrá desfer</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
               			        <h5 class="modal-title">Eliminar definitivament aquest document?</h5>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocNoRequerido_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                                </div>
                        </div>
                    </div>
                </div> -->

                <div class="alert alert-dark">
                <small>Estat de la signatura de la declaració responsable i de la sol·licitud:</small>
                <?php

                	//Compruebo el estado de la firma de la declaración responsable.
                    $thePublicAccessId = $modelExp->getPublicAccessId ($expedientes['id']);
	                if (isset($thePublicAccessId))
		                {
		                    $PublicAccessId = $thePublicAccessId;
	                        $requestPublicAccessId = $PublicAccessId;
                            $request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
		                    $respuesta = json_decode ($request, true);
		                    $estado_firma = $respuesta['status'];

			                switch ($estado_firma)
				                {
				                    case 'NOT_STARTED':
				                        $estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar</div>";				
				                        break;
				                    case 'REJECTED':
				                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'warning-msg'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
				                        $estado_firma .= "</a>";				
				                        break;
				                    case 'COMPLETED':
				                        $estado_firma = "<a class='btn btn-ver-itramits' href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><i class='fa fa-check'></i>Signat";		
				                        $estado_firma .= "</a>";					
				                        break;
				                    case 'IN_PROCESS':
                                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='info-msg'><i class='fa fa-check'></i>En curs</div>";		
				                        $estado_firma .= "</a>";						
				                    default:
				                        $estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
				                }
			                echo "<br>".$estado_firma;
		                }?>
                        <br>
                        <a href="<?php echo base_url('/public/index.php/expedientes/muestradocumento/'.$expedientes['nif'].'_dec_res_solicitud_idi_isba.pdf'.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>"><small class = 'verSello' id='<?php echo $docs_item->publicAccessIdCustodiado;?>'>La declaració responsable sense signar</small></a>
            </div>                

            </div>
                
                <?php } else { 
                    echo "<div class='alert alert-warning'>Cap documentació.</div>";
                    }   
                ?>

            <div class="modal" id="eliminaDocNoRequerido">
			    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">Atenció: aquesta acció no es podrá desfer!</h4>
                        <button type="button" class="close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
    			            <h5 class="modal-title">Eliminar definitivament el document?</h5>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocNoRequerido_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div> <!-- Cierre fila Detalle -->
</div><!-- Cierre del tab Detalle -->

<div id="solicitud_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
           <form action="" onload = "javaScript: actualizaRequired();" name="exped-fase-1" id="exped-fase-1" method="post" accept-charset="utf-8">
                <div class="form-group form-floating solicitud">
                    <label for = "fecha_REC">Data SEU sol·licitud:</label>
			        <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC" class = "form-control send_fase_1" id = "fecha_REC" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC']);?>"/>
                </div>
                <div class="form-group form-floating solicitud">
                    <label for = "ref_REC">Referència SEU sol·licitud:</label>
                    <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC" class = "form-control send_fase_1" id = "ref_REC"  maxlength = "16" value = "<?php echo $expedientes['ref_REC'];?>">
                </div>
                <div class="form-group form-floating solicitud">
                    <label for = "fecha_REC_enmienda">Data SEU esmena:</label>
		    	    <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_enmienda" class = "form-control send_fase_1" id = "fecha_REC_enmienda" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_enmienda']);?>"/>
                </div>		
                <div class="form-group form-floating solicitud">
                    <label for = "ref_REC_enmienda">Referència SEU esmena:</label>
                    <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_enmienda" class = "form-control send_fase_1" id = "ref_REC_enmienda"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_enmienda'];?>">
                </div>
		        <div class="form-group form-floating solicitud">
                    <label class="label-negativo" for = "fecha_requerimiento">Firma requeriment:</label>
                    <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" disabled name = "fecha_requerimiento" class = "form-control" id = "fecha_requerimiento" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento']), 'Y-m-d');?>"/>
                    <input type = "hidden" readonly disabled name = "fecha_requerimiento_setauto" class = "form-control send_fase_1" id = "fecha_requerimiento_setauto" value = "<?php echo $expedientes['fecha_requerimiento_setauto'];?>"/>
                </div>
		        <div class="form-group form-floating solicitud">
                    <label for = "fecha_requerimiento_notif">Notificació requeriment:</label>
                    <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" name = "fecha_requerimiento_notif" onchange = "javaScript: calcularFechaMaximaEnmienda(this.value, 10);" class = "form-control send_fase_1" id = "fecha_requerimiento_notif" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento_notif']), 'Y-m-d');?>"/>
                </div>
		        <div class="form-group form-floating solicitud">
                    <label class="label-negativo" for = "fecha_requerimiento_notif">Data màxima per esmenar <small>[data notificació req + 10 dies naturals]</small>:</label>
                    <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" name = "fecha_maxima_enmienda" disabled readonly class = "form-control" id = "fecha_maxima_enmienda" value = "<?php echo date_format(date_create($expedientes['fecha_maxima_enmienda']), 'Y-m-d');?>"/>
                </div>
                <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class="form-group">
                        <button type="button" onclick = "javaScript: actualiza_fase_1_solicitud_expediente_idi_isba('exped-fase-1');" id="send_fase_1" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>    
            </form>
        </div>
        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start ="1">
            <!----------------------------------------- Requeriment DOC 1 -------------------------------------------------->
	        <li><?php include $_SERVER['DOCUMENT_ROOT'].'/app/Views/pages/forms/modDocs/IDI-ISBA/requerimiento.php';?></li>
            <!-------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Resolució DOC 2 ---------------------------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'].'/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-desestimiento-por-no-enmendar.php';?></li>
            <!-------------------------------------------------------------------------------------------------------------->
            </ol>
            <h3>Millores: <!-- <small class="alert alert-secondary" role="alert"><?php echo $ultimaMejoraSolicitud; ?></small> --></h3>
            <?php if($mejorasSolicitud): ?>
                <div class = "header-wrapper-docs-3 header-wrapper-docs-solicitud">
        	        <div >Data SEU</div>
   	  	            <div >Referència SEU</div>
   	  	            <div >Acciò</div>
                </div>
               
                <div class='filas-container'>
                    <?php foreach($mejorasSolicitud as $mejorasSolicitud_item):?>
                        <div id ="mejora_<?php echo $mejorasSolicitud_item['id'];?>" class = "detail-wrapper-docs-3 detail-wrapper-docs-solicitud">
                            <span class = "detail-wrapper-docs-col"><?php echo $mejorasSolicitud_item['fecha_rec_mejora'] ;?></span>
                            <span class = "detail-wrapper-docs-col"><?php echo $mejorasSolicitud_item['ref_rec_mejora'] ;?></span>
                            <span class = "detail-wrapper-docs-col trash"><?php echo '<button onclick = "javaScript: setLocalStorage (this.id, this.name);" id="'.$mejorasSolicitud_item['id'].'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target="#modalEliminaMejora"><i class="bi bi-trash-fill" style="font-size: 1.5rem; color: red;"></i></button>';?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!$mejorasSolicitud): ?>
              <div class="alert alert-info" role="alert">De moment, no hi ha millores!</div>
            <?php endif; ?>
            <div style="margin-top:1rem;color:blue;text-align:left;padding:.5rem;">
                <div class="mb-3">
                    <input type='datetime-local' title = "dd/mm/aaaa hh:mm:ss" name = "fechaRecMejora" class='form-control form-control-sm' id="fechaRecMejora"/>
                </div>
                <div class="mb-3">
                    <input type='text' placeholder = "El número del SEU [GOIBE539761_2021]" name = "refRecMejora" class='form-control form-control-sm' id="refRecMejora" maxlength = "16"/>
                </div>
                    <button class="btn-itramits btn-success-itramits btn-lg btn-block btn-docs" <?php echo $isDisabled;?> onclick="insertaMejoraEnSolicitud()" id="addMejora">Afegir</button>
            </div>
        </div>
        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs-4 header-wrapper-docs-solicitud">
        	        <div >Pujat el</div>
   	  	            <div >Document</div>
                    <div >Estat</div>                         
      	            <div >Acció</div>
                </div>
                <?php if($documentos): ?>
                <?php foreach($documentos as $docSolicitud_item): 
			                if($docSolicitud_item->fase_exped == 'Solicitud') {
    			                $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
	    		                $parametro = explode ("/",$path);
		    	                $tipoMIME = $docSolicitud_item->type;
			                    $nom_doc = $docSolicitud_item->name;
			                ?>
                            <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-solicitud-isba">
          	                    <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
       		                    <span id = "convocatoria" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>" href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                                   <?php
                            switch ($docSolicitud_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id."#".$docSolicitud_item->tipo_tramite.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id."#".$docSolicitud_item->tipo_tramite.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id."#".$docSolicitud_item->tipo_tramite.'" class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id."#".$docSolicitud_item->tipo_tramite.'" class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                            <span class = "detail-wrapper-docs-col">
                                <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: setLocalStorage (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocSolicitud"><strong>Elimina</strong></button>
                            </span>
	                        </div>
                        <?php 
                            }
                     endforeach; ?>
                <?php endif; ?>
            </div>

                <div id="myModalDocSolicitud" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Atenció: aquesta acció no es podrá desfer!</h4>
                            <button type="button" class="close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body"> 
    		            		<h5 class="modal-title">Eliminar definitivament el document?</h5>
                                <div class="modal-footer">
		                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocSolicitud_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  

                <h5 class ="upload-docs-type-label">[.pdf, .zip]:</h5>
                <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Solicitud');?>" onsubmit="logSubmit('subeDocsSolicitudBtn')" name="subir_faseExpedSolicitud" id="subir_faseExpedSolicitud" method="post" accept-charset="utf-8" enctype="multipart/form-data">      
                <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class = "content-file-upload">
                        <div>
                            <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedSolicitud[]" id="nombrefaseExpedSolicitud" size="20" accept=".pdf, .zip" multiple />
                        </div>
                        <div>
                            <input id="subeDocsSolicitudBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                        </div>
                    </div>
                <?php }?>                    
                </form>
        </div><!-- Cierre de la columna de documentos -->
        </div> 
    </div><!-- Cierre de la fila -->
</div><!-- Cierre del tab Solicitud -->

<div id="validacion_tab" class="tab_fase_exp_content">
    <div class="row">
    <div class="col-sm-2 docsExpediente">
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-2" id="exped-fase-2" method="post" accept-charset="utf-8">
            <div class="form-group form-floating validacion">
                <label for = "fecha_infor_fav_desf">Firma informe favorable / desfavorable:</label>
		        <input type = "date" name = "fecha_infor_fav_desf" class = "form-control send_fase_2" id = "fecha_infor_fav_desf" value = "<?php echo date_format(date_create($expedientes['fecha_infor_fav_desf']), 'Y-m-d');?>">
            </div>
		    <div class="form-group form-floating validacion">
                <label for = "fecha_firma_propuesta_resolucion_prov">Firma proposta resolució provisional:</label>
                <input type = "date" name = "fecha_firma_propuesta_resolucion_prov" class = "form-control send_fase_2" id = "fecha_firma_propuesta_resolucion_prov" value = "<?php echo date_format(date_create($expedientes['fecha_firma_propuesta_resolucion_prov']), 'Y-m-d');?>">
            </div>
		    <div class="form-group form-floating validacion">
                <label for = "fecha_not_propuesta_resolucion_prov">Notificació proposta resolució provisional:</label>
                <input type = "date" name = "fecha_not_propuesta_resolucion_prov" onchange = "javaScript: cambiarSituacionExpediente('send_fase_2', this.id);" class = "form-control send_fase_2" id = "fecha_not_propuesta_resolucion_prov" value = "<?php echo date_format(date_create($expedientes['fecha_not_propuesta_resolucion_prov']), 'Y-m-d');?>">
            </div>
            
		    <div class="form-group form-floating validacion">
                <label class="label-negativo" for = "fecha_firma_propuesta_resolucion_def">Firma proposta resolució definitiva <small>[Al firmar la PR definitiva]</small>:</label>
                <input type = "date" disabled name = "fecha_firma_propuesta_resolucion_def" class = "form-control" id = "fecha_firma_propuesta_resolucion_def" value = "<?php echo date_format(date_create($expedientes['fecha_firma_propuesta_resolucion_def']), 'Y-m-d');?>">
                <input type = "hidden" readonly disabled name = "fecha_firma_propuesta_resolucion_def_setauto" class = "form-control send_fase_1" id = "fecha_firma_propuesta_resolucion_def_setauto" value = "<?php echo $expedientes['fecha_firma_propuesta_resolucion_def_setauto'];?>"/>
            </div>
		    <div class="form-group form-floating validacion">
                <label for = "fecha_not_propuesta_resolucion_def">Notificació proposta resolució definitiva:</label>
                <input type = "date" name = "fecha_not_propuesta_resolucion_def" class = "form-control send_fase_2" id = "fecha_not_propuesta_resolucion_def" value = "<?php echo date_format(date_create($expedientes['fecha_not_propuesta_resolucion_def']), 'Y-m-d');?>">
            </div>                
		    <div class="form-group form-floating validacion">
                <label for = "fecha_firma_res">Firma resolució:</label>
                <input type = "date" name = "fecha_firma_res" class = "form-control send_fase_2" id = "fecha_firma_res" value = "<?php echo date_format(date_create($expedientes['fecha_firma_res']), 'Y-m-d');?>">
            </div>
                <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class="form-group">
                        <button type="button"  onclick = "javaScript: actualiza_fase_2_validacion_expediente_idi_isba('exped-fase-2');" id="send_fase_2" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>                  
        </form>
        </div>        
    	    
        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="3">
            <!----------------------------------------Informe favorable --------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/informe-favorable-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe favorable amb requeriment------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/informe-favorable-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució provisional---------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-provisional.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució provisional amb requeriment--------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-provisional-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució definitiva----------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-definitiva.php';?></li> 
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució definitiva amb requeriment----------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-definitiva-con-requerimiento.php';?></li>  
            <!------------------------------------------------------------------------------------------------------>            
            <!----------------------------------------- Resolución de concesión ---------------------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-concesion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Resolución de concesión amb requeriment------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-concesion-con-requerimiento.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
        </ol>
        </div>
        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs-4 header-wrapper-docs-solicitud">
    	            <div >Pujat el</div>
   	  	            <div >Document</div>
		            <div >Estat</div>                     
      	            <div >Acció</div>
                </div>
            <?php if($documentos): ?>
            <?php foreach($documentos as $docSolicitud_item): 			            
                if($docSolicitud_item->fase_exped == 'Adhesion') {
			        $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			        $parametro = explode ("/",$path);
			        $tipoMIME = $docSolicitud_item->type;
			        $nom_doc = $docSolicitud_item->name;?>

                    <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-validacion-ils">
      	                <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
   		                <span id = "convocatoria" class = "detail-wrapper-docs-col"><a	title="<?php echo $nom_doc;?>" href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                           <?php
                            switch ($docSolicitud_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                            <span class = "detail-wrapper-docs-col">
                                <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: setLocalStorage (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocValidacion"><strong>Elimina</strong></button>
                            </span>
	                </div>
                <?php }
                endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="myModalDocValidacion" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Atenció: aquesta acció no es podrá desfer!</h4>
                            <button type="button" class="close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
    			            <h5 class="modal-title">Eliminar definitivament el document?</h5>
                        </div>
                        <div class="modal-footer">
    		                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                            <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocValidacion_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                        </div>
                    </div>
                </div>
            </div>  	
            <h5 class ="upload-docs-type-label">[.pdf]:</h5>
            <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Adhesion');?>" onsubmit="logSubmit('subeDocsValidacionBtn')" name="subir_doc_faseExpedValidacion" id="subir_doc_faseExpedValidacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
 
            <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class = "content-file-upload">
                    <div>
                        <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedAdhesion[]" id="nombrefaseExpedAdhesion" size="20" accept=".pdf" multiple />
                    </div>
                    <div>
                        <input id="subeDocsValidacionBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                    </div>
                </div>
                <?php }?>
            </form> 
        </div> <!--Cierre columna documentos-->
            </div>
    </div><!--Cierre de la fila-->
</div><!--Cierre del tab Validación-->

<div id="justificacion_tab" class="tab_fase_exp_content"> <!-- RENOVACIÓN -->
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-4" id="exped-fase-4" method="post" accept-charset="utf-8">
            <div class="row">
            <div class="col">
            <div class="form-group form-floating justificacion">
            <label for = "fecha_notificacion_resolucion">Notificació resolució:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" name = "fecha_notificacion_resolucion" class = "form-control send_fase_4" id = "fecha_notificacion_resolucion" onchange = "javaScript: setFechaLimiteJustificacion(this.value, 6);" value = "<?php echo date_format(date_create($expedientes['fecha_notificacion_resolucion']), 'Y-m-d');?>">
            </div>
            <div class="form-group form-floating justificacion">
            <label class="label-negativo" for = "fecha_limite_justificacion">Data límit per justificar:</label>
            <span class="form-control send_fase_3 ocultar" id="nueva_fecha_limite_justificacion"></span>
            <input disabled readonly type = "date" name = "fecha_limite_justificacion" class = "form-control" onchange = "javaScript: cambiarSituacionExpediente('send_fase_4', this.id)" id = "fecha_limite_justificacion" value = "<?php echo date_format(date_create($expedientes['fecha_limite_justificacion']), 'Y-m-d');?>">
            </div>
            <div class="form-group justificacion">
            <label class="label-negativo" for = "fecha_REC_justificacion"><strong>Data SEU justificació:</strong></label>
			<input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_justificacion" class = "form-control send_fase_4" id = "fecha_REC_justificacion" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_justificacion']);?>" />
            </div>	
		    <div class="form-group form-floating justificacion">
            <label for = "ref_REC_justificacion">Referència SEU justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_justificacion" class = "form-control send_fase_4" id = "ref_REC_justificacion"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_justificacion'];?>">
        	</div>
            <div class="form-group form-floating justificacion">
            <label for = "fecha_firma_res_pago_just">Firma resolució de pagament i justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" placeholder = "dd/mm/yyyy" name = "fecha_firma_res_pago_just" class = "form-control send_fase_4" id = "fecha_firma_res_pago_just" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_firma_res_pago_just']), 'Y-m-d');?>">
            </div>
		    <div class="form-group form-floating justificacion">
            <label for = "fecha_not_res_pago">Notificació resolució de pagament i justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" placeholder = "dd/mm/yyyy" name = "fecha_not_res_pago" class = "form-control send_fase_4" id = "fecha_not_res_pago" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_not_res_pago']), 'Y-m-d');?>">
            </div>

            <div class="form-group form-floating justificacion">
            <label for = "fecha_inf_inicio_req_justif">Informe inici requeriment justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" placeholder = "dd/mm/yyyy" name = "fecha_inf_inicio_req_justif" class = "form-control send_fase_4" id = "fecha_inf_inicio_req_justif" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_inf_inicio_req_justif']), 'Y-m-d');?>">
            </div>
		    <div class="form-group form-floating justificacion">
            <label for = "fecha_inf_post_enmienda_justif">Informe post esmena justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" placeholder = "dd/mm/yyyy" name = "fecha_inf_post_enmienda_justif" class = "form-control send_fase_4" id = "fecha_inf_post_enmienda_justif" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_inf_post_enmienda_justif']), 'Y-m-d');?>">
            </div>  

		    <div class="form-group form-floating justificacion">
            <label for = "fecha_firma_requerimiento_justificacion">Firma requeriment justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" placeholder = "dd/mm/yyyy" name = "fecha_firma_requerimiento_justificacion" class = "form-control send_fase_4" id = "fecha_firma_requerimiento_justificacion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_firma_requerimiento_justificacion']), 'Y-m-d');?>">
            </div>
		    <div class="form-group form-floating justificacion">
            <label for = "fecha_not_req_just">Notificació requeriment de justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "date" placeholder = "dd/mm/yyyy" name = "fecha_not_req_just" class = "form-control send_fase_4" id = "fecha_not_req_just" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_not_req_just']), 'Y-m-d');?>">
            </div>            
            <div class="form-group form-floating justificacion">
            <label for = "fecha_REC_requerimiento_justificacion">Data SEU requeriment justificació:</label>
			<input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "fecha_REC_requerimiento_justificacion" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_requerimiento_justificacion']);?>" />
            </div>	
		    <div class="form-group form-floating justificacion">
            <label for = "ref_REC_requerimiento_justificacion">Referència SEU requeriment justificació:</label>
            <input <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "ref_REC_requerimiento_justificacion"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_requerimiento_justificacion'];?>">
        	</div>
                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                    <div class="form-group">
                        <button <?php if($session->get('rol') === 'adr-isba') { echo 'disabled';}?> type="button"  onclick = "javaScript: actualiza_fase_4_justificacion_expediente_idi_isba('exped-fase-4');" id="send_fase_4" onChange="avisarCambiosEnFormulario('send_fase_4', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>
            
            </div>
            </div>
        </form>
        </div>
        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="11">
            <!----------------- Resolución de pago sin requerimiento  DOC 11 FIRMA D GERENTE ------------------>
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-de-pago-y-justificacion.php';?></li>
            <!------------------------------------------------------------------------------------------------->                  
        </ol>        
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs-4 header-wrapper-docs-solicitud">
                    <div >Pujat el</div>
                    <div >Document</div>
                    <div >Estat</div>               
                    <div >Acció</div>
                </div>
                <?php if($documentos): ?>
                    <?php foreach($documentos as $docSolicitud_item): 			            
                            if($docSolicitud_item->fase_exped == 'Justificacion') {
                                $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
                                $parametro = explode ("/",$path);
                                $tipoMIME = $docSolicitud_item->type;
                                $nom_doc = $docSolicitud_item->name;
                    ?>
                    <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-justificacion">
                        <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
                        <span id = "convocatoria" class = "detail-wrapper-docs-col"><a	title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                        <?php
                            switch ($docSolicitud_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                        <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                        <span class = "detail-wrapper-docs-col">
                            <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocJustificacion"><strong>Elimina</strong></button>
                        </span>
                    </div>
                <?php }
                    endforeach; ?>
                <?php endif; ?>

                <div id="myModalDocJustificacion" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Atenció: aquesta acció no es podrá desfer!</h4>
                            <button type="button" class="close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="modal-title">Eliminar definitivament aquest document?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocJustificacion_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class ="upload-docs-type-label">[.zip]:</h5>
                <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Justificacion');?>" onsubmit="logSubmit('subeDocsJustificacionBtn')" name="subir_doc_faseExpedRenovacion" id="subir_doc_faseExpedRenovacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <?php
                        if ( !$esAdmin && !$esConvoActual ) {?>
                    <?php }
                        else {?>
                        <div class = "content-file-upload">
                            <div>
                                <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedJustificacion[]" id="file_faseExpedJustificacion" size="20" accept=".zip" multiple />
                            </div>
                            <div>
                                <input id="subeDocsJustificacionBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                            </div>
                        </div>
                    <?php }?>
                </form>             
            </div>
        </div>
        <div class="col docsExpediente">
            <h3>Justificants:</h3>
            <div class="accordion " id="accordionJustificacionISBA">
                <div class="accordion-item" style="border:1px solid red;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tab_mem_econ_isba" aria-expanded="true" aria-controls="tab_mem_econ_isba">
                            <?php echo lang('message_lang.justificacion_mem_econom_isba');?>
                        </button>
                    </h2>
                    <div id="tab_mem_econ_isba" class="accordion-collapse collapse show" data-bs-parent="#accordionJustificacionISBA">
                    <div class = "header-wrapper-docs-justificacion">
  	                    <div>Rebut el</div>
   	                    <div>Document</div>
	                    <div>Estat</div>
                    </div>
	                <?php if($documentosMemoriaEconomIsba): 
                    foreach($documentosMemoriaEconomIsba as $docsJustif_item): 
			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $parametro = explode ("/",$path);
			            $tipoMIME = $docsJustif_item->type;
			            $nom_doc = $docsJustif_item->name;?>
  	                    <div id ="fila" class = "detail-wrapper-docs-justificacion-justificantes">
      	                    <span id = "convocatoria" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " ", $docsJustif_item->selloDeTiempo); ?></span>	
   		                    <span id = "fechaComletado" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docsJustif_item->name.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');?>" target = "_self"><?php echo $nom_doc;?></a></span>
                           <?php
                            switch ($docsJustif_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?> 
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tab_mem_actividades" aria-expanded="true" aria-controls="tab_mem_actividades">
                            <?php echo lang('message_lang.justificacion_memoria_actividades_isba');?>
                        </button>
                    </h2>
                    <div id="tab_mem_actividades" class="accordion-collapse collapse show"  data-bs-parent="#accordionJustificacionISBA">
                    <div class = "header-wrapper-docs-justificacion">
  	                    <div>Rebut el</div>
   	                    <div>Document</div>
	                    <div>Estat</div>
                    </div>
	                <?php if($documentosMemoriaActividadesIsba): 
                    foreach($documentosMemoriaActividadesIsba as $docsJustif_item): 
			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $parametro = explode ("/",$path);
			            $tipoMIME = $docsJustif_item->type;
			            $nom_doc = $docsJustif_item->name;?>
  	                    <div id ="fila" class = "detail-wrapper-docs-justificacion-justificantes">
      	                    <span id = "convocatoria" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " ", $docsJustif_item->selloDeTiempo); ?></span>	
   		                    <span id = "fechaComletado" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docsJustif_item->name.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');?>" target = "_self"><?php echo $nom_doc;?></a></span>
                           <?php
                            switch ($docsJustif_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?> 
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tab_facturas" aria-expanded="false" aria-controls="tab_facturas">
                            <?php echo lang('message_lang.justificacion_facturas_isba');?>
                        </button>
                    </h2>
                    <div id="tab_facturas" class="accordion-collapse collapse show"  data-bs-parent="#accordionJustificacionISBA">
                    <div class = "header-wrapper-docs-justificacion">
  	                    <div>Rebut el</div>
   	                    <div>Document</div>
	                    <div>Estat</div>
                    </div>
                    <?php if($documentosFacturasEmitidasIsba): ?>
                    <?php foreach($documentosFacturasEmitidasIsba as $docsJustif_item):

			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $tipoMIME = $docsJustif_item->type;
			            $nom_doc = $docsJustif_item->name;
			            ?>
  	                    <div id ="fila" class = "detail-wrapper-docs-justificacion-justificantes">
      	                <span id = "convocatoria" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " ", $docsJustif_item->selloDeTiempo); ?></span>	
   		                <span id = "fechaComletado" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>" href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docsJustif_item->name.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');?>" target = "_self"><?php echo $nom_doc;?></a></span>

                           <?php
                            switch ($docsJustif_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
	                </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tab_pagos" aria-expanded="false" aria-controls="tab_pagos">
                            <?php echo lang('message_lang.justificacion_justificantes_pago_isba');?>
                        </button>
                    </h2>
                    <div id="tab_pagos" class="accordion-collapse collapse show"  data-bs-parent="#accordionJustificacionISBA">
                    <div class = "header-wrapper-docs-justificacion">
		                <div >Rebut el</div>
   		                <div >Document</div>
		                <div >Estat</div>   
                    </div>
                    <?php if($documentosJustificantesPagoIsba): ?>
                    <?php foreach($documentosJustificantesPagoIsba as $docsJustif_item): ?>
			            <?php 
			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $tipoMIME = $docsJustif_item->type;
			            $nom_doc = $docsJustif_item->name;
    			        ?>

                        <div id ="fila" class = "detail-wrapper-docs-justificacion-justificantes">
                        <span id = "convocatoria" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " ", $docsJustif_item->selloDeTiempo); ?></span>	     
   		                <span id = "fechaComletado" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docsJustif_item->name.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');?>" target = "_self"><?php echo $nom_doc;?></a></span>

                           <?php
                            switch ($docsJustif_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
		            </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tab_declaracion_isba" aria-expanded="false" aria-controls="tab_declaracion_isba">
                            <?php echo lang('message_lang.justificacion_declaracion_isba_sgr');?>
                        </button>
                    </h2>
                    <div id="tab_declaracion_isba" class="accordion-collapse collapse show"  data-bs-parent="#accordionJustificacionISBA">
                    <div class = "header-wrapper-docs-justificacion">
		                <div >Rebut el</div>
   		                <div >Document</div>
		                <div >Estat</div>   
                    </div>
                    <?php if($documentosDeclaracionIsba): ?>
                    <?php foreach($documentosDeclaracionIsba as $docsJustif_item): ?>
			            <?php
			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $tipoMIME = $docsJustif_item->type;
			            $nom_doc = $docsJustif_item->name;
			            ?>

                    <div id ="fila" class = "detail-wrapper-docs-justificacion-justificantes">
                        <span id = "convocatoria" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " ", $docsJustif_item->selloDeTiempo); ?></span>	     
   		                <span id = "fechaComletado" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docsJustif_item->name.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');?>" target = "_self"><?php echo $nom_doc;?></a></span>

                           <?php
                            switch ($docsJustif_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button  id="'.$docsJustif_item->id.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDocJustificacion(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
		            </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <div><a href="<?php echo base_url('public/index.php/home/set_lang_justific/ca').'/'.$expedientes['id'].'/'.$expedientes['nif'].'/'.$expedientes['tipo_tramite'].'/'.$expedientes['convocatoria'].'/ca';?>" target = "_blank">Formulari de requeriment de justificació</a></div>
            <div><a href="<?php 
                if (isset($selloDeTiempo)) {
                    echo base_url('public/index.php/expedientes/muestradocumento/'.$expedientes['nif'].'_justificacion_solicitud_ayuda.pdf'.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');
                }
            ?>" target = "_blank">Mostrar la declaració responsable de la justificació sense signar</a>
            </div>
            <div class="alert alert-info">
                <small>Estat de la declaració responsable de la justificació</small>
                <?php
                	//Compruebo el estado de la firma de la declaración responsable.
                    $thePublicAccessId = $modelJustificacion->getPublicAccessId ($expedientes['id']);
	                if (isset($thePublicAccessId))
		                {
		                    $PublicAccessId = $thePublicAccessId;
	                        $requestPublicAccessId = $PublicAccessId;
                            $request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
		                    $respuesta = json_decode ($request, true);
		                    $estado_firma = $respuesta['status'];

			                switch ($estado_firma)
				                {
				                    case 'NOT_STARTED':
				                        $estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar</div>";				
				                        break;
				                    case 'REJECTED':
				                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'warning-msg'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
				                        $estado_firma .= "</a>";				
				                        break;
				                    case 'COMPLETED':
				                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class = 'success-msg'><i class='fa fa-check'></i>Signada</div>";		
				                        $estado_firma .= "</a>";					
				                        break;
				                    case 'IN_PROCESS':
                                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='info-msg'><i class='fa fa-check'></i>En curs</div>";		
				                        $estado_firma .= "</a>";						
				                    default:
				                        $estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
				                }
			                echo $estado_firma;
		                }?>
            </div>
        </div>
    </div>

</div>

<div id="deses_ren_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>"  name="exped-fase-5" id="exped-fase-5" method="post" accept-charset="utf-8">
            <div class="form-group desistimiento">
                <label class="label-negativo" for = "fecha_REC_desestimiento">Data SEU desistiment:</label>
	    	    <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_desestimiento" class = "form-control send_fase_5" id = "fecha_REC_desestimiento" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_desestimiento']);?>"/>
            </div>
		    <div class="form-group form-floating desistimiento">
                <label for = "ref_REC_desestimiento">Referència SEU desistiment:</label>
                <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" maxlength = "16" name = "ref_REC_desestimiento" class = "form-control send_fase_5" id = "ref_REC_desestimiento" value = "<?php echo $expedientes['ref_REC_desestimiento'];?>">
        	</div>
	    	<div class="form-group form-floating desistimiento">
                <label for = "fecha_firma_resolucion_desestimiento">Data firma resolució de desistiment:</label>
                <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_firma_resolucion_desestimiento" class = "form-control send_fase_5" id = "fecha_firma_resolucion_desestimiento" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_firma_resolucion_desestimiento']), 'Y-m-d');?>">
            </div>
		    <div class="form-group form-floating desistimiento">
                <label for = "fecha_notificacion_desestimiento">Data notificació desistiment:</label>
                <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_notificacion_desestimiento" class = "form-control send_fase_5" id = "fecha_notificacion_desestimiento" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_notificacion_desestimiento']), 'Y-m-d');?>">
            </div>
            <div class="form-group form-floating desistimiento">
                <label for = "fecha_propuesta_rev">Proposta de Resolució de Revocació:</label>
                <input type = "date" placeholder = "dd/mm/yyyy" name = "fecha_propuesta_rev" class = "form-control send_fase_5" id = "fecha_propuesta_rev"  maxlength = "16" value = "<?php echo $expedientes['fecha_propuesta_rev'];?>">
        	</div>
            <div class="form-group form-floating desistimiento">
                <label for = "fecha_resolucion_rev">Resolució de revocació:</label>
                <input type = "date" placeholder = "dd/mm/yyyy" name = "fecha_resolucion_rev" class = "form-control send_fase_5" id = "fecha_resolucion_rev"  maxlength = "16" value = "<?php echo $expedientes['fecha_resolucion_rev'];?>">
        	</div>

            <div class="form-group form-floating desistimiento">
                <label for = "fecha_not_pr_revocacion">Notificació Proposta de Resolució de Revocació:</label>
                <input type = "date" placeholder = "dd/mm/yyyy" name = "fecha_not_pr_revocacion" class = "form-control send_fase_5" id = "fecha_not_pr_revocacion"  maxlength = "16" value = "<?php echo $expedientes['fecha_not_pr_revocacion'];?>">
        	</div>
            <div class="form-group form-floating desistimiento">
                <label for = "fecha_not_r_revocacion">Notificació Resolució de revocació:</label>
                <input type = "date" placeholder = "dd/mm/yyyy" name = "fecha_not_r_revocacion" class = "form-control send_fase_5" id = "fecha_not_r_revocacion"  maxlength = "16" value = "<?php echo $expedientes['fecha_not_r_revocacion'];?>">
        	</div>

                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                <div class="form-group">
                    <button type="button" onclick = "javaScript: actualiza_fase_5_desestimiento_expediente_idi_isba('exped-fase-5');" id="send_fase_5" onchange="avisarCambiosEnFormulario('send_fase_5', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                </div>
                <?php }?>
            </form>
        </div>

        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start="15">
                <!----------------------------------------- Reseolución desestimiento  DOC 15 -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-desestimiento-por-renuncia.php';?></li>
                <!------------------------------------------------------------------------------------------------->
                <!----------------- Propuesta resolución revocación por no justificar  DOC 16 -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-revocacion-por-no-justificar.php';?></li>
                <!------------------------------------------------------------------------------------------------->
                <!----------------- Resolución revocación por no justificar  DOC 17 ------------------>
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-revocacion-por-no-justificar.php';?></li>
                <!------------------------------------------------------------------------------------------------->
            </ol>
        </div>

        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <h4 class="alert alert-danger" role="alert">No pujar actes administratius signats!!!</h4>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs-4 header-wrapper-docs-solicitud">
    	            <div>Pujat el</div>
   	  	            <div>Document</div>
   	  	            <div>Estat</div>
      	            <div>Acció</div>
                </div>

            <?php if($documentos): ?>
            <?php foreach($documentos as $docSolicitud_item): 			            
                if($docSolicitud_item->fase_exped == 'Desestimiento') {
			    $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			    $parametro = explode ("/",$path);
			    $tipoMIME = $docSolicitud_item->type;
			    $nom_doc = $docSolicitud_item->name;
			    ?>
                <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-desestimiento">
      	            <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
   		            <span id = "convocatoria" class = "detail-wrapper-docs-col"><a	title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                    <?php
                    switch ($docSolicitud_item->estado) {
				        case 'Pendent':
    			            $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					        break;
    				    case 'Aprovat':
    					    $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
					        break;
	    			    case 'Rebutjat':
    					    $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					        break;
                        default:
    					    $estado_doc = '<button  id="'.$docSolicitud_item->id.'" class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                    }
                    ?>
                    <span id = "estado" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                    <span class = "detail-wrapper-docs-col trash">
                        <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: setLocalStorage (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocDesestimiento"><i class="bi bi-trash-fill" style="font-size: 1.5rem; color: red;"></i></button>
                    </span> 
                </div>
            <?php }
            endforeach; ?>
            <?php endif; ?>
            </div>
                <div id="myModalDocDesestimiento" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style = "width: 60%;">
                        <div class="modal-header">
                        <h4 class="modal-title">Atenció: aquesta acció no es podrá desfer!</h4>
                        <button type="button" class="close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
    	    		        <h5 class="modal-title">Eliminar definitivament el document?</h5>
                            <div class="modal-footer">
    		                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocDesestimiento_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            <h5 class ="upload-docs-type-label">[.pdf, .zip]:</h5>
            <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Desestimiento');?>" onsubmit="logSubmit('subeDocsDesestimientoBtn')" name="subir_doc_faseExpedDesestimiento" id="subir_doc_faseExpedDesestimiento" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                
                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                <div class = "content-file-upload">
                    <div>
                        <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedDesestimiento[]" id="nombrefaseExpedDesestimiento" size="20" accept=".pdf, .zip" multiple />
                    </div>
                    <div>
                        <input id="subeDocsDesestimientoBtn" type="submit" class = "btn-itramits btn-success-itramits btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                    </div>
                </div>
                <?php }?>

            </form>             
        </div>
    </div>
</div>

<style>
    .content-file-upload {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 15px;
        grid-auto-rows: minmax(50%, 50%);
    }

    .accordion-exped {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 1.4rem;
        font-weight: bold;
        transition: 0.4s;
    }

    .accordion-exped:hover {
        font-weight: normal;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .panel-exped {
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }
</style>

<script>
    if (<?php echo $totalDocsMemoriaEconomIsba;?> === 0) {
    	document.getElementById("tab_mem_econ_isba").classList.add ("warning-msg-justific");
    }
    else
    {
    	document.getElementById("tab_mem_econ_isba").classList.add ("success-msg-justific");
    }

    if (<?php echo $totalDocsMemoriaActividadesIsba;?> === 0) {
    	document.getElementById("tab_mem_actividades").classList.add ("warning-msg-justific");
    }
    else
    {
    	document.getElementById("tab_mem_actividades").classList.add ("success-msg-justific");
    }

    if (<?php echo $totalDocsFacturasEmitidasIsba;?> === 0) {
    	document.getElementById("tab_facturas").classList.add ("warning-msg-justific");
    }
    else
    {
    	document.getElementById("tab_facturas").classList.add ("success-msg-justific");
    }

    if (<?php echo $totalDocsJustificantesPagoIsba;?> === 0) {
    	document.getElementById("tab_pagos").classList.add ("warning-msg-justific");
    }
    else
    {
	    document.getElementById("tab_pagos").classList.add ("success-msg-justific");
    }

    if (<?php echo $totalDocsDeclaracionIsba;?> === 0) {
    	document.getElementById("tab_declaracion_isba").classList.add ("warning-msg-justific");
    }
    else
    {
	    document.getElementById("tab_declaracion_isba").classList.add ("success-msg-justific");
    }
</script>

<script>
    var acc = document.getElementsByClassName("accordion-exped ");
    var i;
    
    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        } 
    });
    }
</script>

<script>
    function getCookie(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for(var i = 0; i <ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
                }
                return "";
    }
</script> 

<script>
    function justificacion_docs_IDI_click (id, nombre) {
        document.cookie = "documento_actual = " + id;
        console.log (id);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="text/javascript" src="/public/assets/js/edita-expediente-isba.js"></script>
<script src="https://kit.fontawesome.com/1a19d0e4f2.js" crossorigin="anonymous"></script>