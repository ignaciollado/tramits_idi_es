<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title>
			<?php if ($tipoTramite == "IDI-ISBA") {?>
				<?php echo lang('message_lang.titulo_solicitud_idi_isba');?>
			<?php } else { ?>
				<?php echo lang('message_lang.titulo_justificacion_idigital');?>
			<?php } ?>
	</title>
	<meta name="description" content="Requeriment informació adicional">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="/public/assets/images/adr-balears.png" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://use.fontawesome.com/5db4446d08.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<script type="text/javascript" src="/public/assets/js/solicitud-ayuda.js"></script>		
</head>
<body>
<?php

use App\Models\ConfiguracionModel;
use App\Models\ExpedientesModel;
$modelConfig = new ConfiguracionModel();
$modelExp = new ExpedientesModel();
$db = \Config\Database::connect();
	
$uri = new \CodeIgniter\HTTP\URI();
$request = \Config\Services::request();

$data['expedientes'] = $modelExp->where('id', $id)->first();
?>
<!-- HEADER: MENU + HEROE SECTION -->
<header>
	<div class="menu">
		<ul>
			<li class="logo"><a href="http://www.adrbalears.es" target="_self"><img height = "64" title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)"
						alt = "<?php echo lang('message_lang.titulo_justificacion_idigital');?>"
						src = "<?php echo base_url()."/public/assets/images/adr-balears.png";?>" >
			</li>
			<li>
			<?php if ($tipoTramite == "IDI-ISBA") {?>
				<h2><?php echo lang('message_lang.titulo_solicitud_idi_isba');?></h2>
			<?php } else { ?>
				<h2><?php echo lang('message_lang.titulo_justificacion_idigital');?></h2>
			<?php } ?>
			</li>
		</ul>
	</div>	
  <div class="p-2 bg-white text-center">
		<div class="btn-group" role="group" aria-label="lang toggle">
			<a href="<?php echo base_url('/public/index.php/home/set_lang_justific/ca/').'/'.$id.'/'.$nif.'/'.$tipoTramite; ?>" class="btn btn-outline-primary" role="button"> Català</a>
			<a href="<?php echo base_url('/public/index.php/home/set_lang_justific/es/').'/'.$id.'/'.$nif.'/'.$tipoTramite; ?>" class="btn btn-outline-primary" role="button"> Castellano</a>
		</div>
  </div>
</header>
<div id="container">