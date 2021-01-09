<?php
require_once './gerenciador/util/conexao.php';
require_once './gerenciador/util/funcoes.php';
require_once './src/Conexao.php';

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
    <link rel="shortcut icon" href="img/Logo.png">
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
    <!--CSS============================================= -->
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
    <link href="css/estilo.css?id=<?=$idCSS?>" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>

    <!-- start banner Area -->
    <div class="container">
        <div id="banner" class="row">
            <div class="col-lg-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <?php
                        $sql = "select id, descricao, capa from evento where data >= now() order by rand() limit 3";
                        $resultado = mysqli_query($conexao, $sql);
                        $posicao = 1;
                        while ($dados = mysqli_fetch_array($resultado)) :
                            $id = $dados['id'];
                            $descricao = $dados['descricao'];
                            $capa = $dados['capa'];
                            echo $posicao == 1 ? "<div class='carousel-item active'>" : "<div class='carousel-item'>";
                            ?>
                            <a href="evento/<?= $id ?>">
                                <img id="imgcarousel" class="d-block w-100" src="img/eventos-capa/<?= $capa ?>" alt="<?= $descricao ?>">
                            </a>
                    </div>
                <?php
                    $posicao++;
                endwhile;
                ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    </div>
    <!-- End banner Area -->

    <!-- Grade de Produtos -->
    <div class="container">
        <br><br>
        <div class="col-lg-12 col-md-12">
            <h5 class="h5 font-weight-bold">Escolha um evento</h5>
        </div>
        <?php
        if (isset($_GET['search_input'])) :
            $pesquisa = clear($_GET['search_input']);
            $sql2 = "select id, descricao, cidade, estado, data, imagem from evento "
                . "where (descricao like '%$pesquisa%' or cidade like '%$pesquisa%') and data >= now() order by data ";
        else :
            $sql2 = "select id, descricao, cidade, estado, data, imagem from evento where data >= now() order by data";
        endif;
        $resultado2 = mysqli_query($conexao, $sql2);
        $posicao2 = 1;
        while ($dados2 = mysqli_fetch_array($resultado2)) :
            $id = $dados2['id'];
            $descricao = substr($dados2['descricao'], 0, 28); 
            $cidade = $dados2['cidade'];
            $estado = $dados2['estado'];
            $data = $dados2['data'];
            $imagem = $dados2['imagem'];
            echo $posicao2 == 1 ? "<div class='row my-4'>" : "";
            echo $posicao2 % 4 == 0 ? "<div class='row my-4'>" : "";
            ?>
            <!--Grid column-->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <a href="evento/<?= $id ?>">
                    <div class="img-thumbnail foto_item">
                        <img class="img-fluid foto_evento" src="img/eventos/<?= $imagem ?>" alt="<?= $descricao ?>" />
                        <div id="cidade_evento" class="caption">
                            <p><?= $cidade . "/" . $estado ?></p>
                        </div>
                        <div id="nome_evento" class="caption">
                            <p><?= $descricao ?></p>
                        </div>
                        <div id="data_evento" class="caption">
                            <p><?= date("d/m/Y", strtotime($data)) ?></p>
                        </div>
                        <div id="detalhe" class="caption"></div>
                    </div>
                </a>
            </div>
            <!--Grid column-->
        <?php
            echo $posicao2 % 3 == 0 ? "</div>" : "";
            $posicao2++;
        endwhile;
        if ($posicao2 <= 1) :
            echo "<h5 class='h5 alert alert-danger text-center'>Evento não encontrado :(</h5>";
        endif;
        ?>
    </div>
    </div>
    <!-- Fim Grade de Produtos -->

    <!-- Start brand Area -->
    <section class="brand-area section_gap">
        <div class="container">
            <!-- <div class="col-lg-12 col-md-12">
                <h5 class="h5 font-weight-bold">Parceiros</h5>
            </div> -->
            <hr>
            <div class="row d-flex justify-content-center">
                <?php
                $sql3 = "select * from parceiro where status = 'A' order by rand() limit 4";
                $resultado3 = mysqli_query($conexao, $sql3);
                mysqli_close($conexao);
                while ($dados3 = mysqli_fetch_array($resultado3)) :
                    $imagem3 = $dados3['imagem'];
                    $complemento3 = $dados3['complemento'];
                    $nomeFantasia3 = $dados3['nomefantasia'];
                    ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-3">
                        <a target="_blank" href="<?= $complemento3 ?>" class="col single-img" title="<?= $nomeFantasia3 ?>">
                            <img class="img-parceiros img-fluid d-block mx-auto" src="img/parceiros/<?= $imagem3 ?>" alt="Instagram">
                        </a>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
        </div>
    </section>
    <!-- End brand Area -->


    <!-- rodape -->
    <?php include 'rodape.php'; ?> 

    <script src="js/funcoes.js" type="text/javascript"></script>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
    <!-- segurança Mercado Pago -->
    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>

</body> 

</html> 