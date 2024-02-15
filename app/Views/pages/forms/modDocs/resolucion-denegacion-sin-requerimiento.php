<!----------------------------------------- Resolució denegació_ sense requeriment. DOC 12. SIN VIAFIRMA-->
<div class="card-itramits">
  <div class="card-itramits-body">
    Resolució de denegació sense requeriment
  </div>
  <div class="card-itramits-footer">
  	<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
      else {?>
				<button id="generadoc_res_denegacion_sin_req" class='btn btn-primary' onclick="generaResolucionDenegacionSinRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera  la resolució</button>
					<div id='infoMissingDataDoc12' class="alert alert-danger ocultar"></div>
					<span id="spinner_12" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
			<?php }?>
	</div>  
  <div class="card-itramits-footer">
			<!-- <?php if ($expedientes['doc_res_denegacion_sin_req'] !=0) { ?>
        <a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_denegacion_sin_req');?>" target = "_self"><i class='fa fa-check'></i>La resolució de denegació</a>	
			<?php }?> -->
			<?php //} else {?>
			<?php //}?>

			<?php if ($expedientes['doc_res_denegacion_sin_req'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_denegacion_sin_req.pdf');
			if (isset($tieneDocumentosGenerados)) {
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
				$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
						$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar</div>";
						break;
					case 'REJECTED':
						$estado_firma = "<a href=" . base_url('public/index.php/expedientes/muestrasolicitudrechazada/' . $requestPublicAccessId) . "><div class = 'warning-msg'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
						$estado_firma .= "</a>";
						break;
					case 'COMPLETED':
						$estado_firma = "<a class='btn btn-ver-itramits' href=" . base_url('public/index.php/expedientes/muestrasolicitudfirmada/' . $requestPublicAccessId) . " ><i class='fa fa-check'></i>Signat";
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

	function generaResolucionDenegacionSinRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	 	let fecha_propuesta_resolucion = document.getElementById('fecha_propuesta_resolucion') //0000-00-00
		let fecha_propuesta_resolucion_notif = document.getElementById('fecha_propuesta_resolucion_notif')
		let generadoc_res_denegacion_sin_req = document.getElementById('generadoc_res_denegacion_sin_req')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_12 = document.getElementById('spinner_12')
		let infoMissingDataDoc12 = document.getElementById('infoMissingDataDoc12')
		infoMissingDataDoc12.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc12.innerHTML = infoMissingDataDoc12.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc12.innerHTML = infoMissingDataDoc12.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	 	if(!fecha_propuesta_resolucion.value) {
			infoMissingDataDoc12.innerHTML = infoMissingDataDoc12.innerHTML + "Data firma proposta resolució<br>"
			todoBien = false
		}
		if(!fecha_propuesta_resolucion_notif.value) {
			infoMissingDataDoc12.innerHTML = infoMissingDataDoc12.innerHTML + "Data notificació proposta resolució<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc12.classList.add('ocultar')
			generadoc_res_denegacion_sin_req.disabled = true
			generadoc_res_denegacion_sin_req.innerHTML = "Enviant ..."
			spinner_12.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_denegacion_sin_req'
		} else {
			infoMissingDataDoc12.classList.remove('ocultar')
		}
	}

</script>