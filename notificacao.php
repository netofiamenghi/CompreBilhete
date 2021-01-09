<?php

include_once('./src/includes.php');

MercadoPago\SDK::setAccessToken(access_token);

$merchant_order = null;

switch ($_GET["topic"]) {
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        break;
    case "merchant_order":
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        break;
}

$paid_amount = 0;

if ($payment->status == 'approved') :
    $paid_amount += $payment->transaction_amount;
endif;

$external_ref = $payment->external_reference;
$status_detail = $payment->status;

if ($paid_amount >= $payment->transaction_amount) {
    if ($merchant_order->shipments > 0) { // The merchant_order has shipments
        if ($merchant_order->shipments[0]->status == "ready_to_ship") {
            print_r("Totally paid. Print the label and release your item.");
        }
    } else { // The merchant_order don't has any shipments
        print_r("Totally paid. Release your item.");


        // apaga pedidos não finalizados com mais de 2 dias inclusos
        $sql = "delete from pedido where status = '0' and data <= (CURDATE() - INTERVAL 2 DAY)";
        mysqli_query($conexao, $sql);

        // envio de e-mail confirmação de pagamento

        $sql = "select v.*, p.email as pedido_email from pedido p, visitante v where p.visitante_id = v.id and p.id = '$external_ref' ";
        $resultado = mysqli_query($conexao, $sql);
        $dados = mysqli_fetch_array($resultado);

        $visitante = $dados['nome'];
        $email = $dados['email'];
        $pedido_email = $dados['pedido_email'];

        if ($pedido_email == 0) :

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
                                <h2>Olá, $visitante</h2>
                                <br>
                                <h3>Recebemos o seu pedido Nº $external_ref, e o seu pagamento foi aprovado!</h3>
                                <br>
                                <h3><a href='https://comprebilhete.com.br/detalhes/$external_ref'>Clique aqui para salvar o(s) seu(s) bilhete(s)</a></h3>
                                <br><br>
                                <h5>Qualquer dúvida entre em contato conosco: atendimento@comprebilhete.com.br</h5>
                                <h5>Esta é uma mensagem gerada automaticamente, portanto não pode ser respondida.</h5>
                                <br>
                                <p><a href='https://www.comprebilhete.com.br' target='_blank'>Compre Bilhete - Seu evento começa aqui!!!</a></p>
                            </body>
                        </html>";

            Email::enviarEmail($email, "Compre Bilhete - Pagamento Aprovado", $mensagem);

        endif;


        // altera status do pedido para PAGO
        $sql = "update pedido set email = '1', status = '2', status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    }
} else {
    print_r("Not paid yet. Do not release your item.");
    // altera status do pedido
    if ($status_detail == 'in_process') :
        $sql = "update pedido set status = '3', status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    elseif ($status_detail == 'rejected') :
        $sql = "update pedido set status = '4', status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    elseif ($status_detail == 'cancelled') :
        $sql = "update pedido set status = '5', status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    elseif ($status_detail == 'refunded') :
        $sql = "update pedido set status = '6', status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    elseif ($status_detail == 'pending') :
        $sql = "update pedido set status = '7', status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    else :
        $sql = "update pedido set status_detail = '$status_detail' where id = '$external_ref'";
        mysqli_query($conexao, $sql);
    endif;
}

// $id = $payment->order->id;
// $sql = "update pedido set payment_status_detail = '$id' where id = '3'";
// mysqli_query($conexao, $sql);
