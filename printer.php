<?php
/*   SISTEMA DESENVOLVIDO POR FRANCO V. MORALES - INDAIATUBA 31OUT21
     SISTEMA DESARROLLADO POR FRANCO V. MORALES - INDAIATUBA 31OUT21
     SYSTEM  DEVELOPED    BY  FRANCO V. MORALES - INDAIATUBA 31OUT21


   
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  15NOV21 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  31MAI22 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  08JUN22 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  09JUN22 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  11JUN22 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  18JUN22 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  09JUL22 - FRANCO V. MORALES
   ULTIMA ATUALIZAÇÃO - INDAIATUBA  08SET22 - FRANCO V. MORALES - RES000101/13BR
                                                                  (19)98133-2762
                                                                  (19)99272-0159
                                                                  (19)99751-7645 */
     session_start();
     require 'Utilidades/conexao.php';
     
     $usuario   = $_SESSION['usuario'];  /*  ####   VARIÁVEL DE SESSÃO COM NOME DO RESPONSAVEL DO ORÇAMENTO  #####  */
     $orcamento = $_REQUEST['orc']; /* ### RECEBE O NÚMERO DO ORÇAMENTO ### */
     

     /* ### BUSCANDO O CÓDIGO DO ORÇAMENTO ### */
         $_sql = mysql_query("SELECT ponPesquisa FROM ponteiro WHERE ponResponsavel = '$usuario'");


     while($_obj = mysql_fetch_array($_sql))
     {
          $codigoOrcamento = $_obj['ponPesquisa']; // CARREGA NESTA LINHA O NUMERO DO ORÇAMENTO  //
     }
    /* ### FINAL DE BUSCA ### */



     /* ### INICIO DE ROTINA PARA CARREGAR O ORÇAMENTO - REFERÊNCIA, VARÁVEL DE SESSÃO  ###  */
         $sql = mysql_query("SELECT cliNome, cliEndereco, cliNumero, cliCelular, cliMoto, cliPlaca, orcItensResponsavel FROM clientes INNER JOIN orcamento_itens ON orcamento_itens.orcItensCliente_fk = clientes.cliCodigo WHERE orcamento_itens.orcItens_fk = '$codigoOrcamento'");
         while($res = mysql_fetch_array($sql))
         {
             $objCliente     = $res['cliNome'];
             $objEndereco    = $res['cliEndereco'];
             $objNumero      = $res['cliNumero'];
             $objTelefone    = $res['cliCelular'];
             $objMoto        = $res['cliMoto'];
             $objPlaca       = $res['cliPlaca'];
             $objResponsavel = $res['orcItensResponsavel'];
         }

         /* LIMPANDO CAMPO DE CONTROLE NA TABELA */
         mysql_query("UPDATE ponteiro SET ponPonteiro = 6 WHERE ponResponsavel LIKE '$usuario'");
         mysql_query("UPDATE container SET conStatus = 0 WHERE conResponsavel LIKE '$usuario'");
        /* ### FIM DE ROTINA  ###  */
?>


<!--  ###############################################################################################   -->
<!--  ######################################   TELA DE IMPRESSÃO  ###################################   -->
<!--  ###############################################################################################   -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- ========== VIEWPORT META ========== -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        
<!-- ========== MINIFIED VENDOR CSS ========== -->
      <link rel="stylesheet" href="css/estilo.css">
        


<!-- BIBLIOTECA JAVASCRIPT  -->
<script type="text/javascript" src="js/script_print.js"></script>
<style type="text/css">
  #frame-impressao         {position:absolute;top:13%;width:98%;height:10%;border-style:ridge;}
  #frame-tabela-printer    {position:absolute;top:25%;width:98%;height:40%;border-style:none;font-size:70%;}
  #header-printer          {position:absolute;width:99%;height:10%;top:00%;border-style:none;}
  #onclosure               {position:absolute;width:97%;height:97%;border-style:none;}
  #fraseologia             {position:fixed;width:99%;height:13%;top:87%;background-color:#FFFFE0;border-style:ridge;}
  .frases p                {font-size:15px;}



  .lb-celular-print        {position:absolute;top:57%;left:03%;font-size:70%;}
  .lb-celular-printer      {position:absolute;top:57%;left:13%;font-size:70%;}
  .lb-endereco-print       {position:absolute;top:40%;left:1.8%;font-size:70%;}
  .lb-endereco-printer     {position:absolute;top:40%;left:13%;font-size:70%;}
  .lb-km-print             {position:absolute;top:75%;left:80%;font-size:70%;}
  .lb-km-printer           {position:absolute;top:75%;left:85%;font-size:70%;}
  .lb-nome-print           {position:absolute;top:20%;left:06%;font-size:70%;}
  .lb-nome-printer         {position:absolute;top:20%;left:13%;font-size:70%;}
  .lb-numero-print         {position:absolute;top:40%;left:52.5%;font-size:70%;}
  .lb-numero-printer       {position:absolute;top:40%;left:62%;font-size:70%;}
  .lb-pedido-print         {position:absolute;top:01%;left:4.8%;font-size:70%;}
  .lb-pedido-printer       {position:absolute;top:01%;left:21%;font-size:70%;}
  .lb-placa-print          {position:absolute;top:75%;left:54%;font-size:70%;}
  .lb-placa-printer        {position:absolute;top:75%;left:62%;font-size:70%;}
  .lb-veiculo-print        {position:absolute;top:75%;left:3.3%;font-size:70%;}
  .lb-veiculo-printer      {position:absolute;top:75%;left:13%;font-size:70%;}
  .lb-vendido-print        {position:absolute;top:01%;left:48%;font-size:70%;}
  .lb-vendido-printer      {position:absolute;top:01%;left:62%;font-size:70%;}
  .tabela-letras           {font-size:70%;}
  .title-menu              {position:absolute;font-size:100%;top:00%;left:44%;}
  .title-menu1             {position:absolute;font-size:100%;top:20%;left:44%;}
  .title-menu2             {position:absolute;font-size:100%;top:40%;left:44%;text-align: center}
  .title-menu-fone         {position:absolute;font-size:80%;top:65%;left:43%;text-align: center}
  .title-menu-fone1        {position:absolute;font-size:95%;top:80%;left:43%;text-align: center}

</style>
<script type="text/javascript">
  /*  ###  FUNÇÃO PARA SAIDA DA TELA DE IMPRESSÃO E VOLTAR AO ORÇAMENTO  ####  */
function imprimir_voltar()
{
     location.href="http://www.grausmotos.com.br/ponteiro.php?sender=6";
}
/*  ###    FIM DE FUNÇÃO VOLTA IMPRIMIR    ### */ 

</script>

</head>
<!-- onload="load_print();" -->
<body onload="load_print();">
  <!--  ###   INICIO DE FRAME EXTERNO PARA COMPORTAR FRASEOLOGIA NO FINAL DA PÁGINA  ####   -->
<article id="onclosure">        
        <!--   ###  INÍCIO DE CABEÇÁRIO  -->
        <div id="header-printer">
             <a href=""><img src="pedidos/img/logo.jpg" alt="some text" width=260 height=120 onclick="voltar_print()"></a>
             <p class="title-menu"><strong>GRAUS MOTOS</strong></p>
             <p class="title-menu-fone"><strong>TELEFONE.: (19) 3935-3312</strong></p>
             <p class="title-menu-fone1"><strong>CELULAR.: (19) 99649-4156</strong></p>
         </div>
        <!--   ###  FINAL DE CABEÇÁRIO  -->
  

        <!--  ###   INICIO DE LINHAS DOS ITENS NO ORÇAMENTO   ####   -->
        <section id="frame-impressao">
             <label class="lb-nome-print"><strong>NOME.:</strong></label>
               <label class="lb-nome-printer"><?php print utf8_encode($objCliente); ?></label>   <!--  ####   VARIÁVEL objCliente QUE RECEBE NUMERO DE ORÇAMENTO PARA IMPRESSÃO  #### -->
             <label class="lb-endereco-print"><strong>ENDEREÇO.:</strong></label>
                 <label class="lb-endereco-printer"><?php print utf8_encode($objEndereco); ?></label>
             <label class="lb-pedido-print"><strong>ORÇAMENTO.:</strong></label>
                 <label class="lb-pedido-printer"><?php print $codigoPedido; ?></label>  
             <label class="lb-numero-print"><strong>NÚMERO.:</strong></label>
                 <label class="lb-numero-printer"><?php print $objNumero; ?></label>
             <label class="lb-celular-print"><strong>CELULAR.:</strong></label>
                 <label class="lb-celular-printer"><?php print $objTelefone; ?></label>
             <label class="lb-veiculo-print"><strong>MOTO.:</strong></label>
                 <label class="lb-veiculo-printer"><?php print $objMoto; ?></label>
             <label class="lb-placa-print"><strong>PLACA.:</strong></label>
                 <label class="lb-placa-printer"><?php print $objPlaca; ?></label>
             <label class="lb-km-print"><strong>KM.:</strong></label>
                 <label class="lb-km-printer"><?php print $objKm; ?></label>
             <label class="lb-vendido-print"><strong>VENDIDO POR.:</strong></label>
                 <label class="lb-vendido-printer"><?php print $objResponsavel; ?></label>
        </section>

        <section id="frame-tabela-printer">
                <table bgcolor="#FFFFFF" width="99.7%" border="1" cellpadding="1" cellspacing="1">
                   <!-- TABELA PARA IMPRIMIR O ORÇAMENTO OU O SERVIÇO -->
              
                      <tr>
                         <td width="20"  height="03" align="center"><strong>ITEM </strong></td>
                         <td width="20"  height="03" align="center"><strong>QUANT. </strong></td>
                         <td width="850" height="03" align="center"><strong>DESCRIÇÃO</strong></td>
                         <td width="80"  height="03" align="center"><strong>PREÇOS</strong></td>
                         <!--td width="80"  height="03" align="center"><strong>TOTAL</strong></td-->
                      <!--/tr> <!-- INICIO DO  PHP QUE TRAZ INFORMAÇÕES DO BANCO DE DADOS -->
                      <?php 
                            $it = mysql_query("SELECT * FROM orcamento_itens WHERE orcItens_fk = '$codigoOrcamento'");
                            while($res = mysql_fetch_array($it))
                            {  ?>
                              
                                  <tr>
                                      <td><?php print $res['orcItensIdProduto_fk']; ?></td>
                                      <td><?php print $res['orcItensQuantidade']; ?></td>
                                      <td><?php print utf8_encode($res['orcItensDescricao']); ?></td>
                                      <td><?php print $res['orcItensTotal']; ?></td>
                                      <!--td><?php/* print $res['iteTotal']*/ ?></td-->
                                  </tr>  <?php }  ?>
                                  <tr>
                                    <?php 
                                         $objFinal = mysql_query("SELECT orcTotal  FROM orcamento WHERE orcCodigo = '$codigoOrcamento'");
                                          while($objV = mysql_fetch_array($objFinal))
                                           {
                                              $valor_orcamento = $objV['orcTotal'];
                                           }
                                    ?>
                                      <input type="hidden" name="valor_orcamento" id="valor_orcamento" value="<?php print $valor_orcamento;?>">
                                  </tr>
                                      
                </table>
                
        <div id="total-impressao">
          <table width="99.7%" border="1" cellpadding="1" cellspacing="1">
            <tr>
                <td width="860"><strong>VALOR DESCONTO.:</strong></td>
                <td width="82"><strong><?php print $desconto;?></strong></td>
            </tr>
            <tr>
                <td width="860"><strong>VALOR TOTAL ORÇAMENTO.:</strong></td>
                <td width="82"><strong><?php print $valor_orcamento;?></strong></td>
            </tr>
          </table>
        </div>      
        </section>
        <!-- ###   INÍCIO DO RODAPÉ COM A FRASEOLOGIA EMPREGADA  ###  -->
        <section id="fraseologia" class="frases">
          <?php $objCo = mysql_query("SELECT orcGarantia, orcComentario FROM orcamento WHERE orcCodigo = '$codigoOrcamento'"); 
                        while($objC = mysql_fetch_array($objCo))
                         {
                               $validade    = $objC['orcGarantia'];
                               $comentarios = $objC['orcComentario'];
                         }
             ?>

              <p><?php print $validade ?></p>
              <p>ASSINATURA.:__________________________________________________________________.</p>
              <p>COMENTÁRIOS.: &nbsp;<?php print $comentarios ?>.</p>
        </section>
       <!-- ###   FINAL DE RODAPÉ COM A FRASEOLOGIA EMPREGADA  ###  -->
</article>
<!--?php
      require 'footerprint.php';
?-->

  
</body>
</html>