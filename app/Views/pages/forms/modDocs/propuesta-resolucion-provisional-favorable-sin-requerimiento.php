<!----------------------------------------- Proposta de resolució i resolució de pagament sense requeriment. DOC 9 SIN VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució PROVISIONAL FAVORABLE<br>sense requeriment
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_propuestaResPagoSinReg" class='btn btn-primary btn-acto-admin' onclick="enviaPropResolucionProvisionalFavorableSinReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Genera la proposta</button>
			<div id='infoMissingDataDoc9' class="alert alert-danger ocultar btn-acto-admin"></div>
			<span id="spinner_9" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_provisional_favorable_sin_req'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_provisional_favorable_sin_req.pdf');
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

		<?php } ?>
	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>
	function enviaPropResolucionProvisionalFavorableSinReg(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf') //0000-00-00
		let wrapper_propuestaResPagoSinReg = document.getElementById('wrapper_propuestaResPagoSinReg')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_9 = document.getElementById('spinner_9')
		let infoMissingDataDoc9 = document.getElementById('infoMissingDataDoc9')
		infoMissingDataDoc9.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc9.innerHTML = infoMissingDataDoc9.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc9.classList.add('ocultar')
			wrapper_propuestaResPagoSinReg.disabled = true
			wrapper_propuestaResPagoSinReg.innerHTML = "Enviant ..."
			spinner_9.classList.remove('ocultar')
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_provisional_favorable_sin_req'
		} else {
			infoMissingDataDoc9.classList.remove('ocultar')
		}
	}
</script>