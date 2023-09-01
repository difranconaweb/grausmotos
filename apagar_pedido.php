<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 11MAI21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 11MAI21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 11MAI21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03OUT21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08MAI22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 31JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29OUT22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 02AGO23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    ROTINA DE PEDIDOS PARA APAGAR ITEM DO PEDIDO  */
     require 'Utilidades/conexao.php';

     $pedido   = $_GET['pedido'];  // TRAZ O NÚMERO DO PEDIDO  //
     $usuario  = $_GET['usuario']; // TRAZ O NOME DO USUÁRIO PARA A TABELA TEMPORÁRIA //

     
     $ite = mysql_query("SELECT pedIteItem_fk, pedIteQuantidade FROM pedido_itens WHERE pedItePedido_fk = '$pedido'");
     $linhas = mysql_num_rows($ite);  // ENCONTRA A QUANTIDADE DE LINHAS DESTE PEDIDO //
     

     for($x=0; $x < $linhas; $x++)  // FOR PARA RODAR A QUANTIDADE DE VEZES CORRESPONDENTE A QUANTIDADE DE REGISTROS NA TABELA DE ITENS //
     {
           $ite = mysql_query("SELECT pedIteItem_fk, pedIteQuantidade FROM pedido_itens WHERE pedItePedido_fk = '$pedido'");
           while($d = mysql_fetch_array($ite))
           {
                 $idItem   = $d['pedIteItem_fk'];   //  BUSCA O ID DO ITEM NA TABELA DE ITENS //
                 $quant    = $d['pedIteQuantidade'];   //  BUSCA A QUANTIDADE DESTE ITEM QUE FOI COLOCADO PARA A VENDA E QUE SERÁ DEVOLVIDO //
           } 

           $me = mysql_query("SELECT merQuantidade FROM mercadorias WHERE merCodigoProduto LIKE '$idItem'");  // BUSCA A QUANTIDADE EM ESTOQUE  //
           while($ob = mysql_fetch_array($me))
           {
                 $quantidade = $ob['merQuantidade'];   // VALOR QUE ESTÁ NO ESTOQUE  //
           }

           $quantidade = ($quantidade + $quant);   // SOMA O ESTOQUE COM A QUANTIA QUE SERÁ DEVOLVIDA //

           // ATUALIZA A TABELA DE ESTOQUE  //
          $sql =  mysql_query("UPDATE mercadorias  SET merQuantidade = '$quantidade' WHERE merCodigoProduto LIKE '$idItem'");  
           
           // APAGA O (ITEM DA TABELA DE ITENS DE PEDIDO  //
           mysql_query("DELETE FROM pedido_itens WHERE pedIteItem_fk LIKE '$idItem' AND pedItePedido_fk = '$pedido'");
     }


    // REMOVE FINALMENTE O PEDIDO DA TABELA PRINCIPALE TEMPORÁRIA //
        $sql =  mysql_query("DELETE FROM pedidos WHERE pedCodigo = '$pedido'"); 

        // REMOVE O PEDIDO DA TABELA DE PAGAMENTOS //
        mysql_query("DELETE FROM pagamentos WHERE pagPedido_fk = '$pedido'");     

        // REMOVE O PEDIDO DA TABELA TEMPORÁRIA //
        mysql_query("DELETE FROM $usuario");     

        // REMOVE O PEDIDO DA TABELA DE CAIXA SE HOUVER //
        mysql_query("DELETE FROM caixa WHERE caxIdPedido_fk = '$pedido'");

         // ## REMOVENDO DA TABELA DE ALIQUOTA OS REGISTROS DO PEDIDO ## //
        mysql_query("DELETE FROM aliquota WHERE aliPedido = '$pedido'");

        // ATUALIZA A TABELA DE PONTEIRO //
        mysql_query("UPDATE ponteiro SET ponPonteiro = 5 WHERE ponResponsavel = '$usuario'");

        // CASO HAJA NOTA FISCAL EMITIDA, ENTAO AO APAGAR, REMOVERÁ DA TABELA DE NOTA FISCAL TAMBÉM //
        mysql_query("DELETE FROM ntafiscal WHERE ntNumero = '$pedido'");


        // PEGA O ÚLTIMO REGISTRO NA TABELA DE PEDIDOS  //
        $ult = mysql_query("SELECT pedCodigo,pedCliente_fk,pedHora,pedData,pedResponsavel,pedValor,pedDesconto,pedKm,pedMecanico FROM pedidos WHERE pedResponsavel = '$usuario'");
        while($_ult = mysql_fetch_array($ult))
        {
           $pedCodigo      = $_ult['pedCodigo'];// NUMERO DO PEDIDO //
           $pedCliente     = $_ult['pedCliente_fk']; // CODIGO DO CLIENTE //
           $pedHora        = $_ult['pedHora']; // HORA DO PEDIDO //
           $pedData        = $_ult['pedData']; // DATA DO PEDIDO //
           $pedResponsavel = $_ult['pedResponsavel']; // RESPONSAVEL DO PEDIO //
           $pedTotal       = $_ult['pedValor']; // TOTAL DO PEDIDO //
           $pedDesconto    = $_ult['pedDesconto']; // DESCONTO DO PEDIDO //
           $pedKm          = $_ult['pedKm']; // KILOMETRAGEM //
           $pedMecanico    = $_ult['pedMecanico']; // MECANICO //
        }

        // INSERE O ULTIMO PEDIDO COLETADO NA TABELA TEMPORÁRIA //
         mysql_query("INSERT INTO $usuario (Codigo,Cliente_fk,Codigo_fk,Hora,Data,Responsavel,Total,Desconto,Pedido_fk,Mecanico) VALUES ('$pedCodigo','$pedCliente','$pedCodigo','$pedHora','$pedData','$pedResponsavel','$pedTotal','$pedDesconto','$pedKm','$pedMecanico')");    

         // ATUALIZANDO A  PÁGINA DE CONTAINER_PEDIDO  //
         mysql_query("UPDATE container_pedido SET conCodigoPedido_fk = '$pedCodigo' WHERE conResponsavel = '$usuario'");

     //  VERIFICA SE A QUERY NAO VOLTOU VAZIA/ERRO E RESPONDE AO USUÁRIO COM JAVASCRIPT  //
     if(empty($sql))
     {
          print 0;
     }

     else
     {
          print 1;
     }
?>
