<!----------------------------------------- Resolución de concesión amb requeriment. DOC 10 -->
<div class="card-itramits">
	<div class="card-itramits-body">
		Resolució de concessió amb requeriment
		<?php
		if ($base_url === "pre-tramitsidi") {?>
			**testear** [PRE]
		<?php }?>
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_ResConcesionConReq" class="btn btn-primary btn-acto-admin" onclick="enviaResolucionConcesionConReq(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la resolució</button>
			<div id='infoMissingDataDoc10' class="alert alert-danger ocultar"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_concesion_con_requerimiento_adr_isba'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_res_concesion_con_requerimiento_adr_isba.pdf');

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
						break;
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
	function enviaResolucionConcesionConReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')

		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')

		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf')
		let fecha_firma_propuesta_resolucion_prov = document.getElementById('fecha_firma_propuesta_resolucion_prov')
		let fecha_not_propuesta_resolucion_prov = document.getElementById('fecha_not_propuesta_resolucion_prov')
		let fecha_firma_propuesta_resolucion_def = document.getElementById('fecha_firma_propuesta_resolucion_def')
		let fecha_not_propuesta_resolucion_def = document.getElementById('fecha_not_propuesta_resolucion_def')

		let wrapper_ResConcesionConReq = document.getElementById('wrapper_ResConcesionConReq')
		let infoMissingDataDoc10 = document.getElementById('infoMissingDataDoc10')
		infoMissingDataDoc10.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_infor_fav_desf.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "	Firma informe favorable / desfavorable<br>"
			todoBien = false
		}
		if (!fecha_firma_propuesta_resolucion_prov.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Firma proposta resolució provisional<br>"
			todoBien = false
		}
		if (!fecha_not_propuesta_resolucion_prov.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "	Notificació proposta resolució provisional<br>"
			todoBien = false
		}
		if (!fecha_firma_propuesta_resolucion_def.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Firma proposta resolució definitiva<br>"
			todoBien = false
		}
		if (!fecha_not_propuesta_resolucion_def.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Notificació proposta resolució definitiva<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc10.innerHTML = infoMissingDataDoc10.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc10.classList.add('ocultar')
			wrapper_ResConcesionConReq.disabled = true
			wrapper_ResConcesionConReq.innerHTML = "Generant i enviant..."
			window.location.href = base_url_isba + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_res_concesion_con_requerimiento_adr_isba'
		} else {
			infoMissingDataDoc10.classList.remove('ocultar')
		}
	}
</script>