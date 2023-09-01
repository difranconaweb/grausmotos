<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22


     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 ####   ARQUIVO PARA SALVAR O ORÇAMENTO NA TABELA DEDICADA QUANDO VIER DE EDITAR ORÇAMENTO DO ARQUIVO PRINCIPAL  ###  */
     require 'Utilidades/conexao.php';

     $orcamento      = $_GET['orcamento'];
     $idCliente      = $_GET['idCliente'];
     $valor          = $_GET['valor'];
     $usuario        = $_GET['responsavel'];

     $data = Date('d/m/Y');
     $hora = Date('H:i:s');
     $dia  = Date('d');
     $mes  = Date('m');
     $ano  = Date('Y');


    // ### ROTINA PARA ATUALIZAR O REGISTRO DE ORÇAMENTO NA TABELA DEDICADA ### //
     mysql_query("DELETE FROM $usuario");
     
     // ## SE JÁ HOUVER REGISTRO ABRE NOVO, SENAO APENAS ATUALIZA  ## //
     $sql = mysql_query("INSERT INTO  $usuario (Codigo,Cliente_fk,Codigo_fk,Total,Hora,Data,Responsavel,Pedido_fk,Orcamento_fk) VALUES ('$orcamento','$idCliente','$orcamento','$valor','$hora','$data','$usuario',0,'$orcamento')");
     
  
     if(empty($sql))
     {
        print 0;
     }

     else
     {
        print 1;
     }
?>