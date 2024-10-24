<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/public/assets/css/ils.css"/>
	<!-- The form filter area visible -->
<section class='container empresa__detail' onload="">
<?php
    helper('filesystem');
		if ($empresas) {

					 foreach ($empresas as $row) {
?>

    <article class='card card--detail card--hiden' id="card">
      <picture>
        <source srcset="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$row->name.'/'.$row->nif.'/'.$row->selloDeTiempo.'/'.$row->type);?>" type="image/svg+xml">
        <img src="<?php echo base_url('public/index.php/expedientes/muestradocumento/'.$row->name.'/'.$row->nif.'/'.$row->selloDeTiempo.'/'.$row->type);?>" class="img-fluid" alt="...">
      </picture>

      
      <div class="card-body">
        <h2 class="card-title"><?php echo  $row->empresa;?></h2>
        <p class="card-text"><?php echo  $row->nif;?></p>
        <p class="card-text"><?php echo  $row->domicilio;?></p>
        <?php //$domicilio = str_split($row->domicilio, "#");?>
        <p class="card-text"><?php $row->domicilio;?></p>
        <p class="card-text"><?php //echo  $domicilio[1]." (".$domicilio[0].")" ;?></p>
        <p class="card-text"><?php echo  $row->telefono;?></p>
        <p class="card-text"><a target="_blank" href="<?php echo "https://". $row->sitio_web_empresa;?>"><?php echo  $row->sitio_web_empresa;?></a></p>
        <p class="card-text"><a target="_blank" href="<?php echo $row->video_empresa;?>"><?php echo  $row->video_empresa;?></a></p>
        <p class="card-text"><?php If ($row->fecha_creacion_empresa != '0000-00-00') {echo  date_format(date_create($row->fecha_creacion_empresa),"d/m/Y");}?></p>
        <p class="card-text"><?php echo  $row->canales_comercializacion_empresa;?></p>
      </div>
    </article>

    <h1>Our Picture gallery</h1>
    <section class="picture-gallery">
      <?php for ($x = 0; $x <= 9; $x++) {;?>
        <div class="card card-picture-list">

          <?php if ($row->nif === 'A07166085' || $row->nif === 'A07090707') {?>
              <img src="https://docs.tramits.adrbalears.es/writable/gallery-ils/<?php echo  $row->nif.'/'.($x+1).".jpg";?>" class="card-img-top" alt="<?php echo  $row->empresa;?>">
              <div class="card-body">
              </div>
            <?php } else {?>
              <img src="https://dummyjson.com/image/520" class="card-img-top" alt="...">
              <div class="card-body">
                <h4>Picture #<?php echo ($x+1);?></h4>
                <p class="card-text">If you send us ten photos of your company, we will publish them in this section.</p>
                <h5>Picture specification needed</h5>
                <ul>
                  <li>Max width: 1320px</li>
                  <li>Pixels depth: 72 ppp</li>
                  <li>File format: webp or jpg</li>
              </ul>
            </div>
          <?php }?>
        </div>
      <?php };?>
    </section>

  <!-- <div class="card" aria-hidden="true" id="cardPlaceHolder">
  <img src="https://via.placeholder.com/450" class="card-img-top" alt="...">
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
    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
  </div>
</div> -->


<?php 
}

} else {
        echo "<div class='alert alert-warning'><strong>De moment,</strong> no s'han trobat empreses adherides a ILS.</div>";
      }
?>

</section>



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

