<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

if (isset($_POST['btnenviar'])):
    $msg = array();
    $nomefantasia = clear($_POST['nomefantasia']);
    $razaosocial = clear($_POST['razaosocial']);
    $cnpj = clear($_POST['cnpj']);
    $telefone = clear($_POST['telefone']);
    $email = clear($_POST['email']);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $contato = clear($_POST['contato']);

    if (empty($nomefantasia) or empty($razaosocial) or empty($cnpj) or empty($telefone) or
            empty($email) or empty($logradouro) or empty($numero) or empty($bairro) or empty($cep) or
            empty($cidade) or empty($estado) or empty($contato)):
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O(s) campo(s) não pode(m) ser vazio(s)!</div>";
    else:
        $formatospermitidos = array("png", "jpeg", "jpg", "gif");
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        if (in_array($extensao, $formatospermitidos)):
            $pasta = "../../img/parceiros/";
            $temporario = $_FILES['imagem']['tmp_name'];
            $novoNome = uniqid() . ".$extensao";
            if (move_uploaded_file($temporario, $pasta . $novoNome)):
                $sql = "insert into parceiro (nomefantasia, razaosocial, cnpj, telefone, email, logradouro, complemento, numero, "
                        . "bairro, cep, cidade, estado, contato, imagem, status) values('$nomefantasia','$razaosocial','$cnpj','$telefone','$email',"
                        . "'$logradouro','$complemento','$numero','$bairro','$cep', '$cidade', '$estado', '$contato', '$novoNome', 'A')";
                if (mysqli_query($conexao, $sql)):
                    $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Parceiro cadastrado com sucesso!</div>";
                else:
                    $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao cadastrar Parceiro: " . mysqli_error($conexao) . "</div>";
                endif;
                mysqli_close($conexao);
            else:
                $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Não foi possível fazer o upload da imagem!!!</div>";
            endif;
        else:
            $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Formato de imagem incompatível!!!</div>";
        endif;
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
            <h1>Cadastro de Parceiro</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <label for="id">Id</label>
                <input class="form-control" type="text" name="id" id="id" readonly="readonly"/><br>
                <label for="nomefantasia">Nome Fantasia</label>
                <input class="form-control" type="text" name="nomefantasia" id="nomefantasia" maxlength="100" required/><br>
                <label for="razaosocial">Razão Social</label>
                <input class="form-control" type="text" name="razaosocial" id="razaosocial" maxlength="100" required/><br>
                <label for="cnpj">CNPJ</label>
                <input class="form-control" type="text" name="cnpj" id="cnpj" required/><br>
                <label for="telefone">Telefone</label>
                <input class="form-control" type="text" name="telefone" id="telefone" required/><br>
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="100" required/><br>
                <label for="contato">Contato</label>
                <input class="form-control" type="text" name="contato" id="contato" maxlength="100" required/><br>
                <label for="cep">CEP</label>
                <input class="form-control" type="text" name="cep" id="cep" required/><br>
                <label for="logradouro">Logradouro</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required/><br>
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento"/><br>
                <label for="numero">Número</label>
                <input class="form-control" type="text" name="numero" id="numero"/><br>
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
                <label for="imagem">Imagem</label>
                <input class="form-control" type="file" name="imagem" id="imagem" required/><br>
                <input class="btn btn-primary" type="submit" name="btnenviar" value="Cadastrar"/>
            </form>
            <br>
            <a class="btn btn-secondary" href="listar-parceiro.php">Listar Parceiro</a>
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