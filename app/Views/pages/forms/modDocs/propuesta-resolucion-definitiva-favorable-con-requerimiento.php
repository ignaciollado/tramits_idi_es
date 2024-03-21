<!----------------------------------------- Proposta de resolució definitiva favorable amb requeriment. DOC 12. SIN VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
	Proposta de resolució definitiva favorable<br> amb requeriment
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="btnPropResDefFavConReq" class='btn btn-primary btn-acto-admin' onclick="enviaPropResolucionDefFavConReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Genera la proposta</button>
			<div id='infoMissingDataDoc12' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php } ?>
	</div>
	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_prop_res_def_favorable_con_req.pdf');

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
<!-------------------------------------------------------------------------------------------------------------------->

<script>
	function enviaPropResolucionDefFavConReg(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let btnPropResDefFavConReq = document.getElementById('btnPropResDefFavConReq')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let infoMissingDataDoc11 = document.getElementById('infoMissingDataDoc11')
		infoMissingDataDoc11.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc11.classList.add('ocultar')
			btnPropResDefFavConReq.disabled = true
			btnPropResDefFavConReq.innerHTML = "Generant i enviant ..."
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_def_favorable_con_req'
		} else {
			infoMissingDataDoc11.classList.remove('ocultar')
		}
	}
</script>