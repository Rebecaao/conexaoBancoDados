<?php
/*******************************************
 * Objetivo: arquivo de rota, para seguimentar as acoes encaminhadas pela view
 *     (dados de um form, listagem de dados, acao de excluir ou atualizar)
 *  esse arquivp sera responsavel por encaminhar as solicitacoes para a controller
 * Autor:Rebeca Lopes de Oliveira
 * Versao:1.0
 * ******************************************
*/

$action = (string) null;
$component = (string) null;



//validacao para verificar se a requisiçao é um post de um formulario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
       

        // recebendo dados via url para saber quem esta solicitando e qual açao sera 
        //realizada
        $component = strtoupper($_GET['component']);
        $action = strtoupper($_GET['action']);

        //estrutura condicional para validar quem esta solicitando algo para o pout
        switch($component)
        {
            case 'CONTATOS':
                require_once('controller/controllerContatos.php');
                if($action == 'INSERIR')
                    inserirContato($_POST);
                elseif($action == 'EDITAR')
                    atualizarContato();

            break;
        }


    }

?>