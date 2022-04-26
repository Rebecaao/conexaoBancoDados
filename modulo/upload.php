<?php

//criando funcao para re
function uploadFile($arrayFile)
{

    //import do arquivo
    require_once("modulo/config.php");

    $arquivo = $arrayFile;
    $sizeFile = (int) 0;
    $typeFile = (string) null;
    $nameFile = (string) null;
    $tempFile = (string) null;

    //validacao para identificar se existe um arquivo valido maior que 0 e que tenha uma extensao
    if($arquivo['size'] > 0 && $arquivo['type'] != "")
    {

        //recupera o tamanho do arquivo que é em bytes e converte para kb (/1024)
        $sizeFile = $arquivo['size']/1024;

        //recupera o tipo do arquivo (extensoes)
        $typeFile = $arquivo['type'];

        //recupera o nome do arquivo 
        $nameFile = $arquivo['name'];

        //recupera o caminho do diretorio temporario que esta o arquivo
        $tempFile = $arquivo['tmp_name'];

        //validacao para permitir upload apenas de arquivos de no maximo 5mb
        if($sizeFile <= MAX_FILE_UPLOAD)
        {
            if(in_array($typeFile, EXT_FILE_UPLOAD))
            {
                //separa somente o nome do arquivo sem a sua extensao
                $nome = pathinfo($nameFile, PATHINFO_FILENAME);

                //separa somente a extensao do arquivo sem o nome
                $extensao = pathinfo($nameFile, PATHINFO_EXTENSION);

                //existem diversos algoritimos para criptografia dedados
                    //md5()
                    //sha1()
                    //hash()

                //md5() gerando uma criptografia de dados
                //uniqid gerando uma sequencia numerica diferente tendo como base, configuracoes da maquina
                //time() pega a hora, minuto, e segundo que está sendo feito o upload da foto
                $nomeCripty = md5($nome . uniqid(time()));


                //montando novamente o nome do arquivo com a extensao
                $foto = $nomeCripty.".".$extensao;

                //envia o arquivo da pasta temporaria do apache para a pasta criada no projeto
                if (move_uploaded_file($tempFile, DIRETORIO_FILE_UPLOAD.$foto))
                {
                    return $foto;
                }else{
                    return array('idErro' => 13,
                      'message' => 'Não foi possivel mover o arquivo para o servidor.'); 
                }




            }else{
                return array('idErro' => 12,
                      'message' => 'Extensão do arquivo selecionado não é permitida no upload.'); 
            }

        }else{
            return array('idErro' => 10,
                      'message' => 'Tamanho de arquivo invalido no upload.'); 
        }

    }else{
        return array('idErro' => 11,
        'message' => 'Não é possivel realizar um upload sem um arquivo selecionado.'); 
    }

}

?>