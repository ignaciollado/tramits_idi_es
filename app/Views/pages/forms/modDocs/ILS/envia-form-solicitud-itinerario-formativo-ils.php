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
			data-toggle = "modal" data-target = "#myEnviarFormularioItinerarioFormativo" 
			id="myBtnEnviarFormularioItinerarioFormativo" 
			title="Torna a sol·licitar el document">
      	Notifica <span class="badge text-bg-secondary"><?php echo $totalNotifications;?></span>
    </button>

<?php  }?>

  <!-- The Modal para generar el correo de justificación -->
  <div id="myEnviarFormularioItinerarioFormativo" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<label for="cerrarModalActaCierre"><strong>Sol·licitud del certificat itinerari formatiu ILS</strong></label>
        				<button id="cerrarModalActaCierre" type="button" class="close" data-dismiss="modal">&times;</button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant de l'adhesió a ILS perquè ens faci arribar el certificat itinerari formatiu?</span>
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


  <script>
  // Get the modal
  let modal_17ils_Itinerario = document.getElementById("myEnviarFormularioItinerarioFormativo");
	// Get the button that opens the modal
	let btn_17ils_Itinerario = document.getElementById("myBtnEnviarFormularioItinerarioFormativo");
	// Get the <span> element that closes the modal
	let span_17ils_Itinerario = document.getElementsByClassName("close")[0];
	// When the user clicks the button, open the modal 
	btn_17ils_Itinerario.onclick = function() {
    modal_17ils_Itinerario.style.display = "block";
	}
	// When the user clicks on <span> (x), close the modal
	span_17ils_Itinerario.onclick = function() {
    modal_17ils_Itinerario.style.display = "none";
	}
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
  	if (event.target == modal_17ils_Itinerario) {
      modal_17ils_Itinerario.style.display = "none";
  	}
	}
  </script>

<!------------------------------------------------------------------------------------------------------>