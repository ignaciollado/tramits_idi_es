<link rel="stylesheet" type="text/css" href="/public/assets/css/form-adhesion-ils.css"/>

<!-- CONTENT -->
<?php
	helper('cookie');
	use App\Models\ConfiguracionModel;
	use App\Models\ExpedientesModel;
	use App\Models\ConfiguracionLineaModel;
	
	$db = \Config\Database::connect();
	
	$uri = new \CodeIgniter\HTTP\URI();
	$request = \Config\Services::request();

	$language = \Config\Services::language();
	$language->setLocale($idioma);

	$configuracion = new ConfiguracionModel();
	$configuracionLinea = new ConfiguracionLineaModel();
	$modelExp = new ExpedientesModel();

	$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
	$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('ILS', $data['configuracion']['convocatoria']);
	$data['expedientes'] = $modelExp->where('id', $id)->first();
?>

<section>
	<h3><?php echo lang('message_lang.intro_renovacion_marca_ils');?></h3>
	<fieldset class="alert alert-info">
		<h5><?php echo lang('message_lang.justificacion_doc');?>: <strong><?php echo lang('message_lang.renovacion_marca_ils');?></strong></h5>
		<h5><?php echo lang('message_lang.justificacion_exp');?>:  <?php echo $data['expedientes']['idExp'];?> / <?php echo $data['expedientes']['convocatoria'];?></h5>
		<h5>Núm. REC GOIB: <?php echo $data['expedientes']['ref_REC'];?></h5>
		<h5><?php echo lang('message_lang.destino_solicitud');?>: <?php echo lang('message_lang.idi');?></h5>
		<h5><?php echo lang('message_lang.codigo_dir3');?> <?php echo $data['configuracion']['emisorDIR3'];?></h5>
		<h5><?php echo lang('message_lang.codigo_sia');?>: <?php echo $data['configuracionLinea']['codigoSIA'];?></h5>
  </fieldset> 

<form onsubmit="justificacionILSSubmit()" action="<?php echo base_url('/public/index.php/expedientes/do_renovacion_ils_upload/'.$data['expedientes']['id'].'/'.$data['expedientes']['nif'].'/'.$data['expedientes']['tipo_tramite'].'/'.$data['expedientes']['convocatoria'].'/'. $idioma);?>" name="form_justificacion_ils" id="form_justificacion_ils" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type = "hidden" name="id_sol" id="id_sol" value = "<?php echo $data['expedientes']['id'];?>">
	<fieldset>
		<h4><?php echo lang('message_lang.solicitante');?>
			<span><strong><?php echo $data['expedientes']['empresa'];?></strong></span> <?php echo lang('message_lang.conCIF');?><span><strong><?php echo $data['expedientes']['nif'];?></strong></span>
			<input type = "hidden" readonly class="grid-item-profesor" required minlength = "4" name="empresa" id="empresa" value = "<?php echo $data['expedientes']['empresa'];?>" >
			<input type = "hidden" readonly class="grid-item-profesor" required name="nif" id="nif" maxlength = "9" value = "<?php echo $data['expedientes']['nif'];?>">
			<?php echo lang('message_lang.renovacion_marca_ils_declaracion').": ";?>
		</h4>
	</fieldset>
 
	<fieldset>
		<h4><?php echo lang('message_lang.justificacion_informe_calculo');?>:</h4>
		<input  type="checkbox" class="form-check-input" id="politica-privacidad" onchange="adrBalearsTieneInformes(this)">
		<?php if (get_cookie('CurrentLanguage') === 'es') {?>
    	<label class="form-check-label" for="adr-balears-tiene-informes">Marcad si la ADR Balears ya dispone de los informes</label>
		<?php } else {;?>
			<label class="form-check-label" for="adr-balears-tiene-informes">Marcau si l'ADR Balears ja disposa dels informes</label>
		<?php };?>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
					<h5>[.pdf]:</h5>
					<div>
						<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_JustificacionInformeCalculo" name="file_JustificacionInformeCalculo[]" required size="20" accept=".pdf" multiple />
					</div>
				</div>
			</div>
	</fieldset>

	<fieldset>
		<h4><?php echo lang('message_lang.justificacion_comprimiso_reduccion');?>:</h4>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
					<div>
						<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_CompromisoReduccion" name = "file_CompromisoReduccion[]" required size = "20" accept = ".pdf" multiple />
					</div>
				</div>
			</div>
	</fieldset>

	<fieldset class="submit-button">
		<button type="submit" disabled class = "btn btn-primary btn-lg" id = "enviar_docs"><?php echo lang('message_lang.enviar_documentacion');?></button>
    <input  type="checkbox" class="form-check-input" id="politica-privacidad" onchange="changeSubmitState(this)">
		<?php if (get_cookie('CurrentLanguage') === 'es') {?>
    	<label class="form-check-label" for="politica-privacidad"> <a href='https://www.adrbalears.es/politica-de-privacidad/2777' target="_blank">He leído y acepto la política de privacidad de ADR Balears</a></label>
		<?php } else {;?>
			<label class="form-check-label" for="politica-privacidad"> <a href='https://www.adrbalears.es/politica-de-privacidad/2776' target="_blank">He llegit i accepto la política de privacitat de ADR Balears</a></label>
		<?php };?>
	</fieldset>
</form>
<div class="alert alert-info"> 
	<i class="fa fa-info-circle" style="font-size:24px;color:red;"></i> info
	<span > <?php echo lang('message_lang.upload_multiple');?></span>
</div>

<script>
	function adrBalearsTieneInformes (element) {
		let uploadReports = document.getElementById('file_JustificacionInformeCalculo')
		uploadReports.disabled = element.checked
	}
	function changeSubmitState (element) {
		let submitButton = document.getElementById('enviar_docs')
		submitButton.disabled = !element.checked
	}

  function justificacionILSSubmit() {
	let theForm = document.getElementById("form_justificacion_ils");
	theForm.style.cursor="progress";
  theForm.disabled = true;
  theForm.style.opacity =".2";
	$("#enviar_docs", this)
			.html("Enviant, un moment per favor ...")
			.attr('disabled', 'disabled')
			.css("background-color","orange");
  }
</script>
</section>