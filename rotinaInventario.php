<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 11JAN23
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 11JAN23
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 11JAN23

     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11JAN23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645 */

// ### INICIO DE ARQUIVO QUE CRIA O INVENTÁRIO ###  //
require 'Utilidades/conexao.php';
//require 'Utilidades/sentinela.php';
    
    $data = Date('d/m/Y');  // CARREGA A DATA
    $hora = Date('H:i:s');  // CARREGA A HORA



    // ##  INICIA CAPTURANDO OS REGISTRO NA TABELA DE MERCADORIA ## //
    $mer = mysql_query("SELECT merCodigoProduto,merMercadoria,merQuantidade,merCompra FROM mercadorias WHERE merExcluir = 0");
    while($m3r = mysql_fetch_array($mer))
    {
         $codProduto = $m3r['merCodigoProduto'];
         $mercadoria = $m3r['merMercadoria'];
         $quantidade = $m3r['merQuantidade'];
         $compra     = $m3r['merCompra'];

         $total = ($quantidade*$compra); // VALOR TOTAL DA QUANTIDADE PELO VALOR UNITARIO FORMANDO O PREÇO DE COMPRA NO TOTAL //

         // ## INSERINDO E PREENCHENDO A TABELA DE INVENTÁRIO ## //
        $sql =  mysql_query("INSERT INTO inventario (invCodigoProduto,invDiscriminacao,invUnidade,invQuantidade,invVlUnit,invVlTotal) VALUES ('$codProduto','$mercadoria','unid.','$quantidade','$compra','$total')");
    }

    print "AGUARDE CRIANDO INVENTÁRIO";


?>
