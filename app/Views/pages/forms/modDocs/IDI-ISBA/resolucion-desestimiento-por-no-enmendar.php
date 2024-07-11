<!----------------------------------------- Resolució desistiment por no enmendar DOC 2 SIN VIAFIRMA--------->
<div class="card-itramits">

  <div class="card-itramits-body">
  	Resolució desistiment per no esmenar ***PRE***
  </div>

  	<div class="card-itramits-footer">
	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
				<span id="btn_2" class="">
					<button id="generaElDesestimiento" class="btn btn-primary btn-acto-admin" onclick="enviaDesestimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
					<div id='infoMissingDataDoc2' class="alert alert-danger ocultar"></div>
				</span>
					<span id="spinner_2" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
		<?php
	//Compruebo el estado de la firma del documento.
	$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_requeriment_idi_isba.pdf');
	if ($tieneDocumentosGenerados)
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
				$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='info-msg'><i class='fa fa-check'></i>En curs</div>";		
				$estado_firma .= "</a>";						
				default:
				$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
				}
			echo $estado_firma;
		}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function enviaDesestimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_requerimiento_notif= document.getElementById('fecha_requerimiento_notif')
	
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let spinner_2 = document.getElementById('spinner_2')
		let generaElDesestimiento = document.getElementById('generaElDesestimiento')
		let infoMissingDataDoc2 = document.getElementById('infoMissingDataDoc2')
		infoMissingDataDoc2.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		if(!fecha_requerimiento_notif.value) {
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Data notificació requeriment"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc2.classList.add('ocultar')
			generaElDesestimiento.setAttribute("disabled", true)
			generaElDesestimiento.innerHTML = "Generant i enviant ..."
			spinner_2.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_desestimiento_por_no_enmendar_idi_isba'
		} else {
			infoMissingDataDoc2.classList.remove('ocultar')
		}
	}
</script>