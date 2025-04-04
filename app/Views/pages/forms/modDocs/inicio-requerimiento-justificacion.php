<!------------------------------------------- Informe inici requeriment justificación DOC 18 SIN VIAFIRMA --------->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Informe inici requeriment justificació<br>
			<small>Pendent crear plantilla json</small>
	</div>
	<div class="card-itramits-footer">
		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target= "#myInicioRequerimiento" id="myBtnInicioRequerimiento">Motiu del requeriment</button>
			<span id="btn_18" class="">
					<button id="wrapper_inicio_req_subsanacion" class='btn btn-secondary ocultar btn-acto-admin' onclick="enviaInformeInicioRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar el requeriment</button>
					<div id='infoMissingDataDoc18' class="alert alert-danger ocultar"></div>			
			</span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">

	<?php if ($expedientes['doc_inicio_requerimiento_justificacion'] !=0) { ?>
		<a	class='btn btn-ver-itramits ocultar btn-acto-admin' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_inicio_requerimiento_justificacion');?>" target = "_self"><i class='fa fa-check'></i>Inici requeriment justificació</a>		
		<?php }?>
		<?php
	//Compruebo el estado de la firma del documento.
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_inicio_requerimiento_justificacion.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
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
  	
	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- The Modal -->
 		<div id="myInicioRequerimiento" class="modal">
				<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content">
      				<div class="modal-header">
      					<h4><strong>Escriu el motiu de l'inici del requeriment:</strong></h4>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
							<textarea required rows="10" cols="30" name="motivoInicioRequerimiento" class="form-control" id = "motivoInicioRequerimiento" 
							placeholder="Motiu del requeriment"><?php echo $expedientes['motivoInicioRequerimiento']; ?></textarea>
        				</div>
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoInicioRequerimiento_click();" id="guardaMotivoInicioRequerimiento" 
										class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
		</div>


		<!------------------------------------------------------------------------------------------------------>
<script>
	function enviaInformeInicioRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
	 	let fecha_res_liquidacion = document.getElementById('fecha_res_liquidacion') //0000-00-00
		let fecha_de_pago = document.getElementById('fecha_de_pago')
		let fecha_reunion_cierre = document.getElementById('fecha_reunion_cierre')
		let fecha_max_desp_ampliacion = document.getElementById('fecha_max_desp_ampliacion')
		let wrapper_inicio_req_subsanacion = document.getElementById('wrapper_inicio_req_subsanacion')
		let infoMissingDataDoc18 = document.getElementById('infoMissingDataDoc18')
		infoMissingDataDoc18.innerText = ""

		if(!fecha_res_liquidacion.value) {
			infoMissingDataDoc18.innerHTML = infoMissingDataDoc18.innerHTML + "Data resolució de concessió<br>"
			todoBien = false
		}
		if(!fecha_de_pago.value) {
			infoMissingDataDoc18.innerHTML = infoMissingDataDoc18.innerHTML + "Data pagament<br>"
			todoBien = false
		}
		if(!fecha_reunion_cierre.value) {
			infoMissingDataDoc18.innerHTML = infoMissingDataDoc18.innerHTML + "Data reunió tancament<br>"
			todoBien = false
		}
		if(!fecha_max_desp_ampliacion.value) {
			infoMissingDataDoc18.innerHTML = infoMissingDataDoc18.innerHTML + "Data màxima després d'ampliació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc18.classList.add('ocultar')
			wrapper_inicio_req_subsanacion.disabled = true
			wrapper_inicio_req_subsanacion.innerHTML = "Generant i enviant..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_inicio_requerimiento_justificacion'
		} else {
			infoMissingDataDoc18.classList.remove('ocultar')
		}
	}
</script>