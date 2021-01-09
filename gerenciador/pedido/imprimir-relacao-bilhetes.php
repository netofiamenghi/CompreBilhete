<?php
include_once '../../vendor/autoload.php';
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['admin'])) :
    header('Location: ../inicio');
endif;

$visitante = $_POST['visitante'];
$visitanteChek = $_POST['visitante-chek'];
$evento = $_POST['evento'];
$status = $_POST['status'];
$statusChek = $_POST['status-chek'];

$sql = "select descricao, data from evento where id = $evento";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$eventoDescricao = $dados['descricao'];
$eventoData = date('d/m/Y', strtotime($dados['data']));

$mpdf = new \Mpdf\Mpdf();
date_default_timezone_set('America/Sao_Paulo');
$agora = date('d/m/Y \à\s H:i:s');

$html = "<html>
            <head>
                <title>Relação de Bilhetes Impressos | Compre Bilhete - Seu evento começa aqui!!!</title>
            </head>
            <body>
                <p style='text-align:right;font-size: 10px;'>$agora</p>
                <h3 style='text-align:center;'>Relação de Bilhetes Impressos</h3>
                <p>Evento - $eventoDescricao</p>
                <p>Data - $eventoData</p>
                <hr>
                <table style='font-size: 12px;'>
                <thead>
                    <tr>
                        <th style='width:120px'>Número</th>
                        <th style='width:120px'>CPF</th>
                        <th style='width:120px'>Tipo</th>
                        <th style='width:120px'>Status</th>
                        <th style='width:120px'>Última Atualização</th>
                    </tr>
                 </thead>";

if ($visitanteChek != "on") :
    $w_visitante = " and v.id = $visitante";
endif;

if ($statusChek != "on") :
    $w_status = " and b.status = $status";
endif;

$order = " order by b.numero";

$sql = "select b.numero, b.status, b.data_hora_status, v.cpf, es.tipo 
        from bilhetes b, itens_pedido ip, pedido p, visitante v, evento_setor es, evento e 
        where ip.id = b.itens_pedido_id and p.id = ip.pedido_id and v.id = p.visitante_id and 
        es.id = ip.evento_setor_id and es.evento_id = e.id and es.evento_id = $evento" . $w_visitante . $w_status . $order;

$resultado = mysqli_query($conexao, $sql);
while ($dados = mysqli_fetch_array($resultado)) :
    $status = $dados['status'] == '1' ? 'Impresso' : 'Finalizado';
    $atualizacao = date('d/m/Y H:m:s', strtotime($dados['data_hora_status']));

    $html .= "<tr>
                 <td style='text-align:center;'> {$dados['numero']} </td>
                 <td style='text-align:center;'> {$dados['cpf']} </td>
                 <td style='text-align:center;'> {$dados['tipo']} </td>
                 <td style='text-align:center;'> $status </td>
                 <td style='text-align:center;'> $atualizacao</td>
            </tr>";
endwhile;

$html .= "</table>
            <hr>
            <p style='text-align:center;font-size:10px;'>Compre Bilhete - Seu evento começa aqui!!!</p>
            </body>
        </html>";

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
