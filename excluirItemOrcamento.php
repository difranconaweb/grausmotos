<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 15JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08SET22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 ####   ARQUIVO PARA EXCLUIR ITEM DE ORÇAMENTO  ###  */
     require 'Utilidades/conexao.php';
    
    $codigoOrcamento = $_REQUEST['codigoGrid'];
    $codigoCliente   = $_REQUEST['codigoCliente'];
    $idProduto       = $_REQUEST['orcItensIdProduto_fk'];
    $usuario         = $_REQUEST['orcUsuario'];

    mysql_query("DELETE FROM orcamento_itens WHERE orcItensIdProduto_fk = '$idProduto' AND orcItens_fk = '$codigoOrcamento'");
    $vl = mysql_query("SELECT SUM(orcItensTotal) AS VALOR from orcamento_itens WHERE orcItens_fk = '$codigoOrcamento'");
     while($objVl = mysql_fetch_array($vl))
     {
          $valorOrcamentoNovo = $objVl['VALOR'];
     }
     // ATUALIZANDO TABELA DE ORÇAMENTO E TABELA DEDICADA D USUARIOS //
     mysql_query("UPDATE orcamento SET orcTotal = '$valorOrcamentoNovo' WHERE orcCodigo = '$codigoOrcamento'");
     mysql_query("UPDATE $usuario SET Valor = '$valorOrcamentoNovo', Orcamento_fk = '$codigoOrcamento' WHERE Codigo_fk = '$codigoOrcamento' AND Responsavel = '$usuario'");

     // ## ATUALIZANDO  TABELA DE CONTAINER ## //
     mysql_query("UPDATE container SET conStatus = 0, conCodigoCliente = '$codigoCliente'");

     header('Location:http://www.grausmotos.com.br/controller.php');

?>