<?php
helper('cookie');
$language = \Config\Services::language();
$locale = $language->getLocale();

require_once('tcpdf/tcpdf.php');

use App\Models\ConfiguracionModel;
	$modelConfig = new ConfiguracionModel();
	$data['configuracion'] = $modelConfig->where('convocatoria_activa', true)->first();	

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'ADRBalears-conselleria.jpg';
        $this->Image($image_file, 30, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
        // Logo

		// Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
		$this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel 971176161 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Sol·licitud del Ajuntament per a la adhesió als programes de la ADR Balears");
$pdf->SetSubject('DOCUMENT DE SOL·LICITUD');
$pdf->SetKeywords('INDUSTRIA 4.0, DIAGNÓSTIC, DIGITAL, EXPORTA, ILS, PIMES, ADR Balears, GOIB');	

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

// --------------------------------------------------------------CABECERA Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$html1 = lang('message_lang.destino_solicitud').": <b>". lang('message_lang.idi')."</b>";
$html1 .= "<br>";
$html1 .= lang('message_lang.codigo_dir3')." <b>".$data['configuracion']['emisorDIR3']."</b>";
// set color for background
$pdf->SetFillColor(0, 55, 72);
// set color for text
$pdf->SetTextColor(255, 255, 255);
$pdf->writeHTMLCell(89, '', 106, 40, $html1, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 45);
$pdf->setX($currentX - 10);
$pdf->SetTextColor(0, 0, 0);
$html2 = lang('message_lang.titulo_solicitud_felib');

$textoIntro =  "%ALCALDE%, batle/batlessa de l'Ajuntament %AYUNTAMIENTO% estic informat dels
programes que ofereix l'ADR Balears per donar suport en el procés de creació i la
millora competitiva de les empreses de les Illes Balears. Una vegada analitzats els
seus objectius i recursos oferts, vull comptar amb la seva col·laboració al nostre
municipi.";

$textoIntro = str_replace("%ALCALDE%", $alcalde_felib, $textoIntro);
$textoIntro = str_replace("%AYUNTAMIENTO%", $localidad, $textoIntro);

$html4 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html4 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $textoIntro ."</td></tr>";
$html4 .= "</table>";

// -------------------------------------------------------------2. DATOS AYUNTAMIENTO---------------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);

$html9 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>".$html2."</b><br><br>".$html4."</td></tr>"; 
$html9 .= "<tr><td></td></tr>";
$html9 .= "</table>";

$pdf->writeHTML($html9, true, false, true, false, '');

// ------------------------------------------------------------------3. PROGRAMAS QUE SOLICITA------------------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------- //

$html11 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Per tot això, <b>deman a la directora gerent</b> que el meu municipi ofereixi els programes següents:</td></tr>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><br><ul>";

$felib_p = explode('#', $felib_p);


if (strlen($felib_p[0])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p1')."</li>";
}
if (strlen($felib_p[1])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p2')."</li>";
}
if (strlen($felib_p[2])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p3')."</li>";
}
if (strlen($felib_p[3])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p4')."</li>";
}
if (strlen($felib_p[4])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p5')."</li>";
}
if (strlen($felib_p[5])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p6')."</li>";
}
if (strlen($felib_p[6])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p7')."</li>";
}
if (strlen($felib_p[7])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p8')."</li>";
}
if (strlen($felib_p[8])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p9')."</li>";
}
if (strlen($felib_p[9])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p10')."</li>";
}
if (strlen($felib_p[10])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p11')."</li>";
}
if (strlen($felib_p[11])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p12')."</li>";
}
if (strlen($felib_p[12])> 0) {
  $html11 .= "<li>".lang('message_lang.felib_p13')."</li>";
}
$html11 .="</ul></td></tr>";
$html11 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 15);
$pdf->writeHTML($html11, true, false, true, false, '');

// ----------------------------------------------4. DOCUMENTACIÓN ADJUNTADA requerida y opcional-------------------------------------------------- //
// ----------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '25', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$html15 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html15 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Per dur a terme aquesta col·laboració, l'Ajuntament es compromet a:</td></tr><br>";
$html15 .= "<tr><td><ol>";
$html15 .= "<li>Assignar un tècnic/a al programa perquè s'encarregui de desenvolupar-lo i executar-lo, sota la coordinació del regidor/a competent en matèria d'emprenedoria i empresa.</li>";
$html15 .= "<li>Ser el canal de comunicació amb el sector empresarial i d'emprenedoria implicats, per això, a l'inici del programa, l'Ajuntament ha d'organitzar:<ul>
<li>Una roda de premsa/presentació pública del programa.</li>
<li>Una sessió informativa adreçada a titulars d'empresa i les persones emprenedores objectiu del programa.</li></ul></li>
<li>Posar a disposició del projecte les instal·lacions i els mitjans audiovisuals necessaris per fer les sessions informatives i un espai per atendre consultes específiques del programa per part del personal tècnic assignat.</li>
<li>Mantenir reunions periòdiques de seguiment dels programes amb l'equip de l'ADR Balears.</li>
<li>Informar l'ADR Balears abans de la realització de qualsevol actuació relacionada amb els programes per tal de coordinar-la, sigui quin sigui el moment de la seva execució.</li>
<li>Informar periòdicament l'ADR Balears del desenvolupament dels treballs executats relacionats amb el programa, com ara atencions realitzades, captació d'empreses i persones emprenedores interessades.</li>
<li>Utilitzar la marca i la imatge gràfica dels programes per a totes les accions dutes a terme per l'Ajuntament dins el marc d'aquests.</li>
<li>Comunicar periòdicament i sempre que ho sol·liciti l'ADR Balears, mitjançant una roda de premsa/presentació pública i difusió a les xarxes socials els resultats dels programes, a més d'incloure-hi una taula d'indicadors de seguiment.</li>";
$html15 .= "</ol></td></tr>";
$html15 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 45);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html15, true, false, true, false, '');  

// ------------------DATOS AYUNTAMIENTO, FIRMA------------------------------------------ //
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '25', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$html16 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html16 .= "<tr><td><b>Dades de l'ajuntament:</b></td></tr><br><br>";
$html16 .= "<tr><td>Adreça: ".$domicilio." CP: ".$cpostal."</td></tr>";
$html16 .= "<tr><td>Responsable: ".$responsable_felib." Càrrec: ".$cargo_felib."</td></tr>";
$html16 .= "<tr><td>Adreça electrònica: ".$email_rep." Telèfon: ".$telefono_rep."</td></tr>";
$html16 .= "<tr><td>Adreça electrònica: ".$email_rep." Telèfon: ".$telefono_rep."</td></tr><br><br>";
$html16 .= "<tr><td>Les administracions implicades poden donar publicitat a les accions desenvolupades en els programes a la seva web o en altres formats (fullets, xarxes socials, vídeos, jornades...). Les dades personals facilitades a l’ADR Balears seran tractades d’acord amb la Llei de protecció de dades de caràcter personal i es garantiran els drets d’oposició, accés, modificació, i cancel·lació dels seus titulars.</td></tr>";
$html16 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 45);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html16, true, false, true, false, ''); 

$html29 .= "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html29 .= "<tr><td>".lang('message_lang.fecha_ils')."</td></tr>";
$html29 .= "<tr><td>".lang('message_lang.firma_ils')."</td></tr>";
$html29 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY+30);
$pdf->WriteHTML($html29, true, false, true, false, '');

// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //

// ---------------------------------------------------------RGDP----------------------- //
$pdf->SetFont('helvetica', '', 7);
$rgpd = lang('message_lang.rgpd_txt');
$html29 = "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html29 .= "<tr><td style='text-align:left;background-color:#f2f2f2;color:#000;font-size:7px;'>$rgpd</td></tr>";
$html29 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 9);
$pdf->setX($currentX - 10);
$pdf->WriteHTML($html29, true, false, true, false, '');

$pdf->Output(WRITEPATH.'documentos/'.strtoupper($nif).'/'.$selloDeTiempo.'/'.strtoupper($nif).'_dec_res_solicitud_felib.pdf', 'F');
?>


<div class="container">
	<div><?php echo $html1;?></div>
	
	<div class="cabecera-apartado"><?php echo $html6;?></div>

	<div class="cabecera-apartado"><?php echo $html8;?></div>
	<div ><?php echo $html4;?></div>
	<div class="cabecera-apartado"><?php echo $html10;?></div>
	<div ><?php echo $html11;?></div>

	<div class="cabecera-apartado"><?php echo $html15;?></div>
	<div ><?php echo $html16;?></div>
	<div class="cabecera-apartado"><?php echo $html155;?></div>
  <div class='alert alert-info'><?php echo lang('message_lang.enviado_correo_electron_felib');?></div>
	<div class='alert alert-warning'><?php echo lang('message_lang.nota_info_felib');?></div>
  <div class='alert alert-info'><?php echo lang('message_lang.contacto_idi_felib');?></div>
	<div ><?php echo $html29;?></div>
</div>
<style>
	html, body {
		font-size: 14px!important;
	}
	table, li {
		font-size: 1rem!important;
	}

	td {
		padding: 0.5cm!important;
	}
	.cabecera-apartado {
		margin-top:1rem;
	}
	.container {

  margin: auto!important;
  width: 100%!important;
  max-width: 1140px;
  border: 1px solid black;
  background-color: #cdebe8;
  color: #000;
  border-radius: .5rem;
	padding: 1rem;
	margin-bottom: 1rem;
	}
</style>