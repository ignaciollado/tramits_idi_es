<script defer type="text/javascript" src="/public/assets/js/listado-expediente.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<link rel="stylesheet" type="text/css" href="/public/assets/grocery_crud/themes/flexigrid/css/flexigrid.css" >

<?php
	//defined('BASEPATH') OR exit('No direct script access allowed');
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
			<input class="<?php if ($session->get('rol') == 'admin') { echo 'form-control-itramits';} else {echo 'form-control-itramits-disabled';} ?> " onfocus="this.value=''" list="programa" name="programa_fltr" id="programa_fltr" <?php if ($session->get('rol')!='admin') { echo 'disabled';} ?> placeholder = "Programa ..." value = "<?php 
																																																				if ($session->get('rol') != 'admin') {
																																																					echo $session->get('rol');
																																																				} else {
																																																					echo $session->get('programa_fltr');
																																																				}
																																																				?>">
  			<datalist id="programa">
			  	<option value="Programa iDigital 20">
    			<option value="Programa I">
					<option value="Programa II">
					<option value="Programa III">	
    			<option value="Programa III actuacions corporatives">
    			<option value="Programa III actuacions producte">
					<option value="Programa IV">
					<option value="ILS">
					<option value="IDI-ISBA">
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
                            <option <?php if ($session->get('situacion_fltr') == "comprobarAntReg") { echo "selected";}?> value = "comprobarAntReg" class="sitSolicitud"> Comprovar Antonia amb <br>requeriment pendent</option>
                            <option <?php if ($session->get('situacion_fltr') == "emitirReq") { echo "selected";}?> value = "emitirReq" class="sitSolicitud"> Emetre requeriment</option>
                            <option <?php if ($session->get('situacion_fltr') == "firmadoReq") { echo "selected";}?> value = "firmadoReq" class="sitSolicitud"> Requeriment signat</option>
                            <option <?php if ($session->get('situacion_fltr') == "notificadoReq") { echo "selected";}?> value = "notificadoReq" class="sitSolicitud"> Requeriment notificat</option>
                            <option <?php if ($session->get('situacion_fltr') == "emitirDesEnmienda") { echo "selected";}?> value = "emitirDesEnmienda" class="sitSolicitud"> Emetre desistiment <br>per esmena</option>
                            <option <?php if ($session->get('situacion_fltr') == "emitidoDesEnmienda") { echo "selected";}?> value = "emitidoDesEnmienda" class="sitSolicitud"> Desistiment per <br>esmena emès</option>
														<option <?php if ($session->get('situacion_fltr') == "Desestimiento") { echo "selected";}?> value = "Desestimiento" class="sitSolicitud"> Desistiment</option>
                        </optgroup>
                        <optgroup style="background-color:#1ecbe1;color:#000;" label="Fase validació:">
                            <optgroup style="background-color:#fff;color:#1ecbe1;" label="Expedients favorables:">
        		            		<option <?php if ($session->get('situacion_fltr') == "emitirIFPRProvPago") { echo "selected";}?> value = "emitirIFPRProvPago" class="sitValidacion"> IF + PR Provisional emetre</option>
    				            		<option <?php if ($session->get('situacion_fltr') == "emitidoIFPRProvPago") { echo "selected";}?> value = "emitidoIFPRProvPago" class="sitValidacion"> IF + PR Provisional emesa</option>
	    			            		<option <?php if ($session->get('situacion_fltr') == "emitirPRDefinitiva") { echo "selected";}?> value = "emitirPRDefinitiva" class="sitValidacion"> PR definitiva emetre</option>
														<option <?php if ($session->get('situacion_fltr') == "emitidaPRDefinitiva") { echo "selected";}?> value = "emitidaPRDefinitiva" class="sitValidacion"> PR definitiva emesa</option>
                        		<option <?php if ($session->get('situacion_fltr') == "emitirResConcesion") { echo "selected";}?> value = "emitirResConcesion" class="sitValidacion"> Resolució de concessió emetre</option>
                        		<option <?php if ($session->get('situacion_fltr') == "emitidaResConcesion") { echo "selected";}?> value = "emitidaResConcesion" class="sitValidacion"> Resolució de concessió emesa</option>
            		        		<option <?php if ($session->get('situacion_fltr') == "inicioConsultoria") { echo "selected";}?> value = "inicioConsultoria" class="sitValidacion"> Inici de consultoria</option>
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
                		        <option <?php if ($session->get('situacion_fltr') == "pendienteRECJustificar") { echo "selected";}?> value = "pendienteRECJustificar" class="sitEjecucion"> Pendent <span class="seu-elect">SEU</span> justificat</option>
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
						<optgroup class="sitSolicitud_cab_ils" label="Fase sol·licitud:">
                           	<option <?php if ($session->get('situacion_fltr') === "nohapasadoREC") { echo "selected";}?> value = "nohapasadoREC" class="sitSolicitud_ils"> No ha passat per la <span class="seu-elect">SEU</span></option>
                           	<option <?php if ($session->get('situacion_fltr') === "pendiente") { echo "selected";}?> value = "pendiente" class="sitSolicitud_ils"> Pendent de validar</option>
                           	<option <?php if ($session->get('situacion_fltr') === "reqFirmado") { echo "selected";}?> value = "reqFirmado" class="sitSolicitud_ils"> Requeriment signat</option>
                           	<option <?php if ($session->get('situacion_fltr') === "reqNotificado") { echo "selected";}?> value = "reqNotificado" class="sitSolicitud_ils"> Requeriment notificat + 30 dies per subsanar</option>
                        </optgroup>
						<optgroup class="sitAdhesion_cab_ils" label="Fase adhesió:">
                           	<option <?php if ($session->get('situacion_fltr') === "ifResolucionEmitida") { echo "selected";}?> value = "ifResolucionEmitida" class="sitAdhesion_ils"> IF + resolució emesa</option>
                           	<option <?php if ($session->get('situacion_fltr') === "ifResolucionEnviada") { echo "selected";}?> value = "ifResolucionEnviada" class="sitAdhesion_ils"> IF + resolució enviada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "ifResolucionNotificada") { echo "selected";}?> value = "ifResolucionNotificada" class="sitAdhesion_ils"> IF + resolución notificada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "empresaAdherida") { echo "selected";}?> value = "empresaAdherida" class="sitAdhesion_ils"> Empresa adherida</option>
                        </optgroup>
						<optgroup class="sitEjecucion_cab_ils" label="Fase seguiment:">
                           	<option <?php if ($session->get('situacion_fltr') === "idResolucionDenegacionEmitida") { echo "selected";}?> value = "idResolucionDenegacionEmitida" class="sitEjecucion_ils"> ID + resolució denegació emesa</option>
                           	<option <?php if ($session->get('situacion_fltr') === "idResolucionDenegacionEnviada") { echo "selected";}?> value = "idResolucionDenegacionEnviada" class="sitEjecucion_ils"> ID + resolución denegació enviada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "idResolucionDenegacionNotificada") { echo "selected";}?> value = "idResolucionDenegacionNotificada" class="sitEjecucion_ils"> ID + resolució denegació notificada</option>
                           	<option <?php if ($session->get('situacion_fltr') === "empresaDenegada") { echo "selected";}?> value = "empresaDenegada" class="sitEjecucion_ils"> Empresa denegada</option>
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

	<!-- <?php if ($session->get('rol') == 'admin') {?>
		<div class="filter-area-col">
			<a title="Afegir una sol·licitud manualment" target="_blank" href="<?php echo base_url("/public/index.php/home/solicitud_ayuda/manual")?>">Afegir sol·licitud</a>
		</div>
	<?php }?> -->

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
			<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/tipo_tramite/" . (($sort_order == 'ASC' && $sort_by == 'tipo_tramite') ? 'DESC' : 'ASC'), 'https');?>">Programa</a>					
    </div>
		<div <?php echo($sort_by == 'idExp' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
			<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/idExp/" . (($sort_order == 'ASC' && $sort_by == 'idExp') ? 'DESC' : 'ASC'), 'https');?>">N. exped.</a>
		</div>
		<div <?php echo($sort_by == 'empresa' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
			<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/empresa/" . (($sort_order == 'ASC' && $sort_by == 'empresa') ? 'DESC' : 'ASC'), 'https');?>">Sol·licitant</a>					
    </div>
	<div class="header-wrapper-col">
		<?php if (  strtoupper($session->get('programa_fltr')) === 'ILS' ) {?>
			 Visible a la web ILS
		<?php } elseif ( strtoupper($session->get('programa_fltr')) === 'IDI-ISBA' ) {
			?>
			Import ajut sol·licitat
			<?php } else {?>
				Import de l'ajuda (€)
		<?php }?>
  </div>
	<div <?php echo($sort_by == 'nom_consultor' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/nom_consultor/" . (($sort_order == 'ASC' && $sort_by == 'nom_consultor') ? 'DESC' : 'ASC'), 'https');?>">Representant legal</a>
	</div>
	<div <?php echo($sort_by == 'nom_consultor' ? 'class="header-wrapper-col sort_'.$sort_order.'"' : 'class="header-wrapper-col"'); ?>>
		<a href="<?php echo base_url("/public/index.php/expedientes/ordenarExpedientes/nom_consultor/" . (($sort_order == 'ASC' && $sort_by == 'nom_consultor') ? 'DESC' : 'ASC'), 'https');?>">Ordre pagament</a>
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
			<span id = "solicitante" class = "detail-wrapper-col"><?php echo $item['empresa']; ?></span>
			
		<?php if (  strtoupper($session->get('programa_fltr')) != 'ILS' ) {?>
				<span id = "semaforo" class = "detail-wrapper-col">
					<?php 
					if ( strtoupper($session->get('programa_fltr')) != 'IDI-ISBA' ) {
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

			<span id = "nombre_rep" class = "detail-wrapper-col"><?php echo $item['nombre_rep']; ?></span>
			<span id = "ordenDePago" class = "detail-wrapper-col"><?php echo $item['ordenDePago']; ?></span>
			<span id = "situacion" class = "detail-wrapper-col">			
			
			<?php 
			if ($item['situacion'] == "pendiente") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-final" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud está pendent de validació"><strong>Pendent de validar</strong></span></div>'; 
			}
			else if ($item['situacion'] == "nohapasadoREC") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud No ha passat per la SEU electrònica"><strong>No ha passat per la<br><span class="seu-elect">SEU</span><br>electrònica</strong></span></div>'; 
			}
			else if ($item['situacion'] == "comprobarAnt") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud la de comprobar el S.Juridic"><strong>Comprovar Antonia</strong></span></div>'; 
			}
			else if ($item['situacion'] == "comprobarAntReg") {
				echo '<div  id="'.$item['id'].'" class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud la de comprobar el S.Juridic"><strong>Comprovar Antonia <br>amb<br> requeriment pendent</strong></span></div>'; 
			}
			else if ($item['situacion'] == "emitirReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud está pendent emetre requeriment"><strong>Emetre requeriment</strong></span></div>'; 
			}
			else if ($item['situacion'] == "firmadoReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha signat el requeriment"><strong>Requeriment signat</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "notificadoReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha notificat el requeriment"><strong>Requeriment notificat</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "emitirDesEnmienda") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre desistiment per esmena"><strong>Emetre desistiment <br>per esmena</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "emitidoDesEnmienda") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès desistiment per esmena"><strong>Desistiment per <br>esmena emès</strong></span></div>'; 				
			}
			else if ($item['situacion'] == "Desestimiento") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-final" data-toggle = "modal" data-target = "#myModal"><span title="El sol·licitant a desistit en demanar l´ajut/subvenció"><strong>Desistiment</strong></span></div>';				
			}
			else if ($item['situacion'] == "reqFirmado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits solicitud-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud te el requeriment signat"><strong>Requeriment signat</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitirIFPRProvPago") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre IF+PR pagament"><strong>IF + PR pagament emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidoIFPRProvPago") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès IF+PR pagament"><strong>IF + PR <br>pagament emesa</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitirPRDefinitiva") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre IF+PR pagament"><strong>PR definitiva emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidoPRDefinitiva") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès IF+PR pagament"><strong>PR definitiva emesa</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitirResConcesion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre IF+PR pagament"><strong>Resolució concessió emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaResConcesion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès IF+PR pagament"><strong>Resolució concessió emesa</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitirIDPDenProv") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre IF+PR pagament"><strong>ID + P denegació<br>provisional emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaIDPDenProv") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès IF+PR pagament"><strong>ID + P denegació<br>provisional emesa</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitirPDenDef") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre IF+PR pagament"><strong>P denegació<br>definitiva emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaPDenDef") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès IF+PR pagament"><strong>P denegació<br>definitiva emesa</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitirResDen") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre IF+PR pagament"><strong>Resolució de denegació<br>emetre</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitidaResDen") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès IF+PR pagament"><strong>Resolució de denegació<br>emesa</strong></span></div>';				
			}

			else if ($item['situacion'] == "enviadoPRPago") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha enviat PR pagament"><strong>PR pagament enviat</strong></span></div>';
			}
			else if ($item['situacion'] == "emitirPagoReqIFPR") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha enviat IF+PR pagament amb requeriment emetre"><strong>IF+PR Pagament amb <br>requeriment emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "emitirPagoReqIDPD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha enviat ID+PD pagament amb requeriment emetre"><strong>ID+PD pagament amb <br>requeriment emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "inicioConsultoria") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha iniciat la consultoria"><strong>Inici de consultoria</strong></span></div>';				
			}			
			else if ($item['situacion'] == "emitirIDPD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre ID+PD"><strong>ID + PD emetre</strong></span></div>';				
			}

			else if ($item['situacion'] == "emitidoIDPD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha ID+PD emès"><strong>ID + PD emès</strong></span></div>';
			}
			else if ($item['situacion'] == "enviadoFirmaPD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha enviat a signar PD"><strong>PD enviat a signar</strong></span></div>';
			}
			else if ($item['situacion'] == "notificadoPD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha PD notificada"><strong>PD notificada</strong></span></div>';				
			}
			else if ($item['situacion'] == "emitirRD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre RD"><strong>RD emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoRD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès RD"><strong>RD emès</strong></span></div>';
			}
			else if ($item['situacion'] == "enviadoFirmaRD") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha RD enviat a signar"><strong>RD enviada a signar</strong></span></div>';
			}
			else if ($item['situacion'] == "denegado" || $item['situacion'] == "Denegado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits validacion-final" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha denegat"><strong>Denegat</strong></span></div>';
			}
			
			else if ($item['situacion'] == "pendienteJustificar") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud esta pendent de justificar"><strong>Pendent de justificar</strong></span></div>';
			}
			else if ($item['situacion'] == "pendienteRECJustificar") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud esta pendent de que, el sol·licitant, la passi per la SEU">Pendent<br><span class="seu-elect">SEU</span><br>justificant</span></div>';
			}
			else if ($item['situacion'] == "Justificado" ) {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-justificado" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud esta justificada"><strong>Justificat</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoResJustificacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès la resolució de justificació"><strong>Resolució de <br>justificació emesa</strong></span></div>';
			}

			else if ($item['situacion'] == "emitirResPagoyJust" ) {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-justificado" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud esta justificada"><strong>Resolució de pagament<br>i justificació emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoResPagoyJust") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès la resolució de justificació"><strong>Resolució de pagament<br>i justificació emesa</strong></span></div>';
			}

			else if ($item['situacion'] == "Finalizado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-final" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha finalitzat"><strong>Finalitzat</strong></span></div>';
			}
			else if ($item['situacion'] == "emitirReqJust") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre requeriment de justificació">Requeriment de <br>justificació emetre</span></div>';
			}
			else if ($item['situacion'] == "emitidoReqJust") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès requeriment de justificació">Requeriment de <br>justificació emès</span></div>';
			}
			else if ($item['situacion'] == "notificadoReq") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha notificat el requeriment">Requeriment notificat</span></div>';
			}

			else if ($item['situacion'] == "emitirPropRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emetre proposta de revocació">Proposta de<br>revocació emetre</span></div>';
			}
			else if ($item['situacion'] == "emitidoPropRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emesa proposta de revocació">Proposta de<br>revocació emesa</span></div>';
			}

			else if ($item['situacion'] == "inicioRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha iniciat la revocació"><strong>Inici de revocació</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoPropRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès proposta de revocació"><strong>Emesa proposta <br>de revocació</strong></span></div>';
			}				
			else if ($item['situacion'] == "notificadoPropRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha notificada proposta de revocació"><strong>Notificat proposta de revocació</strong></span></div>';
			}				
			else if ($item['situacion'] == "emitirResRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha d´emetre la resolució de revocació">Resolució de<br>revocació emetre</strong></span></div>';
			}
			else if ($item['situacion'] == "emitidoResRevocacion") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès la resolució de revocació">Resolució de<br>revocació emesa</span></div>';
			}
			else if ($item['situacion'] == "revocado") {
				echo '<div  id="'.$item['id'].'"  class = "btn-idi btn-itramits ejecucion-revocado" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha revocat"><strong>Revocat</strong></span></div>';
			}
/* ------------------------- inicio estados propios de ILS ----------------------------------  */


else if ($item['situacion'] == "reqNotificado") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits ejecucion-final" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha notificat el requeriment"><strong>Requeriment notificat <br>+ 30 dies <br>per subsanar </strong></span></div>';
}

else if ($item['situacion'] == "ifResolucionEmitida") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès resolució"><strong>IF + Resolució <br>Emesa</strong></span></div>';
}
else if ($item['situacion'] == "ifResolucionEnviada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha enviat la resolució"><strong>IF + Resolució <br>Enviada</strong></span></div>';
}
else if ($item['situacion'] == "ifResolucionNotificada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha notificat la resolució"><strong>IF + Resolució <br>Notificada</strong></span></div>';
}
else if ($item['situacion'] == "empresaAdherida") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits adhesion-lbl-final" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud acaba en adhesió al programa ILS"><strong>Adherida a ILS</strong></span></div>';
}

else if ($item['situacion'] == "idResolucionDenegacionEmitida") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha emès la resolució de Denegació"><strong>ID + Resolució <br>denegació emesa</strong></span></div>';
}
else if ($item['situacion'] == "idResolucionDenegacionEnviada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha enviat la resolució de Denegació"><strong>ID + Resolució <br>denegació enviada</strong></span></div>';
}
else if ($item['situacion'] == "idResolucionDenegacionNotificada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha notificat la resolució de Denegació"><strong>ID + Resolució <br>denegació notificada</strong></span></div>';
}
else if ($item['situacion'] == "empresaDenegada") {
	echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits seguimiento-lbl-final" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha denegat l´adhesió"><strong>Adhesió Denegada</strong></span></div>';
}
/* ------------------------- fin estados propios de ILS -------------------------------------- */

			else {
				echo '<div  id="'.$item['id'].'"  class = "btn btn-itramits indeterminado" data-toggle = "modal" data-target = "#myModal"><span title="Aquesta sol·licitud s´ha ?????"><strong>'.$item['situacion'].'</strong></span></div>';
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
  -webkit-appearance:none;
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
  border: 0.25rem solid rgba(0,0,0,0.3);
  border-radius: 5px;
	margin-top: 8rem;
	margin-bottom: 9rem;
}

.filter-area-col {
	align-self: center;
}
</style>

