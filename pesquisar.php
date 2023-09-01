<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26JUN22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    
 ####   ARQUIVO PARA PESQUISAR ORÇAMENTO  ###  */
     require 'Utilidades/conexao.php';

     $pesquisar = strtoupper(trim($_GET['pesquisar']));
     $orcamento = $_GET['orcamento'];
     $usuario   = $_GET['usuario'];
    
     /* ##  PRIMEIRO PEGA O ID DO CLIENTE NA TABELA DE CLIENTES ## */
     /* BUSCA O REGISTRO */
             $_sql = mysql_query("SELECT cliCodigo, cliNome, cliMoto, cliPlaca FROM clientes WHERE cliPlaca LIKE '$pesquisar' OR cliNome LIKE '$pesquisar%' AND cliExcluir = 0");
             while($_obj = mysql_fetch_array($_sql))
             {
                  $codigo  = $_obj['cliCodigo'];
                  $nome    = $_obj['cliNome'];
                  $moto    = $_obj['cliMoto'];
                  $placa   = $_obj['cliPlaca'];
             }
            // ##  FINAL DE PESQUISA DE PLACA ## //

            // ##  VERIFICA QUANTOS CLIENTES EXISTEM EM CASO DA PESQUISA SER FEITA PELO NOME ## //
            $count = mysql_num_rows($_sql);
            // ##  FINAL DE CONTAGEM DE PESQUISA PELO NOME ## /

     if($count == 0)
     {
       /* ## SE VOLTAR VÁZIO, ENTÃO NÃ HÁ CLIENTE REGISTRADO NA TABELA ## */ 
        print 0;
     }

     else if($count == 1)
     {// ESTE BLOCO NO CASO DE VOLTAR SOMENTE UM REGISTRO NA TABELA //

          // ### BUSCA AQUI O USUARIO PARA SABER ONDE ALTERAR NA TABELA DE CONTAINER ### //
         
              // ## ATUALIZA A TABELA DE ORCAMENTOS PARA STATUS SEMI-FECHADO ## //
              mysql_query("UPDATE orcamento SET orcCliente_fk = '$codigo', orcPedido_fk = 0 WHERE orcCodigo ='$orcamento'"); // INSERE O NÚMERO DO CLIENTE NA TABELA JÁ NA PESQUISA  E ALTERA A TABELA PARA SEMI-FECHADO //

               // ##  ATUALIZA A TABELA DE CONTAINER ## //
               mysql_query("UPDATE container SET conStatus = 0, conCodigoCliente = '$codigo' WHERE conResponsavel LIKE '$usuario'"); // INSERE NA TABELA DE STATUS O NOVO STATUS E O CLIENTE //
               
               // ##  ATUALIZA A TABELA DE PONTEIRO COM O ID DO CLIENTE ## //
               mysql_query("UPDATE ponteiro SET  ponPesquisa = '$pesquisar' WHERE ponResponsavel LIKE '$usuario'");
               /* ##  FINAL DE ATUALIZAÇÃO DE TABELA DE PONTEIRO ## */
               print 1;
     }

     else
     { // ### ESTE BLOCO VEM PARA CARREGAR A LISTA EM CASO DE MAIS DE UM REGISTRO ENCONTRADO  ### //
          $_sql = mysql_query("SELECT cliCodigo, cliNome, cliMoto, cliPlaca FROM clientes WHERE cliPlaca LIKE '$pesquisar' OR cliNome LIKE '$pesquisar%' AND cliExcluir = 0");
                     while($_obj = mysql_fetch_array($_sql))
                     {
                          $codig3  = $_obj['cliCodigo'];
                          $nom3    = $_obj['cliNome'];
                          $moto3   = $_obj['cliMoto'];
                          $plac3   = $_obj['cliPlaca'];

                         // ## ROTINA PARA INSERIR OS DADOS DA TABELA NO JSON  ## //
                          $array[] = array(
                         'Codigo'   => $codig3,
                         'Nome'     => $nom3,
                         'Moto'     => $moto3,
                         'Placa'    => $plac3
                         );  
                     }
                    // TERMINO DE ROTINA PARA CRIAR ARQUIVO JSON //
                         
                         // CONVERTE OS DADOS DA TABELA EM JSON //
                         $dados_json = json_encode($array);
                         // CRIA UM ARQUIVO JSON //
                         $fp = fopen("cadastro.json", "a");
                         // ESCREVE O CONTEÚDO JSON DENTRO DO ARQUIVO ABERTO //
                         fwrite($fp, $dados_json);
                         // FECHA O ARQUIVO //
                         fclose($fp);
                    
                    // TERMINO DE ROTINA PARA CRIAR ARQUIVO XML //

                      // APAGANDO ARQUIVO JSON PARA NÃO ACUMULAR CARGA //
                       unlink('cadastro.json'); 
                     //  $file = stripcslashes($file); 
                       print $dados_json; //dados_json; // ENVIANDO OS DADOS PARA A FUNÇÃO JS //
                       

         /* ## FINAL DE ROTINA DE DEVOLUÇÃO ## */
     }
?>