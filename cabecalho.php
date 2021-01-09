<?php
if (!isset($_SESSION)) :
    session_start();
endif;

$pagina = $_SERVER['SCRIPT_NAME'];

$posEvento = stripos($pagina, 'evento.php');
$posPedido = stripos($pagina, 'pedido-detalhes.php');

if($posEvento == true || $posPedido == true):
    $raiz = '../';
else:
    $raiz = '';
endif;

?>
<!-- Start Header Area -->
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="<?= $raiz ?>inicio">
                    <img id="logoimg" src="<?= $raiz ?>img/Logo.png" alt="">
                </a>
                <a class="navbar-brand logo_h" href="<?= $raiz ?>inicio">
                    <img id="logoescrito" src="<?= $raiz ?>img/CompreBilheteLetrasAmarelo.png" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="<?= $raiz ?>inicio">Página Inicial</a></li>
                        <li class="nav-item submenu dropdown">
                            <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php echo isset($_SESSION['nomeVisitante']) ? "Olá, {$_SESSION['nomeVisitante']} " : "Olá, visitante"; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                if (isset($_SESSION['nomeVisitante'])) :
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link' id='nav-link-sair' href='" . $raiz . "dados'>Meus Dados</a>";
                                    echo "</li>";
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link' id='nav-link-sair' href='" . $raiz . "pedidos'>Meus Pedidos</a>";
                                    echo "</li>";
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link' id='nav-link-sair' href='" . $raiz . "sair'>Sair</a>";
                                    echo "</li>";
                                else :
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link' id='nav-link-sair' href='" . $raiz . "entrar'>Entrar</a>";
                                    echo "</li>";
                                endif;
                                ?>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $raiz ?>carrinho">
                                Compras&nbsp;&nbsp;( <?= isset($_SESSION['carrinho']['id_evento_setor']) ? sizeof($_SESSION['carrinho']['id_evento_setor']) : 0 ?> )
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <span class="ti-bag"></span>
                        </li>
                        <li class="nav-item">
                            <?php
                            $palheiro = $_SERVER["REQUEST_URI"];
                            $agulha   = 'inicio';
                            $pos = strpos($palheiro, $agulha);
                            if (!$pos === false) :
                                echo "<button class='search'><span class='lnr lnr-magnifier' id='search'></span></button>";
                            endif;
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="search_input" id="search_input_box">
        <div class="container">
            <form action="<?= $raiz ?>inicio" method="GET" class="d-flex justify-content-between">
                <input type="text" class="form-control" id="search_input" name="search_input" placeholder="Pesquise Aqui">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Fechar Pesquisa"></span>
            </form>
        </div>
    </div>
</header>
<!-- End Header Area -->