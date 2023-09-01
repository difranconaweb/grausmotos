/* SISTEMA DESENVOLVIDO POR FRANCO VIEIRA MORALES - INDAIATUBA 10SET18
   SISTEMA DESARROLLADO POR FRANCO VIEIRA MORALES - INDAIATUBA 10SET18
   SYSTEM  DEVELOPED    BY  FRANCO VIEIRA MORALES - INDAIATUBA 10SET18

   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 11SET18
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 24SET18
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 25SET18
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 28SET18
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 30SET18
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 07SET21
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 17ABR22
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 16JUN22
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 23JUN22
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 08SET22
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 10MAR23
   ÚLTIMA ALTERAÇÃO FRANCO VIEIRA MORALES - INDAIATUBA 06MAI23 - RES000101/13BR
                                                                 (19)3017-3460
                                                                 (19)99272-0159
                                                                 (19)99751-7645

    ARQUIVO JAVASCRIPT PARA CONTROLE DA DAS PRIMEIRAS FUNÇÕES DO SISTEMA //
 **/

//  ########    FUNÇÃO PARA REQUISIÇÃO ASSINCRONA   #####  //
function createRequest()
{
  try{
       request =  new XMLHttpRequest();  //Esta linha tenta criar um novo objeto de solicitação
     }
     catch(trymicrosoft)
     {          //Estas duas linhas tentam criar objeto de solicitação, porém que funcione no explorer
         try
         {
           request = new ActiveXObject("Msxml2.XMLHTTP");
         }
          catch(othermicrosoft)
          {
            try
            {
              request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(failed)
            {   // SE NÃO FUNCIONAR ESTA INSTRUÇÃO ASSEGURA QUE A VARIÁVEL CONTINUA SENDO 'NULA' //
              request = null;
            }
          }
     }
     if(request == null)     // SE ALGO SAIR ERRADO, MENSAGEM DE ALERTA "NÃO FOI POSSÍVEL CRIAR O OBJETO REQUEST //
     {
       alert("Erro ao criar o objeto de pedido");
     }
}
//  ###   FIM DE AJAX  #### //

// ## FUNÇÃO DE CARREGAR TELA PARA LOGIN ## //
function loadTela()
{
    document.getElementById('nome').focus();
}
// ## FINAL DE FUNÇÃO CARGA DE TELA ## //

///  ########    FUNÇÃO PARA VALIDAR LOGIN   #####  //
function loger()
{
   var nome  = document.getElementById('nome').value;
   var senha = document.getElementById('senha').value;
   

   if(nome == "")
   {
       document.getElementById("excessao").innerHTML = "<div class='alert alert-danger'>ATENÇÃO; O CAMPO NOME DEVERÁ SER PREENCHIDO</div>";
       setTimeout(function(){document.getElementById("excessao").innerHTML = "";}, 2000);
   }

   else if(senha == "")
   {
       document.getElementById("excessao").innerHTML = "<div class='alert alert-danger'>ATENÇÃO; O CAMPO SENHA DEVERÁ SER PREENCHIDO</div>";
       setTimeout(function(){document.getElementById("excessao").innerHTML = "";}, 2000);
   }

   else
   { 
      createRequest();  
    // INICIA A REQUISIÇÃO //
      var url = "login/login.php?nome="+escape(nome)+"&senha="+escape(senha);
      request.open("GET", url, true);
    // ATRIBUI UMA FUNÇÃO PARA SER EXECUTADA SEMPRE QUE HOUVER UMA MUDANÇA //
       request.onreadystatechange = function(){ // VERIFICA SE FOI CONCLUIDO COM SUCESSO E A CONEXÃO FECHADA (readyState=4)
       if (request.readyState == 4)
       {                                      // VERIFICA SE O ARQUIVO FOI ENCONTRADO COM SUCESSO //
           if (request.status == 200)
           { 
               var obj = request.responseText; 
               if(obj == 0)
               { 
                   document.getElementById("excessao").innerHTML = "<div class='alert alert-danger'>ATENÇÃO..: LOGIN OU SENHA ESTÃO ERRADOS!! </div>";
                   setTimeout(function(){document.getElementById("excessao").innerHTML = "";}, 2000);
               }

               else if(obj == 2)//  SE ENTRAR NESTE BLOCO, INFORMA QUE JÁ ESTÁ LOGADO //
               {
                   document.getElementById("confirmacao").innerHTML = "<div class='alert alert-warning excessao-chave-login'><h4><strong>USUÁRIO JÁ CONECTADO - PARA DESLOGAR DIGITE A SUA CHAVE E SENHA</strong></h4><div class='row form-group'><div class='col-md-6 mb-6 mb-md-0'><input style='color:#000000' type='text' name='chave' id='chave' class='form-control'></div></div><h4><strong>CHAVE</strong></h4><div class='row form-group'><div class='col-md-6'><input style='color:#000000' type='password' name='senha' id='senha' class='form-control'></div></div><div class='row form-group'><div class='col-md-12'><h4><strong>SENHA</strong></h4></br><ul><input type='button' class='btn btn-primary btn-md btn-green text-white' value='AVANÇAR' onclick='reset_login()'><input type='button' class='btn btn-primary btn-md btn-blackRed text-white' value='FECHAR' onclick='no_reset_login()'><span id='ret_login' class='ret_login'></span></ul></div></div>";
                   document.getElementById('chave').focus(); // FOCANDO O CURSOR NO CAMPO A SER PREENCHIDO //
               }

               else if(obj == 3)
               {// SE VOLTAR VALOR 3 - ENTAO NAO ESTÁ NO HORÁRIO DE ACESSO //
                   document.getElementById("excessao").innerHTML = "<div class='alert alert-danger'>ATENÇÃO - FORA DE HORÁRIO DE LOGIN !!!</div>"; 
                   setTimeout(function(){document.getElementById("excessao").innerHTML = "";}, 2000);
               }

               else
               { //  SE ENTRAR NESTE BLOCO, ESTÁ TUDO BEM E ACESSA O SISTEMA //
                   document.getElementById("excessao").innerHTML = "<div class='alert alert-info'>LOGANDO...</div>"; 
                   // LIMPANDO MENSAGEM CASO HAJA //
                   setTimeout(function(){window.location.href = "http://www.grausmotos.com.br/ponteiro.php?sender="+escape(1);}, 2000);
               }
          }
       
          else
          { 
              document.getElementById("excessao").innerHTML = "ERRO: " + request.statusText;
          }
      }};
      request.send(null); 
   }
}
//  ########    FINAL DE FUNÇÃO LOGIN   #####  //


// ##  ROTINA PARA FECHAR A JANELA DE CHAVE DE LOGIN ## //
function no_reset_login()
{
    document.getElementById("confirmacao").innerHTML = "";
}
// ## FINAL DE ROTINA ## //


// ## FUNÇÃO PARA O RESET DE LOGIN ## //
function reset_login()
{
     var chave = document.getElementById('chave').value;
     var senha = document.getElementById('senha').value;

      if(chave == "")
      { 
          document.getElementById("ret_login").innerHTML = "<div class='alert alert-danger'>ATENÇÃO..: O CAMPO DA CHAVE  NÃO PODE ESTAR VÁZIO!! </div>";
          setTimeout(function(){document.getElementById("ret_login").innerHTML = "";}, 2000);
      }

      else if(senha == "")
      { 
          document.getElementById("ret_login").innerHTML = "<div class='alert alert-danger'>ATENÇÃO..: O CAMPO DA SENHA  NÃO PODE ESTAR VÁZIO!! </div>";
          setTimeout(function(){document.getElementById("ret_login").innerHTML = "";}, 2000);
      }

      else
      {
           createRequest();  
          // INICIA A REQUISIÇÃO //
            var url = "login/reseter.php?chave="+escape(chave)+"&senha="+escape(senha);
            request.open("GET", url, true);
          // ATRIBUI UMA FUNÇÃO PARA SER EXECUTADA SEMPRE QUE HOUVER UMA MUDANÇA //
             request.onreadystatechange = function(){ // VERIFICA SE FOI CONCLUIDO COM SUCESSO E A CONEXÃO FECHADA (readyState=4)
             if (request.readyState == 4)
             {                                      // VERIFICA SE O ARQUIVO FOI ENCONTRADO COM SUCESSO //
                 if (request.status == 200)
                 { 
                     var obj = request.responseText;
                     if(obj == 0)
                     {
                          document.getElementById("ret_login").innerHTML = "<div class='alert alert-danger'>OPA!  ESTA CHAVE QUE VOCE DIGITOU ESTÁ ERRADA, TENTE OUTRA. </div>";
                         setTimeout(function(){document.getElementById("ret_login").innerHTML = "";document.getElementById('chave').focus()}, 4000); 
                     }

                     else
                     {
                         document.getElementById("ret_login").innerHTML = "<div class='alert alert-danger'>AGUARDE ENQUANTO O SISTEMA ESTÁ DESLOGANDO... </div>";
                         setTimeout(function(){window.location.href = "http://www.grausmotos.com.br/ponteiro.php?sender="+escape(1);}, 2000);
                     }
                 }

                 else
                 {
                      document.getElementById("ret_login").innerHTML = "<div class='alert alert-danger'>ERRO AO DESLOGAR USUÁRIO - CONTATE O ANALISTA  :( </div>";
                     setTimeout(function(){document.getElementById("ret_login").innerHTML = "";}, 2000);
                 }
             }};
             request.send(null);
        }
}
// ## FINAL DE FUNÇÃO PARA O RESET DE LOGIN ## //