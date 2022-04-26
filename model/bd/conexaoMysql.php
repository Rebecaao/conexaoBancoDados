<?php
/****** 
 * Objetivo: Arquivo para criar conexãocom o BD Mysql
 * autor: rebeca
 * data:25/02/2022
 * versao:1.0
******************************************************/



// constante para estabelcer a conexao local com o BD (local do BD, usuario, senha, database)
const SERVER = 'localhost';
const USER = 'root';
const PASSOWORD = 'bcd127';
const DATABASE = 'dbcontatos';

$resultado = conexaoMysql();
//abre a conexao com o banco de bados Mysql
function conexaoMysql()
{
    $conexao = array();
    //monta o script para enviar para o BD
   
                 

    //se a conexao for estabelecida com o bd, iremos ter um array de dados sobre a conexao
    $conexao = mysqli_connect(SERVER, USER, PASSOWORD, DATABASE);

    // validacao para verificar se a conexao foi realizada com sucesso
    if ($conexao)
        return $conexao;
    else
        return false;

}

//fecha a conexao com o bd
function fecharConexaoMysql($conexao)
{
    mysqli_close($conexao);
}

/**existem 3 formas de criar uma conexao com banco de dados Mysql
 * 
 *  mysql_connect()- versao antiga do php de fazer a coexao com bd (nao oferece perfomance de segurança)
 
 * mysqli_connect()- versao atualizDA do php fazer a conexao com bd
     (ela permite ser utilixada para programçao estruturada e poo)
 
 *PDO()- versao mais completa e eficiente par aconexao com bd
    (é indicada pela segurança e poo)
 */

?>