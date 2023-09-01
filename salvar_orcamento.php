<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 20JUN22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 20JUN22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 20JUN22

     
     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05OUT22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    ROTINA DE ORÇAMENTO - SALVAR O ORÇAMENTO */
     require 'Utilidades/conexao.php';

     $orcamento   = $_GET['orcamento'];
     $idCliente   = $_GET['id_cliente'];
     $valor       = $_GET['valor'];
     $usuario     = strtoupper($_GET['usuario']);
     $valor       = str_replace(',', '.',$valor);
     $comentario  = $_GET['comentario']; 
     

     $data = Date('d/m/Y'); // PEGA A DATA DO SERVIDOR //
     $hora = Date('H:i:s'); // PEGA O HORÁRIO DO SERVIDOR //
     $dia  = Date('d');
     $mes  = Date('m');
     $ano  = Date('Y');


    $cli = mysql_query("SELECT orcCliente_fk FROM orcamento WHERE orcCodigo = '$orcamento'");
    while($ob = mysql_fetch_array($cli))
    {
         $cliente = $ob['orcCliente_fk']; //  VERIFICA ANTES DE SALVAR SE HÁ CLIENTE SALVO NA TABELA  //
    }

        $sql = mysql_query("UPDATE orcamento SET orcCliente_fk = '$idCliente', orcTotal = '$valor', orcPedido_fk = 0, orcData = '$data', orcHora = '$hora', orcComentario = '$comentario', orcFechado = 1 WHERE orcCodigo = '$orcamento'");
     
         // ATUALIZANDO A TABELA DE CONTAINER PARA O USUÁRIO ESPECIFICO //
         mysql_query("UPDATE container SET conStatus = 2 WHERE conResponsavel = '$usuario'");


         // ALTERA O PONTEIRO PARA MUDAR DE ARQUIVO APÓS SALVAR A FORMA DE PAGAMENTO //
         mysql_query("UPDATE ponteiro SET ponPonteiro = 6, ponData = '$data', ponHora = '$hora' WHERE ponResponsavel = '$usuario'");


        if(empty($sql))
        {
           print 0;
        }

        else
        {
           print 1;
        }
    
?>