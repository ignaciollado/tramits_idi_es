<!----------------------------------------- Enviar formulario solicitud de datos adicionales de la emrpesa ILS -->

	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
        else {?>
			  <button type = "button" class = "btn-primary-itramits" 
			  	data-bs-toggle="modal" data-bs-target = "#myEnviarFormularioEmpresa" 
				id="myBtnEnviarFormEmpresa">Sol·licitar dades adicionals per a la web de ILS</button>       
		  <?php }?>


  <div id="myEnviarFormularioEmpresa" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4><strong>Sol·licitar dades adicionals d'empresa per a la web de ILS</strong></h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
