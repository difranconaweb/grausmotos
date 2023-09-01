<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 07SET21

     
    
    ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
    ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17JUN22
    ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 27DEZ22
    ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 28DEZ22 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645


    ROTINA DE PEDIDOS - SALVAR O PEDIDO  */
     require 'Utilidades/conexao.php';

     $pedido    = $_GET['pedido'];
     $desconto  = $_GET['desconto'];
     $km        = $_GET['km'];
     $mecanico  = strtoupper($_GET['mecanico']);
     $idCliente = $_GET['id_cliente'];
     $usuario   = strtoupper($_GET['usuario']); 
     
     
     $data = Date('d/m/Y'); // PEGA A DATA DO SERVIDOR //
     $hora = Date('H:i:s'); // PEGA O HORÁRIO DO SERVIDOR //
     $dia  = Date('d');
     $mes  = Date('m');
     $ano  = Date('Y');

     // BUSCANDO NA TABELA DE PEDIDO ITENS O VALOR DOS ITENS E SOMANDO ENCONTRA O VALOR REAL PARA APLICAR O DESCONTO ## //
     $desc = mysql_query("SELECT sum(pedIteTotal) AS total FROM pedido_itens WHERE pedItePedido_fk = '$pedido'");
     while($_desc = mysql_fetch_array($desc))
     {
         $valTab = $_desc['total']; // VALOR CONSTA NA TABELA DE ITENS //
     }

     // ## SE A VARIÁVEL DE DESCONTO VIER CARREGADA ENTAO CALCULA O NOVO VALOR DO PEDIDO ## //
     $valor3 = ($valTab-$desconto);
    
    // ALTERAR O REGISTRO QUE JÁ FOI CRIADO AO SALVAR O PEDIDO //
     $sql = mysql_query("UPDATE pedidos SET pedCliente_fk = '$idCliente', pedValor = '$valor3', pedDesconto = '$desconto', pedKm = '$km', pedMecanico = '$mecanico', pedPedido_fk = 2, pedHora = '$hora', pedData = '$data', pedDia = '$dia', pedMes = '$mes', pedAno = '$ano' WHERE pedCodigo = '$pedido'");
         
      // MUDA O STATUS PARA A  CONDIÇÃO DA TELA //
      mysql_query("UPDATE container_pedido SET conStatus = 3 WHERE conResponsavel = '$usuario'");
     
      // INSERE O METODO DE PAGAMENTO NA TABELA DE PAGAMENTO  //
      mysql_query("UPDATE pagamentos SET pagCliente_fk = '$idCliente', pagStatus = 'FECHADO',  pagFormaPagto = 3, pagBandeira = 'DINHEIRO', pagParcela = 1, pagDatapag = '$data', pagValor = '$valor3', pagData = '$data', pagHora = '$hora', pagResponsavel = '$usuario' WHERE pagPedido_fk = '$pedido'");

      // ## ATUALIZANDO A TABELA DE CAIXA ## //
      mysql_query("UPDATE caixa SET caxVlrEntrada = '$valor3' WHERE caxIdPedido_fk = '$pedido'");

      // ## ATUALIZANDO A TABELA DE USUÁRIO  ## //
      mysql_query("UPDATE $usuario SET Total = '$valor3', Desconto = '$desconto', Data = '$data', Hora = '$hora', Mecanico = '$mecanico', Dia = '$dia', Mes = '$mes', Ano = '$ano'");


        if(empty($sql))
        {
           print 0;
        }

        else
        {
           print 1;
        }
?>