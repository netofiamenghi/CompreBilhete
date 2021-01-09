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

$evento = $_POST['evento'];

$sql = "select descricao, data from evento where id = $evento";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$eventoDescricao = $dados['descricao'];
$eventoData = date('d/m/Y', strtotime($dados['data']));

$mpdf = new \Mpdf\Mpdf();
date_default_timezone_set('America/Sao_Paulo');
$agora = date('d/m/Y \à\s H:i:s');


$sql = "select sum(ip.quantidade) as qtd
        from visitante v, pedido p, itens_pedido ip, evento_setor es, setor s
        where es.evento_id = $evento and s.id = es.setor_id and es.id = ip.evento_setor_id 
        and p.id = ip.pedido_id and p.visitante_id = v.id and p.status = 2";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$qtd = $dados['qtd'];       

$html = "<html>
            <head>
                <title>Relação de Bilhetes Vendidos | Compre Bilhete - Seu evento começa aqui !!!</title>
            </head>
            <body>
                <p style='text-align:right;font-size: 10px;'>$agora</p>
                <h3 style='text-align:center;'>Relação de Bilhetes Vendidos</h3>
                <p>Evento - $eventoDescricao</p>
                <p>Data Evento - $eventoData&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qtd Vendida: $qtd</p>
                <hr>
                <table style='font-size: 12px;'>
                <thead>
                    <tr>
                        <th style='width:120px'>Nome</th>
                        <th style='width:120px'>CPF</th>
                        <th style='width:120px'>Telefone</th>
                        <th style='width:120px'>Quantidade</th>
                        <th style='width:120px'>Tipo</th>
                        <th style='width:120px'>Setor</th>
                    </tr>
                 </thead>";


$sql = "select v.nome, v.cpf, v.cod_area, v.telefone, v.email, p.data, ip.quantidade, es.tipo, s.descricao
        from visitante v, pedido p, itens_pedido ip, evento_setor es, setor s
        where es.evento_id = $evento and s.id = es.setor_id and es.id = ip.evento_setor_id and p.id = ip.pedido_id and 
        p.visitante_id = v.id and p.status = 2 order by s.descricao, es.tipo, v.nome";

$resultado = mysqli_query($conexao, $sql);
while ($dados = mysqli_fetch_array($resultado)) :

    $html .= "<tr>
                 <td style='text-align:center;'> {$dados['nome']} </td>
                 <td style='text-align:center;'> {$dados['cpf']} </td>
                 <td style='text-align:center;'> ({$dados['cod_area']}) {$dados['telefone']} </td>
                 <td style='text-align:center;'> {$dados['quantidade']} </td>
                 <td style='text-align:center;'> {$dados['tipo']}</td>
                 <td style='text-align:center;'> {$dados['descricao']}</td>
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

