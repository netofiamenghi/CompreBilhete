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
    $setor_id = clear($_POST['setor_id']);
    $tipo = clear($_POST['tipo']);
    $valor = clear($_POST['valor']);
    $valorTaxa = clear($_POST['valorTaxa']);
    $descricao = clear($_POST['descricao']);
    $local = clear($_POST['local']);
    $cidade = clear($_POST['cidade']);
    $data = clear($_POST['data']);

    if (empty($tipo) or empty($valor)):
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O(s) campo(s) não pode(m) ser vazio(s)!</div>";
    else:
        $sql = "insert into evento_setor (evento_id, setor_id, tipo, valor, taxa) values ('$evento_id','$setor_id','$tipo', '$valor', '$valorTaxa')";
        if (mysqli_query($conexao, $sql)):
            $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Evento-setor incluído com sucesso!</div>";
        else:
            $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao inserir Evento-setor: " . mysqli_error($conexao) . "</div>";
        endif;
    //mysqli_close($conexao);
    endif;
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

            <h1>Incluir Setores ao Evento</h1>
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

                <label for="setor">Setor</label>
                <select class="form-control" name="setor_id" id="setor_id">
                    <?php
                    $sql = "select * from setor";
                    $resultado = mysqli_query($conexao, $sql);
                    while ($dados = mysqli_fetch_array($resultado)):
                        $setor_id = $dados['id'];
                        $descricao = $dados['descricao'];
                        ?>
                        <option value="<?= $setor_id ?>"><?= "$setor_id - $descricao" ?></option>
                        <?php
                    endwhile;
                    ?>
                </select><br>
                <label for="tipo">Tipo</label>
                <input class="form-control" type="text" name="tipo" id="tipo" required/><br>
                <label for="valor">Valor</label>
                <input class="form-control" type="number" step="0.5" name="valor" id="valor" min="0" required/><br>
                <label for="valorTaxa">Valor Taxa</label>
                <input class="form-control" type="number" step="0.5" name="valorTaxa" id="valorTaxa" min="0" required/><br>

                <input type="submit" class="btn btn-primary" value="Incluir" name="btnenviar"/>
            </form>
            <br>
            <?php
            if (!empty($msg)):
                foreach ($msg as $mensagem):
                    echo $mensagem;
                endforeach;
            endif;
            ?>
            <hr>
            <h2>Setores Incluídos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Setor</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Taxa</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select es.*, s.descricao from evento_setor es, setor s where  es.setor_id = s.id and es.evento_id = '$evento_id'";
                    $resultado = mysqli_query($conexao, $sql);
                    while ($dados = mysqli_fetch_array($resultado)):
                        $id = $dados['id'];
                        $tipo = $dados['tipo'];
                        $valor = $dados['valor'];
                        $descricao = $dados['descricao'];
                        $taxa = $dados['taxa'];
                        ?>    
                        <tr>
                            <td><?= $descricao ?></td>
                            <td><?= $tipo ?></td>
                            <td><?= 'R$ ' . number_format($valor, 2) ?></td>
                            <td><?= 'R$ ' . number_format($taxa, 2) ?></td>
                            <td><a class='btn btn-info' href='excluir-evento-setor.php?id=<?= $id ?>&evento_id=<?=$evento_id?>'>Excluir</a></td>
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