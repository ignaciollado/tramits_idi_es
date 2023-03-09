<div class="card-itramits">
  	<div class="card-itramits-body">
    	Requeriment
  	</div>
	<div class="card-itramits-footer">

	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn-primary-itramits" data-toggle = "modal" data-target = "#myRequerimiento" id="myBtnRequerimiento">Motiu del <br>requeriment</button>
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
	<?php ?>
            <!-- The Modal -->
			<div id="myRequerimiento" class="modal fade" role="dialog">
				<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content" style = "width: 80%;">
      				<div class="modal-header">
      					<label for="motivoRequerimiento"><strong>Escriu el motiu del requeriment:</strong></label>
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoRequerimiento" class="form-control" id = "motivoRequerimiento" 
						placeholder="Motiu del requeriment"><?php echo $expedientes['motivoRequerimiento']; ?></textarea>
        				</div>
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoRequerimiento_click();" id="guardaMotivoRequerimiento" 
							class="btn-itramits btn-success-itramits">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
			</div>
			<script>
					// Get the modal
					let modal_3 = document.getElementById("myRequerimiento");

					// Get the button that opens the modal
					let btn_3 = document.getElementById("myBtnRequerimiento");

					// Get the <span> element that closes the modal
					let span_3 = document.getElementsByClassName("close")[0];

					// When the user clicks the button, open the modal 
					btn_3.onclick = function() {
                    	modal_3.style.display = "block";

						if ( <?php echo $session->get("programa") === "ILS";?> ) {
							let id = '<?php echo $session->get("id");?>'
							getEstadoValidacionDocumentos(id)
						}
					}

					// When the user clicks on <span> (x), close the modal
					span_3.onclick = function() {
	                    modal_3.style.display = "none";
					}

					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
  					if (event.target == modal_3) {
	                    modal_3.style.display = "none";
  					}
					}
			</script>
	<?php ?> 
  </div>  
</div>