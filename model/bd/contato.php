<?php

/****** 
 * Objetivo: Arquivo responsavel por manipular os dados dentro do banco de dados
 * (insert, update, selec e delete)
 * autor: rebeca
 * data:11/03/2022
 * versao:1.0
******************************************************/
//import do arquivos para estabelecer 
require_once('conexaoMysql.php');

// criando funcao para realizar inset no BD
function insertContato($dadosContato)
{
    $statusResposta = (boolean) false;
    //abre a conexao com o banco
        $conexao = conexaoMysql();

        $sql = "insert into tblcontatos
        (nome,
         telefone,
         celular,
         email,
         obs,
         foto)
    values
         ('".$dadosContato['nome']."',
         '".$dadosContato['telefone']."',
         '".$dadosContato['celular']."',
         '".$dadosContato['email']."',
         '".$dadosContato['obs']."',
        '".$dadosContato['foto']."');";

         //executa o script no bd
         //validacao para identificar se o script esta certo
         if(mysqli_query($conexao,$sql)){
           //validacao para verificae se uma linha foi acrescentada no DB
            if(mysqli_affected_rows($conexao))
                $statusResposta = true;
            else
            $statusResposta = false;
         } 
        else {
            $statusResposta = false;
        }

        // solicita o fechamento 
        fecharConexaoMysql($conexao);
        return $statusResposta;
            
}
    
// criando funcao para realizar update no BD
function upDateContato($dadosContato)
{
    $statusResposta = (boolean) false;
    //abre a conexao com o banco
        $conexao = conexaoMysql();

        $sql = "update tblcontatos set
        nome = '".$dadosContato['nome']."',
         telefone = '".$dadosContato['telefone']."',
         celular = '".$dadosContato['celular']."',
         email = '".$dadosContato['email']."',
         obs= '".$dadosContato['obs']."',
         foto= '".$dadosContato['foto']."'
        
         where idcontato = ".$dadosContato['id'];
  
        
         //executa o script no bd
         //validacao para identificar se o script esta certo
        if(mysqli_query($conexao,$sql)){
           //validacao para verificae se uma linha foi acrescentada no DB
           
            if(mysqli_affected_rows($conexao))
            {
             $statusResposta = "true";
        
            }
        
        }

       
        // solicita o fechamento 
        fecharConexaoMysql($conexao);
        return $statusResposta;
}
// criando funcao para listar todos os contatos do BD
function selectAllContato()
{
    //abre a conexao com o BD
    $conexao = conexaoMysql();


    // script para listar todos os dados do bd
    $sql = "select * from tblcontatos order by idcontato desc";
    
    //executa o sript no bd e guarda o retorno dos dados, se houver
    $result = mysqli_query($conexao, $sql);

    //valida se o bd retornou registros 
    if($result)
    {
        //mysqli_fetch_assoc() - permite converter os dados do BD em um array para manipular no php
        //nesta repeticao estamos, convertendo os dados do bd em um array ($rsDAdos), alem de o proprio whilw
        //conseguir gerenciar a qtdade de vezes que devera ser feita a repeticao
        $cont = 0;
        while($rsDAdos = mysqli_fetch_assoc($result))

        {
            //cria um array com os dados do bd
            $arrayDados [$cont] = array(
                "id"    => $rsDAdos['idcontato'],
                "nome"  => $rsDAdos['nome'],
                "telefone" => $rsDAdos['telefone'],
                "celular" => $rsDAdos['celular'],
                "email" => $rsDAdos['email'],
                "obs" => $rsDAdos['obs'],
                "foto" => $rsDAdos['foto']
            );
            $cont++;
        }
        

        fecharConexaoMysql($conexao);

        return $arrayDados;
    }
}
// criando funcao para deletar no BD
function deleteContato($id)
{   
    $statusResposta = (boolean) false;

    
    //abre a conexao com o banco de dados
    $conexao = conexaoMysql();

    $sql= "delete from tblcontatos where idcontato=".$id;

    if(mysqli_query($conexao, $sql))
    {
        
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;
        
    }

    fecharConexaoMysql($conexao);
    // echo($statusResposta);
    // die;
    return $statusResposta;
}

//funcao criada para buscar um contato no bd atraves do id do registro
function selectByIdContato($id){
    //abre a conexao com o BD
    $conexao = conexaoMysql();


    // script para listar todos os dados do bd
    $sql = "select * from tblcontatos where idcontato = ".$id;
    
    //executa o sript no bd e guarda o retorno dos dados, se houver
    $result = mysqli_query($conexao, $sql);

    //valida se o bd retornou registros 
    if($result)
    {
        //mysqli_fetch_assoc() - permite converter os dados do BD em um array para manipular no php
        //nesta repeticao estamos, convertendo os dados do bd em um array ($rsDAdos), alem de o proprio whilw
        //conseguir gerenciar a qtdade de vezes que devera ser feita a repeticao
        
        if($rsDAdos = mysqli_fetch_assoc($result))

        {
            //cria um array com os dados do bd
            $arrayDados = array(
                "id"    => $rsDAdos['idcontato'],
                "nome"  => $rsDAdos['nome'],
                "telefone" => $rsDAdos['telefone'],
                "celular" => $rsDAdos['celular'],
                "email" => $rsDAdos['email'],
                "obs" => $rsDAdos['obs'],
                //editar foto- primeiro passo
                "foto" => $rsDAdos['foto']
            );
        }
        

        fecharConexaoMysql($conexao);

        return $arrayDados;
    }
}


?>