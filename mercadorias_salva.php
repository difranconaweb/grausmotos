<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 03MAR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 29JAN23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 03FEV23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 01ABR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08ABR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11ABR23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 10MAI23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 23JUN23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645

     ARQUIVO PARA REGISTRO DE MERCADORIAS */
     require 'Utilidades/conexao.php';
     
       $data = Date('d/m/Y');
 

        $codigo     = strtoupper(trim($_GET['codigo']));
        $marca      = strtoupper(trim($_GET['marca']));
        $descricao  = strtoupper(trim($_GET['descricao']));
        $ncm        = trim($_GET['ncm']);
        $cest       = $_GET['cest'];
        $cst        = $_GET['cst'];
        $quantidade = trim($_GET['quantidade']);
        $unidade    = trim($_GET['unidade']);
        $grupo      = $_GET['grupo'];
        $compra     = trim($_GET['compra']);
        $frete      = trim($_GET['frete']);
        $encargos   = trim($_GET['encargos']);
        $lucro      = trim($_GET['lucro']);
        $compraUni  = trim($_GET['compraUni']);
        $vendaUni   = trim($_GET['vendaUni']);
        $precoTotal = trim($_GET['precoTotal']);
        $lucroFinal = trim($_GET['lucroFinal']);
        $prateleira = strtoupper(trim($_GET['prateleira']));
        $usuario    = strtoupper($_GET['usuario']);
        $excluir    = 0;
  
        

        if(empty($grupo))
        {
            $sq = mysql_query("SELECT gruCodigo  FROM grupo");
            while($obj = mysql_fetch_array($sq))
             {
                 $grupo = $obj['gruCodigo'];   // VERIFICA QUAL FOI O CÓDIGO CRIADO E INSERE NA TABELA DE MERCADORIAS
             }
        }

        else
        {
            $grupo = $grupo;  // SENÃO A VARIÁVEL RECEBE ELA MESMA //
        }
        
        
        //   VERIFICA SE O REGISTRO JÁ CONSTA NA TABELA  -  INDAIATUBA 27OUT19  //
             $sql   = mysql_query("SELECT merCodigoProduto FROM mercadorias WHERE merCodigoProduto LIKE '$codigo'");
             while($obj = mysql_fetch_array($sql))
             {
                  $codigoPeca = $obj['merCodigoProduto'];
             }


             if($codigo == $codigoPeca)
             {
                  print 2;
             }

             else
             {  
                    $sql = mysql_query("INSERT INTO mercadorias (merCodigoProduto,merMarca, merMercadoria,merNCM,merCEST,merCST,merQuantidade,merUnidade,merCompra,merFrete,merEncargos,merPercentual,merVenda,merPrecoCompraUnid,merPrecoVendaUnid,merLucroFinal,merData,merUltimaAlteracao,merExcluir,merPrateleira,merGrupo,merResponsavel) VALUES ('$codigo','$marca','$descricao','$ncm','$cest','$cst','$quantidade','$unidade','$compra','$frete','$encargos','$lucro','$precoTotal','$compraUni','$vendaUni','$lucroFinal','$data','$data','$excluir','$prateleira','$grupo','$usuario')");

                     if(empty($sql))
                     { 
                        print 0;
                     }

                     else
                     {
                        
                        print 1;
                     } 
             }    
?>     