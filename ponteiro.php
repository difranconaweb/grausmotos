<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 14ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 12MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07JUN21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 28AGO21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29AGO21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 30AGO21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17ABR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

/* ### INICIO DE CONTROLE E DISTRIBUIÇÃO DE FUNÇÕES DE TODO O SISTEMA ###  */
require 'Utilidades/conexao.php';

    session_start(); // INICIA A SESSÃO //
    $ponteiro = 6;//$_REQUEST['sender']; // RECEBE NESTA VARIÁVEL O NOME DO USUARIO QUE VEM DO JAVASCRIPT NA PASTA MENU //
    $pesquisa = 12;//$_REQUEST['pesquisa']; // RECEBE NESTA VARIÁVEL O VALOR DA PESQUISA, QUE VEM COM O ID DO CLIENTE OU DA PESQUISA //
    $usuario  = 'FRANCO';//$_SESSION['usuario']; // CARREGA A VARIÁVEL COM O VALOR DA SESSÃO //

    // PEGANDO O HORARIO E A DATA NO SERVIDOR //
    $data = Date('d/m/Y');
    $hora = Date('H:i:s');

    /* ## SALVA O VALOR NA TABELA PARA INDICAR QUAL A TELA ## */
    /* VALOR - 1 PARA TELA DE MENU
       VALOR - 2 PARA TELA DE CLIENTES 
       VALOR - 3 PARA TELA DE FORNECEDOR
       VALOR - 4 PARA TELA DE MERCADORIAS
       VALOR - 5 PARA TELA DE PEDIDOS
       VALOR - 6 PARA TELA DE ORÇAMENTOS
       VALOR - 7 PARA TELA DE ADMINISTRADOR
       VALOR - 8 PARA FUNÇÃO DE IMPRESSÃO
       VALOR - 9 PARA FUNÇÃO DE CAIXA
       VALOR - 10 PARA FUNÇÃO DE RELATÓRIO CLIENTES
       VALOR - 11 PARA FUNÇÃO DE RELATÓRIO FORNECEDORES
       VALOR - 12 PARA FUNÇÃO DE RELATÓRIO MERCADORIAS
       VALOR - 13 PARA FUNÇÃO DE RELATÓRIO CAIXA
       VALOR - 14 PARA FUNÇÃO DE RELATÓRIO PEDIDOS
       VALOR - 15 PARA FUNÇÃO DE RELATÓRIO INDEX
       VALOR - 16 PARA FUNÇÃO DE RELATÓRIO COBRANÇA */

   

    /* ######################################################################################################################## */
    /* ###     SE VIER COM O PONTEIRO VALENDO - ENTÃO DEVERÁ DECIDIR O QUE FAZER                                            ### */
    /* ######################################################################################################################## */
    
    if($ponteiro == 5 || $ponteiro == 18)// SE VIER VALENDO 5 ou 18, PORQUE VAI APONTAR PARA OS ARQUIVOS DE PEDIDO E PEDIDO IA //
    {
       /* ## FAZ UMA PESQUISA NA TABELA PEDIDO PARA CARREGAR O ID DO CLIENTE COM O ID DO PEDIDO PARA INSERI-LO NA TABELA DE CONTAINER_PEDIDO ## */
         $sql = mysql_query("SELECT pedCliente_fk FROM pedidos WHERE pedCodigo = '$pesquisa'");
         while($obj = mysql_fetch_array($sql))
         {
            $objCliente = $obj['pedCliente_fk'];  // ID DO CLIENTE NESTA LINHA  //
         }

         // ## ATUALIZANDO A TABELA DE CONTAINER PEDIDO ## //
                mysql_query("UPDATE ponteiro SET ponPonteiro = $ponteiro, ponTabela = 1, ponDataInicial = '$data', ponHora = '$hora'
                  WHERE ponResponsavel = '$usuario'");

                mysql_query("UPDATE container_pedido SET conTabela = 1, conStatus = 0, conCodigoOrcamento_fk = '$pesquisa', conCodigoCliente = '$objCliente' WHERE conResponsavel = '$usuario'");
    }
// INSERE O ID DO ORCAMENTO NA TABELA DE CONTAINER, POSSA PESQUISAR O REGISTRO/ORÇAMENTO E CARREGAR NA TELA  //
    else if($ponteiro == 6 || $ponteiro == 17)
    {// ##  SE ENTRAR NESTE BLOCO, VEM PARA ORÇAMENTO ## //
          /* ## FAZ UMA PESQUISA NA TABELA ORÇAMENTO PARA CARREGAR O ID DO CLIENTE COM O ID DO ORÇAMENTO PARA INSERI-LO NA TABELA DE CONTAINER ## */
         $sql = mysql_query("SELECT orcCliente_fk FROM orcamento WHERE orcCodigo = '$pesquisa'");
         while($obj = mysql_fetch_array($sql))
         {
            $objCliente = $obj['orcCliente_fk'];  // ID DO CLIENTE NESTA LINHA  //
         }
         
                mysql_query("UPDATE ponteiro SET ponPonteiro = $ponteiro, ponTabela = 1, ponDataInicial = '$data', ponHora = '$hora'
                  WHERE ponResponsavel = '$usuario'");

                mysql_query("UPDATE container SET conTabela = 1, conStatus = 0, conCodigoOrcamento_fk = '$pesquisa', conCodigoCliente = '$objCliente' WHERE conResponsavel = '$usuario'");
    }

    else
    {
        /* ## ATUALIZA A TABELA DE PONTEIRO  ## */
        mysql_query("UPDATE ponteiro SET ponPonteiro = '$ponteiro', ponPesquisa = '$pesquisa', ponData = '$data', ponHora = '$hora' WHERE ponResponsavel = '$usuario'");
    }
    
    // APONTA PARA O ARQUIVO DE CONTROLE //
    header('Location:controller.php');
  
   /* ## FINAL DE ENDEREÇAMENTO ## */
   

?>  