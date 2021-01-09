<?php
require_once './gerenciador/util/conexao.php';
require_once './gerenciador/util/funcoes.php';
require_once './src/Visitante.php';
require_once './recaptcha/Config.php';
require_once './recaptcha/Captcha.php';

$idCSS = random_int(1, 9999);

if (!isset($_SESSION)) :
    session_start();
endif;

if (isset($_POST['btnenviar'])) :

    $ObjCaptcha = new Captcha();
    $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']);

    if ($Retorno->success == false && $Retorno->score < 0.9) {
        header("Location: inicio");
    }

    $msg = array();
    $nome = clear($_POST['nome']);
    $sobrenome = clear($_POST['sobrenome']);
    $cpf = clear($_POST['cpf']);
    $rg = clear($_POST['rg']);
    $area = clear($_POST['area']);
    $telefone = clear($_POST['telefone']);
    $email = clear($_POST['email']);
    $senha = clear($_POST['senha']);
    $senhaNova = password_hash($senha, PASSWORD_DEFAULT);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $datanascimento = clear($_POST['datanascimento']);

    if (
        empty($nome) or empty($sobrenome) or empty($cpf) or empty($rg) or empty($telefone) or 
        empty($email) or empty($senha) or empty($logradouro) or empty($numero) or empty($bairro) or
        empty($cep) or empty($cidade) or empty($estado) or empty($datanascimento)
    ) :
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O(s) campo(s) não pode(m) ser vazio(s)!</div>";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>O e-mail não é válido!</div>";
    else :
        $sql = "insert into visitante (nome, sobrenome, cpf, rg, cod_area, telefone, email, senha, logradouro, "
            . "complemento, numero, bairro, cep, cidade, estado, datanascimento, status) "
            . "values('$nome', '$sobrenome', '$cpf', '$rg', '$area', '$telefone', '$email', '$senhaNova', '$logradouro', "
            . "'$complemento', '$numero', '$bairro', '$cep', '$cidade', '$estado', '$datanascimento', 'A')";

        if (mysqli_query($conexao, $sql)) :
            if (Visitante::logar($email, $senha, $conexao)) :
                if ($_SESSION['rota'] == 'carrinho') :
                    header("Location: pagamento");
                else :
                    header("Location: inicio");
                endif;
            endif;
        else :
            $msg[] = "<div class='p-3 mb-2 bg-danger text-white'>CPF e/ou E-mail já cadastrado!</div>";
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
    <title>Compre Bilhete - Seu evento começa aqui!!!</title>
    <link rel="shortcut icon" href="img/Logo.png">

    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="css/estilo.css?id=<?= $idCSS ?>" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" 
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script>
        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#cep").val("");
                $("#logradouro").val("");
                $("#complemento").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#logradouro").val("...");
                        $("#complemento").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#estado").val("...");
                        $("#complemento").focus();

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logradouro").val(dados.logradouro);
                                $("#complemento").val(dados.complemento);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#estado").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                                $("#cep").focus();
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
            // Fim Quando o campo cep perde o foco.
        });

        function validaDat(campo, valor) {
            if (valor != "") {
                var date = valor;
                var ardt = new Array;
                var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
                ardt = date.split("/");
                erro = false;

                var hoje = new Date();
                var anoAtual = hoje.getFullYear();

                if (anoAtual < ardt[2]) {
                    erro = true;
                } else if (date.search(ExpReg) == -1) {
                    erro = true;
                } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30)) {
                    erro = true;
                } else if (ardt[1] == 2) {
                    if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                        erro = true;
                    if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                        erro = true;
                }

                if (erro) {
                    alert("Data de Nascimento inválida!");
                    campo.value = "";
                    campo.focus();
                    return false;
                }
            }
            return true;
        }

        function TestaCPF(strCPF) {
            var Soma;
            var Resto;
            var strCPF = strCPF.replace(".", "").replace(".", "").replace("-", "");
            Soma = 0;
            if (strCPF == "00000000000") {
                document.getElementById('cpf').value = "";
                alert('CPF inválido!');
            }

            if (strCPF != "") {
                for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
                Resto = (Soma * 10) % 11;

                if ((Resto == 10) || (Resto == 11)) Resto = 0;
                if (Resto != parseInt(strCPF.substring(9, 10))) {
                    document.getElementById('cpf').value = "";
                    alert('CPF inválido!');
                }

                Soma = 0;
                for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
                Resto = (Soma * 10) % 11;

                if ((Resto == 10) || (Resto == 11)) Resto = 0;
                if (Resto != parseInt(strCPF.substring(10, 11))) {
                    document.getElementById('cpf').value = "";
                    alert('CPF inválido!');
                }
            }
            return true;
        }
    </script>
</head>

<body>
    <!-- cabecalho -->
    <?php include 'cabecalho.php' ?>

    <div class="container container-cadastro">
        <div class="row">
            <div class="col-md-12 linha_cabecalho">
            </div>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-azul" href="inicio">Página Inicial</a></li>
            <li class="breadcrumb-item active">Meu cadastro</li>
        </ol>
        <div class="card">
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning h4">Meu Cadastro</li>
                </ul>
            </div>
            <div class="card-header">
                <ul class="list-group text-center">
                    <li class="list-group-item list-group-item-warning text-warning bg-dark h6">
                        Atenção: Os campos abaixo não podem conter erros, pois são de grande importância para o sucesso de sua compra.
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <?php
                    if (!empty($msg)) :
                        foreach ($msg as $mensagem) :
                            echo $mensagem;
                        endforeach;
                        echo "<hr>";
                    endif;
                    ?>
                    <div class="col-lg-12">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <input placeholder="Nome *" class="form-control input-cadastro" type="text" name="nome" id="nome" maxlength="100" required />
                                </div>
                                <div class="col-lg-6">
                                    <input placeholder="Sobrenome *" class="form-control input-cadastro" type="text" name="sobrenome" id="sobrenome" maxlength="200" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input onblur="TestaCPF(this.value)" placeholder="CPF *" class="form-control input-cadastro" type="text" name="cpf" id="cpf" data-mask="999.999.999-99" minlength="14" maxlength="14" required />
                                </div>
                                <div class="col-lg-6">
                                    <input placeholder="RG *" class="form-control input-cadastro" type="text" name="rg" id="rg" maxlength="20" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <input placeholder="DDD *" class="form-control input-cadastro" type="text" name="area" id="area" data-mask="99" minlength="2" maxlength="2" required />
                                </div>
                                <div class="col-lg-4">
                                    <input placeholder="Celular *" class="form-control input-cadastro" type="text" name="telefone" id="telefone" data-mask="99999-9999" required />
                                </div>
                                <div class="col-lg-6">
                                    <input placeholder="Data Nascimento *" class="form-control input-cadastro" type="text" name="datanascimento" id="datanascimento" data-mask="99/99/9999" onblur="validaDat(this,this.value)" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input placeholder="E-mail *" class="form-control input-cadastro" type="email" name="email" id="email" maxlength="100" required />
                                </div>
                                <div class="col-lg-6">
                                    <input placeholder="Senha *" class="form-control input-cadastro" type="password" name="senha" id="senha" maxlength="15" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <input placeholder="CEP *" class="form-control input-cadastro" type="text" name="cep" id="cep" data-mask="99.999-999" required />
                                </div>
                                <div class="col-lg-2">
                                    <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank">
                                        <i class="fas fa-search"></i> Encontre o seu CEP
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <input placeholder="Endereço *" class="form-control input-cadastro" type="text" name="logradouro" id="logradouro" maxlength="100" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input placeholder="Complemento" class="form-control input-cadastro" type="text" name="complemento" id="complemento" maxlength="100" />
                                </div>
                                <div class="col-lg-6">
                                    <input placeholder="Número *" class="form-control input-cadastro" type="text" name="numero" id="numero" maxlength="100" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input placeholder="Bairro *" class="form-control input-cadastro" type="text" name="bairro" id="bairro" maxlength="100" required />
                                </div>
                                <div class="col-lg-4">
                                    <input placeholder="Cidade *" class="form-control input-cadastro" type="text" name="cidade" id="cidade" maxlength="100" readonly required />
                                </div>
                                <div class="col-lg-2">
                                    <input placeholder="Estado *" class="form-control input-cadastro" type="text" name="estado" id="estado" maxlength="100" readonly required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right text-primary">
                                    <em>* Campos obrigatórios.</em>
                                </div>
                            </div>
                            <br>
                            <div class="row col-lg-12">
                                <input class="col-12 btn btn-success" type="submit" name="btnenviar" value="Salvar" />
                            </div> 
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- rodape -->
    <?php include 'rodape.php' ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!--gmaps Js-->
    <script src="js/main.js"></script>
    <!-- jquery.inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= FRONT_END_KEY ?>"></script>
    <script src="recaptcha/recaptcha.js"></script>
</body>

</html>