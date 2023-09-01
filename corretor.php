<?php
require 'Utilidades/conexao.php';

$sql = mysql_query("SELECT pedCodigo, pedCliente_fk, pedData, pedResponsavel, pedValor, pedDesconto, pedPedido_fk, pedKm, pedGarantia, pedComentario, pedDia, pedMes, pedAno, pedOrcamento_fk FROM pedidos_temp");
         for($i = 0; $i < 1; $i++)
         {
            $obj = mysql_fetch_array($sql);
            $codigo      = $obj['pedCodigo'];
            $cod_cliente = $obj['pedCliente_fk'];
	        $data        = $obj['pedData'];
	    	$responsavel = $obj['pedResponsavel'];
	    	$valor       = $obj['pedValor'];
	    	$desconto    = $obj['pedDesconto'];
	    	$pedido      = $obj['pedPedido_fk'];
	    	$km          = $obj['pedKm'];
	        $garantia    = $obj['pedGarantia'];
	    	$comentario  = $obj['pedComentario'];
	    	$dia         = $obj['pedDia'];
	    	$mes         = $obj['pedMes'];
	    	$ano         = $obj['pedAno'];

	    	// AGORA SALVA NA OUTRA TABELA PARA MANTER O REGISTRO GUARDADO //
            mysql_query("INSERT INTO ped (pedCliente_fk, pedData, pedResponsavel, pedValor, pedDesconto, pedPedido_fk, pedKm, pedGarantia, pedComentario, pedDia, pedMes, pedAno) VALUES ('$cod_cliente', '$data', '$responsavel', '$valor', '$desconto', '$pedido', '$km', '$garantia', '$comentario', '$dia', '$mes', '$ano')");
	     }


	     // VERIFICA A TABELA FORNECEDORA SE AINDA CONTÉM EMAILS PARA SER ENVIADOS //
                $sq = mysql_query("SELECT pedCodigo FROM pedidos_temp");
                $num = mysql_num_rows($sq);
                

                if($num == 0) // SE NÃO HOUVER MAIS EMAILS DA TABELA FORNECEDORA, ENCERRA A ROTINA //
                {
                    print "FIM";
                    break;  
                }

                else  // SENÃO, CONTINUAR EXECUTANDO E ENVIANDO EMAILS
                {
                	mysql_query("DELETE FROM pedidos_temp WHERE pedCodigo = '$codigo'"); // DELETA OS EMAILS DA TABELA FORNECEDORA //

                    print "EXECUTANDO"; 
                    header( 'Refresh: 01; url=http://www.difranconaweb.com.br/GRAUS/corretor.php' );   
                }
/*
         $sql = mysql_query("SELECT pedIteCodigo, pedIteItem_fk, pedIteQuantidade, pedIteDescricao, pedItePreco, pedIteTotal, pedIteResponsavel, pedIteData, pedItePedido_fk, pedIteCliente_fk, pedIteIdProduto_fk, pedIteKm, pedIteDia, pedIteMes, pedIteAno FROM pedido_itens_temp");
         for($i = 0; $i < 1; $i++)
         {
             $obj = mysql_fetch_array($sql);
            $codigo      = $obj['pedIteCodigo'];
            $cod_item    = $obj['pedIteItem_fk'];
	        $quantidade  = $obj['pedIteQuantidade'];
	    	$descricao   = $obj['pedIteDescricao'];
	    	$preco       = $obj['pedItePreco'];
	    	$total       = $obj['pedIteTotal'];
	    	$responsavel = $obj['pedIteResponsavel'];
	    	$data        = $obj['pedIteData'];
	        $pedido      = $obj['pedItePedido_fk'];
	    	$cliente     = $obj['pedIteCliente_fk'];
	    	$produto     = $obj['pedIteIdProduto_fk'];
	    	$km          = $obj['pedIteKm'];
	    	$dia         = $obj['pedIteDia'];
	    	$mes         = $obj['pedIteMes'];
	    	$ano         = $obj['pedIteAno'];

	    	// AGORA SALVA NA OUTRA TABELA PARA MANTER O REGISTRO GUARDADO //
            mysql_query("INSERT INTO ped_itens (pedIteItem_fk, pedIteQuantidade, pedIteDescricao, pedItePreco, pedIteTotal, pedIteResponsavel, pedIteData, pedItePedido_fk, pedIteCliente_fk, pedIteIdProduto_fk, pedIteKm, pedIteDia, pedIteMes, pedIteAno) VALUES ('$cod_item', '$quantidade', '$descricao', '$preco', '$total', '$responsavel', '$data', '$pedido', '$cliente', '$produto', '$km', '$dia', '$mes', '$ano')");
	     }

	     

         


          // VERIFICA A TABELA FORNECEDORA SE AINDA CONTÉM EMAILS PARA SER ENVIADOS //
                $sq = mysql_query("SELECT pedIteCodigo FROM pedido_itens_temp");
                $num = mysql_num_rows($sq);
                

                if($num == 0) // SE NÃO HOUVER MAIS EMAILS DA TABELA FORNECEDORA, ENCERRA A ROTINA //
                {
                    print "FIM";
                    break;  
                }

                else  // SENÃO, CONTINUAR EXECUTANDO E ENVIANDO EMAILS
                {
                	mysql_query("DELETE FROM pedido_itens_temp WHERE pedIteCodigo = '$codigo'"); // DELETA OS EMAILS DA TABELA FORNECEDORA //

                    print "EXECUTANDO"; 
                    header( 'Refresh: 01; url=http://www.difranconaweb.com.br/GRAUS/corretor.php' );   
                }    */
   
?>