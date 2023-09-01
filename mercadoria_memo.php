<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 28JAN23
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 28JAN23
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 28JAN23

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08FEV23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

     ARQUIVO PARA MEMÓRIA DE MERCADORIAS */
     require 'Utilidades/conexao.php';
     
       $data = Date('d/m/Y');
 

        $codigo     = strtoupper(trim($_GET['codigo']));
        $quantidade = $_GET['quantidade'];
        $compra     = $_GET['compra'];
        $lucro      = $_GET['lucro'];
        $vendaUni   = $_GET['unidade'];
        $compraUni  = $_GET['compraUni'];
        $precoTotal = $_GET['total'];
        $lucroFinal = $_GET['final'];

        // ## VERIFICANDO SE A QUANTIDADE VEM ZERO PARA TROCAR POR VALOR 1 ## //
        if($quantidade == 0){$quantidade = 1;$compra = ($quantidade*$compraUni); /* ENCONTRANDO O VALOR DA COMPRA PARA A QUANTIDADE QUE TEM AQUI */$quantidade = 0;}else{$quantidade = $quantidade;}


        // ##  LIMPANDO A TABELA DE MEMORIA ## //
        mysql_query("TRUNCATE memoria");
        
        
       // ## INNSERINDO O VALOR NA TABELA DE MEMÓRIA ## //  
        $sql = mysql_query("INSERT INTO memoria (codMemo, quantidade, totalCompra, lucro, preCompraUni, preVendaUnit, preTotal, lucroFinal) VALUES ('$codigo','$quantidade','$compra','$lucro','$compraUni','$vendaUni','$precoTotal','$lucroFinal')");

        if(empty($sql))
        { 
           print 0;
        }

        else
        {
           print $compraUni;
        } 
?>     