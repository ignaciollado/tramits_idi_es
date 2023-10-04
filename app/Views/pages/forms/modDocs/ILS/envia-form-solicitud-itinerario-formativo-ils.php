<!----------------------------------------- Enviar formulario solicitud de datos adicionales de la emrpesa ILS -->

<?php
$totalNotifications = 0;
$db = \Config\Database::connect();
$query = $db->query('SELECT COUNT(id) AS totalNotificaciones FROM pindust_documentos_notificacion WHERE id_doc='.$id_doc);
foreach ($query->getResult('array') as $row)
		{
			$totalNotifications = $row['totalNotificaciones'];
		}
?>

<input type='hidden' class='text' id="id_doc_ITINERARIO" value="<?php echo $id_doc;?>"></input>
<?php
  if ( !$esAdmin && !$esConvoActual ) {?>
	  <?php }
  else {?>
		<button type="button" <?php if ( $docs_item->estado === "Rebutjat" ) { echo 'class="btn btn-primary position-relative"'; } else {echo 'style="display:none;"';} ?> 
			data-bs-toggle="modal" data-bs-target = "#myEnviarFormularioItinerarioFormativo"
			data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myBtnEnviarFormularioItinerarioFormativo" aria-hidden="true"
			id="myBtnEnviarFormularioItinerarioFormativo" 
			title="Torna a sol·licitar el document">
      		Notifica <span class="badge text-bg-secondary"><?php echo $totalNotifications;?></span>
    	</button>

<?php  }?>

  <div id="myEnviarFormularioItinerarioFormativo" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4><strong>Sol·licitud del certificat itinerari formatiu ILS</strong></h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant de l'adhesió a ILS perquè ens faci arribar el document?</span>
						</div>	
						<div class="form-group">
           			<button type="button" onclick = "javaScript: enviaMailItinerarioFormativo_click();" id="enviaMailItinerarioFormativo" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_ItinerarioFormativo" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							  </button>
							   <span id="mensajeItinerarioFormativo" class ="ocultar info-msg"></span>
        		</div>	
					</div>
				</div>
			</div>
	</div>