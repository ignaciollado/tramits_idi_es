<!---------------------------- Proposta resolució denegació ajut sin requeriment. DOC 8. FIRMA GERENTE ------------------------>
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució de denegació sense requeriment
	</div>
	<div class="card-itramits-footer" aria-label="generar informe">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button type="button" class="btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#myDenegacion_8" id="myBtnResDenegacionSinReq">Motiu de la denegació</button>
			<span id="btn_8" class="">
				<button id="wrapper_motivoDenegacion_8" class='btn btn-primary ocultar btn-acto-admin' onclick="enviaPropuestaResDenegacionSinRequerimiento(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Envia a signar</button>
				<div id='infoMissingDataDoc8' class="alert alert-danger ocultar"></div>
			</span>
			<span id="spinner_8" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">

		<?php
		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_prop_res_denegacion_sin_req.pdf');
		if (isset($tieneDocumentosGenerados)) {
			$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
			$requestPublicAccessId = $PublicAccessId;
			$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
			$respuesta = json_decode($request, true);
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
				$estado_firma = "<div class='btn btn-light btn-acto-admin'><i class='fa fa-info-circle'></i>Desconegut</div>";
				}
			echo $estado_firma;
		}	?>

		<!-- The Modal -->
		<div class="modal" id="myDenegacion_8">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content" style="width: 80%;">
					<div class="modal-header">
						<label for="motivoResDenegacionConReq"><strong>Escriu el motiu de la denegació:</strong></label>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<textarea rows="10" cols="30" class="form-control" id="motivoDenegacion_8" placeholder="Motiu de la denegació"><?php echo $expedientes['motivoDenegacion']; ?></textarea>
						</div>
						<div class="form-group">
							<button type="button" onclick="javaScript: actualizaMotivoDenegacionSinReq_click();" id="guardaMotivoDenegacion" class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function enviaPropuestaResDenegacionSinRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let wrapper_motivoDenegacion_8 = document.getElementById('wrapper_motivoDenegacion_8')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_8 = document.getElementById('spinner_8')
		let infoMissingDataDoc8 = document.getElementById('infoMissingDataDoc8')
		infoMissingDataDoc8.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc8.classList.add('ocultar')
			wrapper_motivoDenegacion_8.disabled = true
			wrapper_motivoDenegacion_8.innerHTML = "Enviant ..."
			spinner_8.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_denegacion_sin_req'
		} else {
			infoMissingDataDoc8.classList.remove('ocultar')
		}
	}
</script>