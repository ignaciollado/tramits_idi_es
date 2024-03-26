<!----------------------------------------- Resolució denegació amb requeriment SIN VIAFIRMA DOC 11-->
<div class="card-itramits">
  <div class="card-itramits-body">
	Propuesta de resolución definitiva desfavorable sense requeriment
  </div>
  <div class="card-itramits-footer">
  		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="generadoc_res_denegacion_con_req" class='btn btn-primary btn-acto-admin' onclick="generaResolucionDenegacionConRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera  la resolució</button>
			<div id='infoMissingDataDoc11' class="alert alert-danger ocultar btn-acto-admin"></div>
			<span id="spinner_11" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
	<!-- <?php if ($expedientes['doc_res_denegacion_con_req'] !=0) { ?>
		<a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_denegacion_con_req');?>" target = "_self"><i class='fa fa-check'></i>La resolució de denegació</a>
	<?php }?> -->
	<?php if ($expedientes['doc_res_denegacion_con_req'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_denegacion_con_req.pdf');
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

	function generaResolucionDenegacionConRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	 	let fecha_propuesta_resolucion = document.getElementById('fecha_propuesta_resolucion') //0000-00-00
		let fecha_propuesta_resolucion_notif = document.getElementById('fecha_propuesta_resolucion_notif')
		let generadoc_res_denegacion_con_req = document.getElementById('generadoc_res_denegacion_con_req')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_11 = document.getElementById('spinner_11')
		let infoMissingDataDoc11 = document.getElementById('infoMissingDataDoc11')
		infoMissingDataDoc11.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	 	if(!fecha_propuesta_resolucion.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data firma proposta resolució<br>"
			todoBien = false
		}
		if(!fecha_propuesta_resolucion_notif.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data notificació proposta resolució<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc11.classList.add('ocultar')
			generadoc_res_denegacion_con_req.disabled = true
			generadoc_res_denegacion_con_req.innerHTML = "Enviant ..."
			spinner_11.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_denegacion_con_req'
		} else {
			infoMissingDataDoc11.classList.remove('ocultar')
		}
	}

</script>