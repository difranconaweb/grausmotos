<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 28ABR22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 28ABR22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 28ABR22

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29ABR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 14JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 15JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 21JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 22JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 27JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 30JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07JUL22 
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 09JUL22 
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 23JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06AGO22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08NOV22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 
<!-- ####   ARQUIVO PARA IMPRESSÃO EM PDF  ###  */


session_start();  //  INICIALIZA A SESSÃO //
require 'Utilidades/conexao.php';  // CONEXAO COM O BANCO DE DADOS //
require_once("pdf/fpdf.php");
//require('mc_table.php');

 $usuario   = $_SESSION['usuario'];  //  ####   VARIÁVEL DE SESSÃO COM NOME DO RESPONSAVEL DO ORÇAMENTO  #####  //
 $orcamento = $_REQUEST['orcamento']; // ### RECEBE O NÚMERO DO ORÇAMENTO ### //


 
$pdf= new fPDF("portrait","pt","A4");

$pdf->setLineWidth(1);// Definindo a margem das cedulas

$pdf->AddPage();
// ###  CARREGANDO OS DADOS DO CLIENTE NA TELA ### //
           $log = mysql_query("SELECT cliNome, cliEndereco, cliNumero, cliCelular, cliMoto, cliPlaca, orcItensResponsavel, orcItensData FROM clientes INNER JOIN orcamento_itens ON orcamento_itens.orcItensCliente_fk = clientes.cliCodigo WHERE orcamento_itens.orcItens_fk = '$orcamento'");
           while($_obj = mysql_fetch_array($log))
            {
                 $nome       = $_obj['cliNome'];  // NOME DO CLIENTE PARA CARREGAR NO FORMULARIO DE ENVIO DE EMAIL //
                 $celular    = $_obj['cliCelular'];  // NUMERO DO CELULAR DO CLIENTE //
                 $placa       = $_obj['cliPlaca'];  // PLACA DA MOTO DO CLIENTE //
                 $data        = $_obj['orcItensData'];  // DATA DO ORÇAMENTO //
                 $responsavel = $_obj['orcItensResponsavel'];  // NOME DO RESPONSÁVEL DO PEDIDO //
            }




 
$pdf->Cell(10,10,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE A IMAGEM E O CABEÇÁRIO //


$pdf->Image('img/logo.jpg');
$pdf->SetFont('arial','B',12);
$pdf->SetFontSize(12);
$pdf->Cell(00,10,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE O CABEÇÁRIO E A GRID //
$pdf->Cell(00,20,utf8_decode("Orçamento.: ".$orcamento),0,0,'L');
$pdf->Cell(00,20,"Data : ".$data,0,1,'R');
$pdf->Cell(00,20,utf8_decode("Cliente : ".$nome),0,1,'L');
$pdf->Cell(00,20,utf8_decode("Celular : ".$celular),0,0,'L');
$pdf->Cell(00,20,utf8_decode("Responsável : ".$responsavel),0,0,'R');
$pdf->Cell(0,1,"","B",1,'C');
$pdf->Ln(8);
 
$pdf->Cell(60,20,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE A IMAGEM E O CABEÇÁRIO //
// ################################################################################################ //

// CABECALHO DA TABELA //
$pdf->SetFont('arial','B',8);
$pdf->SetFontSize(8);
$pdf->Cell(60,30,"ITEM",1,0,"C");
$pdf->Cell(35,30,"QUANT",1,0,"C");
$pdf->Cell(385,30,utf8_decode("DESCRIÇÃO"),1,0,"C");
$pdf->Cell(60,30,utf8_decode("PREÇO"),1,0,"C");


 $pdf->ln();
$pdf->SetFont('Arial','B',06);
//Table with 32 rows and 4 columns
//$pdf->SetWidths(array(50,50));
srand(microtime()*1000000);

$content = mysql_query("SELECT * FROM orcamento_itens WHERE orcItens_fk = '$orcamento'");

while($cont = mysql_fetch_array($content))
{  
     $pdf->SetFont('arial','B',8);
     $pdf->SetFontSize(7);

     $pdf->SetFillColor(255);

     $pdf->Cell(60, 20, $cont['orcItensIdProduto_fk'], 1, 0, 'L');
     $pdf->SetFontSize(8);
     $pdf->Cell(35, 20, $cont['orcItensQuantidade'], 1, 0, 'C');
     $pdf->SetFontSize(6);
     $pdf->Cell(385, 20, $cont['orcItensDescricao'], 1, 0, 'L');
     $pdf->SetFontSize(8);
     $pdf->Cell(60, 20, "R$ ".$cont['orcItensTotal'], 1, 0, 'L');
   
     
     $pdf->ln();


     // $pdf->Row(array($obk['patrimonio'],$obk['item'],$obk['inspTipoExtintor'],$obk['inspCargaNominal'],$obk['recarga'],$obk['reteste'],$obk['local_galpao'],$obk['inspItemNaoConformidade'],$obk['inspDataEnd']));
}
$pdf->ln();




     // $pdf->Row(array($obk['patrimonio'],$obk['item'],$obk['inspTipoExtintor'],$obk['inspCargaNominal'],$obk['recarga'],$obk['reteste'],$obk['local_galpao'],$obk['inspItemNaoConformidade'],$obk['inspDataEnd']));

$pdf->ln();
// ## VALOR FINAL DO ORÇAMENTO ## //
$sql = mysql_query("SELECT orcTotal,orcComentario FROM orcamento WHERE orcCodigo = '$orcamento'");
while($_sql = mysql_fetch_array($sql))
{
   $total      = $_sql['orcTotal'];
   $comentario = $_sql['orcComentario'];
}

//$pdf->Cell(10,20,'',0,0,"R");
$pdf->ln();
$pdf->SetFont('arial','B',8);
$pdf->SetFontSize(8);
$pdf->Cell(480,20,utf8_decode('VALOR TOTAL ORÇAMENTO:'),1,0,"L");$pdf->Cell(60,20,"R$ ".$total,1,0,"L");
//$pdf->Cell(10,20,'',0,0,"R");
$pdf->ln();







$pdf->ln();

 

/*for($i = 1; $i<=2; $i++)
{  
     
     $pdf->SetFont('arial','B',6);
     $pdf->SetFontSize(8);

     $pdf->SetFillColor(255);

     $pdf->Cell(100, 20, 'Line'. $i, 1, 0, 'C');
     $pdf->Cell(200, 20, 'Line'. $i, 1, 0, 'C');
     
     $pdf->ln();
}*/


$pdf->ln();



$pdf->ln();

/*for($i = 1; $i<=2; $i++)
{  
     $pdf->SetFont('arial','B',8);
     $pdf->SetFontSize(8);

     $pdf->SetFillColor(255);

     $pdf->Cell(150, 20, 'Line'. $i, 1, 0, 'C');
     $pdf->Cell(50, 20, 'Line'. $i, 1, 0, 'C');


CREATE TABLE naoConformidadesSoma (sumCodigo INT AUTO INCREMENT NOT NULL,sumInspecao INT NOT NULL,sumConformidade VARCHAR(30) NOT NULL,sumHora CHAR(8) NOT NULL,sumData CHAR(10),sumQtdNaoConformidades INT NOT NULL,sumTotalEquipamentos INT NOT NULL)


     
     $pdf->ln();
}*/

$pdf->ln();
$pdf->ln();$pdf->ln();


$pdf->SetFont('arial','B',8);
$pdf->SetFontSize(8);

$pdf->SetFillColor(255);
$pdf->Cell(100, 20, utf8_decode('ORÇAMENTO VÁLIDO POR 10 DIAS'), 0, 0, 'L');

$pdf->ln();$pdf->ln();$pdf->ln();
$pdf->Cell(100, 20, ' ', 'B', 0, 'C');
$pdf->Cell(100, 20, ' ', 'B', 0, 'C');
$pdf->Cell(100, 20, ' ', 0, 0, 'C');
$pdf->ln();

$pdf->Cell(70, 20, 'ASSINATURA', 0, 0, 'L');
$pdf->Cell(50, 20, ' ', 0, 0, 'C');
/*$pdf->Cell(50, 20, ' ', 0, 0, 'C');
$pdf->Cell(50, 20, ' ', 0, 0, 'C');
$pdf->Cell(100, 20, ' ', 0, 0, 'C');*/

$pdf->ln();

$pdf->Cell(70, 20, utf8_decode('OBSERVAÇÃO: ').$comentario, 0, 0, 'L');
$pdf->Cell(50, 20, ' ', 0, 0, 'C');


$pdf->Output("printerr.pdf","I");


/* ### FIM DE ROTINA  ###  */               


/* SELECT sum(case when inspIntempere=1 then 0 else 1 end)+sum(case when inspLacre=0 then 1 else 0 end)+sum(case when inspValidade=0 then 1 else 0 end)+sum(case when inspQuadro=0 then 1 else 0 end)+sum(case when inspAspecto=0 then 1 else 0 end)+sum(case when inspTransporte=0 then 1 else 0 end)+sum(case when inspCondicoes=0 then 1 else 0 end)+sum(case when inspCorpo=0 then 1 else 0 end)+sum(case when inspPonteiro=0 then 1 else 0 end)+sum(case when inspExistencia=0 then 1 else 0 end)+sum(case when insporificio=0 then 1 else 0 end)+sum(case when inspCO2=0 then 1 else 0 end)+sum(case when inspHidrante=0 then 1 else 0 end)+sum(case when inspCompleto=0 then 1 else 0 end)+sum(case when inspEsguicho=0 then 1 else 0 end)+sum(case when inspMangueira=0 then 1 else 0 end)+sum(case when inspChave=0 then 1 else 0 end)+sum(case when inspHidObstruido=0 then 1 else 0 end)+sum(case when inspDemarSolo=0 then 1 else 0 end)+sum(case when inspPlaca=0 then 1 else 0 end)+sum(case when inspAdaptador=0 then 1 else 0 end)+sum(case when inspVidro=0 then 1 else 0 end) FROM inspecao_item WHERE inspIdInspecao_fk = 937 */
 //    SELECT sum(case when inspIntempere=1 then 1 else 0 end) FROM inspecao_item WHERE inspIdInspecao_fk = 937

//SELECT SUM(inspIntempere.a+inspLacre.b) FROM (SELECT COUNT(inspIntempere) AS a, COUNT(inspLacre) AS b FROM `inspecao_item` WHERE inspIdInspecao_fk = 937 AND inspIntempere = 1 OR inspLacre = 0)
//SELECT COUNT(inspIntempere) AS a, COUNT(inspLacre) AS b FROM `inspecao_item` WHERE inspIdInspecao_fk = 937 AND inspIntempere = 1 AND inspLacre = 0
 /*    $pdf->ln();
}*/
?>                 