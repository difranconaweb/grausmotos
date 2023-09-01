<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06JUN21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 31JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08SET22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    ROTINA DE PEDIDOS PARA EXCLUIR ITEM DE MERCADORIA DE PEDIDO  */
    require 'Utilidades/conexao.php';
    
    $codigoPedido    = $_REQUEST['codigoGrid'];
    $idProduto       = $_REQUEST['pedIteIdProduto_fk'];
    $quantidade      = $_REQUEST['quantidade'];
 
    // ## BUSCANDO A QUANTIDADE QUE CONSTA NO ESTOQUE
    $sql = mysql_query("SELECT merQuantidade FROM mercadorias WHERE merCodigo = '$idProduto'");
    while($obj = mysql_fetch_array($sql))
    {
         $quant = $obj['merQuantidade'];
    }
    
    // ## SOMANDO O QUE TEM NA TABELA COM A ORDEM DE EXCLUSÃO ## //
    $quant = $quantidade+$quant;

    // ## ATUALIZANDO A TABELA DE MERCADORIAS / DEVOLVENDO O PRODUTO NA PRATELEIRA ## //
    mysql_query("UPDATE mercadorias SET merQuantidade = '$quant' WHERE merCodigo = '$idProduto'");


    // ## REMOVENDO DA TABELA DE ITENS O QUE FOI PEDIDO PARA SER APAGADO ## //
     mysql_query("DELETE FROM pedido_itens WHERE pedIteIdProduto_fk = '$idProduto' AND pedItePedido_fk = '$codigoPedido'");

    // ## REMOVENDO DA TABELA DE ALIQUOTA O VALO REMOVIDO ## //
     mysql_query("DELETE FROM aliquota WHERE aliIdMercadoria = '$idProduto' AND aliPedido = '$codigoPedido'");
    
   // ##  SOMA O VALOR DOS ITENS NA TABELA DE ITENS PARA ATUALIZAR O VALOR TOTAL DO PEDIDO NA TABELA DE PEDIDO  ## //
     // BUSCA VALOR DE PEDIDO E DE DESCONTO
     $_sql = mysql_query("SELECT sum(pedIteTotal) AS somatoria, pedDesconto FROM pedido_itens LEFT JOIN pedidos ON pedido_itens.pedItePedido_fk = pedidos.pedCodigo WHERE pedItePedido_fk = '$codigoPedido'");
     while($_d = mysql_fetch_array($_sql))
     {
          $desconto = $_d['pedIteDesconto']; //  BUSCA O VALOR DO DESCONTO EMPREGADO //
          $total    = $_d['somatoria']; // BUSCA O VALOR TOTAL DO PEDIDO PARA ATUALIZAR A TABELA DE PEDIDO E PAGAMENTO //
     } 

    
     // ### PEGA O VALOR DO PEDIDO BEM COMO O DESCONTO E LANÇA O VALOR REAL NA TABELA ### //
     
     $total = ($total - $desconto); // VALOR COM O DESCONTO //
     mysql_query("UPDATE pedidos SET pedValor = '$total'  WHERE pedCodigo = '$codigoPedido'");
     mysql_query("UPDATE $usuario SET Valor = '$total'"); // ## ATUALIZANDO A TABELA DEDICADA ## //
     mysql_query("UPDATE pagamentos SET pagValor = '$total' WHERE pagPedido_fk = '$codigoPedido'");

     // ###  FINAL DE ROTINA DE ATUALIZAÇÃO  ### //


// VOLTA PARA A PÁGINA DE PEDIDO //
    header('Location:http://www.grausmotos.com.br/controller.php'); 

?>