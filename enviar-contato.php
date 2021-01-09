<?php
require_once './recaptcha/Config.php';
require_once './recaptcha/Captcha.php';
require_once './gerenciador/util/funcoes.php';
require_once './src/Contato.php';
require_once './src/Email.php';

$idCSS = random_int(1, 9999);

if (!isset($_SESSION)) :
    session_start();
endif;

if (isset($_POST['nome'])) :

    $ObjCaptcha = new Captcha();
    $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']);

    if ($Retorno->success == false && $Retorno->score < 0.9) {
        header("Location: inicio");
    }

    $contato = new Contato();
    $contato->nome = clear($_POST['nome']);
    $contato->email = clear($_POST['email']);
    $contato->telefone = clear($_POST['telefone']);
    $contato->cidade = clear($_POST['cidade']);
    $contato->texto = clear($_POST['texto']);

    $contato->inserir();

    $mensagem .= "<b>Nome:</b> $contato->nome<br>";
    $mensagem .= "<b>Email:</b> $contato->email<br>";
    $mensagem .= "<b>Telefone:</b> $contato->telefone<br>";
    $mensagem .= "<b>Cidade:</b> $contato->cidade<br>";
    $mensagem .= "<b>Mensagem:</b> $contato->texto";

    if (Email::enviarEmail("atendimento@comprebilhete.com.br", "Contato - Compre Bilhete", $mensagem)) :
        $resposta = "<h4 class='alert alert-success text-center'>Mensagem Enviada!</h4>";
    else :
        $resposta = "<h4 class='alert alert-danger text-center'>Erro ao enviar mensagem!</h4>";
    endif;
endif;
?>

<!DOCTYPE html>
<html lang="pt-br" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <!-- CSS ============================================= -->

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<body>

    <!-- cabeçalho -->
    <?php include 'cabecalho.php' ?>

    <div class="container container-contato">
        <div class="row">
            <div class="col-md-12 linha_cabecalho">
            </div>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="inicio">Página Inicial</a></li>
            <li class="breadcrumb-item active">Contato</li>
        </ol>
        <div class="card">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Entre em contato</li>
                </ul>
            </div>
            <div class="card-body">
                <div class="col-md-3">
                    <?= $resposta ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="col-lg-12 col-md-12 card coluna_endereco">
                            <h5 class="h5">Compre Bilhete</h5>
                            <p><i class="fas fa-home"></i> Fernandópolis/SP</p>
                            <h5 class="h5">Horário de atendimento</h5>
                            <p><i class="fas fa-clock"></i> Seg-Sex das 8:00 às 18:00</p>
                            <h5 class="h5">Suporte</h5>
                            <p>
                                <i class="fas fa-envelope"></i>
                                <a class="link-azul" href="mailto:atendimento@comprebilhete.com.br">
                                    atendimento@comprebilhete.com.br
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-header">
                            <ul class="list-group text-center">
                                <li class="list-group-item list-group-item-warning text-warning bg-dark h6">
                                    Envie uma mensagem
                                </li>
                            </ul>
                        </div>
                        <form method="POST" action="contato">
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                            <input placeholder="Nome Completo *" type="text" class="form-control" id="nome" name="nome" required><br>
                            <input placeholder="E-mail *" type="email" class="form-control" id="email" name="email" required><br>
                            <input placeholder="Celular *" type="text" class="form-control" id="telefone" name="telefone" data-mask="(99) 99999-9999" required><br>
                            <input placeholder="Cidade *" type="text" class="form-control" id="cidade" name="cidade" required><br>
                            <textarea placeholder="Mensagem *" type="text" class="form-control" id="texto" name="texto" rows="5" required></textarea>
                            <div class="row">
                                <div class="col-12 text-right text-primary">
                                    <em>* Campos obrigatórios.</em>
                                </div>
                            </div>
                            <br>
                            <input class="btn btn-success col-md-12" type="submit" name="btnenviar" value="Enviar" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rodape -->
    <?php include 'rodape.php' ?>

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
    <!-- jquery.inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= FRONT_END_KEY ?>"></script>
    <script src="recaptcha/recaptcha.js"></script>
</body>

</html>