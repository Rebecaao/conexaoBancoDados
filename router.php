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
    if($_SERVER['REQUEST_METHOD'] == 'POST'  || $_SERVER['REQUEST_METHOD'] == 'GET' ){
       

        // recebendo dados via url para saber quem esta solicitando e qual açao sera 
        //realizada
        $component = strtoupper($_GET['component']);
        $action = strtoupper($_GET['action']);

        //estrutura condicional para validar quem esta solicitando algo para o pout
        switch($component)
        {
            case 'CONTATOS':
                //import da controller Contatos
                require_once('controller/controllerContatos.php');

                //validacao para identificar o tipo de açao que sserá realizada
                if($action == 'INSERIR')
                {
                   //validação para tratar se a imagem existe na chegada dos dados do html
                    if(isset($_FILES) && !empty($_FILES))
                    {
                        $arrayDados = array(
                                            $_POST,
                                            "file" => $_FILES
                                            );
                        //chama a funçao de inserir na controler
                        $resposta = inserirContato($arrayDados);
                    }else{
                        $arrayDados = array(
                            $_POST,
                            "file" => null
                            );
                      //chama a funcao de inserir na controller
                        $resposta = inserirContato($arrayDados);
                    }

                    //valida o tipo de dados que a controller retornou
                    if(is_bool($resposta))//se for booleano
                    { 

                        //verifica se o retorno foi verdadeiro
                        if($resposta)
                            echo("<script>
                            alert('Registro Inserido com sucesso!');
                            window.location.href = 'index.php';
                            </script>");
                    //se o retorno for um array significa erro no processo de inserção
                    }elseif(is_array($resposta)){
                        echo("<script>
                        alert('".$resposta['message']."');
                        window.history.back();
                        </script>");
                    }

                }elseif($action == 'DELETAR')
                {

                    //recebe o id do registro que devera ser excluido
                    //que foi enviado pela url no link da imagem
                    //do excluir que foi acionado na index
                    $idContato = $_GET['id'];    
                    $foto = $_GET['foto'];  

                    //criando array para encaminhar os valores do id e da foto para a controller
                    $arrayDados = array (
                        "id" => $idContato,
                        "foto" => $foto  
                    );

                    //chama a funcao excluir
                    $resposta = excluirContato($arrayDados);


                    if(is_bool($resposta))
                    {
                        if($resposta)
                        {
                            echo("<script>
                            alert('Registro excluido com sucesso!');
                            window.location.href ='index.php';
                            </script>");
                        }
                    }elseif(is_array($resposta))
                    {
                        echo("<script>
                            alert('".$resposta['message']."');
                            window.history.back();
                            </script>");
                    }
                }

                elseif($action == 'EDITAR')
                {
                    $idContato = $_GET['id'];    

                    $dados = editarContato($idContato);

                    //ativa a utilizaçao de variaveis de sessao no servidor
                    session_start(); 

                    //guarda em variavel de sessao os dados que o BD retornou para a busca do id
                      //OBS(essa variavel de sessao sera utilizada na idex, para colocar os dados na caixa de texto)
                    $_SESSION['dadosContato'] = $dados;

                    //usando o require iremos apenas importar a tela index, assim nao havendo um novo carregamento da pagina
                    require_once('index.php');
                }
                elseif($action ==   'ATUALIZAR')
                {

                    //recebe o id que foi encaminhado no action do form pela url
                    $idContato = $_GET['id'];

                    //recebe nome da fotp que foi enviada pelo get do form
                    $foto = $_GET['foto'];

                    //craindo um array contendo o id e o nome da foto para enviar a controller
                    $arrayDados = array(
                        "id" => $idContato,
                        "foto" => $foto,
                        "file" => $_FILES
                    );

                    
                    //chama a funcao de editar na controller
                    $resposta = atualizarContato($_POST, $arrayDados);
                    //valida o tipo de dados que a controller retornou
                    if(is_bool($resposta))//se for booleano
                    { 

                        //verifica se o retorno foi verdadeiro
                        if($resposta)
                            echo("<script>
                            alert('Registro Inserido com sucesso!');
                            window.location.href = 'index.php';
                            </script>");
                    //se o retorno for um array significa erro no processo de inserção
                    }elseif(is_array($resposta)){
                        echo("<script>
                        alert('".$resposta['message']."');
                        window.history.back();
                        </script>");
                    }
                }
            
            break;
        }


    }

?>