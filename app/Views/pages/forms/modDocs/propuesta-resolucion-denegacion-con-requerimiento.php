<!----------------------------------------- Proposta resolució denegació ajut amb requeriment. DOC 7. SIN VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució de denegació amb requeriment
	</div>
	<div class="card-itramits-footer" aria-label="generar informe">

		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myDenegacion_7" id="myBtnResDenegacionConReq">Motiu de la denegació</button>
			<span id="btn_7" class="">
				<!-- <a id="wrapper_motivoDenegacion_7" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/' . $id . '/' . $convocatoria . '/' . $programa . '/' . $nifcif . '/doc_prop_res_denegacion_con_req'); ?>" class="btn btn-primary-itramits">Envia a la firma <br>de Gerència IDI</a> -->
				<button id="wrapper_motivoDenegacion_7" class='btn btn-primary ocultar' onclick="enviaPropuestaResDenegacionConRequerimiento(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Envia a la firma <br>de Gerència IDI</button>
				<div id='infoMissingDataDoc7' class="alert alert-danger ocultar"></div>
			</span>
			<span id="spinner_7" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_denegacion_con_req'] != 0) { ?> <!--Si existe el documento PDF muetra el enlace -->
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_denegacion_con_req.pdf');
			if (isset($tieneDocumentosGenerados)) {
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
				$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
						$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar<br>per Gerència IDI</div>";
						break;
					case 'REJECTED':
						$estado_firma = "<div class = 'warning-msg'><i class='fa fa-warning'></i><a href=" . base_url('public/index.php/expedientes/muestrasolicitudrechazada/' . $requestPublicAccessId) . ">Signatura rebutjada<br>per Gerència IDI";
						$estado_firma .= "</a></div>";
						break;
					case 'COMPLETED':
						$estado_firma = "<a class='btn btn-ver-itramits' href=" . base_url('public/index.php/expedientes/muestrasolicitudfirmada/' . $requestPublicAccessId) . " ><i class='fa fa-check'></i>Signat per Gerència IDI";
						$estado_firma .= "</a>";
						break;
					case 'IN_PROCESS':
						$estado_firma = "<div class='info-msg'><i class='fa fa-check'></i><a href=" . base_url('public/index.php/expedientes/muestrasolicitudfirmada/' . $requestPublicAccessId) . " >En curs";
						$estado_firma .= "</a></div>";
					default:
						$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
				}
				echo $estado_firma;
			}	?>

		<?php } ?>
		<?php //} else {
		?> <!-- En caso de no existir el documento PDF muestra el botón para generarlo-->
		<div id="wrapper_generaDenegacion_7" class="">

		</div>
		<!-- The Modal -->
		<div class="modal" id="myDenegacion_7">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content" style="width: 80%;">
					<div class="modal-header">
						<label for="motivoResDenegacionConReq"><strong>Escriu el motiu de la denegació:</strong></label>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<textarea rows="10" cols="30" class="form-control" id="motivoDenegacion_7" placeholder="Motiu de la denegació"><?php echo $expedientes['motivoDenegacion']; ?></textarea>
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
	function enviaPropuestaResDenegacionConRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf')

		let wrapper_motivoDenegacion_7 = document.getElementById('wrapper_motivoDenegacion_7')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_7 = document.getElementById('spinner_7')
		let infoMissingDataDoc7 = document.getElementById('infoMissingDataDoc7')
		infoMissingDataDoc7.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc7.innerHTML = infoMissingDataDoc7.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc7.innerHTML = infoMissingDataDoc7.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc7.innerHTML = infoMissingDataDoc7.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc7.innerHTML = infoMissingDataDoc7.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc7.innerHTML = infoMissingDataDoc7.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc7.classList.add('ocultar')
			wrapper_motivoDenegacion_7.disabled = true
			wrapper_motivoDenegacion_7.innerHTML = "Generant ..."
			spinner_7.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_denegacion_con_req'
		} else {
			infoMissingDataDoc7.classList.remove('ocultar')
		}
	}
</script>