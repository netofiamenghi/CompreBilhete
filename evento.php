<?php

require_once './gerenciador/util/conexao.php';

if (!isset($_SESSION)) :
    session_start();
endif;

$idCSS = random_int(1, 9999);

?>

<!DOCTYPE html>
<html lang="pt-br" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="../img/Logo.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Compre Bilhete - Seu evento começa aqui!!!</title>
    <!-- CSS ============================================= -->
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

    <script>
        function atualizarQtd(operacao, indice) {
            var qtd = document.getElementById('qtd' + indice).value;
            if (operacao === '-' && qtd > 0) {
                qtd--;
            } else if (operacao !== '-' && qtd < 5) {
                qtd++;
            }
            document.getElementById('qtd' + indice).value = qtd;
        }
    </script>
</head>

<body>
    <!-- cabecalho -->

    <?php include 'cabecalho.php' ?>

    <?php
    $id = $_GET['id'];
    $sql = "select id, descricao, capa, data, cidade, estado, informacoes, abertura, inicio, local "
        . "from evento where id = $id";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $descricao = $dados['descricao'];
    $capa = $dados['capa'];
    $data = $dados['data'];
    $cidade = $dados['cidade'];
    $estado = $dados['estado'];
    $informacoes = $dados['informacoes'];
    $abertura = $dados['abertura'];
    $inicio = $dados['inicio'];
    $local = $dados['local'];
    ?>
    <div class="capa_evento col-md-12">
        <img class="img-fluid foto_cp_evento" src="../img/eventos-capa/<?= $capa ?>" alt="Imagem <?= $descricao ?>" />
    </div>
    <br>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="../inicio">Página Inicial</a></li>
            <li class="breadcrumb-item active">Evento</li>
        </ol>
        <div class="card text-center">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h6"><?= $descricao ?><br>
                        <i class="fa fa-calendar"></i>&nbsp;<?= date("d/m/Y", strtotime($data)) ?>
                        &nbsp;&nbsp;
                        <i class="fa fa-map-marker"></i>&nbsp;<?php echo "$cidade - $estado" ?>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="../inserir-carrinho" method="POST">
                    <?php
                    $sql2 = "select distinct s.id, s.descricao from evento_setor es, setor s, evento e "
                        . "where s.id = es.setor_id and e.id = es.evento_id and e.id = $id";
                    $resultado2 = mysqli_query($conexao, $sql2);
                    $x = 0;
                    while ($dados2 = mysqli_fetch_array($resultado2)) :
                        $descricao = $dados2['descricao'];
                        $setor_id = $dados2['id'];
                    ?>
                        <div class="row">
                            <div class="col-3 col-md-2">
                            </div>
                            <div class="col-lg-8">
                                <div class="tabela_preco">
                                    <div class="nome_tabela_preco text-center"><?= $descricao ?></div>
                                    <?php
                                    $sql3 = "select es.* from evento_setor es, setor s, evento e "
                                        . "where s.id = es.setor_id and e.id = es.evento_id and e.id = $id and s.id = $setor_id";
                                    $resultado3 = mysqli_query($conexao, $sql3);
                                    while ($dados3 = mysqli_fetch_array($resultado3)) :

                                        $id_evento_setor = $dados3['id'];
                                        $tipo = $dados3['tipo'];
                                        $valor = $dados3['valor'];
                                        $taxa = $dados3['taxa'];
                                    ?>
                                        <div class="row">
                                            <!-- col-md-12 col-lg-12 -->
                                            <input type="hidden" name="id_evento_setor<?= $x ?>" value="<?= $id_evento_setor ?>" />
                                            <div class="col-md-4 text-center"><?= $tipo ?></div>
                                            <div class="col-md-4 text-center"><?= " R$ " . number_format($valor, 2, ',', '.') . " + R$ " . number_format($taxa, 2, ',', '.') ?> de taxas</div>
                                            <div class="col-md-4 text-center">
                                                <input type='button' value='-' onclick='atualizarQtd(this.value,<?= $x ?>)' />
                                                <input type="text" id='qtd<?= $x ?>' name='qtd<?= $x ?>' value="0" size="1" readonly />
                                                <input type='button' value='+' onclick='atualizarQtd(this.value,<?= $x ?>)' />
                                            </div>
                                        </div>
                                        <div class="row">&nbsp;</div>
                                    <?php
                                        $x++;
                                    endwhile;
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-2">
                            </div> -->
                        </div>
                    <?php
                    endwhile;
                    ?>
                    <input type="hidden" name="qtd" value="<?= $x ?>" />
                    <button class="btn btn-success" type="submit"><i class="fa fa-cart-plus"></i> Comprar</button>
                </form>
                <br>
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning text-dark bg-light h5">
                        INFORMAÇÕES IMPORTANTES
                    </li>
                </ul>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-12">
                        <div class="card" style="margin: 0 auto">
                            <div class="card-body">

                                <h6 class="h6 card-subtitle mb-2 text-dark">Local: <?= $local ?></h6>
                                <?php
                                if ($abertura != "00:00:00") :
                                ?>
                                    <h6 class="h6 card-subtitle mb-2 text-dark">Horário de abertura: <?= $abertura ?></h6>
                                <?php
                                endif;
                                ?>

                                <?php
                                if ($inicio != "00:00:00") :
                                ?>
                                    <h6 class="h6 card-subtitle mb-2 text-dark">Horário de início: <?= $inicio ?></h6>
                                <?php
                                endif;
                                ?>
                                
                                <p id="informacoes"><?= $informacoes ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <br>
                <?php
                $sql2 = "select * from pontovenda p, evento_pontovenda ep "
                    . "where p.id = ep.pontovenda_id and ep.evento_id = $id";
                $resultado2 = mysqli_query($conexao, $sql2);
                if (mysqli_num_rows($resultado2) > 0) :
                ?>

                    <h5 class="h5">PONTOS DE VENDA FÍSICOS</h5>
                    <div class="row">
                        <?php
                        $posicao = 1;
                        while ($dados2 = mysqli_fetch_array($resultado2)) :
                            $nome = $dados2['nome'];
                            $telefone = $dados2['telefone'];
                            $cidade2 = $dados2['cidade'];
                            $estado2 = $dados2['estado'];
                            $email = $dados2['email'];
                            $logradouro2 = $dados2['logradouro'];
                            $numero2 = $dados2['numero'];
                        ?>

                            <div class="col-md-3">
                                <div class="card" style="margin: 0 auto">
                                    <div class="card-body">
                                        <h5 class="h5 card-title"><?= $nome ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Telefone: <?= $telefone ?></h6>
                                        <h6 class="card-text text-muted"><?php echo "$logradouro2, $numero2" ?></h6>
                                        <h6 class="card-text text-muted"><?php echo "$cidade2/$estado2" ?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $posicao++;
                        endwhile;
                        ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <ul class="list-group text-center">
                <li class="list-group-item list-group-item-warning text-dark bg-light h6">
                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<?= date("d/m/Y", strtotime($data)) ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <i class="fa fa-map-marker "></i>&nbsp;&nbsp;<?php echo "$cidade - $estado" ?>
                </li>
            </ul>
        </div>
    </div>
    <br>

    <!-- rodape -->
    <?php include 'rodape.php' ?>

    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <script src="../js/jquery.ajaxchimp.min.js"></script>
    <script src="../js/jquery.nice-select.min.js"></script>
    <script src="../js/jquery.sticky.js"></script>
    <script src="../js/nouislider.min.js"></script>
    <script src="../js/countdown.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <!--gmaps Js-->
    <script src="../js/main.js"></script>
</body>

</html>