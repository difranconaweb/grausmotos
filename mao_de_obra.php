<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 ####   ARQUIVO PARA INSERIR A MÃO DE OBRA  ###  */
    require 'Utilidades/conexao.php';

    $data            = Date('d/m/Y');                    // CRIA A DATA DO SERVER //
    $dia             = Date('d');                        // CRIA O DIA //
    $mes             = Date('m');                        // CRIA O MÊS //
    $ano             = Date('Y');                        // CRIA O ANO //
    $obra            = strtoupper(trim($_GET['obra']));  // DESCRIÇÃO DA MÃO DE OBRA //
    $m_obra          = $_GET['m_obra'];                  // VALOR DA MÃO DE OBRA //
    $orcamento       = $_GET['orcamento'];               // NÚMERO DO ORÇAMENTO   //
    $valor_orcamento = $_GET['valor_orcamento'];         // VALOR DO ORÇAMENTO QUE SERÁ SOMANDO COM A MAO DE OBRA //
    $usuario         = $_GET['usuario'];                 // ´VARIÁVEL RECEBE O USUÁRIO //
    $id_cliente      = $_GET['id_cliente'];              // ´VARIÁVEL RECEBE O ID DO CLIENTE //

    $sql = mysql_query("SELECT orcTotal FROM orcamento WHERE orcCodigo = '$orcamento'");
    while($obj = mysql_fetch_array($sql))
    {
         $valor = $obj['orcTotal'];
    }

    $valor = ($valor+$m_obra); // SOMA OS VALORES //


    // ATUALIZA A TABELA DE PEDIDOS //
    mysql_query("UPDATE orcamento  SET orcTotal = '$valor' WHERE orcCodigo = '$orcamento'");  

    // ATUALIZA A TABELA DE ITENS DO PEDIDO  //
   $iten = mysql_query("INSERT INTO orcamento_itens (orcItensQuantidade,orcItensDescricao,orcItensPreco,orcItensTotal,orcItensResponsavel,orcItensData,orcItens_fk,orcItensCliente_fk,orcItensIdProduto_fk,orcItensDia,orcItensMes,orcItensAno) VALUES (1,'$obra','$m_obra','$m_obra','$usuario','$data','$orcamento','$id_cliente',0,'$dia','$mes','$ano')");

    if(empty($iten))
    {
        print 0;
    }

    else
    {
        print 1;
    }
?>