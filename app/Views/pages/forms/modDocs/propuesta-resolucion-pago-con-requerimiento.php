<!----------------------------------------- Proposta de resolució i resolució de pagament amb requeriment. DOC 10. SIN VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució i resolució de pagament amb requeriment
	</div>
	<div class="card-itramits-footer">
	pre-tramits
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<!-- <a href="<?php echo base_url('public/index.php/expedientes/generaInforme/' . $id . '/' . $convocatoria . '/' . $programa . '/' . $nifcif . '/doc_prop_res_conces_con_req'); ?>" class="btn-primary-itramits">Genera la proposta</a> -->
			<button id="wrapper_propuestaResPagoConReg" class='btn btn-primary' onclick="enviaPropResolucionPagoConReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Genera la proposta</button>
			<div id='infoMissingDataDoc10' class="alert alert-danger ocultar"></div>
			<span id="spinner_10" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_conces_con_req'] != 0) { ?>
			<!-- 		<a class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/' . $id . '/' . $convocatoria . '/' . $programa . '/' . $nifcif . '/doc_prop_res_conces_con_req'); ?>" target = "_self"><i class='fa fa-check'></i>La proposta de resolució</a>	 	
		 -->
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_prop_res_conces_con_req.pdf');

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
	function enviaPropResolucionPagoConReg(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let wrapper_propuestaResPagoConReg = document.getElementById('wrapper_propuestaResPagoConReg')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_10 = document.getElementById('spinner_10')
		let infoMissingDataDoc10 = document.getElementById('infoMissingDataDoc10')
		infoMissingDataDoc10.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc10.classList.add('ocultar')
			wrapper_propuestaResPagoConReg.disabled = true
			wrapper_propuestaResPagoConReg.innerHTML = "Generant ..."
			spinner_10.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_conces_con_req'
		} else {
			infoMissingDataDoc10.classList.remove('ocultar')
		}
	}
</script>