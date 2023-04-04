<!----------------------------------------- Informe inici requeriment d'esmena DOC 20 SIN VIAFIRMA --------->
<div class="card-itramits">
  	<div class="card-itramits-body">
      Informe post esmena justificació
	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn-primary-itramits" data-toggle = "modal" data-target = "#mySobreSubsanacionRequerimiento" id="myBtnSobreSubsanacionRequerimiento">Genera l'informe</button>
			<span id="btn_19" class="">
    			<a id="wrapper_informe_sobre_subsanacion" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_informe_sobre_la_subsanacion');?>" class="btn-primary-itramits">Envia a signar l'informe</a>
			</span>
			<span id="spinner_19" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_informe_sobre_la_subsanacion'] !=0) { ?>
		<a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_informe_sobre_la_subsanacion');?>" target = "_self"><i class='fa fa-check'></i>Informe sobre l'esmena</a>		
		<?php }?>
		<?php
	//Compruebo el estado de la firma del documento.
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_informe_sobre_la_subsanacion.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
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
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- The Modal -->
<div id="mySobreSubsanacionRequerimiento" class="modal fade" role="dialog">
				<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content" style = "width: 80%;">
      				<div class="modal-header">
      					<label for="motivoSobreSubsanacion"><strong>Una vegada transcorregut el termini, el tècnic exposa i proposa que:</strong></label>
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
							<textarea required rows="10" cols="30" name="motivoSobreSubsanacion" class="form-control" id = "motivoSobreSubsanacion" 
							placeholder="El tècnic exposa que ..."><?php echo $expedientes['motivoSobreSubsanacion']; ?></textarea>
        				</div>
						<div class="form-group">
							<textarea required rows="10" cols="30" name="propuestaTecnicoSobreSubsanacion" class="form-control" id = "propuestaTecnicoSobreSubsanacion" 
							placeholder="El tècnic proposa que ..."><?php echo $expedientes['propuestaTecnicoSobreSubsanacion']; ?></textarea>
        				</div>					
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoInformeSobreSubsanacion_click();" id="guardaMotivoInformeSobreSubsanacion" 
							class="btn-itramits btn-success-itramits">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
		</div>
				<script>
					// Get the modal
					let modal_19 = document.getElementById("mySobreSubsanacionRequerimiento");
					// Get the button that opens the modal
					let btn_19 = document.getElementById("myBtnSobreSubsanacionRequerimiento");
					// Get the <span> element that closes the modal
					let span_19 = document.getElementsByClassName("close")[0];
					// When the user clicks the button, open the modal 
					btn_19.onclick = function() {
                    	modal_19.style.display = "block";
					}
					// When the user clicks on <span> (x), close the modal
					span_19.onclick = function() {
	                    modal_19.style.display = "none";
					}
					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
  					if (event.target == modal_19) {
	                    modal_19.style.display = "none";
  					}
					}
				</script>