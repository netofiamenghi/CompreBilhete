<?php
if (!isset($_SESSION)) :
    session_start();
endif;

$operacao = $_GET['op'];
$indice = $_GET['ind'];

if ($operacao == "-" && $_SESSION['carrinho']['qtd_ingresso'][$indice] > 1) :
    $_SESSION['carrinho']['qtd_ingresso'][$indice]--;
    $_SESSION['carrinho']['sub_total'][$indice] = ($_SESSION['carrinho']['valor_unitario'][$indice] * $_SESSION['carrinho']['qtd_ingresso'][$indice]) + ($_SESSION['carrinho']['taxa_unitario'][$indice] * $_SESSION['carrinho']['qtd_ingresso'][$indice]);
elseif ($operacao != "-" && $operacao != "excluir" && $operacao != "carregar" && $_SESSION['carrinho']['qtd_ingresso'][$indice] < 5) :
    $_SESSION['carrinho']['qtd_ingresso'][$indice]++;
    $_SESSION['carrinho']['sub_total'][$indice] = ($_SESSION['carrinho']['valor_unitario'][$indice] * $_SESSION['carrinho']['qtd_ingresso'][$indice]) + ($_SESSION['carrinho']['taxa_unitario'][$indice] * $_SESSION['carrinho']['qtd_ingresso'][$indice]);
elseif ($operacao == "excluir") :

    unset($_SESSION['carrinho']['id_evento_setor'][$indice]);
    unset($_SESSION['carrinho']['descricao_evento'][$indice]);
    unset($_SESSION['carrinho']['tipo_entrada'][$indice]);
    unset($_SESSION['carrinho']['qtd_ingresso'][$indice]);
    unset($_SESSION['carrinho']['valor_unitario'][$indice]);
    unset($_SESSION['carrinho']['taxa_unitario'][$indice]);
    unset($_SESSION['carrinho']['sub_total'][$indice]);

    $posNovo = 0;
    $carrinhoNovo = array();

    for ($i = 0; $i <= sizeof($_SESSION['carrinho']['id_evento_setor']); $i++) :

        if (isset($_SESSION['carrinho']['id_evento_setor'][$i])) :
            $carrinhoNovo['carrinho']['id_evento_setor'][$posNovo] = $_SESSION['carrinho']['id_evento_setor'][$i];
            $carrinhoNovo['carrinho']['descricao_evento'][$posNovo] = $_SESSION['carrinho']['descricao_evento'][$i];
            $carrinhoNovo['carrinho']['tipo_entrada'][$posNovo] = $_SESSION['carrinho']['tipo_entrada'][$i];
            $carrinhoNovo['carrinho']['qtd_ingresso'][$posNovo] = $_SESSION['carrinho']['qtd_ingresso'][$i];
            $carrinhoNovo['carrinho']['valor_unitario'][$posNovo] = $_SESSION['carrinho']['valor_unitario'][$i];
            $carrinhoNovo['carrinho']['taxa_unitario'][$posNovo] = $_SESSION['carrinho']['taxa_unitario'][$i];
            $carrinhoNovo['carrinho']['sub_total'][$posNovo] = $_SESSION['carrinho']['sub_total'][$i];
            $posNovo++;
        endif;
    endfor;
    $_SESSION['carrinho'] = $carrinhoNovo['carrinho'];
    $_SESSION['posicao'] = $posNovo;
endif;

$qtd = count($_SESSION['carrinho']['id_evento_setor']);

if ($qtd == 0) :
    echo "<h5 class='h5 alert alert-danger'>Sem bilhetes :(</h5>"
        . "<a href='inicio'/>"
        . "<input class='btn btn-info' type='button' value='Continuar Comprando'/>"
        . "<a/>";
else :
    $resultado = "<div class='row col-lg-12'></div>";
    $x = 0;
    $_SESSION['totalCompra'] = 0.0;
    $_SESSION['totalTaxas'] = 0.0;
    while ($qtd > 0) :
        $_SESSION['carrinho']['sub_total'][$x] = ($_SESSION['carrinho']['valor_unitario'][$x] * $_SESSION['carrinho']['qtd_ingresso'][$x]) + ($_SESSION['carrinho']['taxa_unitario'][$x] * $_SESSION['carrinho']['qtd_ingresso'][$x]);
        $resultado .= "<div class='row col-lg-12'>";
        $resultado .= "<div class='col-lg-3'><span class='detalhe-carrinho'>Bilhete - </span> {$_SESSION['carrinho']['descricao_evento'][$x]} - {$_SESSION['carrinho']['tipo_entrada'][$x]}</div>";
        $resultado .= "<div class='col-lg-2'>";
        $resultado .= "<input type = 'button' id = 'menos' value = '-' onclick = 'atualizar(this.value, " . $x . ")'/>";
        $resultado .= "<input name='qtd' id='qtd" . $x . "' value='{$_SESSION['carrinho']['qtd_ingresso'][$x]}' type='text' size='1' readonly />";
        $resultado .= "<input type = 'button' id = 'mais' value = '+' onclick = 'atualizar(this.value, " . $x . ")'/>";
        $resultado .= "</div>";
        $resultado .= "<div class='col-lg-2'><span class='detalhe-carrinho'>Vr Unit. - </span>R$ " . number_format($_SESSION['carrinho']['valor_unitario'][$x], 2, ',', '.') . "</div>";
        $resultado .= "<div class='col-lg-2'><span class='detalhe-carrinho'>Vr. Taxa - </span>R$ " . number_format($_SESSION['carrinho']['taxa_unitario'][$x], 2, ',', '.') . "</div>";
        $resultado .= "<div class='col-lg-2'><span class='detalhe-carrinho'>Subtotal - </span>R$ " . number_format($_SESSION['carrinho']['sub_total'][$x], 2, ',', '.') . "</div>";
        $resultado .= "<div class='col-lg-1'><a href = ''>";
        $resultado .= "<button class = 'btn btn-danger' value='excluir' onclick = 'atualizar(this.value," . $x . ")'><i class='fa fa-trash'></i> Excluir</button>";
        $resultado .= "</a>";
        $resultado .= "</div>";
        $resultado .= "</div><hr>";
        $_SESSION['totalTaxas'] += ($_SESSION['carrinho']['taxa_unitario'][$x] * $_SESSION['carrinho']['qtd_ingresso'][$x]);
        $_SESSION['totalCompra'] += $_SESSION['carrinho']['sub_total'][$x];
        $x++;
        $qtd--;
    endwhile;
    $resultado .= "<h5 class = 'h5 alert alert-secondary'>Total da Compra: R$ " . number_format($_SESSION['totalCompra'], 2, ',', '.') . "</h5>";
    $resultado .= "<a class='botao-comprar-carrinho' href='inicio'>";
    $resultado .= "<button class='btn btn-info btn-carrinho' type='button'><i class='fa fa-backward'></i> Continuar Comprando</button>";
    $resultado .= "<a/>";
    if (isset($_SESSION['visitante'])) :
        $resultado .= "<a href='pagamento'>";
    else :
        $_SESSION['rota'] = "carrinho";
        $resultado .= "<a href='entrar'>";
    endif;
    $resultado .= "<button class='btn btn-success btn-carrinho' type='button'><i class='fa fa-check'></i> Finalizar Compra </button>";
    $resultado .= "<a/>"; 
    echo $resultado;
endif;
