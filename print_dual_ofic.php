<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 05NOV22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 05NOV22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 05NOV22

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05NOV22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08NOV22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 
<!-- ####   ARQUIVO PARA IMPRESSÃO EM IMPRESSORA FISCAL PARA A OFICINA  ###  */
session_start();  //  INICIALIZA A SESSÃO //
ob_start();
require 'Utilidades/conexao.php';  // CONEXAO COM O BANCO DE DADOS //
require 'tcpdf/tcpdf.php';


 $usuario   = $_SESSION['usuario'];  //  ####   VARIÁVEL DE SESSÃO COM NOME DO RESPONSAVEL DO ORÇAMENTO  #####  //
 $orcamento = $_REQUEST['orcamento']; // ### RECEBE O NÚMERO DO ORCAMENTO ### //




// $custom_layout = array(210, 297);
$custom_layout = array(90, 410);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 10, '', true);

$pdf->AddPage();
// ###  CARREGANDO OS DADOS DO CLIENTE NA TELA ### //
/*SELECT cliNome, cliEndereco, cliNumero, cliCelular, cliMoto, cliPlaca, pedIteResponsavel, pedIteKm, pedIteData FROM clientes INNER JOIN pedidos_itens ON pedido_itens.pedIteCliente_fk = clientes.cliCodigo WHERE pedido_itens.pedItePedido_fk = '$pedido'*/
           $log = mysql_query("SELECT cliNome, cliEndereco, cliNumero, cliCelular, cliMoto, cliPlaca, orcResponsavel, orcData FROM clientes INNER JOIN orcamento ON orcamento.orcItens_fk = clientes.cliCodigo WHERE orcamento.orcCodigo = '$orcamento'");
           while($_obj = mysql_fetch_array($log))
            {
                 $nome        = $_obj['cliNome'];  // NOME DO CLIENTE PARA CARREGAR NO FORMULARIO DE ENVIO DE EMAIL //
                 $celular     = $_obj['cliCelular'];  // NUMERO DO CELULAR DO CLIENTE //
                 $moto        = $_obj['cliMoto'];  // MODELO DA MOTO //
                 $placa       = $_obj['cliPlaca'];  // PLACA DA MOTO DO CLIENTE //
                 $data        = $_obj['pedData'];  // DATA DO PEDIDO //
                 $responsavel = $_obj['pedResponsavel'];  // NOME DO RESPONSÁVEL DO PEDIDO //
            }
            
            // ## CARREGANDO O CONTEUDO DA TABELA  ## //
            $content = mysql_query("SELECT orcItensIdProduto_fk,orcItensQuantidade,orcItensDescricao AS descricao,orcItensTotal FROM orcamento_itens WHERE orcItens_fk = '$orcamento'");



$html='';

//$html.= '<h1>EXEMPLO</h1>';

$html.='
<style type="text/css">
  .tg  {border-collapse:collapse;border-spacing:0;}
  .tg td{font-family:Arial, sans-serif;font-size:10px;padding:10px 5px;overflow:hidden;word-break:normal;}
  .tg th{font-family:Arial, sans-serif;font-size:8px;font-weight:normal;padding:10px 5px;overflow:hidden;word-break:normal;font-weight: bold;}
  .tg .tg-yw4l{vertical-align:top}

  .hr1{
    overflow: visible; /* For IE */
    height: 2px;
    border-style: solid;
    border-color: black;
    border-width: 1px 0 0 0;
    border-radius: 20px;
  }
</style>';

$html.='<hr class="hr1">';
$html.='<img src="img/logo.jpg" alt="Graus Motos">';
$html.='<hr class="hr1">';
$html.='<table class="tg">
    <tr>
      <th class="tg-yw4l">Orcamento.:'. $orcamento.'</th>
      <th class="tg-yw4l">Data.:'.$data.'</th>
    </tr>
    <tr>
      <th class="tg-yw4l">Cliente.:'.$nome.'</th>
    </tr>
    <tr>
      <th class="tg-yw4l">Celular.:'.$celular.'</th>
      <th class="tg-yw4l">Tecnico.:'.$mecanico.'</th>
    </tr>
    <tr>
      <th class="tg-yw4l">Moto.:'.$moto.'</th>
      <th class="tg-yw4l">Placa.:'.$placa.'</th>
    </tr>
    <tr>
      <th class="tg-yw4l">Responsável.:'.$responsavel.'</th>
      <th class="tg-yw4l">Km.:'.$km.'</th>
    </tr>
</table>';
$html.='<table border="1" class="tg">
   <tr>
        <th style="width:25px">ITEM</th>
        <th style="width:35px">QUANT</th>
        <th style="width:170px">DESCRICAO</th>
    </tr>';

while($cont = mysql_fetch_array($content)){
 $html.='<tr>';
 $html.='<th style="width:25px">'.$cont['orcItensIdProduto_fk'].'</th>';
 $html.='<th style="width:35px">'.$cont['orcItensQuantidade'].'</th>';
 $html.='<th style="width:170px">'.utf8_encode($cont['descricao']).'</th>';
 $html.='</tr>';
} 

$html.='</table>';
// ## VALOR FINAL DO ORÇAMENTO ## //
$sql = mysql_query("SELECT orcComentario FROM orcamento WHERE orcCodigo = '$orcamento'");
while($_sql = mysql_fetch_array($sql))
{
   $comentario = $_sql['orcComentario'];
}
$html.='<br>';
$html.='<table border="1" class="tg">
</table>';

ob_end_clean();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output(dirname(__FILE__).'/print_dual_ofic.pdf', 'I');


// ### FIM DE ROTINA  ###  //               
?>                 