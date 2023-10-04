<!----------------------------------------- Enviar formulario solicitud de escritura emrpesa ILS -->
<!-- <div class="card-itramits"> -->
<?php
$totalNotifications = 0;

$db = \Config\Database::connect();
$query = $db->query('SELECT COUNT(id) AS totalNotificaciones FROM pindust_documentos_notificacion WHERE id_doc='.$id_doc);
foreach ($query->getResult('array') as $row)
		{
			$totalNotifications = $row['totalNotificaciones'];
		}
?>
<input type='hidden' class='text' id="id_doc_ESCRITURA" value="<?php echo $id_doc;?>"></input>
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
			<button type="button" <?php if ( $docs_item->estado === "Rebutjat" ) { echo 'class="btn btn-primary position-relative"'; } else {echo 'style="display:none;"';} ?> 
				data-bs-toggle="modal" data-bs-target = "#myEnviarFormularioEscrituraEmpresa"
				data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myBtnEnviarFormularioEscrituraEmpresa" aria-hidden="true"
				id="myBtnEnviarFormularioEscrituraEmpresa"
				title="Torna a sol·licitar el document">Notifica 
				<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-secondary"><?php echo $totalNotifications;?></span>
      		</button>    
		<?php }?>


  	<div id="myEnviarFormularioEscrituraEmpresa" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">	
				<div class="modal-header">
					<h4><strong>Sol·licitud de l'escriptura empresa</strong></h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  				</div>
    			<div class="modal-body">
					<div class="form-group">
						<span>Vols enviar un correu electrònic al sol·licitant perquè ens faci arribar el document?</span>
					</div>	
					<div class="form-group">
          					<button type="button" onclick = "javaScript: enviaMailEscrituraEmpresa_click();" id="enviaMailEscrituraEmpresa" class="btn-itramits btn-success-itramits">Enviar
							<span id="spinner_EscrituraEmpresa" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
						</button>
						<span id="mensajeEscrituraEmpresa" class ="ocultar info-msg"></span>
       				</div>	
				</div>
			</div>
		</div>
	</div>