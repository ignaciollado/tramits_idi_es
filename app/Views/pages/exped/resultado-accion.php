<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
<div class="further">
  <div class="container">
	<div class = "row">	
	<div class="col-md-6">
<!--         <div class="form-group">
            <label for = "convocatoria_activa" class="main"><?php echo lang('message_lang.convocatoria_activa');?>
			<input title = "<?php echo lang('message_lang.convocatoria_activa');?>" type="checkbox" disabled name="convocatoria_activa" id="convocatoria_activa" value="<?php echo $configuracion['convocatoria_activa'];?>" onchange = "javaScript: muestraSubeArchivo(this.id);">
			<span class = "w3docs"></span>
        </div> -->
        <div class="form-group">
            <label for="programa">Emissor DIR3:</label>
            <input type="text" name="emisorDIR3" readonly class="form-control" id="emisorDIR3" value = "<?php echo $configuracion['emisorDIR3'];?>">
        </div>
       <!--  <div class="form-group">
            <label for="programa">Codi SIA:</label>
            <input type="text" name="codigoSIA" readonly class="form-control" id="codigoSIA" value = "<?php echo $configuracion['codigoSIA'];?>">
        </div>	   -->      	
       <!--  <div class="form-group">
            <label for="programa">Programa:</label>
            <input type="text" name="programa" readonly class="form-control" id="programa" value = "<?php echo $configuracion['programa'];?>">
        </div> -->
        <!--  <div class="form-group">
            <label for="convocatoria">Convocatòria:</label>
            <input type="text" name="convocatoria" readonly class="form-control" id="convocatoria" value = "<?php echo $configuracion['convocatoria'];?>">
        </div> -->
       <!--  <div class="form-group">
            <label for="convocatoria">Data límit per tots els programes:</label>
            <input type="date" name="fechaLimiteProgramas" readonly class="form-control" id="fechaLimiteProgramas" value = "<?php echo $configuracion['fechaLimiteProgramas'];?>">
        </div>      -->       
        <!-- <div class="form-group">
            <label for="num_BOIB">Data publicació convocatoria al BOIB:</label>
            <input type="text" name="num_BOIB"readonly class="form-control" id="num_BOIB" value = "<?php echo $configuracion['num_BOIB'];?>">
        </div>    -->    
        <div class="form-group">
            <label for="respresidente">President de l'IDI:</label>
            <input type="text" readOnly name="respresidente" maxlength = "50" size="50" class="form-control" id="respresidente" value = "<?php echo $configuracion['respresidente'];?>">
        </div>
        <div class="form-group">
            <label for="eMailPresidente">Adreça electrònica President de l'IDI:</label>
            <input type="mail" readOnly name="eMailPresidente" maxlength = "100" size="50" class="form-control" id="eMailPresidente" value = "<?php echo $configuracion['eMailPresidente'];?>">
        </div>
        <div class="form-group">
            <label for="directorGeneralPolInd">Directora General:</label>
            <input type="text" readOnly name="directorGeneralPolInd" maxlength = "50" size="50" class="form-control" id="directorGeneralPolInd" value = "<?php echo $configuracion['directorGeneralPolInd'];?>">
        </div>
        <div class="form-group">
            <label for="eMailDGeneral">Adreça electrònica Director General:</label>
            <input type="mail" readOnly name="eMailDGeneral" maxlength = "100" size="50" class="form-control" id="eMailDGeneral" value = "<?php echo $configuracion['eMailDGeneral'];?>">
        </div>        
        <div class="form-group">
            <label for="directorGerenteIDI">Directora Gerent:</label>
            <input type="text" readOnly name="directorGerenteIDI" maxlength = "50" size="50" class="form-control" id="directorGerenteIDI" value = "<?php echo $configuracion['directorGerenteIDI'];?>">
        </div>
        <div class="form-group">
            <label for="eMailDGerente">Adreça electrònica Directora Gerent:</label>
            <input type="mail" readOnly name="eMailDGerente" maxlength = "100" size="50" class="form-control" id="eMailDGerente" value = "<?php echo $configuracion['eMailDGerente'];?>">
        </div>     
<!--         <div class="form-group">
            <label for="num_BOIB_modific">Segona resolució BOIB:</label>
            <input type="text" name="num_BOIB_modific" readonly class="form-control" id="num_BOIB_modific" value = "<?php echo $configuracion['num_BOIB_modific'];?>">
        </div>	 -->             
               
<!--         <div class="form-group">
            <label for="convocatoria_desde">Data opertura de la convocatòria:</label>
            <input type="text" name="convocatoria_desde" readonly class="form-control" id="convocatoria_desde" value = "<?php echo $configuracion['convocatoria_desde'];?>">
        </div>	 -->             
<!--         <div class="form-group">
            <label for="convocatoria_hasta">Data tancament de la convocatòria:</label>
            <input type="text" name="convocatoria_hasta" readonly class="form-control" id="convocatoria_hasta" value = "<?php echo $configuracion['convocatoria_hasta'];?>">
        </div> -->
        <div class="form-group">
            <label for="convocatoria_aviso_es">Nota d'avís quan estigui activada:</label>
            <input type="text" name="convocatoria_aviso_es" readonly class="form-control" id="convocatoria_aviso_es" value = "<?php echo $configuracion['convocatoria_aviso_es'];?>">
        </div>        
        <div class="form-group">
            <label for="convocatoria_aviso_ca">Nota d'avís quan no estigui activada:</label>
            <input type="text" name="convocatoria_aviso_ca" readonly class="form-control" id="convocatoria_aviso_ca" value = "<?php echo $configuracion['convocatoria_aviso_ca'];?>">
        </div>        	
    </div>
	
	<!-- <div class="col-md-6">
        <div class="form-group">
            <label for="mail_registro">Adreça electrònica de la persona que registra:</label>
            <input type="text" name="mail_registro" readonly class="form-control" id="mail_registro" value = "<?php echo $configuracion['mail_registro'];?>">
        </div>
        <div class="form-group">
            <label for="dias_not_def">Mesos data limit consultoria:</label>
            <input type="hidden" name="meses_fecha_lim_consultoria" class="form-control" id="meses_fecha_lim_consultoria" value = "<?php echo $configuracion['meses_fecha_lim_consultoria'];?>">
                 
            <table class="table table-bordered">
            <thead class="alert-info">
            <tr>
                <th>Programa</th>
                <th>Interval en mesos:</th>
            </tr>
            </thead>
            <tbody id= "result"></tbody>
            </table>
        </div>
        <div class="form-group">
            <label for="dias_fecha_lim_justificar">Dies data limit justificació:</label>
            <input type="text" name="dias_fecha_lim_justificar" readonly class="form-control" id="dias_fecha_lim_justificar" value = "<?php echo $configuracion['dias_fecha_lim_justificar'];?>">
        </div>		   
        <div class="form-group">
            <label for="updateInterval">Interval execució de tasques asíncrones (minuts):</label>
            <input type="text" name="updateInterval" readonly class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">
        </div>	
    </div>
	</div> -->

</div>
</div>
<input type="hidden" name="id"readonly class="form-control" id="id" value = "<?php echo $configuracion['id'];?>">

<script>
let data = eval(document.getElementById("meses_fecha_lim_consultoria").value);
 let table = "" ;
 for(let i of data){
      table += "<tr>";
      table += "<td>" 
          + i.programa +"</td>" 
          + "<td><span name ='meses_p1' class='form-control' id = '"+i.programa+"' value ='" + i.intervalo +"'>"+i.intervalo+"</span></td>" 
          ;
      table += "</tr>";

    }
document.getElementById("result").innerHTML = table;
    $(document).ready( function () {
         $('#documentos').DataTable( {
        "order": [[ 4, "desc" ]]
    } );
  } );
</script>





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