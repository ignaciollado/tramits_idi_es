<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?php echo lang('message_lang.titulo_sol_form');?></title>
	<meta name="description" content="Sol·licitud d'ajuts i de subvencions">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://use.fontawesome.com/5db4446d08.js"></script>

<!-- Latest compiled JavaScript -->
	<link rel="icon" type="image/jpg" href="/public/assets/images/headeridi.jpg" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>	
</head>
<body>
<section>
<!-- HEADER: MENU + HEROE SECTION -->
<header>
	<div class="menu">
		<div>
			<a href="http://www.idi.es" target="_blank">
				<img class="logo" alt="logo" title="logo" src="<?php echo base_url() ."/public/assets/images/logo_idi_conselleria.png";?>" />
			</a>
		</div>
		<div>
		<?php
	?>

    <fieldset>
		<h4><?php echo lang('message_lang.destino_solicitud');?>: <strong><?php echo lang('message_lang.idi');?></strong></h4>
		<h4><?php echo lang('message_lang.codigo_dir3');?> <strong><?php echo $configuracion['emisorDIR3'];?></strong></h4>
		<h4><?php echo lang('message_lang.codigo_sia');?> <strong><?php echo $configuracionLinea['codigoSIA'];?></strong></h4>
		<h4><?php echo lang('message_lang.convocatoria_sol_idigital');?>: <strong><?php echo $configuracionLinea['convocatoria'];?></strong></h4>
	</fieldset> 
		</div>
	</div>
</header>
</section>