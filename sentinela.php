<?php
/* SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 17ABR22
   SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 17ABR22
   SYSTEM DEVELOPED BY FRANCO VIEIRA MORALES      - INDAIATUBA 17ABR22


   ULTMA ALTERAÇÃO - FRANCO VIEIRA MORALES - INDAIATUBA 03JUN22
   ULTMA ALTERAÇÃO - FRANCO VIEIRA MORALES - INDAIATUBA 04JUN22  (08:45:46) 
   ULTMA ALTERAÇÃO - FRANCO VIEIRA MORALES - INDAIATUBA 16JUN22
   ULTMA ALTERAÇÃO - FRANCO VIEIRA MORALES - INDAIATUBA 21SET22  (19:22:25)
   ULTMA ALTERAÇÃO - FRANCO VIEIRA MORALES - INDAIATUBA 22MAR23  (09:57:25) - RES000101/13BR  
https://www.free-css.com/free-css-templates
   */


/*###########################################################################*/
/* ###  ARQUIVO CUIDA DO TEMPO QUE ESTÁ LOGADO        -        SENTINELA ### */
/*###########################################################################*/


// ##  FAZ A CONEXÃO COM O BANCO DE DADOS  ## //
// require 'Utilidades/conexao.php';

  // ## DATA E HORA DO SERVIDOR ## //
  $data = Date('d/m/Y');
  $hora = Date('H');
  $min  = Date('i');


  // ## INICIA CRIANDO A SESSÃO ## //
  session_start();
  $usuario = $_SESSION['usuario']; 

// ### ROTINA PARA CRIAR MEMÓRIA DE LOG IN - SENTINELA ### //
 $sql = mysql_query("SELECT logNome, logMemoIn, logMemoOff, logLogin FROM login WHERE logNome = '$usuario'");
 while($obj = mysql_fetch_array($sql))
 {
     $nome         = $obj['logNome'];
     $horaInicial  = $obj['logMemoIn'];
     $horaFinal    = $obj['logMemoOff'];
     $login        = $obj['logLogin'];
 }
 // ### FINAL DE ROTINA DE MEMÓRIA DE LOG IN CONTADOR DE TEMPO  ###  //
 
  // ### VERIFICANDO ATRAVÉS DE CALCULO DE O USUARIO AINDA TEM TEMPO PARA ESTAR LOGADO ### //
  // ### ROTINA PARA CONTADOR/TIMER DE DESLOG ### //
     $hora        = floatval($hora); // TRANSFORMA A STRING EM FLOAT //
     $min         = floatval($min);  // TRANSFORMA A STRING EM FLOAT //
     $hora_atual  = (($hora * 60) + $min); // VERIFICA A HORA ATUAL //

     // ### COMPARA A VER SE A HORA ATUAL É IGUAL A HORA QUE ESTÁ NA BASE ### //
    /*  if($hora_atual >= $horaFinal)
      {
         // ATUALIZA A TABELA DE LOGIN E DESCONECTA USUÁRIO //
         mysql_query($con,"UPDATE login SET logMemoIn = 0, logMemoOff = 0, logLogin = 0 WHERE logNome = '$usuario'");
         header('Location:http://www.grausmotos.com.br/login/logoff.php?usuario='.$usuario);
      }*/ // ROTINA FECHADA TEMPORÁRIAMENTE   #################################################  //

      if($login == 0)
      {// SE O CAMPO logLogin ESTIVER VALENDO ZERO, ENTAO DESCONECTA O USUÁRIO ## //
         // ATUALIZA A TABELA DE LOGIN E DESCONECTA USUÁRIO //
         mysql_query($con,"UPDATE login SET logMemoIn = 0, logMemoOff = 0, logLogin = 0 WHERE logNome = '$usuario'");
         header('Location:http://www.grausmotos.com.br/login/logoff.php?usuario='.$usuario);
      }

      else
      {
           $usuario;
      }
     // ### FINAL DE COMPARAÇÃO ### //
     
  // ### FINAL DE ROTINA DESLOG ### //
?>