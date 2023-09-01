<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 20AGO22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 20AGO22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 20AGO22

     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20AGO22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 18SET22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    ROTINA DE CALCULO DE ICMS E ISS DO MÓDULO DE PEDIDO  */
     
     $usuario = $_SESSION['usuario'];  // VARIÁVEL DE SESSÃO, QUE VEM COM O NOME DO USUÁRIO LOGADO //
     $data = Date('d/m/Y');
     $hora = Date('H:i:s');
     define("ISS",2.01); // DEFININDO A CONSTANTE //
     define("ICMS",1.36);// DEFININDO CONTANTE //
     require 'Utilidades/conexao.php';

     // ## BUSCA O ULTIMO REGISTRO INSERIDO NA TABELA  ## //
     $sql = mysql_query("SELECT pedIteIdProduto_fk,pedItePedido_fk,pedIteTotal FROM pedido_itens");
     while($obj = mysql_fetch_array($sql))
     {
         $valor  = $obj['pedIteTotal']; // VALOR DO ITEM SOMADO CASO VENHA COM MAIS DE UM - VALOR TOTAL //
         $codigo = $obj['pedIteIdProduto_fk']; // CODIGO ID DA MERCADORIA //
         $pedido = $obj['pedItePedido_fk']; // CÓDIGO DO PEDIDO //
     }


                //  INSERE A ALIQUOTA DA MERCADORIA NA TABELA DE ALIQUOTAS MAS ANTES FAZ O CALCULO DA ALIQUOTA //
                if($codigo == "0")
                {
                      $iss = ($valor * ISS); // DESMEMBRANDO O VALOR DO ISS //
                      $iss = ($iss/100);
                      mysql_query("INSERT INTO aliquota (aliPedido,aliBruto,aliValor,aliISS,aliHora,aliData,aliAliquota,aliIdMercadoria) VALUES ('$pedido','$valor',$iss','$iss','$hora','$data',2.01,$codigo)");
                } 

                else
                {
                     $icms = ($valor * ICMS); // DESMEMBRANDO O VALOR DO ICMS //
                     $icms = ($icms/100);
                     mysql_query("INSERT INTO aliquota (aliPedido,aliBruto,aliValor,aliICMS,aliHora,aliData,aliAliquota,aliIdMercadoria) VALUES ('$pedido','$valor','$icms','$icms','$hora','$data',1.36,$codigo)");
                }
                


     ?>