<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>
<?php

define("K_PATH_IMAGES", "/home/pre-tramitsidi/www/app/Views/pages/forms/modDocs/pdf/fpdf/images/");
define("LINE_HEIGHT", 14);
require('fpdf/fpdf.php');

setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ExpedientesModel;
use App\Models\MejorasExpedienteModel;
    //obtengo los datos de la convocatoria
    $configuracion = new ConfiguracionModel();
    $data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
    //obtengo los datos de la solicitud
    $expediente = new ExpedientesModel();
    $data['expediente'] = $expediente->where('id', $id)->first();
    //obtengo los datos de la última mejora de la solicitud (si la hay)
    $mejorasSolicitud = new MejorasExpedienteModel();
    $data['ultimaMejora'] = $mejorasSolicitud->selectLastMejorasExpediente($id);
    $ultimaMejora = explode("##",  $data['ultimaMejora']);
    //obtengo los datos del documento
    $db = \Config\Database::connect();
	  $query = $db->query("SELECT * FROM pindust_documentos_generados WHERE id_sol=".$id." AND convocatoria='".$convocatoria."' AND tipo_tramite='".$programa."'");
    foreach ($query->getResult() as $row)
        {
        $nif = $row->cifnif_propietario;
        }
        
    $session = session();
    if ($session->has('logged_in')) {  
       $pieFirma =  $session->get('full_name');
    }

  class MYPDF extends FPDF {
    //Page header
    public function Header() {
      // Logo
      $image_file = K_PATH_IMAGES.'logo_idi_conselleria.jpg';
      $this->Image($image_file, 10, 10, 90);
			$this->SetFont('Arial', '', 14);
	  }
    // Page footer
    public function Footer() {
      // Logo
		// Position at 15 mm from bottom
      $this->SetY(-15);
    // Set font
      $this->SetFont('Arial', 'I', 8);
    // Address and Page number
		  $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Institut d'Innovació Empresarial - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
      $this->Cell(0, 15, iconv('UTF-8', 'windows-1252','Pàgina ').$this->PageNo().'/'.$this->AliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

/* $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); */
$pdf = new MYPDF();
$pdf->SetCreator("Linea idi-isba");
	
$pdf->SetAuthor(iconv('UTF-8', 'windows-1252',"INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ"));
$pdf->SetTitle(iconv('UTF-8', 'windows-1252',"PROPUESTA RESOLUCIÓN DENEGACIÓN CON REQUERIMIENTO"));
$pdf->SetSubject(iconv('UTF-8', 'windows-1252',"PROPUESTA RESOLUCIÓN DENEGACIÓN CON REQUERIMIENTO"));
$pdf->SetKeywords(iconv('UTF-8', 'windows-1252',"INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, GOIB"));	

$pdf->SetMargins(15, 20, 15, true);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 25);

// set image scale factor
/* $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); */

$pdf->SetFont('Arial', '', 8);
/* $pdf->setFontSubsetting(false); */

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: proposta de resolució <br>de denegació<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']." (".$data['expediente']['tipo_tramite'].")"."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Codi SIA: ".$data['configuracion']['codigoSIA']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->WriteHTML(90, '', 105, 20, $html, 1, 1, 1, true, 'J', true);

$pdf->SetFont('Arial', '', 11);
/* $pdf->setFontSubsetting(false); */

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('message_lang.doc_prop_resolucion_denegacion_con_req_intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('message_lang.doc_prop_resolucion_denegacion_con_req_antecedentes') ."</b></td></tr>";
$html .= "</table>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1 = str_replace("%RESPRESIDENTE%", $data['configuracion']['respresidente'], lang('message_lang.doc_prop_resolucion_denegacion_con_req_p1'));
$parrafo_1 = str_replace("%BOIB%", $data['configuracion']['num_BOIB'], $parrafo_1);
$html = "<ol>";
$html .= "<li>". $parrafo_1 ."</li>";
$html .= "<br>";

$parrafo_2 = str_replace("%FECHAREC%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y") , lang('message_lang.doc_prop_resolucion_denegacion_con_req_p2'));
$parrafo_2 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_2);
$parrafo_2 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_2);
$parrafo_2 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $parrafo_2);
$parrafo_2 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_2);
$parrafo_2 = str_replace("%PROGRAMA%", $data['expediente']['tipo_tramite'], $parrafo_2);
$html .= "<li>". $parrafo_2 ."</li>";
$html .= "<br>";

if ($ultimaMejora[2] && $ultimaMejora[3]) {
    $parrafo_3m = str_replace("%FECHARECM%", date_format(date_create($ultimaMejora[2]),"d/m/Y") , lang('message_lang.doc_prop_resolucion_denegacion_con_req_p3m'));
    $parrafo_3m = str_replace("%REFRECM%", $ultimaMejora[3], $parrafo_3m);
    $html .= "<li>". $parrafo_3m ."</li>";
    $html .= "<br>";
}

$parrafo_3 = str_replace("%FECHAENMIENDA%", date_format(date_create($data['expediente']['fecha_REC_enmienda']),"d/m/Y") , lang('message_lang.doc_prop_resolucion_denegacion_con_req_p3'));
$parrafo_3 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'] , $parrafo_3);
$parrafo_3 = str_replace("%NIF%", $data['expediente']['nif'] , $parrafo_3);
$parrafo_3 = str_replace("%NUMENMIENDAREC%", $data['expediente']['ref_REC_enmienda'] , $parrafo_3);
$parrafo_3 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']), $parrafo_3);
$parrafo_3 = str_replace("%PROGRAMA%", $data['expediente']['tipo_tramite'], $parrafo_3);
$html .= "<li>". $parrafo_3 ."</li>";
$html .= "<br>";

$parrafo_4 =  lang('message_lang.doc_prop_resolucion_denegacion_con_req_p4');
$html .= "<li>". $parrafo_4 ."</li>";
$html .= "<br>";

$parrafo_5 = str_replace("%FECHAINFORFAV%", date_format(date_create($data['expediente']['fecha_infor_fav_desf']),"d/m/Y") , lang('message_lang.doc_prop_resolucion_denegacion_con_req_p5'));
$parrafo_5 = str_replace("%TEXTOLIBRE%", $data['expediente']['motivoDenegacion'], $parrafo_5);
$html .= "<li>". $parrafo_5 ."</li>";
$html .= "</ol>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

// remove default header/footer
/* $pdf->setPrintHeader(false); */
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 25);
$req_fundamentos = lang('message_lang.doc_prop_resolucion_denegacion_con_req_fundamentos');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $req_fundamentos ."</td></tr>";
$html .= "</table>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$req_fundamentos_1 = lang('message_lang.doc_prop_resolucion_denegacion_con_req_fundamentos_1');
$html = "<ol><li>". $req_fundamentos_1."</li><br>";

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$req_fundamentos_2 = lang('message_lang.doc_prop_resolucion_denegacion_con_req_fundamentos_2');
$html .= "<li>". $req_fundamentos_2."</li></ol>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$dicto = lang('message_lang.doc_prop_resolucion_denegacion_con_req_dicto');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $dicto ."</td></tr>";
$html .= "</table>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$resolucion = lang('message_lang.doc_prop_resolucion_denegacion_con_req_resolucion');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $resolucion ."</td></tr>";
$html .= "</table>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$resolucion_1 = str_replace("%IMPORTE%", money_format("%i ", $data['expediente']['importeAyuda']) , lang('message_lang.doc_prop_resolucion_denegacion_con_req_resolucion_1'));
$resolucion_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'] , $resolucion_1);
$resolucion_1 = str_replace("%NIF%", $data['expediente']['nif'] , $resolucion_1);
$html = "<ol><li>". $resolucion_1."</li><br>";
$resolucion_2 = lang('message_lang.doc_prop_resolucion_denegacion_con_req_resolucion_2');
$html .= "<li>". $resolucion_2."</li><br>";

$resolucion_3 = lang('message_lang.doc_prop_resolucion_denegacion_con_req_resolucion_3');
$html .= "<li>". $resolucion_3."</li></ol>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$firma = lang('message_lang.doc_prop_resolucion_denegacion_con_req_firma');
$firma = str_replace("%BOIBNUM%", $data['configuracion']['num_BOIB'], $firma);
$firma = str_replace("%DIRECTORAGERENTEIDI%", "Mariona Luis Tomás", $firma);

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $firma ."</td></tr>";
$html .= "</table>";
$html = iconv('UTF-8', 'windows-1252', $html);
$pdf->Write(LINE_HEIGHT, $html);

// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
 /* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria'];
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_fpdf_prop_res_denegacion_con_req.pdf', 'F');