<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 07SET21

     
     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08MAI22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29DEZ22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

     ARQUIVO PARA DIRECIONAR AO PEDIDO  */   

     require 'Utilidades/conexao.php';


     $data    = Date('d/m/Y');
     $hora    = Date('H:i:s');
     $usuario = $_GET['usuario'];


      // LIMPANDO A TABELA TEMPORÁRIA COM O NOME DO USUÁRIO //
         mysql_query("DELETE IF EXISTS FROM $usuario");

     // BUSCANDO O ID DO CLIENTE QUE ACABOU DE SER CADASTRADO //
     $_sql = mysql_query("SELECT cliCodigo FROM clientes");
     while($_obj = mysql_fetch_array($_sql))
     {
         $cliCodigo = $_obj['cliCodigo'];
     }

     // INSERE O NOVO PEDIDO //
          mysql_query("INSERT INTO pedidos (pedCliente_fk,pedHora,pedData,pedResponsavel,pedPedido_fk) VALUES ('$cliCodigo','$hora','$data','$usuario',0)");
          
          // BUSCA O NÚMERO DO NOVO PEDIDO CRIADO PARA SER ENVIADO NA URL //*/
          $sql = mysql_query("SELECT pedCodigo FROM pedidos");
          while($obj = mysql_fetch_array($sql))
          {
               $codigo = $obj['pedCodigo'];
          }
          
          mysql_query("UPDATE container_pedido SET conCodigoCliente = $cliCodigo, conStatus = 1, data = '$data', conCodigoPedido_fk = '$codigo' WHERE conResponsavel = '$usuario'"); // ATUALIZA A TABELA DE CONTAINER_PEDIDO COM O NOVO PEDIDO E TAMBÉM COLOCA O VALOR ZERO NA COLUNA PARA O ID DO CLIENTE DEVIDO AINDA NÃO TER SIDO PESQUISADO O CLIENTE PARA ESTE NOVO PEDIDO BEM COMO CONSTATUS RECEBE O VALOR 2 PARA NOVO PEDIDO //

          // ## NESTA ROTINA INSERE O VALOR DO ARQUIVO QUE DEVE SER DIRECIONADO COMO PONTEIRO  ## //
          mysql_query("UPDATE ponteiro SET ponPonteiro = 5, ponData = '$data', ponHora = '$hora' WHERE ponResponsavel LIKE '$usuario'");    


          //############################################################################################################################## //
          // ESTE TRECHO É O COMEÇO DA IA PARA O REGISTRO DE UM PEDIDO DE CADA VENDEDOR SIMULTANEAMENTE //
// ############################################################################################################################## //
mysql_query("CREATE TABLE IF NOT EXISTS $usuario (Codigo INT(10), Cliente_fk INT(10) NOT NULL, Codigo_fk INT(10) NOT NULL, Hora CHAR(8)NOT NULL, Data CHAR(10) NOT NULL, Responsavel CHAR(20) NOT NULL, Total DOUBLE(8,2) NOT NULL, Desconto DOUBLE(8,2) NOT NULL, Pedido_fk INT(5) NOT NULL, Km CHAR(20) NOT NULL, Garantia CHAR(20) NOT NULL, Comentario VARCHAR(100) NOT NULL, , Quantidade INT(5) NOT NULL, CodigoMercadoria VARCHAR(20) NOT NULL, Mercadoria VARCHAR(100) NOT NULL, Dia CHAR(2) NOT NULL, Mes CHAR(2) NOT NULL, Ano CHAR(4) NOT NULL, Mecanico CHAR(20) NOT NULL, Orcamento_fk INT(1) NOT NULL, Fechado INT(5) NOT NULL, reg_date TIMESTAMP)");
// FINAL DE CRIAÇÃO DE TABELA //

// ABRINDO O PRIMEIRO REGISTRO COM O NUMERO ID DO REGISTRO CRIADO NA TABELA MATRIZ. O ID DA MATRIZ ESTÁ EM CAMPO DE  FK //
mysql_query("INSERT INTO $usuario (Codigo, Cliente_fk, Codigo_fk, Hora, Data, Responsavel, Dia, Mes, Ano) VALUES ('$codigo','$cliCodigo','$codigo','$hora','$data','$usuario','$dia','$mes','$ano')");


          header('Location:http://www.grausmotos.com.br/controller.php');                                              

?>