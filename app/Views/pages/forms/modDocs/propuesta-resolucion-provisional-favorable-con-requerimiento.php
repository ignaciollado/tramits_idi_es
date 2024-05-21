<!----------------------------------------- Proposta resolució provisional favorable amb requeriment DOC 8------------------------------------------------>
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució provisional favorable<br>amb requeriment
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="btnPropResProvfavConReq" class='btn btn-primary btn-acto-admin' onclick="enviaPropResolucionProvisionalFavorableConReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Genera la proposta</button>
			<div id='infoMissingDataDoc8' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_provisional_favorable_con_req.pdf');
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
	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>
	function enviaPropResolucionProvisionalFavorableConReg(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		/* let fecha_firma_res = document.getElementById('fecha_firma_res') */
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf') //0000-00-00
		let btnPropResProvfavConReq = document.getElementById('btnPropResProvfavConReq')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let infoMissingDataDoc8 = document.getElementById('infoMissingDataDoc8')
		infoMissingDataDoc8.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
/* 		if (!fecha_firma_res.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data firma resolució<br>"
			todoBien = false
		} */
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc8.classList.add('ocultar')
			btnPropResProvfavConReq.disabled = true
			btnPropResProvfavConReq.innerHTML = "Generant i enviant ..."
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_provisional_favorable_con_req'
		} else {
			infoMissingDataDoc8.classList.remove('ocultar')
		}
	}
</script>