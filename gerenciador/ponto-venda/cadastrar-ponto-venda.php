<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

if (isset($_POST['btnenviar'])):
    $msg = array();
    $nome = clear($_POST['nome']);
    $telefone = clear($_POST['telefone']);
    $email = clear($_POST['email']);
    $logradouro = clear($_POST['logradouro']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);

    if (empty($nome) or empty($telefone) or empty($email) or empty($logradouro) or
            empty($numero) or empty($bairro) or empty($cep) or empty($cidade) or empty($estado)):
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O(s) campo(s) não pode(m) ser vazio(s)!</div>";
    else:
        $sql = "insert into pontovenda (nome, telefone, email, logradouro, numero, bairro, cep, cidade, estado, status) "
                . "values('$nome','$telefone','$email','$logradouro','$numero','$bairro','$cep','$cidade','$estado','A')";
        if (mysqli_query($conexao, $sql)):
            $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Ponto de Venda cadastrado com sucesso!</div>";
        else:
            $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao cadastrar Ponto de Venda: " . mysqli_error($conexao) . "</div>";
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

        <script src="../js/funcoes.js" type="text/javascript"></script>
        <title>Compre Bilhete</title>
    </head>
    <body>
        <div class="container">

            <h1>Cadastro de Ponto de Venda</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="id">Id</label>
                <input class="form-control" type="text" name="id" id="id" readonly="readonly"/><br>
                <label for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" id="nome" maxlength="100" required/><br>
                <label for="telefone">Telefone</label>
                <input class="form-control" type="text" name="telefone" id="telefone"/><br>
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email"/><br>
                <label for="cep">CEP</label>
                <input class="form-control" type="text" name="cep" id="cep" required/><br>
                <label for="logradouro">Logradouro</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required/><br>
                <label for="numero">Número</label>
                <input class="form-control" type="text" name="numero" id="numero" required/><br>
                <label for="bairro">Bairro</label>
                <input class="form-control" type="text" name="bairro" id="bairro" maxlength="100" required/><br>
                <label for="cidade">Cidade</label>
                <input class="form-control" type="text" name="cidade" id="cidade" maxlength="100" required/><br>
                <label for="estado">Estado</label>
                <select class="form-control" name="estado" id="estado">
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select><br>

                <input class="btn btn-primary" type="submit" name="btnenviar" value="Cadastrar"/>
            </form>
            <br>
            <a class="btn btn-secondary" href="listar-ponto-venda.php">Listar Ponto de Venda</a>
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