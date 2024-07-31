<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

    echo '<div class="alert alert-warning" role="alert">Nombre total de sol·licituds d´aquesta línia d´ajuda: '.$totalConvocatorias.'</div>';

    /* $convocatoriaEnCurso = $configuracion['convocatoria']; */
    $convocatoriaEnCurso = $configuracionLinea['convocatoria'];

    $esAdmin = ($session->get('rol') == 'admin');
    $esConvoActual = ($convocatoria == $convocatoriaEnCurso);

    $expedienteID = [
        'id'  => $id,
        'programa' => $programa
    ];
    $session->set($expedienteID);
	?>

    <!----------------- Para poder consultar en VIAFIRMA el estado de los modelos de documentos --------------------------->
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/execute-curl.php';?>
    <!--------------------------------------------------------------------------------------------------------------------->

<div class="tab_fase_exp">
    <button id="detall_tab_selector" class="tablinks" onclick="openFaseExped(event, 'detall_tab', ' #ccc')">Detall</button>  
    <button id="solicitud_tab_selector" class="tablinks" onclick="openFaseExped(event, 'solicitud_tab', '#f6b26b')">Sol·licitud</button>
</div>
<?php echo "Data sol·licitud: ". $expedientes['fecha_solicitud'];?> <?php echo "Data complert: ". $expedientes['fecha_completado'];?>
<div id="detall_tab" class="tab_fase_exp_content" style="display:block;">
    <div class="row">
        <div class="col docsExpediente">
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>"  name="exped-fase-0" id="exped-fase-0" method="post" accept-charset="utf-8">
	        <div class = "row">	
	            <div class="col">
                    <h3>Detall:</h3>
     			    <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $expedientes['id']; ?>"> 
                    <?php $ayuntamiento = explode("#", $expedientes['empresa']);?>
                    <div class="form-group general">
                        <label for="empresa">Ajuntament de:</label>
                        <input type="text" name="empresa" class="form-control send_fase_0" id = "empresa" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> placeholder="Nom del sol·licitant" value="<?php echo strtoupper($ayuntamiento[1]); ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif">NIF:</label>
                        <input type="text" name="nif" class="form-control" id = "nif" disabled readonly placeholder="NIF del sol·licitant" value="<?php echo $expedientes['nif']; ?>">
                    </div>

                    <div class="form-group general">
                        <label for="alcalde_felib">Batle/Batlessa:</label>
                        <input type="text" name="alcalde_felib" class="form-control send_fase_0" id = "alcalde_felib" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> placeholder="Nom del sol·licitant" value="<?php echo $expedientes['alcalde_felib']; ?>">
                    </div>
    		        <div class="form-group general">
                        <label for="fecha_completado">Data de la sol·licitud:</label>
                        <strong><?php echo date_format(date_create($expedientes['fecha_solicitud']), 'd/m/Y H:i:s'); ?></strong>
		        	    <input type="hidden" name="fecha_completado" class="form-control" id = "fecha_completado" value="<?php echo $expedientes['fecha_completado']; ?>">
			            <input type="hidden" name="fecha_solicitud" class="form-control" id = "fecha_solicitud" value="<?php echo $expedientes['fecha_solicitud']; ?>">
                    </div>
    		        <div class="form-group general">
                        <label for="programa">Linia de tràmit:</label>
		    	        <input type="text" name="programa" class="form-control" id = "programa" list="listaProgramas" readonly disabled value="<?php echo $expedientes['tipo_tramite'];?>">
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
                        <input type="text" name="cpostal" class="form-control" readonly disabled id = "cpostal" maxlength = "5" size="5" required placeholder="Codi postal del sol·licitant" value="<?php echo $expedientes['cpostal'];?>">
                    </div>      	  		            	  
                   
                </div>
                <div class="col">
                    <div class="form-group general">
                        <label for="responsable_felib">Responsable:</label>
                        <input type="text" name="responsable_felib" class="form-control" readonly id = "responsable_felib" disabled value="<?php echo $expedientes['responsable_felib'];?>">
                    </div>
                    <div class="form-group general">
                        <label for="cargo_felib">Càrrec:</label>
                        <input type="text" name="cargo_felib" class="form-control" readonly id = "cargo_felib" disabled value="<?php echo $expedientes['cargo_felib'];?>">
                    </div>
              	    <div class="form-group general">
                        <label for="email_rep"><strong>Adreça electrònica a efectes de notificacions:</strong></label>
                        <input type="email" name="email_rep" class="form-control send_fase_0" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "email_rep" placeholder="Adreça electrònica a efectes de notificacions" value="<?php echo $expedientes['email_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="telefono">Telèfon:</label>
                        <input type="tel" name="telefono" class="form-control" readonly id = "telefono" disabled value="<?php echo $expedientes['telefono'];?>">
                    </div>
                    <div class="form-group general">
                        <label for="telefono_rep"><strong>Mòbil a efectes de notificacions:</strong></label>
                        <input type="tel" name="telefono_rep" class="form-control send_fase_0" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "telefono_rep" placeholder = "Mòbil a efectes de notificacions" minlength = "9" maxlength = "9" value = "<?php echo $expedientes['telefono_rep']; ?>">
                    </div>
                    <hr>
                    <div class="form-group general">
                        <label for="tecnico_felib">Tècnic/a de contacte:</label>
                        <input type="text" name="tecnico_felib" class="form-control" readonly id = "tecnico_felib" disabled value="<?php echo $expedientes['tecnico_felib'];?>">
                    </div>
                    <div class="form-group general">
                        <label for="cargo_tecnico_felib">Càrrec:</label>
                        <input type="text" name="cargo_tecnico_felib" class="form-control" readonly id = "cargo_tecnico_felib" disabled value="<?php echo $expedientes['cargo_tecnico_felib'];?>">
                    </div>
                    <div class="form-group general">
                        <label for="mail_tecnico_felib">Adreça electrònica:</label>
                        <input type="text" name="mail_tecnico_felib" class="form-control" readonly id = "mail_tecnico_felib" disabled value="<?php echo $expedientes['mail_tecnico_felib'];?>">
                    </div>
                    <div class="form-group general">
                        <label for="tel_tecnico_felib">Telèfon:</label>
                        <input type="tel" name="tel_tecnico_felib" class="form-control" readonly id = "tel_tecnico_felib" disabled value="<?php echo $expedientes['tel_tecnico_felib'];?>">
                    </div>
                    <div class="form-group general">
                        <label for="movil_tecnico_felib">Mòbil:</label>
                        <input type="tel" name="movil_tecnico_felib" class="form-control" readonly id = "movil_tecnico_felib" disabled value="<?php echo $expedientes['movil_tecnico_felib'];?>">
                    </div>                    
    		    <div class="form-group general">
                    <label for="tecnicoAsignado">Tècnica asignada:</label>
                    <input type="text" name="tecnicoAsignado" onchange="avisarCambiosEnFormulario('send_fase_0', this.id)" list="listaTecnicos" class="form-control send_fase_0" id = "tecnicoAsignado" min="0" placeholder="Tècnica asignada" value="<?php echo $expedientes['tecnicoAsignado']; ?>">
			        <datalist id="listaTecnicos">
    			        <option value="Alejandra Gelabert">
				        <option value="Antonia Medina">
				        <option value="Beatriz Pino Roca">
				        <option value="Caterina Mas">
				        <option value="María del Carmen Muñoz Adrover">
				        <option value="Marta Riutord">
				        <option value="Pilar Jordi Amorós">
  			        </datalist>
		        </div>

		        <div class="form-group general">
                    <label for = "situacion_exped"><strong>Situació:</strong></label>
	    		    <select class="form-control send_fase_0" id = "situacion_exped" name = "situacion_exped" required onchange="compruebaExistenciaFecha('send_fase_0', this.id)">
    		    		<option disabled <?php if ($expedientes['situacion'] == "") { echo "selected"; }?> value = ""><span>Selecciona una opció:</span></option>
                        <optgroup style="background-color:#F51720;color:#000;" label="Fase sol·licitud:">
                            <option <?php if ($expedientes['situacion'] === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitSolicitud"> No ha passat per la SEU electrònica</option>
                            <option <?php if ($expedientes['situacion'] === "pendiente") { echo "selected";}?> value = "pendiente" class="sitSolicitud"> Pendent de validar</option>
                           <!--  <option <?php if ($expedientes['situacion'] === "comprobarAnt") { echo "selected";}?> value = "comprobarAnt" class="sitSolicitud"> Comprovar Antonia</option>
                            <option <?php if ($expedientes['situacion'] === "comprobarAntReg") { echo "selected";}?> value = "comprobarAntReg" class="sitSolicitud"> Comprovar Antonia amb <br>requeriment pendent</option>
                            <option <?php if ($expedientes['situacion'] === "emitirReq") { echo "selected";}?> value = "emitirReq" class="sitSolicitud"> Emetre requeriment</option>
                            <option <?php if ($expedientes['situacion'] === "firmadoReq") { echo "selected";}?> value = "firmadoReq" class="sitSolicitud"> Requeriment signat</option>
                            <option <?php if ($expedientes['situacion'] === "notificadoReq") { echo "selected";}?> value = "notificadoReq" class="sitSolicitud"> Requeriment notificat</option>
                            <option <?php if ($expedientes['situacion'] === "emitirDesEnmienda") { echo "selected";}?> value = "emitirDesEnmienda" class="sitSolicitud"> Emetre desistiment <br>per esmena</option>
                            <option <?php if ($expedientes['situacion'] === "emitidoDesEnmienda") { echo "selected";}?> value = "emitidoDesEnmienda" class="sitSolicitud"> Desistiment per <br>esmena emès</option>
							<option <?php if ($expedientes['situacion'] === "Desestimiento") { echo "selected";}?> value = "Desestimiento" class="sitSolicitud"> Desistiment</option> -->
                        </optgroup>
                        <optgroup style="background-color:#1ecbe1;color:#000;" label="Fase validació:">
                            <!-- <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients favorables:"> -->
                            <option <?php if ($session->get('situacion_fltr') == "Validado") { echo "selected";}?> value = "Validado" class="sitValidacion"> Validat</option>
                              <!--   <option <?php if ($expedientes['situacion'] === "emitirIFPRProvPago") { echo "selected";}?> value = "emitirIFPRProvPago" class="sitValidacion"> IF + PR Provisional emetre</option>
    				            <option <?php if ($expedientes['situacion'] === "emitidoIFPRProvPago") { echo "selected";}?> value = "emitidoIFPRProvPago" class="sitValidacion"> IF + PR Provisional emesa</option>
	    			            <option <?php if ($expedientes['situacion'] === "emitirPRDefinitiva") { echo "selected";}?> value = "emitirPRDefinitiva" class="sitValidacion"> PR definitiva emetre</option>
							    <option <?php if ($expedientes['situacion'] === "emitidaPRDefinitiva") { echo "selected";}?> value = "emitidaPRDefinitiva" class="sitValidacion"> PR definitiva emesa</option>
                        	    <option <?php if ($expedientes['situacion'] === "emitirResConcesion") { echo "selected";}?> value = "emitirResConcesion" class="sitValidacion"> Resolució de concessió emetre</option>
                        	    <option <?php if ($expedientes['situacion'] === "emitidaResConcesion") { echo "selected";}?> value = "emitidaResConcesion" class="sitValidacion"> Resolució de concessió emesa</option>
            		            <option <?php if ($expedientes['situacion'] === "inicioConsultoria") { echo "selected";}?> value = "inicioConsultoria" class="sitValidacion"> Inici de consultoria</option> -->
                            </optgroup>   
                           <!--  <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients NO favorables:">
                                <option <?php if ($expedientes['situacion'] === "emitirIDPDenProv") { echo "selected";}?> value = "emitirIDPDenProv" class="sitValidacion"> ID + P denegació provisional emetre</option>
				                <option <?php if ($expedientes['situacion'] === "emitidoIDPDenProv") { echo "selected";}?> value = "emitidoIDPDenProv" class="sitValidacion"> ID + P denegació provisional emesa</option>
    				            <option <?php if ($expedientes['situacion'] === "emitirPDenDef") { echo "selected";}?> value = "emitirPDenDef" class="sitValidacion"> P denegació definitiva emetre</option>
            		            <option <?php if ($expedientes['situacion'] === "emitidoPDenDef") { echo "selected";}?> value = "emitidoPDenDef" class="sitValidacion"> P denegació definitiva emesa</option>
            		            <option <?php if ($expedientes['situacion'] === "emitirResDen") { echo "selected";}?> value = "emitirResDen" class="sitValidacion"> Resolució de denegació emetre</option>	
                                <option <?php if ($expedientes['situacion'] === "emitidoResDen") { echo "selected";}?> value = "emitidoResDen" class="sitValidacion"> Resolució de denegació emesa</option>
                                <option <?php if ($expedientes['situacion'] === "Denegado") { echo "selected";}?> value = "Denegado" class="sitValidacion"> Denegat</option>
                            </optgroup> -->
                        </optgroup>
                        <!-- <optgroup style="background-color:#6d9eeb;color:#000;" label="Fase justificació pagament:">
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
                        </optgroup> -->
			        </select>
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
            <?php
            $felib_p = explode('#', $expedientes['felib_p']);
            ?>
            <h3>Programes sol·licitats:</h3>
                <label for = "felib_p1" class="main" >
					<span ><?php echo lang('message_lang.felib_p1');?> </span>
						<input type="checkbox" <?php if ($felib_p[0]) { echo "checked";}?> disabled readonly name = "felib_p1" id = "felib_p1">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p2" class="main" >
					<span ><?php echo lang('message_lang.felib_p2');?> </span>
						<input type="checkbox" <?php if ($felib_p[1]) { echo "checked";}?> disabled readonly name = "felib_p2" id = "felib_p2">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p3" class="main" >
					<span ><?php echo lang('message_lang.felib_p3');?> </span>
						<input type="checkbox" <?php if ($felib_p[2]) { echo "checked";}?> disabled readonly name = "felib_p3" id = "felib_p3">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p4" class="main" >
					<span ><?php echo lang('message_lang.felib_p4');?> </span>
						<input type="checkbox" <?php if ($felib_p[3]) { echo "checked";}?> disabled readonly name = "felib_p4" id = "felib_p4">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p5" class="main" >
					<span ><?php echo lang('message_lang.felib_p5');?></span>
						<input type="checkbox" <?php if ($felib_p[4]) { echo "checked";}?> disabled readonly name = "felib_p5" id = "felib_p5">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p6" class="main" >
					<span ><?php echo lang('message_lang.felib_p6');?></span>
						<input type="checkbox" <?php if ($felib_p[5]) { echo "checked";}?> disabled readonly name = "felib_p6" id = "felib_p6">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p7" class="main" >
					<span ><?php echo lang('message_lang.felib_p7');?></span>
						<input type="checkbox" <?php if ($felib_p[6]) { echo "checked";}?> disabled readonly name = "felib_p7" id = "felib_p7">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p8" class="main" >
					<span ><?php echo lang('message_lang.felib_p8');?></span>
						<input type="checkbox" <?php if ($felib_p[7]) { echo "checked";}?> disabled readonly name = "felib_p8" id = "felib_p8">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p9" class="main" >
					<span ><?php echo lang('message_lang.felib_p9');?></span>
						<input type="checkbox" <?php if ($felib_p[8]) { echo "checked";}?> disabled readonly name = "felib_p9" id = "felib_p9">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p10" class="main" >
					<span ><?php echo lang('message_lang.felib_p10');?></span>
						<input type="checkbox" <?php if ($felib_p[9]) { echo "checked";}?> disabled readonly name = "felib_p10" id = "felib_p10">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p11" class="main" >
					<span ><?php echo lang('message_lang.felib_p11');?></span>
						<input type="checkbox" <?php if ($felib_p[10]) { echo "checked";}?> disabled readonly name = "felib_p11" id = "felib_p11">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p12" class="main" >
					<span ><?php echo lang('message_lang.felib_p12');?></span>
						<input type="checkbox" <?php if ($felib_p[11]) { echo "checked";}?> disabled readonly name = "felib_p12" id = "felib_p12">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p13" class="main" >
					<span ><?php echo lang('message_lang.felib_p13');?></span>
						<input type="checkbox" <?php if ($felib_p[12]) { echo "checked";}?> disabled readonly name = "felib_p13" id = "felib_p13">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p14" class="main" >
					<span ><?php echo lang('message_lang.felib_p14');?></span>
						<input type="checkbox" <?php if ($felib_p[13]) { echo "checked";}?> disabled readonly name = "felib_p14" id = "felib_p14">
					<span class="w3docs"></span>
				</label>

                <label for = "felib_p15" class="main" >
					<span ><?php echo lang('message_lang.felib_p15');?></span>
						<input type="checkbox" <?php if ($felib_p[14]) { echo "checked";}?> disabled readonly name = "felib_p15" id = "felib_p15">
					<span class="w3docs"></span>
				</label>
                <br>
            <div class="alert alert-info">
                <small>Estat de la signatura electrònica de la carta d'adhesió</small>
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
				                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class = 'success-msg'><i class='fa fa-check'></i>Signades</div>";		
				                        $estado_firma .= "</a>";					
				                        break;
				                    case 'IN_PROCESS':
                                        $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='info-msg'><i class='fa fa-check'></i>En curs</div>";		
				                        $estado_firma .= "</a>";						
				                    default:
				                        $estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
				                }
			                echo $estado_firma;
                            $tipoMIME = "application/pdf";
		                }?>
                        <br>
                        <a href="<?php echo base_url('/public/index.php/expedientes/muestradocumento/'.strtoupper($expedientes['nif']).'_dec_res_solicitud_felib.pdf'.'/'.strtoupper($expedientes['nif']).'/'.$expedientes['selloDeTiempo'].'/'.$tipoMIME);?>"><small class = 'verSello' id='<?php echo $docs_item->publicAccessIdCustodiado;?>'>La carta d'adhesió sense signar</small></a>
            </div>
        </div>
    </div>
    </div> <!-- Cierre fila Detalle -->
</div> <!-- Cierre del tab Detalle -->

<div id="solicitud_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente">
            <h3>Detall:</h3>
           <form action=""  name="exped-fase-1" id="exped-fase-1" method="post" accept-charset="utf-8">
                <div class="form-group solicitud">
                    <label for = "fecha_REC"><strong>Data SEU sol·licitud:</strong></label>
			        <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC" onchange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC']);?>"/>
                </div>
                <div class="form-group solicitud">
                    <label for = "ref_REC"><strong>Referència SEU sol·licitud:</strong></label>
                    <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC" onchange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "ref_REC"  maxlength = "16" value = "<?php echo $expedientes['ref_REC'];?>">
                </div>
               <!--  <div class="form-group solicitud">
                    <label for = "fecha_REC_enmienda"><strong>Data SEU esmena:</strong></label>
		    	    <input type = "text" placeholder = "dd/mm/aaaa hh:mm:ss" name = "fecha_REC_enmienda" onchange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_REC_enmienda" value = "<?php echo str_replace("0000-00-00 00:00:00", "", $expedientes['fecha_REC_enmienda']);?>"/>
                </div>		
                <div class="form-group solicitud">
                    <label for = "ref_REC_enmienda"><strong>Referència SEU esmena:</strong></label>
                    <input type = "text" placeholder = "El número del SEU o el número del resguard del sol·licitant" name = "ref_REC_enmienda" onchange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "ref_REC_enmienda"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_enmienda'];?>">
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento"><strong>Firma requeriment:</strong></label>
                    <input type = "date" name = "fecha_requerimiento" onchange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_requerimiento" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento']), 'Y-m-d');?>"/>
                </div>
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento_notif"><strong>Notificació requeriment:</strong></label>
                    <input type = "date" name = "fecha_requerimiento_notif" onchange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_requerimiento_notif" value = "<?php echo date_format(date_create($expedientes['fecha_requerimiento_notif']), 'Y-m-d');?>"/>
                </div> -->

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
           <!--  <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-desestimiento-por-no-enmendar.php';?></li> -->
            <!-------------------------------------------------------------------------------------------------------------->
            </ol>
           <!--  <h3>Millores: <?php echo $ultimaMejoraSolicitud; ?></small></h3>
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
                            <span class = "detail-wrapper-docs-col trash"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$mejorasSolicitud_item['id'].'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target="#modalEliminaMejora"><i class="bi bi-trash-fill" style="font-size: 1.5rem; color: red;"></i></button>';?></span>
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
                    <input type='text' placeholder = "El número del SEU [GOIBE539761_2021]" name = "refRecMejora" class='form-control form-control-sm' id="refRecMejora" maxlength = "16"/>
                </div>
                    <button class="btn-itramits btn-success-itramits btn-lg btn-block btn-docs" onclick="insertaMejoraEnSolicitud()" id="addMejora">Afegir</button>
            </div>           -->
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
			                if($docSolicitud_item->fase_exped == 'Solicitud') {
    			                $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
	    		                $parametro = explode ("/",$path);
		    	                $tipoMIME = $docSolicitud_item->type;
			                    $nom_doc = $docSolicitud_item->name;
			                ?>
                            <div id ="fila" class = "detail-wrapper-docs-4 detail-wrapper-docs-solicitud-ils">
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
                            <span class = "detail-wrapper-docs-col trash">
                                <button <?php if ($docSolicitud_item->estado == 'Aprovat') {echo 'disabled';} ?>  onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="<?php echo $docSolicitud_item->id."_del";?>" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target= "#eliminaDocsExpedienteJustificacion"><i class="bi bi-trash-fill" style="font-size: 1.5rem; color: red;"></i></button>
                            </span>                            
	                        </div>
                        <?php 
                            }
                     endforeach; ?>
                <?php endif; ?>
            </div>

                <div id="eliminaDocsExpedienteJustificacion" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
	    	                    <h4>¡Aquesta acció no es podrá desfer!</h4>
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
                            <input id="subeDocsSolicitudBtn" type="submit" class = "btn-itramits btn-success-itramits btn-lg btn-block btn-docs" value="Pujar el/els document/s" />
                        </div>
                    </div>
                <?php }?>                    
                </form>
        </div><!-- Cierre de la columna de documentos -->
        </div> 
    </div><!-- Cierre de la fila -->
</div><!-- Cierre del tab Solicitud -->

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
            <?php 
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

<script>
    function desestimiento_docs_IDI_click (id, nombre) {
        document.cookie = "documento_actual = " + id;
    }

    function opcion_seleccionada_click(respuesta) {
        document.cookie = "respuesta = " + respuesta;
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>

