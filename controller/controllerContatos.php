<?php
/*******************************************
 * Objetivo: arquivo responsavel pela manipulaçao de dados contatos(obs:este arquivo
 * fara a ponte entre a view e a model)
 * autor:Rebeca 
 * data:04/03/22
 * versao:1.0
 *******************************************
 */

 //funcao para escrever dados da view e  encaminhar para a model (inserir)
 function inserirContato ($dadosContato)
 {
   // empty verifica seo objeto esta vazio
    if(!empty($dadosContato))
    {
      //validacao de caixa vazia dos elementos nome, email, celular, pois sao campos
      //obrigatorios no BD
      if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular'])&& !empty($dadosContato['txtEmail']))
      {

        //cracao do array de dados que sera encaminhado a model 
        //para inserir no BD, é importante criar este array conforme
        //as necessidades de manipulaçao do BD
        //OBS: criar chaves do array conforme os nomes dos atributos do bd
            $arrayDados= array(
              'nome' => $dadosContato['txtNome'],
              'telefone' => $dadosContato['txtTelefone'],
              'celular' => $dadosContato['txtCelular'],
              'email' => $dadosContato['txtEmail'],
              'obs' => $dadosContato['txtObs'],
            );
            require_once('./model/bd/contato.php');

            insertContato($arrayDados);

      }else{
          echo('dados incompleto');
      }
      }
    }
 

  //funcao para escrever dados da view e  encaminhar para a model (atualizar)
  function atualizarContato()
 { 

 }

 //funcao para realizar a exclusao de dasdos
 function excluirContato ()
 {

 }

 //funcao para solicitar os dados da model e encaminhar a lista de contatos da view
function listarContato ()
 {
 
 }
?>