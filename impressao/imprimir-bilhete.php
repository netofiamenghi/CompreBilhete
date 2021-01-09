<?php
include_once '../vendor/autoload.php';
include_once '../gerenciador/util/conexao.php';
include_once '../gerenciador/util/funcoes.php';
include_once '../phpqrcode/qrlib.php';

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['visitante'])) :
    header('Location: inicio');
endif;

$mpdf = new \Mpdf\Mpdf();

$pedido = $_SESSION['pedido'];
$titular = $_SESSION['nomeVisitante'];
$cpf = $_SESSION['cpfVisitante'];

$sql = "select ip.id, ip.quantidade, es.tipo, e.descricao, s.descricao as setor, e.data, e.local, e.cidade, e.inicio, e.estado
        from itens_pedido ip, evento_setor es, evento e, setor s
        where s.id = es.setor_id and e.id = es.evento_id and ip.evento_setor_id = es.id and ip.pedido_id = $pedido";
$resultado = mysqli_query($conexao, $sql);
while ($dados = mysqli_fetch_array($resultado)) :
    $item = $dados['id'];
    $quantidade = $dados['quantidade'];
    $tipo = $dados['tipo'];
    $descricao = $dados['descricao'];
    $setor = $dados['setor'];
    $data = date('d/m/Y', strtotime($dados['data']));
    $local = $dados['local'];
    $cidade = $dados['cidade'];
    $estado = $dados['estado'];
    $inicio = $dados['inicio'];
    $y = 1;
    while ($y <= $quantidade) :

        $sql2 = "select numero from bilhetes where numero = '$pedido$item$y'";
        $resultado2 = mysqli_query($conexao, $sql2);

        if (mysqli_num_rows($resultado2) == 0) :
            // se não existir cadastra o bilhete no banco

            $status = 1; // 1 - impresso; 2 - entrada
            date_default_timezone_set('America/Sao_Paulo');
            $agora = date("Y-m-d H:i:s");

            $sql3 = "insert into bilhetes (numero, status, data_hora_status, itens_pedido_id) 
                    values('$pedido$item$y','$status','$agora','$item')";
            mysqli_query($conexao, $sql3);
        endif;

        QRcode::png("$pedido$item$y", "QR_code$y.png");
        $html = "<html>
                    <head>
                        <link rel='shortcut icon' href='../img/Logo.png'>
                        <title>Compre Bilhete - Os melhores eventos aqui!!!</title>
                        <link rel='stylesheet' href='imprimir-bilhete.css'>
                    </head>
                    <body>
                        <fieldset>
                            <img id='logo' src='../img/Compre Bilhete Amarelo.png'/> 
                            <h2>$descricao</h2> 
                            <h2>$num</h2>
                            <p class='center'> Nº do Bilhete - <strong class='bilhete'>$pedido$item$y</strong> - setor - <strong class='bilhete'>$setor</strong> - tipo - <strong class='bilhete'>$tipo</strong></p> 
                            <p>Nº PEDIDO: <strong>$pedido</strong></p>
                            <p>TITULAR DO PEDIDO: <strong>$titular</strong> CPF: <strong>$cpf</strong></p>
                            <p>DATA: <strong>$data</strong> HORÁRIO: <strong>$inicio h</strong></p>
                            <p>LOCAL: <strong>$local</strong></p>
                            <p>CIDADE: <strong>$cidade/$estado</strong></p>
                            <a class='creditos' href='https://www.comprebilhete.com.br' target='_blank'>Compre Bilhete - Seu evento começa aqui!!!</a>
                            <img id='qrcode' src='QR_code$y.png'/>
                        </fieldset>
                    </body>
                </html>";
        $y++;
        $mpdf->WriteHTML($html);
        if ($y <= $quantidade) :
            $mpdf->AddPage();
        endif;
    endwhile;
endwhile;
$mpdf->Output();
exit;
