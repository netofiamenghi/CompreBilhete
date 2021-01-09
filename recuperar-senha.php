<?php
require_once './gerenciador/util/conexao.php';
require_once './gerenciador/util/funcoes.php';
require_once './recaptcha/Config.php';
require_once './recaptcha/Captcha.php';
require_once './src/Email.php';

$idCSS = random_int(1, 9999);

if (isset($_POST['entrar'])) :

    $ObjCaptcha = new Captcha();
    $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']);

    if ($Retorno->success == false && $Retorno->score < 0.9) {
        header("Location: inicio");
    }

    $erros = array();
    $cpf = clear($_POST['cpf']);

    if (empty($cpf)) :
        $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-danger text-white'>O campo CPF não pode ser vazio!</div>";
    else :
        $sql = "select id,nome,email,senha from visitante where cpf = '$cpf'";
        $resultado = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($resultado) == 1) :
            $dados = mysqli_fetch_array($resultado);
            $id = $dados['id'];
            $nome = $dados['nome'];
            $email = $dados['email'];
            // $senha = substr($dados['senha'], 0, 8);
            $senha = random_int(111111, 999999);
            $novaSenha = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "update visitante set senha = '$novaSenha' where id = $id";

            mysqli_query($conexao, $sql);
            mysqli_close($conexao);

            // Corpo do E-mail
            $mensagem = "
            <html>
                <head>
                    <style>
                        * {margin: 0;padding: 0;box-sizing: border-box;}
                        a,a:active,a:visited,a:hover {text-decoration: none;color: blue;}
                        h2{font-size: 1.5em}
                        p{font-size: 1em}
                    </style>
                </head>
                <body>
                    <h2>Olá, $nome</h2>
                    <br>
                    <h3>Nós vimos que você solicitou alteração de senha da sua conta.</h3>
                    <br>
                    <h2>Sua nova senha é: $senha</h2>
                    <br><br>
                    <h5>Qualquer dúvida entre em contato conosco: atendimento@comprebilhete.com.br</h5>
                    <h5>Esta é uma mensagem gerada automaticamente, portanto não pode ser respondida.</h5>
                    <p><a href='http://www.comprebilhete.com.br' target='_blank'>Compre Bilhete - Seu evento começa aqui!!!</a></p>
                </body>
            </html>";

            if (Email::enviarEmail($email, "Compre Bilhete - Envio de Senha", $mensagem)) :
                $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-success text-white'>Senha enviada!</div>";
            else :
                $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-danger text-white'>Erro ao enviar senha!</div>";
            endif;
        else :
            $erros[] = "<div class='col-12 text-center p-3 mb-2 bg-danger text-white'>CPF não cadastrado!</div>";
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
                    <h3 class="h3_entrar">Recuperar Senha</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <img class="imagem_login" src="img/Logo.png" alt="" />
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                        <p class="h3_entrar">Digite o CPF cadastrado para receber um e-mail com a sua nova senha.</p>
                        <br>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="form-control" type="text" name="cpf" id="cpf" placeholder="CPF Cadastrado" data-mask="999.999.999-99" minlength="14" maxlength="14" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" name="entrar" value="Enviar" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div>
                        <p class="h3_entrar text-warning text-center">Lembre-se de verificar as pastas Spam e/ou Lixo Eletrônico, caso não receba o e-mail.</p>
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
                <a href="entrar" class="alert-link">Voltar à Página de Login</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</body>

</html>