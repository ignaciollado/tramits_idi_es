<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo lang('message_lang.titulo_sol_form');?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  	<link rel="icon" type="image/jpg" href="/public/assets/images/headeridi.jpg" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>
</head>
<body>
<div style ="margin-top:150px;"></div>
<div class="container">
  <div class="jumbotron">
    <h1>Nota informativa</h1>      
    
    <div class="alert alert-warning">
  <h1><?php echo $aviso;?></h1>
</div>
<div style="text-align:center;">
    <a href="https://www.idi.es"><img width="50%" src="/public/assets/images/logo_institut_dinnovacio_empresarial_col_horitz.jpg" title="Institut d'Innovació Empresrial de les Illes Balears" alt="Institut d'Innovació Empresrial de les Illes Balears"/></a>
</div>

  </div>   
</div>


<div style ="margin-top:150px;"></div>


<a href="<?php echo $urls;?>"><i class="fas fa-dragon" title="Animales exóticos"></i><img src="<?php echo $image_src;?>" alt="<?php echo $titulo;?>" title="<?php echo $titulo;?>" alt="<?php echo $titulo;?>"/></a>