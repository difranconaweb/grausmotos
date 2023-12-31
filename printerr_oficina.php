<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUL22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUL22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 26JUL22

  
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08NOV22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 
<!-- ####   ARQUIVO PARA IMPRESSÃO EM PDF - OFICINA  ###  */


session_start();  //  INICIALIZA A SESSÃO //
require 'Utilidades/conexao.php';  // CONEXAO COM O BANCO DE DADOS //
require_once("pdf/fpdf.php");
//require('mc_table.php');

 $usuario    = $_SESSION['usuario'];  //  ####   VARIÁVEL DE SESSÃO COM NOME DO RESPONSAVEL DO ORÇAMENTO  #####  //
 $orcamento  = $_REQUEST['orcamento']; // ### RECEBE O NÚMERO DO ORCAMENTO ### //


 
$pdf= new fPDF("portrait","pt","A4");

$pdf->setLineWidth(1);// Definindo a margem das cedulas

$pdf->AddPage();
// ###  CARREGANDO OS DADOS DO CLIENTE NA TELA ### //
/*SELECT cliNome, cliEndereco, cliNumero, cliCelular, cliMoto, cliPlaca, pedIteResponsavel, pedIteKm, pedIteData FROM clientes INNER JOIN pedidos_itens ON pedido_itens.pedIteCliente_fk = clientes.cliCodigo WHERE pedido_itens.pedItePedido_fk = '$pedido'*/
           $log = mysql_query("SELECT cliNome, cliEndereco, cliNumero, cliCelular, cliMoto, cliPlaca, orcResponsavel, orcData FROM clientes INNER JOIN orcamento ON orcamento.orcCliente_fk = clientes.cliCodigo WHERE orcamento.orcCodigo = '$orcamento'");
           while($_obj = mysql_fetch_array($log))
            {
                 $nome        = $_obj['cliNome'];  // NOME DO CLIENTE PARA CARREGAR NO FORMULARIO DE ENVIO DE EMAIL //
                 $celular     = $_obj['cliCelular'];  // NUMERO DO CELULAR DO CLIENTE //
                 $moto        = $_obj['cliMoto'];  // MODELO DA MOTO //
                 $placa       = $_obj['cliPlaca'];  // PLACA DA MOTO DO CLIENTE //
                 $data        = $_obj['orcData'];  // DATA DO PEDIDO //
                 $responsavel = $_obj['orcResponsavel'];  // NOME DO RESPONSÁVEL DO ORCAMENTO //
            }




 
$pdf->Cell(10,10,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE A IMAGEM E O CABEÇÁRIO //


$pdf->Image('img/logo.jpg');
$pdf->SetFont('arial','B',12);
$pdf->SetFontSize(12);
$pdf->Cell(00,10,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE O CABEÇÁRIO E A GRID //
$pdf->Cell(00,20,"Pedido.: ".$pedido,0,0,'L');
$pdf->Cell(00,20,"Data : ".$data,0,1,'R');
$pdf->Cell(00,20,utf8_decode("Cliente : ".$nome),0,1,'L');
$pdf->Cell(00,20,"Celular : ".$celular,0,1,'L');
$pdf->Cell(00,20,"Moto : ".$moto,0,0,'L');
$pdf->Cell(00,20,"Placa : ".$placa,0,1,'R');
$pdf->Cell(00,20,utf8_decode("Responsável : ".$responsavel),0,0,'L');
$pdf->Cell(0,1,"","B",1,'C');

$pdf->Ln(8);
$pdf->Ln();
 
$pdf->Cell(60,20,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE A IMAGEM E O CABEÇÁRIO //
// ################################################################################################ //

// CABECALHO DA TABELA //
$pdf->SetFont('arial','B',8);
$pdf->SetFontSize(8);
$pdf->Cell(60,30,"ITEM",1,0,"C");
$pdf->Cell(35,30,"QUANT",1,0,"C");
$pdf->Cell(440,30,utf8_decode("DESCRIÇÃO"),1,0,"C");


$pdf->ln();
$pdf->SetFont('Arial','B',06);
//Table with 32 rows and 4 columns
//$pdf->SetWidths(array(50,50));
srand(microtime()*1000000);

$content = mysql_query("SELECT * FROM orcamento_itens WHERE orcItens_fk = '$orcamento'");

while($cont = mysql_fetch_array($content))
{  
     $pdf->SetFont('arial','B',8);
     $pdf->SetFontSize(8);

     $pdf->SetFillColor(255);

     $pdf->Cell(60, 20, $cont['orcItensIdProduto_fk'], 1, 0, 'L');
     $pdf->Cell(35, 20, $cont['orcItensQuantidade'], 1, 0, 'C');
     $pdf->Cell(440, 20, $cont['orcItensDescricao'], 1, 0, 'L');
     
     $pdf->ln();
}

    
/*for($i = 1; $i<=2; $i++)
{  
     
     $pdf->SetFont('arial','B',6);
     $pdf->SetFontSize(8);

     $pdf->SetFillColor(255);

     $pdf->Cell(100, 20, 'Line'. $i, 1, 0, 'C');
     $pdf->Cell(200, 20, 'Line'. $i, 1, 0, 'C');
     
     $pdf->ln();
}*/


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


$pdf->SetFont('arial','B',8);
$pdf->SetFontSize(8);

$pdf->ln();$pdf->ln();$pdf->ln();
$pdf->Cell(100, 20, ' ', 'B', 0, 'C');
$pdf->Cell(100, 20, ' ', 'B', 0, 'C');
$pdf->Cell(100, 20, ' ', 'B', 0, 'C');
$pdf->Cell(100, 20, ' ', 'B', 0, 'C');

$pdf->Cell(100, 20, ' ', 0, 0, 'C');
$pdf->ln();




$objCo = mysql_query("SELECT pedGarantia, pedComentario FROM pedidos WHERE pedCodigo = '$pedido'"); 
                        while($objC = mysql_fetch_array($objCo))
                         {
                               $validade    = $objC['pedGarantia'];
                               $comentarios = $objC['pedComentario'];
                         }
$pdf->Cell(70, 20, utf8_decode('OBS.: MECÂNICO RESPONSÁVEL PELA MÃO DE OBRA'), 0, 1, 'L');

$pdf->Cell(70, 20, 'MECANICO.:__________________________________________________________________.', 0, 1, 'L');
$pdf->Cell(70, 20, utf8_decode('COMENTÁRIOS :').$comentarios, 0, 1, 'L');
$pdf->Cell(50, 20, ' ', 0, 0, 'C');


$pdf->Output("printerr_oficina.pdf","I");


/* ### FIM DE ROTINA  ###  */               


/* SELECT sum(case when inspIntempere=1 then 0 else 1 end)+sum(case when inspLacre=0 then 1 else 0 end)+sum(case when inspValidade=0 then 1 else 0 end)+sum(case when inspQuadro=0 then 1 else 0 end)+sum(case when inspAspecto=0 then 1 else 0 end)+sum(case when inspTransporte=0 then 1 else 0 end)+sum(case when inspCondicoes=0 then 1 else 0 end)+sum(case when inspCorpo=0 then 1 else 0 end)+sum(case when inspPonteiro=0 then 1 else 0 end)+sum(case when inspExistencia=0 then 1 else 0 end)+sum(case when insporificio=0 then 1 else 0 end)+sum(case when inspCO2=0 then 1 else 0 end)+sum(case when inspHidrante=0 then 1 else 0 end)+sum(case when inspCompleto=0 then 1 else 0 end)+sum(case when inspEsguicho=0 then 1 else 0 end)+sum(case when inspMangueira=0 then 1 else 0 end)+sum(case when inspChave=0 then 1 else 0 end)+sum(case when inspHidObstruido=0 then 1 else 0 end)+sum(case when inspDemarSolo=0 then 1 else 0 end)+sum(case when inspPlaca=0 then 1 else 0 end)+sum(case when inspAdaptador=0 then 1 else 0 end)+sum(case when inspVidro=0 then 1 else 0 end) FROM inspecao_item WHERE inspIdInspecao_fk = 937 */
 //    SELECT sum(case when inspIntempere=1 then 1 else 0 end) FROM inspecao_item WHERE inspIdInspecao_fk = 937

//SELECT SUM(inspIntempere.a+inspLacre.b) FROM (SELECT COUNT(inspIntempere) AS a, COUNT(inspLacre) AS b FROM `inspecao_item` WHERE inspIdInspecao_fk = 937 AND inspIntempere = 1 OR inspLacre = 0)
//SELECT COUNT(inspIntempere) AS a, COUNT(inspLacre) AS b FROM `inspecao_item` WHERE inspIdInspecao_fk = 937 AND inspIntempere = 1 AND inspLacre = 0
 /*    $pdf->ln();
}*/
?>                 