<?php
include_once '../util/conexao.php';

session_start();

if (!isset($_SESSION['admin'])) :
    header('Location: ../index.php');
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <title>Compre Bilhete</title>
</head>

<body>
    <div class="container">
        <h1>Bilhetes Impressos</h1>
        <form action="imprimir-relacao-bilhetes.php" target="_blank" method="POST">
            <fieldset>
                <legend>Evento</legend>
                <select name="evento">
                    <?php
                    $sql = "select distinct e.id, e.descricao, e.data 
                                from bilhetes b, itens_pedido ip, evento_setor es, evento e
                                where ip.id = b.itens_pedido_id and es.id = ip.evento_setor_id and es.evento_id = e.id
                                order by e.data desc";
                    $resultado = mysqli_query($conexao, $sql);
                    while ($dados = mysqli_fetch_array($resultado)) :
                        ?>
                        <option value="<?= $dados['id'] ?>"><?= date('d/m/Y', strtotime($dados['data'])) ?> - <?= $dados['descricao'] ?></option>
                    <?php
                    endwhile;
                    ?>
                </select>
            </fieldset>
            <hr>
            <fieldset>
                <legend>Status do Bilhete</legend>
                <select name="status">
                    <option value="1">Impresso</option>
                    <option value="2">Finalizado</option>
                </select>
                <input type="checkbox" name="status-chek" checked />Todos
            </fieldset>
            <hr>
            <input type="submit" class="btn btn-success" value="Imprimir" />
        </form>
        <br>
        <a class="btn btn-secondary" href="../pagina-inicial-adm.php">Página Principal</a>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>

</html>