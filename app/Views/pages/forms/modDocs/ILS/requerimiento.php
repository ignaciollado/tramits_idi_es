<div class="card-itramits">
  	<div class="card-itramits-body">
    	Requeriment
  	</div>
	<div class="card-itramits-footer">
	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button class="btn btn-secondary btn-acto-admin" type = "button" data-bs-toggle="modal" data-bs-target= "#myRequerimientoIls" id="myBtnRequerimientoIls">Motiu del requeriment</button>
			<span id="btn_3" class="">
    			<a id ="wrapper_motivoRequerimientoIls" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInformeILS/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requeriment_ils');?>">Envia a signar el requeriment</a>
			</span>
	<?php }?>
	
	</div>
  <div class ="card-itramits-footer">
	<?php
	//Compruebo el estado de la firma del documento.
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_requeriment_ils.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
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
	<?php ?>

			<div id="myRequerimientoIls" class="modal">
				<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
					  	<h4 class="modal-title">Escriu el motiu del requeriment ILS:</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoRequerimientoIls" class="form-control" id = "motivoRequerimientoIls" 
						placeholder="Motiu del requeriment"><?php echo $expedientes['motivoRequerimientoIls']; ?></textarea>
        				</div>
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoRequerimientoIls_click();" id="guardaMotivoRequerimientoIls" 
							class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
			</div>
		
	<?php ?> 
  </div>  
</div>