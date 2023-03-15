<div class="card-itramits">
  	<div class="card-itramits-body">
    	Requeriment
  	</div>
	<div class="card-itramits-footer">

	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type="button" class="btn-primary-itramits" data-bs-toggle="modal" data-bs-target="#myRequerimiento">Motiu del <br>requeriment</button>
			<span id="btn_3" class="">
    			<a id ="wrapper_motivoRequerimiento" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requeriment');?>">Envia a signar el requeriment</a>
			</span>
			<span id="spinner_3" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
	<?php }?>
	
	</div>
  <div class ="card-itramits-footer">
	<?php
	//Compruebo el estado de la firma del documento.
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_requeriment.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
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

<div class="modal" id="myRequerimiento">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Motiu del requeriment:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
					<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoRequerimiento" class="form-control" id = "motivoRequerimiento" 
						placeholder="Motiu del requeriment"><?php echo $expedientes['motivoRequerimiento']; ?></textarea>
        	</div>
					
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
				<div class="form-group">
          	<button type="button" onclick = "javaScript: actualizaMotivoRequerimiento_click();" id="guardaMotivoRequerimiento" 
						class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
				</div>		
      </div>

    </div>
  </div>
</div>

  </div>  
</div>