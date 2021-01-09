<?php

if (!isset($_SESSION)) :
    session_start(); 
endif;

if (!isset($_SESSION['visitante'])) :
    if (isset($_GET['pedido'])) :
        $_SESSION['rota'] = 'detalhes';
        $_SESSION['detalhes'] = $_GET['pedido'];
    endif;
    header('Location: ../entrar');
endif;

include_once('./src/includes.php');

$id_visitante = $_SESSION['idVisitante'];
$id_pedido = $_GET['pedido'];
$sql = "select * from pedido where id = $id_pedido and visitante_id = $id_visitante";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);

if ($dados['id'] == null) :
    header('Location: ../inicio');
endif;

$id_pedido = $dados['id'];
$data = $dados['data'];
$taxa = $dados['taxa_total'];
$total = $dados['total'];
$status = $dados['status'];

$_SESSION['pedido'] = $id_pedido;

$idCSS = random_int(1, 9999);

?>

<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <title>Compre Bilhete - Seu evento começa aqui!!!</title>
    <link rel="shortcut icon" href="../img/Logo.png">

    <link rel="stylesheet" href="../css/linearicons.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/themify-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/nice-select.css">
    <link rel="stylesheet" href="../css/nouislider.min.css">
    <link rel="stylesheet" href="../css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="../css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/main.css">
    <link href="../css/estilo.css?id=<?= $idCSS ?>" rel="stylesheet" type="text/css" />

    <!-- ícones bootstrap 4 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>

<body>
    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>

    <div class="container container-pedido-detalhes">
        <div class="row">
            <div class="col-md-12 linha_cabecalho">
            </div>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="../inicio">Página Inicial</a></li>
            <li class="breadcrumb-item"><a class="link-azul" href="../pedidos">Meus Pedidos</a></li>
            <li class="breadcrumb-item active">Detalhes do Pedido</li>
        </ol>
        <div class="card">
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
                        echo "<a class='link-azul' target='_blank' href='../imprimir'><i class='fas fa-save'></i> Salvar Bilhetes</a>";
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

    <!-- rodape -->
    <?php include 'rodape.php' ?>

    <!-- Optional JavaScript -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <script src="../js/jquery.ajaxchimp.min.js"></script>
    <script src="../js/jquery.nice-select.min.js"></script>
    <script src="../js/jquery.sticky.js"></script>
    <script src="../js/nouislider.min.js"></script>
    <script src="../js/countdown.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>