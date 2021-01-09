<?php
require_once 'conexao.php';

function clear($input)
{
    global $conexao;
    // limpar espaços
    $var = trim($input);
    // limpar sql
    $var = mysqli_escape_string($conexao, $var);
    // limpar xss (cross site scriting)
    $var = htmlspecialchars($var);
    return $var;
}

function limpaCEPCPF($input)
{
    $chars = array(".", "-");
    return str_replace($chars,"", $input);
}

function dataBR($input){
    return date('d/m/Y', strtotime($input));
}
