<link rel="stylesheet" type="text/css" href="/public/assets/css/form-adhesion-ils.css"/>

<!-- CONTENT -->
<?php 
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
  <fieldset class="alert alert-info">
		<h5><?php echo lang('message_lang.justificacion_doc');?>: <strong><?php echo lang('message_lang.renovacion_marca_ils');?></strong></h5>
		<h5><?php echo lang('message_lang.justificacion_exp');?>:  <?php echo $data['expedientes']['idExp'];?> / <?php echo $data['expedientes']['convocatoria'];?></h5>
		<h5>Núm. REC GOIB: <?php echo $data['expedientes']['ref_REC'];?></h5>
		<h5><?php echo lang('message_lang.destino_solicitud');?>: <?php echo lang('message_lang.idi');?></h5>
		<h5><?php echo lang('message_lang.codigo_dir3');?> <?php echo $data['configuracion']['emisorDIR3'];?></h5>
		<h5><?php echo lang('message_lang.codigo_sia');?>: <?php echo $data['configuracionLinea']['codigoSIA'];?></h5>
  </fieldset> 

	<?php echo lang('message_lang.intro_renovacion_marca_ils');?>

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
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
    <label class="form-check-label" for="flexCheckChecked">Checked checkbox</label>
  </div>
		<button type="submit" class = "btn btn-primary btn-lg" id = "enviar_docs"><?php echo lang('message_lang.enviar_documentacion');?></button>
	</fieldset>
</form>
<div class="alert alert-info"> 
	<i class="fa fa-info-circle" style="font-size:24px;color:red;"></i> info
	<span > <?php echo lang('message_lang.upload_multiple');?></span>
</div>

<script>
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

<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
				<h4 class="modal-title"><?php echo lang('message_lang.clausula_idi');?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div><span style='font-size:8pt'><span style='font-family:Trebuchet\ MS,Default\ Sans\ Serif,Verdana,Arial,Helvetica,sans-serif'>
				<?php echo lang('message_lang.rgpd_txt');?>
      	</span></div>
      	<div class="modal-footer">
        	<button type = "button" id = "documentacion_justificacion" class = "btn btn-default" data-dismiss="modal"><?php echo lang('message_lang.cierra');?></button>
      	</div>
    	</div>
  	</div>
	</div>
</div>
</section>