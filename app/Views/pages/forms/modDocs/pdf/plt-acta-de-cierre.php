<?php
    require_once('tcpdf/tcpdf.php');
    setlocale(LC_MONETARY,"es_ES");

    use App\Models\ConfiguracionModel;
    use App\Models\ConfiguracionLineaModel;
    use App\Models\ExpedientesModel;

    $configuracion = new ConfiguracionModel();
    $configuracionLinea = new ConfiguracionLineaModel();
    $expediente = new ExpedientesModel();

    $data['configuracion'] = $configuracion->configuracionGeneral();   
    $data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('XECS', $convocatoria);
    $data['expediente'] = $expediente->where('id', $id)->first();

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
    if ($data['expediente']['tipo_tramite'] == "Programa I") {
        $tipo_tramite = lang('message_lang.programaiDigital');
    }
    else if ($data['expediente']['tipo_tramite'] == "Programa II") {
        $tipo_tramite = lang('message_lang.programaiExporta');
    }
    else if ($data['expediente']['tipo_tramite'] == "Programa III actuacions corporatives") {
        $tipo_tramite = lang('message_lang.programaiSostenibilitatCorp');
    }
    else if ($data['expediente']['tipo_tramite'] == "Programa III actuacions producte") {
        $tipo_tramite = lang('message_lang.programaiSostenibilitatProd');
    }
    else if ($data['expediente']['tipo_tramite'] == "Programa IV") {
        $tipo_tramite = lang('message_lang.programaiGestio');
    }

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'ADRBalears-conselleria.jpg';
        $this->Image($image_file, 10, 10, 90, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
        // Logo

		// Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
        $this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("ACTA DE CIERRE");
$pdf->SetSubject("ACTA DE CIERRE");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, GOIB");	

$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ------------------------------------------- Programa, datos solicitante, datos consultor -------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: Acta núm. ".$data['expediente']['actaNumCierre']."<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']."<br>";
$html .= "Programa: " .$tipo_tramite."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";
$html .= "Codi SIA: ".$data['configuracionLinea']['codigoSIA']."<br>";

// set membrete
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 9);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 110, 40, $html, 0, 1, 1, true, 'J', true);
$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$intro = lang('20_acta_de_tacament.20_identificacion')."<br>";
$intro = str_replace("%PROGRAMA%", $tipo_tramite, $intro);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $intro);
$intro = str_replace("%fecha_reunion_cierre%", date_format(date_create($data['expediente']['fecha_reunion_cierre']),"d/m/Y"), $intro);
$intro = str_replace("%horaInicioActaCierre%", $data['expediente']['horaInicioActaCierre'], $intro);
$intro = str_replace("%horaFinActaCierre%", $data['expediente']['horaFinActaCierre'], $intro);
$intro = str_replace("%lugarActaCierre%", $data['expediente']['lugarActaCierre'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $intro ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$nombreAsistentes =  $data['expediente']['asistentesActaCierre'];
$asistentes =  lang('20_acta_de_tacament.20_Asistentes');
$asistentes = str_replace("%nombreAsistentes%", nl2br($nombreAsistentes), $asistentes);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $asistentes ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_1 = lang('20_acta_de_tacament.20_Desarrollo');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_1 = lang('20_acta_de_tacament.20_p1');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_2 = lang('20_acta_de_tacament.20_p2');
$parrafo_2 =  str_replace("%FECHAJUSTIFICACIONAYUDA%", date_format(date_create($data['expediente']['fecha_limite_justificacion']),"d/m/Y"), $parrafo_2);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_2 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$parrafo_3 = lang('20_acta_de_tacament.20_p3');
$parrafo_3 = str_replace("%observacionesActaCierre%", $data['expediente']['observacionesActaCierre'], $parrafo_3); ;
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 2);
$firma = lang('20_acta_de_tacament.20_firma');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $firma ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
 /* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria']; 
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_acta_de_cierre.pdf', 'F');
