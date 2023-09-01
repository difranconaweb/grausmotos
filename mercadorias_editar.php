<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 07SET21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 31JAN23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01ABR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08ABR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01MAI23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 23JUN23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

     ARQUIVO PARA EDITAR REGISTRO DE MERCADORIAS */

require 'Utilidades/conexao.php';

       $data = Date('d/m/Y');
 
        
        $id         = $_GET['id']; // ESSE ID É O ID DA TABELA GERADO PELO AUTO INCREMENTO //
        $codigo     = strtoupper(trim($_GET['codigo'])); // ESTE É CODIGO PARTICULAR DA PEÇA //
        $marca      = strtoupper(trim($_GET['marca']));
        $descricao  = strtoupper(trim($_GET['descricao']));
        $ncm        = strtoupper(trim($_GET['ncm']));
        $cest       = $_GET['cest'];
        $cst        = $_GET['cst'];
        $quantidade = trim($_GET['quantidade']);
        $unidade    = trim($_GET['unidade']);
        $grupo      = $_GET['grupo'];
        $compra     = trim($_GET['compra']);
        $frete      = trim($_GET['frete']);
        $encargos   = trim($_GET['encargos']);
        $lucro      = trim($_GET['lucro']);
        $vendaUni   = strtoupper(trim($_GET['vendaUni']));
        $precoTotal = strtoupper(trim($_GET['precoTotal']));
        $lucroFinal = strtoupper(trim($_GET['lucroFinal']));
        $prateleira = strtoupper(trim($_GET['prateleira']));
        $usuario    = strtoupper($_GET['usuario']);
        $excluir    = 0;

            // INICIO DE ROTINA PARA A MEMORIA DO VALOR ## //
            $mPreCompra  = ($compra/$quantidade);// ENCONTRANDO O VALOR DA COMPRA DE CADA ITEM //

           $sql = mysql_query("UPDATE mercadorias SET merCodigoProduto = '$codigo', merMarca = '$marca', merMercadoria = '$descricao', merNCM = '$ncm', merCEST = '$cest', merCST = '$cst',merQuantidade = '$quantidade', merCompra = '$compra', merFrete = '$frete', merEncargos = '$encargos', merPercentual = '$lucro', merVenda = '$precoTotal', merPrecoCompraUnid = '$mPreCompra', merPrecoVendaUnid = '$vendaUni', merLucroFinal = '$lucroFinal', merUltimaAlteracao = '$data', merExcluir = '$excluir', merPrateleira = '$prateleira', merGrupo = '$grupo', merResponsavel = '$usuario' WHERE merCodigo = '$id'");
 
            if(empty($sql))
             {
                print 0;
             }

             else
             {
                print 1;
             } 
?>