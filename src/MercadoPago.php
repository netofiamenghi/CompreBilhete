<?php

#CONJFIGURAÇÕES DO MERCADOPAGO
#-> TROCAR NOTIFICAÇÃO -> https://www.mercadopago.com.br/ipn-notifications
#-> CREDÊNCIAIS -> https://www.mercadopago.com/mlb/account/credentials?type=basic
#-> Detalhes: https://www.mercadopago.com.br/developers/pt/guides/payments/web-payment-checkout/configurations/

// SANDBOX
// define("access_token", "TEST-7098810026792343-091701-747f29d1184a756f7b257ab9f0e14002-33587557");

// PRODUCAO
define("access_token", "APP_USR-7098810026792343-091701-8927348d8a7d7b93cbc4b82c1f85251c-33587557");

define("notification_url", "https://www.comprebilhete.com.br/notificacao.php");

define("success_url", "https://www.comprebilhete.com.br/detalhes");
define("pending_url", "https://www.comprebilhete.com.br/detalhes"); 
define("failure_url", "https://www.comprebilhete.com.br/detalhes");

define("statement_descriptor", "COMPREBILHETE");
