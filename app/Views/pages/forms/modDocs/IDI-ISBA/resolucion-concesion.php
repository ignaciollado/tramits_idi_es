<!----------------------------------------- Resolución de concesión amb requeriment. DOC 7. CON VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Resolució de concessió ***PRE***
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_ResConcesionConReg" class="btn btn-primary btn-acto-admin" onclick="enviaResolucionConcesionConReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la resolució</button>
			<div id='infoMissingDataDoc6' class="alert alert-danger ocultar"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_conces_con_req'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_res_conces_con_req_idi_isba.pdf');

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
	</div>
</div>
<!-------------------------------------------------------------------------------------------------------------------->

<script>
	function enviaResolucionConcesionConReg(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let wrapper_ResConcesionConReg = document.getElementById('wrapper_ResConcesionConReg')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let infoMissingDataDoc6 = document.getElementById('infoMissingDataDoc6')
		infoMissingDataDoc6.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc6.classList.add('ocultar')
			wrapper_ResConcesionConReg.disabled = true
			wrapper_ResConcesionConReg.innerHTML = "Generant i enviant..."
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_res_conces_con_req_idi_isba'
		} else {
			infoMissingDataDoc6.classList.remove('ocultar')
		}
	}
</script>