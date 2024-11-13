<?php 
  use App\Models\ExpedientesModel;
  $modelExp = new ExpedientesModel();
  $totalexpedAZero = "<span class='badge bg-secondary'>".$modelExp->getWithZeroIdSol()."</span>";
?>
<!-- CONTENT -->
<input type="hidden" name="updateInterval" class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">
<script type="text/javascript" src="/public/assets/js/content.js"></script>
<div class="container">

<!-----------------------------------------------------CHEQUES---------------------------------------------------------------->
<!------------------------------------------------------2024------------------------------------------------------------------>
<button class="accordion accordion--convo"><h1>Xecs consultoria</h1></button>
<div class="row">
  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="accordion" id="accordeonConvo2024">
      <div class="btn btn-primary position-relative"><h5 class="card-title">Línia 2024 Xecs consultoria</h5><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalSolicitudesXecs2024">0</span></div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePI2024" aria-expanded="true" aria-controls="collapsePI2024">Programa I (iDigital)</button>
        </h2>
        <div id="collapsePI2024" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2024');?>">
            <strong>«IDigital»</strong>, estratègia per impulsar la digitalització en la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesINoREC_2024">0</span>              
              <span class="badge bg-primary" id="totalPendienteI_2024">0</span>
              <span class="badge bg-secondary" id="totalInicioConsultoriaI_2024">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasI_2024">0</span>
              <span class="badge text-bg-success" id="importeConcedidoI_2024">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2024');?>">            
            <strong>«IExporta»</strong>, estratègia per impulsar la internacionalització de les empreses industrials de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIINoREC_2024">0</span>
              <span class="badge bg-primary" id="totalPendienteII_2024">0</span>
              <span class="badge bg-secondary" id="totalInicioConsultoriaII_2024">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasII_2024">0</span>
              <span class="badge text-bg-success" id="importeConcedidoII_2024">0.00</span>
            </li></ul>
          
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Programa III (iSostenibilitat)</button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">           
            <strong>«ISostenibilitat»</strong>, estratègia per impulsar la millora de la sostenibilitat de la indústria de les Illes Balears.<br>
            <ul>
            <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III actuacions corporatives/2024');?>">               
              <li>Identificació i càlcul de les emissions de gasos amb efecte d'hivernacle de l'organització.</a><br>
                  <span class="badge text-bg-warning" id="totalSolicitudesIIINoREC_org_2024">0</span>
                  <span class="badge bg-primary" id="totalPendienteIII_org_2024">0</span>
                  <span class="badge bg-secondary" id="totalInicioConsultoriaIII_org_2024">0</span>
                  <span class="badge text-bg-success" id="totalSolicitudesFinalizadasIII_org_2024">0</span>
                  <span class="badge text-bg-success" id="importeConcedidoIII_org_2024">0.00</span>
              </li>
            
            <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III actuacions producte/2024');?>">               
              <li>Identificació i càlcul de les emissions de gasos d'efecte d'hivernacle de producte. </a><br>
                  <span class="badge text-bg-warning" id="totalSolicitudesIIINoREC_prod_2024">0</span>
                  <span class="badge bg-primary" id="totalPendienteIII_prod_2024">0</span>
                  <span class="badge bg-secondary" id="totalInicioConsultoriaIII_prod_2024">0</span>
                  <span class="badge text-bg-success" id="totalSolicitudesFinalizadasIII_prod_2024">0</span>
                  <span class="badge text-bg-success" id="importeConcedidoIII_prod_2024">0.00</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Programa IV (iGestió)</button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa IV/2024');?>">              
            <strong>«IGestió»</strong>, estratègia per impulsar la implantació d'eines de gestió avançada i optimització de processos de la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIVNoREC_2024">0</span>
              <span class="badge bg-primary" id="totalPendienteIV_2024">0</span>
              <span class="badge bg-secondary" id="totalInicioConsultoriaIV_2024">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasIV_2024">0</span>
              <span class="badge text-bg-success" id="importeConcedidoIV_2024">0.00</span>
            </li></ul>
          
          </div>
        </div>
      </div>
    </div>
  </div> 

  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="accordion" id="accordeonConvo2023">
    <div class="btn btn-primary position-relative"><h5 class="card-title">Línia 2023 Xecs consultoria</h5><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalSolicitudesXecs2023">0</span></div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2023PI" aria-expanded="true" aria-controls="collapse2023PI">Programa I (iDigital)</button>
        </h2>
        <div id="collapse2023PI" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2023');?>">
            <strong>«IDigital»</strong>, estratègia per impulsar la digitalització en la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesINoREC_2023">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasI_2023">0</span>
              <span class="badge text-bg-success" id="importeConcedidoI_2023">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2023');?>">            
            <strong>«IExporta»</strong>, estratègia per impulsar la internacionalització de les empreses industrials de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIINoREC_2023">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasII_2023">0</span>
              <span class="badge text-bg-success" id="importeConcedidoII_2023">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2023');?>">            
            <strong>«ISostenibilitat»</strong>, estratègia per impulsar la millora de la sostenibilitat de la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIIINoREC_2023">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasIII_2023">0</span>
              <span class="badge text-bg-success" id="importeConcedidoIII_2023">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="accordion" id="accordeonConvo2022">
    <div class="btn btn-primary position-relative"><h5 class="card-title">Línia 2022 Xecs consultoria</h5><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalSolicitudesXecs2022">0</span></div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2022PI" aria-expanded="true" aria-controls="collapse2022PI">Programa I (iDigital)</button>
        </h2>
        <div id="collapse2022PI" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2022');?>">
            <strong>«IDigital»</strong>, estratègia per impulsar la digitalització en la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesINoREC_2022">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasI_2022">0</span>
              <span class="badge text-bg-success" id="importeConcedidoI_2022">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2022');?>">            
            <strong>«IExporta»</strong>, estratègia per impulsar la internacionalització de les empreses industrials de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIINoREC_2022">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasII_2022">0</span>
              <span class="badge text-bg-success" id="importeConcedidoII_2022">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2022');?>">            
            <strong>«ISostenibilitat»</strong>, estratègia per impulsar la millora de la sostenibilitat de la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIIINoREC_2022">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasIII_2022">0</span>
              <span class="badge text-bg-success" id="importeConcedidoIII_2022">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>      
      
    </div>
  </div>

  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="accordion" id="accordeonConvo2021">
    <div class="btn btn-primary position-relative"><h5 class="card-title">Línia 2021 Xecs consultoria</h5><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalSolicitudesXecs2021">0</span></div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Programa I (iDigital)</button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2021');?>">
            <strong>«IDigital»</strong>, estratègia per impulsar la digitalització en la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesINoREC_2021">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasI_2021">0</span>
              <span class="badge text-bg-success" id="importeConcedidoI_2021">0.00</span>
            </li></ul>
          
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2021');?>">            
            <strong>«IExporta»</strong>, estratègia per impulsar la internacionalització de les empreses industrials de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIINoREC_2021">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasII_2021">0</span>
              <span class="badge text-bg-success" id="importeConcedidoII_2021">0.00</span>
            </li></ul>
          
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2021');?>">            
            <strong>«ISostenibilitat»</strong>, estratègia per impulsar la millora de la sostenibilitat de la indústria de les Illes Balears.</a><br>
            <ul><li>
              <span class="badge text-bg-warning" id="totalSolicitudesIIINoREC_2021">0</span>
              <span class="badge text-bg-success" id="totalSolicitudesFinalizadasIII_2021">0</span>
              <span class="badge text-bg-success" id="importeConcedidoIII_2021">0.00</span>
            </li></ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------2020------------------------------------------------------------------>
<!-- <button class="accordion accordion--convo"><h1>Convocatòria 2020</h1></button>
  <div class="panel">
    <section id="sectioniDigital2020">
	    <h2 id="iDigital2020" onclick="listPrograma('2020', 'iDigital 2020')">iDigital 2020</h2>
      <pre><code><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/iDigital 2020/2020');?>" target="_self">Consultar les sol·licituds</a></code></pre>
      <div><span id="totaliDigital_2020"></span> <span id="importeTotaliDigital_2020"></span> <span id="importeConcedidoiDigital_2020"></span></div>
    </section>
  </div> -->

<!---------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------ILS---------------------------------------------------------------->  
<button class="accordion accordion--convo"><h1>Marca ILS</h1></button>
<div class="accordion" id="accordionILS">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseILS" aria-expanded="true" aria-controls="collapseILS">
        <div class="btn btn-primary position-relative"><h5 class="card-title">Línia ILS</h5><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalSolicitudesILS">0</span></div>
      </button>
    </h2>
    <div id="collapseILS" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionILS">
      <section id="sectionILS">
        <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/ILS');?>" target="_self">Expedients</a></h2>
        <fieldset>
          <div>
            <span id="totalSolicitudesAdrIsba"></span>
            <span id="importeTotalAdrIsba"></span>
            <span id="importeConcedidoAdrIsba"></span>
          </div>
          <div>
              <span id="totalSolicitudesAdrIsbaNoREC_2022"></span>
              <span id="totalSolicitudesAdrIsbaPendientes_2022"></span>
              <span id="totalSolicitudesAdrIsbaDenegadas_2022"></span>
              <span id="totalSolicitudesAdrIsbaAdheridas_2022"></span>
          </div>
        </fieldset>
        </section>
    </div>
  </div>
</div>
<!------------------------------------------------------IDI-ISBA-------------------------------------------------------------->  
<button class="accordion accordion--convo"><h1>IB Avals Indústria</h1></button>
<div class="accordion" id="accordionISBA">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseISBA" aria-expanded="true" aria-controls="collapseISBA">
          <div class="btn btn-primary position-relative"><h5 class="card-title">Línia ADR-ISBA</h5><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalSolicitudesISBA">0</span></div>
        </button>
      </h2>
      <div id="collapseISBA" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionISBA">
        <section id="sectionISBA">
          <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/ADR-ISBA/');?>" target="_self">Expedients</a></h2>
          <fieldset>
            <div>
              <span id="totalSolicitudesAdrIsba"></span>
              <span id="importeTotalAdrIsba"></span>
              <span id="importeConcedidoAdrIsba"></span>
            </div>
            <div>
              <span id="totalSolicitudesAdrIsbaNoREC_2022"></span>
              <span id="totalSolicitudesAdrIsbaPendientes_2022"></span>
              <span id="totalSolicitudesAdrIsbaDenegadas_2022"></span>
              <span id="totalSolicitudesAdrIsbaAdheridas_2022"></span>
            </div>
          </fieldset>
        </section>
      </div>
    </div>
  </div>
</div>  
<!-------------------------------------------------------------------------------------------------------------------------->


<script>
  var acc = document.getElementsByClassName("accordion");
  var i;
  console.log("Acordeones home: " + acc.length +"--")
  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>