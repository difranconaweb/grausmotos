<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21

  
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 14ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 22AGO21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 30AGO21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 02SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17ABR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08OUT22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 27OUT22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29OUT22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 10MAR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11MAR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17MAI23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04JUL23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645  */


    // ARQUIVO DE LOGIN DO SISTEMA GRAUS MOTOS  //
          session_start();
          require 'Utilidades/conexao.php';

          $data = Date('d/m/Y');  // CARREGA A DATA
          $hora = Date('H:i:s');  // CARREGA A HORA
          $hor  = Date('H'); // SOMENTE O VALO DA HORA //
          $min  = Date('i'); // SOMENTE O VALOR DO MINUTO //

  


  // ### ROTINA PARA CONTADOR/TIMER DE DESLOG ### //
     $hor          = floatval($hor); // TRANSFORMA A STRING EM FLOAT //
     $min          = floatval($min);  // TRANSFORMA A STRING EM FLOAT //
     $mins         = ($min+120);       // SOMA O MINUTO COM O TEMPO DE TOLERANCIA LOGADO //
     $hora_inicial = (($hor * 60) + $min); // INSERE O VALOR NA VARIÁVEL PARA SER ENVIADO A TABELA //
     $hora_final   = (($hor * 60) + $mins); // INSERE O VALOR NA VARIÁVEL PARA SER ENVIADO A TABELA MINUTO SOMADO //
  // ### FINAL DE ROTINA DESLOG ### //


          // PEGA OS VALORES E CARREGA AS VARIÁVEIS //
          $nome     = trim(strtoupper($_GET['nome']));
          $password = trim(strtolower($_GET['senha']));
          $senha    = sha1($password);  // CRIPTOGRAFA A SENHA //



          $sql = mysql_query("SELECT * FROM login  WHERE logNome LIKE '$nome' AND logSenha LIKE '$senha'");

          while($obj = mysql_fetch_array($sql))
          {
              $objCodigo     = $obj['logCodigo'];
              $objUsuario    = $obj['logNome'];
              $objPrivilegio = $obj['logPrivilegio'];
              $objApelido    = $obj['logApelido'];
              $objSenha      = $obj['logSenha'];
              $objConectado  = $obj['logLogin'];
          }


          if($objConectado == 1)
          {
                print 2; // ESTE VALOR CASO APRESENTE O USUÁRIO JÁ CONECTADO //
          }

          else
          {// CASO NÃO ESTEJA CONECTADO, PASSA POR ESTE BLOCO PARA O LOGIN //
                //  VERIFICA PRIMEIRO SE O ACESSO ESTA PARA "ADMIN"... PARA QUE POSSA CHAMAR A TELA DE CADASTRO PARA USUÁRIO DO SISTEMA //
                  if($objApelido == "ADMIN")
                  {// APONTA PARA A PÁGINA DE CADASTRO DE NOVO USUÁRIO //
                        mysql_query("UPDATE login SET logDataIn = '$data', logTimeIn = '$hora', logLogin = 1, logMemoIn = '$hora_inicial', logMemoOff = '$hora_final' WHERE logCodigo = '$objCodigo'");
                       
                       // INSERE NA TABELA PONTEIRO O USUÁRIO E O ENDEREÇO PARA A PRÓXIMA PÁGINA  //
                        mysql_query("UPDATE ponteiro SET ponPonteiro = 1, ponData = '$data', ponHora = '$hora', ponResponsavel = '$objUsuario' WHERE ponResponsavel LIKE '$objUsuario'");
                  }

                  else // SENÃO SEGUE O PROCEDIMENTO NORMAL //
                  {
                       // VERIFICA SE OS VALORES DIGITADOS NO CAMPO SÃO IGUAIS AOS VALORES QUE CONSTAM NO BANCO E RETORNA //
                        if($nome == $objUsuario && $senha == $objSenha)
                        {// ## VERIFICA O PRIVILEGIO PARA VER SE ESTÁ DENTRO DO HORARIO ## //
                                 if($objPrivilegio == 0)
                                 {    // ## VERIFICA AGORA SE ESTÁ DENTRO DO HORARIO DE ACESSO ## //
                                      if(($hora_inicial > 1110) || ($hora_final < 390))
                                      {
                                            print 3; // ## VALOR 3 É PARA INFORMAR QUE NÃO ESTÁ NO HORÁRIO DE ACESSO ## //
                                      }

                                      else
                                      {
                                            // CRIA A TABELA PARA O USUÁRIO POR FUNÇÃO //
                                            criarTabela($objUsuario);
                                            // FINAL DE CRIAÇÃO DE TABELA //

                                            //  ## ATUALIZA A TABELA DE LOGIN ## //
                                            mysql_query("UPDATE login SET logDataIn = '$data', logTimeIn = '$hora', logLogin = 1, logMemoIn = '$hora_inicial', logMemoOff = '$hora_final' WHERE logCodigo = '$objCodigo'");

                                             print 1;  // RETORNA 1 É PORQUE ESTÁ VÁLIDO O LOG //
                                      }
                                 }

                                 else
                                 {
                                      // CRIA A TABELA PARA O USUÁRIO POR FUNÇÃO //
                                      criarTabela($objUsuario);
                                      // FINAL DE CRIAÇÃO DE TABELA //

                                      //  ## ATUALIZA A TABELA DE LOGIN ## //
                                      mysql_query("UPDATE login SET logDataIn = '$data', logTimeIn = '$hora', logLogin = 1, logMemoIn = '$hora_inicial', logMemoOff = '$hora_final' WHERE logCodigo = '$objCodigo'");

                                       print 1;  // RETORNA 1 É PORQUE ESTÁ VÁLIDO O LOG //
                                 }
                            } 

                            else
                            {
                                  print 0;  //RETORNA ZERO É PORQUE ESTÁ INCORRETO //
                            }
                  }
          }


          // ## FUNÇÃO PARA CRIAR A TABELA ## //
          function criarTabela($objUsuario)
          {
              require 'Utilidades/conexao.php';
              $data = Date('d/m/Y');  // CARREGA A DATA
              $hora = Date('H:i:s');  // CARREGA A HORA
              
              // ## REMOVENDO A TABELA DA MEMORIA PORQUE SE CASO O SISTEMA CAI E RECONECTA PELO USUÁRIO A TABELA FICA SEM INFORMAÇÇOES ATALIZADAS, POR ISSO DECIDI REMOVE-LA ## //
              mysql_query("DROP TABLE $objUsuario");
             
             // ## CRIANDO A NOVA TABELA ## //
              mysql_query("CREATE TABLE IF NOT EXISTS $objUsuario (Codigo INT(10) , Cliente_fk INT(10) NOT NULL, Codigo_fk INT(10) NOT NULL, Hora CHAR(8)NOT NULL, Data CHAR(10) NOT NULL, Responsavel CHAR(20) NOT NULL, Total DOUBLE(8,2) NOT NULL, Desconto DOUBLE(8,2) NOT NULL, Pedido_fk INT(5) NOT NULL, Km CHAR(20) NOT NULL, Garantia CHAR(20) NOT NULL, Comentario VARCHAR(100) NOT NULL, Quantidade INT(5) NOT NULL, CodigoMercadoria VARCHAR(20) NOT NULL, Mercadoria VARCHAR(100) NOT NULL, Dia CHAR(2) NOT NULL, Mes CHAR(2) NOT NULL, Ano CHAR(4) NOT NULL, Mecanico CHAR(20) NOT NULL, Orcamento_fk INT(1) NOT NULL, Fechado INT(5) NOT NULL, reg_date TIMESTAMP, Coringa CHAR(20) NOT NULL)");

              // INSERE O LOGIN NA TABELA MEMO  //
                mysql_query("INSERT INTO login_memo (logMemoData, logMemoHora, logMemoUsuario) VALUES ('$data', '$hora', '$objUsuario')");

                // ## ATUALIZA A TABELA DE PONTEIRO ## //
                mysql_query("UPDATE ponteiro SET ponPonteiro = 1, ponDataInicial = '$data', ponHora = '$hora' WHERE ponResponsavel LIKE '$objUsuario'");
                             
                // ## CRIA A SESSÃO PARA O PROXIMO ARQUIVO ## //
                $_SESSION['usuario'] = $objUsuario;

                // VERIFICA O ULTIMO PEDIDO DA TABELA //
                $_sql = mysql_query("SELECT pedCodigo, pedCliente_fk FROM pedidos");
                while($_obj = mysql_fetch_array($_sql))
                {
                     $_pedido  = $_obj['pedCodigo'];
                     $_cliente = $_obj['pedCliente_fk'];
                }

                // ATUALIZA A TABELA DE CONTAINER_PEDIDO //
                mysql_query("UPDATE container_pedido SET conStatus = 0, conCodigoCliente = '$_cliente', conCodigoPedido_fk = '$_pedido', data = '$data' WHERE conResponsavel LIKE '$objNome'");
                
                // ## INSERE DADOS NA TABELA DEDICADA DE USUÁRIO ## //
                mysql_query("INSERT INTO $objUsuario (Codigo,Cliente_fk,Codigo_fk,Hora,Data,Responsavel,Total,Desconto,Pedido_fk,Km,Garantia,Comentario,fechado,Dia,Mes,Ano) VALUES ('','','','$hora','$data','$objUsuario','','','','','','',0,'','','')");
          }
?>