<!----------------------------------------- Informe favorable amb requeriment ILS-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Informe favorable <strong>amb</strong> requeriment
	
  	</div>
  	<div class="card-itramits-footer">

	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
	  		<span id="btn_6" class="">	
	  			<a class="btn btn-secondary btn-acto-admin" id="generaInfFavConReq" href="<?php echo base_url('public/index.php/expedientes/generainformeILS/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_informe_favorable_con_requerimiento_ils');?>">Genera l'informe</a>
			</span>
			<span id="spinner_6" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#365446;"></i></span>
		<?php }?>
	
	</div>  
  	<div class="card-itramits-footer">
<?php if ($expedientes['doc_informe_favorable_con_requerimiento_ils'] !=0) { ?>
	<?php 
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_informe_favorable_con_requerimiento_ils.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
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
					$estado_firma = "<div class='info-msg'><i class='fa fa-check'></i><a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." >En curs";		
					$estado_firma .= "</a></div>";						
				default:
					$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
			}
			echo $estado_firma;
	}		
			 ?>			
		<!--<?php //} else {?>-->
<?php }?>
	<!--<?php //}?>-->
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>