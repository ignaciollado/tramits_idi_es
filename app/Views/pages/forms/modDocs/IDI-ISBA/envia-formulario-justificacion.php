<!----------------------------------------- Acta de cierre DOC 20-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Formulari de justificació
  	</div>
  	<div class="card-itramits-footer">
			<button type="button" id="enviar-a-justificar" class="btn btn-dark btn-acto-admin" data-bs-toggle="modal" data-bs-target="#enviarFormJustificacionISBA" id="myBtnEnviarJustificador">Envia el formulari de justificació</button>
    </div>
  	<div class="card-itramits-footer">
			<?php if ($expedientes['doc_acta_de_cierre'] !=0) { ?>
			<?php 
    		//Compruebo el estado de la firma del documento.
		 		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_acta_de_cierre.pdf');
	   		if (isset($tieneDocumentosGenerados))
	   		{
    			$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
	   			$requestPublicAccessId = $PublicAccessId;
	   			$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
	   			$respuesta = json_decode ($request, true);
      		$estado_firma = $respuesta['status'];
					switch ($estado_firma) {
						case 'NOT_STARTED':
						$estado_firma = "<div class='btn btn-info btn-acto-admin'><i class='fa fa-info-circle'></i>Pendent de signar</div>";
						break;
						case 'REJECTED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'btn btn-warning btn-acto-admin'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
						$estado_firma .= "</a>";
						break;
						case 'COMPLETED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-success btn-acto-admin'><i class='fa fa-check'></i>Signat</div>";		
						$estado_firma .= "</a>";
						break;
						case 'IN_PROCESS':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-secondary btn-acto-admin'><i class='fa fa-check'></i>En curs</div>";		
						$estado_firma .= "</a>";
						default:
						$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i>Desconegut</div>";
						}
					echo $estado_firma;
				}
			?>

		<?php }?>
		<div id="wrapper_generaActaDeCierre" class="">
		
    </div>
 		<!-- The Modal para generar el correo de justificación-->
 		<div class="modal" id="enviarFormJustificacionISBA">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h3 class="modal-title">Enviar correu electrònic al interessat</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  				</div>
    				<div class="modal-body">
						  <div class="form-group">
  							<span>Vols enviar el formulari de justificació al interessat?</span>
						  </div><br>
						  <div class="form-group">
           		  <button type="button" onclick = "javaScript: enviaMailJustificacionISBA_click();" id="enviaMailJustificacion" class="btn-itramits btn-success-itramits">Enviar
							    <span id="spinner_151" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:24px; color:#1AB394;"></i></span>
							  </button>
							  <span id="mensaje" class ="ocultar info-msg" style="font-size:.5rem;"></span>
        			</div>	
					</div>
				</div>
			</div>
		</div>
  </div>
</div>
<script>
	function actaDeCierre(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_reunion_cierre = document.getElementById('fecha_reunion_cierre')
		let fecha_limite_justificacion = document.getElementById('fecha_limite_justificacion')
		let myBtnActaDeCierre = document.getElementById('myBtnActaDeCierre')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let infoMissingDataDoc20 = document.getElementById('infoMissingDataDoc20')
		const myActaDeCierre = new bootstrap.Modal(document.getElementById('myActaDeCierre'), {  keyboard: false });

		infoMissingDataDoc20.innerText = ""

		if (!fecha_reunion_cierre.value) {
			infoMissingDataDoc20.innerHTML = infoMissingDataDoc20.innerHTML + "Data reunió tancament<br>"
			todoBien = false
		}
		if (!fecha_limite_justificacion.value) {
			infoMissingDataDoc20.innerHTML = infoMissingDataDoc20.innerHTML + "Data límit per justificar l'ajut rebut<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc20.classList.add('ocultar')
			myActaDeCierre.show()
		} else {
			infoMissingDataDoc20.classList.remove('ocultar')
		}
	}

	function enviaActaDeCierre() {
		let myBtnActaDeCierre = document.getElementById('myBtnActaDeCierre')
		myBtnActaDeCierre.disabled = true
		myBtnActaDeCierre.innerHTML = "Enviant ..."
	}
</script>