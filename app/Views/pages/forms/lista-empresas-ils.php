<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/public/assets/css/ils.css"/>	


	<!-- The form filter area visible -->
<section class='container card__empresas' onload="hidePlaceHolder()">
<?php

		if ($empresas) {

					 foreach ($empresas as $row) {
?>

    <article class='card card--hidden' id="card">
        <div class="card-body">
          <a href="<?php echo base_url('/public/index.php/home/empresas_adheridas_ils_detail/'.$row->id);?>" class="btn btn-primary">+ info</a>
          <h5 class="card-title"><?php echo  $row->empresa;?></h5>
          <span class="card-text"><?php echo  $row->nif;?></span>
          <a target="a_blank" href="https://<?php echo $row->sitio_web_empresa;?>" title="Visita el seu lloc web">
            <img class="img-thumbnail card-logo" src="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$row->name.'/'.$row->nif.'/'.$row->selloDeTiempo.'/'.$row->type);?>" class="card-img-top" alt="<?php echo  $row->empresa;?>">
          </a>
        </div>
    </article>

    <div class="card" aria-hidden="true" id="cardPlaceHolder">
    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-3"></a>
      <div class="card-body">
        <h5 class="card-title placeholder-glow">
          <span class="placeholder col-6"></span>
        </h5>
        <p class="card-text placeholder-glow">
          <span class="placeholder col-7"></span>
          <span class="placeholder col-4"></span>
          <span class="placeholder col-4"></span>
          <span class="placeholder col-6"></span>
          <span class="placeholder col-8"></span>
        </p>
      </div>
      <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
    </div>
   
<?php 
}?>
</section>
<?php } else {
        echo "
        <div class='alert alert-success' role='alert'>
  <h4 class='alert-heading'>Directori d'empreses adherides.</h4>
  <p><strong>Actualment</strong> estem preperant la presentació de les empreses que s'han adherit al programa <strong>ILS</strong>.</p>
  <hr>
  <p class='mb-0'>Per favor, disculpi les molèsties.</p>
</div>
        ";
      }
?>





<script>

/* function hidePlaceHolder() { */

  console.log ("estoy en hide place holder")
  setTimeout(placeHolderOff, 1000);

/* } */

function placeHolderOff() {
  let memberAndrewPlaceHolder = document.querySelectorAll("#cardPlaceHolder")
  let memberAndrew = document.querySelectorAll("#card");


  /* memberAndrewPlaceHolder.style.display = "none"; */
  memberAndrewPlaceHolder.forEach(function( itemHolder ) {
   itemHolder.style.display = "none";
  });

  /* memberAndrew.classList.remove('card--hiden'); */
  memberAndrew.forEach(function( itemCard ) {
    itemCard.classList.remove('card--hiden');
  });
}

</script>

