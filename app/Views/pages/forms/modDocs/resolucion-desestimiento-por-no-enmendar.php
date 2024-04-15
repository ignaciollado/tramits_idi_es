<!----------------------------------------- Resolució desistiment por no enmendar DOC 2--------->
<div class="card-itramits">

  <div class="card-itramits-body">
  	Resolució de desistiment per no esmenar
  </div>

  	<div class="card-itramits-footer">

	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
				<span id="btn_2" class="">
					<button id="wrapper_desestimientoPorNoEnmendar" class = "btn btn-primary btn-acto-admin" onclick="enviaDesestimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
					<div id='infoMissingDataDoc2' class="alert alert-danger ocultar btn-acto-admin"></div>
				</span>
					<span id="spinner_2" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>  

	</div>

  <div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_desestimiento_por_no_enmendar'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_desestimiento_por_no_enmendar.pdf');
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
/* 					$estado_firma .= "<a href=".base_url('/public/index.php/expedientes/muestrainforme/'.$expedientes['id'].'/2024/'.$expedientes['tipo_tramite'].'/'.$expedientes['nif'].'/doc_res_desestimiento_por_no_enmendar'.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME).">PDF</a>";
					$estado_firma .= "</a>"; */
					}
				echo $estado_firma;
			}	?>
		<?php } ?>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function enviaDesestimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_requerimiento_notif= document.getElementById('fecha_requerimiento_notif')
		let wrapper_desestimientoPorNoEnmendar = document.getElementById('wrapper_desestimientoPorNoEnmendar')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generainforme'
		let spinner_2 = document.getElementById('spinner_2')
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
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc2.classList.add('ocultar')
			wrapper_desestimientoPorNoEnmendar.disabled = true
			wrapper_desestimientoPorNoEnmendar.innerHTML = "Generant i enviant ..."
			spinner_2.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_desestimiento_por_no_enmendar'
		} else {
			infoMissingDataDoc2.classList.remove('ocultar')
		}
	}
</script>