<?php
session_start();

if (!isset($_SESSION['admin'])) :
    header('Location: index.php');
endif;
?>
<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Compre Bilhete - Os melhores eventos aqui!!!</title>
</head>

<body>
    <div class="container">
        <h1>Compre Bilhete - Administração</h1>
        <h2>Seja bem-vindo, <?php echo $_SESSION['nome']; ?></h2>
        <hr>
        <h3>Cadastros</h3>
        <ul>
            <li><a href="administrador/listar-administrador.php">Administrador</a></li>
            <li><a href="categoria/listar-categoria.php">Categoria</a></li>
            <li><a href="evento/listar-evento.php">Evento</a></li>
            <li><a href="parceiro/listar-parceiro.php">Parceiro</a></li>
            <li><a href="pedido/listar-pedido.php">Pedido</a></li>
            <li><a href="ponto-venda/listar-ponto-venda.php">Ponto de Venda</a></li>
            <li><a href="setor/listar-setor.php">Setor</a></li>
            <li><a href="visitante/listar-visitante.php">Visitante</a></li>
        </ul>
        <hr>
        <h3>Relatórios</h3>
        <ul>
            <li><a href="pedido/relacao-bilhetes.php">Relação Bilhetes Impressos</a></li>
            <li><a href="pedido/relacao-bilhetes-vendidos.php">Relação Bilhetes Vendidos</a></li>
            <li><a href="pedido/relatorio-final-bilhetes.php">Relatório Final do Evento</a></li>
        </ul>
        <hr>
        <a href="logout.php">Sair</a>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>

</html>