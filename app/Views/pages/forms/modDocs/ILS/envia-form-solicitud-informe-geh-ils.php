<!----------------------------------------- Enviar formulario solicitud del informe GEI ILS -->
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
<input type='hidden' class='text' id="id_doc_GEH" value="<?php echo $id_doc;?>"></input>
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {
					?>

						<button type="button" <?php if ( $docs_item->estado === "Rebutjat" ) { echo 'class="btn btn-primary position-relative"'; } else {echo 'style="display:none;"';} ?> 
						data-bs-toggle="modal" data-bs-target = "#myEnviarInformeGEH" 
						id="myBtnEnviarInformeGEH" 
						title="Torna a sol·licitar el document">Notifica 
						<span class="badge text-bg-secondary"><?php echo $totalNotifications;?></span>
            </button>
						
		  <?php }?>

  <!-- The Modal para generar el correo de justificación-->
  <div id="myEnviarInformeGEH" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4 class="modal-title">Sol·licitud de l'Informe d'Inventari de GEH segons la norma ISO 14.064-1 de ILS</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant de l'adhesió a ILS perquè ens faci arribar l'Informe d'Inventari de GEH segons la norma ISO 14.064-1?</span>
						</div>	
						<div class="form-group">
           				    <button type="button" onclick = "javaScript: enviaMailInformeGEH_click();" id="enviaMailInformeGEH" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_InformeGEH" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							   </button>
							   <span id="mensajeInformeGEH" class ="ocultar info-msg"></span>
        				</div>	
					</div>
				</div>
			</div>
	</div>


  <script>
  // Get the modal
  let modal_17ils_GEH = document.getElementById("myEnviarInformeGEH");
	// Get the button that opens the modal
	let btn_17ils_GEH = document.getElementById("myBtnEnviarInformeGEH");
	// Get the <span> element that closes the modal
	let span_17ils_GEH = document.getElementsByClassName("close")[0];
	// When the user clicks the button, open the modal 
	btn_17ils_GEH.onclick = function() {
    modal_17ils_GEH.style.display = "block";
	}
	// When the user clicks on <span> (x), close the modal
	span_17ils_GEH.onclick = function() {
    modal_17ils_GEH.style.display = "none";
	}
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
  	if (event.target == modal_17ils_GEH) {
      modal_17ils_GEH.style.display = "none";
  	}
	}
  </script>
				

				
	

<!-- </div> -->
<!------------------------------------------------------------------------------------------------------>