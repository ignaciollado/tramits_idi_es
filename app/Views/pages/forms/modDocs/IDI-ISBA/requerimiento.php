<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Requeriment [Tendrá un término máximo de 10 días]
  	</div>
	<div class="card-itramits-footer">
		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
				<button type="button" class="btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#myRequerimientoIdiIsba" id="myBtnRequerimientoIdiIsba">Motiu del requeriment</button>
				<span id="btn_3">
    			<a id ="wrapper_motivoRequerimientoIdiIsba" class="btn btn-primary ocultar" href="<?php echo base_url('public/index.php/expedientes/generainformeIDI_ISBA/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requeriment_idi_isba');?>">Envia a signar</a>
				</span>
		<?php }?>
	</div>
  <div class ="card-itramits-footer">
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

		<div id="myRequerimientoIdiIsba" class="modal">
        	<div class="modal-dialog">
            	<div class="modal-content">
	                <div class="modal-header">
    	                <h4>Motiu del requeriment:</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            	    </div>
                	<div class="modal-body">
						<textarea required rows="10" cols="30" name="motivoRequerimientoIdiIsba" class="form-control" id = "motivoRequerimientoIdiIsba" 
								placeholder="Motiu del requeriment"><?php echo $expedientes['motivoRequerimiento']; ?>
						</textarea>
                	</div>
                	<div class="modal-footer">
						<div class="btn-group" role="group" aria-label="cancela-guarda">
	                    	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancela</button>
                    		<button type="button" class="btn btn-primary" onclick = "javaScript: actualizaMotivoRequerimientoIdiIsba_click();" id="guardaMotivoRequerimientoIdiIsba" 
								class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
						</div>
                	</div>
            	</div>
        	</div>
		</div>
  </div>  
</div>