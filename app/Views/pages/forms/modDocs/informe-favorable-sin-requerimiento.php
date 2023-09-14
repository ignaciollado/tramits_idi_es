<!-- -------------------------------------- abril_Informe favorable sense requeriment 2021 OK-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Informe favorable sense requeriment
  	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
				<span id="btn_4" class="">	
    			<!-- <a id="generaInfFavSinReq" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_informe_favorable_sin_requerimiento');?>" class="btn-primary-itramits">Generar l'informe</a> -->
					<button id="generaInfFavConReq" class = "btn btn-primary" onclick="enviaInformeFavorableSinRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera l'informe</button>
					<div id='infoMissingDataDoc4' class="alert alert-danger ocultar"></div>
				</span>
			<span id="spinner_4" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	
	</div>  
  	<div class="card-itramits-footer">
	<?php //if ($expedientes['doc_informe_favorable_sin_requerimiento'] !=0) { 
		$db = \Config\Database::connect();
		$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_informe_favorable_sin_requerimiento.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";// AND tipo_tramite='".$expedientes['tipo_tramite']."'";
		$query = $db->query($sql);
		$row = $query->getRow();
		if (isset($row))
		{
		$PublicAccessId = $row->publicAccessId;
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
			$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='info-msg'><i class='fa fa-check'></i>En curs</div>";		
			$estado_firma .= "</a>";						
			default:
			$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
			}
			echo $estado_firma;
		}
			 ?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>

	function enviaInformeFavorableSinRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	/* 	let fecha_requerimiento_notif = document.getElementById('fecha_requerimiento_notif') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda') */
		let generaInfFavConReq = document.getElementById('generaInfFavConReq')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_4 = document.getElementById('spinner_4')
		let infoMissingDataDoc4 = document.getElementById('infoMissingDataDoc4')
		infoMissingDataDoc4.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	/* 	if(!fecha_requerimiento_notif.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if(!fecha_REC_enmienda.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if(!ref_REC_enmienda.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		} */

		if (todoBien) {
			infoMissingDataDoc4.classList.add('ocultar')
			generaInfFavConReq.disabled = true
			generaInfFavConReq.innerHTML = "Generant ..."
			spinner_4.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_favorable_sin_requerimiento'
		} else {
			infoMissingDataDoc4.classList.remove('ocultar')
		}
	}

</script>