<!----------------------------------------- Proposta resolució provisional desfavorable amb requeriment. DOC 10 -->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució provisional desfavorable<br> amb requeriment
	</div>
	<div class="card-itramits-footer" aria-label="generar informe">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button type="button" class="btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#modalMotivoDenegacion10" id="myBtnResProvDenegacionConReq">Motiu de la denegació</button>
			<span id="btn_10" class="">
				<button id="btnPropResProvDesfavConReq" class='btn btn-primary ocultar btn-acto-admin' onclick="enviaPropuestaResProvDesfConReq(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Envia a signar</button>
				<div id='infoMissingDataDoc10' class="alert alert-danger ocultar"></div>
			</span>
		<?php } ?>
	</div>
	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_prov_desf_con_req.pdf');
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
					$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i>Desconegut</div>";
					}
				echo $estado_firma;
			}	?>
		<?php //} else {
		?> <!-- En caso de no existir el documento PDF muestra el botón para generarlo-->
		<div id="wrapper_generaDenegacion_10" class="">

		</div>
		<!-- The Modal -->
		<div class="modal" id="modalMotivoDenegacion10">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content" style="width: 80%;">
					<div class="modal-header">
						<label for="motivoResDenegacionConReq"><strong>Escriu el motiu de la denegació:</strong></label>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<textarea rows="10" cols="30" class="form-control" id="motivoDenegacion_10" placeholder="Motiu de la denegació"><?php echo $expedientes['motivoDenegacion']; ?></textarea>
						</div>
						<div class="form-group">
							<button type="button" onclick="javaScript: actualizaMotivoDenegacion_click();" id="guardaMotivoDenegacion" class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function enviaPropuestaResProvDesfConReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf')

		let btnPropResProvDesfavConReq = document.getElementById('btnPropResProvDesfavConReq')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let infoMissingDataDoc10 = document.getElementById('infoMissingDataDoc10')
		infoMissingDataDoc10.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc10.classList.add('ocultar')
			btnPropResProvDesfavConReq.disabled = true
			btnPropResProvDesfavConReq.innerHTML = "Generant i enviant ..."
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_prov_desf_con_req'
		} else {
			infoMissingDataDoc10.classList.remove('ocultar')
		}
	}
</script>