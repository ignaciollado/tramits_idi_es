<!----------------------------------------- Enviar formulario solicitud de certificado AEAT -->
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
<input type='hidden' class='text' id="id_doc_CERAEAT" value="<?php echo $id_doc;?>"></input>
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
				<button type="button" <?php if ( $docs_item->estado === "Rebutjat" ) { echo 'class="btn btn-primary position-relative"'; } else {echo 'style="display:none;"';} ?> 
				data-bs-toggle="modal" data-bs-target = "#myEnviarFormularioCertAEAT"
				data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myBtnEnviarFormularioCertAEAT" aria-hidden="true"
				
				id="myBtnEnviarFormularioCertAEAT"
				title="Torna a sol·licitar el document">
				Notifica <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-secondary"><?php echo $totalNotifications;?></span>
                                                </button>    
		  <?php }?>


  <!-- The Modal para generar el correo -->
  <div id="myEnviarFormularioCertAEAT" class="modal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<label for="cerrarModalActaCierre"><strong>Sol·licitud de la documentació adreditativa de representació</strong></label>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant perquè ens faci arribar la documentació?</span>
						</div>	
						<div class="form-group">
           			<button type="button" onclick = "javaScript: enviaMailCertAEAT_click();" id="enviaMailCertAEAT" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_CertAEAT" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							  </button>
							   <span id="mensajeCertAEAT" class ="ocultar info-msg"></span>
        		</div>	
					</div>
				</div>
			</div>
	</div>

  <script>
  // Get the modal
  let modal_17_CertAEAT = document.getElementById("myEnviarFormularioCertAEAT");
	// Get the button that opens the modal
	let btn_17_CertAEAT = document.getElementById("myBtnEnviarFormularioCertAEAT");
	// Get the <span> element that closes the modal
	let span_17_CertAEAT = document.getElementsByClassName("close")[0];
	// When the user clicks the button, open the modal 
	btn_17_CertAEAT.onclick = function() {
    modal_17_CertAEAT.style.display = "block";
	}
	// When the user clicks on <span> (x), close the modal
/* 	span_17_CertAEAT.onclick = function() {
    modal_17_CertAEAT.style.display = "none";
	} */
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
  	if (event.target == modal_17_CertAEAT) {
      modal_17_CertAEAT.style.display = "none";
  	}
	}
  </script>
				

				
	

<!-- </div> -->
<!------------------------------------------------------------------------------------------------------>