<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

if (isset($_GET['id'])):
    $evento_id = $_GET['id'];
    $sql = "select * from evento where id = '$evento_id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $descricao = $dados['descricao'];
    $local = $dados['local'];
    $cidade = $dados['cidade'];
    $data = $dados['data'];
    $status = $dados['status'];
elseif (isset($_POST['btnenviar'])):
    $msg = array();
    $evento_id = clear($_POST['evento_id']);
    $pontovenda_id = clear($_POST['pontovenda_id']);
    $taxacobranca = clear($_POST['taxacobranca']);
    $local = clear($_POST['local']);
    $cidade = clear($_POST['cidade']);
    $data = clear($_POST['data']);

    $sql = "insert into evento_pontovenda (evento_id, pontovenda_id, taxacobranca) values ('$evento_id','$pontovenda_id','$taxacobranca')";
    if (mysqli_query($conexao, $sql)):
        $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Evento-ponto-venda incluído com sucesso!</div>";
    else:
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao inserir Evento-ponto-venda: " . mysqli_error($conexao) . "</div>";
    endif;
    echo $msg[0];
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
        <script src="../js/funcoes.js" type="text/javascript"></script>
        <title>Compre Bilhete</title>
    </head>
    <body>
        <div class="container">

            <h1>Incluir Pontos de Venda ao Evento</h1>
            <hr>
            <h3><?= $descricao ?></h3>
            <h3><?= $local . " - " . $cidade . " - " . date('d/m/Y', strtotime($data)) ?></h3>
            <hr>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="hidden" name="evento_id" value="<?= $evento_id ?>"/>
                <input type="hidden" name="descricao" value="<?= $descricao ?>"/>
                <input type="hidden" name="local" value="<?= $local ?>"/>
                <input type="hidden" name="cidade" value="<?= $cidade ?>"/>
                <input type="hidden" name="data" value="<?= $data ?>"/>

                <label for="pontovenda">Ponto de Venda</label>
                <select class="form-control" name="pontovenda_id" id="pontovenda_id">
                    <?php
                    $sql = "select id, nome from pontovenda "
                            . "where id not in (select p.id from evento_pontovenda ep, pontovenda p "
                            . "where p.id = ep.pontovenda_id and ep.evento_id = $evento_id)";
                    $resultado = mysqli_query($conexao, $sql);
                    while ($dados = mysqli_fetch_array($resultado)):
                        $pontovenda_id = $dados['id'];
                        $nome = $dados['nome'];
                        ?>
                        <option value="<?= $pontovenda_id ?>"><?= "$pontovenda_id - $nome" ?></option>
                        <?php
                    endwhile;
                    ?>
                </select><br>
                <label for="taxacobranca">Taxa de Cobrança</label>
                <input class="form-control" type="number" name="taxacobranca" id="taxacobranca" step="0.5" min="0" value="0"/><br>

                <input type="submit" class="btn btn-primary" value="Incluir" name="btnenviar"/>
            </form>
            <br>
            <h2>Pontos de Venda Incluídos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Taxa de Cobrança</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select ep.*, p.nome from evento_pontovenda ep, pontovenda p where p.id = ep.pontovenda_id and ep.evento_id = '$evento_id'";
                    $resultado = mysqli_query($conexao, $sql);
                    while ($dados = mysqli_fetch_array($resultado)):
                        $id = $dados['id'];
                        $taxacobranca = $dados['taxacobranca'];
                        $nome = $dados['nome'];
                        ?>    
                        <tr>
                            <td><?= $nome ?></td>
                            <td><?= 'R$ ' . number_format($taxacobranca, 2) ?></td>
                            <td><a class='btn btn-info' href='excluir-evento-ponto-venda.php?id=<?= $id ?>&evento_id=<?= $evento_id ?>'>Excluir</a></td>
                        </tr>
                        <?php
                    endwhile;
                    ?>
                </tbody>
            </table>

            <hr>
            <a class="btn btn-secondary" href="../evento/listar-evento.php">Listar Eventos</a>
            <a class="btn btn-secondary" href="../pagina-inicial-adm.php">Página Principal</a>

        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>
</html>