<?php
require_once '../../src/Conexao.php';
require_once '../../src/Funcoes.php';

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['admin'])) :
    header('Location: index.php');
endif;

$id_pedido = $_GET['pedido'];
$cpf = $_GET['cpf'];
$sql = "select * from pedido where id = '$id_pedido'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);

$id_pedido = $dados['id'];
$data = $dados['data'];
$taxa = $dados['taxa_total'];
$total = $dados['total'];
$status = $dados['status'];


?>
<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Compre Bilhete - Os melhores eventos aqui!!!</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <br>
        <a class="btn btn-secondary" href="listar-pedido.php?pedido=<?= $cpf ?>">Voltar</a>
        <br><br>
        <div class="card-body">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Detalhes do Pedido nº <?= $id_pedido ?></li>
                    <li class="list-group-item">Data da Compra: <span class="h6"><?= date('d/m/Y', strtotime($data)) ?></span></li>
                    <li class="list-group-item">SubTotal: <span class="h6">R$ <?= number_format($total - $taxa, 2, ',', '.') ?></span></li>
                    <li class="list-group-item">Taxas: <span class="h6">R$ <?= number_format($taxa, 2, ',', '.') ?></span></li>
                    <li class="list-group-item text-success h5">Total: R$ <?= number_format($total, 2, ',', '.') ?></li>
                    <li class="list-group-item">Status: <span class="h5">
                            <?php
                            switch ($status):
                                case 1:
                                    echo 'Pagamento não Finalizado';
                                    break;
                                case 2:
                                    echo 'Aprovado';
                                    break;
                                case 3:
                                    echo 'Em Análise';
                                    break;
                                case 4:
                                    echo 'Pagamento Recusado';
                                    break;
                                case 5:
                                    echo 'Cancelado ou Expirou';
                                    break;
                                case 6:
                                    echo 'Pagamento Devolvido';
                                    break;
                                case 7:
                                    echo 'Aguardando Pgto Boleto Bancário';
                                    break;
                                default:
                                    echo 'Status inválido';
                            endswitch;
                            ?>
                        </span></li>
                    <?php

                    if ($status == 2) :
                        echo "<li class='list-group-item h5'>";
                        echo "<a class='link-azul' target='_blank' href='../../imprimir'><i class='fas fa-save'></i> Salvar Bilhetes</a>";
                        echo "</li>";
                    elseif ($status == 1 or $status == 3) :
                        echo "<li class='list-group-item h5 text-warning bg-dark'>";
                        echo "Após a confirmação do pagamento você poderá realizar a impressão do(s) bilhete(s).";
                        echo "</li>";
                    endif;

                    ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="list-group text-center">
                            <?php
                            $sql2 = "select ip.id, ip.valor_unitario, ip.taxa_unitario, ip.quantidade, es.tipo, e.descricao, s.descricao as setor " .
                                "from itens_pedido ip, evento_setor es, evento e, setor s " .
                                "where s.id = es.setor_id and e.id = es.evento_id and ip.evento_setor_id = es.id and ip.pedido_id = $id_pedido";
                            $resultado = mysqli_query($conexao, $sql2);
                            mysqli_close($conexao);
                            while ($dados = mysqli_fetch_array($resultado)) :
                                $id = $dados['id'];
                                $tipo = $dados['tipo'];
                                $descricao = $dados['descricao'];
                                $setor = $dados['setor'];
                                $quantidade = $dados['quantidade'];
                                $valorUnitario = $dados['valor_unitario'];
                                $taxaUnitario = $dados['taxa_unitario'];
                                $y = 1;
                                while ($y <= $quantidade) :
                            ?>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div>
                                            <h5 class="mb-1">Bilhete <?= $id_pedido .  $id .  $y ?> - <?= $descricao ?></h5>
                                        </div>
                                        <div>Setor: <?= $setor ?> - Tipo: <?= $tipo ?></div>
                                        <div>Valor: R$ <?= number_format($valorUnitario, 2, ',', '.') ?> - Taxa: R$ <?= number_format($taxaUnitario, 2, ',', '.') ?></div>
                                    </a>
                            <?php
                                    $y++;
                                endwhile;
                            endwhile;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>

</html>