<?php

class Conexao
{
    public static function conectar()
    {
        try {
            // $conexao = new PDO('mysql:host=localhost;dbname=comprebilhete', 'root', 'root');
             $conexao = new PDO('mysql:host=localhost;dbname=plugas91_comprebilhete', 'plugas91_plugasi', 'Swxaqz33');
        } catch (PDOException $e) {
            print $e->getMessage();
        }
        return $conexao;
    }
}

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