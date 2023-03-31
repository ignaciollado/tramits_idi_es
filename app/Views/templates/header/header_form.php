<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?php echo lang('message_lang.titulo_sol_form');?></title>
	<meta name="description" content="Sol·licitud d'ajuts i de subvencions">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">  -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://use.fontawesome.com/5db4446d08.js"></script>

<!-- Latest compiled JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> 	 -->
	
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
				<img class="logo" alt="logo" title="logo" src="<?php echo base_url() ."/public/assets/images/logo_institut_dinnovacio_empresarial_col_horitz.jpg";?>" />
			</a>
		</div>
		<div>
		<?php
	use App\Models\ConfiguracionModel;
	$modelConfig = new ConfiguracionModel();
	//$db = \Config\Database::connect();
	$data['configuracion'] = $modelConfig->where('convocatoria_activa', true)->first();	
	?>

    <fieldset>
		<h4><?php echo lang('message_lang.destino_solicitud');?>: <strong><?php echo lang('message_lang.idi');?></strong></h4>
		<h4><?php echo lang('message_lang.codigo_dir3');?> <strong><?php echo $data['configuracion']['emisorDIR3'];?></strong></h4>
		<h4><?php echo lang('message_lang.codigo_sia');?> <strong><?php echo $data['configuracion']['codigoSIA'];?></strong></h4>
		<h4><?php echo lang('message_lang.convocatoria_sol_idigital');?>: <strong><?php echo $data['configuracion']['convocatoria'];?></strong></h4>
	</fieldset> 
		</div>
	</div>
  <!--<div class="p-2 bg-white text-center">
	<div class="btn-group">
	<a href="<?php echo base_url('/public/index.php/home/set_lang/ca'); ?>" class="btn btn-outline-light text-dark" role="button"> Català</a>
	<a href="<?php echo base_url('/public/index.php/home/set_lang/es'); ?>" class="btn btn-outline-light text-dark" role="button"> Castellano</a>
	</div>
  </div>-->
</header>
</section>