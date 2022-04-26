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
 function inserirContato ($dadosContato, $file)
 {
   // empty verifica seo objeto esta vazio
    if(!empty($dadosContato))
    {
      //validacao de caixa vazia dos elementos nome, email, celular, pois sao campos
      //obrigatorios no BD
      if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular'])&& !empty($dadosContato['txtEmail']))
      {

        if ($file != null)
        {
          require_once('modulo/upload.php');
          $resultado = uploadFile($file['fleFoto']);
         
          
          echo($resultado);
          die;
        }

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

            //import do arquivo de modelagem para manipular o BD
            require_once('./model/bd/contato.php');

            //chama a funçao que fara o insert no BD(esta funçao esta na model)
            if (insertContato($arrayDados))
              return true;
            else
              return array('idErro' => 1,
                          'message' => 'não foi possivel inserir os dados no Banco de Dados');

      }else
         return array('idErro' => 2,
                      'message' => 'Existem campos obrigatórios que nao foram preenchidos '); 
      }
    }
 

  //funcao para escrever dados da view e  encaminhar para a model (atualizar)
  function atualizarContato($dadosContato, $id)
 { 
    // empty verifica seo objeto esta vazio
    if(!empty($dadosContato))
    {
      //validacao de caixa vazia dos elementos nome, email, celular, pois sao campos
      //obrigatorios no BD
      if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular'])&& !empty($dadosContato['txtEmail']))
      {

        //validacao para garantir que  o id é valido
        if(!empty($id) && $id !=0 && is_numeric($id))
        {

        //cracao do array de dados que sera encaminhado a model 
        //para inserir no BD, é importante criar este array conforme
        //as necessidades de manipulaçao do BD
        //OBS: criar chaves do array conforme os nomes dos atributos do bd
              $arrayDados= array(

                'id'  =>  $id,
                'nome' => $dadosContato['txtNome'],
                'telefone' => $dadosContato['txtTelefone'],
                'celular' => $dadosContato['txtCelular'],
                'email' => $dadosContato['txtEmail'],
                'obs' => $dadosContato['txtObs'],

        
              );

             

              //import do arquivo de modelagem para manipular o BD
              require_once('./model/bd/contato.php');

              //chama a funçao que fara o insert no BD(esta funçao esta na model)
              if (upDateContato($arrayDados))
                return true;
              else
                return array('idErro' => 1,
                            'message' => 'não foi possivel atualizar os dados no Banco de Dados');
        }else{
          return array('idErro' => 4,
          'message' => 'Não é possivel editar um registro sem informar um id válido.');
        }

      }else
         return array('idErro' => 2,
                      'message' => 'Existem campos obrigatórios que nao foram preenchidos '); 
   }
 }

 //funcao para realizar a exclusao de dasdos
 function excluirContato ($id)
 {

  //validacao para verificar se o id tem um numero valido
    if($id != 0 && !empty($id) && is_numeric($id))
    {

      //import do arquivo de contato
      require_once('model/bd/contato.php');

      //chama a duncao da model e valida se o retorno foi verdadeiro ou falso
      if(deleteContato($id))
        return true;
      else 
        return array('idErro' => 3,
                      'message' => 'O banco de dados não pode excluir o registro.');

    }else
      return array('idErro' => 4,
                  'message' => 'Não é possivel excluir um registro sem informar um id válido.');

 }

 //funcao para solicitar os dados da model e encaminhar a lista de contatos da view
function listarContato ()
 {
   //import do arquivo que vai buscar os dados do BD
    require_once('model/bd/contato.php');

    //chama a funçao que vai buscar os dados no BD
    $dados = selectAllContato();

    if(!empty($dados))
      return $dados;
    else
      return false;
 }

 //funcao para buscar um contato atravez do id do registro
 function editarContato($id){
 //validacao para verificar se o id tem um numero valido
    if($id != 0 && !empty($id) && is_numeric($id))
    {
        //import do arquivo de contato
        require_once('model/bd/contato.php');

        $dados = selectByIdContato($id);

        //valida se existem dados para serem devolvidos 
        if(!empty($dados))
            return $dados;
        else
            return false;
        
        
    } else{
        return array('idErro' => 4,
      'message' => 'Não é possivel excluir um registro sem informar um id válido.');

    }
}
?>