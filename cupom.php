<?php
ob_start();
require_once('tcpdf/tcpdf.php');

// $custom_layout = array(210, 297);
$custom_layout = array(80, 200);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 8, '', true);

$pdf->AddPage();
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// $pdf->Write(0, 'Example of HTML tables' . $acao, '', 0, 'L', true, 0, false, false, 0);
$html='';

//$html.= '<h1>EXEMPLO</h1>';

$html.='
<style type="text/css">
  .tg  {border-collapse:collapse;border-spacing:0;}
  .tg td{font-family:Arial, sans-serif;font-size:9px;padding:10px 5px;overflow:hidden;word-break:normal;}
  .tg th{font-family:Arial, sans-serif;font-size:7px;font-weight:normal;padding:10px 5px;overflow:hidden;word-break:normal;font-weight: bold;}
  .tg .tg-yw4l{vertical-align:top}

  .hr1{
    overflow: visible; /* For IE */
    height: 2px;
    border-style: solid;
    border-color: black;
    border-width: 1px 0 0 0;
    border-radius: 20px;
  }
</style>
';

$html.='<hr class="hr1">';
$html.= '<h3 style="text-align:center;">RESTAURANTE MM<br></h3>';
$html.='
<table class="tg">
<tr>
  <th class="tg-yw4l">Nome cliente</th>
  <th class="tg-yw4l">RG</th> 
</tr>  
<tr>
  <td class="tg-yw4l">Tiago da Silva Gomes</td>
  <td class="tg-yw4l">3987054564</td>
</tr>

<tr>
  <th class="tg-yw4l">Número</th>
  <th class="tg-yw4l">Plataforma</th>
</tr>  
<tr>
  <td class="tg-yw4l">0544</td>
  <td class="tg-yw4l">4445</td>
</tr>



<p class="tg-yw4l" style="text-align:center"><strong>
  End. Rua dois</strong> <br>
</p>
</table>
';
ob_end_clean();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output(dirname(__FILE__).'/cupom.pdf', 'I');

?>