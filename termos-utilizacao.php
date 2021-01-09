<?php

if (!isset($_SESSION)) :
    session_start();
endif;

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

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
</head>

<body>
    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>

    <div class="container container-cadastro">
        <div class="row">
            <div class="col-md-12 linha_cabecalho">
            </div>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="inicio">Página Inicial</a></li>
            <li class="breadcrumb-item active">Termos de Uso</li>
        </ol>
        <div class="card">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Termos de Uso</li>
                </ul>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="col-lg-12">
                        <ul class="list-group">
                            <li class="list-group-item bg-light text-justify">1 - A finalização da compra dos ingressos está sujeita à aprovação da administradora do boleto/cartão de crédito.</li>
                            <li class="list-group-item text-justify">2 - Verifique a classificação etária do evento/espetáculo antes da aquisição. O promotor do evento poderá exigir a apresentação de documento comprobatório no acesso.</li>
                            <li class="list-group-item bg-light text-justify">3 - O cliente é o único responsável por averiguar os dados do pedido (evento, data do evento, cidade de realização, setor, preço, horários, classificação etária) antes da finalização da compra.</li>
                            <li class="list-group-item text-justify">4 - A solicitação de cancelamento poderá ser efetuada no prazo de 07 dias a partir da data de confirmação do pedido, limitado ao prazo máximo de até 48h (quarenta e oito horas) antes do horário de abertura dos portões do respectivo evento.</li>
                            <li class="list-group-item bg-light text-justify">5 - Os pedidos de compra estão condicionados à confirmação do pagamento. O usuário declara conhecer e aceitar que as informações solicitadas sejam utilizadas para confirmar a veracidade dos dados do comprador e aprovação do crédito.</li>
                            <li class="list-group-item text-justify">6 - Após a conclusão da compra, caso seja identificada qualquer inconsistência de dados junto a administradora do cartão de crédito utilizado para pagamento, o pedido poderá ser cancelado.</li>
                            <li class="list-group-item bg-light text-justify">7 - O contratante dos serviços (promotor do evento) é o único e exclusivo responsável pela realização, cancelamento e adiamento do evento/espetáculo, bem como pela eventual troca ou restituição do valor de face do ingresso.</li>
                            <li class="list-group-item text-justify">8 - Os ingressos podem ser acrescidos de taxa de serviço. Em eventual cancelamento do show, as taxas não serão ressarcidas.</li>
                            <li class="list-group-item bg-light text-justify">9 - O cliente é o único responsável em manter o cadastro atualizado (endereço físico, endereço de e-mail, telefones de contato), pois somente assim poderá receber confirmação do seu pedido, bem como demais informações importantes.</li>
                            <li class="list-group-item text-justify">10 - A empresa Compre Bilhete somente presta serviços de venda e divulgação dos eventos, não fazendo parte da producão e/ou organização dos eventos listados no site.</li>
                            <li class="list-group-item bg-light text-justify">11 - O cancelamento do pedido deve ser solicitado por e-mail no endereço atendimento@comprebilhete.com.br de segunda à sexta-feira das 08:00 às 18:00 horas. Solicitações enviadas fora destas datas e horários serão processadas no próximo dia útil (desde que dentro do prazo de 48h do evento).</li>
                            <li class="list-group-item text-justify">12 - Para cancelamento devem ser informados nome completo, endereço de email utilizado na compra e número do pedido.</li>
                            <li class="list-group-item bg-light text-center">Dúvidas? Entre em contato: <a class="link-azul" href="mailto:atendimento@comprebilhete.com.br">atendimento@comprebilhete.com.br</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- rodape -->
    <?php include 'rodape.php' ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
</body>

</html>