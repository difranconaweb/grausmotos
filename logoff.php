<?php

/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06JUN21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08JUN21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 30AGO21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 09MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 10SET22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


     ARQUIVO DE LOGOFF DO SISTEMA GRAUS MOTOS  */
          
          session_start();
          require 'Utilidades/conexao.php';

          $usuario = $_SESSION['usuario'];


          $data = Date('d/m/Y');  // CARREGA A DATA
          $hora = Date('H:i:s');  // CARREGA A HORA
           
          mysql_query("UPDATE login SET logLogin = 0, logDataOff = '$data', logTimeOff = '$hora', logMemoIn = 0, logMemoOff = 0 WHERE logNome LIKE '$usuario'");
          mysql_query("UPDATE ponteiro SET ponPonteiro = 0, ponData = '$data', ponHora = '$hora'  WHERE ponResponsavel LIKE '$usuario'");
          // ## APAGANDO A TABELA TEMPORÁRIA DE USUÁRIO ## //
          mysql_query("DROP TABLE $usuario");
          session_destroy();
          header('Location:http://www.grausmotos.com.br');
          
?>