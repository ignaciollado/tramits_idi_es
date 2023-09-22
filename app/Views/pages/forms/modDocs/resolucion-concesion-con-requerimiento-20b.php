<!----------------------------------------- Informe inici requeriment d'esmena (20b) DOC 21 SIN VIAFIRMA --------->
<div class="card-itramits">
  	<div class="card-itramits-body">
      Resolució de concessió amb requeriment (20b)
	</div>
	<div class="card-itramits-footer">
	pre-tramits
		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<span id="btn_20b" class="">
    	<!-- 		<a id="wrapper_informe_sobre_subsanacion" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_resolucion_concesion_con_req_20b');?>" class="btn-primary-itramits">Envia a signar l'informe</a> -->
					<button id="generaResolucioConcesio20b" class='btn btn-primary' onclick="enviaResolucionConcesionConRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
					<div id='infoMissingDataDoc20b' class="alert alert-danger ocultar"></div>
				</span>
				<span id="spinner_20b" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:20px; color:#000000;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
			<?php if ($expedientes['doc_resolucion_concesion_con_req_20b'] !=0) { ?>
        <a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_resolucion_concesion_con_req_20b');?>" target = "_self">La resolució de concessió</a>	
			<?php }?>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>
	function enviaResolucionConcesionConRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true

		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let fecha_REC_enmienda = document.getElementById('fecha_REC_enmienda')
		let fecha_propuesta_resolucion_notif = document.getElementById('fecha_propuesta_resolucion_notif')
		let fecha_de_pago = document.getElementById('fecha_de_pago')
		let fecha_reunion_cierre = document.getElementById('fecha_reunion_cierre')
		let fecha_REC_justificacion = document.getElementById('fecha_REC_justificacion')
		let ref_REC_justificacion = document.getElementById('ref_REC_justificacion')
		let fecha_not_liquidacion = document.getElementById('fecha_not_liquidacion')

		let generaResolucioConcesio20b = document.getElementById('generaResolucioConcesio20b')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_20b = document.getElementById('spinner_20b')
		let infoMissingDataDoc20b = document.getElementById('infoMissingDataDoc20b')
		infoMissingDataDoc20b.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
		if(!fecha_REC_enmienda.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Data REC esmena<br>"
			todoBien = false
		}
		if(!fecha_propuesta_resolucion_notif.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Data notificació proposta resolució<br>"
			todoBien = false
		}
		if(!fecha_de_pago.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Data pagament<br>"
			todoBien = false
		}
		if(!fecha_reunion_cierre.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Data reunió tancament<br>"
			todoBien = false
		}
		if(!fecha_REC_justificacion.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Data REC justificació<br>"
			todoBien = false
		}
		if(!ref_REC_justificacion.value) {
			infoMissingDataDoc20b.innerHTML = infoMissingDataDoc20b.innerHTML + "Referència REC justificació<br>"
			todoBien = false
		}
		alert ("Data notificació requeriment???")
		alert ("Data firma informe situació post esmena???")

		if (todoBien) {
			infoMissingDataDoc20b.classList.add('ocultar')
			generaResolucioConcesio20b.disabled = true
			generaResolucioConcesio20b.innerHTML = "Generant ..."
			spinner_20b.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_resolucion_concesion_con_req_20b'
		} else {
			infoMissingDataDoc20b.classList.remove('ocultar')
		}
	}

</script>