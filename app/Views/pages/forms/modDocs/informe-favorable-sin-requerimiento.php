<!-- -------------------------------------- Informe favorable sense requeriment  DOC 4-------------------------------------->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Informe favorable
			<?php
		if ($base_url === "pre-tramitsidi") {?>
			<span class="label label-warning">***testear*** [PRE]</span>
		<?php }?>			
  	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
				<span id="btn_4" class="">	
					<button id="generaInfFavSinReq" class = "btn btn-primary btn-acto-admin" onclick="enviaInformeFavorableSinRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera l'informe</button>
					<div id='infoMissingDataDoc4' class="alert alert-danger ocultar btn-acto-admin"></div>
				</span>
			<span id="spinner_4" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	
	</div>  
  	<div class="card-itramits-footer">
	<?php 
		$db = \Config\Database::connect();
		$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_informe_favorable_sin_requerimiento.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";// AND tipo_tramite='".$expedientes['tipo_tramite']."'";
		$query = $db->query($sql);
		$row = $query->getRow();
		if (isset($row))
		{
		$PublicAccessId = $row->publicAccessId;
	    $requestPublicAccessId = $PublicAccessId;
		$selloDeTiempo = $row->selloDeTiempo;
		$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
		$respuesta = json_decode ($request, true);
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
/* 			$estado_firma .= "<a href=".base_url('/public/index.php/expedientes/muestrainforme/'.$expedientes['id'].'/2024/'.$expedientes['tipo_tramite'].'/'.$expedientes['nif'].'/doc_informe_favorable_sin_requerimiento'.'/'.$expedientes['nif'].'/'.$selloDeTiempo.'/'.$tipoMIME).">PDF</a>";
			$estado_firma .= "</a>"; */
			}
			echo $estado_firma;
		}
			 ?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>
	const actualBaseUrl = window.location.origin
	let base_url = actualBaseUrl+'/public/index.php/expedientes/generaInforme'	
	function enviaInformeFavorableSinRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')

		let generaInfFavSinReq = document.getElementById('generaInfFavSinReq')
		let spinner_4 = document.getElementById('spinner_4')
		let infoMissingDataDoc4 = document.getElementById('infoMissingDataDoc4')
		infoMissingDataDoc4.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc4.innerHTML = infoMissingDataDoc4.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc4.classList.add('ocultar')
			generaInfFavSinReq.disabled = true
			generaInfFavSinReq.innerHTML = "Generant ..."
			spinner_4.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_favorable_sin_requerimiento'
		} else {
			infoMissingDataDoc4.classList.remove('ocultar')
		}
	}

</script>