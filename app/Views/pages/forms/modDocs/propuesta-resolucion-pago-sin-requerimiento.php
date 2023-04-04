<!----------------------------------------- Proposta de resolució i resolució de pagament sense requeriment. DOC 9 SIN VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució i resolució de pagament sense requeriment
	</div>
	<div class="card-itramits-footer">

		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<!-- 	<a class="btn-primary-itramits" href="<?php echo base_url('public/index.php/expedientes/generaInforme/' . $id . '/' . $convocatoria . '/' . $programa . '/' . $nifcif . '/doc_prop_res_conces_sin_req'); ?>">Genera la proposta</a> -->
			<button id="wrapper_propuestaResPagoSinReg" class='btn btn-secondary' onclick="enviaPropResolucionPagoSinReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Genera la proposta</button>
			<div id='infoMissingDataDoc9' class="alert alert-danger ocultar"></div>
			<span id="spinner_9" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_conces_sin_req'] != 0) { ?>
			<!-- 		<a class="btn btn-ver-itramits" href="<?php echo base_url('public/index.php/expedientes/muestrainforme/' . $id . '/' . $convocatoria . '/' . $programa . '/' . $nifcif . '/doc_prop_res_conces_sin_req'); ?>" target = "_self"><i class='fa fa-check'></i>La proposta de resolució</a>
 -->
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria']);

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
<!------------------------------------------------------------------------------------------------------>

<script>
	function enviaPropResolucionPagoSinReg(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf') //0000-00-00
		/* let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda') */
		let wrapper_propuestaResPagoSinReg = document.getElementById('wrapper_propuestaResPagoSinReg')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_9 = document.getElementById('spinner_9')
		let infoMissingDataDoc9 = document.getElementById('infoMissingDataDoc9')
		infoMissingDataDoc9.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}
		/* 		if(!fecha_REC_enmienda.value) {
					infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Data REC esmena<br>"
					todoBien = false
				}
				if(!ref_REC_enmienda.value) {
					infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Referència REC esmena<br>"
					todoBien = false
				}  */

		if (todoBien) {
			infoMissingDataDoc9.classList.add('ocultar')
			wrapper_propuestaResPagoSinReg.disabled = true
			wrapper_propuestaResPagoSinReg.innerHTML = "Generant ..."
			spinner_9.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_conces_sin_req'
		} else {
			infoMissingDataDoc9.classList.remove('ocultar')
		}
	}
</script>