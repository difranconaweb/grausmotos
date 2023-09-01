<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 
<!-- ####   ARQUIVO PARA IMPRESSÃO EM PDF  ###  */


session_start();  //  INICIALIZA A SESSÃO //
require 'Utilidades/conexao.php';  // CONEXAO COM O BANCO DE DADOS //

$codigoOrcamento = $_SESSION['codigoOrcamento']; /* ####    VARIÁVEL QUE RECEBE NUMERO DO ORÇAMENTO PARA IMPRESSÃO  #### */
$usuario         = $_SESSION['usuario'];         /*  ####   VARIÁVEL DE SESSÃO COM NOME DO RESPONSAVEL DO ORÇAMENTO  ##### */

/* ### INICIO DE ROTINA PARA CARREGAR O ORÇAMENTO - REFERÊNCIA, VARÁVEL DE SESSÃO  ###  */
  /*       $sql = mysql_query("SELECT cliNome, cliEndereco, cliNumero, cliTelefone, cliVeiculo, cliPlaca, orcResponsavel FROM clientes INNER JOIN orcamento ON orcamento.orcCliente_fk = clientes.cliCodigo WHERE orcamento.orcCodigo = '$codigoOrcamento'");
         while($res = mysql_fetch_array($sql))
         {
             $objCliente     = $res['cliNome'];
             $objEndereco    = $res['cliEndereco'];
             $objNumero      = $res['cliNumero'];
             $objTelefone    = $res['cliCelular'];
             $objVeiculo     = $res['cliVeiculo'];
             $objPlaca       = $res['cliPlaca'];
             $objResponsavel = $res['orcResponsavel'];
         }*/
 
require_once("pdf/fpdf.php");
 
$pdf= new fPDF("P","pt","A4");

$pdf->AddPage();
//$pdf->Image('img/logo.jpg'); /* pdf-128.jpg */

 
$pdf->Cell(60,20,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE A IMAGEM E O CABEÇÁRIO //

$pdf->SetFont('arial','B',15);
$pdf->Cell(00,30,utf8_decode("Orçamento.:  $codigoOrcamento"),1,1,'C');
$pdf->Cell(0,1,"","B",1,'C');
$pdf->Ln(8);
 
 
// NOME //
$pdf->SetFont('arial','B',10);
$pdf->Cell(70,20,"Nome.:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$objCliente,0,1,'L');
 

// ENDEREÇO //
$pdf->SetFont('arial','B',10);
$pdf->Cell(70,20,utf8_decode("Endereço.:"),0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$objEndereco,0,1,'L');
 
// NÚMERO //
$pdf->SetFont('arial','B',10);
$pdf->Cell(70,20,"Numero.:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$objNumero,0,1,'L');
 
// TELEFONE //
$pdf->SetFont('arial','B',10);
$pdf->Cell(70,20,"Telefone.:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$objTelefone,0,1,'L');
 
// MOTO //
$pdf->SetFont('arial','B',10);
$pdf->Cell(70,20,"Veiculo.:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$objVeiculo,0,1,'L');

// PLACA //
$pdf->SetFont('arial','B',10);
$pdf->Cell(70,20,"Placa.:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$objPlaca,0,1,'L');

$pdf->Cell(60,20,'',0,1,"L");//  ESTA LINHA FOI CRIADA PARA DAR ESPAÇO ENTRE O CABEÇÁRIO E A GRID //

// CABECALHO DA TABELA //
$pdf->SetFont('arial','B',10);
$pdf->Cell(60,20,'ITEM',1,0,"L");
$pdf->Cell(50,20,'QUANT',1,0,"L");
$pdf->Cell(370,20,utf8_decode('DESCRIÇÃO'),1,0,"L");
$pdf->Cell(60,20,'VALOR',1,1,"L");
 
// INICIANDO AS LINHAS DA TABELA //
$pdf->SetFont('arial','',06);
$it = mysql_query("SELECT * FROM orcamento_itens WHERE orcItens_fk = '$codigoOrcamento'");
    while($res = mysql_fetch_array($it))
    {
       $pdf->Cell(60,20,$res['orcItensIdProduto_fk'].$i,1,0,"L");
       $pdf->Cell(50,20,$res['orcItensQuantidade'],1,0,"L");
       $pdf->Cell(370,20,$res['orcItensDescricao'],1,0,"L");
       $pdf->Cell(60,20,$res['orcItensTotal'],1,1,"L");
    }
// FINAL DE LINHAS DA TABELA //

// INICIANDO O VALOR TOTAL DO ORÇAMENTO // 
$pdf->SetFont('arial','B',10);
$pdf->Cell(480,20,utf8_decode('VALOR TOTAL ORÇAMENTO.:'),1,0,"L");  
$objFinal = mysql_query("SELECT SUM(orcItensTotal) AS TOTAL FROM orcamento_itens WHERE orcItens_fk = '$codigoOrcamento'");
    while($objV = mysql_fetch_array($objFinal))
    {
       $valor_orcamento = $objV['TOTAL']; //  BUSCA E SOMA O VALOR TOTAL DO ORÇAMENTO //
    }
$pdf->Cell(60,20,$valor_orcamento,1,1,"L"); // IMPRIME O VALOR TOTAL DO ORÇAMENTO DENTRO DO CAMPO NA TABELA GERADA


$pdf->Output("printer.pdf","I");





/* ### FIM DE ROTINA  ###  */
?>                 