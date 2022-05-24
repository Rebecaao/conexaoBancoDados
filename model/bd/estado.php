<?php
/*******************************************
 * Objetivo: arquivo responsavel por manipular osdados dentro do banco
 *  (select)
 * autor:rebeca
 * data
 * Versao:1.0
 * ******************************************
*/

require_once('conexaoMysql.php');

function selectAllEstados()
{
    //abre a conexao com o BD
    $conexao = conexaoMysql();


    // script para listar todos os dados do bd
    $sql = "select * from tblestados order by nome asc";
    
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
                "idestado"    => $rsDAdos['idestado'],
                "nome"  => $rsDAdos['nome'],
                "sigla" => $rsDAdos['sigla'],
            );
            $cont++;
        }
        

        fecharConexaoMysql($conexao);

        return $arrayDados;
    }
}

?>