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
    //abre a conexao com o banco
        $conexao = conexaoMysql();

        $sql = "insert into tblcontatos
        (nome,
         telefone,
         celular,
         email,
         obs)
    values
         ('".$dadosContato['nome']."',
         '".$dadosContato['telefone']."',
         '".$dadosContato['celular']."',
         '".$dadosContato['email']."',
         '".$dadosContato['obs']."');";

         mysqli_query($conexao,$sql);
}
    
// criando funcao para realizar update no BD
function upDatetContato()
{
    
}
// criando funcao para listar todos os contatos do BD
function selecAlltContato()
{
    
}
// criando funcao para deletar no BD
function delettContato()
{
    
}

?>