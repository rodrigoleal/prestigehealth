<?php
/**
 * The footer for the Twistshake storefront.
 *
 * @package prestige-child
 */

?>
		</div><!-- .col-full -->
	</div><!-- #content -->

	<style>
		/* OVERRIDE ALL STOREFRONT THEME DEFAULTS FOR TWISTSHAKE FOOTER */
		footer.ts-footer,
		.site-footer.ts-footer,
		#colophon.ts-footer {
			background-color: #F9F6F0 !important;
			color: #333333 !important;
			font-family: inherit !important;
			padding: 0 !important;
			margin: 0 !important;
			border-top: 1px solid #EAE5DB !important;
		}

		footer.ts-footer *,
		.site-footer.ts-footer * {
			box-sizing: border-box !important;
		}

		/* RESET LISTS & STRIP ALL BULLET DOTS */
		footer.ts-footer ul,
		footer.ts-footer ul.ts-footer-links,
		footer.ts-footer ul.ts-footer-contacts,
		.site-footer ul.ts-footer-links,
		.site-footer ul.ts-footer-contacts {
			list-style: none !important;
			list-style-type: none !important;
			margin: 0 !important;
			padding: 0 !important;
		}

		footer.ts-footer ul li,
		footer.ts-footer ul.ts-footer-links li,
		footer.ts-footer ul.ts-footer-contacts li,
		.site-footer ul.ts-footer-links li,
		.site-footer ul.ts-footer-contacts li {
			list-style: none !important;
			list-style-type: none !important;
			margin: 0 0 12px 0 !important;
			padding: 0 !important;
			background: none !important;
		}

		footer.ts-footer ul li::before,
		footer.ts-footer ul li::after,
		.site-footer ul li::before,
		.site-footer ul li::after {
			content: none !important;
			display: none !important;
		}

		/* FORCE FONT COLOR ON LINKS TO MATCH GENERAL SITE FONTS */
		footer.ts-footer a,
		footer.ts-footer ul.ts-footer-links li a,
		footer.ts-footer ul.ts-footer-contacts li a,
		.site-footer ul.ts-footer-links li a,
		.site-footer ul.ts-footer-contacts li a {
			color: #444444 !important;
			text-decoration: none !important;
			font-size: 13px !important;
			font-weight: 500 !important;
			transition: color 0.2s ease !important;
		}

		footer.ts-footer a:hover,
		footer.ts-footer ul.ts-footer-links li a:hover,
		footer.ts-footer ul.ts-footer-contacts li a:hover {
			color: #111111 !important;
			text-decoration: underline !important;
		}

		footer.ts-footer h3 {
			font-size: 13px !important;
			font-weight: 700 !important;
			letter-spacing: 0.1em !important;
			text-transform: uppercase !important;
			margin: 0 0 25px 0 !important;
			color: #111111 !important;
		}

		/* 3-COLUMN FLEX GRID */
		footer.ts-footer .ts-footer-grid {
			display: flex !important;
			flex-direction: row !important;
			flex-wrap: wrap !important;
			justify-content: space-between !important;
			align-items: flex-start !important;
			gap: 40px !important;
			padding: 60px 0 50px !important;
			width: 100% !important;
			max-width: 1200px !important;
			margin: 0 auto !important;
		}

		footer.ts-footer .ts-footer-col {
			flex: 1 1 240px !important;
			margin: 0 !important;
			float: none !important;
			width: auto !important;
		}

		footer.ts-footer .ts-brand-col {
			flex: 1.4 1 320px !important;
		}

		/* FOOTER BOTTOM BAR FLEX LAYOUT */
		footer.ts-footer .ts-footer-bottom {
			border-top: 1px solid #EAE5DB !important;
			padding: 25px 0 !important;
			background-color: #FFFFFF !important;
			width: 100% !important;
		}

		footer.ts-footer .ts-bottom-container {
			display: flex !important;
			flex-direction: row !important;
			justify-content: space-between !important;
			align-items: center !important;
			flex-wrap: wrap !important;
			gap: 20px !important;
			width: 100% !important;
			max-width: 1200px !important;
			margin: 0 auto !important;
		}

		footer.ts-footer .ts-payment-badges {
			display: flex !important;
			flex-direction: row !important;
			align-items: center !important;
			gap: 12px !important;
		}

		footer.ts-footer img.ts-payment-logo {
			height: 24px !important;
			max-height: 24px !important;
			width: auto !important;
			max-width: 75px !important;
			object-fit: contain !important;
			display: inline-block !important;
			vertical-align: middle !important;
			background-color: #FFFFFF !important;
			padding: 2px 6px !important;
			border-radius: 4px !important;
			border: 1px solid #EAE5DB !important;
		}

		footer.ts-footer .ts-distributor-info {
			display: flex !important;
			flex-direction: column !important;
			align-items: flex-end !important;
			text-align: right !important;
			font-size: 11px !important;
			line-height: 1.4 !important;
		}

		/* COPYRIGHT BAR */
		footer.ts-footer .ts-copyright-bar {
			background-color: #F4EFE6 !important;
			padding: 15px 0 !important;
			font-size: 12px !important;
			color: #666666 !important;
			border-top: 1px solid #EAE5DB !important;
		}

		footer.ts-footer .ts-copyright-container {
			display: flex !important;
			flex-direction: row !important;
			justify-content: space-between !important;
			align-items: center !important;
			flex-wrap: wrap !important;
			gap: 15px !important;
			width: 100% !important;
			max-width: 1200px !important;
			margin: 0 auto !important;
		}
	</style>

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
					<span>Em compras superiores a 70€ (PT Continental)</span>
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
					<li><a href="<?php echo esc_url( home_url( '/shop/?store=twistshake&is_new=1' ) ); ?>">Novo</a></li>
					<li><a href="<?php echo esc_url( home_url( '/shop/?store=twistshake&on_sale=1' ) ); ?>">Promoções</a></li>
				</ul>
			</div>

			<!-- Contacts Column -->
			<div class="ts-footer-col ts-contacts-col">
				<h3>CONTACTOS</h3>
				<ul class="ts-footer-contacts">
					<li>
						<span class="ts-contact-icon">✉️</span>
						<a href="mailto:marketing@prestigehealth.pt">marketing@prestigehealth.pt</a>
					</li>
					<li>
						<span class="ts-contact-icon">📞</span>
						<a href="tel:+351916638570">+351 91 663 85 70</a><br>
						<small class="ts-contact-hours">(Dias úteis 9h - 18h)</small>
					</li>
				</ul>
			</div>

		</div>

		<!-- Footer Bottom -->
		<div class="ts-footer-bottom">
			<div class="col-full ts-bottom-container">
				
				<!-- Secure Payments -->
				<div class="ts-payment-badges">
					<span class="ts-lock-icon" style="font-weight:600; font-size:12px; color:#333;">🔒 Pagamentos 100% Seguros:</span>
					<div class="ts-payment-icons" style="display:flex; align-items:center; gap:8px;">
						<img src="<?php echo esc_url( content_url( '/plugins/multibanco-ifthen-software-gateway-for-woocommerce/images/mbway_banner.svg' ) ); ?>" alt="MB WAY" class="ts-payment-logo" style="height: 24px !important; width: auto !important; max-height: 24px !important; max-width: 75px !important; object-fit: contain;">
						<img src="<?php echo esc_url( content_url( '/plugins/multibanco-ifthen-software-gateway-for-woocommerce/images/multibanco_banner.svg' ) ); ?>" alt="Multibanco" class="ts-payment-logo" style="height: 24px !important; width: auto !important; max-height: 24px !important; max-width: 75px !important; object-fit: contain;">
						<img src="<?php echo esc_url( content_url( '/plugins/multibanco-ifthen-software-gateway-for-woocommerce/images/creditcard_banner_and_icon.svg' ) ); ?>" alt="Cartão de Crédito" class="ts-payment-logo" style="height: 24px !important; width: auto !important; max-height: 24px !important; max-width: 75px !important; object-fit: contain;">
					</div>
				</div>

				<!-- Distributor Info -->
				<div class="ts-distributor-info">
					<strong style="color:#111; font-size:11px;">LOJA OFICIAL TWISTSHAKE PORTUGAL</strong>
					<span style="color:#666; font-size:11px;">Distribuído oficialmente em Portugal por:</span>
					<div class="ts-distributor-logo" style="margin-top: 6px;">
						<a href="https://prestigehealth.pt" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; text-decoration: none;">
							<!-- Official Transparent Vector SVG Logo matching client image (Heart on left, PRESTIGE HEALTH on right) -->
							<svg width="220" height="42" viewBox="0 0 220 42" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 38px; width: auto; background: transparent; display: block;">
								<!-- Heart outline icon on the left side -->
								<g transform="translate(0, 1)">
									<path d="M 20 34 C 17.5 34 11 27.5 5 19.5 C -0.5 12.5 1 4.5 8.5 2.5 C 14.5 1 19.5 4.5 21 7.5 C 22.5 4.5 27.5 1 33.5 2.5 C 40 4.2 42.5 10 41 15" stroke="#0066B2" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
									<rect x="29" y="10" width="8" height="2.6" rx="0.8" fill="#004B87"/>
									<rect x="31.7" y="7.3" width="2.6" height="8" rx="0.8" fill="#004B87"/>
								</g>
								<!-- PRESTIGE (bold dark blue) -->
								<text x="48" y="21" font-family="'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif" font-weight="900" font-size="17" fill="#004B87" letter-spacing="0.2">PRESTIGE</text>
								<!-- HEALTH (lighter blue) -->
								<text x="135" y="21" font-family="'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif" font-weight="400" font-size="17" fill="#3B82A6" letter-spacing="0.2">HEALTH</text>
								<!-- Soluções de Saúde (medium blue title case underneath) -->
								<text x="48" y="35" font-family="'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif" font-weight="500" font-size="11" fill="#0066B2" letter-spacing="0.1">Soluções de Saúde</text>
							</svg>
						</a>
					</div>
				</div>

			</div>
		</div>

		<!-- Copyright & Legal Links -->
		<div class="ts-copyright-bar">
			<div class="col-full ts-copyright-container">
				<span>© <?php echo date('Y'); ?> Twistshake Portugal. Todos os direitos reservados.</span>
				<div class="ts-legal-links" style="display:flex; gap:25px; align-items:center;">
					<a href="<?php echo esc_url( home_url( '/politica-de-privacidade/' ) ); ?>" style="font-weight:600; color:#2D3748 !important; text-decoration:none !important; font-size:13px !important;">Política de Privacidade</a>
					<a href="<?php echo esc_url( home_url( '/termos-e-condicoes/' ) ); ?>" style="font-weight:600; color:#2D3748 !important; text-decoration:none !important; font-size:13px !important;">Termos e Condições</a>
					<a href="https://www.livroreclamacoes.pt" target="_blank" rel="noopener" style="font-weight:600; color:#2D3748 !important; text-decoration:none !important; font-size:13px !important;">Livro de Reclamações</a>
				</div>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
