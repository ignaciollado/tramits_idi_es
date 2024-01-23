<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $titulo.": ";?><?php echo lang('message_lang.titulo_sol_form');?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
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
      <h2><?php echo $activatedLine;?></h2>
    </div>
    <div style="text-align:center;">
      <a href="https://www.idi.es"><img width="50%" src="/public/assets/images/logo_idi_conselleria.jpg" 
      title="Institut d'Innovació Empresrial de les Illes Balears"
      alt="Institut d'Innovació Empresrial de les Illes Balears"/></a>
    </div>
  </div>   
</div>


<div style ="margin-top:150px;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>