<!-- -------------------------------------- Renovacion resolución de revocació DOC 15-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Resolució de revocació
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
			<button id="btnRenResolucionRevocacionMarcaILS" class='btn btn-primary btn-acto-admin' onclick="generaRenovacionResolucionRevocacionILS(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Generar la resolució</button>
			<div id='infoMissingDataDoc15ILS' class="alert alert-danger ocultar btn-acto-admin"></div>		
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
		<?php
		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_renovacion_resolucion_revocacion_ils.pdf');
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
			}	
			if (isset($tieneDocumentosGenerados)) {?>
				<a class='btn btn-warning btn-acto-admin' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_renovacion_resolucion_revocacion_ils');?>" target = "_self"><i class='fa fa-check'></i>La revocació</a>		
			<?php }?>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function generaRenovacionResolucionRevocacionILS (id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_resolucion = document.getElementById('fecha_resolucion')
		let fecha_notif_req_renov = document.getElementById('fecha_notif_req_renov')
		let fecha_infor_desf_renov = document.getElementById('fecha_infor_desf_renov')
		let btnRenResolucionRevocacionMarcaILS = document.getElementById('btnRenResolucionRevocacionMarcaILS')
		let infoMissingDataDoc15ILS = document.getElementById('infoMissingDataDoc15ILS')
		infoMissingDataDoc15ILS.innerText = ""

		if(!fecha_resolucion.value) {
			infoMissingDataDoc15ILS.innerHTML = infoMissingDataDoc15ILS.innerHTML + "Firma resolució<br>"
			todoBien = false
		}
		if(!fecha_infor_desf_renov.value) {
			infoMissingDataDoc15ILS.innerHTML = infoMissingDataDoc15ILS.innerHTML + "Data informe desfavorable renovació<br>"
			todoBien = false
		}
		if(!fecha_notif_req_renov.value) {
			infoMissingDataDoc15ILS.innerHTML = infoMissingDataDoc15ILS.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc15ILS.classList.add('ocultar')
			btnRenResolucionRevocacionMarcaILS.disabled = true
			btnRenResolucionRevocacionMarcaILS.innerHTML = "Generant i enviant ..."
			window.location.href = base_url_ils+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_renovacion_resolucion_revocacion_ils'
		} else {
			infoMissingDataDoc15ILS.classList.remove('ocultar')
		}
	}
</script>