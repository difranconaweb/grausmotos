<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 16JUN22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 16JUN22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 16JUN22

  
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08MAI3 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645  */


    /* ARQUIVO DE LOGIN DO SISTEMA GRAUS MOTOS  */
    require 'Utilidades/conexao.php';

    $data = Date('d/m/Y');  // CARREGA A DATA
    $hora = Date('H:i:s');  // CARREGA A HORA
    $hor  = Date('H'); // SOMENTE O VALO DA HORA //
    $min  = Date('i'); // SOMENTE O VALOR DO MINUTO //
    $chave = trim(strtoupper($_GET['chave'])); // CARREGA O VALOR DA CHAVE DIGITADA  //
    $senha = trim(strtolower($_GET['senha'])); // CARREGA O VALOR DA SENHA DIGITADA //
    $senha = sha1($password);  // CRIPTOGRAFA A SENHA //
  


  /* ### ROTINA PARA CONTADOR/TIMER DE DESLOG ### */
     $hor          = floatval($hor); // TRANSFORMA A STRING EM FLOAT //
     $min          = floatval($min);  // TRANSFORMA A STRING EM FLOAT //
     $mins         = ($min+30);       // SOMA O MINUTO COM O TEMPO DE TOLERANCIA LOGADO //
     $hora_inicial = (($hor * 60) + $min); // INSERE O VALOR NA VARIÁVEL PARA SER ENVIADO A TABELA //
     $hora_final   = (($hor * 60) + $mins); // INSERE O VALOR NA VARIÁVEL PARA SER ENVIADO A TABELA MINUTO SOMADO //
  /* ### FINAL DE ROTINA DESLOG ### */


          
          // ## BUSCANDO O NOME DO USUÁRIO PARA ALTERAR O PONTEIRO E A TABELA TEMPORÁRIA  ## //
          $sql =  mysql_query("SELECT logNome,logChave FROM login WHERE logChave = '$chave'");
          while($obj = mysql_fetch_array($sql))
          {
              $nome    = $obj['logNome'];
              $c_chave = $obj['logChave'];
          }
          // ## FINAL DE BUSCA DE USUÁRIO ## //
        
          // ## VERIFICANDO SE EXISTE CHAVE OU SE ESTÁ CORRETA ## //
          if(empty($c_chave))
          {
               print 0; // SE IMPRIMIR ZERO, ENTÃO PORQUE A CHAVE FOI DIGITADA ERRADA OU INEXISTENTE //
          }

          else
          {
               // ## RESETANDO O LOGIN DO USUÁRIO ## //
               mysql_query("UPDATE login SET  logDataIn = '$data', logTimeIn = '$hora', logMemoIn = 0, logMemoOff = 0, logLogin = 0  WHERE logChave LIKE '$c_chave'");
               // ## ATUALIZANDO A TABELA DE PONTEIRO  ## //
               mysql_query("UPDATE ponteiro SET ponPonteiro = 0, ponData = '$data', ponHora = '$hora' WHERE ponResponsavel LIKE '$nome'");

               
               // ######################################################################################### //
               // INSERE O LOGIN NA TABELA MEMO  //
               mysql_query("INSERT INTO login_memo (logMemoData, logMemoHora, logMemoUsuario) VALUES ('$data', '$hora', '$nome')");
               print 1; // CHAVE ESTÁ CORRETA //
          }
?>
