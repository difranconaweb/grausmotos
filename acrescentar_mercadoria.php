<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26MAR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 23MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01OUT21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20FEV22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 24MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08MAI22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 24JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20AGO22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29MAI23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    ROTINA DE PEDIDOS PARA ACRESCENTAR ITEM DO PEDIDO  */
     session_start();
     $usuario = $_SESSION['usuario'];  // VARIÁVEL DE SESSÃO, QUE VEM COM O NOME DO USUÁRIO LOGADO //

     require 'Utilidades/conexao.php';


     

     $data = Date('d/m/Y');
     $hora = Date('H:i:s');
     $dia  = Date('d');
     $mes  = Date('m');
     $ano  = Date('Y');


     $mercadoria       = $_GET['mercadoria'];
     $codigoMercadoria = $_GET['codigoMercadoria'];
     $quantidade       = $_GET['quantidade'];
     $preco            = $_GET['preco'];
     $total            = $_GET['total'];
     $usuario          = $_GET['usuario'];
     $pedido           = $_GET['pedido'];
     $idCliente        = $_GET['idCliente'];
     $valorPedido      = $_GET['valorPedido'];

     

       $mer   = mysql_query("SELECT merCodigo, merNCM, merCEST,merCodigoProduto, merQuantidade FROM mercadorias WHERE merCodigoProduto = '$codigoMercadoria'");
       while($me = mysql_fetch_array($mer))
       {
            $id    = $me['merCodigo']; // PEGA O CODIGO ID DA MERCADORIA //
            $quant = $me['merQuantidade'];
            $ncm   = $me['merNCM']; // CODIGO NCM DA MERCADORIA //
            $cest  = $me['merCEST'];// CODIGO CEST DA MERCADORIA //
       }

       
        //  ###   VERIFICA A QUANTIDADE EM ESTOQUE ### //
       if($quant == 0)
       {
          print 0;
       }

       else if($quantidade > $quant)
       {
             print 1;
       }

       else
       {    
               //  INSERE NA TABELA DE ITENS O QUE FOI SELECIONADO  //
               mysql_query("INSERT INTO pedido_itens (pedIteItem_fk,pedIteNCM,pedIteCest,pedIteQuantidade,pedIteDescricao,pedItePreco,pedIteTotal,pedIteResponsavel,pedIteData,pedItePedido_fk,
                pedIteCliente_fk,pedIteIdProduto_fk,pedIteDia,pedIteMes,pedIteAno)
               VALUES ('$codigoMercadoria','$ncm','$cest','$quantidade','$mercadoria','$preco','$total','$usuario','$data','$pedido','$idCliente', '$id','$dia','$mes','$ano')");

               //  INSERE A ALIQUOTA DA MRCADORIA NA TABELA DE ALIQUOTAS MAS ANTES FAZ O CALCULO DA ALIQUOTA // 
                $icms = ($pedIteTotal * 1.36)/100; // DESMEMBRANDO O VALOR DO ICMS //
                mysql_query("INSERT INTO aliquota (aliPedido,aliICMS,aliHora,aliData) VALUES ('pedItePedido_fk','$icms','$hora','$data')");


                //  DÁ BAIXA NA TABELA E MERCADORIAS O QUE FOI SELECIONADO //
              $quantidade = $quant - $quantidade;   //  ###   CALCULA DE ACORDO COM O PEDIDO E O ESTOQUE  ###  //
              mysql_query("UPDATE mercadorias SET merQuantidade = '$quantidade' WHERE merCodigo = '$id'");
             //  FIM DE BAIXAS //

               //  FAZ A SOMA DO VALOR E ATUALIZA A TABELA DE PEDIDO //
               $vl = mysql_query("SELECT SUM(pedIteTotal) AS VALOR, pedDesconto from pedidos RIGHT JOIN pedido_itens ON pedidos.pedCodigo = pedido_itens.pedItePedido_fk WHERE pedItePedido_fk = '$pedido'");
               while($objVl = mysql_fetch_array($vl))
               {
                  $valorPedidoNovo = $objVl['VALOR'];
                  $objDesconto     = $objVl['pedDesconto'];
               }

               //  ## AGORA FAZ A DIFERENÇA E MANDA PARA A QUERY PARA ATUALIZAR A TABELA  ##  //
               $valorPedidoNovo = ($valorPedidoNovo - $objDesconto);
              // ## ATUALIZA A TABELA TEMPORÁRIA ## //
              mysql_query("UPDATE $usuario SET Valor = '$valorPedidoNovo', Pedido_fk = 0 WHERE Codigo_fk = '$pedido'");
              // ## ATUALIZA A TABELA DE PEDIDO ## //
              mysql_query("UPDATE pedidos SET pedValor = '$valorPedidoNovo', pedPedido_fk = 0 WHERE pedCodigo = '$pedido'");
              // ## CHAMANDO ARQUIVO PARA FAZER CALCULO DE ICMS E ISS ## //
              include_once('calculista.php');
              print 2;
       }
?>