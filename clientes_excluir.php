<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645 
     ARQUIVO PARA EXCLUSAO DE REGISTRO ###  */
     require 'Utilidades/conexao.php';

     $codigo = $_GET['codigo'];

     mysql_query("UPDATE clientes SET cliExcluir = 1 WHERE cliCodigo = '$codigo'");

     print 1;

?>