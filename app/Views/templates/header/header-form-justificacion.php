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
	<link rel="shortcut icon" type="image/jpg" href="/public/assets/images/headeridi.jpg" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"> 
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="https://use.fontawesome.com/5db4446d08.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> 	
	
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<!--<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>-->
	<!-- <script type="text/javascript" src="/public/assets/js/pindust.js"></script>	 -->
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

	//$data['configuracion'] = $modelConfig->where('tipo_tramite', 'iDigital')->first();	
	$data['expedientes'] = $modelExp->where('id', $id)->first();
?>
<!-- HEADER: MENU + HEROE SECTION -->
<header>

	<div class="menu">
		<ul>
			<li class="logo"><a href="http://www.idi.es" target="_self"><img height = "54" title="IDI Logo"
																					alt = "<?php echo lang('message_lang.titulo_justificacion_idigital');?>"
																					src = "<?php echo base_url()."/public/assets/images/logo_idi_conselleria.jpg";?>" >
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
	<div class="btn-group">
		<a href="<?php echo base_url('/public/index.php/home/set_lang_justific/ca/').'/'.$id.'/'.$nif.'/'.$tipoTramite; ?>" class="btn btn-outline-light text-dark" role="button"> Català</a>
		<a href="<?php echo base_url('/public/index.php/home/set_lang_justific/es/').'/'.$id.'/'.$nif.'/'.$tipoTramite; ?>" class="btn btn-outline-light text-dark" role="button"> Castellano</a>
	</div>
  </div>
</header>
<div id="container">