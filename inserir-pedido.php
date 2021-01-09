<?php

if (!isset($_SESSION)) : 
    session_start();
endif;


include_once('./src/includes.php');

$pedido = $_SESSION['pedido'];

$sql = "update pedido set status = '1' where id = '$pedido'";
mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

// ITENS PEDIDO
for ($x = 0; $x < sizeof($_SESSION['carrinho']['id_evento_setor']); $x++) :
    $evento_setor_id = (int) $_SESSION['carrinho']['id_evento_setor'][$x];
    $quantidadeVendida = (int) $_SESSION['carrinho']['qtd_ingresso'][$x];
    $valorUnitario = (float) $_SESSION['carrinho']['valor_unitario'][$x];
    $taxaUnitario = (float) $_SESSION['carrinho']['taxa_unitario'][$x];
    $sql3 = "insert into itens_pedido (pedido_id, evento_setor_id, quantidade, valor_unitario, taxa_unitario) " .
        "values('$pedido','$evento_setor_id','$quantidadeVendida', '$valorUnitario', '$taxaUnitario')";
    mysqli_query($conexao, $sql3) or die(mysqli_error($conexao) . "<pre>" . var_dump($_SESSION['carrinho']) . "</pre>");
endfor;
// FIM ITENS PEDIDO

// LIMPAR CARRINHO 
unset($_SESSION['carrinho']);
unset($_SESSION['totalTaxas']);
unset($_SESSION['totalCompra']);
unset($_SESSION['posicao']);
unset($_SESSION['pedido']);
// FIM CARRINHO