<!----------------------------------------- Enviar correo electrónico con manual y logotipos de ILS -->
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
			<button type = "button" class = "btn-primary-itramits" 
				data-bs-toggle="modal" data-bs-target = "#myEnviarManualYLogotipo" 
				id="myBtnEnviarManualYLogotipo">Enviar el manual d'ús i els logotips ILS
			</button>       
		  <?php }?>


  	<div id="myEnviarManualYLogotipo" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4><strong>Enviar el manual i els logotips de ILS</strong></h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
    				<div class="modal-body">
						<div class="form-group">
						<span>Vols enviar un correu electrònic al sol·licitant perquè ens faci arribar el document?</span>
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