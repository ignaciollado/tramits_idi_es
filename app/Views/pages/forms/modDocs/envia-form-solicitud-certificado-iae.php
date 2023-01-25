<!----------------------------------------- Enviar formulario solicitud de certificado IAE ILS -->
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
<input type='hidden' class='text' id="id_doc_IAE" value="<?php echo $id_doc;?>"></input>
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
				<button type="button" <?php if ( $docs_item->estado === "Rebutjat" ) { echo 'class="btn btn-primary position-relative"'; } else {echo 'style="display:none;"';} ?> 
				data-toggle = "modal" data-target = "#myEnviarFormularioCertificadoIAE" 
				id="myBtnEnviarFormularioCertificadoIAE"
				title="Torna a sol·licitar el document">
				Notifica <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-secondary"><?php echo $totalNotifications;?></span>
                                                </button>    
		  <?php }?>


  <!-- The Modal para generar el correo -->
  <div id="myEnviarFormularioCertificadoIAE" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<label for="cerrarModalActaCierre"><strong>Sol·licitud del certificat IAE ILS</strong></label>
        				<button id="cerrarModalActaCierre" type="button" class="close" data-dismiss="modal">&times;</button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant de l'adhesió a ILS perquè ens faci arribar el certificat IAE?</span>
						</div>	
						<div class="form-group">
           			<button type="button" onclick = "javaScript: enviaMailCertificadoIAE_click();" id="enviaMailCertificadoIAE" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_CertificadoIAE" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							  </button>
							   <span id="mensajeCertificadoIAE" class ="ocultar info-msg"></span>
        		</div>	
					</div>
				</div>
			</div>
	</div>

  <script>
  // Get the modal
  let modal_17ils_CertificadoIAE = document.getElementById("myEnviarFormularioCertificadoIAE");
	// Get the button that opens the modal
	let btn_17ils_CertificadoIAE = document.getElementById("myBtnEnviarFormularioCertificadoIAE");
	// Get the <span> element that closes the modal
	let span_17ils_CertificadoIAE = document.getElementsByClassName("close")[0];
	// When the user clicks the button, open the modal 
	btn_17ils_CertificadoIAE.onclick = function() {
    modal_17ils_CertificadoIAE.style.display = "block";
	}
	// When the user clicks on <span> (x), close the modal
	span_17ils_CertificadoIAE.onclick = function() {
    modal_17ils_CertificadoIAE.style.display = "none";
	}
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
  	if (event.target == modal_17ils_CertificadoIAE) {
      modal_17ils_CertificadoIAE.style.display = "none";
  	}
	}
  </script>
				

				
	

<!-- </div> -->
<!------------------------------------------------------------------------------------------------------>