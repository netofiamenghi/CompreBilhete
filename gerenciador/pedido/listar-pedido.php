<?php
require_once '../../src/Conexao.php';
require_once '../../src/Funcoes.php';

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['admin'])) :
    header('Location: index.php');
endif;

?>
<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Compre Bilhete - Os melhores eventos aqui!!!</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <br>
        <a class="btn btn-secondary" href="../pagina-inicial-adm.php">Página Principal</a>
        <br><br>
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                CPF<input value="<?= $_GET['pedido'] ?>" placeholder="Digite o CPF com máscara" class="form-control col-md-6" type="text" name="cpf" required /><br>
                <input class="btn btn-primary" type="submit" value="Pesquisar" />
            </form>
            <hr>

            <?php

            if (isset($_POST['cpf'])) :
                $cpf = $_POST['cpf'];

            ?>

                <center>
                    <h1>Pedidos</h1>
                    <div class="table-responsive">
                        <table class="table table-striped w-auto">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col"></th>
                                    <th class="text-center" scope="col">Pedido</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Data</th>
                                    <th class="text-center" scope="col">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "select p.* from pedido p, visitante v 
                                        where p.visitante_id = v.id and v.cpf = '$cpf' and p.status <> 0 order by p.id desc ";
                                $resultado = mysqli_query($conexao, $sql);
                                $qtd = 0;
                                while ($dados = mysqli_fetch_array($resultado)) :
                                    $qtd++;
                                    $id = $dados['id'];
                                    $data = $dados['data'];
                                    $tipoPagto = $dados['tipo_pagto'];
                                    $total = $dados['total'];
                                    $status = $dados['status'];
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <a class="link-azul" href="carregar-pedido.php?pedido=<?= $id ?>&cpf=<?= $cpf ?>">
                                                <i class='fas fa-envelope-open-text'></i> Abrir
                                            </a>
                                        </td>
                                        <td class="text-center" scope="row"><?= $id ?></td>
                                        <td class="text-center">
                                            <?php
                                            switch ($status):
                                                case 1:
                                                    echo 'Pagamento não Finalizado';
                                                    break;
                                                case 2:
                                                    echo 'Aprovado';
                                                    break;
                                                case 3:
                                                    echo 'Em Análise';
                                                    break;
                                                case 4:
                                                    echo 'Pagamento Recusado';
                                                    break;
                                                case 5:
                                                    echo 'Cancelado ou Expirou';
                                                    break;
                                                case 6:
                                                    echo 'Pagamento Devolvido';
                                                    break;
                                                case 7:
                                                    echo 'Aguardando Pgto Boleto Bancário';
                                                    break;
                                                default:
                                                    echo 'Status inválido';
                                            endswitch;
                                            ?>

                                        </td>
                                        <td class="text-center"><?= date('d/m/Y', strtotime($data)) ?></td>
                                        <td class="text-center">R$ <?= number_format($total, 2, ',', '.') ?></td>
                                    </tr>
                                <?php
                                endwhile;

                                if ($qtd < 1) :
                                    echo "<tr><td colspan='6' class='text-center alert alert-danger'>Sem pedidos :(</td></tr>";
                                endif;
                                ?>

                            </tbody>
                        </table>
                        <hr>
                    </div>
                </center>
            <?php
            endif;
            ?>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>

</html>