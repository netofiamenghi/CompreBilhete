<?php
require_once './gerenciador/util/conexao.php';

if (!isset($_SESSION)) :
    session_start();
endif;

// pegando valores do formulário
$x = 0;
$a = 0;
while ($x <= $_POST['qtd']) :
    if ($_POST["qtd$x"] > 0) :
        $bilhetes['id_evento_setor'][$a] = $_POST["id_evento_setor$x"];
        $bilhetes['qtd_ingresso'][$a] = $_POST["qtd$x"];

        $sql = "select es.*, e.descricao from evento_setor es, evento e "
            . "where es.evento_id = e.id and es.id = {$_POST["id_evento_setor$x"]}";
        $resultado = mysqli_query($conexao, $sql);
        $dados = mysqli_fetch_array($resultado);

        $bilhetes['descricao_evento'][$a] = $dados['descricao'];
        $bilhetes['valor_unitario'][$a] = $dados['valor'];
        $bilhetes['tipo_entrada'][$a] = $dados['tipo'];
        $bilhetes['taxa_unitario'][$a] = $dados['taxa'];

        $bilhetes['sub_total'][$a] = $bilhetes['valor_unitario'][$a] * $bilhetes['qtd_ingresso'][$a];
        $a++;
    endif;
    $x++;
endwhile;

if (!isset($_SESSION['posicao'])) :
    $_SESSION['posicao'] = 0;
endif;

$p = $_SESSION['posicao'];

// se bilhetes cheio
if (!empty($bilhetes)) :
    // passo por todos os bilhetes
    for ($i = 0; $i < sizeof($bilhetes['id_evento_setor']); $i++) :
        $incluir = true;
        // passo por todos o carrinho
        for ($y = 0; $y < sizeof($_SESSION['carrinho']['id_evento_setor']); $y++) :

            if ($_SESSION['carrinho']['id_evento_setor'][$y] == $bilhetes['id_evento_setor'][$i]) :
                $_SESSION['carrinho']['qtd_ingresso'][$y] += $bilhetes['qtd_ingresso'][$i];
                $_SESSION['carrinho']['sub_total'][$y] = $_SESSION['carrinho']['valor_unitario'][$y] * $_SESSION['carrinho']['qtd_ingresso'][$y];
                $incluir = false;
            endif;
        endfor;
        if ($incluir) :
            $_SESSION['carrinho']['id_evento_setor'][$p] =  $bilhetes['id_evento_setor'][$i];
            $_SESSION['carrinho']['descricao_evento'][$p] = $bilhetes['descricao_evento'][$i];
            $_SESSION['carrinho']['tipo_entrada'][$p] = $bilhetes['tipo_entrada'][$i];
            $_SESSION['carrinho']['qtd_ingresso'][$p] = $bilhetes['qtd_ingresso'][$i];
            $_SESSION['carrinho']['valor_unitario'][$p] = $bilhetes['valor_unitario'][$i];
            $_SESSION['carrinho']['taxa_unitario'][$p] = $bilhetes['taxa_unitario'][$i];
            $_SESSION['carrinho']['sub_total'][$p] = $bilhetes['valor_unitario'][$i] * $bilhetes['qtd_ingresso'][$i];
            $p++;
        endif;
    endfor;
    $_SESSION['posicao'] = $p;
    unset($bilhetes);
endif;

header('Location: carrinho');