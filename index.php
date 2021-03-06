<?php

    require_once('modulo/config.php');
 
 
//essa varievel foi criada para diferenciar no action do formulario
//qual acao devria ser levada para router (insert ou editar).
//nas condicoes abaixo, mudamoso action dessa variavel para a acao de editar
$form = (string) "router.php?component=contatos&action=inserir";

//variavel para carregar o nome da foto no bd
$foto = (string) null;

//variavel para ser utilizada ao carregar 
$idestado = (string) null;


//valida se a utilizacao de variaveis de sessao esta ativa no servidor
if(session_status()){
        //valida se a variaver de sessao dadoscontatos
        //nao esta vazia
    if(!empty($_SESSION['dadosContato']))
    {
        $id = $_SESSION['dadosContato']['id'];
        $nome = $_SESSION['dadosContato']['nome'];
        $telefone = $_SESSION['dadosContato']['telefone'];
        $celular = $_SESSION['dadosContato']['celular'];
        $email = $_SESSION['dadosContato']['email'];
        $obs = $_SESSION['dadosContato']['obs'];
        $foto = $_SESSION['dadosContato']['foto'];
        $idestado = $_SESSION['dadosContato']['idestado'];
 
        //mudamos a acao do form  para editar o registro no click do botao salvar 
        $form = "router.php?component=contatos&action=atualizar&id=".$id."&foto=".$foto;
 
        //destroi uma variavel da memoria do servidor
        unset($_SESSION['dadosContato']);
        
    }
}
 
?>
 
 
<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
 
 
    </head>
    <body>
       
       <div id="cadastro"> 
           <div id="cadastroTitulo"> 
               <h1> Cadastro de Contatos </h1>
               
           </div>
           <div id="cadastroInformacoes">
                <form  action="<?=$form?>" name="frmCadastro" method="post" enctype="multipart/form-data"> 
                <!-- /*sem o enctype não é possivel enviar arquivos do form em html para o servidor  */ -->
                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Nome: </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <input type="text" name="nome" value="<?=isset($nome)?$nome:null?>" placeholder="Digite seu Nome" maxlength="100">
                           <!-- isset($nome)?$nome:null - if ternario  -->
                       </div>
                   </div>
                  
                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Estado </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <select name="estado" id="">
                                <option value="">Selecione um item</option>
                                <?php
                                    require_once('controller/controllerEstados.php');

                                    //chama a funcao para carregar todos os estados
                                    $listEstados = listarEstado();
                                    foreach($listEstados as $item)
                                    {
                                        ?>
                                                <option <?=$idestado==$item['idestado']?'selected':null ?> value="<?=$item['idestado']?>"><?=$item['nome']?></option>
                                        <?php
                                    }
                                ?>
                           </select>
                       </div>
                   </div>

                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Telefone </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <input type="text" name="telefone" value="<?=isset($telefone)?$telefone:null?>" placeholder="Digite seu Nome" maxlength="100">
                           <!-- isset($nome)?$nome:null - if ternario  -->
                       </div>
                   </div>
                                    
               
                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Celular: </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <input type="tel" name="celular" value="<?=isset($celular)?$celular:null?>">
                       </div>
                   </div>
                  
                   
                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Email: </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <input type="email" name="email" value="<?=isset($email)?$email:null?>">
                       </div>

                    


                   </div>
                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Escolha um arquivo: </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <input type="file" name="foto" accept=".jpg, .png, .jpeg, .gif" >
                       </div>
                   </div>
                   <div class="campos">
                       <div class="cadastroInformacoesPessoais">
                           <label> Observações: </label>
                       </div>
                       <div class="cadastroEntradaDeDados">
                           <textarea name="obs" cols="50" rows="7"><?=isset($obs)?$obs:null?></textarea>
                       </div>
                   </div>
                   
                   <div class="campos">
                        <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" alt="">
                   </div>
                   
                   <div class="enviar">
                       <div class="enviar">
                           <input type="submit" name="btnEnviar" value="Salvar">
                       </div>
                   </div>
               </form>
           </div>
       </div>
       <div id="consultaDeDados">
           <table id="tblConsulta" >
               <tr>
                   <td id="tblTitulo" colspan="6">
                       <h1> Consulta de Dados.</h1>
                   </td>
               </tr>
               <tr id="tblLinhas">
                   <td class="tblColunas destaque"> Nome </td>
                   <td class="tblColunas destaque"> Celular </td>
                   <td class="tblColunas destaque"> Email </td>
                   <td class="tblColunas destaque"> Foto </td>
                   <td class="tblColunas destaque"> Opções </td>
                   
               </tr>
               
                 <?php
 
                     //import do arqivo da controller para solicitar a listagem dos dados
                    require_once('controller/controllerContatos.php');
                    
                    //chama a funçao que vai retornar os dados de contatos
                    if($listContatos = listarContato())
                    {
                
                    //estrutura de repetiçao para retornar os dados do array e printarna tela
                    foreach($listContatos as $item){

                        //variavel para carregar a foto que veio do bd
                        $foto = $item['foto'];
                ?>
                   <tr id="tblLinhas">
                       <td class="tblColunas registros"><?=$item['nome']?></td>
                       <td class="tblColunas registros"><?=$item['celular']?></td>
                       <td class="tblColunas registros"><?=$item['email']?></td>
                       <td class="tblColunas registros"><img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" class="foto"></td>
                   
                       <td class="tblColunas registros">
 
                               <a href="router.php?component=contatos&action=editar&id=<?=$item['id']?>">
                                   <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                               </a>
                               
                               <a onclick="return confirm('Deseja realmente excluir o contato <?=$item['nome']?>?')" href="router.php?component=contatos&action=deletar&id=<?=$item['id']?>&foto=<?=$foto?>">
                                   <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir" >
                               </a>
 
                               <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                       </td>
                   </tr>
               <?php
                   }
                }
               ?>
           </table>
       </div>
   </body>
</html>
