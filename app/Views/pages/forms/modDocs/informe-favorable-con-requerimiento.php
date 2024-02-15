<!----------------------------------------- Informe favorable amb requeriment DOC 3-------------------------------------->
<!-- Campos requeridos son: fecha_REC, ref_REC, fecha_rec_mejora, ref_rec_mejora, fecha_requerimiento_notif, fecha_REC_enmienda, ref_REC_enmienda -->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Informe favorable amb requeriment
  	</div>
  	<div class="card-itramits-footer">
	<?php
			
      if ( !$esAdmin && !$esConvoActual ) {
        /*  */
				}
      else {
	?>
	  	<span id="btn_3" class="">
			<button id="generaInfFavConReq" class = "btn btn-primary" onclick="enviaInformeFavorableConRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera l'informe</button>
			<div id='infoMissingDataDoc3' class="alert alert-danger ocultar"></div>
		</span>
		<span id="spinner_3" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:20px; color:#000000;"></i></span>
	
	<?php }?>
	
	</div>  
  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_informe_favorable_con_requerimiento'] !=0) { 
		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_informe_favorable_con_requerimiento.pdf');
		if (isset($tieneDocumentosGenerados))
		{
	  $PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
	  $requestPublicAccessId = $PublicAccessId;
		$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
		$respuesta = json_decode ($request, true);
		$estado_firma = $respuesta['status'];
		switch ($estado_firma)
			{
				case 'NOT_STARTED':
					$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar</div>";				
					break;
					case 'REJECTED':
					$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'warning-msg'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
					$estado_firma .= "</a>";				
					break;
					case 'COMPLETED':
					$estado_firma = "<a class='btn btn-ver-itramits' href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><i class='fa fa-check'></i>Signat";		
					$estado_firma .= "</a>";					
					break;
					case 'IN_PROCESS':
					$estado_firma = "<div class='info-msg'><i class='fa fa-check'></i><a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." >En curs";		
					$estado_firma .= "</a></div>";						
					default:
					$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
			}
			echo $estado_firma;
	}		
}?>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>
	function enviaInformeFavorableConRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_requerimiento_notif = document.getElementById('fecha_requerimiento_notif') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let generaInfFavConReq = document.getElementById('generaInfFavConReq')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_3 = document.getElementById('spinner_3')
		let infoMissingDataDoc3 = document.getElementById('infoMissingDataDoc3')
		infoMissingDataDoc3.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if(!fecha_requerimiento_notif.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if(!fecha_REC_enmienda.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if(!ref_REC_enmienda.value) {
			infoMissingDataDoc3.innerHTML = infoMissingDataDoc3.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc3.classList.add('ocultar')
			generaInfFavConReq.disabled = true
			generaInfFavConReq.innerHTML = "Generant ..."
			spinner_3.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_favorable_con_requerimiento'
		} else {
			infoMissingDataDoc3.classList.remove('ocultar')
		}
	}

</script>