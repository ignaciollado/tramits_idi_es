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
$pdf->SetTitle("Resolució sol·licitud ajudes/subvencions DENEGACIÓ");
$pdf->SetSubject('DOCUMENT DE RESOLUCIÓ');
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

// -------------------------------------------------------------------------------------------------------------------------------------------------- //
// La resolución.
$pdf->AddPage();
$html = "<section>";
$html .= "<h4>Expedient: ". $expedientes['id']." / ".$expedientes['tipo_tramite']." Ajut per al disseny de plans de transformació digital 2020</h4>";
$html .= "<h4>Document: Resolució</h4>";
$html .= "<h4>Emissor: IDI </h4>";
echo $html;

// set color for background
$pdf->SetFillColor(230, 247, 255);

// set color for text
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(90, '', 105, 20, $html, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Proposta de resolució de la directora gerent de l’IDI per la qual es <strong>deficiencies</strong> la concessió d’un ajut per al disseny i la implementació d’un pla de transformació digital a ".$expedientes['empresa']." amb DNI ".$expedientes['nif'];
echo "<div>".$html."</div>";
$pdf->Cell(0, 10, $html, 1, 1, 'C');
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Antecedents</b></td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>1. Mitjançant Resolució del president de l'Institut d’Innovació Empresarial de les Illes Balears (IDI) de dia $fecha_resol es va aprovar la convocatòria per a l’any 2020 d’ajuts per al disseny de plans de transformació digital per a l’any 2020 destinats a la indústria balear, en el marc d’Idigital, Estratègia de Digitalització Industrial (BOIB núm. XXX, de X de XXXXX de 2020).</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>2. D'acord amb el punt 12è de la convocatòria, es designen els membres de la Comissió Avaluadora per a la valoració de les sol·licituds presentades.</td></tr><tr><td style='background-color:</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>3. El $fecha_solicitud, l'Institut d’Innovació Empresarial de les Illes Balears (IDI)  va rebre la sol·licitud de ".$expedientes['empresa']." amb DNI ".$expedientes['nif']." d'un ajut per import de XXXXX euros, equivalent a XX hores de consultoria especialitzada.</td></tr>";

$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');

$html = "REPRESENTANT LEGAL";
echo "<div>".$html."</div>";
$pdf->Cell(0, 10, $html, 1, 1, 'C');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Nom i llinatges:</b>  ". $nombre_rep ."</td></tr><tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>NIF/NIE:</b> " . $nif_rep . "</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Adreça:</b>  ". $domicilio_rep . "</td></tr><tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Telèfon:</b>  " . $telefono_rep . "</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Condició que al·lega:</b>  ". $condicion_rep."</td></tr>";
$html .= "</table>";
echo $html;

$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');
$html = "DADES ECONÒMIQUES";
echo "<div>".$html."</div>";
$pdf->Cell(0, 10, $html, 1, 1, 'C');

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>IAE:</b>  " . $iae . "</td></tr>";
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');

$html = "DADES DEL CONSULTOR";
echo "<div>".$html."</div>";
$pdf->Cell(0, 10, $html, 1, 1, 'C');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
if ( $hay_consultor != "si") {
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'><b>No</b> tenc consultor, l'IDI m'assignarà un consultor acreditat</td></tr>";
}
else {	
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>Ja tenc consultor, no necessit que l'IDI m'assigni un consultor acreditat:</td></tr>";
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>Nom del consultor proposat: " . $nom_consultor . "</td></tr>";
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>Telèfon del consultor: " . $tel_consultor . "</td></tr>";
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'>E-mail: " . $mail_consultor . "</td></tr>";
}
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');

$html = "DOCUMENTACIÓ ADJUNTADA";
echo "<div>".$html."</div>";
$pdf->Cell(0, 10, $html, 1, 1, 'C');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td><ul>";
if ( $file_infoautodiagnostico == "SI ") {
	$html .= "<li> Informe Autodiagnosi Digital.</li>";
}
if ( $file_certificadoIAE == "SI ") {
	$html .= "<li> Certificat d'alta d'IAE.</li>";
}
if ( $file_memoriaTecnica == "SI ") {
	$html .= "<li> Memòria tècnica de l'empresa.</li>";
}
if ( $file_certigicadoSegSoc == "SI ") {
	$html .= "<li> Certificat de la Seguretat Social (en cas de no autoritzar la consulta).</li>";
}
if ( $file_certificadoAEAT == "SI ") {
	$html .= "<li> Certificat obligacions tributàries amb Agència Estatal de l'Administració Tributària i Agència Tributària IB (en cas de no autoritzar la consulta).</li>";
}
if ( $file_declaracionResponsable == "SI ") {
	$html .= "<li> Declaració responsable de l'empresa.</li>";
}
if ( $file_declaracionResponsableConsultor == "SI ") {
	$html .= "<li> Declaració responsable del consultor (només en cas de proposar un consultor).</li>";
}
$html .= "</ul></td></tr>";
if ( $file_copiaNIF == "SI " || $file_altaAutonomos == "SI ") {
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'><b><i>Per a  persones físiques (autònoms):</i></b></td></tr>";
	$html .= "<tr><td><ul>";
	if ( $file_copiaNIF == "SI ") {
		$html .= "<li> Còpia NIF.</li>";
	}
	if ( $file_altaAutonomos == "SI ") {
		$html .= "<li> Còpia documentació acreditativa alta d'autònoms.</li>";
	}
	$html .= "</ul></td></tr>";
}

if ( $file_escrituraConstitucion == "SI " || $file_nifEmpresa == "SI " || $file_nifRepresentante == "SI ") {
	$html .= "<tr><td style='text-align:left;background-color:#ffffff;color:#000;font-size:14px;'><b><i>Per a persones jurídiques:</i></b></td></tr>";
	$html .= "<tr><td><ul>";
	if ( $file_escrituraConstitucion == "SI ") {
		$html .= "<li> Còpia escriptura de constitució de l'entitat.</li>";
	}
	if ( $file_nifEmpresa == "SI ") {
		$html .= "<li> Còpia del NIF de l'empresa.</li>";
	}
	if ( $file_nifRepresentante == "SI ") {
		$html .= "<li> Còpia del NIF del representant de la societat.</li>";
	}
	$html .= "</ul></td></tr>";
}

$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');

// Lo guarda todo en una carpeta del servidor para, luego, enviarlo por correo electrónico.
$pdf->Output(WRITEPATH.'documentos/'.$expedientes['nif'].'/'.$expedientes['selloDeTiempo'].'/'.'resolucion_deficiencias.pdf', 'F');

// $pdf->Output($nif.'_dec_res_solicitud_iDigital.pdf', 'D');