<!----------------------------------------- Resolución de concesión amb requeriment. DOC 7. CON VIAFIRMA OK-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Resolució de concessió **testear** [PRE]
	</div>
	<div class="card-itramits-footer">
		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<button id="wrapper_ResConcesion" class="btn btn-primary btn-acto-admin" onclick="enviaResolucionConcesionConReg(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la resolució</button>
			<div id='infoMissingDataDoc6' class="alert alert-danger ocultar"></div>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_concesion_adr_isba'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_res_concesion_adr_isba.pdf');
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
	function enviaResolucionConcesion(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let wrapper_ResConcesion = document.getElementById('wrapper_ResConcesion')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let infoMissingDataDoc6 = document.getElementById('infoMissingDataDoc6')
		infoMissingDataDoc6.innerText = ""

		if (!fecha_REC.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if (!ref_REC.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if (!fecha_REC_enmienda.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if (!ref_REC_enmienda.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Referència SEU esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc6.classList.add('ocultar')
			wrapper_ResConcesion.disabled = true
			wrapper_ResConcesion.innerHTML = "Generant i enviant..."
			window.location.href = base_url + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_res_concesion_adr_isba'
		} else {
			infoMissingDataDoc6.classList.remove('ocultar')
		}
	}
</script>