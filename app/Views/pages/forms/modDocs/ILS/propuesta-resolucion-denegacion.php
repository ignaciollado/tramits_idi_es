<!----------------------------------------- Proposta resolució denegació amb requeriment. DOC 5. CON VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Resolució de denegació
	</div>
	<div class="card-itramits-footer" aria-label="generar informe">
	pre-tramits
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<span id="btn_5" class="">
				<button id="wrapper_motivoDenegacion_5" onclick="enviaResDenegacionConRequerimiento(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')"><i title="Enviar a firma de Gerència" class="fa-solid fa-signature fa-2xl" style="color: #00145c;"></i></button>
				<div id='infoMissingDataDoc5' class="alert alert-danger ocultar"></div>
			</span>
			<span id="spinner_5" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_denegacion_con_req'] != 0) { ?> <!--Si existe el documento PDF muetra el enlace -->
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_denegacion_con_req_idi_isba.pdf');
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
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf')

		let wrapper_motivoDenegacion_5 = document.getElementById('wrapper_motivoDenegacion_5')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let spinner_5 = document.getElementById('spinner_5')
		let infoMissingDataDoc5 = document.getElementById('infoMissingDataDoc5')
		infoMissingDataDoc5.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc5.classList.add('ocultar')
			wrapper_motivoDenegacion_5.disabled = true
			wrapper_motivoDenegacion_5.innerHTML = "Generant la resolució..."
			spinner_5.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_res_denegacion_con_req_idi_isba'
		} else {
			infoMissingDataDoc7.classList.remove('ocultar')
		}
	}
</script>