<?php
/*******************************************
 * Objetivo: arquivo responsavel pela manipulaçao de dados contatos(obs:este arquivo
 * fara a ponte entre a view e a model)
 * autor:Rebeca 
 * data:04/03/22
 * versao:1.0
 *******************************************
 */

 //import do arquivo de configuracao dos projetos
 require_once(SRC.'modulo/config.php');
 
 //funcao para escrever dados da view e  encaminhar para a model (inserir)
 function inserirContato ($dadosContato, $file)
 {

  $nomeFoto = (string) null;
   // empty verifica seo objeto esta vazio
    if(!empty($dadosContato))
    {
      //validacao de caixa vazia dos elementos nome, email, celular, pois sao campos
      //obrigatorios no BD
      if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular'])&& !empty($dadosContato['txtEmail'])&& !empty($dadosContato['sltEstado']))
      {

        //validacao para verificar se chegou um arquivo para upload
        if ($file['fleFoto']['name']!= null)
        {
          //import da funcao pload
          require_once('modulo/upload.php');
          
          //chama a funcao upload
          $nomeFoto = uploadFile($file['fleFoto']);

          if(is_array($nomeFoto))
          {
            //caso aconteca algum erro no processo do upload, a função ira retornar
            //um array com a possivel mensagem de erro. Esse array será retornado para a router
            //e ela ira exibir a mensagem para o usuario
              return $nomeFoto;
          }
         
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
              'foto' => $nomeFoto,
              'idestado' => $dadosContato['sltEstado']
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
  function atualizarContato($dadosContato, $arrayDados)

 
  { 

    $statusUpload = (boolean) false;
      //recebe o id enviado pelo array dados
      $id = $arrayDados['id'];

      //Recebe a foto enviada pelo arrayDados (nome da foto ja existente no bd)
      $foto = $arrayDados['foto'];

      //recebe o objeto de array referente a nova foto que ppodera ser enviada ao servidor
      $file = $arrayDados['file'];
 
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

          //validacao para identificar se sera enviado ao servidor uma nova foto
          if($file['fleFoto']['nome'] != null)
          {
               //import da funcao pload
              require_once('modulo/upload.php');
              
              //chama a funcao upload para enviar a nova foto para o servidor
              $novaFoto = uploadFile($file['fleFoto']);
              $statusUpload = true;

          }else{
            //permanece a mesma foto no bd
            $novaFoto = $foto;
          }

        //criacao do array de dados que sera encaminhado a model 
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
                'foto' => $nomeFoto,
                'idestado' => $dadosContato['sltEstado']

        
              );

             

              //import do arquivo de modelagem para manipular o BD
              require_once('./model/bd/contato.php');

              //chama a funçao que fara o insert no BD(esta funçao esta na model)
              if (upDateContato($arrayDados))
              {

               //validacao para verificar se sera necessario apagar a foto antiga 
               //esta variavel foi ativada em true na linha 
                if($statusUpload){
                   //apaga a foto antiga da pasta do servidor
                  unlink(DIRETORIO_FILE_UPLOAD.$foto); 
                }
                return true;
              }
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
 function excluirContato ($arrayDados)
 {

    //recebe o id do registro que sera excluido
      //pegando ele de dentro do arrayDados
      $id = $arrayDados['id'];
      
      //recebe o nome da foto que sera excluida da pasta
      $foto = $arrayDados['foto'];

  //validacao para verificar se o id tem um numero valido
    if($id != 0 && !empty($id) && is_numeric($id))
    {

      //import do arquivo de contato
      require_once('model/bd/contato.php');
      require_once('modulo/config.php');

      //chama a duncao da model e valida se o retorno foi verdadeiro ou falso
      if(deleteContato($id))
      {
        
          if($foto!=null)
          {
              //apaga foto de um computador local
              //comentario do professor: permite apagar a foto fisicamente do diretorio do servidor
              if(unlink(DIRETORIO_FILE_UPLOAD.$foto))
                  return true;
              else
                  return array('idErro' => 5,
                                'message' => 'O registro do banco de dados foi excluido com sucesso,
                                  porem a imagem não foi excluida do diretorio do servidor!');
          }else
              return true;
          

      }else 
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
    require_once(SRC.'model/bd/contato.php');

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
        require_once(SRC.'model/bd/contato.php');


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