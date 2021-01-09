<!-- start footer Area -->
<script type="text/javascript">
    //<![CDATA[ 
    var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
    document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
    //]]>
</script>

<footer class="footer-area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="single-footer-widget">
                    <h6 id="titulo_rodape" class="text-center">Siga-nos nas redes</h6>
                    <div class="footer-social d-flex justify-content-center align-items-center">
                        <a href="https://www.facebook.com/comprebilhete" target="_blank" title="Página no Facebook">
                            <img src="<?= $raiz ?>img/redes_sociais/face.png" alt="" />
                        </a>
                        <a href="https://www.instagram.com/comprebilhete/" target="_blank" title="Perfil no Instagram">
                            <img src="<?= $raiz ?>img/redes_sociais/insta.png" alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center col-lg-2 col-md-3">
                <div class="single-footer-widget">
                    <h6 id="titulo_rodape">Institucional</h6>
                    <ul id="lista_rodape">
                        <li><a id="link_rodape" href="<?= $raiz ?>inicio">Página Inicial</a></li>
                        <li><a id="link_rodape" href="<?= $raiz ?>contato">Contato</a></li>
                        <!-- <li><a id="link_rodape" href="<?= $raiz ?>duvidas">Dúvidas (FAQ)</a></li> -->
                        <li><a id="link_rodape" href="<?= $raiz ?>termos-uso">Termos de Uso</a></li>
                    </ul>
                </div>
            </div>
            <?php
            if (isset($_SESSION['nomeVisitante'])) :
            ?>
                <div class="d-flex justify-content-center col-lg-2 col-md-3">
                    <div class="single-footer-widget">
                        <h6 id="titulo_rodape">Minha Conta</h6>
                        <ul id="lista_rodape">
                            <li><a id="link_rodape" href="<?= $raiz ?>dados">Meus Dados</a></li>
                            <li><a id="link_rodape" href="<?= $raiz ?>pedidos">Meus Pedidos</a></li>
                        </ul>
                    </div>
                </div>
            <?php
            endif;
            ?>
            <div class="d-flex justify-content-center col-lg-3 col-md-4">
                <div class="single-footer-widget">
                    <div>
                        <img id="logo-rodape" class="footerimg" src="<?= $raiz ?>img/Compre Bilhete Amarelo.png" alt="Logo Compre Bilhete" />
                    </div>
                    <div>
                        <i class="fa fa-copyright" aria-hidden="true">2019 - Todos os direitos reservados</i>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <center>
                    <div class="single-footer-widget">
                        <script language="JavaScript" type="text/javascript">
                            TrustLogo("https://comprebilhete.com.br/img/positivessl_trust_seal_md_167x42.png", "CL1", "none");
                        </script>
                        <a href="https://www.positivessl.com/" id="comodoTL">Positive SSL</a>
                    </div>
                    <div class="single-footer-widget">
                        <img class="img-fluid logo-pagseguro col-lg-12 col-md-10 col-sm-4 col-5" src="https://comprebilhete.com.br/img/mercado-pago-logo.png" />
                    </div>
                </center>
            </div>
        </div>
    </div>
</footer>
<!-- End footer Area -->