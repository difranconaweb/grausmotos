<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 29AGO21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 29AGO21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 29AGO21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 09SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 10SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 28OUT22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 12NOV22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 25DEZ22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

// ############################################################################################  //
/* ### ARQUIVO PARA PONTEIRO DE PEDIDOS  - SEMPRE QUE VIER DO MENU, ESTE ARQUIVO VAI ATUALIZAR 
       A TABELA DE CONTAINER_PEDIDO PARA O ÚLTIMO PEDIDO DA TABELA, PARA QUE NÃO FIQUE PRESO
       NA ÚLTIMA PESQUISA ###  */
// ############################################################################################  //
require 'Utilidades/conexao.php';

    session_start(); // INICIANDO A SESSÃO
    $usuario = $_SESSION['usuario'];
    $dt = Date('d/m/Y');  // PEGANDO A DATA ATUAL NO SERVIDOR //
    $hr = Date('H:i:s');  // PEGA A HORA NO SERVER //


// ##  BUSCA O ULTIMO REGISTRO PARA CARREGAR A TABELA DE CONTAINER_PEDIDO COM OS DADOS  ## //
   $sql = mysql_query("SELECT pedCodigo, pedCliente_fk, pedValor, pedPedido_fk, logCodigo, pedData, pedHora FROM pedidos LEFT JOIN login ON login.logNome = pedidos.pedResponsavel WHERE pedResponsavel LIKE '$usuario'");
   while($obj = mysql_fetch_array($sql))
   {
        $pedCodigo     = $obj['pedCodigo'];      // INFORMA O ID DO PEDIDO //
        $pedCliente_fk = $obj['pedCliente_fk'];  // INFORMA O ID DO CLIENTE //
        $logCodigo     = $obj['logCodigo'];      // ID DO CLIENTE //
        $pedValor      = $obj['pedValor'];       // VALOR DO PEDIDO //
        $pedFechado    = $obj['pedPedido_fk'];   // INFORMA SE O PEDIDO ESTÁ FECHADO //
        $pedData       = $obj['pedData'];        // DATA DO PEDIDO //
        $pedHora       = $obj['pedHora'];        // HORA DO PEDIDO //
   }

   // ## ESTA QUERY VEM PAR ATUALIZAR O USUARIO LOGADO, PORQUE A QUERY ACIMA INSERE O LOG DO RESPONSAVEL DO ÚLTIMO PEDIDO, PORTANTO NEM SEMPRE COINCIDE. //
   $_sql = mysql_query("SELECT logCodigo FROM login WHERE logNome LIKE '$usuario'");
   while($_obj = mysql_fetch_array($_sql))
   {
       $user = $_obj['logCodigo'];
   }




// ## CARREGA OS DADOS DO ULTIMO ORÇAMENTO NA TABELA DEDICADA ## //
    mysql_query("UPDATE $usuario SET Codigo = '$pedCodigo', Cliente_fk = '$pedCliente_fk', Codigo_fk = '$pedCodigo', Hora = '$pedHora',Data = '$pedData', Total = '$pedValor', Fechado = '$pedFechado'");
// ###  QUERY QUE ATUALIZA A TABELA CONTAINER_PEDIDO  ###  //
    mysql_query("UPDATE container_pedido SET conStatus = 1, conCodigoCliente = '$pedCliente_fk', conCodigoPedido_fk = '$pedCodigo', data = '$dt' WHERE conResponsavel LIKE '$usuario'");
// ### ATUALIZA A TABELA PONTEIRO PARA A OPÇÃO 5 DA ROTINA CONTROLLER.PHP  ### //
    mysql_query("UPDATE ponteiro SET ponPonteiro = 5, ponPesquisa = '', ponIDUser_fk = '$user', ponData = '$dt', ponHora = '$hr' WHERE ponResponsavel LIKE '$usuario'");
    
    if(empty($usuario))
    {
        // APONTA PARA O ARQUIVO DE CONTROLE //
        header('Location:http://www.grausmotos.com.br');
    }

    else
    {
        // ##  ESTA LINHA VAI SEMPRE ZERAR A TABELA DE PONTEIRO PARA QUE NÃO FAÇA APONTAMENTO DESNECESSÁRIO ## //
        mysql_query("UPDATE ponteiro SET ponPesquisa = '', ponDataInicial = '', ponDataFinal = '' WHERE ponResponsavel LIKE '$usuario'");    
        // APONTA PARA O ARQUIVO DE CONTROLE APÓS ZERA A TABELA PONTEIRO //
        header('Location:http://www.grausmotos.com.br/controller.php');    
    }
?>  