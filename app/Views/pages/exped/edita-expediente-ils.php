<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script defer src="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>

<?php
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
    <button id="validacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'validacion_tab', '#b23cfd', <?php echo $expedientes['id'];?>)">Adhesió</button>
    <button id="ejecucion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'ejecucion_tab', '#fffb0b', <?php echo $expedientes['id'];?>)">Seguiment</button>
    <button id="justifiacion_tab_selector" class="tablinks" onclick="openFaseExped(event, 'justificacion_tab', '#a64d79', <?php echo $expedientes['id'];?>)">Renovació</button>
    <button id="deses_ren_tab_selector" class="tablinks" onclick="openFaseExped(event, 'deses_ren_tab', '#8e7cc3', <?php echo $expedientes['id'];?>)">Desistiment o renúncia</button>
</div>

<?php echo "Data sol·licitud: ". $expedientes['fecha_solicitud'];?> <?php echo "Data complert: ". $expedientes['fecha_completado'];?>
<!---------- Inicio TAB DETALL ----------------------------------------------->
<div id="detall_tab" class="tab_fase_exp_content" style="display:block;">
    <div class="row">
        <div class="col">
            <div class="row">	
	            <div class="col">
                    <h3>Detall:</h3>
     			    <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $expedientes['id']; ?>">
     			    <input type="hidden" name="convocatoria" class="form-control" id="convocatoria" value="<?php echo $expedientes['convocatoria']; ?>">
                    <div class="form-group form-check form-switch general">
                        <label for = "publicar_en_web" class="main" >
				            <span>Publicat en la web de ILS</ºspan>
					            <input type="checkbox" class="form-control send_fase_0" <?php if ($expedientes['publicar_en_web'] == 1) { echo 'checked';} ?> value="<?php echo $expedientes['publicar_en_web']; ?>" name = "publicar_en_web" id = "publicar_en_web">
				            <span class="w3docs"></span>
			            </label>
                    </div>
                    <div class="form-group general">
                        <label for="empresa">Nom o raó social:</label>
                        <input type="text" name="empresa" class="form-control send_fase_0" id = "empresa" required <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> placeholder="Nom del sol·licitant" value="<?php echo $expedientes['empresa']; ?>">
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
                    <datalist id="listaProgramas">
    			        <option value="Programa I">
				        <option value="Programa II">
				        <option value="Programa III">
                        <option value="ILS">
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

                </div>
	            <div class="col">
                    <div class="form-group general">
                        <label for="cpostal">Codi postal:</label>
                        <input type="text" name="cpostal" class="form-control" readonly disabled id = "cpostal" maxlength = "5" size="5" required placeholder="Codi postal del sol·licitant" value="<?php echo $expedientes['cpostal']; ?>">
                    </div>      	  		            	  
                    <div class="form-group general">
                        <label for="telefono">Telèfon de contacte:</label>
                        <input type="tel" name="telefono" class="form-control" readonly disabled id = "telefono" required placeholder="Telèfon del sol·licitant" value="<?php echo $expedientes['telefono']; ?>">
                    </div> 
                    <div class="form-group general">
                        <label for="iae">Activitat econòmica (IAE):</label>
                        <input type="text" name="iae" class="form-control" readonly disabled id = "iae" maxlength = "4" size="4" placeholder="IAE" value="<?php echo $expedientes['iae']; ?>">
                    </div>
		            <div class="form-group general">
                        <label for="nombre_rep">Representant legal:</label>
                        <input type="text" name="nombre_rep" class="form-control send_fase_0" oninput = "javaScript: actualizaRequired(this.value);" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nombre_rep" placeholder = "Nom del representant" value = "<?php echo $expedientes['nombre_rep']; ?>">
                    </div>
                    <div class="form-group general">
                        <label for="nif_rep">NIF representant legal:</label>
                        <input type="text" name="nif_rep" class="form-control send_fase_0" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "nif_rep" minlength = "9" maxlength = "9" placeholder = "NIF del representant" value = "<?php echo $expedientes['nif_rep']; ?>">
                    </div>
        		    <div class="form-group general">
                        <label for="tecnicoAsignado">Tècnica asignada:</label>
                        <input type="text" name="tecnicoAsignado" onChange="avisarCambiosEnFormulario('send_fase_0')" list="listaTecnicos" class="form-control send_fase_0" id = "tecnicoAsignado" min="0" placeholder="Tècnica asignada" value="<?php echo $expedientes['tecnicoAsignado']; ?>">
			            <datalist id="listaTecnicos">
    			        <option value="Alejandra Gelabert">
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
                           	<option <?php if ($expedientes['situacion'] === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitSolicitud_ils"> No ha passat pel REC</option>
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
                    <div class="form-group general">
                        <label for="sitio_web_empresa">Lloc web de l'empresa (<span class="alert-info">no poner el prefijo https:// ni http://</span>):</label>
                        <input type="text" name="sitio_web_empresa" class="form-control send_fase_0" oninput = "javaScript: actualizaRequired(this.value);" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "sitio_web_empresa" placeholder = "Lloc web de l'empresa" value = "<?php echo $expedientes['sitio_web_empresa']; ?>">
                    </div>
		            <div class="form-group general">
                        <label for="video_empresa">Video de l'empresa (<span class="alert-info">no poner el prefijo https:// ni http://</span>):</label>
                        <input type="text" name="video_empresa" class="form-control send_fase_0" oninput = "javaScript: actualizaRequired(this.value);" <?php if ($session->get('rol')!='admin') { echo 'readonly';} ?> id = "video_empresa" placeholder = "Video de l'empresa" value = "<?php echo $expedientes['video_empresa']; ?>">
                    </div>                
                        <?php
                        if ( !$esAdmin && !$esConvoActual ) {?>
                            <?php }
                        else {?>
                            <div class="form-group">
                                <button type="button" onclick = "javaScript: actualiza_fase_0_expediente_ils('exped-fase-0');" id="send_fase_0" class="btn-itramits btn-success-itramits">Actualitzar</button>
                            </div>
                        <?php }?>
                    
                </div>
            </div>
        </div>
        <div class="col">
            <input type="hidden" name="doc_requeriment_auto_ils" class="form-control" id="doc_requeriment_auto_ils" value="<?php echo $expedientes['doc_requeriment_auto_ils']; ?>">
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
                            case 'file_logotipoEmpresaIls':	
                                $nom_doc = "Logotip de l'empresa";
                                break; 
                            case 'file_informeResumenIls':	
                                $nom_doc = "Informe resum de la petjada de carboni";
                                break;
                            case 'file_informeInventarioIls':	
                                $nom_doc = "Informe d'Inventari de GEH segons la norma ISO 14.064-1";
                                break;
                            case 'file_modeloEjemploIls':	
                                $nom_doc = "Compromís de reducció de les emissions de gasos d'efecte hivernacle";
                                break;
                            case 'file_lineaProduccionBalearesIls':	
                                $nom_doc = "Declaració responsable de que l'empresa compta amb una línia de producció activa a les Illes Balears";
                                break;
                            case 'file_certificado_itinerario_formativo':	
                                $nom_doc = "Certificat itinerari formatiu";
                                break;
                            case 'file_certificado_verificacion_ISO':	
                                $nom_doc = "Certificat verificación ISO";
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
                                case 'file_informeResumenIls':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/envia-form-solicitud-informe-resumen-ils.php'; 
                                    break;
                                case 'file_informeInventarioIls':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/envia-form-solicitud-informe-geh-ils.php';
                                    break;
                                case 'file_certificado_itinerario_formativo':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/envia-form-solicitud-itinerario-formativo-ils.php';
	    				            break;
                                case 'file_modeloEjemploIls':
                                    include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/envia-form-solicitud-compromiso-reduccion-ils.php';
	    				            break;
                            } 
                            ?>
                            </span>
  			            </div>
                        <?php }?>
                        <?php endforeach; ?>
                        <div >
                            <button class='hide-button' id="requeriment-button" onclick = "javaScript: generaRequerimiento(<?php echo $expedientes['id']; ?>);">Generar el requeriment</button>
                            <button class='hide-button' id="adhesion-button" onclick = "javaScript: generaResolucionAdhesion(<?php echo $expedientes['id']; ?>);">Generar la resolució d'adhesió a ILS</button>
                        </div>
                </div>
                <?php } else { 
                    echo "<div class='alert alert-warning'>Cap documentació.</div>";
                    }   
                ?>
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
                    <?php if($documentos){ ?>

                        <?php foreach($documentos as $docs_opc_item): 
			            $path = $docs_opc_item->created_at;
			            $parametro = explode ("/",$path);
			            $tipoMIME = $docs_opc_item->type;
                        
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
			            } ?>

                        <?php if ($docs_opc_item->docRequerido === 'NO') {?>
                            <div id ="fila" class = "detail-wrapper-docs general">
                              <span id = "convocatoria" class = "detail-wrapper-docs-col date-docs-col"><?php echo str_replace ("_", " / ", $docs_opc_item->selloDeTiempo); ?></span>
                              <span id = "tipoTramite" class = "detail-wrapper-docs-col"><a title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docs_opc_item->name.'/'.$parametro [6].'/'.$parametro [7].'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
                                <span id = "fechaCompletado" class = "detail-wrapper-docs-col"><?php echo $docs_opc_item->tipo_tramite; ?></span>
                              <?php
                              switch ($docs_opc_item->estado) {
                                  case 'Pendent':
                                      $estado_doc = '<button  id="'.$docs_opc_item->id.'" class = "btn btn-itramits isa_info" onclick = "javaScript: cambiaEstadoDocIls(this.id);" title="Aquesta documentació està pendent de revisió">Pendent</button>';
                                      break;
                                  case 'Aprovat':
                                      $estado_doc = '<button  id="'.$docs_opc_item->id.'" class = "btn btn-itramits isa_success" onclick = "javaScript: cambiaEstadoDocIls(this.id);" title="Es una documentació correcta">Aprovat</button>';
                                      break;
                                  case 'Rebutjat':
                                      $estado_doc = '<button  id="'.$docs_opc_item->id.'"  class = "btn btn-itramits isa_error" onclick = "javaScript: cambiaEstadoDocIls(this.id);" title="Es una documentació equivocada">Rebutjat</button>';
                                      break;
                                  default:
                                      $estado_doc = '<button  id="'.$docs_opc_item->id.'"  class = "btn btn-itramits isa_caducado" onclick = "javaScript: cambiaEstadoDocIls(this.id);" title="No sé en què estat es troba aquesta documentació">Desconegut</button>';
                                  }
                              ?>
                              <span id = "estado-doc-no-requerido" class = "detail-wrapper-docs-col"><?php echo $estado_doc;?></span>
                              <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: docNoRequerido_click (this.id, this.name);" id="'.$id_doc = $docs_opc_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-bs-toggle="modal" data-bs-target="#myModalDocNoRequerido"><strong>Elimina</strong></button>';?></span>
                            </div>
                        <?php }?>
                        <?php endforeach; ?>

                    <?php } else { 
                        echo "<div class='alert alert-warning'>Cap documentació.</div>";
                                }   
                    ?>

                    <div class="modal" id="myModalDocNoRequerido">
                        <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style = "width: 60%;">
                            <div class="modal-header">
                                <h4 class="modal-title">Aquesta acció no es podrá desfer.</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
    			                <h5 class="modal-title">Eliminar definitivament el document?</h5>
                                <div class="modal-footer">
    		                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocNoRequerido_click();" class="btn btn-default" data-bs-dismiss="modal">Confirma</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  	
                <script>
 
                    function opcion_seleccionada_click(respuesta) {
                        document.cookie = "respuesta = " + respuesta;
                        console.log (respuesta);
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
                <div>
                    <small>Estat de la signatura de la declaració responsable i de la sol·licitud:</small>
                    <?php //Compruebo el estado de la firma del documento.
	                $db = \Config\Database::connect();
	                $sql = "SELECT PublicAccessId FROM pindust_expediente WHERE id=".$expedientes['id'];

	                $query = $db->query($sql);
	                $row = $query->getRow();
	                if (isset($row))
		            {
		                $PublicAccessId = $row->PublicAccessId;
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
				                $estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class = 'success-msg'><i class='fa fa-check'></i>Signat</div>";		
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
                <div class="btn-group" role="group">
                <!-----------------------------------------Envía formulario solicitud datos adicionales de la empresa ----------------->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/envia-form-datos-empresa.php';?>
                <!------------------------------------------------------------------------------------------------------>
                <!-----------------------------------------Envía manual y logotipos ILS ----------------->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/envia-manual-logotipos-ils.php';?>
                <!------------------------------------------------------------------------------------------------------>

                <br><a target="_blank" class = "btn btn-warning" href="<?php echo base_url('/public/index.php/home/datos_empresa_ils/'.$id.'/'.$expedientes['nif'].$programa.$convocatoria);?>"><small>Sol·licitud de dades adicionals per a la web de ILS (ús intern IDI)</small></span></a>
            </div>
            </div>

        </div>
    </div>
</div>
<!----------- Cierre del tab Detalle -->

<!-- Inicio del tab SOLICITUD -->
<div id="solicitud_tab" class="tab_fase_exp_content">
    <div class="row">
        <div class="col-sm-2 docsExpediente" style="border:1px solid #0000ff;">
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
		        <div class="form-group solicitud">
                    <label for = "fecha_requerimiento_notif"><strong>Data màxima per esmenar [data notificació req + 30 dies naturals]:</strong></label>
                    <input type = "date" name = "fecha_maxima_enmienda" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_1" id = "fecha_maxima_enmienda" value = "<?php echo date_format(date_create($expedientes['fecha_maxima_enmienda']), 'Y-m-d');?>"/>
                </div>
                <?php
                if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                else {?>
                    <div class="form-group">
                        <button type="button" onclick = "javaScript: actualiza_fase_1_solicitud_expediente_ils('exped-fase-1');" id="send_fase_1" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>    
            </form>
        </div>
        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start ="1">
            <!----------------------------------------- Requeriment DOC 1 ILS ---------------------------------------------->
	        <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/requerimiento.php';?></li>
            <!-------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Resolució desistiment per no esmenar  SIN VIAFIRMA ----------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/resolucion-desestimiento-por-no-enmendar.php';?></li>
            <!-------------------------------------------------------------------------------------------------------------->
            </ol>
        </div>
        <div class="col docsExpediente" style="border:1px solid #aaccff;">
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
                    <div id ="fila" class = "detail-wrapper-docs detail-wrapper-docs-solicitud">
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
		                	        <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-toggle = "modal" data-target = "#myModalDocSolicitud"><strong>Elimina</strong></button>';?></span>		
    		                        <?php } else {?>
	    		                        <span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
    		                    <?php } ?>
	                </div>
                        <?php 
                            }
                     endforeach; ?>
                <?php endif; ?>
            </div>

                <div id="myModalDocSolicitud" class="modal fade" role="dialog">
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
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocSolicitud_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  	
                <script>
                        function myFunction_docs_IDI_click (id, nombre) {
        	                document.cookie = "documento_actual = " + id;
    	                    console.log (id);
                            }
                        function opcion_seleccionada_click(respuesta) {
            	            document.cookie = "respuesta = " + respuesta;
	                        console.log (respuesta);
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
 
        </div> <!-- Cierre de la col -->
    </div><!-- Cierre de la row -->
</div><!-- Cierre del tab Solicitud -->

<div id="validacion_tab" class="tab_fase_exp_content"> <!-- ADHESIÓN -->
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
                        <button type="button"  onclick = "javaScript: actualiza_fase_2_validacion_expediente_ils('exped-fase-2');" id="send_fase_2" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>                  
        </form>
        </div>        
    	    <script>
		     /*    $('#fecha_REC_amp_termino').mask('99/99/9999 99:99:99');
		        $('#tel_consultor').mask('999999999'); */
	        </script>

        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="3">
            <!-----------------------------------------Informe favorable amb requeriment ILS ------------>
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/informe-favorable-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe favorable sense requeriment ILS ---------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/informe-favorable-sin-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe desfavorable sense requeriment ILS -->
            <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-desfavorable-sin-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Informe desfavorable amb requeriment ILS -->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/informe-desfavorable-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta resolucio concessió ajut_ amb requeriment SIN VIAFIRMA-->
            <?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-concesion-con-requerimiento.php';?>
            <!-------------------------------------------------------------------------------------------------------------------->
            <!-----------------------------------------Proposta resolucio concessió ajut_ sense requeriment SIN VIAFIRMA-->
            <?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-concesion-sin-requerimiento.php';?>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta resolucio denegació ajut_ amb requeriment SIN VIAFIRMA-->
	        <!--  <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-denegacion-con-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta resolucio denegació ajut_ sin requeriment SIN VIAFIRMA-->
	        <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-denegacion-sin-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució i resolució de pagament sense requeriment SIN VAIFIRMA-->
            <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-pago-sin-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Proposta de resolució i resolució de pagament amb requeriment SIN VIAFIRMA-->
            <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/propuesta-resolucion-pago-con-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució denegació amb requeriment ILS SIN VIAFIRMA -->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/resolucion-denegacion-con-requerimiento.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució denegació_ sense requeriment SIN VIAFIRMA-->
            <!-- <li><?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-denegacion-sin-requerimiento.php';?></li> -->
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució concesió adhesió ILS sense requeriment------------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/resolucion-concesion-adhesion-ils-sin-requerimiento.php';?>
            <input type="hidden" name="doc_res_concesion_adhesion_sin_req_auto_ils" class="form-control" id="doc_res_concesion_adhesion_sin_req_auto_ils" value="<?php echo $expedientes['doc_res_concesion_adhesion_sin_req_auto_ils']; ?>"></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------Resolució concesió adhesió ILS sense requeriment--------->
            <li><?php include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/ILS/resolucion-concesion-adhesion-ils-con-requerimiento.php';?>
            <input type="hidden" name="doc_res_concesion_adhesion_con_req_auto_ils" class="form-control" id="doc_res_concesion_adhesion_con_req_auto_ils" value="<?php echo $expedientes['doc_res_concesion_adhesion_con_req_auto_ils']; ?>"></li>
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
                if($docSolicitud_item->fase_exped == 'Adhesion') {
			        $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			        $parametro = explode ("/",$path);
			        $tipoMIME = $docSolicitud_item->type;
			        $nom_doc = $docSolicitud_item->name;?>

                    <div id ="fila" class = "detail-wrapper-docs detail-wrapper-docs-validacion">
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
                        <!-- <span id="custodia" class = "detail-wrapper-docs-col"><a href="<?php echo base_url('/public/index.php/expedientes/muestrasolicitudfirmada/'.$docSolicitud_item->publicAccessIdCustodiado);?>"><span class = 'verSello' id='<?php echo $docSolicitud_item->publicAccessIdCustodiado;?>'>Pendent de custodiar</span></a></span> -->
        		        <?php if (!$docSolicitud_item->publicAccessIdCustodiado) {?>
	        		        <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-toggle = "modal" data-target = "#myModalDocValidacion"><strong>Elimina</strong></button>';?></span>		
    		            <?php } else {?>
            	    		<span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
                		<?php } ?>
	                </div>
                <?php }
                endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="myModalDocValidacion" class="modal fade" role="dialog">
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
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocValidacion_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  	
            <script>
                function myFunction_docs_IDI_click (id, nombre) {
    	        document.cookie = "documento_actual = " + id;
	            console.log (id);
                }
                function opcion_seleccionada_click(respuesta) {
    	        document.cookie = "respuesta = " + respuesta;
	            console.log (respuesta);
                }
                function eliminaDocValidacion_click() {
    	        console.log (getCookie("documento_actual"));
	            let id = getCookie("documento_actual");
	            console.log (getCookie("nuevo_estado"));
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

<div id="ejecucion_tab" class="tab_fase_exp_content"> <!-- SEGUIMIENTO -->
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-3" id="exped-fase-3" method="post" accept-charset="utf-8">
            <div class="row">
                <div class="col">
                    <div class="form-group ejecucion">
                        <label for = "fecha_adhesion_ils"><strong>Data adhesió:</strong></label>
                        <input type = "date" name = "fecha_adhesion_ils" class = "form-control send_fase_3" id = "fecha_adhesion_ils" onchange = "javaScript: actualizaFechasILS(this.value);" value = "<?php if ($expedientes['fecha_adhesion_ils'] != null) {echo date_format(date_create($expedientes['fecha_adhesion_ils']), 'Y-m-d');}?>">
                    </div>
                    <div class="form-group ejecucion">
                        <label for = "fecha_seguimiento_adhesion_ils"><strong>Data seguiment:</strong></label>
                        <input title="Es data adhesió mes UN ANY" type = "date" name = "fecha_seguimiento_adhesion_ils" class = "form-control send_fase_3" id = "fecha_seguimiento_adhesion_ils" value = "<?php if ($expedientes['fecha_seguimiento_adhesion_ils'] != null) {echo date_format(date_create($expedientes['fecha_seguimiento_adhesion_ils']), 'Y-m-d');}?>">
                    </div>    
                    <div class="form-group ejecucion">
                        <label for = "fecha_limite_presentacion"><strong>Data límit presentació:</strong></label>
                        <input title="Es data seguiment mes DOS MESOS" type = "date" name = "fecha_limite_presentacion" class = "form-control send_fase_3" id = "fecha_limite_presentacion" value = "<?php if ($expedientes['fecha_limite_presentacion'] != null) {echo date_format(date_create($expedientes['fecha_limite_presentacion']), 'Y-m-d');}?>">
                    </div>                                        
                    <div class="form-group ejecucion">
                        <label for = "fecha_rec_informe_seguimiento"><strong>Data REC informe seguiment:</strong></label>
                        <input title="Es data seguiment mes DOS MESOS" type = "date" name = "fecha_rec_informe_seguimiento" class = "form-control send_fase_3" id = "fecha_rec_informe_seguimiento" value = "<?php if ($expedientes['fecha_rec_informe_seguimiento'] != null) {echo date_format(date_create($expedientes['fecha_rec_informe_seguimiento']), 'Y-m-d');}?>">
                    </div>     
                    <div class="form-group ejecucion">
                        <label for = "ref_REC_informe_seguimiento"><strong>Ref. REC informe seguiment:</strong></label>
                        <input type = "text" placeholder = "El número del REC o el número del resguard del sol·licitant" name = "ref_REC_informe_seguimiento" onChange="avisarCambiosEnFormulario('send_fase_1', this.id)" class = "form-control send_fase_3" id = "ref_REC_informe_seguimiento"  maxlength = "16" value = "<?php echo $expedientes['ref_REC_informe_seguimiento'];?>">
                    </div>
                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                        <div class="form-group">
                            <button type="button" onclick = "javaScript: actualiza_fase_3_ejecucion_expediente_ils('exped-fase-3');" id="send_fase_3" class="btn-itramits btn-success-itramits">Actualitzar</button>
                        </div>
                <?php }?>

                </div>
            </div>
        </form>
        </div>
        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start="9">
            <!-----------------------------------------15.-abril_Acta Kick off ------------------------------------>
            <li>Enviar Modelo seguimiento [Pilar me pasará el texto del email]<?php //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/acta-de-kickoff.php';?></li>
            <!------------------------------------------------------------------------------------------------------>
            <!-----------------------------------------17.-mayo_Acta de cierre ---->
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
                if($docSolicitud_item->fase_exped == 'Seguimient') {
			        $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
			        $parametro = explode ("/",$path);
			        $tipoMIME = $docSolicitud_item->type;
			        $nom_doc = $docSolicitud_item->name;
			        ?>
                    <div id ="fila" class = "detail-wrapper-docs detail-wrapper-docs-ejecucion">
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
    	        		    <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: myFunction_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-toggle = "modal" data-target = "#myModalDocEjecucion"><strong>Elimina</strong></button>';?></span>		
        		        <?php } else {?>
    	        		    <span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
        		        <?php } ?>			
		            </div>
                    <?php }
                endforeach; ?>
            <?php endif; ?>
            </div>
            <div id="myModalDocEjecucion" class="modal fade" role="dialog">
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
                                <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocValidacion_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function myFunction_docs_IDI_click (id, nombre) {
    	            document.cookie = "documento_actual = " + id;
	                console.log (id);
                    }
                function opcion_seleccionada_click(respuesta) {
        	        document.cookie = "respuesta = " + respuesta;
	                console.log (respuesta);
                    }
                function eliminaDocValidacion_click() {
    	            console.log (getCookie("documento_actual"));
	                let id = getCookie("documento_actual");
	                console.log (getCookie("nuevo_estado"));
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
            <form action="<?php echo base_url('/public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Seguimient');?>" onsubmit="logSubmit('subeDocsEjecucionBtn')" name="subir_doc_faseExpedEjecucion" id="subir_doc_faseExpedEjecucion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                
                <?php
                    if ( !$esAdmin && !$esConvoActual ) {?>
                <?php }
                    else {?>
                <div class = "content-file-upload">
                    <div>
                        <input class="fileLoader" type="file" class = "btn btn-secondary btn-lg btn-block btn-docs" required name="file_faseExpedSeguimient[]" id="nombrefaseExpedSeguimient" size="20" accept=".pdf" multiple />
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

<div id="justificacion_tab" class="tab_fase_exp_content"> <!-- RENOVACIÓN -->
    <div class="row">
        <div class="col-sm-2 docsExpediente">
        <h3>Detall:</h3>
        <form action="<?php echo base_url('public/index.php/expedientes/update');?>" onload = "javaScript: actualizaRequired();" name="exped-fase-4" id="exped-fase-4" method="post" accept-charset="utf-8">
            <div class="row">
            <div class="col">  
    		<div class="form-group justificacion">
            <label for = "fecha_renovacion"><strong>Data renovació:</strong></label>
            <input type = "date" title ="Es la data adhesió mes DOS ANYS" placeholder = "dd/mm/yyyy" name = "fecha_renovacion" class = "form-control send_fase_4" id = "fecha_renovacion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_renovacion']), 'Y-m-d');?>">
            </div>
            <div class="form-group justificacion">
            <label for = "fecha_renovacion_concesion"><strong>Data renovació concesió:</strong></label>
            <input type = "date" title ="Es la data adhesió mes DOS ANYS" placeholder = "dd/mm/yyyy" name = "fecha_renovacion_concesion" class = "form-control send_fase_4" id = "fecha_renovacion_concesion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_renovacion_concesion']), 'Y-m-d');?>">
            </div>
    		<div class="form-group justificacion">
            <label for = "fecha_limite_presentacion_renovacion"><strong>Data límit presentació renovació:</strong></label>
            <input type = "date" title ="Es la data adhesió mes DOS ANYS" placeholder = "dd/mm/yyyy" name = "fecha_limite_presentacion_renovacion" class = "form-control send_fase_4" id = "fecha_limite_presentacion_renovacion" minlength = "19" maxlength = "19" value = "<?php echo date_format(date_create($expedientes['fecha_limite_presentacion_renovacion']), 'Y-m-d');?>">
            </div>                          
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
                        <button type="button"  onclick = "javaScript: actualiza_fase_4_justificacion_expediente('exped-fase-4');" id="send_fase_4" onChange="avisarCambiosEnFormulario('send_fase_4', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                    </div>
                <?php }?>
            
            </div>
            </div>
        </form>
        </div>
        <div class="col docsExpediente">
        <h3>Actes administratius:</h3>
        <ol start="17">
            <!----------------------------------------- Resolución de concesión ---------------------------------------------->
            <li><?php echo "Resolució concessió ¿ToDo?"; //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-concesion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Informe inicio requerimiento de subsanación -------------------------->
            <li><?php echo "Informe inici requeriment d'esmena ¿ToDo?"; //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/inicio-requerimiento-subsanacion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Requerimiento de subsanación ----------------------------------------->
            <li><?php echo "Requeriment d'esmena ¿ToDo?"; //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/requerimiento-subsanacion.php';?></li>
            <!---------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------- Informe sobre la subsanación de la documentación de justificación ---->
            <li><?php echo "Informe sobre l'esmena de la documentació de justificació ¿ToDo?"; //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/informe-sobre-subsanacion.php';?></li>
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
                            if($docSolicitud_item->fase_exped == 'Renovacion') {
                                $path = str_replace ("/home/tramitsidi/www/writable/documentos/","", $docs_item->created_at);
                                $parametro = explode ("/",$path);
                                $tipoMIME = $docSolicitud_item->type;
                                $nom_doc = $docSolicitud_item->name;
                    ?>
                    <div id ="fila" class = "detail-wrapper-docs detail-wrapper-docs-justificacion">
                        <span id = "fechaComletado" class = "detail-wrapper-docs-col"><?php echo str_replace ("_", " / ", $docSolicitud_item->selloDeTiempo); ?></span>	
                        <span id = "convocatoria" class = "detail-wrapper-docs-col"><a	title="<?php echo $nom_doc;?>"  href="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$docSolicitud_item->name.'/'.$docSolicitud_item->cifnif_propietario.'/'.$docSolicitud_item->selloDeTiempo.'/'.$tipoMIME);?>" target = "_self"><?php echo $nom_doc;?></a></span>
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
                            <span class = "detail-wrapper-docs-col"><?php echo '<button onclick = "javaScript: justificacion_docs_IDI_click (this.id, this.name);" id="'.$docSolicitud_item->id.'" name = "elimina" type = "button" class = "btn btn-link" data-toggle = "modal" data-target = "#myModalDocJustificacion"><strong>Elimina</strong></button>';?></span>		
                        <?php } else {?>
                            <span id = "accion" class = "detail-wrapper-docs-col">No es pot esborrar</span>			
                        <?php } ?>			
                    </div>
                <?php }
                    endforeach; ?>
                <?php endif; ?>

                <div id="myModalDocJustificacion" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style = "width: 60%;">
                            <div class="modal-header">
                                Aquesta acció no es podrá desfer.
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <h5 class="modal-title">Eliminar definitivament aquest document?</h5>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancela</button>
                                    <button type="button" class="btn btn-danger" onclick = "javaScript: eliminaDocJustificacion_click();" class="btn btn-default" data-dismiss="modal">Confirma</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function justificacion_docs_IDI_click (id, nombre) {
                        document.cookie = "documento_actual = " + id;
                        console.log (id);
                    }
                    function opcion_seleccionada_click(respuesta) {
                        document.cookie = "respuesta = " + respuesta;
                        console.log (respuesta);
                    }
                    function eliminaDocJustificacion_click() {
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
                    <button type="button"  onclick = "javaScript: actualiza_fase_5_desestimiento_expediente('exped-fase-5');" id="send_fase_5" onChange="avisarCambiosEnFormulario('send_fase_5', this.id)" class="btn-itramits btn-success-itramits">Actualitzar</button>
                </div>
                <?php }?>

            </form>
        </div>

        <div class="col docsExpediente">
            <h3>Actes administratius:</h3>
            <ol start="21">
                <!----------------------------------------- 14.-abril_Resolució desistiment per renúncia SIN VIAFIRMA -------------->
                <li><?php echo "Resolució desistiment per renúncia ¿ToDo?"; //include $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/modDocs/resolucion-desestimiento-por-renuncia.php';?></li>
                <!------------------------------------------------------------------------------------------------------------------>
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
	                console.log (id);
                    }
                function opcion_seleccionada_click(respuesta) {
        	        document.cookie = "respuesta = " + respuesta;
	                console.log (respuesta);
                    }
                function eliminaDocDesestimiento_click() {
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
<!-- </form> -->