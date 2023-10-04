<!----------------------------------------- Proposta de resolució provisional. DOC 3. CON VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució provisional
	</div>
	<div class="card-itramits-footer">
	pre-tramits
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_propuestaResProvisional" onclick="enviaPropResolucionResProvisional(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')"><i title="Generar la proposta" class="fa-solid fa-file-pdf fa-2xl" style="color: #00145c;"></i></button>
			<div id='infoMissingDataDoc3' class="alert alert-danger ocultar"></div>
			<span id="spinner_3" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_provisional_con_req'] != 0) { ?>

			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_prop_res_provisional_con_req_idi_isba.pdf');
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
	function enviaPropResolucionResProvisional(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav = document.getElementById('fecha_infor_fav') //0000-00-00
		let fecha_infor_desf = document.getElementById('fecha_infor_desf') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let wrapper_propuestaResProvisional = document.getElementById('wrapper_propuestaResProvisional')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let spinner_3 = document.getElementById('spinner_3')
		let infoMissingDataDoc3 = document.getElementById('infoMissingDataDoc3')
		infoMissingDataDoc3.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data firma informe favorable<br>"
			todoBien = false
		}
		if (!fecha_infor_desf.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data firma informe desfavorable<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc3.classList.add('ocultar')
			wrapper_propuestaResProvisional.disabled = true
			wrapper_propuestaResProvisional.innerHTML = "Generant la proposta ..."
			spinner_3.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_provisional_con_req_idi_isba'
		} else {
			infoMissingDataDoc3.classList.remove('ocultar')
		}
	}
</script>