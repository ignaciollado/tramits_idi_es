<!----------------------------------------- Resolució denegació amb requeriment SIN VIAFIRMA-->
<div class="card-itramits">
	<div class="card-itramits-body">
		Resolució de denegació <strong>amb</strong> requeriment
	</div>
	<div class="card-itramits-footer">

		<?php
		if (!$esAdmin && !$esConvoActual) { ?>
		<?php } else { ?>
			<a id="generadoc_res_denegacion_con_req" href="<?php echo base_url('public/index.php/expedientes/generainformeILS/' . $id . '/' . $convocatoria . '/' . $programa . '/' . $nifcif . '/doc_res_denegacion_con_req_ils'); ?>"><i title="Generar la resolució" class="fa-solid fa-file-pdf fa-2xl" style="color: #365446;"></i></a>
			<span id="spinner_12" class="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#cbebe9;"></i></span>
		<?php } ?>

	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_denegacion_con_req_ils'] != 0) { ?>
			<a href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_denegacion_con_req_ils');?>" target = "_self"><div class = 'btn btn-ver-itramits'><i class='fa fa-check'></i>La resolució de denegació</div></a>

		<?php } ?>
		<?php //} else {
		?>
		<?php //}
		?>
	</div>
</div>
<!------------------------------------------------------------------------------------------------------>