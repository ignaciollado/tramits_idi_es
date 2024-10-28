<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/public/assets/css/ils.css"/>
	<!-- The form filter area visible -->
<section class='container empresa__detail' onload="window.scroll({top: 0, left: 0, behavior: 'smooth',})">
<?php
    helper('filesystem');
    $request = \Config\Services::request();

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
        <p class="card-text"><?php $row->domicilio;?></p>
        <p class="card-text"><?php echo  $row->telefono;?></p>
        <p class="card-text"><a target="_blank" href="<?php echo "https://". $row->sitio_web_empresa;?>"><?php echo  $row->sitio_web_empresa;?></a></p>
        <p class="card-text"><a target="_blank" href="<?php echo $row->video_empresa;?>"><?php echo  $row->video_empresa;?></a></p>
        <p class="card-text"><?php If ($row->fecha_creacion_empresa != '0000-00-00') {echo  date_format(date_create($row->fecha_creacion_empresa),"d/m/Y");}?></p>
        <p class="card-text"><?php echo  $row->canales_comercializacion_empresa;?></p>
      </div>
    </article>

    <section class="picture-gallery" id="gallery">
      <?php for ($x = 0; $x <= 9; $x++) {;?>
        <div class="card-picture-list">

          <?php if ($row->nif === 'A07166085' || $row->nif === 'A07090707') {?>
            <div class="content">
              <img src="https://docs.tramits.adrbalears.es/writable/gallery-ils/<?php echo  $row->nif.'/'.($x+1).".webp";?>" class="card-img-top" alt="<?php echo  $row->empresa;?>">
            </div>  
            <?php } else {?>
              <img src="https://dummyjson.com/image/520" class="card-img-top" alt="...">
              <div class="card-body">
                <h4>Picture #<?php echo ($x+1);?></h4>
                <p class="card-text">If you send us ten photos of your company, we will publish them in this section.</p>
                <h5>Picture specification needed</h5>
                <ul>
                  <li>Max width: 1320px</li>
                  <li>Max pixels depth: 72 ppp</li>
                  <li>File format: webp</li>
              </ul>
            </div>
          <?php }?>
        </div>
      <?php };?>
    </section>
<?php 
}

} else {
        echo "<div class='alert alert-warning'><strong>De moment,</strong> no s'han trobat empreses adherides a ILS.</div>";
      }
?>

</section>



<script>

var gallery = document.querySelector('#gallery');
var getVal = function (elem, style) { return parseInt(window.getComputedStyle(elem).getPropertyValue(style)); };
var getHeight = function (item) { return item.querySelector('.content').getBoundingClientRect().height; };
var resizeAll = function () {
    var altura = getVal(gallery, 'grid-auto-rows');
    var gap = getVal(gallery, 'grid-row-gap');
    gallery.querySelectorAll('.card-picture-list').forEach(function (item) {
        var el = item;
        el.style.gridRowEnd = "span " + Math.ceil((getHeight(item) + gap) / (altura + gap));
    });
};
gallery.querySelectorAll('img').forEach(function (item) {
    item.classList.add('byebye');
    if (item.complete) {
        console.log(item.src);
    }
    else {
        item.addEventListener('load', function () {
            var altura = getVal(gallery, 'grid-auto-rows');
            var gap = getVal(gallery, 'grid-row-gap');
            var gitem = item.parentElement.parentElement;
            gitem.style.gridRowEnd = "span " + Math.ceil((getHeight(gitem) + gap) / (altura + gap));
            item.classList.remove('byebye');
        });
    }
});
window.addEventListener('resize', resizeAll);
gallery.querySelectorAll('.card-picture-list').forEach(function (item) {
    item.addEventListener('click', function () {        
        item.classList.toggle('full');        
    });
});

</script>

