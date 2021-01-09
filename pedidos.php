<?php

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['visitante'])) :
    header('Location: inicio');
endif;

include_once('./src/includes.php');

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
    <link rel="shortcut icon" href="img/Logo.png">

    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="css/estilo.css?id=<?= $idCSS ?>" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>

<body>
    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>

    <div class="container container-pedidos">
        <div class="row">
            <div class="col-md-12 linha_cabecalho">
            </div>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="inicio">Página Inicial</a></li>
            <li class="breadcrumb-item active">Meus Pedidos</li>
        </ol>
        <div class="card">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Meus Pedidos</li>
                </ul>
            </div>
            <div class="card-body">
                <center>
                    <div class="table-responsive">
                        <table class="table table-striped w-auto">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col"></th>
                                    <th class="text-center" scope="col">Pedido</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Data</th>
                                    <th class="text-center" scope="col">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id_visitante = $_SESSION['idVisitante'];
                                $sql = "select * from pedido where status <> 0 and visitante_id = $id_visitante order by id desc ";
                                $resultado = mysqli_query($conexao, $sql);
                                mysqli_close($conexao);
                                $qtd = 0;
                                while ($dados = mysqli_fetch_array($resultado)) :
                                    $qtd++;
                                    $id = $dados['id'];
                                    $data = $dados['data'];
                                    $tipoPagto = $dados['tipo_pagto'];
                                    $total = $dados['total'];
                                    $status = $dados['status'];
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <a class="link-azul" href="detalhes/<?= $id ?>">
                                                <i class='fas fa-envelope-open-text'></i> Abrir
                                            </a>
                                        </td>
                                        <td class="text-center" scope="row"><?= $id ?></td>
                                        <td class="text-center">
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

                                        </td>
                                        <td class="text-center"><?= date('d/m/Y', strtotime($data)) ?></td>
                                        <td class="text-center">R$ <?= number_format($total, 2, ',', '.') ?></td>
                                    </tr>
                                <?php
                                endwhile;

                                if ($qtd < 1) :
                                    echo "<tr><td colspan='6' class='text-center alert alert-danger'>Sem pedidos :(</td></tr>";
                                endif;
                                ?>

                            </tbody>
                        </table>
                        <hr>
                    </div>
                </center>
            </div>
        </div>
    </div>

    <!-- rodape -->
    <?php include 'rodape.php' ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>