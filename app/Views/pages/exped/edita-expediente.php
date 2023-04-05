<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>

<?php
    use App\Models\DocumentosGeneradosModel;
    use App\Models\MejorasExpedienteModel;
    use App\Models\ExpedientesModel;

    $modelDocumentosGenerados = new DocumentosGeneradosModel();
  
    $modelMejorasSolicitud = new MejorasExpedienteModel();
    $session = session();
	$convocatoria = $expedientes['convocatoria'];
   
    $modelExp = new ExpedientesModel();

    if ($totalConvocatorias>1){
        echo '<div class="alert alert-warning" role="alert">
        Nombre total de sol·licituds d´aquesta línia d´ajuda: '.$totalConvocatorias.'</div>';
    }

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

/* Si no hay IMPORTE AYUDA, Calcula el importe según el programa Y el número de convocatorias a las que se ha  presentado */

if (!$expedientes['importeAyuda']) {
    $objs = json_decode( $configuracion['programa']);
    /**
     * object(stdClass)#88 (3) { ["Programa_I"]=> object(stdClass)#90 (1) { ["edicion"]=> object(stdClass)#89 (3) 
     * { ["Primera"]=> array(3) { [0]=> int(5100) [1]=> int(90) [2]=> int(60) } ["Segunda"]=> array(3) 
     * { [0]=> int(3400) [1]=> int(80) [2]=> int(40) } ["Tercera"]=> array(3) 
     * { [0]=> int(3400) [1]=> int(80) [2]=> int(40) } } } ["Programa_II"]=> object(stdClass)#92 (1) 
     * { ["edicion"]=> object(stdClass)#91 (2) { ["Primera"]=> array(3) { [0]=> int(4080) [1]=> int(90) [2]=> int(48) } 
     * ["Segunda"]=> array(3) { [0]=> int(4080) [1]=> int(80) [2]=> int(48) } } } 
     * ["Programa_III"]=> object(stdClass)#94 (1) { ["edicion"]=> object(stdClass)#93 (2) { 
     * ["Primera"]=> array(3) { [0]=> int(1360) [1]=> int(90) [2]=> int(16) } 
     * ["Segunda"]=> array(3) { [0]=> int(1360) [1]=> int(80) [2]=> int(16) } } } } */
  
    switch ($programa) {
        case 'Programa I':
            switch($totalConvocatorias) {
                case 1:
                    $importeAyuda = $objs->Programa_I->edicion->Primera[0]*($objs->Programa_I->edicion->Primera[1]/100);
                    break;
                case 2:
                    $importeAyuda = $objs->Programa_I->edicion->Segunda[0]*($objs->Programa_I->edicion->Segunda[1]/100);                
                    break;
                default:
                    $importeAyuda = $objs->Programa_I->edicion->Tercera[0]*($objs->Programa_I->edicion->Tercera[1]/100);
            }
            break;
        case 'Programa II':
            switch($totalConvocatorias) {
                case 1:
                    $importeAyuda = $objs->Programa_II->edicion->Primera[0]*($objs->Programa_II->edicion->Primera[1]/100);
                    break;
                default:
                    $importeAyuda = $objs->Programa_II->edicion->Segunda[0]*($objs->Programa_II->edicion->Segunda[1]/100);
            }
            break;
        case 'Programa III':
            switch($totalConvocatorias) {
                case 1:
                    $importeAyuda = $objs->Programa_III->edicion->Primera[0]*($objs->Programa_III->edicion->Primera[1]/100);
                    break;
                default:
                    $importeAyuda = $objs->Programa_III->edicion->Segunda[0]*($objs->Programa_III->edicion->Segunda[1]/100);
            }
            break;
    }
        $resultadoActualizar = $modelExp->updateImporteAyuda ($id, $importeAyuda);
    } else {
        $importeAyuda = $expedientes['importeAyuda'];
    }
	?>

    <!----------------------------------------- Para poder consultar en VIAFIRMA el estado de los modelos de documentos --->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/execute-curl.php';?>
    <!--------------------------------------------------------------------------------------------------------------------->

<div class="tab_fase_exp">
    <button id="detall_tab_selector" class="tablinks" onclick="openFaseExped(event, 'detall_tab', ' #ccc')">Detall</button>  
    <button id="solicitud_tab_selector" class="tablinks" onclick="openFaseExped(event, 'solicitud_tab', '#f6b26b')">Sol·licitud</button>
    <button id="validacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'validacion_tab', '#92cd92')">Validació</button>
    <button id="ejecucion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'ejecucion_tab', '#6d9eeb')">Execució</button>
    <button id="justifiacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'justificacion_tab', '#a64d79')">Justificació</button>
    <button id="deses_ren_tab_selector" class="tablinks" onclick="openFaseExped(event, 'deses_ren_tab', '#8e7cc3')">Desistiment o renúncia</button>
</div>
<?php echo "Data sol·licitud: ". $expedientes['fecha_solicitud'];?> <?php echo "Data complert: ". $expedientes['fecha_completado'];?>
<div id="detall_tab" class="tab_fase_exp_content" style="display:block;">
    <div class="row">
        <div class="col docsExpediente">
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-0" id="exped-fase-0" method="post" accept-charset="utf-8">
	        <div class = "row">	
	            <div class="col">
                    <h3>Detall:</h3>
     			    <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $expedientes['id']; ?>"> 

                    <div class="form-group general">
                        <label for="empresa">Nom o raó social:</label>
                        <input type="text" name="empresa" class="form-control send_fase_0" id = "empresa" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> placeholder="Nom del sol·licitant" value="<?php echo $expedientes['empresa']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif">NIF:</label>
                        <input type="text" name="nif" class="form-control" id = "nif" disabled readonly placeholder="NIF del sol·licitant" value="<?php echo $expedientes['nif']; ?>">
                    </div>     
    		        <div class="form-group general">
                        <label for="fecha_completado">Data de la sol·licitud:</label>
                        <strong><?php echo date_format(date_create($expedientes['fecha_solicitud']), 'd/m/Y H:i:s'); ?></strong>
		        	    <input type="hidden" name="fecha_completado" class="form-control" id = "fecha_completado" value="<?php echo $expedientes['fecha_completado']; ?>">
			            <input type="hidden" name="fecha_solicitud" class="form-control" id = "fecha_solicitud" value="<?php echo $expedientes['fecha_solicitud']; ?>">
                    </div>
    		        <div class="form-group general">
                        <label for="programa">Programa:</label>
		    	        <input type="text" name="programa" list="listaProgramas" class="form-control send_fase_0" required readonly disabled <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "programa" value="<?php echo $expedientes['tipo_tramite'];?>">
                    </div>
                    <datalist id="listaProgramas">
    			        <option value="Programa I">
				        <option value="Programa II">
				        <option value="Programa III">
  			        </datalist>

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
                    <label for="telefono">Telèfon mòbil de contacte:</label>
                    <input type="tel" name="telefono" class="form-control" readonly id = "telefono" required disabled placeholder="Telèfon del sol·licitant" value="<?php echo $expedientes['telefono']; ?>">
                </div> 
                <div class="form-group general">
                    <label for="iae">Activitat econòmica (IAE):</label>
                    <input type="text" name="iae" class="form-control" readonly disabled id = "iae" maxlength = "4" size="4" placeholder="IAE" value="<?php echo $expedientes['iae']; ?>">
                </div>
		        <div class="form-group general">
                    <label for="nombre_rep">Representant legal:</label>
                    <input type="text" name="nombre_rep" class="form-control send_fase_0" oninput = "javaScript: actualizaRequired(this.value);" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nombre_rep" placeholder = "Nom del representant" value = "<?php echo $expedientes['nombre_rep']; ?>">
                </div>
            </div>
            <div class="col">
                <div class="form-group general">
                    <label for="nif_rep">NIF representant legal:</label>
                    <input type="text" name="nif_rep" class="form-control send_fase_0" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nif_rep" minlength = "9" maxlength = "9" placeholder = "NIF del representant" value = "<?php echo $expedientes['nif_rep']; ?>">
                </div>
        <?php if ( $expedientes['tipo_tramite'] != 'ILS') {?>    
                <div class="form-group general">
                    <label for="empresa_consultor">Empresa del consultor:</label>
                    <input type="text" name="empresa_consultor" class="form-control send_fase_0" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "empresa_consultor" placeholder = "Empresa del consultor" value = "<?php echo $expedientes['empresa_consultor']; ?>">
                </div>
	            <div class="form-group general">
                    <label for="nom_consultor">Nom del consultor:</label>
                    <input type="text" name="nom_consultor" class="form-control send_fase_0" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nom_consultor" placeholder="Nom del consultor" value="<?php echo $expedientes['nom_consultor']; ?>">
                </div> 
                <div class="form-group general">
                    <label for="tel_consultor"><strong>Telèfon mòbil consultor:</strong></label>
                    <input type="tel" name="tel_consultor" class="form-control send_fase_0" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "tel_consultor" minlength = "9" maxlength = "9" placeholder="Telèfon del consultor" value="<?php echo $expedientes['tel_consultor']; ?>">
                </div> 
    		    <div class="form-group general">
                    <label for="mail_rep"><strong>Adreça electrònica consultor:</strong></label>
                    <input type="email" name="mail_consultor" class="form-control send_fase_0" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "mail_consultor" placeholder="Adreça electrònica del consultor" value="<?php echo $expedientes['mail_consultor']; ?>">
                </div>
        <?php }?>
    		    <div class="form-group general">
                    <label for="tecnicoAsignado">Tècnica asignada:</label>
                    <input type="text" name="tecnicoAsignado" onChange="avisarCambiosEnFormulario('send_fase_0')" list="listaTecnicos" class="form-control send_fase_0" id = "tecnicoAsignado" min="0" placeholder="Tècnica asignada" value="<?php echo $expedientes['tecnicoAsignado']; ?>">
			        <datalist id="listaTecnicos">
    			        <option value="Alejandra Gelabert">
				        <option value="Antonia Medina">
				        <option value="Beatriz Pino Roca">
				        <option value="Caterina Mas">
				        <option value="Francisca Ferragut">
				        <option value="Joana María Miquel">
				        <option value="María del Carmen Muñoz Adrover">
				        <option value="Marta Riutord">
				        <option value="Pilar Jordi Amorós">
				        <option value="Vanessa Rosselló Garí">
  			        </datalist>
		        </div>

		        <div class="form-group general">
                    <label for = "situacion_exped"><strong>Situació:</strong></label>
	    		    <select class="form-control send_fase_0" id = "situacion_exped" name = "situacion_exped" required onChange="avisarCambiosEnFormulario('send_fase_0', this.id)">
    		    		<option disabled <?php if ($expedientes['situacion'] == "") { echo "selected"; }?> value = ""><span>Selecciona una opció:</span></option>
                        <optgroup style="background-color:#F51720;color:#000;" label="Fase sol·licitud:">
                            <option <?php if ($expedientes['situacion'] == "nohapasadoREC") { echo "selected"; }?> value = "nohapasadoREC" class="sitSolicitud"> No ha passat pel REC</option>
                            <option <?php if ($expedientes['situacion'] == "pendiente") { echo "selected"; }?> value = "pendiente" class="sitSolicitud"> Pendent de validar</option>
                            <option <?php if ($expedientes['situacion'] == "comprobarAnt") { echo "selected"; }?> value = "comprobarAnt" class="sitSolicitud"> Comprovar Antonia</option>
                            <option <?php if ($expedientes['situacion'] == "comprobarAntReg") { echo "selected"; }?> value = "comprobarAntReg" class="sitSolicitud"> Comprovar Antonia amb requeriment pendent</option>
                            <option <?php if ($expedientes['situacion'] == "emitirReq") { echo "selected"; }?> value = "emitirReq" class="sitSolicitud"> Emetre requeriment</option>
                            <option <?php if ($expedientes['situacion'] == "firmadoReq") { echo "selected"; }?> value = "firmadoReq" class="sitSolicitud"> Requeriment signat</option>
                            <option <?php if ($expedientes['situacion'] == "notificadoReq") { echo "selected"; }?> value = "notificadoReq" class="sitSolicitud"> Requeriment notificat</option>
                            <option <?php if ($expedientes['situacion'] == "emitirDesEnmienda") { echo "selected"; }?> value = "emitirDesEnmienda" class="sitSolicitud"> Emetre desistiment per esmena</option>
                            <option <?php if ($expedientes['situacion'] == "emitidoDesEnmienda") { echo "selected"; }?> value = "emitidoDesEnmienda" class="sitSolicitud"> Desistiment per esmena emès</option>
                            <option <?php if ($expedientes['situacion'] == "Desestimiento") { echo "selected"; }?> value = "Desestimiento" class="sitSolicitud"> Desistiment</option>
                        </optgroup>
                        <optgroup style="background-color:#e44097;color:#000;" label="Fase validació:">
                            <optgroup style="background-color:#fff;color:#e44097;" label="En el cas d'expedients favorables:">
        		                <option <?php if ($expedientes['situacion'] == "emitirIFPRPago") { echo "selected";}?> value = "emitirIFPRPago" class="sitValidacion"> IF + PR Pagament emetre</option>
    				            <option <?php if ($expedientes['situacion'] == "emitidoIFPRPago") { echo "selected";}?> value = "emitidoIFPRPago" class="sitValidacion"> IF + PR Pagament emés</option>
	    			            <option <?php if ($expedientes['situacion'] == "enviadoPRPago") { echo "selected";}?> value = "enviadoPRPago" class="sitValidacion"> PR Pagament enviat</option>
                                <option <?php if ($expedientes['situacion'] == "emitirPagoReqIFPR") { echo "selected";}?> value = "emitirPagoReqIFPR" class="sitValidacion"> IF+PR Pagament amb requeriment emetre</option>
                                <option <?php if ($expedientes['situacion'] == "emitirPagoReqIDPD") { echo "selected";}?> value = "emitirPagoReqIDPD" class="sitValidacion"> ID+PD pagament amb requeriment emetre</option>                                
            		            <option <?php if ($expedientes['situacion'] == "inicioConsultoria") { echo "selected";}?> value = "inicioConsultoria" class="sitValidacion"> Inici de consultoria</option>
                            </optgroup>   
                            <optgroup style="background-color:#fff;color:#e44097;" label="En el cas d'expedients desfavorables:">
                                <option <?php if ($expedientes['situacion'] == "emitirIDPD") { echo "selected";}?> value = "emitirIDPD" class="sitValidacion"> ID + PD emetre</option>
				                <option <?php if ($expedientes['situacion'] == "emitidoIDPD") { echo "selected";}?> value = "emitidoIDPD" class="sitValidacion"> ID + PD emés</option>
    				            <option <?php if ($expedientes['situacion'] == "enviadoFirmaPD") { echo "selected";}?> value = "enviadoFirmaPD" class="sitValidacion"> PD enviat a firmar</option>
            		            <option <?php if ($expedientes['situacion'] == "notificadoPD") { echo "selected";}?> value = "notificadoPD" class="sitValidacion"> PD notificada</option>
            		            <option <?php if ($expedientes['situacion'] == "emitirRD") { echo "selected";}?> value = "emitirRD" class="sitValidacion"> Emetre RD</option>	
                                <option <?php if ($expedientes['situacion'] == "emitidoRD") { echo "selected";}?> value = "emitidoRD" class="sitValidacion"> RD emés</option>
                                <option <?php if ($expedientes['situacion'] == "enviadoFirmaRD") { echo "selected";}?> value = "enviadoFirmaRD" class="sitValidacion"> RD enviada a signar</option>
                                <option <?php if ($expedientes['situacion'] == "denegado") { echo "selected";}?> value = "Denegado" class="sitValidacion"> Denegat</option>
                            </optgroup>
                        </optgroup>
                        <optgroup style="background-color:#6d9eeb;color:#000;" label="Fase execució / justificació:">
                            <optgroup  style="background-color:#fff;color:#6d9eeb;" label="En cas de justificació correcte:">
                		        <option <?php if ($expedientes['situacion'] == "pendienteJustificar") { echo "selected";}?> value = "pendienteJustificar" class="sitEjecucion"> Pendent de justificar</option>
                		        <option <?php if ($expedientes['situacion'] == "pendienteRECJustificar") { echo "selected";}?> value = "pendienteRECJustificar" class="sitEjecucion"> Pendent REC justificant</option>
            	    	        <option <?php if ($expedientes['situacion'] == "Justificado") { echo "selected";}?> value = "Justificado" class="sitEjecucion"> Justificat</option>
        	    	            <option <?php if ($expedientes['situacion'] == "emitidoResJustificacion") { echo "selected";}?> value = "emitidoResJustificacion" class="sitEjecucion"> Resolució justificació emesa</option>
        	    	            <option <?php if ($expedientes['situacion'] == "Finalizado") { echo "selected";}?> value = "Finalizado" class="sitEjecucion"> Finalitzat</option>
                            </optgroup>   
                            <optgroup  style="background-color:#fff;color:#6d9eeb;" label="En cas de requeriment en la justificació:">
            		            <option <?php if ($expedientes['situacion'] == "emitidoReqJust") { echo "selected";}?> value = "emitidoReqJust" class="sitEjecucion"> Emès requeriment justificació</option>
        	    	            <option <?php if ($expedientes['situacion'] == "notificadoReq") { echo "selected";}?> value = "notificadoReq" class="sitEjecucion"> Requeriment notificat</option>
        	    	            <option <?php if ($expedientes['situacion'] == "inicioRevocacion") { echo "selected";}?> value = "inicioRevocacion" class="sitEjecucion"> Inici de revocació</option>
        	    	            <option <?php if ($expedientes['situacion'] == "emitidoPropRevocacion") { echo "selected";}?> value = "emitidoPropRevocacion" class="sitEjecucion"> Emès proposta de revocació</option>
        	    	            <option <?php if ($expedientes['situacion'] == "notificadoPropRevocacion") { echo "selected";}?> value = "notificadoPropRevocacion" class="sitEjecucion"> Notificat proposta de revocació</option>
        	    	            <option <?php if ($expedientes['situacion'] == "emitirResRevocacion") { echo "selected";}?> value = "emitirResRevocacion" class="sitEjecucion"> Emetre la resolució de revocació</option>
        	    	            <option <?php if ($expedientes['situacion'] == "emitidoResRevocacion") { echo "selected";}?> value = "emitidoResRevocacion" class="sitEjecucion"> Resolució de revocació emès</option>
        	    	            <option <?php if ($expedientes['situacion'] == "revocado") { echo "selected";}?> value = "revocado" class="sitEjecucion"> Revocat</option>
                            </optgroup>                          
                        </optgroup>
			        </select>
		        </div>
		    
                <label for = "memoriaTecnicaEnIDI" class="main" >
					<span ><?php echo lang('message_lang.memoriaTecnicaEnIDI_sinCambios');?> </span>
						<input type="checkbox" <?php if ($expedientes['memoriaTecnicaEnIDI'] === "SI") { echo "checked";}?> disabled readonly name = "memoriaTecnicaEnIDI" id = "memoriaTecnicaEnIDI">
					<span class="w3docs"></span>
				</label>

                <label for = "certificadoIAEEnIDI" class="main" >
					<span ><?php echo lang('message_lang.certificadoIAEEnIDI_sinCambios');?> </span>
						<input type="checkbox" <?php if ($expedientes['certificadoIAEEnIDI'] === "SI") { echo "checked";}?> disabled readonly name = "certificadoIAEEnIDI" id = "certificadoIAEEnIDI">
					<span class="w3docs"></span>
				</label>

                <label for = "copiaNIFSociedadEnIDI" class="main" >
					<span ><?php echo lang('message_lang.copiaNIFSociedadEnIDI_sinCambios');?> </span>
						<input type="checkbox" <?php if ($expedientes['copiaNIFSociedadEnIDI'] === "SI") { echo "checked";}?> disabled readonly name = "copiaNIFSociedadEnIDI" id = "copiaNIFSociedadEnIDI">
					<span class="w3docs"></span>
				</label>

                <label for = "pJuridicaDocAcreditativaEnIDI" class="main" >
					<span ><?php echo lang('message_lang.pJuridicaDocAcreditativaEnIDI_sinCambios');?> </span>
						<input type="checkbox" <?php if ($expedientes['pJuridicaDocAcreditativaEnIDI'] === "SI") { echo "checked";}?> disabled readonly name = "pJuridicaDocAcreditativaEnIDI" id = "pJuridicaDocAcreditativaEnIDI">
					<span class="w3docs"></span>
				</label>

                <div class="form-group general">
                    <label for="importeAyuda">Import de l'ajuda:</label>
                    <input type="number" name="importeAyuda" readonly disabled class="form-control" id = "importeAyuda" min="0" placeholder="Import de l'ajuda" value="<?php echo $importeAyuda; ?>">
                </div>
                <div class="form-group general">
                    <label for="porcentajeConcedido">Percentatje de l'ajuda:</label>
                    <select class="form-control send_fase_0" readonly disabled id = "porcentajeConcedido" name = "porcentajeConcedido" required>
    		    		    <option disabled <?php if ($expedientes['porcentajeConcedido'] == "") { echo "selected"; }?> value = ""><span>Selecciona una opció:</span></option>
                            <option <?php if ($expedientes['porcentajeConcedido'] == "0") { echo "selected"; }?> value = "0" class="solicitud"></option>
                            <option <?php if ($expedientes['porcentajeConcedido'] == "60") { echo "selected"; }?> value = "60" class="solicitud">60 %</option>
    				        <option <?php if ($expedientes['porcentajeConcedido'] == "70") { echo "selected"; }?> value = "70" class="solicitud">70 %</option>
        		            <option <?php if ($expedientes['porcentajeConcedido'] == "80") { echo "selected"; }?> value = "80" class="validacion">80 %</option>
    				        <option <?php if ($expedientes['porcentajeConcedido'] == "90") { echo "selected"; }?> value = "90" class="validacion">90 %</option>
			        </select>
                    <!--<input type="number" name="porcentajeConcedido" onChange="avisarCambiosEnFormulario('send_fase_0')" class="form-control" id = "porcentajeConcedido" min="0" placeholder="Percentatje de l'ajuda" value="<?php echo $expedientes['porcentajeConcedido']; ?>">-->
                </div>
                <div class="form-group general">
                    <label for="cc_datos_bancarios">CC:</label>
                    <input type="text" name="cc_datos_bancarios" readonly disabled class="form-control" id = "cc_datos_bancarios"  placeholder="Compte corrent" value="<?php echo strtoupper($expedientes['cc_datos_bancarios']); ?>">
                </div>               

	    	    <div class="form-group general">
                    <label for = "ordenDePago"><strong>Enviar a pagament:</strong></label>
                    <select class="form-control send_fase_0" id = "ordenDePago" name = "ordenDePago" required>
    		    		    <option <?php if ($expedientes['ordenDePago'] == "NO") { echo "selected";}?> value = "NO"><span>NO</span></option>
                            <option <?php if ($expedientes['ordenDePago'] == "SI") { echo "selected";}?> value = "SI" class="solicitud">SI</option>
			        </select>
                </div>
	    	    <div class="form-group general">
                    <label for = "fechaEnvioAdministracion"><strong>Data enviament a administració:</strong></label>
                    <input type = "date" name = "fechaEnvioAdministracion" class = "form-control send_fase_0" id = "fechaEnvioAdministracion" value = "<?php echo date_format(date_create($expedientes['fechaEnvioAdministracion']), 'Y-m-d');?>">
                </div>    
	    	    <div class="form-group general">
                    <label for = "fecha_de_pago"><strong>Data pagament:</strong></label>
                    <input type = "date" name = "fecha_de_pago" class = "form-control send_fase_0" id = "fecha_de_pago" value = "<?php echo date_format(date_create($expedientes['fecha_de_pago']), 'Y-m-d');?>">
                </div>  
   
                <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class="form-group">
                        <button type="button" onclick = "javaScript: actualiza_fase_0_expediente('exped-fase-0');" id="send_fase_0" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>

            </div>
        </div>
    </form>
    </div>    
    <div class="col docsExpediente">
        <div class="col">
            <h3>Documentació <strong>requerida</strong> de l'expedient:</h3>
            <div class="docsExpediente">
  	            <div class = "header-wrapper-docs header-wrapper-docs-solicitud">
        	        <div >Rebut el</div>
			        <div >Document</div>
    		        <div >Tràmit</div>
			        <div >Estat</div>
  		        </div>
                <?php if($documentos){ ?>
                <?php foreach($documentos as $docs_item): 
			            $path = $docs_item->created_at;
			            $parametro = explode ("/",$path);
			            $tipoMIME = $docs_item->type;

                    if ($convocatoria >= '2022') {
			            switch ($docs_item->corresponde_documento) {
				            case 'file_infoautodiagnostico':
					            $nom_doc = "Informe autodiagnosi digital";
					            break;
    				        case 'file_certificadoIAE':
					            $nom_doc = "Certificat d'alta d'IAE";
					            break;
	    			        case 'file_declaracionResponsable':
					            $nom_doc = "Declaració responsable de l'empresa";
					            break;
		    		        case 'file_declaracionResponsableConsultor':
					            $nom_doc = "Declaració responsable del consultor";
					            break;
			    	        case 'file_memoriaTecnica':
					            $nom_doc = "La memòria tècnica";
					            break;
                            case 'file_document_acred_como_repres':
                                $nom_doc = "Documentació acreditativa de les facultats de representació de la persona que firma la sol·licitud d'ajut";
                                break;
				            case 'file_docConstitutivoCluster':	
					            $nom_doc = "Document constitutiu clústers i/o centres tecnològics";
					            break;    					
				            case 'file_certigicadoSegSoc':
					            $nom_doc = "Certificat de la Seguretat Social";
					            break;
				            case 'file_certificadoATIB':
					            $nom_doc = "Certificat estar al corrent obligacions amb Agència Estatal de l'Administració Tributària i Agència Tributària IB";
					            break;				
				            case 'file_copiaNIF':
					            $nom_doc = "Còpia del NIF al no autoritzar a IDI per comprobar";
					            break;				
				            case 'file_altaAutonomos':	
					            $nom_doc = "Còpia documentació acreditativa alta d'autònoms";
					            break;	
				            case 'file_escrituraConstitucion':	
					            $nom_doc = "Còpia escriptura de constitució de l'entitat";
					            break;
				            case 'file_nifEmpresa':	
					            $nom_doc = "Còpia del NIF de l'empresa";
					            break;
				            case 'file_nifRepresentante':	
					            $nom_doc = "Còpia del NIF del representant de la societat";
					            break;
				            case 'file_certificadoDocumentacion':	
					            $nom_doc = "Certificats i documentació corresponent (al no donar consentiment a l'IDI)";
					            break;
				            case 'file_declNoConsentimiento':	
					            $nom_doc = "Declaració de no consentiment";
          			            break;
				            case 'file_enviardocumentoIdentificacion':	
					            $nom_doc = "Identificació de la persona sol·licitant i/o la persona autoritzada per l’empresa";
					            break;
                            case 'file_certificadoSegSoc':	
                                $nom_doc = "Certificat estar al corrent obligacions amb la Tesoreria de la Seguridad Social";
                                break;
                            case 'file_resguardoREC':	
                                $nom_doc = "Justificant de presentació pel REC";
                                break;
                            case 'file_DocumentoIDI':	
                                $nom_doc = "Document pujat des-de l'IDI";
                                break;
                            case 'file_escritura_empresa':	
                                $nom_doc = "Escriptures del registre Mercantil";
                                break;
                            case 'file_certificadoAEAT':	
                                $nom_doc = "Certificat AEAT";
                                break;                              
			                default:
					        $nom_doc = $docs_item->corresponde_documento; 
			            } 
                        } else {
                            $nom_doc = $docs_item->name;
                        }?>
                    <?php if ($docs_item->docRequerido !== 'NO') {?>
  			            <div id ="fila" class = "detail-wrapper-docs general">
    				        <span id = "convocatoria" class = "detail-wrapper-docs-col date-docs-col"><?php echo str_replace ("_", " / ", $docs_item->selloDeTiempo); ?></span>
				            <span id = "tipoTramite" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docs_item->name.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
      			            <span id = "fechaCompletado" class = "detail-wrapper-docs-col"><?php echo $docs_item->tipo_tramite; ?></span>
                            <!-- <span id = "custodia" class = "detail-wrapper-docs-col"><a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$docs_item->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $docs_item->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a></span> -->
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
                            <?php 
                            switch ($docs_item->corresponde_documento) {
                                case 'file_escritura_empresa':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/envia-form-solicitud-escritura-empresa.php'; 
                                    break;
    				            case 'file_certificadoIAE':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/envia-form-solicitud-certificado-iae.php'; 
                                    break;
                                case 'file_document_acred_como_repres':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/envia-form-solicitud-documentacion-acred-represent.php'; 
                                    break;
                                case 'file_certificadoAEAT':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/envia-form-solicitud-certificado-aeat.php'; 
                                    break;
                                case 'file_memoriaTecnica':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/envia-form-solicitud-memoria-tecnica.php'; 
                                     break;                                                                      
                            } 
                            ?>
                            </span>                            
  			            </div>
                          <?php }?>
                <?php endforeach; ?>
                <?php } else { 
                    echo "<div class='alert alert-warning'>Cap documentació.</div>";
                    }   
                ?>
            </div>

            <!-- Documentación opcional-->
            <h3>Documentació <strong>opcional</strong> de l'expedient:</h3>
              <div class="docsExpediente">
  	                <div class = "header-wrapper-docs header-wrapper-docs-solicitud">
        	            <div >Rebut el</div>
			            <div >Document</div>
    		            <div >Tràmit</div>
			            <div >Estat</div>
  		            </div>
                    <?php if($documentos){ ?>
                    <?php foreach($documentos as $docs_opc_item): 
			            $path = $docs_opc_item->created_at;
			            $parametro = explode ("/",$path);
			            $tipoMIME = $docs_opc_item->type;
                        
                    if ($convocatoria >= '2022') {
			            switch ($docs_opc_item->corresponde_documento) {
			    	        case 'file_memoriaTecnica':
					            $nom_doc = "La memòria tècnica";
					            break;
				            case 'file_certificadoATIB':
					            $nom_doc = "Certificat estar al corrent obligacions amb Agència Estatal de l'Administració Tributària i Agència Tributària IB";
					            break;
				            case 'file_nifEmpresa':	
					            $nom_doc = "Còpia del NIF de l'empresa";
					            break;
				            case 'file_enviardocumentoIdentificacion':	
					            $nom_doc = "Identificació de la persona sol·licitant i/o la persona autoritzada per l’empresa";
					            break;
                            case 'file_logotipoEmpresaIls':	
                                $nom_doc = "Logotip de l'empresa";
                                break;
			                default:
					        $nom_doc = $docs_opc_item->corresponde_documento; 
			            } 
                    } else {
                        $nom_doc = $docs_opc_item->name;
                    }?>

                    <?php if ($docs_opc_item->docRequerido === 'NO') {?>
  			            <div id ="fila" class = "detail-wrapper-docs general">
    				        <span id = "convocatoria" class = "detail-wrapper-docs-col date-docs-col"><?php echo str_replace ("_", " / ", $docs_opc_item->selloDeTiempo); ?></span>
				            <span id = "tipoTramite" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docs_opc_item->name.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
      			            <span id = "fechaCompletado" class = "detail-wrapper-docs-col"><?php echo $docs_opc_item->tipo_tramite; ?></span>
                            <!-- <span id = "custodia" class = "detail-wrapper-docs-col"><a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$docs_opc_item->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $docs_opc_item->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a></span> -->
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
  			            </div>
                    <?php }?>
                    <?php endforeach; ?>
                </div>
                
                <?php } else { 
                    echo "<div class='alert alert-warning'>Cap documentació.</div>";
                    }   
                ?>


            <br>
            <div class="alert alert-info">
            <small>Estat de la signatura de la declaració responsable i de la sol·licitud:</small>
            <?php

	//Compruebo el estado de la firma de la declaración responsable.
    $thePublicAccessId = $modelExp->getPublicAccessId ($expedientes['id']);

	if (isset($thePublicAccessId))
		{
		$PublicAccessId = $thePublicAccessId->PublicAccessId;
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
			echo $estado_firma;
		}?>
            <br>
            <a href="<?php echo base_url('/public/index.php/expedientes/muestradocumento/'.$expedientes['nif'].'_dec_res_solicitud.pdf'.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>"><small class = 'verSello' id='<?php echo $docs_item->publicAccessIdCustodiado;?>'>La declaració responsable sense signar</small></a>
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
                    <label for = "fecha_REC"><strong>Data REC sol·licitud:</strong></label>
			        <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC']);?>"/>
			        <!-- <input type = "text" placeholder = "aaaa-mm-dd hh:mm:ss" name = "fecha_REC" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC" value = "<?php //echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_enmienda']);?>"/> -->
                </div>
                <div class="form-group solicitud">
                    <label for = "ref_REC"><strong>Referència REC sol·licitud:</strong></label>
                    <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" name = "ref_REC" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "ref_REC"  maxlength = "16" value = "<?php echo $expedientes['ref_REC'];?>">
                </div>
                <div class="form-group solicitud">
                    <label for = "fecha_REC_enmienda"><strong>Data REC esmena:</strong></label>
		    	    <!-- <input type = "datetime-local" name = "fecha_REC_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC_enmienda" value = "<?php //echo date_format(date_create($expedientes['fecha_REC_enmienda']),"Y-m-d\Th:m");?>"/> -->
		    	    <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC_enmienda" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_enmienda']);?>"/>
                </div>		
                <div class="form-group solicitud">
                    <label for = "ref_REC_enmienda"><strong>Referència REC esmena:</strong></label>
                    <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" name = "ref_REC_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "ref_REC_enmienda"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_enmienda'];?>">
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento"><strong>Data firma requeriment:</strong></label>
                    <input type = "date" name = "fecha_requerimiento" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_requerimiento" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento']), 'Y-m-d');?>"/>
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento_notif"><strong>Data notificació requeriment:</strong></label>
                    <input type = "date" name = "fecha_requerimiento_notif" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_requerimiento_notif" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento_notif']), 'Y-m-d');?>"/>
                </div>

                <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class="form-group">
                        <button type="button" onclick = "javaScript: actualiza_fase_1_solicitud_expediente('exped-fase-1');" id="send_fase_1" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>    
            </form>
        </div>
        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
           <ol start ="1">
            <!----------------------------------------- Requeriment 2021 OK ------------------------------------------------>
	        <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/requerimiento.php';?></li>
            <!-------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Resolució desistiment per no esmenar  SIN VIAFIRMA ----------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-desestimiento-por-no-enmendar.php';?></li>
            <!-------------------------------------------------------------------------------------------------------------->
            </ol>
            <h3>Millores: <small class="alert alert-secondary" role="alert"><?php echo $ultimaMejoraSolicitud; ?></small></h3>
            <?php if($mejorasSolicitud): ?>
                <div class = "header-wrapper-docs-3 detail-wrapper-docs-justificacion">
        	        <div >Data rec</div>
   	  	            <div >Referència rec</div>
   	  	            <div >Acciò</div>
                </div>
               
                <div class='filas-container'>
                    <?php foreach($mejorasSolicitud as $mejorasSolicitud_item):?>
                        <div id ="mejora_<?php echo $mejorasSolicitud_item['id'];?>" class = "detail-wrapper-docs-3 detail-wrapper-docs-solicitud">
                            <span class = "detail-wrapper-docs-col"><?php echo $mejorasSolicitud_item['fecha_rec_mejora'] ;?></span>
                            <span class = "detail-wrapper-docs-col"><?php echo $mejorasSolicitud_item['ref_rec_mejora'] ;?></span>
                            <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$mejorasSolicitud_item['id'].'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target="#modalEliminaMejora"><strong>Elimina</strong></button>';?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!$mejorasSolicitud): ?>
              <span class="alert alert-info" role="alert">De moment, no hi ha millores!</span>
            <?php endif; ?>
            <div style="margin-top:1rem;color:blue;text-align:left;padding:.5rem;">
                <div class="mb-3">
                    <input type='datetime-local' title = "dd/mm/aaaa hh:mm:ss" name = "fechaRecMejora" class='form-control form-control-sm' id="fechaRecMejora"/>
                </div>
                <div class="mb-3">
                    <input type='text' placeholder = "El número del REC [GOIBE539761_2021]" name = "refRecMejora" class='form-control form-control-sm' id="refRecMejora" maxlength = "16"/>
                </div>
                    <button class="btn btn-success btn-lg btn-block btn-docs" onclick="insertaMejoraEnSolicitud()" id="addMejora">Afegir</button>
            </div>          
        </div>
        
        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs detail-wrapper-docs-justificacion">
        	        <div >Pujat el</div>
   	  	            <div >Document</div>
                    <div >Estat</div>                         
      	            <div >Acció</div>
                </div>
                <?php if($documentosExpediente): ?>
                <?php foreach($documentosExpediente as $docSolicitud_item): 
			                if($docSolicitud_item->fase_exped == 'Solicitud') {
    			                $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
	    		                $parametro = explode ("/",$path);
		    	                $tipoMIME = $docSolicitud_item->type;
			                    $nom_doc = $docSolicitud_item->name;
			                ?>
                            <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-solicitud">
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
                                <?php if (!$docSolicitud_item->publicAccessIdCustodiado) {?>
		                	        <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target = "#eliminaDocsExpediente"><strong>Elimina</strong></button>';?></span>		
    		                        <?php } else {?>
	    		                        <span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
    		                    <?php } ?>
	                        </div>
                        <?php 
                            }
                     endforeach; ?>
                <?php endif; ?>
            </div>

                <div id="eliminaDocsExpediente" class="modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style = "width: 60%;">
                            <div class="modal-header">
	    	                    Aquesta acció no es podrá desfer.
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

                <div id="modalEliminaMejora" class="modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style = "width: 60%;">
                            <div class="modal-header">
	    	                    Aquesta acció no es podrá desfer.
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
    		            		<h5 class="modal-title">Eliminar definitivament aquesta millora?</h5>
                                <div class="modal-footer">
		                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaMejoraSolicitud_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <script>
                        function myFunction_docs_IDI_click (id, nombre) {
        	                document.cookie = "documento_actual = " + id;
                            }
                        function opcion_seleccionada_click(respuesta) {
            	            document.cookie = "respuesta = " + respuesta;
                            }
                        function eliminaDocSolicitud_click() {
                	        console.log (getCookie("documento_actual"));
	                        let id = getCookie("documento_actual");
                            document.getElementById(id).disabled= true;
                            document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	                        console.log (getCookie("nuevo_estado"));
    	                    let corresponde_documento = 'file_resguardoREC';
	                        $.post("/public/assets/utils/delete_documento_expediente.php",{ id: id, corresponde_documento: corresponde_documento}, function(data){
                                location.reload();
    	    		        });	
                            }
                        function eliminaMejoraSolicitud_click() {
                            let id = getCookie("documento_actual");
                            document.getElementById(id).disabled= true;
                            document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
                            let corresponde_documento = 'file_resguardoREC';
                            $.post("/public/assets/utils/delete_mejora_solicitud.php",{ id: id }, function(data){
                                location.reload();
                            });	
                        }
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
                    <label for = "fecha_infor_fav_desf"><strong>Data firma informe favorable / desfavorable:</strong></label>
		            <input type = "date" name = "fecha_infor_fav_desf" class = "form-control send_fase_2" id = "fecha_infor_fav_desf" value = "<?php echo date_format(date_create($expedientes['fecha_infor_fav_desf']), 'Y-m-d');?>">
                </div>
		        <div class="form-group validacion">
                    <label for = "fecha_propuesta_resolucion"><strong>Data firma proposta resolució:</strong></label>
                    <input type = "date" name = "fecha_propuesta_resolucion" class = "form-control send_fase_2" id = "fecha_propuesta_resolucion" value = "<?php echo date_format(date_create($expedientes['fecha_propuesta_resolucion']), 'Y-m-d');?>">
                </div>
		        <div class="form-group validacion">
                    <label for = "fecha_propuesta_resolucion_notif"><strong>Data notificació proposta resolució:</strong></label>
                    <input type = "date" name = "fecha_propuesta_resolucion_notif" class = "form-control send_fase_2" id = "fecha_propuesta_resolucion_notif" value = "<?php echo date_format(date_create($expedientes['fecha_propuesta_resolucion_notif']), 'Y-m-d');?>">
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
                        <button type="button" onclick = "javaScript: actualiza_fase_2_validacion_expediente('exped-fase-2');" id="send_fase_2" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>                  
        </form>
        </div>        
    	    <script>
		     /*    $('#fecha_REC_amp_termino').mask('99/99/9999 99:99:99');
		        $('#tel_consultor').mask('999999999'); */
	        </script>

            <?php foreach($config_fechas_limite as $config_item): 
	                $dias_fecha_lim_justificar	= $config_item->dias_fecha_lim_justificar;
	                $meses_fecha_lim_consultoria = $config_item->meses_fecha_lim_consultoria;
                endforeach; 

            $mesesPrograma = explode("#",$meses_fecha_lim_consultoria);
            $mesesPrograma = str_replace("{","",$mesesPrograma);
            $mesesPrograma = str_replace("}","",$mesesPrograma);
            $programaI = explode(",",$mesesPrograma[0]);
            $programaII = explode(",",$mesesPrograma[1]);
            $programaIII = explode(",",$mesesPrograma[2]);

            switch ($expedientes['tipo_tramite']) {
	            case 'Programa I':
		            $add_meses = str_replace("'intervalo':'", "", $programaI[1]);
		            $add_meses = str_replace("'", "", $add_meses);
		            break;
	            case 'Programa II':
    		        $add_meses = str_replace("'intervalo':'", "", $programaII[1]);
		            $add_meses = str_replace("'", "", $add_meses);
		            break;
	            case 'Programa III':
    		        $add_meses = str_replace("'intervalo':'", "", $programaIII[1]);
		            $add_meses = str_replace("'", "", $add_meses);
		            break;
	            }
        ?>
        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="3">
            <!-----------------------------------------Informe favorable amb requeriment------------>
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-favorable-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe favorable sense requeriment--------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-favorable-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe desfavorable sense requeriment-->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-desfavorable-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe desfavorable amb requeriment-->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-desfavorable-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta resolucio concessió ajut_ amb requeriment SIN VIAFIRMA-->
            <?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-concesion-con-requerimiento.php';?>
            <!-------------------------------------------------------------------------------------------------------------------->
            <!-----------------------------------------Proposta resolucio concessió ajut_ sense requeriment SIN VIAFIRMA-->
            <?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-concesion-sin-requerimiento.php';?>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta resolucio denegació ajut_ amb requeriment SIN VIAFIRMA-->
	        <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-denegacion-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta resolucio denegació ajut_ sin requeriment SIN VIAFIRMA-->
	        <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-denegacion-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució i resolució de pagament sense requeriment SIN VAIFIRMA-->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-pago-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució i resolució de pagament amb requeriment SIN VIAFIRMA-->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-pago-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució denegació amb requeriment SIN VIAFIRMA-->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-denegacion-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució denegació_ sense requeriment SIN VIAFIRMA-->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-denegacion-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució concesió adhesió ILS sense requeriment--------->
            <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-concesion-adhesion-ils-sin-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució de concessió SIN VIAFIRMA-->
            <?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-desestimiento.php';?>
            <!------------------------------------------------------------------------------------------------------>            
        </ol>
        </div>
        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs detail-wrapper-docs-justificacion">
    	            <div >Pujat el</div>
   	  	            <div >Document</div>
		            <div >Estat</div>                     
      	            <div >Acció</div>
                </div>
            <?php if($documentosExpediente): ?>
            <?php foreach($documentosExpediente as $docSolicitud_item): 			            
                if($docSolicitud_item->fase_exped == 'Validacion') {
			        $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			        $parametro = explode ("/",$path);
			        $tipoMIME = $docSolicitud_item->type;
			        $nom_doc = $docSolicitud_item->name;?>

                    <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-validacion">
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

        		        <?php if (!$docSolicitud_item->publicAccessIdCustodiado) {?>
	        		        <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target = "#myModalDocValidacion"><strong>Elimina</strong></button>';?></span>		
    		            <?php } else {?>
            	    		<span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
                		<?php } ?>
	                </div>
                <?php }
                endforeach; ?>
                <?php endif; ?>
            </div>
            <div id="myModalDocValidacion" class="modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style = "width: 60%;">
                        <div class="modal-header">
        		            Aquesta acció no es podrá desfer.
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
    			            <h5 class="modal-title">Eliminar definitivament el document?</h5>
                            <div class="modal-footer">
    		                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocValidacion_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  	
            <script>
                function myFunction_docs_IDI_click (id, nombre) {
    	        document.cookie = "documento_actual = " + id;
                }
                function opcion_seleccionada_click(respuesta) {
    	        document.cookie = "respuesta = " + respuesta;
                }
                function eliminaDocValidacion_click() {
    	        console.log (getCookie("documento_actual"));
	            let id = getCookie("documento_actual");

	            let corresponde_documento = 'file_resguardoREC';
	            $.post("/public/assets/utils/delete_documento_expediente.php",{ id: id, corresponde_documento: corresponde_documento}, function(data){
    			    location.reload();
			    });	
                }
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
            <h5 class ="upload-docs-type-label">[.pdf]:</h5>
            <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Validacion');?>" onsubmit="logSubmit('subeDocsValidacionBtn')" name="subir_doc_faseExpedValidacion" id="subir_doc_faseExpedValidacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
 
            <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class = "content-file-upload">
                    <div>
                        <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedValidacion[]" id="nombrefaseExpedValidacion" size="20" accept=".pdf" multiple />
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

<div id="ejecucion_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-3" id="exped-fase-3" method="post" accept-charset="utf-8">
            <div class="row">
                <div class="col">
                    <div class="form-group ejecucion">
                        <label for = "fecha_kick_off"><strong>Data de kick-off:</strong></label>
                        <input type = "date" name = "fecha_kick_off" class = "form-control send_fase_3" id = "fecha_kick_off" onchange = "javaScript: actualizaFechaConsultoria(this.value, <?php echo $add_meses;?>);" value = "<?php if ($expedientes['fecha_kick_off'] != null) {echo date_format(date_create($expedientes['fecha_kick_off']), 'Y-m-d');}?>">
                    </div>
		            <div class="form-group ejecucion">
                        <label for = "fecha_limite_consultoria"><strong>Data límit per realitzar la consultoria:</strong></label>
                        <input type = "date" name = "fecha_limite_consultoria" class = "form-control send_fase_3" id = "fecha_limite_consultoria" value = "<?php echo date_format(date_create($expedientes['fecha_limite_consultoria']), 'Y-m-d');?>">
                    </div>
    		        <div class="form-group ejecucion">
                        <label for = "fecha_reunion_cierre"><strong>Data reunió tancament:</strong></label>
                        <input type = "date" name = "fecha_reunion_cierre" class = "form-control send_fase_3" id = "fecha_reunion_cierre" onchange = "javaScript: actualizaFechas(this.value, <?php echo $dias_fecha_lim_justificar;?>);" value = "<?php echo date_format(date_create($expedientes['fecha_reunion_cierre']), 'Y-m-d');?>">
                    </div>
    		        <div class="form-group ejecucion">
                        <label for = "fecha_limite_justificacion"><strong>Data límit per justificar l'ajut rebut:</strong></label>
                        <input type = "date" name = "fecha_limite_justificacion" class = "form-control send_fase_3" id = "fecha_limite_justificacion" value = "<?php echo date_format(date_create($expedientes['fecha_limite_justificacion']), 'Y-m-d');?>">
                    </div>
                    <div class="form-group ejecucion">
                        <label for = "fecha_max_desp_ampliacion"><strong>Data màxima després d'ampliació:</strong></label>
                        <input type = "date" name = "fecha_max_desp_ampliacion" class = "form-control send_fase_3" id = "fecha_max_desp_ampliacion" value = "<?php echo date_format(date_create($expedientes['fecha_max_desp_ampliacion']), 'Y-m-d');?>">
                    </div>	                
                <!--</div>
                <div class="col">-->
                    <div class="form-group ejecucion">
                        <label for = "fecha_REC_amp_termino"><strong>Data REC ampliació termini:</strong></label>
		    	        <!-- <input type = "datetime-local" name = "fecha_REC_amp_termino" class = "form-control send_fase_3" id = "fecha_REC_amp_termino" value = "<?php //echo date_format(date_create($expedientes['fecha_REC_amp_termino']),"Y-m-d\Th:m");?>"/> -->
		    	        <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_amp_termino" class = "form-control send_fase_3" id = "fecha_REC_amp_termino" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_amp_termino']);?>"/>

                    </div>
    		        <div class="form-group ejecucion">
                        <label for = "ref_REC_amp_termino"><strong>Referència REC ampliació termini:</strong></label>
                        <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" name = "ref_REC_amp_termino" class = "form-control send_fase_3" id = "ref_REC_amp_termino"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_amp_termino'];?>">
        	        </div>
    		        <div class="form-group ejecucion">
                        <label for = "fecha_amp_termino"><strong>Data notificació ampliació termini:</strong></label>
                        <input type = "date"  placeholder = "dd/mm/yyyy" name = "fecha_amp_termino" class = "form-control send_fase_3" id = "fecha_amp_termino" minlength = "10" maxlength = "10" value = "<?php echo date_format(date_create($expedientes['fecha_amp_termino']), 'Y-m-d');?>">
                    </div>

                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                        <div class="form-group">
                            <button type="button"  onclick = "javaScript: actualiza_fase_3_ejecucion_expediente('exped-fase-3');" id="send_fase_3" class="btn-itramits btn-success-itramits">Actualitzar</button>
                        </div>
                <?php }?>

                </div>
            </div>
        </form>
        </div>
        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start="14">
            <!-----------------------------------------15.-abril_Acta Kick off ------------------------------------>
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/acta-de-kickoff.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------17.-mayo_Acta de cierre ---->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/acta-de-cierre.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------18.-mayo_Acord de confidencialitat ------------------------------------>
            <!--<li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/acuerdo-de-confidencialidad.php';?></li>-->
            <!---------------------------------------------------------------------------------------------------------------->
            <!-----------------------------------------19.-resolución ampliación plazo ------------------------------------>
            <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-ampliacion-plazo.php';?></li> -->
            <!---------------------------------------------------------------------------------------------------------------->
            </ol>
        </div>

        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs detail-wrapper-docs-justificacion">
    	            <div >Pujat el</div>
   	  	            <div >Document</div>
		            <div >Estat</div>                     
      	            <div >Acció</div>
                </div>
            <?php if($documentosExpediente): ?>
            <?php foreach($documentosExpediente as $docSolicitud_item): 			            
                if($docSolicitud_item->fase_exped == 'Ejecucion') {
			        $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			        $parametro = explode ("/",$path);
			        $tipoMIME = $docSolicitud_item->type;
			        $nom_doc = $docSolicitud_item->name;
			        ?>
                    <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-ejecucion">
      	                <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
   		                <span id = "convocatoria" class = "detail-wrapper-docs-col"><a	title="<?php echo $nom_doc;?>" href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                       <!--  <span id = "custodia" class = "detail-wrapper-docs-col"><a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$docSolicitud_item->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $docSolicitud_item->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a></span> -->
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
    	        		    <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle = "modal" data-bs-target = "#myModalDocEjecucion"><strong>Elimina</strong></button>';?></span>		
        		        <?php } else {?>
    	        		    <span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
        		        <?php } ?>			
		            </div>
                    <?php }
                endforeach; ?>
            <?php endif; ?>
            </div>
            <div id="myModalDocEjecucion" class="modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style = "width: 60%;">
                        <div class="modal-header">
    		                Aquesta acció no es podrá desfer.
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
    	    		        <h5 class="modal-title">Eliminar definitivament el document?</h5>
                            <div class="modal-footer">
    		                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocValidacion_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function myFunction_docs_IDI_click (id, nombre) {
    	            document.cookie = "documento_actual = " + id;
                    }
                function opcion_seleccionada_click(respuesta) {
        	        document.cookie = "respuesta = " + respuesta;
                    }
                function eliminaDocValidacion_click() {
    	            console.log (getCookie("documento_actual"));
	                let id = getCookie("documento_actual");
	                let corresponde_documento = 'file_resguardoREC';
	                $.post("/public/assets/utils/delete_documento_expediente.php",{ id: id, corresponde_documento: corresponde_documento}, function(data){
    			        location.reload();
			        });	
                    }
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
            <h5 class ="upload-docs-type-label">[.pdf]:</h5>
            <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Ejecucion');?>" onsubmit="logSubmit('subeDocsEjecucionBtn')" name="subir_doc_faseExpedEjecucion" id="subir_doc_faseExpedEjecucion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                
                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                <div class = "content-file-upload">
                    <div>
                        <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedEjecucion[]" id="nombrefaseExpedEjecución" size="20" accept=".pdf" multiple />
                    </div>
                    <div>
                        <input id="subeDocsEjecucionBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                    </div>
                </div>
                <?php }?>
            </form> 
        </div> <!--Cierre columna documentos-->
        </div>
    </div><!-- cierre fila fase ejecución -->
</div> <!-- Cierre tab fase ejecución-->

<div id="justificacion_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-4" id="exped-fase-4" method="post" accept-charset="utf-8">
            <div class="row">
            <div class="col">            
            <div class="form-group justificacion">
            <label for = "fecha_REC_justificacion"><strong>Data REC justificació:</strong></label>
			<!-- <input type = "datetime-local" name = "fecha_REC_justificacion" class = "form-control send_fase_4" id = "fecha_REC_justificacion" value = "<?php //echo date_format(date_create($expedientes['fecha_REC_justificacion']),"Y-m-d\Th:m");?>" /> -->
			<input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_justificacion" class = "form-control send_fase_4" id = "fecha_REC_justificacion" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_justificacion']);?>" />

            </div>	
		    <div class="form-group justificacion">
            <label for = "ref_REC_justificacion"><strong>Referència REC justificació:</strong></label>
            <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" name = "ref_REC_justificacion" class = "form-control send_fase_4" id = "ref_REC_justificacion"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_justificacion'];?>">
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
            <label for = "fecha_REC_requerimiento_justificacion"><strong>Data REC requeriment justificació:</strong></label>
			<!-- <input type = "datetime-local" name = "fecha_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "fecha_REC_requerimiento_justificacion" value = "<?php echo date_format(date_create($expedientes['fecha_REC_requerimiento_justificacion']),"Y-m-d\Th:m");?>" /> -->
			<input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "fecha_REC_requerimiento_justificacion" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_requerimiento_justificacion']);?>" />

            </div>	
		    <div class="form-group justificacion">
            <label for = "ref_REC_requerimiento_justificacion"><strong>Referència REC requeriment justificació:</strong></label>
            <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" name = "ref_REC_requerimiento_justificacion" class = "form-control send_fase_4" id = "ref_REC_requerimiento_justificacion"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_requerimiento_justificacion'];?>">
        	</div>

                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                    <div class="form-group">
                        <button type="button" onclick = "javaScript: actualiza_fase_4_justificacion_expediente('exped-fase-4');" id="send_fase_4" onChange="avisarCambiosEnFormulario('send_fase_4', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>
            
            </div>
            </div>
        </form>
        </div>
        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="17">
            <!----------------------------------------- Resolución de concesión DOC 17---------------------------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-concesion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Informe inicio requerimento justificación DOC 18---------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/inicio-requerimiento-subsanacion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Requerimiento de subsanación justificación DOC 19--------------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/requerimiento-subsanacion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Informe post subsanación de la documentación de justificación DOC 20---->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-sobre-subsanacion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Resolució de concesió amb requeriment (20b) ---->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-concesion-con-requerimiento-20b.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->                                      
        </ol>    
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs detail-wrapper-docs-justificacion">
                    <div >Pujat el</div>
                    <div >Document</div>
                    <div >Estat</div>               
                    <div >Acció</div>
                </div>

                <?php if($documentosExpediente): ?>
                    <?php foreach($documentosExpediente as $docSolicitud_item): 			            
                            if($docSolicitud_item->fase_exped == 'Justificac') {
                                $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
                                $parametro = explode ("/",$path);
                                $tipoMIME = $docSolicitud_item->type;
                                $nom_doc = $docSolicitud_item->name;
                    ?>
                    <div id ="fila" class = "detail-wrapper-docs detail-wrapper-docs-justificacion">
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
                            <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: justificacion_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle = "modal" data-bs-target = "#myModalDocJustificacion"><strong>Elimina</strong></button>';?></span>		
                        <?php } else {?>
                            <span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
                        <?php } ?>			
                    </div>
                <?php }
                    endforeach; ?>
                <?php endif; ?>

                <div id="myModalDocJustificacion" class="modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style = "width: 60%;">
                            <div class="modal-header">
                                Aquesta acció no es podrá desfer.
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="modal-title">Eliminar definitivament aquest document?</h5>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocJustificacion_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function justificacion_docs_IDI_click (id, nombre) {
                        document.cookie = "documento_actual = " + id;
                    }
                    function opcion_seleccionada_click(respuesta) {
                        document.cookie = "respuesta = " + respuesta;
                    }
                    function eliminaDocJustificacion_click() {
                        let id = getCookie("documento_actual");
                        document.getElementById(id).disabled= true;
                        document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
                        let corresponde_documento = 'file_resguardoREC';
                        $.post("/public/assets/utils/delete_documento_expediente.php",{ id: id, corresponde_documento: corresponde_documento}, function(data){
                            location.reload();
                        });	
                    }
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
                
                <h5 class ="upload-docs-type-label">[.zip]:</h5>
                <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Justificacion');?>" onsubmit="logSubmit('subeDocsJustificacionBtn')" name="subir_doc_faseExpedJustificacion" id="subir_doc_faseExpedJustificacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">

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

<div id="deses_ren_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-5" id="exped-fase-5" method="post" accept-charset="utf-8">
            <div class="form-group desistimiento">
                <label for = "fecha_REC_desestimiento"><strong>Data REC desistiment:</strong></label>
	    	    <!-- <input type = "datetime-local" name = "fecha_REC_desestimiento" class = "form-control send_fase_5" id = "fecha_REC_desestimiento" value = "<?php echo date_format(date_create($expedientes['fecha_REC_desestimiento']),"Y-m-d\Th:m");?>"/> -->
	    	    <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_desestimiento" class = "form-control send_fase_5" id = "fecha_REC_desestimiento" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_desestimiento']);?>"/>
            </div>
		    <div class="form-group desistimiento">
                <label for = "ref_REC_desestimiento"><strong>Referència REC desistiment:</strong></label>
                <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" maxlength = "16" name = "ref_REC_desestimiento" class = "form-control send_fase_5" id = "ref_REC_desestimiento" value = "<?php echo $expedientes['ref_REC_desestimiento'];?>">
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
                    <button type="button" onclick = "javaScript: actualiza_fase_5_desestimiento_expediente('exped-fase-5');" id="send_fase_5" onChange="avisarCambiosEnFormulario('send_fase_5', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                </div>
                <?php }?>

            </form>
        </div>

        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start="22">
                <!----------------------------------------- Reseolución desestimiento  DOC 22 SIN VIAFIRMA -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-desestimiento-por-renuncia.php';?></li>
                <!------------------------------------------------------------------------------------------------->
                <!----------------- Propuesta resolución revocación por no justificar  DOC 23 SIN VIAFIRMA -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-revocacion-por-no-justificar.php';?></li>
                <!------------------------------------------------------------------------------------------------->
                <!----------------- Resolución revocación por no justificar  DOC 24 SIN VIAFIRMA -------->
                <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-revocacion-por-no-justificar.php';?></li>
                <!------------------------------------------------------------------------------------------------->    
            </ol>
        </div>

        <div class="col docsExpediente">
        <div class="col">
            <h3>Documents de l'expedient:</h3>
            <div class="docsExpediente">
                <div class = "header-wrapper-docs detail-wrapper-docs-justificacion">
    	            <div >Pujat el</div>
   	  	            <div >Document</div>
		            <div >Custodia</div>               
      	            <div >Acció</div>
                </div>

            <?php if($documentosExpediente): ?>
            <?php foreach($documentosExpediente as $docSolicitud_item): 			            
                if($docSolicitud_item->fase_exped == 'Desestimie') {
			    $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			    $parametro = explode ("/",$path);
			    $tipoMIME = $docSolicitud_item->type;
			    $nom_doc = $docSolicitud_item->name;
			    ?>
                <div id ="fila" class = "detail-wrapper-docs detail-wrapper-docs-desestimiento">
      	            <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
   		            <span id = "convocatoria" class = "detail-wrapper-docs-col"><a	title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                    <span id="custodia" class = "detail-wrapper-docs-col"><a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$docSolicitud_item->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $docSolicitud_item->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a></span>
    		        <?php if (!$docSolicitud_item->publicAccessIdCustodiado) {?>
    	    		    <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: desestimiento_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-toggle = "modal" data-target = "#myModalDocDesestimiento"><strong>Elimina</strong></button>';?></span>		
    		        <?php } else {?>
        	    		<span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
        		    <?php } ?>			
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

            <script>
                function desestimiento_docs_IDI_click (id, nombre) {
    	            document.cookie = "documento_actual = " + id;
                    }
                function opcion_seleccionada_click(respuesta) {
        	        document.cookie = "respuesta = " + respuesta;
                    }
                function eliminaDocDesestimiento_click() {
	                let id = getCookie("documento_actual");
                    document.getElementById(id).disabled= true;
                    document.getElementById(id).innerHTML= "<div class='.info-msg'>Un moment, <br>eliminant ...</div>";
	                let corresponde_documento = 'file_resguardoREC';
	                $.post("/public/assets/utils/delete_documento_expediente.php",{ id: id, corresponde_documento: corresponde_documento}, function(data){
    			        location.reload();
			        });	
                    }
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
                        <input id="subeDocsDesestimientoBtn" type="submit" class = "btn btn-success btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                    </div>
                </div>
                <?php }?>

            </form>             
        </div>
    </div>
</div>
</form>