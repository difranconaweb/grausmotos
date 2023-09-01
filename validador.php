<?php
  /* SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22

     
  
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

    ROTINA DE PEDIDOS - SEGUNDA PÁGINA  */

// ############################################################################################################################ //
//   ESTE ARQUIVO VEM PARA CARREGAR O ID DO CLIENTE SELECIONADO E SALVA-LO EM UMA TABELA PARA ABRIR O FORMULÁRIO DE ORCAMENTO   //
//############################################################################################################################# //

     session_start();
     require 'Utilidades/conexao.php';

     $codigo  = $_REQUEST['objCodigo']; /* CODIGO DO CLIENTE */
     $usuario = $_SESSION['usuario'];  // VARIÁVEL DE SESSÃO, QUE VEM COM O NOME DO USUÁRIO LOGADO //



     mysql_query("UPDATE container SET conCodigoCliente = '$codigo', conStatus = 1 WHERE conResponsavel = '$usuario'");

     // ###  PEGANDO O NÚMERO DO ORÇAMENTO ### //
          $sql = mysql_query("SELECT Codigo_fk FROM $usuario");
          while($obj = mysql_fetch_array($sql))
          {
             $orcamento = $obj['Codigo_fk'];
          }


     // ### INSERINDO O ID DO CLIENTE NA TABELA PARTICULAR DE ORÇAMENTO ### //
     mysql_query("UPDATE $usuario SET Cliente_fk = '$codigo'");

     //  ### INSERINDO O NUMERO DO CLIENTE   ### //
     mysql_query("UPDATE orcamento SET orcCliente_fk = '$codigo' WHERE orcCodigo = '$orcamento'");

     header('Location:http://www.grausmotos.com.br/controller.php');


     

?>