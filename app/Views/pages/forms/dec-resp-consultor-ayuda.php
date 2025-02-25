<?php
require_once('tcpdf/tcpdf.php');
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
		$this->Cell(0, 5, "Institut d'Innovació Empresarial - Plaça Son Castelló 1 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Sol·licitud d'ajuts per al disseny de plans de transformació digital en el marc del programa iDigital");
$pdf->SetSubject('DECLARACIÓ RESPONSABLE CONSULTOR iDigital');
$pdf->SetKeywords('INDUSTRIA 4.0, DIAGNÓSTIC, DIGITAL, PIMES, IDI, GOIB');	

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

$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

// --------------------------------------------------------------------------------------------------------------------------------------------------- //

// La declaración responsable del consultor.
$pdf->AddPage();
$html = "<content>";
$html = "<section>";
$html .= "<h4><b>". lang('message_lang.destino_solicitud')."</b>: ". lang('message_lang.idi')."</h4>";
$html .= "<br>";
$html .= "<h5><b>". lang('message_lang.codigo_dir3')." DIR3</b>: A04003714</h5>";
echo $html;
// set color for background
$pdf->SetFillColor(230, 247, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(90, '', 105, 20, $html, 1, 1, 1, true, 'J', true);

$html = lang('message_lang.declaracion_responsable_txt');
$html .= "Idigital, ". lang('message_lang.convocatoria_sol_idigital')." 2020";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->Cell(0, 10, $html, 1, 1, 'C');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->Cell(0, 10, lang('message_lang.titulo_dec_resp_consul'), 1, 1, 'C');
$html = "<table cellpadding='5' style='width: 100%; border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>".lang('message_lang.solicitante_sol_idigital')." :</b> " . $empresa . "</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>NIF: </b> " . $nif . "</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>".lang('message_lang.mail_rep_legal_sol_idigital')." :</b>" . $telefono . "</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>".lang('message_lang.tel_rep_legal_sol_idigital')." :</b>" . $email . "</td></tr>";
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTML($html, true, false, true, false, '');

$html = "<br><br>";
$html .= "<table cellpadding='5' style='border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.declaro')."</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>";
if ( $expMinDos_dec_resp_cons == "on") {
	$html .= "<p>".lang('message_lang.declaracion_responsable_asesor')."</p>";
}
if ( $expTransDigital_dec_resp_cons == "on") {
	$html .= "<p>".lang('message_lang.declaracion_responsable_experiencia')."</p>";
}
if ( $tieneEstudios_dec_resp_cons == "on") {
	$html .= "<p>".lang('message_lang.declaracion_responsable_formacion')."</p>";
}
$html .= "</td></tr>";
$html .= "</table>";
echo $html;

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->WriteHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 7);
$rgpd = lang('message_lang.rgpd_txt');

$html = "<br><br>";
$html .= "<table cellpadding='5' style='width: 100%; border: 1px solid #ffffff;'>";
$html .= "<tr><td style='text-align:center;background-color:#f2f2f2;color:#000;font-size:8px;'>$rgpd</td></tr><br>";
$html .= "</table>";
$html .= "</section>";
$html .= "</content>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->WriteHTML($html, true, false, true, false, '');

// --------------------------------------------------------------------------------------------------------------------------------------------- //
// Lo guarda todo en una carpeta del servidor para, luego, enviarlo por correo electrónico.
$pdf->Output(WRITEPATH.'documentos/consultor/'.$nif.'/'.$selloDeTiempo.'/'.$nif.'_dec_res_consultor_iDigital.pdf', 'F');