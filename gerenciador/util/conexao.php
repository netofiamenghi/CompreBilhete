<?php
global $conexao;

$producao = true;

if ($producao == false) :
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $db_name = "comprebilhete";
else : 
    $servername = "localhost";
    $username = "plugas91_plugasi";
    $password = "Swxaqz33";
    $db_name = "plugas91_comprebilhete";
endif;

$conexao = mysqli_connect($servername, $username, $password, $db_name);

if (mysqli_connect_error()) :
    echo "Falha na conexão com o banco de dados: " . mysqli_connect_error();
endif;