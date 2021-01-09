<?php
require_once './gerenciador/util/conexao.php';
require_once './gerenciador/util/funcoes.php';

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
    <!--CSS ============================================= -->
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
    <link href="css/estilo.css?id=<?=$idCSS?>" rel="stylesheet" type="text/css" />

    <script>
        /**
         * Função para criar um objeto XMLHTTPRequest
         */
        function CriaRequest() {
            try {
                request = new XMLHttpRequest();
            } catch (IEAtual) {

                try {
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (IEAntigo) {

                    try {
                        request = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (falha) {
                        request = false;
                    }
                }
            }

            if (!request)
                alert("Seu Navegador não suporta Ajax!");
            else
                return request;
        }

        /**
         * Função para enviar os dados
         */
        function atualizar(op, ind) {
            // Declaração de Variáveis
            var result = document.getElementById("Resultado");
            var xmlreq = CriaRequest();
            // Iniciar uma requisição
            xmlreq.open("GET", "atualizar-carrinho.php?op=" + op + "&ind=" + ind, true);
            // Atribui uma função para ser executada sempre que houver uma mudança de ado
            xmlreq.onreadystatechange = function() {
                // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
                if (xmlreq.readyState === 4) {
                    // Verifica se o arquivo foi encontrado com sucesso
                    if (xmlreq.status === 200) {
                        result.innerHTML = xmlreq.responseText;
                    } else {
                        result.innerHTML = "Erro: " + xmlreq.statusText;
                    }
                }
            };
            xmlreq.send(null);
        }
    </script>
</head>

<body onload="atualizar('carregar',0)">

    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>
    <div class="container container-carrinho">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="inicio">Página Inicial</a></li>
            <li class="breadcrumb-item active">Carrinho de Compras</li>
        </ol>
        <div class="card text-center">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Carrinho de Compras</li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-lg-12">
                        <div id="Resultado"></div>
                        <br>
                        <div class="col-md-2"></div>
                    </div>
                    <br />
                    <br><br><br>
                </div>

                <div class="card-footer text-muted">

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
</body>

</html>