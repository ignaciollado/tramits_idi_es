<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/public/assets/css/style-idi-isba.css"/>
<?php
    use App\Models\DocumentosGeneradosModel;
    use App\Models\MejorasExpedienteModel;
    use App\Models\ExpedientesModel;

    $modelDocumentosGenerados = new DocumentosGeneradosModel();
    $modelMejorasSolicitud = new MejorasExpedienteModel();
    $modelExp = new ExpedientesModel();

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
?>

    <!---------------------- Para poder consultar en VIAFIRMA el estado de los modelos de los actos administrativos ------->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/execute-curl.php';?>
    <!--------------------------------------------------------------------------------------------------------------------->

<div class="tab_fase_exp">
    <button id="detall_tab_selector" class="tablinks" onclick="openFaseExped(event, 'detall_tab', ' #ccc', <?php echo $expedientes['id'];?>)">Detall</button>  
    <button id="solicitud_tab_selector" class="tablinks" onclick="openFaseExped(event, 'solicitud_tab', '#f6b26b', <?php echo $expedientes['id'];?>)">Sol·licitud</button>
    <button id="validacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'validacion_tab', '#b23cfd', <?php echo $expedientes['id'];?>)">Validació</button>
    <button id="justifiacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'justificacion_tab', '#a64d79', <?php echo $expedientes['id'];?>)">Justificació</button>
    <button id="deses_ren_tab_selector" class="tablinks" onclick="openFaseExped(event, 'deses_ren_tab', '#8e7cc3')">Desistiment o renúncia</button>
</div>

<?php echo "Data sol·licitud: ". $expedientes['fecha_solicitud'];?> <?php echo "Data complert: ". $expedientes['fecha_completado'];?>

<div id="detall_tab" class="tab_fase_exp_content" style="display:block;" onload="javaScript:alert(id);">
    <div class="row">
        <div class="col docsExpediente">
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" name="exped-fase-0" id="exped-fase-0" method="post" accept-charset="utf-8">
	        <div class = "row">	
	            <div class="col">
                    <h3>Detall:</h3>
     			    <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $expedientes['id']; ?>">
     			    <input type="hidden" name="convocatoria" class="form-control" id="convocatoria" value="<?php echo $expedientes['convocatoria']; ?>">
                    <div class="form-group general">
                        <label for="empresa">Empresa:</label>
                        <input type="text" name="empresa" class="form-control" id = "empresa" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> readonly disabled placeholder="Nom del sol·licitant" value="<?php echo $expedientes['empresa']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif">NIF:</label>
                        <input type="text" name="nif" class="form-control" id = "nif" readonly disabled placeholder="NIF del sol·licitant" value="<?php echo $expedientes['nif']; ?>">
                    </div>     
    		        <div class="form-group general">
                        <label for="fecha_completado">Data de la sol·licitud:</label>
                        <strong><?php echo date_format(date_create($expedientes['fecha_solicitud']), 'd/m/Y H:i:s'); ?></strong>
		        	    <input type="hidden" name="fecha_completado" class="form-control" id = "fecha_completado" value="<?php echo $expedientes['fecha_completado']; ?>">
			            <input type="hidden" name="fecha_solicitud" class="form-control" id = "fecha_solicitud" value="<?php echo $expedientes['fecha_solicitud']; ?>">
                    </div>
    		        <div class="form-group general">
                        <label for="programa">Programa:</label>
		    	        <input type="text" name="programa" list="listaProgramas" class="form-control" readonly disabled id = "programa" value="<?php echo $expedientes['tipo_tramite'];?>">
                    </div>

                    <div class="form-group general">
                        <label for="telefono_rep"><strong>Mòbil a efectes de notificacions:</strong></label>
                        <input type="tel" name="telefono_rep" class="form-control send_fase_0" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "telefono_rep" placeholder = "Mòbil a efectes de notificacions" minlength = "9" maxlength = "9" value = "<?php echo $expedientes['telefono_rep']; ?>">
                    </div>
              	    <div class="form-group general">
                        <label for="email_rep"><strong>Adreça electrònica a efectes de notificacions:</strong></label>
                        <input type="email" name="email_rep" class="form-control send_fase_0" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "email_rep" placeholder="Adreça electrònica a efectes de notificacions" value="<?php echo $expedientes['email_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="domicilio">Adreça:</label>
                        <input type="text" name="domicilio" class="form-control" readonly disabled id = "domicilio" required placeholder="Adreça del sol·licitant" value="<?php echo $expedientes['domicilio']; ?>">
                    </div>
		            <div class="form-group general">
                        <label for="localidad">Població:</label>
				            <?php
    					        $localidad = explode ("#", $expedientes['localidad']);		
				            ?>
			            <input type="text" name="Poblacio" class="form-control" readonly disabled id = "Poblacio" placeholder="Població" value="<?php echo $localidad[1].' ('.$localidad[0].')';?>">
                    </div>
                    <div class="form-group general">
                        <label for="cpostal">Codi postal:</label>
                        <input type="text" name="cpostal" class="form-control" readonly disabled id = "cpostal" maxlength = "5" size="5" required placeholder="Codi postal del sol·licitant" value="<?php echo $expedientes['cpostal']; ?>">
                    </div>   
                    <div class="form-group general">
                        <label for="telefono">Telèfon de contacte:</label>
                        <input type="tel" name="telefono" class="form-control" readonly disabled id = "telefono" placeholder="Telèfon del sol·licitant" value="<?php echo $expedientes['telefono']; ?>">
                    </div> 
                    <div class="form-group general">
                        <label for="iae">Activitat econòmica (IAE):</label>
                        <input type="text" name="iae" class="form-control" readonly disabled id = "iae" maxlength = "4" size="4" placeholder="IAE" value="<?php echo $expedientes['iae']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nombre_rep">Representant legal:</label>
                        <input type="text" name="nombre_rep" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nombre_rep" placeholder = "Nom del representant" value = "<?php echo $expedientes['nombre_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif_rep">NIF representant legal:</label>
                        <input type="text" name="nif_rep" class="form-control" readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nif_rep" minlength = "9" maxlength = "9" placeholder = "NIF del representant" value = "<?php echo $expedientes['nif_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif_rep">Adreça representant legal:</label>
                        <input type="text" name="domicilio_rep" class="form-control" readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "domicilio_rep" minlength = "9" maxlength = "9" placeholder = "Adreça del representant" value = "<?php echo $expedientes['domicilio_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif_rep">Telèfon representant legal:</label>
                        <input type="text" name="telefono_contacto_rep" class="form-control" readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "telefono_contacto_rep" minlength = "9" maxlength = "9" placeholder = "Telèfon del representant" value = "<?php echo $expedientes['telefono_contacto_rep']; ?>">
                    </div>
                </div>
                <div class="col">      	     
                <fieldset>
			        <h3><?php echo lang('message_lang.adherido_a_ils_si_no');?></h3>
			        <div class="form-check form-check-inline">
  			            <input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_no" <?php if ($expedientes['empresa_eco_idi_isba']=='NO') { echo 'checked';} ?> disabled readonly>
  			            <label class="form-check-label" for="empresa_eco_idi_isba_no"><?php echo lang('message_lang.no_adherido_a_ils');?></label>
			        </div>
			        <div class="form-check form-check-inline">
  			            <input class="form-check-input" type="radio" name="empresa_eco_idi_isba" id="empresa_eco_idi_isba_si" <?php if ($expedientes['empresa_eco_idi_isba']=='SI') { echo 'checked';} ?> disabled readonly>
  			            <label class="form-check-label" for="empresa_eco_idi_isba_si"><?php echo lang('message_lang.adherido_a_ils');?></label>
			        </div>
			        <div class="alert alert-primary ocultar" role="alert" id="empresa_eco"></div>
		        </fieldset>
                <div style="margin-top:1.5rem;"></div> 
                    <div class="form-group general">
                        <label style="width: 100%;" class="alert alert-success" role="alert" for=''><?php echo lang('message_lang.operacion_financiera_idi_isba') ?>:<br><strong><?php echo $expedientes['finalidad_inversion_idi_isba']; ?></strong></label>
                    </div>

                    <div class="form-group general">
                        <label for=''><u><?php echo lang('message_lang.operacion_financiera_prestamo_idi_isba') ?></u></label>
                    </div>

                    <div class="form-group general">
                        <label for="nom_entidad"><?php echo lang('message_lang.entidad_financiera_idi_isba') ?>:</label>
                        <input type="text" name="nom_entidad" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "nom_entidad" placeholder = "<?php echo lang('message_lang.entidad_financiera_idi_isba') ?>" value = "<?php echo $expedientes['nom_entidad']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="importe_prestamo"><?php echo lang('message_lang.importe_prestamo_entidad_idi_isba') ?>:</label>
                        <input type="text" name="importe_prestamo" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "importe_prestamo" placeholder = "<?php echo lang('message_lang.importe_prestamo_entidad_idi_isba') ?>" value = "<?php echo $expedientes['importe_prestamo']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="plazo_prestamo"><?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba') ?>:</label>
                        <input type="text" name="plazo_prestamo" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "plazo_prestamo" placeholder = "<?php echo lang('message_lang.plazo_prestamo_entidad_idi_isba') ?>" value = "<?php echo $expedientes['plazo_prestamo']; ?>">
                    </div>
                    <label for=''><u><?php echo lang('message_lang.operacion_financiera_aval_idi_isba') ?></u></label>
                    <div class="form-group general">
                        <label for="cuantia_aval_isba"><?php echo lang('message_lang.cuantia_prestamo_idi_isba') ?>:</label>
                        <input type="text" name="cuantia_aval_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "cuantia_aval_isba" placeholder = "<?php echo lang('message_lang.cuantia_prestamo_idi_isba') ?>" value = "<?php echo $expedientes['cuantia_aval_idi_isba']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="plazo_aval_isba"><?php echo lang('message_lang.plazo_prestamo_idi_isba') ?>:</label>
                        <input type="text" name="plazo_aval_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "plazo_aval_isba" placeholder = "<?php echo lang('message_lang.plazo_prestamo_idi_isba') ?>" value = "<?php echo $expedientes['plazo_aval_idi_isba']; ?>">
                    </div>            
                    <div class="form-group general">
                        <label for="fecha_aval_isba"><?php echo lang('message_lang.fecha_del_aval_idi_isba') ?>:</label>
                        <input type="text" name="fecha_aval_isba" class="form-control" readonly disabled  oninput = "javaScript: actualizaRequired(this.value);" readonly id = "fecha_aval_isba" placeholder = "<?php echo lang('message_lang.fecha_del_aval_idi_isba') ?>" value = "<?php echo $expedientes['fecha_aval_idi_isba']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="importe_ayuda_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_importe_idi_isba') ?>:</label>
                        <input type="text" name="importe_ayuda_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "importe_ayuda_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_importe_idi_isba') ?>" value = "<?php echo $expedientes['importe_ayuda_solicita_idi_isba']; ?>">
                        <br><h4>Amb el següent detall:</h4>
                    </div>
                    <div class="form-group general">
                        <ol class="inv-detalle">
                            <li>
                            <label for="intereses_ayuda_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba') ?>:</label>
                            <input type="text" name="intereses_ayuda_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "intereses_ayuda_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_subvencion_intereses_idi_isba') ?>" value = "<?php echo $expedientes['intereses_ayuda_solicita_idi_isba']; ?>">
                            </li>
                            <li>
                            <label for="coste_aval_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba') ?>:</label>
                            <input type="text" name="coste_aval_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "coste_aval_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_coste_aval_isba_idi_isba') ?>" value = "<?php echo $expedientes['coste_aval_solicita_idi_isba']; ?>">
                            </li>
                            <li>
                            <label for="gastos_aval_solicita_idi_isba"><?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba') ?>:</label>
                            <input type="text" name="gastos_aval_solicita_idi_isba" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "gastos_aval_solicita_idi_isba" placeholder = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba') ?>" value = "<?php echo $expedientes['gastos_aval_solicita_idi_isba']; ?>">
                            </li>
                        </ol>
                    </div>
        
                    <div class="form-group general">
                        <label for="ayudasSubvenSICuales_dec_resp"><?php echo lang('message_lang.declaro_idi_isba_ayudas_recibidas') ?>:</label>
                        <input type="text" name="ayudasSubvenSICuales_dec_resp" class="form-control" readonly disabled oninput = "javaScript: actualizaRequired(this.value);" readonly id = "ayudasSubvenSICuales_dec_resp" placeholder = "<?php echo lang('message_lang.solicita_ayuda_gastos_apertura_estudio_idi_isba') ?>" value = "<?php echo $expedientes['ayudasSubvenSICuales_dec_resp']; ?>">
                    </div>

    		        <div class="form-group general">
                        <label for="tecnicoAsignado">Tècnica asignada:</label>
                        <input type="text" name="tecnicoAsignado" onChange="avisarCambiosEnFormulario('send_fase_0')" list="listaTecnicos" class="form-control send_fase_0" id = "tecnicoAsignado" min="0" placeholder="Tècnica asignada" value="<?php echo $expedientes['tecnicoAsignado']; ?>">
			            <datalist id="listaTecnicos">
    			            <option value="Vittoria">
				            <option value="Caterina Mas">
				            <option value="María del Carmen Muñoz Adrover">
				            <option value="Marta Riutord">
				            <option value="Pilar Jordi Amorós">
  			            </datalist>
		            </div>

		            <div class="form-group general">
                        <label for = "situacion_exped"><strong>Situació:</strong></label>
	    		        <select class="form-control send_fase_0" id = "situacion_exped" name = "situacion_exped" required onChange="avisarCambiosEnFormulario('send_fase_0', this.id)">
    		    		    <option disabled <?php if ($expedientes['situacion'] == "") { echo "selected"; }?> value = ""><span>Selecciona una opció:</span></option>
                                <optgroup class="sitSolicitud_cab_ils" label="Fase sol·licitud:">
                           	        <option <?php if ($expedientes['situacion'] === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitSolicitud_ils"> No ha passat pel SEU</option>
                           	        <option <?php if ($expedientes['situacion'] === "pendiente") { echo "selected";}?> value = "pendiente" class="sitSolicitud_ils"> Pendent de validar</option>
                           	        <option <?php if ($expedientes['situacion'] === "reqFirmado") { echo "selected";}?> value = "reqFirmado" class="sitSolicitud_ils"> Requeriment signat</option>
                           	        <option <?php if ($expedientes['situacion'] === "reqNotificado") { echo "selected";}?> value = "reqNotificado" class="sitSolicitud_ils"> Requeriment notificat + 30 dies per subsanar</option>
                                </optgroup>
						        <optgroup class="sitAdhesion_cab_ils" label="Fase adhesió:">
                           	        <option <?php if ($expedientes['situacion'] === "ifResolucionEmitida") { echo "selected";}?> value = "ifResolucionEmitida" class="sitAdhesion_ils"> IF + resolució emesa</option>
                           	        <option <?php if ($expedientes['situacion'] === "ifResolucionEnviada") { echo "selected";}?> value = "ifResolucionEnviada" class="sitAdhesion_ils"> IF + resolució enviada</option>
                           	        <option <?php if ($expedientes['situacion'] === "ifResolucionNotificada") { echo "selected";}?> value = "ifResolucionNotificada" class="sitAdhesion_ils"> IF + resolución notificada</option>
                           	        <option <?php if ($expedientes['situacion'] === "empresaAdherida") { echo "selected";}?> value = "empresaAdherida" class="sitAdhesion_ils"> Empresa adherida</option>
                                </optgroup>
						        <optgroup class="sitEjecucion_cab_ils" label="Fase seguiment:">
                           	        <option <?php if ($expedientes['situacion'] === "idResolucionDenegacionEmitida") { echo "selected";}?> value = "idResolucionDenegacionEmitida" class="sitEjecucion_ils"> ID + resolució denegació emesa</option>
                           	        <option <?php if ($expedientes['situacion'] === "idResolucionDenegacionEnviada") { echo "selected";}?> value = "idResolucionDenegacionEnviada" class="sitEjecucion_ils"> ID + resolución denegació enviada</option>
                           	        <option <?php if ($expedientes['situacion'] === "idResolucionDenegacionNotificada") { echo "selected";}?> value = "idResolucionDenegacionNotificada" class="sitEjecucion_ils"> ID + resolució denegació notificada</option>
                           	        <option <?php if ($expedientes['situacion'] === "empresaDenegada") { echo "selected";}?> value = "empresaDenegada" class="sitEjecucion_ils"> Empresa denegada</option>
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
                <?php if($documentosDetalle){ ?>
                <?php foreach($documentosDetalle as $docs_item): 
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
			                default:
					            $nom_doc = "¿ ".$docs_item->corresponde_documento." ?"; 
			            } 
                    ?>
                    <?php if ($docs_item->docRequerido == 'SI') {?>
  			            <div id ="fila" class = "detail-wrapper-docs general">
    				        <span id = "convocatoria" class = "detail-wrapper-docs-col date-docs-col"><?php echo str_replace ("_", "-", $docs_item->selloDeTiempo); ?></span>
				            <span id = "tipoTramite" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docs_item->name.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
      			            <span id = "fechaCompletado" class = "detail-wrapper-docs-col"><?php echo $docs_item->tipo_tramite;?></span>
                            <?php
                            switch ($docs_item->estado) {
				                case 'Pendent':
    					            $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
					                break;
    				            case 'Aprovat':
    					            $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació correcta">Aprovat</button>';
					                break;
	    			            case 'Rebutjat':
    					            $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
					                break;
                                default:
    					            $estado_doc = '<button id="'.$docs_item->id."#".$docs_item->tipo_tramite."#".$id."#".$docs_item->corresponde_documento.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDoc(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                            }
                            ?>
                            <span id = "estado-doc-requerido" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                            <span class="detail-wrapper-docs-col">
                                <button <?php if ($docs_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docs_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#eliminaDocRequeridoISBA"><strong>Elimina</strong></button>
                            </span>
  			            </div>
                    <?php }?>
                <?php endforeach; ?>

                <div class="modal" id="eliminaDocRequeridoISBA">
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
            <h3>Documentació <strong>opcional</strong> de l'expedient:</h3>
            <div class="docsExpediente">
  	                <div class = "header-wrapper-docs header-wrapper-docs-solicitud">
        	            <div >Rebut el</div>
			            <div >Document</div>
    		            <div >Tràmit</div>
			            <div >Estat</div>
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
                                <button <?php if ($docs_opc_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docs_opc_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#eliminaDocNoRequeridoISBA"><strong>Elimina</strong></button>
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
                </div>

                <div class="alert alert-info">
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
        		            Aquesta acció no es podrá desfer.
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
    			            <h5 class="modal-title">Eliminar definitivament el document?</h5>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocNoRequerido_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div> <!-- Cierre fila Detalle -->
</div> <!-- Cierre del tab Detalle -->

<div id="solicitud_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
            <h3>Detall:</h3>
           <form action="" onload = "javaScript: actualizaRequired();" name="exped-fase-1" id="exped-fase-1" method="post" accept-charset="utf-8">
                <div class="form-group solicitud">
                    <label for = "fecha_REC"><strong>Data SEU sol·licitud:</strong></label>
			        <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC']);?>"/>
                </div>
                <div class="form-group solicitud">
                    <label for = "ref_REC"><strong>Referència SEU sol·licitud:</strong></label>
                    <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "ref_REC"  maxlength = "16" value = "<?php echo $expedientes['ref_REC'];?>">
                </div>
                <div class="form-group solicitud">
                    <label for = "fecha_REC_enmienda"><strong>Data SEU esmena:</strong></label>
		    	    <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC_enmienda" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_enmienda']);?>"/>
                </div>		
                <div class="form-group solicitud">
                    <label for = "ref_REC_enmienda"><strong>Referència SEU esmena:</strong></label>
                    <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "ref_REC_enmienda"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_enmienda'];?>">
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento"><strong>Data firma requeriment:</strong></label>
                    <input type = "date" name = "fecha_requerimiento" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_requerimiento" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento']), 'Y-m-d');?>"/>
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento_notif"><strong>Data notificació requeriment:</strong></label>
                    <input type = "date" name = "fecha_requerimiento_notif" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_requerimiento_notif" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento_notif']), 'Y-m-d');?>"/>
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento_notif"><strong>Data màxima per esmenar [data notificació req + 30 dies naturals]:</strong></label>
                    <input type = "date" name = "fecha_maxima_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_maxima_enmienda" value = "<?php echo date_format(date_create($expedientes['fecha_maxima_enmienda']), 'Y-m-d');?>"/>
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
                <!----------------------------------------- Informe favorable sin requerimiento DOC 1 ILS ---------------------------------------------->
	            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/informe-favorable-sin-requerimiento.php';?></li>
                <!-------------------------------------------------------------------------------------------------------------------------------------->
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
                                <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocSolicitud"><strong>Elimina</strong></button>
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
	    	                    <h4>Aquesta acció no es podrá desfer.</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body"> 
    		            		<h5 class="modal-title">Eliminar definitivament el document?</h5>
                                <div class="modal-footer">
		                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocSolicitud_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
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
        <h3>Detall:</h3>   
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-2" id="exped-fase-2" method="post" accept-charset="utf-8">
                <div class="form-group validacion">
                    <label for = "fecha_infor_fav_desf"><strong>Data firma informe favorable :</strong></label>
		            <input type = "date" name = "fecha_infor_fav" class = "form-control send_fase_2" id = "fecha_infor_fav" value = "<?php echo date_format(date_create($expedientes['fecha_infor_fav']), 'Y-m-d');?>">
                </div>
                <div class="form-group validacion">
                    <label for = "fecha_infor_fav_desf"><strong>Data firma informe desfavorable:</strong></label>
		            <input type = "date" name = "fecha_infor_desf" class = "form-control send_fase_2" id = "fecha_infor_desf" value = "<?php echo date_format(date_create($expedientes['fecha_infor_desf']), 'Y-m-d');?>">
                </div>
		        <div class="form-group validacion">
                    <label for = "fecha_resolucion"><strong>Data firma resolució:</strong></label>
                    <input type = "date" name = "fecha_resolucion" class = "form-control send_fase_2" id = "fecha_resolucion" value = "<?php echo date_format(date_create($expedientes['fecha_resolucion']), 'Y-m-d');?>">
                </div>
    		    <div class="form-group validacion">
                    <label for = "fecha_notificacion_resolucion"><strong>Data notificació resolució:</strong></label>
                    <input type = "date" name = "fecha_notificacion_resolucion" class = "form-control send_fase_2" id = "fecha_notificacion_resolucion" value = "<?php echo date_format(date_create($expedientes['fecha_notificacion_resolucion']), 'Y-m-d');?>">
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
        <ol start="2">
            <!-----------------------------------------Proposta de resolució provisional SIN VAIFIRMA---------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-provisional.php';?></li> 
            <!-----------------------------------------Proposta de resolució definitiva SIN VAIFIRMA---------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/propuesta-resolucion-definitiva.php';?></li> 
            <!-----------------------------------------Resolució de denegació -------------------------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-denegacion.php';?></li>
            <!-----------------------------------------Resolució de pagament -------------------------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-de-pago.php';?></li>   
            <!-------------------------------------------------------------------------------------------------------------------------------->
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
                                <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocValidacion"><strong>Elimina</strong></button>
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
                            <h4 class="modal-title">Aquesta acció no es podrá desfer</h4>
                            <button type="button" class="close" data-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
    			            <h5 class="modal-title">Eliminar definitivament el document?</h5>
                        </div>
                        <div class="modal-footer">
    		                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancela</button>
                            <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocValidacion_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
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
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-4" id="exped-fase-4" method="post" accept-charset="utf-8">
            <div class="row">
            <div class="col">                         
            <div class="form-group justificacion">
            <label for = "fecha_REC_justificacion"><strong>Data SEU justificació:</strong></label>
			<input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_justificacion" class = "form-control send_fase_4" id = "fecha_REC_justificacion" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_justificacion']);?>" />
            </div>	
		    <div class="form-group justificacion">
            <label for = "ref_REC_justificacion"><strong>Referència SEU justificació:</strong></label>
            <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_justificacion" class = "form-control send_fase_4" id = "ref_REC_justificacion"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_justificacion'];?>">
        	</div>
    		<div class="form-group justificacion">
            <label for = "fecha_res_liquidacion"><strong>Data resolució de concessió:</strong></label>
            <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_res_liquidacion" class = "form-control send_fase_4" id = "fecha_res_liquidacion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_res_liquidacion']), 'Y-m-d');?>">
            </div>
		    <div class="form-group justificacion">
            <label for = "fecha_not_liquidacion"><strong>Data notificació resolució:</strong></label>
            <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_not_liquidacion" class = "form-control send_fase_4" id = "fecha_not_liquidacion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_not_liquidacion']), 'Y-m-d');?>">
            </div>	
            <!--</div>
            <div class="col">    -->			
		    <div class="form-group justificacion">
            <label for = "fecha_firma_requerimiento_justificacion"><strong>Data firma requeriment justificació:</strong></label>
            <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_firma_requerimiento_justificacion" class = "form-control send_fase_4" id = "fecha_firma_requerimiento_justificacion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_firma_requerimiento_justificacion']), 'Y-m-d');?>">
            </div>	
            <div class="form-group justificacion">
            <label for = "fecha_REC_requerimiento_justificacion"><strong>Data SEU requeriment justificació:</strong></label>
			<input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "fecha_REC_requerimiento_justificacion" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_requerimiento_justificacion']);?>" />

            </div>	
		    <div class="form-group justificacion">
            <label for = "ref_REC_requerimiento_justificacion"><strong>Referència SEU requeriment justificació:</strong></label>
            <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "ref_REC_requerimiento_justificacion"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_requerimiento_justificacion'];?>">
        	</div>

                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                    <div class="form-group">
                        <button type="button"  onclick = "javaScript: actualiza_fase_4_justificacion_expediente_idi_isba('exped-fase-4');" id="send_fase_4" onChange="avisarCambiosEnFormulario('send_fase_4', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>
            
            </div>
            </div>
        </form>
        </div>
        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="6">
            <!----------------------------------------- Resolución de concesión ---------------------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/IDI-ISBA/resolucion-concesion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->                         
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
                            if($docSolicitud_item->fase_exped == 'Renovacion') {
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
                        <?php if (!$docSolicitud_item->publicAccessIdCustodiado) {?>
                            <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: justificacion_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-toggle = "modal" data-target = "#myModalDocJustificacion"><strong>Elimina</strong></button>';?></span>		
                        <?php } else {?>
                            <span id = "accion" class = "detail-wrapper-docs-col small">No es pot esborrar</span>			
                        <?php } ?>			
                    </div>
                <?php }
                    endforeach; ?>
                <?php endif; ?>

                <div id="myModalDocJustificacion" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Aquesta acció no es podrá desfer.</h4>
                                <button type="button" class="close" data-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="modal-title">Eliminar definitivament aquest document?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocJustificacion_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class ="upload-docs-type-label">[.zip]:</h5>
                <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Renovacion');?>" onsubmit="logSubmit('subeDocsJustificacionBtn')" name="subir_doc_faseExpedRenovacion" id="subir_doc_faseExpedRenovacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
            <div id = "tab_plan">
                <button class="accordion-exped">
                <?php
                    if ($expedientes['tipo_tramite'] =='Programa I') {
	                    echo lang('message_lang.justificacion_plan_p1').": ";
                    }
                    else {
	                    echo lang('message_lang.justificacion_plan_p2_p3').": ";
                    }
                ?>
                </button>
                <div class="panel-exped">
                    <div class = "header-wrapper-docs-justificacion">
  	                    <div>Rebut el</div>
   	                    <div>Document</div>
	                    <div>Estat</div>
                    </div>

	                <?php if($documentosJustifPlan): ?>
                    <?php foreach($documentosJustifPlan as $docsJustif_item): 
			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $parametro = explode ("/",$path);
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

            <div id = "tab_facturas">
                <button class="accordion-exped">Factures de l'habilitador digital:</button>
                <div class="panel-exped">
                    <div class = "header-wrapper-docs-justificacion">
  	                    <div>Rebut el</div>
   	                    <div>Arxiu</div>
	                    <div>Estat</div>
                    </div>
                <?php if($documentosJustifFact): ?>
                <?php foreach($documentosJustifFact as $docsJustif_item):

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
                    
                    
                    <!-- <?php //if (!$documentosJustifPlan->publicAccessIdCustodiado) {?>
			            <span id="custodia" class = "detail-wrapper-docs-col"> 
				            <a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$documentosJustifPlan->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $documentosJustifPlan->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a>
			            </span>
		            <?php //} else {?>
			            <span id = "accion" class = "detail-wrapper-docs-col">Pendent de custodiar</span>			
		            <?php //} ?> -->

	                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                </div>
            </div>

            <div id = "tab_pagos" class="active">
                <button class="accordion-exped">Justificants de pagament a l'habilitador digital:</button>
                <div class="panel-exped">
                    <div class = "header-wrapper-docs-justificacion">
		                <div >Rebut el</div>
   		                <div >Arxiu</div>
		                <div >Estat</div>   
                    </div>
                    <?php if($documentosJustifPagos): ?>
                    <?php foreach($documentosJustifPagos as $docsJustif_item): ?>
			        <?php 
    			        // $path = str_replace ("D:\wampp\apache2\htdocs\pindust\writable\documentos/","", $docsJustif_item->created_at);
			            // $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docsJustif_item->created_at);
			            $path =  $docsJustif_item->created_at;
			            $selloDeTiempo = $docsJustif_item->selloDeTiempo;
			            $tipoMIME = $docsJustif_item->type;
			            $nom_doc = $docsJustif_item->name;
                        //echo "#### ". $selloDeTiempo . " ####";
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
                        
                        <!-- <?php //if (!$documentosJustifPlan->publicAccessIdCustodiado) {?>
			                <span id="custodia" class = "detail-wrapper-docs-col"> 
    				            <a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$documentosJustifPlan->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $documentosJustifPlan->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a>
	    		            </span>
		                <?php //} else {?>
			                <span id = "accion" class = "detail-wrapper-docs-col">Pendent de custodiar</span>			
		                <?php //} ?> -->

		            </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div><a href="<?php echo base_url('public/index.php/home/justificacion_cheques/').'/'.$expedientes['id'].'/'.$expedientes['nif'].'/'.$expedientes['tipo_tramite'].'/'.$expedientes['convocatoria'].'/ca';?>" target = "_blank">Formulari de requeriment de justificació</a></div>
            <div><a href="<?php 
                if (isset($selloDeTiempo)) {
                    echo base_url('public/index.php/expedientes/muestradocumento/'.$expedientes['nif'].'_justificacion_solicitud_ayuda.pdf'.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME.'/justificacion');
                }
            ?>" target = "_blank">Mostrar la declaració responsable de la justificació sense signar</a></div>
        </div>
    </div>
</div>

<div id="deses_ren_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>"  name="exped-fase-5" id="exped-fase-5" method="post" accept-charset="utf-8">
            <div class="form-group desistimiento">
                <label for = "fecha_REC_desestimiento"><strong>Data SEU desistiment:</strong></label>
	    	    <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_desestimiento" class = "form-control send_fase_5" id = "fecha_REC_desestimiento" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_desestimiento']);?>"/>
            </div>
		    <div class="form-group desistimiento">
                <label for = "ref_REC_desestimiento"><strong>Referència SEU desistiment:</strong></label>
                <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" maxlength = "16" name = "ref_REC_desestimiento" class = "form-control send_fase_5" id = "ref_REC_desestimiento" value = "<?php echo $expedientes['ref_REC_desestimiento'];?>">
        	</div>
	    	<div class="form-group desistimiento">
                <label for = "fecha_firma_resolucion_desestimiento"><strong>Data firma resolució de desistiment:</strong></label>
                <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_firma_resolucion_desestimiento" class = "form-control send_fase_5" id = "fecha_firma_resolucion_desestimiento" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_firma_resolucion_desestimiento']), 'Y-m-d');?>">
            </div>
		    <div class="form-group desistimiento">
                <label for = "fecha_notificacion_desestimiento"><strong>Data notificació desistiment:</strong></label>
                <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_notificacion_desestimiento" class = "form-control send_fase_5" id = "fecha_notificacion_desestimiento" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_notificacion_desestimiento']), 'Y-m-d');?>">
            </div>

                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                <div class="form-group">
                    <button type="button" onclick = "javaScript: actualiza_fase_5_desestimiento_expediente('exped-fase-5');" id="send_fase_5" onchange="avisarCambiosEnFormulario('send_fase_5', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                </div>
                <?php }?>

            </form>
        </div>

        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start="25">
                <!----------------------------------------- Reseolución desestimiento  DOC 22 SIN VIAFIRMA -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-desestimiento-por-renuncia.php';?></li>
                <!------------------------------------------------------------------------------------------------->
                <!----------------- Propuesta resolución revocación por no justificar  DOC 23 SIN VIAFIRMA -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-revocacion-por-no-justificar.php';?></li>
                <!------------------------------------------------------------------------------------------------->
                <!----------------- Resolución revocación por no justificar  DOC 24 SIN VIAFIRMA ------------------>
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-revocacion-por-no-justificar.php';?></li>
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
                        <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#myModalDocDesestimiento"><i class="bi bi-trash-fill" style="font-size: 1.5rem; color: red;"></i></button>
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
    		                Aquesta acció no es podrá desfer.
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
    	    		        <h5 class="modal-title">Eliminar definitivament el document?</h5>
                            <div class="modal-footer">
    		                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocDesestimiento_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
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
        /* padding: 0 18px; */
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }
</style>

<script>
    if (<?php echo $totalDocsJustifPlan;?> === 0) {
    	document.getElementById("tab_plan").classList.add ("warning-msg-justific");
    }
    else
    {
    	document.getElementById("tab_plan").classList.add ("success-msg-justific");
    }

    if (<?php echo $totalDocsJustifFact;?> === 0) {
    	document.getElementById("tab_facturas").classList.add ("warning-msg-justific");
    }
    else
    {
    	document.getElementById("tab_facturas").classList.add ("success-msg-justific");
    }

    if (<?php echo $totalDocsJustifPagos;?> === 0) {
    	document.getElementById("tab_pagos").classList.add ("warning-msg-justific");
    }
    else
    {
	    document.getElementById("tab_pagos").classList.add ("success-msg-justific");
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript" src="/public/assets/js/edita-expediente-isba.js"></script>
<script src="https://kit.fontawesome.com/1a19d0e4f2.js" crossorigin="anonymous"></script>