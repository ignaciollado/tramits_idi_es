<!----------------------------------------- Proposta resolució denegació amb requeriment. DOC 5. CON VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Resolució de denegació ***PRE***
	</div>
	<div class="card-itramits-footer" aria-label="generar informe">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_motivoDenegacion_5" class="btn btn-primary btn-acto-admin" onclick="enviaResDenegacionConRequerimiento(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la proposta</button>
			<div id='infoMissingDataDoc5' class="alert alert-danger ocultar"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_denegacion_con_req'] != 0) { ?> <!--Si existe el documento PDF muetra el enlace -->
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_denegacion_con_req_idi_isba.pdf');
			if (isset($tieneDocumentosGenerados)) {
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
				$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
						$estado_firma = "<div class='info-msg'>Pendent de signar</div>";
						break;
					case 'REJECTED':
						$estado_firma = "<div class = 'warning-msg'><a href=" . base_url('public/index.php/expedientes/muestrasolicitudrechazada/' . $requestPublicAccessId) . ">Signatura rebutjada";
						$estado_firma .= "</a></div>";
						break;
					case 'COMPLETED':
						$estado_firma = "<a class='btn btn-ver-itramits' href=" . base_url('public/index.php/expedientes/muestrasolicitudfirmada/' . $requestPublicAccessId) . ">Signat";
						$estado_firma .= "</a>";
						break;
					case 'IN_PROCESS':
						$estado_firma = "<div class='info-msg'><a href=" . base_url('public/index.php/expedientes/muestrasolicitudfirmada/' . $requestPublicAccessId) . ">En curs";
						$estado_firma .= "</a></div>";
					default:
						$estado_firma = "<div class='info-msg'>Desconegut</div>";
				}
				echo $estado_firma;
			}	?>

		<?php } ?>
		<?php //} else {
		?> <!-- En caso de no existir el documento PDF muestra el botón para generarlo-->
		<div id="wrapper_generaDenegacion_5" class="">

		</div>
	</div>
</div>

<script>
	function enviaResDenegacionConRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')

		let wrapper_motivoDenegacion_5 = document.getElementById('wrapper_motivoDenegacion_5')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let infoMissingDataDoc5 = document.getElementById('infoMissingDataDoc5')
		infoMissingDataDoc5.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc5.classList.add('ocultar')
			wrapper_motivoDenegacion_5.disabled = true
			wrapper_motivoDenegacion_5.innerHTML = "Generant i enviant..."
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_res_denegacion_idi_isba'
		} else {
			infoMissingDataDoc5.classList.remove('ocultar')
		}
	}
</script>