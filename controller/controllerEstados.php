<?php
/*******************************************
 * Objetivo: arquivo responsavel pela manipulaçao de dados estados(obs:este arquivo
 * fara a ponte entre a view e a model)
 * autor:Rebeca 
 * data:10/03/22
 * versao:1.0
 *******************************************
 */

require_once('modulo/config.php');

function listarEstado()
 {
   //import do arquivo que vai buscar os dados do BD
    require_once('model/bd/estado.php');

    //chama a funçao que vai buscar os dados no BD
    $dados = selectAllEstados();

    if(!empty($dados))
      return $dados;
    else
      return false;
 }



?>