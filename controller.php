<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21
     SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 01ABR21

     
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 14ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 16ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20ABR21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 12MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 13MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 18MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 21MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 26MAI21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05JUN21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06JUN21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 21SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 25SET21
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 14MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 20MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 22MAR22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 05JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11JUN22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17JUL22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 16SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 22SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 28SET22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 21DEZ22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 24DEZ22
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04JUN23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 04JUL23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07JUL23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06AGO23
     ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 30AGO23 - RES000101/13BR
                                                                   (19)3017-3460
                                                                   (19)99272-0159
                                                                   (19)99751-7645 */

// ### INICIO DE ARQUIVO QUE SOMENTE FAZ A CHAMADA DO ARQUIVO COMISSIONADO DE ACORDO COM O VALOR DA TABELA PONTEIRO ###  //
require 'Utilidades/conexao.php';
//require 'Utilidades/sentinela.php';
    session_start(); // INICIA A SESSÃO //
    $usuario  = $_SESSION['usuario']; // RECEBE A SESSÃO DA PAGINA DE LOGIN.PHP //
    $data = Date('d/m/Y');  // CARREGA A DATA
    $hora = Date('H:i:s');  // CARREGA A HORA



   // ## BUSCA NA TABELA PONTEIRO O ENDEREÇO DA PRÓXIMA PÁGINA COM REFERENCIA AO USUÁRIO ## //
    $sql = mysql_query("SELECT ponPonteiro FROM ponteiro WHERE ponResponsavel = '$usuario'");
    while($obj = mysql_fetch_array($sql))
    {
        $objPonteiro = $obj['ponPonteiro']; // AQUI ESTÁ O VALOR DO ENDEREÇO DA PROXIMA PÁGINA //
    }
        

    // ## VERIFICA QUAL É A PÁGINA SER CHAMADA  ## //
    if($objPonteiro == 1)
    {// ## VALOR DE 1 APONTA PARA A TELA DE MENU ## //
        include_once('menu/index.php');
    }

    else if($objPonteiro == 2)
    {// ## VALOR DE 2 APONTA PARA A TELA DE CADASTRO DE CLIENTES ## //
        include_once('cadastro/clientes.php');
    }

    else if($objPonteiro == 3)
    {// ## VALOR DE 3 APONTA PARA A TELA DE CADASTRO DE FORNECEDORES ## //
        include_once('cadastro/fornecedores.php');
    }

    else if($objPonteiro == 4)
    {// ## VALOR DE 4 APONTA PARA A TELA DE CADASTRO DE MERCADORIAS ## //
        include_once('cadastro/mercadorias.php');
    }

    else if($objPonteiro == 5)
    {// ## VALOR DE 5 APONTA PARA A TELA DE CADASTRO DE PEDIDOS ## //
        include_once('pedidos/index.php');
    }

    else if($objPonteiro == 6)
    {/* ## VALOR DE 6 APONTA PARA A TELA DE CADASTRO DE ORÇAMENTOS ## */
        include_once('orcamentos/index.php');
    }    
    
    else if($objPonteiro == 7)
    {// ## VALOR DE 7 APONTA PARA A TELA DE ADMINISTRAÇÃO DO SISTEMA ## //
        include_once('admin/index.php');
    }

    else if($objPonteiro == 8)
    {// ## VALOR DE 8 APONTA PARA A TELA DE ADMINISTRAÇÃO DO SISTEMA ## //
        include_once('pedidos/printer.php');
    }

    else if($objPonteiro == 9)
    {// ## VALOR DE 9 APONTA PARA A TELA DE CAIXA DO SISTEMA ## //
        include_once('caixa/index.php');
    }

    else if($objPonteiro == 10)
    {// ## VALOR DE 10 APONTA PARA A RELATORIO CLIENTE ## //
        include_once('relatorios/clientes/index.php');
    }

    else if($objPonteiro == 11)
    {// ## VALOR DE 11 APONTA PARA A RELATORIO FORNECEDOR ## //
        include_once('relatorios/fornecedores/index.php');
    }

    else if($objPonteiro == 12)
    {// ## VALOR DE 12 APONTA PARA A RELATORIO MERCADORIA ## //
        include_once('relatorios/mercadorias/index.php');
    }

    else if($objPonteiro == 13)
    {// ## VALOR DE 13 APONTA PARA A RELATORIO CAIXA ## //
        include_once('relatorios/caixa/index.php');
    }

    else if($objPonteiro == 14)
    {// ## VALOR DE 14 APONTA PARA A RELATORIO PEDIDOS ## //
        include_once('relatorios/pedidos/index.php');
    }

    else if($objPonteiro == 15)
    {// ## VALOR DE 15 APONTA PARA A MENU DE RELATORIOS ## //
        include_once('relatorios/index.php');
    }

    else if($objPonteiro == 16)
    {// ## VALOR DE 16 APONTA O RELATORIO DE COBRANCAS ## //
        include_once('relatorios/cobrancas/index.php');
    }

    else if($objPonteiro == 17)
    {// ## VALOR DE 17 APONTA PARA O ARQUIVO INDEX DE ORÇAMENTOS NA PASTA IA ## //
        include_once('orcamentos/orcamentoIA/index.php');
    }

    else if($objPonteiro == 18)
    {// ## VALOR DE 18 APONTA PARA O ARQUIVO INDEX DE PEDIDO NA PASTA IA ## //
        include_once('pedidos/pedidoIA/index_1.php');
    }

    else if($objPonteiro == 19)
    {/// ## VALOR DE 19 APONTA PARA A TELA DE IMPRESSÃO DE ORÇAMENTO ## //
        include_once('orcamentos/printerr.php');
    }

    else if($objPonteiro == 20)
    {// ## VALOR DE 20 APONTA PARA A TELA DE RELATÓRIO DE ORÇAMENTOS ## //
        include_once('relatorios/orcamentos/index.php');
    }

    else if($objPonteiro == 21)
    {// ## VALOR DE 21 APONTA PARA A TELA DE RELATÓRIO DE SERVIÇOS ## //
        include_once('relatorios/servicos/index.php');
    }

    else if($objPonteiro == 22)
    {// ## VALOR DE 22 APONTA PARA A TELA DE INDEX DE ADMIN ## //
        include_once('admin/index.php');
    }

    else if($objPonteiro == 23)
    {// ## VALOR DE 23 APONTA PARA A TELA DE IMPRESSÃO DE NOTA FISCAL ELETRONICA ## //
        include_once('pedidos/notaFiscal/index.php');
    }

    else if($objPonteiro == 24)
    {// ## VALOR DE 24 APONTA PARA A TELA DE LOGIN DO CAIXA ## //
        include_once('caixa/index1.php');
    }

    else if($objPonteiro == 25)
    {// ## VALOR DE 25 APONTA PARA A TELA DE IMPRESSÃO DE NOTA FISCAL ## //
        include_once('pedidos/notaFiscal/terminoNotaFiscal.php');
    }

    else if($objPonteiro == 26)
    {// ## VALOR DE 26 APONTA PARA A TELA DE EXCEÇÃO QUE INFORMA QUE O PEDIDO JÁ EXISTE ## //
        include_once('pedidos/notaFiscal/excecaoNotaExistente.php');
    }

    else if($objPonteiro == 27)
    {// ## VALOR DE 27 APONTA PARA A TELA DE EXCEÇÃO QUE INFORMA QUE O HOUVE ERRO AO EMITIR A NF ## //
        include_once('pedidos/notaFiscal/terminoNotaFiscal.php');
    }

    else if($objPonteiro == 28)
    {// ## VALOR DE 28 APONTA PARA A TELA DE GRID DE NOTAS FISCAIS E CONFERENCIA SE A NOTA SUBIU O DEU ERRO ## //
        include_once('relatorios/notas/index.php');
    }

    else if($objPonteiro == 29)
    {// ## VALOR DE 29 APONTA PARA A TELA DE GRID DE MERCADORIAS PERDIDAS POR FALTA DE GRUPO ## //
        include_once('relatorios/mercadorias/index_mercadorias_zero.php');
    }

    else if($objPonteiro == 30)
    {// ## VALOR DE 30 APONTA PARA A TELA DE GRID DE RELATORIO DE ERRO DA EMISSAO DA NOTA FISCAL ## //
        include_once('pedidos/notaFiscal/excecaoErroNotaFiscal.php');
    }

    else
    {
       header('Location:http://www.grausmotos.com.br');
    }
?>  