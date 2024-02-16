<!----------------------------------------- Resolució concessió sense requeriment DOC 17 SIN VIAFIRMA --------->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Resolució de concessió
	</div>
	<div class="card-itramits-footer">
		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<span id="btn_17" class="">
					<button id="generadoc_res_conces_sin_req" class='btn btn-primary btn-acto-admin' onclick="generaResolucionConcesion(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Generar la resolució</button>
					<div id='infoMissingDataDoc17' class="alert alert-danger ocultar"></div>
				</span>	
			<span id="spinner_17" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_res_conces_sin_req'] !=0) { ?>
		<a	class='btn btn-success btn-acto-admin' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_conces_sin_req');?>" target = "_self"><i class='fa fa-check'></i>La resolució de concessió</a>		
		<?php }	?>	
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function generaResolucionConcesion(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	 	let fecha_propuesta_resolucion_notif = document.getElementById('fecha_propuesta_resolucion_notif') //0000-00-00
		let fecha_de_pago = document.getElementById('fecha_de_pago')
		let fecha_reunion_cierre = document.getElementById('fecha_reunion_cierre')
		let fecha_REC_justificacion = document.getElementById('fecha_REC_justificacion')
		let ref_REC_justificacion = document.getElementById('ref_REC_justificacion')
		let generadoc_res_conces_sin_req = document.getElementById('generadoc_res_conces_sin_req')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_17 = document.getElementById('spinner_17')
		let infoMissingDataDoc17 = document.getElementById('infoMissingDataDoc17')
		infoMissingDataDoc17.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	 	if(!fecha_propuesta_resolucion_notif.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Data notificació proposta resolució<br>"
			todoBien = false
		}
		if(!fecha_de_pago.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Data pagament<br>"
			todoBien = false
		}
		if(!fecha_reunion_cierre.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Data reunió tancament<br>"
			todoBien = false
		}
		if(!fecha_REC_justificacion.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Data REC justificació<br>"
			todoBien = false
		}
		if(!ref_REC_justificacion.value) {
			infoMissingDataDoc17.innerHTML = infoMissingDataDoc17.innerHTML + "Referència REC justificació<br>"
			todoBien = false
		}				
	
		if (todoBien) {
			infoMissingDataDoc17.classList.add('ocultar')
			generadoc_res_conces_sin_req.disabled = true
			generadoc_res_conces_sin_req.innerHTML = "Generant ..."
			spinner_17.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_conces_sin_req'
		} else {
			infoMissingDataDoc17.classList.remove('ocultar')
		}
	}
</script>