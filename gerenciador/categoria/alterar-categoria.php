<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

if (isset($_GET['id'])):
    $id = $_GET['id'];
    $sql = "select * from categoria where id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    mysqli_close($conexao);
    $descricao = $dados['descricao'];
    $status = $dados['status'];
elseif (isset($_POST['btnenviar'])):
    $msg = array();
    $id = clear($_POST['id']);
    $descricao = clear($_POST['descricao']);
    $status = clear($_POST['status']);
    if (empty($descricao)):
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O campo descrição não pode ser vazio!</div>";
    else:
        $sql = "update categoria set descricao = '$descricao', status = '$status' where id = '$id'";
        if (mysqli_query($conexao, $sql)):
            $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Categoria alterado com sucesso!</div>";
        else:
            $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao alterar Categoria: " . mysqli_error($conexao) . "</div>";
        endif;
        mysqli_close($conexao);
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
        <title>Compre Bilhete</title>
    </head>
    <body>
        <div class="container">
            <h1>Alteração de Categoria</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="id">Id</label>
                <input class="form-control" type="text" name="id" id="id" readonly="readonly" value="<?php echo $id ?>"/><br>
                <label for="descricao">Descrição</label>
                <input class="form-control" type="text" name="descricao" id="descricao" maxlength="100" required value="<?php echo $descricao ?>"/><br>
                <label for="status">Status</label>
                <select class="form-control" name="status">
                    <option value="A" <?php echo $status == 'A' ? 'selected' : ''; ?>>Ativo</option>
                    <option value="I" <?php echo $status == 'I' ? 'selected' : ''; ?>>Inativo</option>
                </select>
                <br>
                <input class="btn btn-primary" type="submit" name="btnenviar" value="Alterar"/>
            </form>
            <br>
            <a class="btn btn-secondary" href="listar-categoria.php">Listar Categoria</a>
            <a class="btn btn-secondary" href="../pagina-inicial-adm.php">Página Principal</a>
            <br><br>
            <?php
            if (!empty($msg)):
                foreach ($msg as $mensagem):
                    echo $mensagem;
                endforeach;
                echo "<hr>";
            endif;
            ?>

        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>
</html>
