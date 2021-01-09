<?php
require_once './util/conexao.php';
require_once './util/funcoes.php';
require_once '../recaptcha/Config.php';
require_once '../recaptcha/Captcha.php';

if (isset($_POST['entrar'])) :

    $ObjCaptcha = new Captcha();
    $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']);

    if ($Retorno->success == false && $Retorno->score < 0.9) {
        header("Location: ../index.php");
    }

    $erros = array();
    $email = clear($_POST['email']);
    $senha = clear($_POST['senha']);

    if (empty($email) or empty($senha)) :
        $erros[] = "<div class='p-3 mb-2 bg-danger text-white'>O campo e-mail/senha não pode ser vazio!</div>";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $erros[] = "<div class='p-3 mb-2 bg-danger text-white'>O e-mail não é válido!</div>";
    elseif ($email == 'adm@comprebilhete.com.br' && $senha == 'Swxaqz33') :
        session_start();
        $_SESSION['admin'] = true;
        $_SESSION['id'] = 1;
        $_SESSION['nome'] = 'Administrador';
        header('Location: pagina-inicial-adm.php');
    else :
        $sql = "select * from administrador where email = '$email' and status = 'A'";
        $resultado = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($resultado) == 1) :
            $dados = mysqli_fetch_array($resultado);
            if (password_verify($senha, $dados['senha'])) :
                session_start();
                $_SESSION['admin'] = true;
                $_SESSION['id'] = $dados['id'];
                $_SESSION['nome'] = $dados['nome'];
                header('Location: pagina-inicial-adm.php');
            else :
                $erros[] = "<div class='p-3 mb-2 bg-danger text-white'>Senha não confere!</div>";
            endif;
        else :
            $erros[] = "<div class='p-3 mb-2 bg-danger text-white'>Usuário não encontrado!</div>";
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Compre Bilhete</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <p class="h1">Gerenciador - Compre Bilhete</p>
        </div>
        <div class="row">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" size="50" maxlength="100" required /><br>
                    <label for="senha">Senha</label>
                    <input class="form-control" type="password" name="senha" id="senha" required /><br>
                    <input class="btn btn-primary" type="submit" name="entrar" value="Entrar" />
                </div>
            </form>
        </div>
        <div class="row">
            <?php
            if (!empty($erros)) :
                foreach ($erros as $erro) :
                    echo $erro;
                endforeach;
                echo "<hr>";
            endif;
            ?>
        </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= FRONT_END_KEY ?>"></script>
    <script src="recaptcha/recaptcha.js"></script>
</body>

</html>