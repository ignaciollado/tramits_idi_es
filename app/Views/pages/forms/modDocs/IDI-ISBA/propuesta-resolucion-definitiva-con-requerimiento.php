<!----------------------------------------- Proposta de resolució definitiva amb requeriment DOC 8 -->
<div class="card-itramits">
	<div class="card-itramits-body">
		Proposta de resolució definitiva amb requeriment **testear** [PRE]
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_propuestaResDefinitivaConReq" class="btn btn-primary btn-acto-admin" onclick="enviaPropResolucionResDefinitivaConReq(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la proposta</button>
			<div id='infoMissingDataDoc8' class="alert alert-danger ocultar"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_definitiva_con_requerimiento_adr_isba'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_prop_res_definitiva_con_requerimiento_adr_isba.pdf');
			if (isset($tieneDocumentosGenerados)) {
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
				$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
						$estado_firma = "<div class='btn btn-info btn-acto-admin'><i class='fa fa-info-circle'></i> Pendent de signar</div>";				
						break;
						case 'REJECTED':
							$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'btn btn-warning btn-acto-admin'><i class='fa fa-warning'></i> Signatura rebutjada</div>";
							$estado_firma .= "</a>";
							$estado_firma .= gmdate("d-m-Y", intval ($respuesta['rejectInfo']['rejectDate']/1000));			
							break;
							case 'COMPLETED':
							$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-success btn-acto-admin'><i class='fa fa-check'></i> Signat</div>";		
							$estado_firma .= "</a>";
							$estado_firma .= gmdate("d-m-Y", intval ($respuesta['endDate']/1000));					
							break;
						case 'IN_PROCESS':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-secondary btn-acto-admin'><i class='fa fa-check'></i> En curs</div>";		
						$estado_firma .= "</a>";						
						default:
						$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i> Desconegut</div>";
				}
				echo $estado_firma;
			}	?>

		<?php } ?>
	</div>
</div>
<!-------------------------------------------------------------------------------------------------------------------->

<script>
	function enviaPropResolucionResDefinitivaConReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let fecha_firma_propuesta_resolucion_prov = document.getElementById('fecha_firma_propuesta_resolucion_prov')
		let fecha_not_propuesta_resolucion_prov = document.getElementById('fecha_not_propuesta_resolucion_prov')
		let fecha_maxima_enmienda = document.getElementById('fecha_maxima_enmienda')
		let wrapper_propuestaResDefinitivaConReq = document.getElementById('wrapper_propuestaResDefinitivaConReq')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
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
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data firma informe favorable/desfavorable<br>"
			todoBien = false
		}
/* 		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		} */
		if (!fecha_maxima_enmienda.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Data màxima per esmenar [data notificació req + 10 dies naturals]<br>"
			todoBien = false
		}
		if (!fecha_firma_propuesta_resolucion_prov.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Firma proposta resolució provisional<br>"
			todoBien = false
		}
		if (!fecha_not_propuesta_resolucion_prov.value) {
			infoMissingDataDoc8.innerHTML = infoMissingDataDoc8.innerHTML + "Notificació proposta resolució provisional<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc8.classList.add('ocultar')
			wrapper_propuestaResDefinitivaConReq.disabled = true
			wrapper_propuestaResDefinitivaConReq.innerHTML = "Generant i enviant ..."

			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_prop_res_definitiva_con_requerimiento_adr_isba'
		} else {
			infoMissingDataDoc8.classList.remove('ocultar')
		}
	}
</script>