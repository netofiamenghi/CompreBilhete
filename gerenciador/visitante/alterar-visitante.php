<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

if (isset($_GET['id'])):
    $id = $_GET['id'];
    $sql = "select * from visitante where id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    mysqli_close($conexao);
    $nome = $dados['nome'];
    $cpf = $dados['cpf'];
    $rg = $dados['rg'];
    $telefone = $dados['telefone'];
    $email = $dados['email'];
    $senha = $dados['senha'];
    $logradouro = $dados['logradouro'];
    $complemento = $dados['complemento'];
    $numero = $dados['numero'];
    $bairro = $dados['bairro'];
    $cep = $dados['cep'];
    $cidade = $dados['cidade'];
    $estado = $dados['estado'];
    $datanascimento = $dados['datanascimento'];
    $sexo = $dados['sexo'];
    $status = $dados['status'];
elseif (isset($_POST['btnenviar'])):
    $msg = array();
    $id = clear($_POST['id']);
    $nome = clear($_POST['nome']);
    $cpf = clear($_POST['cpf']);
    $rg = clear($_POST['rg']);
    $telefone = clear($_POST['telefone']);
    $email = clear($_POST['email']);
    $senha = clear($_POST['senha']);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $datanascimento = clear($_POST['datanascimento']);
    $sexo = clear($_POST['sexo']);
    $status = clear($_POST['status']);
    if (empty($nome) or empty($cpf) or empty($rg) or empty($telefone) or empty($email) or
            empty($logradouro) or empty($complemento) or empty($numero) or empty($bairro) or
            empty($cep) or empty($cidade) or empty($estado) or empty($datanascimento) or empty($sexo)):
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Os campos não podem ser vazios!</div>";
    else:
        if (empty($senha)):
            $sql = "update visitante set nome = '$nome', cpf = '$cpf', rg = '$rg', telefone = '$telefone', "
                    . "email = '$email', logradouro = '$logradouro', complemento = '$complemento', "
                    . "numero = '$numero', bairro = '$bairro', cep = '$cep', cidade = '$cidade', estado = '$estado', "
                    . "datanascimento = '$datanascimento', sexo = '$sexo', status = '$status' where id = '$id'";
        else:
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "update visitante set nome = '$nome', cpf = '$cpf', rg = '$rg', telefone = '$telefone', "
                    . "email = '$email', senha = '$senha', logradouro = '$logradouro', complemento = '$complemento', "
                    . "numero = '$numero', bairro = '$bairro', cep = '$cep', cidade = '$cidade', estado = '$estado', "
                    . "datanascimento = '$datanascimento', sexo = '$sexo', status = '$status' where id = '$id'";
        endif;

        if (mysqli_query($conexao, $sql)):
            $msg[] = "<div class='p-3 mb-2 bg-success text-white'>Visitante alterado com sucesso!</div>";
        else:
            $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>Erro ao alterar Visitante: " . mysqli_error($conexao) . "</div>";
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
            <h1>Alteração de Visitante</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="id">Id</label>
                <input class="form-control" type="text" name="id" id="id" readonly="readonly" value="<?php echo $id ?>"/><br>
                <label for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" id="nome" value="<?php echo $nome ?>"/><br>
                <label for="cpf">CPF</label>
                <input class="form-control" type="text" name="cpf" id="cpf" value="<?php echo $cpf ?>"/><br>
                <label for="rg">RG</label>
                <input class="form-control" type="text" name="rg" id="rg" value="<?php echo $rg ?>"/><br>
                <label for="telefone">Telefone</label>
                <input class="form-control" type="text" name="telefone" id="telefone" value="<?php echo $telefone ?>"/><br>
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" value="<?php echo $email ?>"/><br>
                <label for="senha">Nova Senha</label>
                <input class="form-control" type="password" name="senha" id="senha" /><br>
                <label for="cep">CEP</label>
                <input class="form-control" type="text" name="cep" id="cep" value="<?php echo $cep ?>"/><br>
                <label for="logradouro">Logradouro</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" value="<?php echo $logradouro ?>"/><br>
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento" value="<?php echo $complemento ?>"/><br>
                <label for="numero">Número</label>
                <input class="form-control" type="text" name="numero" id="numero" value="<?php echo $numero ?>"/><br>
                <label for="bairro">Bairro</label>
                <input class="form-control" type="text" name="bairro" id="bairro" value="<?php echo $bairro ?>"/><br>
                <label for="cidade">Cidade</label>
                <input class="form-control" type="text" name="cidade" id="cidade" value="<?php echo $cidade ?>"/><br>
                <label for="estado">Estado</label>
                <select class="form-control" name="estado" id="estado">
                    <option <?php echo $estado == 'AC' ? 'selected' : ''; ?> value="AC">Acre</option>
                    <option <?php echo $estado == 'AL' ? 'selected' : ''; ?> value="AL">Alagoas</option>
                    <option <?php echo $estado == 'AP' ? 'selected' : ''; ?> value="AP">Amapá</option>
                    <option <?php echo $estado == 'AM' ? 'selected' : ''; ?> value="AM">Amazonas</option>
                    <option <?php echo $estado == 'BA' ? 'selected' : ''; ?> value="BA">Bahia</option>
                    <option <?php echo $estado == 'CE' ? 'selected' : ''; ?> value="CE">Ceará</option>
                    <option <?php echo $estado == 'DF' ? 'selected' : ''; ?> value="DF">Distrito Federal</option>
                    <option <?php echo $estado == 'ES' ? 'selected' : ''; ?> value="ES">Espírito Santo</option>
                    <option <?php echo $estado == 'GO' ? 'selected' : ''; ?> value="GO">Goiás</option>
                    <option <?php echo $estado == 'MA' ? 'selected' : ''; ?> value="MA">Maranhão</option>
                    <option <?php echo $estado == 'MT' ? 'selected' : ''; ?> value="MT">Mato Grosso</option>
                    <option <?php echo $estado == 'MS' ? 'selected' : ''; ?> value="MS">Mato Grosso do Sul</option>
                    <option <?php echo $estado == 'MG' ? 'selected' : ''; ?> value="MG">Minas Gerais</option>
                    <option <?php echo $estado == 'PA' ? 'selected' : ''; ?> value="PA">Pará</option>
                    <option <?php echo $estado == 'PB' ? 'selected' : ''; ?> value="PB">Paraíba</option>
                    <option <?php echo $estado == 'PR' ? 'selected' : ''; ?> value="PR">Paraná</option>
                    <option <?php echo $estado == 'PE' ? 'selected' : ''; ?> value="PE">Pernambuco</option>
                    <option <?php echo $estado == 'PI' ? 'selected' : ''; ?> value="PI">Piauí</option>
                    <option <?php echo $estado == 'RJ' ? 'selected' : ''; ?> value="RJ">Rio de Janeiro</option>
                    <option <?php echo $estado == 'RN' ? 'selected' : ''; ?> value="RN">Rio Grande do Norte</option>
                    <option <?php echo $estado == 'RS' ? 'selected' : ''; ?> value="RS">Rio Grande do Sul</option>
                    <option <?php echo $estado == 'RO' ? 'selected' : ''; ?> value="RO">Rondônia</option>
                    <option <?php echo $estado == 'RR' ? 'selected' : ''; ?> value="RR">Roraima</option>
                    <option <?php echo $estado == 'SC' ? 'selected' : ''; ?> value="SC">Santa Catarina</option>
                    <option <?php echo $estado == 'SP' ? 'selected' : ''; ?> value="SP">São Paulo</option>
                    <option <?php echo $estado == 'SE' ? 'selected' : ''; ?> value="SE">Sergipe</option>
                    <option <?php echo $estado == 'TO' ? 'selected' : ''; ?> value="TO">Tocantins</option>
                </select><br>
                <label for="datanascimento">Data de Nascimento</label>
                <input class="form-control" type="date" name="datanascimento" id="datanascimento" value="<?php echo $datanascimento ?>"/><br>
                <label for="sexo">Sexo</label>
                <input class="form-control" type="text" name="sexo" id="sexo" value="<?php echo $sexo ?>"/><br>
                <label for="status">Status</label>
                <select class="form-control" name="status">
                    <option value="A" <?php echo $status == 'A' ? 'selected' : ''; ?>>Ativo</option>
                    <option value="I" <?php echo $status == 'I' ? 'selected' : ''; ?>>Inativo</option>
                </select>
                <br>
                <input class="btn btn-primary" type="submit" name="btnenviar" value="Alterar"/>
            </form>
            <br>
            <a class="btn btn-secondary" href="listar-visitante.php">Listar Visitante</a>
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