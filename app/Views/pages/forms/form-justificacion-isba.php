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
	$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('XECS', $data['configuracion']['convocatoria']);
	$data['expedientes'] = $modelExp->where('id', $id)->first();
?>

<section>
  <fieldset class="alert alert-info">
		<h5><?php echo lang('message_lang.justificacion_doc');?>: <strong><?php echo lang('message_lang.justificacion_titulo');?></strong></h5>
		<h5><?php echo lang('message_lang.justificacion_exp');?>:  <?php echo $data['expedientes']['idExp'];?> / <?php echo $data['expedientes']['convocatoria'];?></h5>
		<h5>Núm. REC GOIB: <?php echo $data['expedientes']['ref_REC'];?></h5>
		<h5><?php echo lang('message_lang.destino_solicitud');?>: <?php echo lang('message_lang.idi');?></h5>
		<h5><?php echo lang('message_lang.codigo_dir3');?> <?php echo $data['configuracion']['emisorDIR3'];?></h5>
		<h5><?php echo lang('message_lang.codigo_sia');?>: <?php echo $data['configuracionLinea']['codigoSIA'];?></h5>
  </fieldset> 

	<?php echo lang('message_lang.intro_sol_idigital');?>

<form action="<?php echo base_url('/public/index.php/expedientes/do_justificacion_upload_isba/'.$data['expedientes']['id'].'/'.$data['expedientes']['nif'].'/'.$data['expedientes']['tipo_tramite'].'/'.$data['expedientes']['convocatoria'].'/'. $idioma);?>" name="form_justificacion" id="form_justificacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type = "hidden" name="id_sol" id="id_sol" value = "<?php echo $data['expedientes']['id'];?>">

	<fieldset>
		<h4><?php echo lang('message_lang.solicitante');?>
			<span><strong><?php echo $data['expedientes']['empresa'];?></strong></span> <?php echo lang('message_lang.conCIF');?><span><?php echo $data['expedientes']['nif'];?></span>
			<input type = "hidden" title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" readonly placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" class="grid-item-profesor" required minlength = "4" name="empresa" id="empresa" value = "<?php echo $data['expedientes']['empresa'];?>" >
			<input type = "hidden" title="NIF del consultor digital" readonly  placeholder = "NIF" class="grid-item-profesor" required name="nif" id="nif" maxlength = "9" value = "<?php echo $data['expedientes']['nif'];?>">
			<?php echo lang('message_lang.justificacion_declaracion').": ";?>
		</h4>
	</fieldset>

	<div>  
		<fieldset>
			<legend><h4><?php echo lang('message_lang.justificacion_decl_resp_aplicado_fondo_isba');?>:</h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
					<h5>[.pdf]:</h5>
					<div>
						<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_DeclRespAplicadoFondoIsba" name="file_DeclRespAplicadoFondoIsba[]" required size="20" accept=".pdf" multiple />
					</div>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend><h4><?php echo lang('message_lang.justificacion_memoria_actividades_isba');?>:</h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
					<h5>[.pdf]:</h5>
					<div>
						<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_MemoriaActividadesIsba" name="file_MemoriaActividadesIsba[]" required size="20" accept=".pdf" multiple />
					</div>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend><h4><?php echo lang('message_lang.justificacion_facturas_isba');?>:</h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
					<div>
						<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_FacturasEmitidasIsba" name = "file_FacturasEmitidasIsba[]" required size = "20" accept = ".pdf" multiple />
					</div>
				</div>
			</div>
		</fieldset>
		
		<fieldset class="container-add-line">
			<h4><?php echo lang('message_lang.listaEnumerativaDeGastos');?>:</h4>
			<div class="form-floating">
  			<input type="text" class="form-control" id="num-factura" placeholder="Num. factura">
  			<label for="num-factura"><?php echo lang('message_lang.numFactura');?></label>
			</div>
			<div class="form-floating">
  			<input type="date" class="form-control" id="fecha-factura" placeholder="Fecha factura">
  			<label for="fecha-factura"><?php echo lang('message_lang.fechaFactura');?></label>
			</div>
			<div class="form-floating">
  			<input type="text" class="form-control" id="proveedor" placeholder="Proveedor">
  			<label for="proveedor"><?php echo lang('message_lang.proveedor');?></label>
			</div>
			<div class="form-floating">
  			<input type="text" class="form-control" id="concepto" placeholder="Concepto">
  			<label for="concepto"><?php echo lang('message_lang.concepto');?></label>
			</div>
			<div class="form-floating">
  				<input type="number" class="form-control" id="base-imponible" value="0" placeholder="Base imponible">
  				<label for="base-imponible"><?php echo lang('message_lang.baseImponible');?></label>
			</div>
			<div class="form-floating">
  			<input type="number" class="form-control" id="importe-iva" value="0" onblur="setTotalInvoice()" placeholder="Importe IVA">
  			<label for="importe-iva"><?php echo lang('message_lang.importeIVA');?></label>
			</div>
			<div class="form-floating">
  			<input type="number" class="form-control" disabled readonly required id="importe-factura" placeholder="Importe factura">
  			<label for="importe-factura"><?php echo lang('message_lang.importeFactura');?></label>
			</div>
			<div class="form-floating">
  			<input type="date" class="form-control" id="fecha-pago" placeholder="Data pago" oninput="enableSubmitButtons()">
  			<label for="fecha-pago"><?php echo lang('message_lang.fechaPago');?></label>
			</div>
			<div class="submit-button">
			<button type="button" disabled class="btn btn-primary" id="addInvoiceLineBtn" onclick="addInvoiceLine()"><?php echo lang('message_lang.addLine');?></button>
			</div>
		</fieldset>

		<fieldset>
			<div class="container-lines" id="container-lines"></div>
			<input type='hidden' id="invoice-lines" name="invoice-lines">
			<input type='hidden' id="total-invoice-lines" name="total-invoice-lines" value="0">
		</fieldset>

		<fieldset> 
			<legend><h4><?php echo lang('message_lang.justificacion_justificantes_pago_isba');?>:</h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
					<div>
						<input type = "file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_JustificantesPagoIsba" name = "file_JustificantesPagoIsba[]" required size = "20" accept = ".pdf" multiple />
					</div>
				</div>		
			</div>
		</fieldset>

		<fieldset> 
			<legend><h4><?php echo lang('message_lang.justificacion_declaracion_isba');?>:</h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
					<div>
						<input type = "file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_DeclaracionIsba" name = "file_DeclaracionIsba[]" required size = "20" accept = ".pdf" multiple />
					</div>
				</div>		
			</div>
		</fieldset>
		
		<fieldset class="submit-button">
			<button type="submit" disabled class = "btn btn-primary btn-lg" id = "enviar_docs"><?php echo lang('message_lang.enviar_documentacion');?></button>
		</fieldset>
	</div>
</form>
<div class="alert alert-info"> 
	<i class="fa fa-info-circle" style="font-size:24px;color:red;"></i> info
	<span > <?php echo lang('message_lang.upload_multiple');?></span>
</div>

<script>
	$('#form_justificacion').submit(function(){
		if ( $("#file_PlanTransformacionDigital").val().length == 0 && $("#file_FactTransformacionDigital").val().length == 0 && $("#file_PagosTransformacionDigital").val().length == 0)
			{
			alert ("¡Por favor, seleccione algún archivo para enviarnos!");
			return false;
			}
		else {
			let theForm=document.getElementById("form_justificacion");
			theForm.style.cursor="progress";
  			theForm.disabled = true;
  			theForm.style.opacity =".2";
			$("#enviar_docs", this)
				.html("Enviant, un moment per favor ...")
				.attr('disabled', 'disabled')
				.css("background-color","orange");			
		}
	});
</script>

<div id="myModal" class="modal fade" role="dialog">
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