<?php

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['visitante'])) :
    header('Location: inicio');
endif;

if (sizeof($_SESSION['carrinho']['id_evento_setor']) < 1) :
    header('Location: inicio');
endif;

include_once('./src/includes.php');

$idCSS = random_int(1, 9999);
$idJS = random_int(1, 9999);

if (!is_null($_SESSION['idVisitante'])) :

    // INSERINDO PEDIDO
    date_default_timezone_set('America/Sao_Paulo');

    $visitante_id = $_SESSION['idVisitante'];
    $data = date('Y-m-d H:i:s');
    $total = number_format($_SESSION['totalCompra'], 2, '.', '');
    $status = 0;
    $email = 0;
    $taxaTotal = $_SESSION['totalTaxas'];

    $sql = "insert into pedido (visitante_id, data, total, status, taxa_total, email) " .
        "values('$visitante_id','$data', '$total', '$status', '$taxaTotal', '$email')";
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    $sql2 = "select MAX(id) as id FROM pedido";
    $resultado = mysqli_query($conexao, $sql2);
    $dados = mysqli_fetch_array($resultado);
    $pedido = $dados['id'];

    $_SESSION['pedido'] = $pedido;

// FIM PEDIDO

endif;



MercadoPago\SDK::setAccessToken(access_token);

$preference = new MercadoPago\Preference();

$preference->statement_descriptor = statement_descriptor;
$preference->notification_url = notification_url;
$preference->external_reference = $pedido;

$preference->back_urls = [
    'success' => success_url . '/' . $pedido,
    'pending' => pending_url . '/' . $pedido,
    "failure" => failure_url
];
$preference->auto_return = "approved";

// COMPRADOR
$payer = new MercadoPago\Payer();
$payer->name = $_SESSION['nomeVisitante'];
$payer->surname = $_SESSION['sobrenomeVisitante'];
$payer->email = $_SESSION['emailVisitante'];
$payer->phone = array(
    "area_code" => $_SESSION['codAreaVisitante'],
    "number" => $_SESSION['telefoneVisitante']
);
$payer->identification = array(
    "type" => "CPF",
    "number" => $_SESSION['cpfVisitante']
);
$payer->address = array(
    "street_name" => $_SESSION['logradouroVisitante'],
    "street_number" => $_SESSION['numeroVisitante'],
    "zip_code" => $_SESSION['cepVisitante']
);
$preference->payer = $payer;
// FIM COMPRADOR

// ITEM
$item = new MercadoPago\Item();
$item->id = "1";
$item->title = "Bilhetes - comprebilhete.com.br";
$item->description = "Compra de Bilhetes no site comprebilhete.com.br";
$item->category_id = "tickets";
$item->quantity = 1;
$item->currency_id = "BRL";
$item->unit_price = number_format($_SESSION['totalCompra'], 2, '.', '');
$preference->items = array($item);
// FIM ITEM


if($_SESSION['totalCompra'] < 75.00):

$preference->payment_methods = array(
    "excluded_payment_types" => array(
        array("id" => "ticket")
    )
);

endif;

$preference->save();

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
    <!-- CSS ============================================= -->
    <script src="js/funcoes.js" type="text/javascript"></script>
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

</head>

<body>
    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>

    <div class="container container-pagamento">
        <div class="card">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-azul" href="inicio">Página Inicial</a></li>
                <li class="breadcrumb-item"><a class="link-azul" href="carrinho">Carrinho de Compras</a></li>
                <li class="breadcrumb-item active">Pagamento</li>
            </ol>
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Resumo da Compra</li>
                </ul>
            </div>
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning text-warning bg-dark h6">
                        Atenção: Após a confirmação do pagamento você receberá um e-mail com um link para salvar o(s) bilhete(s).
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="woocommerce-billing-fields">

                            <div id="payment-methods">

                                <div class="tab-pane" id="tab-boleto" role="tabpanel">
                                    <div class="row">
                                        <h4 class="h4 text-dark">Resumo da Compra</h4>
                                    </div>
                                    <div class="row">
                                        <h5 class="h5">Bilhetes: R$ <?= number_format($_SESSION['totalCompra'] - $_SESSION['totalTaxas'], 2, ',', '.') ?></h5>
                                    </div>
                                    <div class="row">
                                        <h5 class="h5">Taxas: R$ <?= number_format($_SESSION['totalTaxas'], 2, ',', '.') ?></h5>
                                    </div>
                                    <div class="row">
                                        <h5 class="h5 text-dark">Total da Compra: R$ <?= number_format($_SESSION['totalCompra'], 2, ',', '.') ?></h5>
                                    </div>
                                    <br>
                                </div>

                                <form action="detalhes/<?= $pedido ?>" method="POST">
                                    <script src="js/mercado-pago.js" data-preference-id="<?php echo $preference->id; ?>">
                                    </script>
                                </form>
                                <hr>
                                <center>
                                    <img class="img-responsive col-md-8" src="./img/mercado-pago.png" alt="Selo Mercado Pago Compra Segura" />
                                </center>
                                <br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!-- rodape -->
    <?php include 'rodape.php' ?>
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
    <script src="https://www.mercadopago.com/v2/security.js" view=""></script>
</body>

</html>