<!----------------------------------------- Proposta resolució denegació ajut amb requeriment. SIN VIAFIRMA OK-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Proposta de resolució de denegació amb requeriment	
  	</div>
  	<div class="btn-group" role="group" aria-label="generar informe">
		
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
	  		<button type = "button" class = "btn-primary-itramits" data-bs-toggle="modal" data-bs-target="#myDenegacion_8" id="myBtnResDenegacionConReq">Motiu de la denegació</button>	
			<span id="btn_8" class="">
    			<a id="wrapper_motivoDenegacion_8" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_prop_res_denegacion_con_req');?>" class="btn btn-primary-itramits">Envia a la firma <br>de Gerència IDI</a>
			</span>
			<span id="spinner_8" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?> 
	
	</div>
  	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_prop_res_denegacion_con_req'] !=0) { ?> <!--Si existe el documento PDF muetra el enlace -->

		<!-- <a class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_prop_res_denegacion_con_req');?>" 
			target = "_self"><i class='fa fa-check'></i>La proposta de resolució</a> -->	 	
		
			<?php 
			$db = \Config\Database::connect();
			$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_prop_res_denegacion_con_req.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";// AND tipo_tramite='".$expedientes['tipo_tramite']."'";
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
					$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar<br>per Gerència IDI</div>";				
					break;
					case 'REJECTED':
					$estado_firma = "<div class = 'warning-msg'><i class='fa fa-warning'></i><a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId).">Signatura rebutjada<br>per Gerència IDI";
					$estado_firma .= "</a></div>";				
					break;
					case 'COMPLETED':
					$estado_firma = "<a class='btn btn-ver-itramits' href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><i class='fa fa-check'></i>Signat per Gerència IDI";		
					$estado_firma .= "</a>";					
					break;
					case 'IN_PROCESS':
					$estado_firma = "<div class='info-msg'><i class='fa fa-check'></i><a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." >En curs";		
					$estado_firma .= "</a></div>";						
					default:
					$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
			}
			echo $estado_firma;
	}	?>		
		
		<?php }?>
	<?php //} else {?> <!-- En caso de no existir el documento PDF muestra el botón para generarlo-->
			<div id="wrapper_generaDenegacion_8" class="">
				
      </div>
      <!-- The Modal -->
			<div class="modal"  id="myDenegacion_8">
				<div class="modal-dialog">
                    <!-- Modal content-->
    				<div class="modal-content" style = "width: 80%;">
      					<div class="modal-header">
      					<label for="motivoResDenegacionConReq"><strong>Escriu el motiu de la denegació:</strong></label>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      					</div>
      					<div class="modal-body">
							<div class="form-group">
								<textarea rows="10" cols="30" class="form-control" id="motivoDenegacion_8" 
									placeholder="Motiu de la denegació"><?php echo $expedientes['motivoDenegacion']; ?></textarea>
        					</div>
							<div class="form-group">
           						<button type="button" onclick = "javaScript: actualizaMotivoDenegacion_click();" id="guardaMotivoDenegacion" 
								   	class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        					</div>				
    					</div>
  					</div>
				</div>
			</div>
  	</div>
</div>