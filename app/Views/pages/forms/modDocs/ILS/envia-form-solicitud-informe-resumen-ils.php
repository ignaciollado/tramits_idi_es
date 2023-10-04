<!----------------------------------------- Enviar formulario solicitud del informe resumen ILS -->
<?php

$totalNotifications = 0;

$db = \Config\Database::connect();
$query = $db->query('SELECT COUNT(id) AS totalNotificaciones FROM pindust_documentos_notificacion WHERE id_doc='.$id_doc);
foreach ($query->getResult('array') as $row)
		{
			$totalNotifications = $row['totalNotificaciones'];
		}
?>
<input type='hidden' class='text' id="id_doc_RESUMEN" value="<?php echo $id_doc;?>"></input>
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
			<button type="button" <?php if ( $docs_item->estado === "Rebutjat" ) { echo 'class="btn btn-primary position-relative"'; } else {echo 'style="display:none;"';} ?> 
				data-bs-toggle="modal" data-bs-target = "#myEnviarFormularioInformeResumen" 
				id="myBtnEnviarFormularioInformeResumen" title="Torna a sol·licitar el document">
				Notifica <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-secondary"><?php echo $totalNotifications;?></span>
            </button>    
		  <?php }?>

  <div id="myEnviarFormularioInformeResumen" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4><strong>Sol·licitud de l'Informe resum ILS</strong></h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant perquè ens faci arribar el document?</span>
						</div>	
						<div class="form-group">
           			<button type="button" onclick = "javaScript: enviaMailInformeResumen_click();" id="enviaMailInformeResumen" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_InformeResumen" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							  </button>
							   <span id="mensajeInformeResumen" class ="ocultar info-msg"></span>
        		</div>	
					</div>
				</div>
			</div>
	</div>