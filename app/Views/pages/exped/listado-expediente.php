<script defer type="text/javascript" src="/public/assets/js/listado-expediente.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<link rel="stylesheet" type="text/css" href="/public/assets/grocery_crud/themes/flexigrid/css/flexigrid.css" >

<?php
	//defined('BASEPATH') OR exit('No direct script access allowed');
	$db = \Config\Database::connect();
	date_default_timezone_set("Europe/Madrid");
	$selloDeTiempo = date("d_m_Y_h_i_sa");
	$builder = $db->table('pindust_expediente');
	$sort_by = "";
	$sort_order = "";
	$session = session();
	?>

<div class="row">
  <div class="col">
	<div id="body">
	<!-- The form filter area visible -->
<form onsubmit ="guardaFiltrado();" action="<?php echo base_url('public/index.php/expedientes/filtrarexpedientes');?>" method="post"> 
<div class="filter-area">
	
	<div class="filter-area-col">
		<div class="form-group">
    		<input class="form-control-itramits" required placeholder="Convocatòria ..." type="text" list="convocatoria" name="convocatoria_fltr" id="convocatoria_fltr" minlength="4" maxlength="4" value = "<?php echo $session->get('convocatoria_fltr');?>">
  			<datalist id="convocatoria">
				<option value="2024">	
				<option value="2023">
    		<option value="2022">
				<option value="2021">
				<option value="2020">
  			</datalist>
		</div>
	</div>

	<div class="filter-area-col">
		<div class="form-group">
			<input class="<?php if ($session->get('rol') == 'admin') { echo 'form-control-itramits';} else {echo 'form-control-itramits-disabled';} ?> " onfocus="this.value=''" list="programa" name="programa_fltr" id="programa_fltr" <?php if ($session->get('rol')!='admin') { echo 'disabled';} ?> placeholder = "Linia de tràmit ..." value = "<?php 
																																																				if ($session->get('rol') != 'admin') {
																																																					echo $session->get('rol');
																																																				} else {
																																																					echo $session->get('programa_fltr');
																																																				}
																																																				?>">
  			<datalist id="programa">
			  	<!-- <option value="Programa iDigital 20"> -->
    			<option value="Programa I">
					<option value="Programa II">
					<option value="Programa III">	
    			<option value="Programa III actuacions corporatives">
    			<option value="Programa III actuacions producte">
					<option value="Programa IV">
					<option value="ILS">
					<option value="ADR-ISBA">
  			</datalist>
  		</div>
	</div>

	<div class="filter-area-col">
		<div class="form-group">
		<select class="form-control-itramits" name="situacion_fltr" id="situacion_fltr" onfocus="this.value=''">
				<option disabled <?php if ($session->get('situacion_fltr') == "") { echo "selected";}?> value = ""><span>Selecciona una situació</span></option>
				<?php if (  strtoupper($session->get('programa_fltr')) != 'ILS' ) {?>																																																
                        <optgroup style="background-color:#F51720;color:#000;" label="Fase sol·licitud:">
                            <option <?php if ($session->get('situacion_fltr') === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitSolicitud"> No ha passat per la <span class="seu-elect">SEU</span> electrònica</option>
                            <option <?php if ($session->get('situacion_fltr') == "pendiente") { echo "selected";}?> value = "pendiente" class="sitSolicitud"> Pendent de validar</option>
                            <option <?php if ($session->get('situacion_fltr') == "comprobarAnt") { echo "selected";}?> value = "comprobarAnt" class="sitSolicitud"> Comprovar Antonia</option>
                            <option <?php if ($session->get('situacion_fltr') == "comprobarAntReg") { echo "selected";}?> value = "comprobarAntReg" class="sitSolicitud"> Comprovar Antonia amb requeriment pendent</option>
                            <option <?php if ($session->get('situacion_fltr') == "emitirReq") { echo "selected";}?> value = "emitirReq" class="sitSolicitud"> Emetre requeriment</option>
                            <option <?php if ($session->get('situacion_fltr') == "firmadoReq") { echo "selected";}?> value = "firmadoReq" class="sitSolicitud"> Requeriment signat pendent de notificar</option>
                            <option <?php if ($session->get('situacion_fltr') == "notificadoReq") { echo "selected";}?> value = "notificadoReq" class="sitSolicitud"> Requeriment notificat</option>
                            <option <?php if ($session->get('situacion_fltr') == "emitirDesEnmienda") { echo "selected";}?> value = "emitirDesEnmienda" class="sitSolicitud"> Emetre desistiment per esmena</option>
                            <option <?php if ($session->get('situacion_fltr') == "emitidoDesEnmienda") { echo "selected";}?> value = "emitidoDesEnmienda" class="sitSolicitud"> Desistiment per esmena emès</option>
														<option <?php if ($session->get('situacion_fltr') == "Desestimiento") { echo "selected";}?> value = "Desestimiento" class="sitSolicitud"> Desistiment</option>
                        </optgroup>
                        <optgroup style="background-color:#1ecbe1;color:#000;" label="Fase validació:">
                            <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients favorables:">
        		            		<option <?php if ($session->get('situacion_fltr') == "emitirIFPRProvPago") { echo "selected";}?> value = "emitirIFPRProvPago" class="sitValidacion"> IF + PR Provisional emetre</option>
    				            		<option <?php if ($session->get('situacion_fltr') == "emitidoIFPRProvPago") { echo "selected";}?> value = "emitidoIFPRProvPago" class="sitValidacion"> IF + PR Provisional emesa</option>
														<option <?php if ($session->get('situacion_fltr') == "firmadoPRProv") { echo "selected";}?> value = "firmadoPRProv" class="sitValidacion">PR Provisional signada pendent de notificar</option>
    				            		<option <?php if ($session->get('situacion_fltr') == "notificadoIFPRProvPago") { echo "selected";}?> value = "notificadoIFPRProvPago" class="sitValidacion"> PR Provisional NOTIFICADA (DATA) AUT</option>

	    			            		<option <?php if ($session->get('situacion_fltr') == "emitirPRDefinitiva") { echo "selected";}?> value = "emitirPRDefinitiva" class="sitValidacion"> PR definitiva Enviada a firma</option>
														<option <?php if ($session->get('situacion_fltr') == "emitidaPRDefinitiva") { echo "selected";}?> value = "emitidaPRDefinitiva" class="sitValidacion"> PR definitiva signada PENDENT de notificar</option>
														<option <?php if ($session->get('situacion_fltr') == "emitidaPRDefinitivaNotificada") { echo "selected";}?> value = "emitidaPRDefinitivaNotificada" class="sitValidacion"> PR definitiva NOTIFICADA</option>
                        		<option <?php if ($session->get('situacion_fltr') == "emitirResConcesion") { echo "selected";}?> value = "emitirResConcesion" class="sitValidacion"> Resolució de concessió enviada a firma</option>
                        		<option <?php if ($session->get('situacion_fltr') == "emitidaResConcesion") { echo "selected";}?> value = "emitidaResConcesion" class="sitValidacion"> Resolució de concessió signada PENDENT de notificar</option>
                        		<option <?php if ($session->get('situacion_fltr') == "notificadaResConcesion") { echo "selected";}?> value = "notificadaResConcesion" class="sitValidacion"> Resolució de concessió NOTIFICADA</option>
            		        		
														<option <?php if ($session->get('situacion_fltr') == "inicioConsultoria") { echo "selected";}?> value = "inicioConsultoria" class="sitValidacion"> Inici de consultoria</option>
														<option <?php if ($session->get('situacion_fltr') == "inicioExpediente") { echo "selected";}?> value = "inicioExpediente" class="sitValidacion"> Inici expedient</option>

                            </optgroup>   
                            <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients NO favorables:">
                            <option <?php if ($session->get('situacion_fltr') == "emitirIDPDenProv") { echo "selected";}?> value = "emitirIDPDenProv" class="sitValidacion"> ID + P denegació provisional emetre</option>
				                <option <?php if ($session->get('situacion_fltr') == "emitidoIDPDenProv") { echo "selected";}?> value = "emitidoIDPDenProv" class="sitValidacion"> ID + P denegació provisional emesa</option>
    				            <option <?php if ($session->get('situacion_fltr') == "emitirPDenDef") { echo "selected";}?> value = "emitirPDenDef" class="sitValidacion"> P denegació definitiva emetre</option>
            		            <option <?php if ($session->get('situacion_fltr') == "emitidoPDenDef") { echo "selected";}?> value = "emitidoPDenDef" class="sitValidacion"> P denegació definitiva emesa</option>
            		            <option <?php if ($session->get('situacion_fltr') == "emitirResDen") { echo "selected";}?> value = "emitirResDen" class="sitValidacion"> Resolució de denegació emetre</option>	
                            <option <?php if ($session->get('situacion_fltr') == "emitidoResDen") { echo "selected";}?> value = "emitidoResDen" class="sitValidacion"> Resolució de denegació emesa</option>
                            <option <?php if ($session->get('situacion_fltr') == "Denegado") { echo "selected";}?> value = "Denegado" class="sitValidacion"> Denegat</option>
                            </optgroup>
                        </optgroup>
                        <optgroup style="background-color:#6d9eeb;color:#000;" label="Fase justificació pagament:">
                            <optgroup  style="background-color:#fff;color:#6d9eeb;" label="Justificació correcta:">
                		        <option <?php if ($session->get('situacion_fltr') == "pendienteJustificar") { echo "selected";}?> value = "pendienteJustificar" class="sitEjecucion"> Pendent de justificar</option>
                		        <option <?php if ($session->get('situacion_fltr') == "pendienteRECJustificar") { echo "selected";}?> value = "pendienteRECJustificar" class="sitEjecucion"> Pendent <span class="seu-elect">SEU</span> justificant</option>
            	    	        <option <?php if ($session->get('situacion_fltr') == "Justificado") { echo "selected";}?> value = "Justificado" class="sitEjecucion"> Justificat</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitirResPagoyJust") { echo "selected";}?> value = "emitirResPagoyJust" class="sitEjecucion"> Resolució de pagament i justificació emetre</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitidoResPagoyJust") { echo "selected";}?> value = "emitidoResPagoyJust" class="sitEjecucion"> Resolució de pagament i justificació emesa</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "Finalizado") { echo "selected";}?> value = "Finalizado" class="sitEjecucion"> Finalitzat</option>
                            </optgroup>   
                            <optgroup  style="background-color:#fff;color:#6d9eeb;" label="En cas de requeriment:">
            		            <option <?php if ($session->get('situacion_fltr') == "emitirReqJust") { echo "selected";}?> value = "emitirReqJust" class="sitEjecucion"> Requeriment de justificació emetre</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitidoReqJust") { echo "selected";}?> value = "emitidoReqJust" class="sitEjecucion"> Requeriment de justificació emes</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitirPropRevocacion") { echo "selected";}?> value = "emitirPropRevocacion" class="sitEjecucion"> Proposta de revocació emetre</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitidoPropRevocacion") { echo "selected";}?> value = "emitidoPropRevocacion" class="sitEjecucion"> Proposta de revocació emes</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitirResRevocacion") { echo "selected";}?> value = "emitirResRevocacion" class="sitEjecucion"> Resolució de revocació emetre</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "emitidoResRevocacion") { echo "selected";}?> value = "emitidoResRevocacion" class="sitEjecucion"> Resolució de revocació emesa</option>
        	    	            <option <?php if ($session->get('situacion_fltr') == "revocado") { echo "selected";}?> value = "revocado" class="sitEjecucion"> Revocat</option>
                            </optgroup>                          
                        </optgroup>
						<?php } else {?>
						<optgroup class="solicitud_tab" label="Fase sol·licitud:">
                           	<option <?php if ($session->get('situacion_fltr') === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitEjecucion_ils"> No ha passat per la <span class="seu-elect">SEU</span></option>
                           	<option <?php if ($session->get('situacion_fltr') === "pendiente") { echo "selected";}?> value = "pendiente" class="sitEjecucion_ils"> Pendent de validar</option>
                           	<option <?php if ($session->get('situacion_fltr') === "reqFirmado") { echo "selected";}?> value = "reqFirmado" class="sitEjecucion_ils"> Requeriment signat</option>
                           	<option <?php if ($session->get('situacion_fltr') === "reqNotificado") { echo "selected";}?> value = "reqNotificado" class="sitEjecucion_ils"> Requeriment notificat + 30 dies per subsanar</option>
                        </optgroup>
						<optgroup class="validacion_tab " label="Fase adhesió:">
                           	<option <?php if ($session->get('situacion_fltr') === "ifResolucionEmitida") { echo "selected";}?> value = "ifResolucionEmitida" class="sitEjecucion_ils"> IF + resolució emesa</option>
                           	<option <?php if ($session->get('situacion_fltr') === "ifResolucionEnviada") { echo "selected";}?> value = "ifResolucionEnviada" class="sitEjecucion_ils"> IF + resolució enviada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "ifResolucionNotificada") { echo "selected";}?> value = "ifResolucionNotificada" class="sitEjecucion_ils"> IF + resolución notificada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "empresaAdherida") { echo "selected";}?> value = "empresaAdherida" class="sitEjecucion_ils"> Empresa adherida</option>
                        </optgroup>
						<optgroup class="ejecucion_tab" label="Fase seguiment:">
                           	<option <?php if ($session->get('situacion_fltr') === "idResolucionDenegacionEmitida") { echo "selected";}?> value = "idResolucionDenegacionEmitida" class="sitEjecucion_ils"> ID + resolució denegació emesa</option>
                           	<option <?php if ($session->get('situacion_fltr') === "idResolucionDenegacionEnviada") { echo "selected";}?> value = "idResolucionDenegacionEnviada" class="sitEjecucion_ils"> ID + resolución denegació enviada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "idResolucionDenegacionNotificada") { echo "selected";}?> value = "idResolucionDenegacionNotificada" class="sitEjecucion_ils"> ID + resolució denegació notificada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "empresaDenegada") { echo "selected";}?> value = "empresaDenegada" class="sitEjecucion_ils"> Empresa denegada</option>
                        </optgroup>
						<optgroup class="justificacion_tab" label="Fase renovació:">
														<option <?php if ($expedientes['situacion_fltr'] === "pendienteJustificar") { echo "selected";}?> value = "pendienteJustificar" class="sitEjecucion_ils"> Pendent de justificar</option>
                           	<option <?php if ($session->get('situacion_fltr') === "justificantGOIB") { echo "selected";}?> value = "justificantGOIB" class="sitEjecucion_ils"> Rebut justificant de distribució GOIB</option>
                           	<option <?php if ($session->get('situacion_fltr') === "adhesionRenovada") { echo "selected";}?> value = "adhesionRenovada" class="sitEjecucion_ils"> Adhesió renovada</option>
                        </optgroup>
						<?php }?>
			        </select>
		</div>
	</div>

	<div class="filter-area-col">
 		<div class="form-group">
  		<input class="form-control-itramits" onfocus="this.value=''" name="textoLibre_fltr" id="textoLibre_fltr" type="text" placeholder = "Text lliure..." value = "<?php echo $session->get('textoLibre_fltr');?>">
  	</div>
	</div>

	<div class = "filter-area-col">
		<input type="submit" class="btn btn-itramits-aceptar" value="Filtra">
	</div>
</div>
</form>
		<?php
			if ($expedientes) {
		?>
  	<!-- The first list item is the header of the table -->
<div class = "lista-exped-wrapper">
  <div class = "header-wrapper">
   	<div <?php echo($sort_by == 'fecha_completado' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/fecha_completado/" . (($sort_order == 'ASC' && $sort_by == 'fecha_completado') ? 'DESC' : 'ASC'), 'https');?>">Data complet</a>
	</div>
	<div <?php echo($sort_by == 'tipo_tramite' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/tipo_tramite/" . (($sort_order == 'ASC' && $sort_by == 'tipo_tramite') ? 'DESC' : 'ASC'), 'https');?>">Linia de tràmit</a>					
    </div>
	<div <?php echo($sort_by == 'idExp' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/idExp/" . (($sort_order == 'ASC' && $sort_by == 'idExp') ? 'DESC' : 'ASC'), 'https');?>">N. exped.</a>
	</div>
	<div <?php echo($sort_by == 'empresa' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/empresa/" . (($sort_order == 'ASC' && $sort_by == 'empresa') ? 'DESC' : 'ASC'), 'https');?>">Sol·licitant</a>					
    </div>
	<div class="header-wrapper-col">
		<?php if ( strtoupper($session->get('programa_fltr')) === 'ILS' ) {?>
			 Visible a la web ILS
		<?php } elseif ( strtoupper($session->get('programa_fltr')) === 'ADR-ISBA' ) {
			?>
			Import ajut sol·licitat
		<?php } else {?>
			Import (€)
		<?php }?>
  	</div>
	<div <?php echo($sort_by == 'nom_consultor' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/nom_consultor/" . (($sort_order == 'ASC' && $sort_by == 'nom_consultor') ? 'DESC' : 'ASC'), 'https');?>">Ordre pagament</a>
	</div>
	<div <?php echo($sort_by == 'empresa_consultor' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/empresa_consultor/" . (($sort_order == 'ASC' && $sort_by == 'empresa_consultor') ? 'DESC' : 'ASC'), 'https');?>">Empresa consultor</a>
	</div>
 	<div <?php echo($sort_by == 'nom_consultor' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/nom_consultor/" . (($sort_order == 'ASC' && $sort_by == 'nom_consultor') ? 'DESC' : 'ASC'), 'https');?>">Nom del consultor</a>
	</div>
	<div <?php echo($sort_by == 'fecha_firma_res' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/fecha_firma_res/" . (($sort_order == 'ASC' && $sort_by == 'fecha_firma_res') ? 'DESC' : 'ASC'), 'https');?>">Res. de concessió</a>
	</div>
	<div <?php echo($sort_by == 'situacion' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/situacion/" . (($sort_order == 'ASC' && $sort_by == 'situacion') ? 'DESC' : 'ASC'), 'https');?>">Situació</a>
	</div>
	<div class = "header-wrapper-col">
		<span class='alert alert-info'>
			<?php echo $totalExpedientes;?>
		</span>
	</div>
  </div>
  <!-- The rest of the items in the list are the actual data -->
  				<?php
					$i = 0;
					foreach ($expedientes as $item) {
						$col_class = ($i % 2 == 0 ? 'odd_col' : 'even_col');
						$i++;
					?>
  	<div id ="fila" class = "detail-wrapper">
   		<span id = "fechaComletado" class = "detail-wrapper-col"><?php if ($item['fecha_completado'] != '0000-00-00 00:00:00' && $item['fecha_completado'] != '1970-01-01 01:00:00') {echo $item['fecha_completado'];} ?></span>
			<span id = "tipoTramite" class = "detail-wrapper-col"><?php echo $item['tipo_tramite']; ?></span>
			<span id = "idExp" class = "detail-wrapper-col"><?php echo $item['idExp'].' / '.$item['convocatoria']; ?></span>												
			<span id = "solicitante" class = "detail-wrapper-col"><?php 
				if ($item['tipo_tramite'] === 'FELIB') {
					$empresa = explode("#", $item['empresa']);
					echo "AJUNTAMENT de ".strtoupper($empresa[1]);
				} else {
					echo $item['empresa'];
				}
			?></span>
			
		<?php if ( strtoupper($session->get('programa_fltr')) != 'ILS' ) {?>
				<span id = "semaforo" class = "detail-wrapper-col">
					<?php 
					if ( strtoupper($session->get('programa_fltr')) != 'ADR-ISBA' && strtoupper($session->get('programa_fltr')) != 'FELIB') {
						$importeAyuda = number_format($item['importeAyuda'], 2, ',', '.');
						echo $importeAyuda;
					} else {
						echo $item['importe_ayuda_solicita_idi_isba'];
					} 
					?>
				</span>
		<?php } else {?>
				<span id = "publicar_en_web" class = "detail-wrapper-col">
					<?php  If ( $item['publicar_en_web'] == 1 )  { echo 'SI'; } else {  echo 'NO'; };?>
				</span>
		<?php }?>
		
		<span id = "ordenDePago" class = "detail-wrapper-col">
			<?php if ( strtoupper($session->get('programa_fltr')) != 'ADR-ISBA' && strtoupper($session->get('programa_fltr')) != 'FELIB') {?>
				<?php echo $item['ordenDePago'];?>
			<?php }?>
		</span>
		
		<span id = "empresa_consultor" class = "detail-wrapper-col"><?php echo $item['empresa_consultor']; ?></span>
		<span id = "nom_consultor" class = "detail-wrapper-col"><?php echo $item['nom_consultor']; ?></span>
		<span id = "fecha_not_propuesta_resolucion_def" class = "detail-wrapper-col"><?php echo $item['fecha_not_propuesta_resolucion_def']; ?></span>
		<span id = "situacion" class = "detail-wrapper-col">
			<?php 
			if ($item['situacion'] == "pendiente") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-final"><span title="Aquesta sol·licitud está pendent de validació">Pendent <br>de validar</span></div>'; 
			}
			else if ($item['situacion'] == "nohapasadoREC") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-lbl"><span title="Aquesta sol·licitud No ha passat per la SEU electrònica">No ha passat <br>per la <span class="seu-elect">SEU</span><br>electrònica</span></div>'; 
			}
			else if ($item['situacion'] == "comprobarAnt") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-lbl solicitud-lbl-jurid"><span title="Aquesta sol·licitud la de comprobar el S.Juridic">Comprovar<br>Antonia</span></div>'; 
			}
			else if ($item['situacion'] == "comprobarAntReg") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-lbl solicitud-lbl-jurid-req"><span title="Aquesta sol·licitud la de comprobar el S.Juridic">Comprovar<br>Antonia amb<br>requeriment<br>pendent</span></div>'; 
			}
			else if ($item['situacion'] == "emitirReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl solicitud-lbl-emit-req"><span title="Aquesta sol·licitud está pendent emetre requeriment">Emetre<br>requeriment</span></div>'; 
			}
			else if ($item['situacion'] == "firmadoReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl"><span title="Aquesta sol·licitud el requeriment está signat pendent de notificar"><strong>Requeriment signat<br>pendent de notificar</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "notificadoReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl"><span title="Aquesta sol·licitud s´ha notificat el requeriment"><strong>Requeriment notificat</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "emitirDesEnmienda") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl"><span title="Aquesta sol·licitud s´ha d´emetre desistiment per esmena"><strong>Emetre desistiment <br>per esmena</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "emitidoDesEnmienda") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl"><span title="Aquesta sol·licitud s´ha emès desistiment per esmena"><strong>Desistiment per <br>esmena emès</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "Desestimiento") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-final"><span title="El sol·licitant a desistit en demanar l´ajut/subvenció"><strong>Desistiment</strong></span></div>';				
			}
			/*  */
			else if ($item['situacion'] == "emitirIFPRProvPago") {?>
				<div id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl">
						<strong>IF + PR<br>Provisional emetre</strong>	
				</div>

			<?php }
			else if ($item['situacion'] == "emitidoIFPRProvPago") {?>
				<div  id="'.$item['id'].'" class = "btn-itramits validacion-lbl validacion-lbl-emesa">
						<strong>IF + PR Provisional emesa</strong>
				</div>
			<?php }
			else if ($item['situacion'] == "notificadoIFPRProvPago") {?>
				<div id="'.$item['id'].'" class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa">
					<span title="Aquesta sol·licitud s'ha notificat PR Provisional">
					<strong>PR Provisional</strong>
					<?php	if (($item['fecha_requerimiento_notif'] === '0000-00-00 00:00:00') || ($item['fecha_requerimiento_notif'] === '0000-00-00')) { /* Seleccionar si el documento va con o sin requerimiento */
						echo "<br>sense requeriment";
						$tipoDocumento = 'doc_prop_res_definitiva_adr_isba';
					} else {
						echo "<br>amb requeriment";
						$tipoDocumento = 'doc_prop_res_definitiva_con_requerimiento_adr_isba';
					}?>
					<strong><br>NOTIFICADA el <?php echo $item['fecha_not_propuesta_resolucion_prov'];?></strong>
					</span>
				</div>
				<div class="btn-idi btn-itramits">
					<?php
						echo "<span class='badge badge-primary'><small>La PR Definitiva<br>s'enviarà el ".sumarDiasHabiles($item['fecha_not_propuesta_resolucion_prov'], 10).'</small></span><br>';
						$date1 = date_create($item['fecha_not_propuesta_resolucion_prov']); 
						$actualDate = date_create(date("Y-m-d"));
						$date2 = date_create(date(sumarDiasHabiles($item['fecha_not_propuesta_resolucion_prov'], 10)));
						$diff = $actualDate->diff($date2);
						$faltan = $diff->format("%r%a dies");
						$faltanNumber = $diff->format("%r%a");
						settype($faltanNumber, "integer");
						if ($faltan >= 5) {?>
							<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies naturals que resten per emetre la Proposta de resolució provisional favorable" class="badge bg-dark">
						<?php } elseif ( $faltan > 0) { ?>
							<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies naturals que resten per emetre la Proposta de resolució provisional favorable" class="badge bg-warning blink">									
						<?php } else { ?>
							<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies naturals que resten per emetre la Proposta de resolució provisional favorable" class="badge bg-danger">
						<?php }
						if (empty($item['fecha_requerimiento_sended'])) {
							echo "<small>(resten <strong>".$faltan."</strong> naturals)</small><br>";
						}
					//echo "<small>(resten <strong>".$faltan."</strong> naturals)</small><br>";
						echo "</span><br>";
						
						if (empty($item['fecha_requerimiento_sended']) && ($faltanNumber <= 0) && ($item['tipo_tramite'] === 'ADR-ISBA')) { /* Si no se ha hecho el envío automático y han transcurrido los 10 días*/
							
							$data['id'] = $item['id'];
							$data['idExp'] = $item['idExp'];
							$data['convocatoria'] = $item['convocatoria'];
							$data['programa'] = $item['tipo_tramite'];
							$data['nifcif'] = mb_strtoupper($item['nif']);
							$data['byCEOSigned'] = true;
							$nombreDocumento = $tipoDocumento . ".pdf";
							$data['nombreDocumento'] = str_replace("doc_", $item['idExp'] . "_" . $item['convocatoria'] . "_", $nombreDocumento);
							$documentos = $db->table('pindust_documentos_generados');
							$documentos->where('id_sol', $item['id']);
							$documentos->where('corresponde_documento', $tipoDocumento);
							$documentos->where('convocatoria', $item['convocatoria']);
							$documentos->delete();
					
							$data_file = [
								'id_sol' => $item['id'],
								'name' =>  $tipoDocumento . ".pdf",
								'type' => 'application/pdf',
								'cifnif_propietario' => $item['nif'],
								'tipo_tramite' => $item['tipo_tramite'],
								'corresponde_documento' => $tipoDocumento,
								'datetime_uploaded' => time(),
								'convocatoria' => $item['convocatoria'],
								'created_at'  => WRITEPATH . 'documentos/' . $data['nifcif'] . '/informes/' . $selloDeTiempo . '/' . $tipoDocumento . ".pdf",
								'selloDeTiempo'  => $selloDeTiempo
							];
					
							$documentos->insert($data_file);
							$last_insert_id = $db->insertID();
							$data['last_insert_id'] = $last_insert_id;
							$dir = WRITEPATH . 'documentos/' . $item['nif'] . '/informes/';
							if (!is_dir($dir)) {
								mkdir($dir, 0775, true);
							}
							if (($item['fecha_requerimiento_notif'] === '0000-00-00 00:00:00') || ($item['fecha_requerimiento_notif'] === '0000-00-00')) { /* Seleccionar si el documento va sin requerimiento o con */
								echo "sense requeriment";
								$data_infor = [
									'doc_prop_res_definitiva_adr_isba' => $last_insert_id
								];
								$builder->where('id', $item['id']);
								$builder->update($data_infor);
								if ($item['tipo_tramite'] === 'ADR-ISBA' && ($item['fecha_requerimiento_notif'] === '0000-00-00 00:00:00') || ($item['fecha_requerimiento_notif'] === '0000-00-00')) { /* ISBA SIN REQUERIMIENTO */
									echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-definitiva-adr-isba', $data);
								} else { /* XECS SIN REQUERIMIENTO PENDIENTE DE QUE ISBA FUNCIONE */
									/* echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-definitiva-favorable-sin-requerimiento', $data); */
								}
								echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
								echo view('pages/forms/rest_api_firma/envia-a-firma-informe-auto-send', $data);
							}
							else {
								$data_infor = [
									'doc_prop_res_definitiva_con_requerimiento_adr_isba' => $last_insert_id
								];
								$builder->where('id', $item['id']);
								$builder->update($data_infor);
								if ($item['tipo_tramite'] === 'ADR-ISBA' && ($item['fecha_requerimiento_notif'] !== '0000-00-00 00:00:00') || ($item['fecha_requerimiento_notif'] !== '0000-00-00')) { /* ISBA CON REQUERIMIENTO */
							 		echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-definitiva-con-requerimiento-adr-isba', $data);
								} else { /* XECS CON REQUERIMIENTO PENDIENTE DE QUE ISBA FUNCIONE */

								}
								echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
								echo view('pages/forms/rest_api_firma/envia-a-firma-informe-auto-send', $data);
							}					
						}	else {
							if (!empty($item['fecha_requerimiento_sended'])) {
								echo "<span class='badge bg-success'><small>Enviat el<br>".$item['fecha_requerimiento_sended']."</small></span>";
								} else {
								/* echo $item['fecha_requerimiento_notif']; */
								if (($item['fecha_requerimiento_notif'] === '0000-00-00 00:00:00') || ($item['fecha_requerimiento_notif'] === '0000-00-00')) {
									echo "notificará sense requerimient<br>";
								} else {
									echo "notificará amb requerimient<br>";
								}
								echo "<span class='badge bg-secondary'><small>Document pendent d'enviament</small></span>";
							}
						}
					?>
				</div>

			<?php }
			else if ($item['situacion'] == "emitirPRDefinitiva")  {?>
				<div  id="'.$item['id'].'" class = "btn-idi btn-itramits validacion-lbl">
					<span title="Aquesta sol·licitud s'ha d'emetre PR pagament definitiva"><strong>PR definitiva Enviada a firma</strong></span>
				</div>				
			<?php }
			else if ($item['situacion'] == "emitidaPRDefinitiva") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha d´emesa PR definitiva"><strong>PR definitiva<br> signada PENDENT de notificar</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaPRDefinitivaNotificada") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha notificat PR definitiva"><strong>PR definitiva<br> NOTIFICADA</strong></span></div>';				
			}
			else if ($item['situacion'] == "firmadoIFPRProvPago") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha notificat PR Provisional firmada pendiente de notificar"><strong>PR Prov.<br> SIGNADA</strong><br>pendent de notificar</span></div>';				
			}			
					
			else if ($item['situacion'] == "emitirResConcesion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl"><span title="Aquesta sol·licitud s´ha d´emetre la Resolució concessió"><strong>Resolució<br>concessió enviada a firma</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaResConcesion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha emès la Resolució de concessió"><strong>Resolució<br>de concessió signada PENDENT de notificar</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaResConcesion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha notificat la Resolució de concessió"><strong>Resolució<br>de concessió NOTIFICADA</strong></span></div>';				
			}

			else if ($item['situacion'] == "inicioConsultoria") {?>
				<div id="'.$item['id'].'" class = "btn-itramits validacion-lbl validacion-lbl-emesa">
						<strong>Inici de consultoria</strong>
				</div>
				<div class="btn-itramits validacion-lbl add-margin-top">
							<?php 
							$date1 = date_create($item['fecha_limite_consultoria']);
							$date2 = date_create(date($item['fecha_limite_consultoria']));
							$actualDate = date_create(date("Y-m-d"));
							$diff  = date_diff($actualDate, $date2);
							$faltan = $diff->format("%a dies");
							if ($faltan >= 5) {?>
								<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies que resten per finalitzar" class="badge bg-dark">
								<?php } elseif ( $faltan > 0) { ?>
									<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies que resten per finalitzar" class="badge blink">									
								<?php } else { ?>
									<div data-bs-toggle="tooltip" data-bs-placement="left" title="...dies que resten per finalitzar" class="badge bg-danger">
								<?php } 
							echo "<small>".$faltan."</small>";
							echo "</span>";
							echo "<br><small>[data límit: ".date_format(date_create($item['fecha_limite_consultoria']),"Y-m-d")."]</small> ";	?>	
				</div>				
			<?php }
			/*  */
			else if ($item['situacion'] == "inicioExpediente") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl"><span title="Aquesta sol·licitud es troba en inici Expedient"><strong>Inici expedient</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitirIDPDenProv") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl"><span title="Aquesta sol·licitud s´ha d´emetre ID + P denegació provisional"><strong>ID + P denegació<br>provisional emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidoIDPDenProv") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha emès ID + P denegació provisional"><strong>ID + P denegació<br>provisional emesa</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitirPDenDef") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl"><span title="Aquesta sol·licitud s´ha d´emetre P denegació definitiva"><strong>P denegació<br>definitiva emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaPDenDef") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha emès P denegació definitiva"><strong>P denegació<br>definitiva emesa</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitirResDen") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl"><span title="Aquesta sol·licitud s´ha d´emetre Resolució de denegació"><strong>Resolució <br>de denegació<br>emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidoResDen") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-lbl-emesa"><span title="Aquesta sol·licitud s´ha emesa Resolució de denegació">Resolució <br>de denegació<br>emesa</span></div>';				
			}
			else if ($item['situacion'] == "Denegado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl validacion-final"><span title="Aquesta sol·licitud s´ha Denegat">Denegat</span></div>';				
			}
			/*  */
			else if ($item['situacion'] == "pendienteJustificar") {?>
				<div  id="'.$item['id'].'"  class = "btn-itramits ejecucion-lbl">
					<strong>Pendent de justificar</strong>
				</div><br>
				<div class="btn-itramits ejecucion-lbl add-margin-top">
						<?php	
							$date1 = date_create($item['fecha_limite_justificacion']);
							$actualDate = date_create(date("Y-m-d"));
							$diffjust = date_diff($actualDate, $date1);
							?>
						<?php if ($diffjust->format("%R%a") > 5) {?>
							<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies naturals que resten per justificar" class="badge bg-dark"><?php echo $diffjust->format("%a dies naturals");?></span>
						<?php } elseif (($diffjust->format("%R%a") < 0) ) { ?>
							<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies naturals que resten per justificar" class="badge bg-danger"><?php echo $diffjust->format("%R%a dies naturals");?></span>
						<?php } elseif (($diffjust->format("%R%a") <= 5) ) { ?>
							<span data-bs-toggle="tooltip" data-bs-placement="left" title="...dies naturals que resten per justificar" class="badge blink"><?php echo $diffjust->format("%a dies naturals");?></span>
						<?php } 
						echo "<br><small>[data max. just.: ".date_format(date_create($item['fecha_limite_justificacion']),"Y-m-d")."]</small> ";	?>			
				</div>
			<?php }
			else if ($item['situacion'] == "pendienteRECJustificar") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud esta pendent de que, el sol·licitant, la passi per la SEU">Pendent<br><span class="seu-elect">SEU</span><br>justificant</span></div>';
			}
			else if ($item['situacion'] == "Justificado" ) {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-justificado"><span title="Aquesta sol·licitud esta justificada"><strong>Justificat</strong></span></div>';
			}
			else if ($item['situacion'] == "emitirResPagoyJust" ) {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-justificado"><span title="Aquesta sol·licitud esta justificada"><strong>Resolució de pagament<br>i justificació emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoResPagoyJust") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha emès la resolució de justificació"><strong>Resolució de pagament<br>i justificació emesa</strong></span></div>';
			}
			else if ($item['situacion'] == "Finalizado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-final"><span title="Aquesta sol·licitud s´ha finalitzat"><strong>Finalitzat</strong></span></div>';
			}
			/*  */
			else if ($item['situacion'] == "emitirReqJust") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha d´emetre requeriment de justificació">Requeriment de <br>justificació emetre</span></div>';
			}
			else if ($item['situacion'] == "emitidoReqJust") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha emès requeriment de justificació">Requeriment de <br>justificació emès</span></div>';
			}
			else if ($item['situacion'] == "emitirPropRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha emetre proposta de revocació">Proposta de<br>revocació emetre</span></div>';
			}
			else if ($item['situacion'] == "emitidoPropRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha emesa proposta de revocació">Proposta de<br>revocació emesa</span></div>';
			}
			else if ($item['situacion'] == "emitirResRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha d´emetre la resolució de revocació">Resolució de<br>revocació emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoResRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl"><span title="Aquesta sol·licitud s´ha emès la resolució de revocació">Resolució de<br>revocació emesa</span></div>';
			}
			else if ($item['situacion'] == "revocado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-revocado"><span title="Aquesta sol·licitud s´ha revocat"><strong>Revocat</strong></span></div>';
			}

			/* ------------------------- inicio estados propios de ILS ----------------------------------  */
		else if ($item['situacion'] == "reqNotificado") {
			echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits ejecucion-final"><span title="Aquesta sol·licitud s´ha notificat el requeriment"><strong>Requeriment notificat <br>+ 30 dies <br>per subsanar </strong></span></div>';
		}

else if ($item['situacion'] == "ifResolucionEmitida") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl"><span title="Aquesta sol·licitud s´ha emès resolució"><strong>IF + Resolució <br>Emesa</strong></span></div>';
}
else if ($item['situacion'] == "ifResolucionEnviada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl"><span title="Aquesta sol·licitud s´ha enviat la resolució"><strong>IF + Resolució <br>Enviada</strong></span></div>';
}
else if ($item['situacion'] == "ifResolucionNotificada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl"><span title="Aquesta sol·licitud s´ha notificat la resolució"><strong>IF + Resolució <br>Notificada</strong></span></div>';
}
else if ($item['situacion'] == "empresaAdherida") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl-final"><span title="Aquesta sol·licitud acaba en adhesió al programa ILS"><strong>Adherida a ILS</strong></span></div>';
}

else if ($item['situacion'] == "idResolucionDenegacionEmitida") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl"><span title="Aquesta sol·licitud s´ha emès la resolució de Denegació"><strong>ID + Resolució <br>denegació emesa</strong></span></div>';
}
else if ($item['situacion'] == "idResolucionDenegacionEnviada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl"><span title="Aquesta sol·licitud s´ha enviat la resolució de Denegació"><strong>ID + Resolució <br>denegació enviada</strong></span></div>';
}
else if ($item['situacion'] == "idResolucionDenegacionNotificada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl"><span title="Aquesta sol·licitud s´ha notificat la resolució de Denegació"><strong>ID + Resolució <br>denegació notificada</strong></span></div>';
}
else if ($item['situacion'] == "empresaDenegada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl-final"><span title="Aquesta sol·licitud s´ha denegat l´adhesió"><strong>Adhesió Denegada</strong></span></div>';
}
else if ($item['situacion'] == "justificantGOIB") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits justificacion_tab"><span title="Rebut justificant de distribució GOIB"><strong>Rebut justificant<br>de<br>distribució GOIB</strong></span></div>';
}
else if ($item['situacion'] == "adhesionRenovada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits justificacion_tab_final"><span title="Adhesió renovada"><strong>Adhesió Renovada</strong></span></div>';
}
/* ------------------------- fin estados propios de ILS -------------------------------------- */

			else {
				echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits indeterminado"><span title="Aquesta sol·licitud s´ha ?????"><strong>'.$item['situacion'].'</strong></span></div>';
			}									
			?>
			</span>
			<?php
				$referencia = "na-na";
				if (strlen($item['ref_REC']) > 0) {
					$referencia = str_replace("/","-",$item['ref_REC']) ;
				}
			?>
			<span id="__<?php echo $item['id'];?>" class = "detail-wrapper-col"><a id="_<?php echo $item['id'];?>" onclick= "cambiarTexto(<?php echo $item['id'];?>)" href="<?php echo base_url('/public/index.php/expedientes/edit/'.$item['id']);?>" class="btn btn-itramits-info">+info</a></span>
  	</div>
			<?php
			}
			?>
    <?php
      } else {
          echo "<div class='alert alert-warning'><strong>Cap expedient!</strong> No s'ha trobat cap informació coincident amb els seus criteris de filtrat.</div>";
      }
    ?>
</div>
</div>
</div>
</div>

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

<?php 
function sumarDiasHabiles($fechaInicial, $dias) {
	$fecha = new DateTime($fechaInicial);
	$diasHabiles = 0;

	while ($diasHabiles < $dias) {
			$fecha->modify('+1 day');

			// Excluir sábados y domingos
			if ($fecha->format('N') < 6) {
					$diasHabiles++;
			}
	}

	return $fecha->format('Y-m-d');
}
?>

<style>
	a {
  color:white;
}

form  {
  height:12vh;
  width:100%;
}

/*Hack to get them to align properly */
.filter-area > *:not([type="date"]) {
  border-top:1px solid white;
  border-bottom:1px solid white;
}

.filter-area input[type="submit"] {
  background:#c30045;
  border-top: 1px solid #c30045;
  border-bottom: 1px solid #c30045;
  color:white;
}

.filter-area {
  z-index: 10;
  position: relative;
}

.filter-area > * {
  border:0;
  padding:0;
  background:white;
  line-height:50px;
  font-size: 20px;
  border-radius:0;
  outline:0;
  border-right:1px solid rgba(0,0,0,0.2);
}

.filter-area > *:last-child {
  border-right: 0;
}

/*Flexbox Starts Here*/

form {
  display: flex;
  justify-content:center; /* centrado horizontal */
  align-items: center; /* centrado vertical */
}

.filter-area {
  display: flex;
	justify-content: space-around;
  border: 0.25rem solid #003747;
  border-radius: 5px;
	margin-top: 8rem;
	margin-bottom: 9rem;
}

.filter-area-col {
	align-self: center;
}
</style>

