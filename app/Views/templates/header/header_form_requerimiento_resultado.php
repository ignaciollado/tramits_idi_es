<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?php echo lang('message_lang.titulo_justificacion_idigital');?></title>
	<meta name="description" content="Requeriment informació adicional per a les ajuts de xecs de consultoria">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"> 
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://use.fontawesome.com/5db4446d08.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> 	
	<link rel="icon" type="image/jpg" href="/public/assets/images/headeridi.jpg" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>
	<script type="text/javascript" src="/public/assets/js/pindust.js"></script>	
	<script type="text/javascript" src="/public/assets/js/comprueba-CIF.js"></script>
	<script type="text/javascript" src="/public/assets/js/solicitud-idigital.js"></script>		
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
		<li class="logo"><a href="http://www.adrbalears.es" target="_self"><img height = "54" alt ="ADR Balears Logo" title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)"
																					alt = "<?php echo lang('message_lang.titulo_justificacion_idigital');?>"
																					src = "<?php echo base_url()."/public/assets/images/ADRBalears-conselleria.jpg";?>" ></a>
			</li>
			<li>
			<h2><?php echo lang('message_lang.titulo_justificacion_idigital');?></h2>
			</li>
		</ul>
	</div>	
</header>