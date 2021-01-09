<?php
include_once '../util/conexao.php';

session_start();

if (!isset($_SESSION['admin'])):
    header('Location: ../index.php');
endif;

$sql = "select * from evento";
$resultado = mysqli_query($conexao, $sql);
mysqli_close($conexao);
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

            <h1>Listar Eventos</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descrição</th>
                        <th>Local</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dados = mysqli_fetch_array($resultado)):
                        $id = $dados['id'];
                        $descricao = $dados['descricao'];
                        $local = $dados['local'];
                        $data = $dados['data'];
                        $status = $dados['status'];
                        ?>    
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $descricao ?></td>
                            <td><?php echo $local ?></td>
                            <td><?php echo date('d/m/Y', strtotime($data)) ?></td>
                            <td><?php
                                switch ($status):
                                    case 'A':
                                        echo 'Ativo';
                                        break;
                                    case 'S':
                                        echo 'Aguardando Setor';
                                        break;
                                    case 'P':
                                        echo 'Aguardando Ponto de Venda';
                                        break;
                                    case 'I':
                                        echo 'Inativo';
                                        break;
                                endswitch;
                                ?></td>
                            <td><a class='btn btn-primary' href='../evento-setor/incluir-evento-setor.php?id=<?php echo $id ?>'>Setores</a></td>
                            <td><a class='btn btn-primary' href='../evento-ponto-venda/incluir-evento-ponto-venda.php?id=<?php echo $id ?>'>Pontos de Venda</a></td>
                            <td><a class='btn btn-info' href='alterar-evento.php?id=<?php echo $id ?>'>Alterar</a></td>
                        </tr>
                        <?php
                    endwhile;
                    ?>
                </tbody>
            </table>
            <a class="btn btn-secondary" href="cadastrar-evento.php">Inserir</a>
            <a class="btn btn-secondary" href="../pagina-inicial-adm.php">Página Principal</a>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>
</html>