<?php
require_once './recaptcha/Config.php';
require_once './recaptcha/Captcha.php';
require_once './src/Visitante.php';

$idCSS = random_int(1, 9999);

if (isset($_POST['entrar'])) :

    $ObjCaptcha = new Captcha();
    $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']);

    if ($Retorno->success == false && $Retorno->score < 0.9) {
        header("Location: inicio");
    }

    $erros = array();
    $email = clear($_POST['email']);
    $senha = clear($_POST['senha']);

    if (empty($email) or empty($senha)) :
        $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-danger text-white'>O campo e-mail/senha não pode ser vazio!</div>";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-danger text-white'>O e-mail não é válido!</div>";
    else :
        if (Visitante::logar($email, $senha, $conexao)) :
            if ($_SESSION['rota'] == 'carrinho') :
                header("Location: pagamento");
            elseif($_SESSION['rota'] == 'detalhes') :
                header("Location: detalhes/{$_SESSION['detalhes']}");
            else :
                header("Location: inicio");
            endif;
        else :
            $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-danger text-white'>Usuário não encontrado!</div>";
        endif;
    endif;
endif;
?>
<!doctype html>
<html class="corpo_login" lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/Logo.png">
    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <title>Compre Bilhete - Seu evento começa aqui!!!</title>
    <link href="css/estilo.css?id=<?=$idCSS?>" rel="stylesheet" type="text/css" />
</head>

<body class="corpo_login">
    <div class="container container_login">
        <div class="d-flex justify-content-center h-100">
            <div class="card card_login">
                <div class="card-header">
                    <h3 class="h3_entrar">Entrar</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <img class="imagem_login" src="img/Logo.png" alt="" />
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail Usuário" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input class="form-control" type="password" name="senha" id="senha" required placeholder="Senha">
                        </div>
                        <div class="text-right links">
                            <a href="recuperar-senha">Esqueci minha senha</a>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" name="entrar" value="Entrar" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Não possui uma conta?<a href="cadastro">Cadastre-se aqui!</a>
                    </div>
                    <div class="d-flex justify-content-center">
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
            <div class="alert alert-dark alert_entrar" role="alert">
                <a href="inicio" class="alert-link">Voltar à Página Inicial</a>
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