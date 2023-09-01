<?php


require 'Utilidades/conexao.php'; // CHAMA O ARQUIVO DE CONEXÃO //

$entrada = 12000.00;
$saida   = 1000.00;
setlocale(LC_MONETARY,"pt_BR");
/* ## REMOVENDO AS VIRGULAS ## */
               $entrada =  money_format("%.2n",$entrada);
               print $entrada;


                              $_sql = mysql_query("SELECT SUM(caxVlrEntrada) AS entrada, SUM(caxVlrSaida) AS saida FROM caixa WHERE caxData LIKE '$data'");
                              while($_obj = mysql_fetch_array($_sql))
                              {
                                 $entradas = $_obj['entrada'];
                                 $saidas   = $_obj['saida'];
                              }   

                        /* ## CARREGANDO CALCULO ## */
                              $total = ($entradas - $saidas);// FAZ O CALCULO DOS VALORES DE ENTRADA E SAÍDA E RETORNA NA LINHA ABAIXO //
                              $total = number_format($total,2); // FORMATAÇÃO DO NUMERO //?>
                                 


?>