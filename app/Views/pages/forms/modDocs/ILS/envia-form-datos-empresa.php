<!----------------------------------------- Enviar formulario solicitud de datos adicionales de la emrpesa ILS -->
<!-- <div class="card-itramits"> -->

	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
			  <button type = "button" class = "btn-primary-itramits" 
				data-toggle = "modal" data-target = "#myEnviarFormularioEmpresa" 
				id="myBtnEnviarFormEmpresa">Enviar al sol·licitant el formulari de sol·licitud de dades per a la web de ILS</button>       
		  <?php }?>


  <!-- The Modal para generar el correo de justificación-->
  <div id="myEnviarFormularioEmpresa" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<label for="cerrarModalActaCierre"><strong>Sol·licitar dades adicionals d'empresa per a la web de ILS</strong></label>
        				<button id="cerrarModalActaCierre" type="button" class="close" data-dismiss="modal">&times;</button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
							<span>Vols enviar un correu electrònic al sol·licitant de l'adhesió a ILS perquè pugui afegir dades de l'empresa?</span>
						</div>	
						<div class="form-group">
           				    <button type="button" onclick = "javaScript: enviaMailFormEmpresa_click();" id="enviaMailFormEmpresa" class="btn-itramits btn-success-itramits">Enviar
							   <span id="spinner_17ils1" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							   </button>
							   <span id="mensaje" class ="ocultar info-msg"></span>
        				</div>	
					</div>
				</div>
			</div>
	</div>


  <script>
  	// Get the modal
  	let modal_17ils_1 = document.getElementById("myEnviarFormularioEmpresa");
		// Get the button that opens the modal
		let btn_17ils_1 = document.getElementById("myBtnEnviarFormEmpresa");
		// Get the <span> element that closes the modal
		let span_17ils_1 = document.getElementsByClassName("close")[0];
		// When the user clicks the button, open the modal 
		btn_17ils_1.onclick = function() {
	    modal_17ils_1.style.display = "block";
		}
		// When the user clicks on <span> (x), close the modal
		span_17ils_1.onclick = function() {
    	modal_17ils_1.style.display = "none";
		}
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
	  	if (event.target == modal_17ils_1) {
      	modal_17ils_1.style.display = "none";
  		}
		}
  </script>
				

				
	

<!-- </div> -->
<!------------------------------------------------------------------------------------------------------>