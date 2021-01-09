<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

$id = clear($_GET['id']);
$evento_id = clear($_GET['evento_id']);
$sql = "delete from evento_setor where id = '$id'";
if (mysqli_query($conexao, $sql)):
    header("Location: incluir-evento-setor.php?id=$evento_id");
else:
    echo "Erro ao excluir Evento-setor: " . mysqli_error($conexao);
endif;