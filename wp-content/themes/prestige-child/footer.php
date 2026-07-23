<?php
if ( function_exists( 'custom_multidomain_is_twistshake' ) && custom_multidomain_is_twistshake() ) {
    get_template_part( 'footer', 'twistshake' );
    return;
}

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo" style="background-color: #f4f7f9; border-top: 1px solid #e1e8ed; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
		<div class="col-full">
            <div class="custom-footer-columns">
                
                <!-- Column 1: Logo & Info -->
                <div class="footer-col footer-col-1">
                    <div class="footer-logo">
                        <!-- Simulated Elegant Logo -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#005492" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"></path>
                                <line x1="12" y1="8" x2="12" y2="14"></line>
                                <line x1="9" y1="11" x2="15" y2="11"></line>
                            </svg>
                            <strong style="color:#005492; font-size: 1.6em; letter-spacing: -0.5px;">PRESTIGE<span style="font-weight: 300;">HEALTH</span></strong>
                        </div>
                        <span style="color:#4a6375; font-size: 0.95em; font-weight: 500;">Soluções de Saúde</span>
                    </div>
                    
                    <div class="footer-contact-block">
                        <p class="contact-lead">Tem alguma dúvida? Receba apoio direto</p>
                        <a href="tel:252095673" class="contact-main">252 095 673</a>
                        <a href="mailto:geral@prestigehealth.pt" class="contact-main">geral@prestigehealth.pt</a>
                        <span class="contact-note">(Chamada para a rede fixa nacional)</span>
                    </div>
                </div>

                <!-- Column 2: Empresa -->
                <div class="footer-col footer-col-2">
                    <h3 class="footer-title">Empresa</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url( ts_get_term_link_safe( 'calcado' ) ); ?>">Calçado</a></li>
                        <li><a href="<?php echo esc_url( ts_get_term_link_safe( 'geriatria' ) ); ?>">Geriatria</a></li>
                        <li><a href="<?php echo esc_url( ts_get_term_link_safe( 'produto-medicos-e-hospitalares' ) ); ?>">Produtos Médicos</a></li>
                        <li><a href="<?php echo esc_url( home_url('/termos-e-condicoes/') ); ?>">Termos e Condições</a></li>
                        <li><a href="<?php echo esc_url( home_url('/privacy-policy/') ); ?>">Política de Privacidade</a></li>
                    </ul>
                </div>

                <!-- Column 3: Minha Conta -->
                <div class="footer-col footer-col-3">
                    <h3 class="footer-title">Minha Conta</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url( wc_get_account_endpoint_url('orders') ); ?>">Encomendas</a></li>
                        <li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Carrinho</a></li>
                        <li><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">Finalizar Compra</a></li>
                        <li><a href="<?php echo esc_url( wc_get_account_endpoint_url('edit-address') ); ?>">Morada</a></li>
                        <li><a href="<?php echo esc_url( wc_get_account_endpoint_url('edit-account') ); ?>">Detalhes da conta</a></li>
                    </ul>
                </div>

                <!-- Column 4: Redes Sociais -->
                <div class="footer-col footer-col-4">
                    <h3 class="footer-title">Redes Sociais</h3>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/www.prestigehealth.pt/?locale=pt_PT" class="social-icon" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                        <a href="https://www.instagram.com/prestige.health/" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                    </div>
                </div>

            </div>
		</div><!-- .col-full -->

        <!-- Bottom Bar -->
        <div class="custom-footer-bottom">
            <div class="col-full">
                <div class="copyright-text">
                    2026 PRESTIGE HEALTH &copy; - Todos os direitos reservados
                </div>
                <div class="payment-methods">
                    <img src="<?php echo esc_url( plugins_url( 'multibanco-ifthen-software-gateway-for-woocommerce/images/mbway_banner.svg' ) ); ?>" alt="MB WAY" class="pay-logo">
                    <img src="<?php echo esc_url( plugins_url( 'multibanco-ifthen-software-gateway-for-woocommerce/images/multibanco_banner.svg' ) ); ?>" alt="Multibanco" class="pay-logo">
                    <img src="<?php echo esc_url( plugins_url( 'multibanco-ifthen-software-gateway-for-woocommerce/images/creditcard_banner_and_icon.svg' ) ); ?>" alt="Cartões de Crédito" class="pay-logo">
                </div>
            </div>
        </div>

	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

<style>
/* Import Inter font for elegant typography */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

/* Custom Elegant Footer Styles */
.custom-footer-columns {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 40px;
    padding: 70px 0 50px;
}
.footer-col {
    flex: 1;
    min-width: 220px;
    margin-bottom: 40px;
}
.footer-col-1 {
    flex: 1.5;
    padding-right: 30px;
}
.footer-logo {
    margin-bottom: 30px;
}
.footer-contact-block {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.contact-lead {
    font-size: 14px;
    color: #5c7285;
    margin-bottom: 5px;
    font-weight: 500;
}
.contact-main {
    color: #005492;
    font-size: 17px;
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s ease;
}
.contact-main:hover {
    color: #003d6a;
}
.contact-note {
    color: #8c9ba5;
    font-size: 12px;
    margin-top: 2px;
}

.footer-title {
    color: #005492;
    font-size: 18px;
    margin-bottom: 25px;
    font-weight: 700;
    letter-spacing: -0.3px;
}
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-links li {
    margin-bottom: 15px;
}
.footer-links a {
    color: #5c7285;
    text-decoration: none;
    font-size: 15px;
    font-weight: 400;
    transition: all 0.2s ease;
    display: inline-block;
}
.footer-links a:hover {
    color: #005492;
    transform: translateX(4px);
}

.social-icons {
    display: flex;
    gap: 12px;
}
.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background-color: #005492;
    color: #fff !important;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 84, 146, 0.2);
}
.social-icon:hover {
    background-color: #003d6a;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 84, 146, 0.3);
}

.custom-footer-bottom {
    border-top: 1px solid #e1e8ed;
    padding: 25px 0;
    background-color: #f4f7f9;
}
.custom-footer-bottom .col-full {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
.copyright-text {
    font-size: 13px;
    color: #5c7285;
    font-weight: 500;
}
.payment-methods {
    display: flex;
    align-items: center;
    gap: 15px;
}
.pay-logo {
    height: 24px;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}
.pay-logo:hover {
    opacity: 1;
}

@media (max-width: 768px) {
    .custom-footer-columns {
        flex-direction: column;
        gap: 20px;
    }
    .custom-footer-bottom .col-full {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
}
</style>

</body>
</html>
