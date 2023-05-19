<!----------------------------------------- Resolució desistiment por no enmendar DOC 2 SIN VIAFIRMA--------->
<div class="card-itramits">

  <div class="card-itramits-body">
  	Resolució desistiment per no esmenar ¿ToDo?
  </div>

  	<div class="card-itramits-footer">

	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
				<span id="btn_2" class="">
					<!-- <a href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_desestimiento_por_no_enmendar');?>" class="btn-primary-itramits">Genera el desistiment per no esmenar</a> -->
					<button id="generaElDesestimiento" class='btn btn-secondary' onclick="enviaDesestimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera l'informe</button>
					<div id='infoMissingDataDoc2' class="alert alert-danger ocultar"></div>
				</span>
					<span id="spinner_2" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_res_desestimiento_por_no_enmendar'] !=0) { ?>
        <a class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_desestimiento_por_no_enmendar');?>" target = "_self"><i class='fa fa-check'></i>El desistiment per no esmenar</a>	
		<?php }?>
	<?php //} else {?>
        
	<?php //}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function enviaDesestimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_requerimiento_notif= document.getElementById('fecha_requerimiento_notif')
	
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_2 = document.getElementById('spinner_2')
		let infoMissingDataDoc2 = document.getElementById('infoMissingDataDoc2')
		infoMissingDataDoc2.innerText = ""
		if(!fecha_REC.value) {
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if(!fecha_requerimiento_notif.value) {
			infoMissingDataDoc2.innerHTML = infoMissingDataDoc2.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc2.classList.add('ocultar')
			generaInfFavConReq.disabled = true
			generaInfFavConReq.innerHTML = "Generant ..."
			spinner_2.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_desestimiento_por_no_enmendar'
		} else {
			infoMissingDataDoc2.classList.remove('ocultar')
		}
	}
</script>