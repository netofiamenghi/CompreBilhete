<?php

require_once './../gerenciador/util/conexao.php';

$bilhete = $_GET['bilhete'];

$sql = "select * from bilhetes where numero = $bilhete";
$resultado = mysqli_query($conexao, $sql);
$resposta = "";
if (mysqli_num_rows($resultado) > 0) :
    $dados = mysqli_fetch_array($resultado);
    if ($dados['status'] == 1) :
        $sql = "update bilhetes set status = '2', data_hora_status = now() where numero = '$bilhete'";
        mysqli_query($conexao, $sql);
        $resposta = "$bilhete - Entrada permitida!";
    else :
        $resposta = "$bilhete - Já entrou!";
    endif;
else :
    $resposta = "$bilhete - Não encontrado!";
endif;

$retorno = array("resposta" => $resposta);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
echo json_encode($retorno);
