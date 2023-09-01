<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04NOV21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11DEZ21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 27JUN22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 ####   ARQUIVO PARA APAGAR ORÇAMENTO  ###  */
     require 'Utilidades/conexao.php';

     $orcamento = $_GET['orcamento'];
     $usuario   = $_GET['usuario'];
     $data      = Date('d/m/Y');

    

    // ##  LIMPANDO AS TABELA DO ORÇAMENTO QUE ESTÁ SENDO APAGADO ## //
    $sql      =  mysql_query("DELETE FROM orcamento WHERE orcCodigo = '$orcamento'");
    $sqlItens =  mysql_query("DELETE FROM orcamento_itens WHERE orcitens_fk = '$orcamento'");
     // ## ATUALIZANDO A TABELA DEDICADA  ## //
     mysql_query("DELETE FROM $usuario");

     // ## BUSCANDO NA TABELA ULTIMO PEDIDO FEITO PELO USUARIO LOGADO  ## //
     $bsk = mysql_query("SELECT orcCodigo,orcCliente_fk,orcTotal,orcHora,orcData FROM orcamento WHERE orcResponsavel = '$usuario'");
     while($_bsk = mysql_fetch_array($bsk))
     {
          $codigo  = $_bsk['orcCodigo'];
          $cliente = $_bsk['orcCliente_fk'];
          $total   = $_bsk['orcTotal'];
          $orcHora = $_bsk['orcHora'];
          $orcData = $_bsk['orcData'];
     }


    // ## SALVANDO DADOS NA TABELA DE CONTAINER  ## //
     mysql_query("UPDATE container SET conStatus = 0,conCodigoCliente = '$cliente',conCodigoOrcamento_fk = '$codigo',conTabela = 1,data = '$data' WHERE conResponsavel = '$usuario'");
     // ## INSERINDO REGISTRO NA TABELA TEMPORÁRIA ## //
     mysql_query("INSERT INTO $usuario (Codigo,Cliente_fk,Codigo_fk,Hora,Data,Responsavel,Total,Pedido_fk,Orcamento_fk) VALUES ('$codigo','$cliente','$codigo','$orcHora','$orcData','$usuario','$total',0,'$codigo')");


    

     if(empty($sql) || empty($sqlItens))
     {
          print 0;
     }

     else
     {
          print 1;
     }
?>