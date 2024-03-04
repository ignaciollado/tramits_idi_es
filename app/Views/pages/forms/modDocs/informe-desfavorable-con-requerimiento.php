<!-- -------------------------------------- Informe desfavorable amb requeriment DOC 6-->
<div class="card-itramits">
  <div class="card-itramits-body">
     Informe desfavorable amb requeriment	
  </div>
  <div class="card-itramits-footer" aria-label="generar informe">

  		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
  			<button type = "button" class = "btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#mygeneraInformeDesfConReq" id="myBtngeneraInformeDesfConReq">Motiu de la denegació</button>
				<span id="btn_4" class="">					
					<button id="wrapper_generaInformeDesfConReq" class='btn btn-primary ocultar btn-acto-admin' onclick="enviaInformeDesfavorableConRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar l'informe</button>
					<div id='infoMissingDataDoc6' class="alert alert-danger ocultar"></div>
				</span>
			<span id="spinner_4" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>	
		<?php }?>
			
	</div>

  	<div class="card-itramits-footer">
	<?php //if ($expedientes['doc_informe_desfavorable_con_requerimiento'] !=0) { ?>
	<?php 
		$db = \Config\Database::connect();
		$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_informe_desfavorable_con_requerimiento.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";// AND tipo_tramite='".$expedientes['tipo_tramite']."'";
		$query = $db->query($sql);
		$row = $query->getRow();
		if (isset($row))
		{
	   	$PublicAccessId = $row->publicAccessId;
		$requestPublicAccessId = $PublicAccessId;
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
			}
			echo $estado_firma;
		}			
			 ?>		


<div class="modal" id="mygeneraInformeDesfConReq">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
        		<h4 class="modal-title">Motiu de la denegació:</h4>
        		<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      		</div>
      		<div class="modal-body">
				<div class="form-group">
          			<input type="hidden" name="motivogeneraInformeDesfConReq_valor" class="form-control" id = "motivogeneraInformeDesfConReq_valor" required placeholder="Nom del sol·licitant" value="<?php echo $expedientes['motivoDenegacion']; ?>">
					<textarea rows="10" cols="30" name="motivogeneraInformeDesfConReq" class="form-control" id = "motivogeneraInformeDesfConReq" min="0" placeholder="Motiu de la denegació"><?php echo $expedientes['motivoDenegacion']; ?></textarea>
        		</div>
      		</div>
      	<div class="modal-footer">
			<div class="form-group">
       			<button type="button" onclick = "javaScript: actualizaMotivoDesfavorableConReq_click();" id="guardaMotivogeneraInformeDesfConReq" 
				class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
			</div>		
      	</div>
    	</div>
  	</div>
</div>
						
	<div id="wrapper_motivogeneraInformeDesfConReq" class="ocultar"></div>
 
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function enviaInformeDesfavorableConRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	 	let fecha_requerimiento_notif = document.getElementById('fecha_requerimiento_notif') //0000-00-00
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let ref_REC_enmienda = document.getElementById('ref_REC_enmienda')
		let generaInfFavConReq = document.getElementById('wrapper_generaInformeDesfConReq')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_4 = document.getElementById('spinner_4')
		let infoMissingDataDoc6 = document.getElementById('infoMissingDataDoc6')
		infoMissingDataDoc6.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	 	if(!fecha_requerimiento_notif.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if(!fecha_REC_enmienda.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if(!ref_REC_enmienda.value) {
			infoMissingDataDoc6.innerHTML = infoMissingDataDoc6.innerHTML + "Referència REC esmena<br>"
			todoBien = false
		} 

		if (todoBien) {
			infoMissingDataDoc6.classList.add('ocultar')
			generaInfFavConReq.disabled = true
			generaInfFavConReq.innerHTML = "Generant ..."
			spinner_4.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_desfavorable_con_requerimiento'
		} else {
			infoMissingDataDoc6.classList.remove('ocultar')
		}
	}
</script>