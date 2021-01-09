<?php
include_once './../../vendor/autoload.php';
include_once './../util/conexao.php';
include_once './../util/funcoes.php';

if (!isset($_SESSION)) :
    session_start();
endif;

if (!isset($_SESSION['admin'])) :
    header('Location: ../index.php');
endif;

$evento = $_POST['evento'];

$sql = "select descricao, data from evento where id = $evento";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$eventoDescricao = $dados['descricao'];
$eventoData = date('d/m/Y', strtotime($dados['data']));

$sql = "select sum(quantidade) quantidade, sum(valor_unitario * quantidade) valor_total, sum(taxa_unitario * quantidade) taxa_total
from itens_pedido ip, evento_setor es, evento e, pedido p
where ip.pedido_id = p.id and ip.evento_setor_id = es.id and es.evento_id = e.id and p.status = 2 and e.id = $evento";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$quantidade = $dados['quantidade'];
$valorTotal = number_format($dados['valor_total'], 2, ',', '.');
$taxaTotal = number_format($dados['taxa_total'], 2, ',', '.');
$valorGeral = $dados['valor_total'] + $dados['taxa_total'];
$valorGeral = number_format($valorGeral, 2, ',', '.');

$mpdf = new \Mpdf\Mpdf();
date_default_timezone_set('America/Sao_Paulo');
$agora = date('d/m/Y \à\s H:i:s');

$html = "<html>
            <head>
                <title>Relatório Final do Evento | Compre Bilhete - Seu evento começa aqui!!!</title>
            </head>
            <body>
                <p style='text-align:right;font-size: 10px;'>$agora</p>
                <h3 style='text-align:center;'>Relatório Final do Evento</h3>
                <p>Evento - $eventoDescricao</p>
                <p>Data - $eventoData</p>
                <hr>
                <table>
                    <caption>Total Por Setor</caption>
                    <tr>
                        <th style='width:150px'>Setor</th>
                        <th style='width:150px'>Tipo</th>
                        <th style='width:120px'>Qtd Vendida</th>
                        <th style='width:120px'>Taxas</th>
                        <th style='width:120px'>Total s/ Taxas</th>
                    </tr>";

$sql = "select s.descricao as setor,  es.tipo as tipo, sum(ip.quantidade) as quantidade, 
        sum(ip.valor_unitario * ip.quantidade) as valor_total, sum(ip.taxa_unitario * ip.quantidade) taxa_total
        from itens_pedido ip, evento_setor es, evento e, setor s, pedido p
        where ip.pedido_id = p.id and ip.evento_setor_id = es.id and es.evento_id = e.id and 
        es.setor_id = s.id and p.status = 2 and e.id = $evento
        group by s.descricao, es.tipo";

$resultado = mysqli_query($conexao, $sql);
while ($dados = mysqli_fetch_array($resultado)) :

    $taxaTotal2 = number_format($dados['taxa_total'], 2, ',', '.');
    $valorTotal2 = number_format($dados['valor_total'], 2, ',', '.');

    $html .= "<tr>
                <td style='text-align:center;'>{$dados['setor']}</td>
                <td style='text-align:center;'>{$dados['tipo']}</td>
                <td style='text-align:center;'>{$dados['quantidade']}</td>
                <td style='text-align:center;'>R$ $taxaTotal2</td>
                <td style='text-align:center;'>R$ $valorTotal2</td>
            </tr>";
endwhile;

$html .= "</table>
            <hr>
            <table>
                <tr>
                    <th style='width:160px'>Qtd Vendida</th>
                    <th style='width:160px'>Taxas</th>
                    <th style='width:160px'>Total s/ Taxas</th>
                    <th style='width:160px'>Total Geral</th>
                </tr>
                <tr>
                    <td style='text-align:center;'>$quantidade</td>
                    <td style='text-align:center;'>R$ $taxaTotal</td>
                    <td style='text-align:center;'>R$ $valorTotal</td>
                    <td style='text-align:center;'>R$ $valorGeral</td>
                </tr>
            </table>
            <hr><p style='text-align:center;font-size:10px;'>Compre Bilhete - Seu evento começa aqui!!!</p>
        </body>
        </html>";

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
