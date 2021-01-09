<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

$id = clear($_GET['id']);
$evento_id = clear($_GET['evento_id']);
$sql = "delete from evento_pontovenda where id = '$id'";
if (mysqli_query($conexao, $sql)):
    header("Location: incluir-evento-ponto-venda.php?id=$evento_id");
else:
    echo "Erro ao excluir Evento-ponto-venda: " . mysqli_error($conexao);
endif;