<!----------------------------------------- Proposta de resolució definitiva. DOC 4. CON VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució definitiva ***PRE***
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_propuestaResDefinitiva" class="btn btn-primary btn-acto-admin" onclick="enviaPropResolucionResDefinitiva(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la proposta</button>
			<div id='infoMissingDataDoc4' class="alert alert-danger ocultar"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_definitiva_con_req'] != 0) { ?>

			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_prop_res_definitiva_con_req_idi_isba.pdf');
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
	function enviaPropResolucionResDefinitiva(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav = document.getElementById('fecha_infor_fav') //0000-00-00
		let fecha_infor_desf = document.getElementById('fecha_infor_desf') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let wrapper_propuestaResDefinitiva = document.getElementById('wrapper_propuestaResDefinitiva')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let infoMissingDataDoc4 = document.getElementById('infoMissingDataDoc4')
		infoMissingDataDoc4.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data firma informe favorable<br>"
			todoBien = false
		}
		if (!fecha_infor_desf.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data firma informe desfavorable<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc4.classList.add('ocultar')
			wrapper_propuestaResDefinitiva.disabled = true
			wrapper_propuestaResDefinitiva.innerHTML = "Generant i enviant ..."

			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_definitiva_con_req_idi_isba'
		} else {
			infoMissingDataDoc4.classList.remove('ocultar')
		}
	}
</script>