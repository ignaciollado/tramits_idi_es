<!----------------------------------------- Informe inici requeriment d'esmena SIN VIAFIRMA --------->
<div class="card-itramits">
  	<div class="card-itramits-body">
      Requeriment d'esmena
	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn-primary-itramits" data-toggle = "modal" data-target = "#myRequerimientoSubsanacion" id="myBtnRequerimientoSubsanacion">Motiu del requeriment</button>
			<span id="btn_18" class="">
    			<a id="wrapper_generadoc_req_subsanacion" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requerimiento_subsanacion');?>" class="btn-primary-itramits">Envia a la firma <br>de Gerència IDI</a>
			</span>			
			<span id="spinner_18" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_requerimiento_subsanacion'] !=0) { ?>
			<a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requerimiento_subsanacion');?>" target = "_self"><i class='fa fa-check'></i>El requeriment d’esmena</a>		

			<?php 
			$db = \Config\Database::connect();
			$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_requerimiento_subsanacion.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";// AND tipo_tramite='".$expedientes['tipo_tramite']."'";
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
					$estado_firma = "<a class='btn btn-ver-itramits' href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><i class='fa fa-check'></i>Signat<br>per Gerència IDI";		
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
		
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
 <!-- The Modal -->
 <div id="myRequerimientoSubsanacion" class="modal fade" role="dialog">
				<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content" style = "width: 80%;">
      				<div class="modal-header">
      					<label for="motivoRequerimientoSubsanación"><strong>Escriu el motiu del requeriment d'esmena:</strong></label>
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoRequerimientoSubsanacion" class="form-control" id = "motivoRequerimientoSubsanacion" 
						placeholder="Motiu del requeriment d'esmena"><?php echo $expedientes['motivoRequerimientoSubsanacion']; ?></textarea>
        				</div>
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoRequerimientoSubsanacion_click();" id="guardaMotivoRequerimientoSubsanacion" 
							class="btn-itramits btn-success-itramits">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
		</div>
				<script>
					// Get the modal
					let modal_18 = document.getElementById("myRequerimientoSubsanacion");
					// Get the button that opens the modal
					let btn_18 = document.getElementById("myBtnRequerimientoSubsanacion");
					// Get the <span> element that closes the modal
					let span_18 = document.getElementsByClassName("close")[0];
					// When the user clicks the button, open the modal 
					btn_18.onclick = function() {
                    	modal_18.style.display = "block";
					}
					// When the user clicks on <span> (x), close the modal
					span_18.onclick = function() {
	                    modal_18.style.display = "none";
					}
					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
  					if (event.target == modal_18) {
	                    modal_18.style.display = "none";
  					}
					}
				</script>