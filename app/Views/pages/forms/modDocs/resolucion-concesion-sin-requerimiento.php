<!-----------------------------------------Resolució concessió favorable sense requeriment-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Resolució concessió favorable<br>sense requeriment<strong>¡¡¡¡¡[pre-tramits]!!!!!</strong>
  	</div>
		<div class="card-itramits-footer">
  		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="btnResConcesionFavSinReq" class='btn btn-primary btn-acto-admin' onclick="generaResolucionConcesionFavSinReq(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
			<div id='infoMissingDataDoc16' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_concesion_favorable_sin_req.pdf');
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

	function generaResolucionConcesionFavSinReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	 	let fecha_requerimiento_notif = document.getElementById('fecha_requerimiento_notif') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let fecha_infor_fav_desf = document.getElementById('fecha_infor_fav_desf')
		let fecha_firma_propuesta_resolucion_prov = document.getElementById('fecha_firma_propuesta_resolucion_prov')
		let fecha_not_propuesta_resolucion_prov = document.getElementById('fecha_not_propuesta_resolucion_prov')
		let btnResConcesionFavSinReq = document.getElementById('btnResConcesionFavSinReq')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generaInforme'
		let infoMissingDataDoc16 = document.getElementById('infoMissingDataDoc16')
		infoMissingDataDoc16.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	 	if(!fecha_requerimiento_notif.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if(!fecha_REC_enmienda.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Data SEU esmena<br>"
			todoBien = false
		}
		if(!fecha_infor_fav_desf.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Data firma informe favorable / desfavorable<br>"
			todoBien = false
		}
		if(!fecha_firma_propuesta_resolucion_prov.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Data firma proposta resolució provisional<br>"
			todoBien = false
		}
		if(!fecha_not_propuesta_resolucion_prov.value) {
			infoMissingDataDoc16.innerHTML = infoMissingDataDoc16.innerHTML + "Data notificació proposta resolució provisional<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc16.classList.add('ocultar')
			btnResConcesionFavSinReq.disabled = true
			btnResConcesionFavSinReq.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_concesion_favorable_sin_req'
		} else {
			infoMissingDataDoc16.classList.remove('ocultar')
		}
	}

</script>