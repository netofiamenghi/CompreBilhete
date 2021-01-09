<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])) :
    header('Location: ../index.php');
endif;

if (isset($_GET['id'])) :
    $id = $_GET['id'];
    $sql = "select * from evento where id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $categoria_id = $dados['categoria_id'];
    $parceiro_id = $dados['parceiro_id'];
    $descricao = $dados['descricao'];
    $local = $dados['local'];
    $cidade = $dados['cidade'];
    $estado = $dados['estado'];
    $abertura = $dados['abertura'];
    $inicio = $dados['inicio'];
    $data = $dados['data'];
    $informacoes = $dados['informacoes'];
    $informacoes = str_ireplace(array("\r", "\n", '\r', '\n'), '', $informacoes);

elseif (isset($_POST['btnenviar'])) :
    $msg = array();
    $id = clear($_POST['id']);
    $categoria_id = clear($_POST['categoria_id']);
    $parceiro_id = clear($_POST['parceiro_id']);
    $descricao = clear($_POST['descricao']);
    $local = clear($_POST['local']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $abertura = clear($_POST['abertura']);
    $inicio = clear($_POST['inicio']);
    $data = clear($_POST['data']);
    $informacoes = $_POST['informacoes'];

    if (
        empty($categoria_id) or empty($parceiro_id) or empty($descricao) or empty($local) or empty($cidade) or
        empty($estado) or empty($abertura) or empty($inicio) or empty($data) or empty($informacoes)
    ) :
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O(s) campo(s) não pode(m) ser vazio(s)!</div>";
    else :
        $temporario = $_FILES['imagem']['tmp_name'];
        $temporario2 = $_FILES['capa']['tmp_name'];
        // alterar imagem
        if (!empty($temporario)) :
            $formatospermitidos = array("png", "jpeg", "jpg", "gif");
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            if (in_array($extensao, $formatospermitidos)) :
                $pasta = "../../img/eventos/";
                $temporario = $_FILES['imagem']['tmp_name'];
                $novoNome = uniqid() . ".$extensao";
                if (move_uploaded_file($temporario, $pasta . $novoNome)) :
                    $sql = "update evento set categoria_id = '$categoria_id',parceiro_id = '$parceiro_id',descricao = '$descricao',local = '$local',"
                        . "cidade = '$cidade',estado = '$estado',abertura = '$abertura',inicio = '$inicio',data = '$data',informacoes = '$informacoes',"
                        . "imagem = '$novoNome' where id = '$id'";
                    if (mysqli_query($conexao, $sql)) :
                        $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Evento alterado com sucesso!</div>";
                    else :
                        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao alterar Evento: " . mysqli_error($conexao) . "</div>";
                    endif;
                    mysqli_close($conexao);
                else :
                    $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Não foi possível fazer o upload da imagem!!!</div>";
                endif;
            else :
                $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Formato de imagem incompatível!!!</div>";
            endif;
        endif;
        // fim alterar imagem

        // alterar capa
        if (!empty($temporario2)) :
            $formatospermitidos2 = array("png", "jpeg", "jpg", "gif");
            $extensao2 = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
            if (in_array($extensao2, $formatospermitidos2)) :
                $pasta2 = "../../img/eventos-capa/";
                $temporario2 = $_FILES['capa']['tmp_name'];
                $novoNome2 = uniqid() . ".$extensao2";
                if (move_uploaded_file($temporario2, $pasta2 . $novoNome2)) :
                    $sql = "update evento set categoria_id = '$categoria_id',parceiro_id = '$parceiro_id',descricao = '$descricao',local = '$local',"
                        . "cidade = '$cidade',estado = '$estado',abertura = '$abertura',inicio = '$inicio',data = '$data',informacoes = '$informacoes',"
                        . "capa = '$novoNome2' where id = '$id'";
                    if (mysqli_query($conexao, $sql)) :
                        $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Evento alterado com sucesso!</div>";
                    else :
                        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao alterar Evento: " . mysqli_error($conexao) . "</div>";
                    endif;
                    mysqli_close($conexao);
                else :
                    $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Não foi possível fazer o upload da imagem!!!</div>";
                endif;
            else :
                $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Formato de imagem incompatível!!!</div>";
            endif;
        endif;
        // fim alterar capa

        if (empty($temporario) && empty($temporario2)) :
            $sql = "update evento set categoria_id = '$categoria_id',parceiro_id = '$parceiro_id',descricao = '$descricao',local = '$local',"
                . "cidade = '$cidade',estado = '$estado',abertura = '$abertura',inicio = '$inicio',data = '$data',informacoes = '$informacoes' "
                . "where id = '$id'";
            if (mysqli_query($conexao, $sql)) :
                $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Evento alterado com sucesso!</div>";
            else :
                $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao alterar Evento: " . mysqli_error($conexao) . "</div>";
            endif;
            mysqli_close($conexao);
        endif;
    endif;
endif;
?>
<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../img/Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="../js/funcoes.js" type="text/javascript"></script>
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <title>Compre Bilhete</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://cdn.tiny.cloud/1/igt0i51guvox84ynqisemghn8voj0t493wcmh8r1z6mqsy8n/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#editor',
            menubar: false
        });
    </script>

</head>

<body>

    <div class="container">
        <h1>Alteração de Evento</h1>
        <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="id">Id</label>
            <input class="form-control" type="text" name="id" id="id" readonly="readonly" value="<?= $id ?>" /><br>
            <label for="categoria">Categoria</label>
            <select class="form-control" name="categoria_id" id="categoria_id">
                <?php
                $sql = "select * from categoria";
                $resultado = mysqli_query($conexao, $sql);
                while ($dados = mysqli_fetch_array($resultado)) :
                    $idCategoria = $dados['id'];
                    $categoria = $dados['descricao'];
                ?>
                    <option <?= $categoria_id == $idCategoria ? 'selected' : ''; ?> value="<?= $idCategoria ?>"><?= $categoria ?></option>
                <?php
                endwhile;
                ?>
            </select><br>
            <label for="parceiro">Parceiro</label>
            <select class="form-control" name="parceiro_id" id="parceiro_id">
                <?php
                $sql = "select * from parceiro";
                $resultado = mysqli_query($conexao, $sql);
                while ($dados = mysqli_fetch_array($resultado)) :
                    $idParceiro = $dados['id'];
                    $parceiro = $dados['nomefantasia'];
                ?>
                    <option <?= $parceiro_id == $idParceiro ? 'selected' : '' ?> value="<?= $idParceiro ?>"><?= $parceiro ?></option>
                <?php
                endwhile;
                ?>
            </select><br>
            <label for="descricao">Descrição</label>
            <input class="form-control" type="text" name="descricao" id="descricao" maxlength="100" required value="<?php echo $descricao ?>" /><br>
            <label for="local">Local</label>
            <input class="form-control" type="text" name="local" id="local" maxlength="100" required value="<?php echo $local ?>" /><br>
            <label for="cidade">Cidade</label>
            <input class="form-control" type="text" name="cidade" id="cidade" maxlength="100" required value="<?php echo $cidade ?>" /><br>
            <label for="estado">Estado</label>
            <select class="form-control" name="estado" id="estado">
                <option <?= $estado == 'AC' ? 'selected' : ''; ?> value="AC">Acre</option>
                <option <?= $estado == 'AL' ? 'selected' : ''; ?> value="AL">Alagoas</option>
                <option <?= $estado == 'AP' ? 'selected' : ''; ?> value="AP">Amapá</option>
                <option <?= $estado == 'AM' ? 'selected' : ''; ?> value="AM">Amazonas</option>
                <option <?= $estado == 'BA' ? 'selected' : ''; ?> value="BA">Bahia</option>
                <option <?= $estado == 'CE' ? 'selected' : ''; ?> value="CE">Ceará</option>
                <option <?= $estado == 'DF' ? 'selected' : ''; ?> value="DF">Distrito Federal</option>
                <option <?= $estado == 'ES' ? 'selected' : ''; ?> value="ES">Espírito Santo</option>
                <option <?= $estado == 'GO' ? 'selected' : ''; ?> value="GO">Goiás</option>
                <option <?= $estado == 'MA' ? 'selected' : ''; ?> value="MA">Maranhão</option>
                <option <?= $estado == 'MT' ? 'selected' : ''; ?> value="MT">Mato Grosso</option>
                <option <?= $estado == 'MS' ? 'selected' : ''; ?> value="MS">Mato Grosso do Sul</option>
                <option <?= $estado == 'MG' ? 'selected' : ''; ?> value="MG">Minas Gerais</option>
                <option <?= $estado == 'PA' ? 'selected' : ''; ?> value="PA">Pará</option>
                <option <?= $estado == 'PB' ? 'selected' : ''; ?> value="PB">Paraíba</option>
                <option <?= $estado == 'PR' ? 'selected' : ''; ?> value="PR">Paraná</option>
                <option <?= $estado == 'PE' ? 'selected' : ''; ?> value="PE">Pernambuco</option>
                <option <?= $estado == 'PI' ? 'selected' : ''; ?> value="PI">Piauí</option>
                <option <?= $estado == 'RJ' ? 'selected' : ''; ?> value="RJ">Rio de Janeiro</option>
                <option <?= $estado == 'RN' ? 'selected' : ''; ?> value="RN">Rio Grande do Norte</option>
                <option <?= $estado == 'RS' ? 'selected' : ''; ?> value="RS">Rio Grande do Sul</option>
                <option <?= $estado == 'RO' ? 'selected' : ''; ?> value="RO">Rondônia</option>
                <option <?= $estado == 'RR' ? 'selected' : ''; ?> value="RR">Roraima</option>
                <option <?= $estado == 'SC' ? 'selected' : ''; ?> value="SC">Santa Catarina</option>
                <option <?= $estado == 'SP' ? 'selected' : ''; ?> value="SP">São Paulo</option>
                <option <?= $estado == 'SE' ? 'selected' : ''; ?> value="SE">Sergipe</option>
                <option <?= $estado == 'TO' ? 'selected' : ''; ?> value="TO">Tocantins</option>
            </select><br>
            <label for="abertura">Horário de Abertura</label>
            <input class="form-control" type="time" name="abertura" id="abertura" required value="<?php echo $abertura ?>" /><br>
            <label for="inicio">Horário de Início</label>
            <input class="form-control" type="time" name="inicio" id="inicio" required value="<?php echo $inicio ?>" /><br>
            <label for="data">Data</label>
            <input class="form-control" type="date" name="data" id="data" required value="<?php echo $data ?>" /><br>
            <label for="editor">Informações</label>
            <textarea style="white-space: pre-wrap;" name="informacoes" id="editor"><?php echo $informacoes ?></textarea><br>
            <label for="imagem">Imagem</label>
            <input class="form-control" type="file" name="imagem" id="imagem" /><br>
            <label for="capa">Capa</label>
            <input class="form-control" type="file" name="capa" id="capa" /><br>
            <input class="btn btn-primary" type="submit" name="btnenviar" value="Alterar" />
        </form>
        <br><br>
        <a href="listar-evento.php">Voltar</a>
        <?php
        if (!empty($msg)) :
            foreach ($msg as $mensagem) :
                echo $mensagem;
            endforeach;
            echo "<hr>";
        endif;
        ?>

    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>