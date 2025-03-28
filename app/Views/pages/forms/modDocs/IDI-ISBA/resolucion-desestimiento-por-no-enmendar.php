<!----------------------------------------- Resolució desistiment por no enmendar DOC 2 SIN VIAFIRMA--------->
<div class="card-itramits">

  <div class="card-itramits-body">
  	Resolució desistiment per no esmenar
		<?php
		if ($base_url === "pre-tramitsidi") {?>
			**testear** [PRE]
		<?php }?>
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
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
		<?php
	//Compruebo el estado de la firma del documento.
	$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_res_desestimiento_por_no_enmendar_adr_isba.pdf');
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
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Notificació requeriment"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc2.classList.add('ocultar')
			generaElDesestimiento.setAttribute("disabled", true)
			generaElDesestimiento.innerHTML = "Generant i enviant ..."
			window.location.href = base_url_isba+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_desestimiento_por_no_enmendar_adr_isba'
		} else {
			infoMissingDataDoc2.classList.remove('ocultar')
		}
	}
</script>