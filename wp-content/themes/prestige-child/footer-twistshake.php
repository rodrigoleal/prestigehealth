<?php
/**
 * The footer for the Twistshake storefront.
 *
 * @package prestige-child
 */

?>
		</div><!-- .col-full -->
	</div><!-- #content -->

	<!-- Trust Badges Bar (Footer Top) -->
	<section class="ts-trust-badges">
		<div class="col-full ts-trust-container">
			<div class="ts-badge-item">
				<div class="ts-badge-icon">🚚</div>
				<div class="ts-badge-text">
					<strong>ENVIO RÁPIDO</strong><br>
					<span>Entrega em 24/48h</span>
				</div>
			</div>
			<div class="ts-badge-item">
				<div class="ts-badge-icon">📦</div>
				<div class="ts-badge-text">
					<strong>PORTES GRÁTIS</strong><br>
					<span>Em compras superiores a 50€</span>
				</div>
			</div>
			<div class="ts-badge-item">
				<div class="ts-badge-icon">🛡️</div>
				<div class="ts-badge-text">
					<strong>PAGAMENTO SEGURO</strong><br>
					<span>100% seguro e encriptado</span>
				</div>
			</div>
			<div class="ts-badge-item">
				<div class="ts-badge-icon">🔄</div>
				<div class="ts-badge-text">
					<strong>DEVOLUÇÕES FÁCEIS</strong><br>
					<span>Processo simples e rápido</span>
				</div>
			</div>
			<div class="ts-badge-item">
				<div class="ts-badge-icon">❤️</div>
				<div class="ts-badge-text">
					<strong>APOIO AO CLIENTE</strong><br>
					<span>Suporte dedicado</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Main Footer -->
	<footer id="colophon" class="ts-footer" role="contentinfo">
		<div class="col-full ts-footer-grid">
			
			<!-- Brand Column -->
			<div class="ts-footer-col ts-brand-col">
				<div class="ts-footer-logo">
					<span class="ts-logo-main">TWISTSHAKE</span>
					<span class="ts-logo-sub">with passion for babies</span>
					<span class="ts-logo-country">PORTUGAL</span>
				</div>
				<p class="ts-brand-desc">
					Loja oficial Twistshake Portugal. Design sueco, produtos seguros e funcionais para cada fase do crescimento do seu bebé.
				</p>
				<div class="ts-social-icons">
					<a href="https://instagram.com/twistshakeportugal" target="_blank" class="ts-social-link" rel="noopener"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
					<a href="https://facebook.com/twistshakeportugal" target="_blank" class="ts-social-link" rel="noopener"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
					<a href="https://tiktok.com/@twistshakeportugal" target="_blank" class="ts-social-link" rel="noopener"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg></a>
				</div>
			</div>

			<!-- Categories Column -->
			<div class="ts-footer-col">
				<h3>CATEGORIAS</h3>
				<ul class="ts-footer-links">
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'carrinhos' ) ); ?>">Carrinhos</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'alimentacao' ) ); ?>">Alimentação</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'copos' ) ); ?>">Copos</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'biberoes' ) ); ?>">Biberões</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'banho' ) ); ?>">Banho</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'acessorios' ) ); ?>">Acessórios</a></li>
					<li><a href="<?php echo esc_url( home_url( '/loja/?store=twistshake&orderby=date' ) ); ?>">Novo</a></li>
					<li><a href="<?php echo esc_url( home_url( '/loja/?store=twistshake&on_sale=1' ) ); ?>">Promoções</a></li>
				</ul>
			</div>

			<!-- Help & Support Column -->
			<div class="ts-footer-col">
				<h3>AJUDA E SUPORTE</h3>
				<ul class="ts-footer-links">
					<li><a href="<?php echo esc_url( home_url( '/perguntas-frequentes/' ) ); ?>">Perguntas Frequentes</a></li>
					<li><a href="<?php echo esc_url( home_url( '/envios-e-entregas/' ) ); ?>">Envios e Entregas</a></li>
					<li><a href="<?php echo esc_url( home_url( '/devolucoes-e-trocas/' ) ); ?>">Devoluções e Trocas</a></li>
					<li><a href="<?php echo esc_url( home_url( '/formas-de-pagamento/' ) ); ?>">Formas de Pagamento</a></li>
					<li><a href="<?php echo esc_url( home_url( '/garantia-e-seguranca/' ) ); ?>">Garantia e Segurança</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contactos/' ) ); ?>">Contactos</a></li>
				</ul>
			</div>

			<!-- About Us Column -->
			<div class="ts-footer-col">
				<h3>SOBRE NÓS</h3>
				<ul class="ts-footer-links">
					<li><a href="<?php echo esc_url( home_url( '/a-nossa-historia/' ) ); ?>">A Nossa História</a></li>
					<li><a href="<?php echo esc_url( home_url( '/qualidade-twistshake/' ) ); ?>">Qualidade Twistshake</a></li>
					<li><a href="<?php echo esc_url( home_url( '/sustentabilidade/' ) ); ?>">Sustentabilidade</a></li>
					<li><a href="<?php echo esc_url( home_url( '/distribuidor-oficial/' ) ); ?>">Distribuidor Oficial</a></li>
				</ul>
			</div>

			<!-- Contacts Column -->
			<div class="ts-footer-col ts-contacts-col">
				<h3>CONTACTOS</h3>
				<ul class="ts-footer-contacts">
					<li>
						<span class="ts-contact-icon">✉️</span>
						<a href="mailto:geral@prestigehealth.pt">geral@prestigehealth.pt</a>
					</li>
					<li>
						<span class="ts-contact-icon">📞</span>
						<a href="tel:+351916638570">+351 91 663 85 70</a><br>
						<small class="ts-contact-hours">(Dias úteis 9h - 18h)</small>
					</li>
					<li>
						<span class="ts-contact-icon">💬</span>
						<a href="https://wa.me/351916638570" target="_blank" rel="noopener">WhatsApp</a><br>
						<small class="ts-contact-hours">Resposta rápida</small>
					</li>
				</ul>
			</div>

		</div>

		<!-- Footer Bottom -->
		<div class="ts-footer-bottom">
			<div class="col-full ts-bottom-container">
				
				<!-- Secure Payments -->
				<div class="ts-payment-badges">
					<span class="ts-lock-icon">🔒 Pagamentos 100% Seguros:</span>
					<div class="ts-payment-icons">
						<!-- Display official colorful payment gateway logos -->
						<img src="<?php echo esc_url( content_url( '/plugins/multibanco-ifthen-software-gateway-for-woocommerce/images/mbway_banner.svg' ) ); ?>" alt="MB WAY" class="ts-payment-logo">
						<img src="<?php echo esc_url( content_url( '/plugins/multibanco-ifthen-software-gateway-for-woocommerce/images/multibanco_banner.svg' ) ); ?>" alt="Multibanco" class="ts-payment-logo">
						<img src="<?php echo esc_url( content_url( '/plugins/multibanco-ifthen-software-gateway-for-woocommerce/images/creditcard_banner_and_icon.svg' ) ); ?>" alt="Cartão de Crédito" class="ts-payment-logo">
					</div>
				</div>

				<!-- Distributor Info -->
				<div class="ts-distributor-info">
					<strong>LOJA OFICIAL TWISTSHAKE PORTUGAL</strong><br>
					<span>Distribuído oficialmente em Portugal por:</span>
					<div class="ts-distributor-logo">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#005492" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
						<strong>PRESTIGE HEALTH</strong>
					</div>
				</div>

			</div>
		</div>

		<!-- Copyright & Legal Links -->
		<div class="ts-copyright-bar">
			<div class="col-full ts-copyright-container">
				<span>© <?php echo date('Y'); ?> Twistshake Portugal. Todos os direitos reservados.</span>
				<div class="ts-legal-links">
					<a href="<?php echo esc_url( home_url( '/politica-de-privacidade/' ) ); ?>">Política de Privacidade</a>
					<a href="<?php echo esc_url( home_url( '/termos-e-condicoes/' ) ); ?>">Termos e Condições</a>
					<a href="https://www.livroreclamacoes.pt" target="_blank" rel="noopener">Livro de Reclamações</a>
				</div>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
