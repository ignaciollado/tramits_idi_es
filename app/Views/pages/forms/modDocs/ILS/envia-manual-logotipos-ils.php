<!----------------------------------------- Enviar correo electrónico con manual y logotipos de ILS -->
<!-- <div class="card-itramits"> -->

	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
			  <button type = "button" class = "btn-primary-itramits" 
			  data-bs-toggle="modal" data-bs-target = "#myEnviarManualYLogotipo" id="myBtnEnviarManualYLogotipo">Enviar al sol·licitant el manual d'ús i els logotips ILS</button>       
		  <?php }?>


  <!-- The Modal para generar el correo de justificación-->
  <div id="myEnviarManualYLogotipo" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4 class="modal-title">Enviar el manual i els logotips de ILS</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant amb el manual i els logotips de ILS?</span>
						</div>	
						<div class="form-group">
           				    <button type="button" onclick = "javaScript: enviaMailManualYLogotipo_click();" id="enviaMailManualYLogotipo" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_ManualYLogotipo" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							   </button>
							   <span id="mensajeManualYLogotipo" class ="ocultar info-msg"></span>
        				</div>	
					</div>
				</div>
			</div>
	</div>


  <script>
  // Get the modal
  let modal_17ils_Logos = document.getElementById("myEnviarManualYLogotipo");
	// Get the button that opens the modal
	let btn_17ils_Logos = document.getElementById("myBtnEnviarManualYLogotipo");
	// Get the <span> element that closes the modal
	let span_17ils_Logos = document.getElementsByClassName("close")[0];
	// When the user clicks the button, open the modal 
	btn_17ils_Logos.onclick = function() {
    modal_17ils_Logos.style.display = "block";
	}
	// When the user clicks on <span> (x), close the modal
	span_17ils_Logos.onclick = function() {
    modal_17ils_Logos.style.display = "none";
	}
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
  	if (event.target == modal_17ils_Logos) {
      modal_17ils_Logos.style.display = "none";
  	}
	}
  </script>
				

				
	

<!-- </div> -->
<!------------------------------------------------------------------------------------------------------>