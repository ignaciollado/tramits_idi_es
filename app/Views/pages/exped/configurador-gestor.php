<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript" src="/public/assets/js/configurador-gestor.js"></script>
<div class="further">
  <div class="container">
  <h3>Terminis :</h3>
     
    <form action="<?php echo base_url('/public/index.php/configuracion/configurador_update');?>" name="edit-configuracion" id="edit-configuracion" method="post" accept-charset="utf-8" onsubmit="guardarFormulario()">
	<div class = "row">	
	<div class="col-md-6">
    <input type="hidden" name="id" min="0" max="60" readonly class="form-control" id="id" value = "<?php echo $configuracion['id'];?>">

<!--         <div class="form-group">
            <label for = "convocatoria_activa" class="main"><?php echo lang('message_lang.convocatoria_activa');?>
			<input title = "<?php echo lang('message_lang.convocatoria_activa');?>" type="checkbox" <?php if($configuracion['convocatoria_activa']) {echo 'checked';}?>  name="convocatoria_activa" id="convocatoria_activa" value="<?php echo $configuracion['convocatoria_activa'];?>" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
        </div> -->
        <div class="form-group">
            <label for="emisorDIR3">Emissor (DIR3):</label>
            <input type="text" maxlength="9" name="emisorDIR3" class="form-control" id="emisorDIR3" value = "<?php echo $configuracion['emisorDIR3'];?>">
        </div>
       <!--  <div class="form-group">
            <label for="codigoSIA">Codi SIA:</label>
            <input type="text" maxlength="7" name="codigoSIA" class="form-control" id="codigoSIA" value = "<?php echo $configuracion['codigoSIA'];?>">
        </div>	       --> 
     <!--    <div class="form-group">
            <label for="programa">Programa:</label>
            <input type="text" name="programa" min="0" max="60" readonly class="form-control" id="programa" value = "<?php echo $configuracion['programa'];?>">
        </div>	 -->
      <!--   <div class="form-group">
            <label for="convocatoria">Convocatòria:</label>
            <input type="number" name="convocatoria" min="2021" max="2030" maxlength = "4" size="4" class="form-control" id="convocatoria" value = "<?php echo $configuracion['convocatoria'];?>">
        </div> -->
       <!--  <div class="form-group">
            <label for="convocatoria">Data límit per tots els programes:</label>
            <input type="date" name="fechaLimiteProgramas" class="form-control" id="fechaLimiteProgramas" value = "<?php echo $configuracion['fechaLimiteProgramas'];?>">
        </div>       -->  
       <!--  <div class="form-group">
            <label for="num_BOIB">Data publicació convocatoria al BOIB:</label>
            <input type="text" name="num_BOIB" maxlength = "50" size="50" class="form-control" id="num_BOIB" value = "<?php echo $configuracion['num_BOIB'];?>">
        </div> -->
        <div class="form-group">
            <label for="respresidente">President de l'IDI:</label>
            <input type="text" required name="respresidente" maxlength = "50" size="50" class="form-control" id="respresidente" value = "<?php echo $configuracion['respresidente'];?>">
        </div>
        <div class="form-group">
            <label for="eMailPresidente">Adreça electrònica President de l'IDI:</label>
            <input type="mail" name="eMailPresidente" maxlength = "100" size="50" class="form-control" id="eMailPresidente" value = "<?php echo $configuracion['eMailPresidente'];?>">
        </div>
        <div class="form-group">
            <label for="directorGeneralPolInd">Directora General:</label>
            <input type="text" required name="directorGeneralPolInd" maxlength = "50" size="50" class="form-control" id="directorGeneralPolInd" value = "<?php echo $configuracion['directorGeneralPolInd'];?>">
        </div>
        <div class="form-group">
            <label for="eMailDGeneral">Adreça electrònica Director General:</label>
            <input type="mail" name="eMailDGeneral" maxlength = "100" size="50" class="form-control" id="eMailDGeneral" value = "<?php echo $configuracion['eMailDGeneral'];?>">
        </div>        
        <div class="form-group">
            <label for="directorGerenteIDI">Directora Gerent:</label>
            <input type="text" required name="directorGerenteIDI" maxlength = "50" size="50" class="form-control" id="directorGerenteIDI" value = "<?php echo $configuracion['directorGerenteIDI'];?>">
        </div>
        <div class="form-group">
            <label for="eMailDGerente">Adreça electrònica Directora Gerent:</label>
            <input type="mail" required name="eMailDGerente" maxlength = "100" size="50" class="form-control" id="eMailDGerente" value = "<?php echo $configuracion['eMailDGerente'];?>">
        </div>     
     <!--    <div class="form-group">
            <label for="num_BOIB_modific">Segona resolució BOIB:</label>
            <input type="text" name="num_BOIB_modific" maxlength = "50" size="50" class="form-control" id="num_BOIB_modific" value = "<?php echo $configuracion['num_BOIB_modific'];?>">
        </div> -->
       <!--  <div class="form-group">
            <label for="convocatoria_desde">Data opertura de la convocatòria:</label>
            <input type="date" name="convocatoria_desde" class="form-control" id="convocatoria_desde" value = "<?php echo date_format(date_create($configuracion['convocatoria_desde']), 'Y-m-d');?>">
        </div> -->
       <!--  <div class="form-group">
            <label for="convocatoria_hasta">Data tancament de la convocatòria:</label>
            <input type="date" name="convocatoria_hasta" class="form-control" id="convocatoria_hasta" value = "<?php echo date_format(date_create($configuracion['convocatoria_hasta']), 'Y-m-d');?>"">
        </div>  -->

        <div class="form-group">
            <label for="convocatoria_aviso_es">Nota de aviso cuando no esté activada:</label>
            <input type="text" name="convocatoria_aviso_es" class="form-control" id="convocatoria_aviso_es" value = "<?php echo $configuracion['convocatoria_aviso_es'];?>">
        </div>			
        <div class="form-group">
            <label for="convocatoria_aviso_ca">Nota d'avís quan no estigui activada:</label>
            <input type="text" name="convocatoria_aviso_ca" min="0" max="60" class="form-control" id="convocatoria_aviso_ca" value = "<?php echo $configuracion['convocatoria_aviso_ca'];?>">
        </div>	
    </div>
	
	<!-- <div class="col-md-6"> -->
<!--         <div class="form-group">
            <label for="mail_registro">Adreça electrònica de la persona que registra:</label>
            <input type="email" name="mail_registro" class="form-control" id="mail_registro" value = "<?php echo $configuracion['mail_registro'];?>">
        </div>	 -->		
       <!--  <div class="form-group">
            <label for="meses_fecha_lim_consultoria">Mesos data limit consultoria:</label>
            <input type="hidden" name="meses_fecha_lim_consultoria" class="form-control" id="meses_fecha_lim_consultoria" value = "<?php echo $configuracion['meses_fecha_lim_consultoria'];?>">
            <table class="table table-bordered" onload="leeJson()">
                <thead class="alert-info">
                    <tr><th>Programa</th><th>Interval en mesos:</th></tr>
                </thead>
                <tbody id= "result"></tbody>
            </table>
        </div> -->
        <!-- <div class="form-group">
            <label for="dias_fecha_lim_justificar">Dies data limit justificació:</label>
            <input type="number" name="dias_fecha_lim_justificar" required min="0" max="60" class="form-control" id="dias_fecha_lim_justificar" value = "<?php echo $configuracion['dias_fecha_lim_justificar'];?>">
        </div>   -->
        <!-- <div class="form-group">
            <label for="updateInterval">Interval execució de tasques asíncrones (minuts):</label>
            <input type="number" name="updateInterval" required min="1" max="4320" class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">
        </div>	 -->	
   <!--  </div> -->
	
	<div class="col-md-12">	
          <div class="form-group">
           <button type="submit" id="guarda_config" class="btn btn-success">Guarda</button>
          </div>
	</div>
	</div>
    </form>
</div>
</div>

    <?= \Config\Services::validation()->listErrors(); ?>
 
    <span class="d-none alert alert-success mb-3" id="res_message"></span>

<script>
function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Show the specific tab content
  document.getElementById(pageName).style.display = "block";

  // Add the specific color to the button used to open the tab content
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click(); 
</script>