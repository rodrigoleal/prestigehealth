<?php
/**
 * The front page template file for Twistshake storefront.
 *
 * @package prestige-child
 */

get_header(); ?>

	<div id="primary" class="content-area ts-homepage" style="width: 100%; margin: 0; padding: 0; float: none;">
		<main id="main" class="site-main" role="main">

			<!-- Hero Banner Section -->
			<section class="ts-hero-section">
				<div class="col-full ts-hero-container">
					
					<!-- Left Column: Content -->
					<div class="ts-hero-content">
						<span class="ts-hero-tagline">VERÃO CHEGOU ☀️</span>
						<h1 class="ts-hero-title">Design sueco<br>para o dia a dia do seu bebé</h1>
						<p class="ts-hero-desc">Produtos seguros, funcionais e estilosos para cada fase do crescimento.</p>
						<div class="ts-hero-buttons">
							<a href="<?php echo esc_url( home_url( '/loja/?store=twistshake' ) ); ?>" class="ts-hero-btn-primary">Ver Produtos</a>
							<a href="#about" class="ts-hero-btn-secondary">Saber Mais</a>
						</div>
					</div>
					
					<!-- Center Column: Discount Badge -->
					<div class="ts-hero-badge-container">
						<div class="ts-hero-badge">
							<span class="ts-badge-sale">SUMMER SALE</span>
							<span class="ts-badge-ate">ATÉ</span>
							<span class="ts-badge-percentage">-60%</span>
							<span class="ts-badge-extra">+20% EXTRA</span>
							<div class="ts-badge-code">CÓDIGO: VERAO20</div>
						</div>
					</div>
					
					<!-- Right Column: Product Image -->
					<div class="ts-hero-image-container">
						<img src="<?php echo esc_url( content_url( '/uploads/twistshake_hero_bottle.png' ) ); ?>" alt="Twistshake Bottle" class="ts-hero-image">
					</div>
					
				</div>
			</section>

			<!-- Categories Circle Nav Bar -->
			<section class="ts-circles-nav">
				<div class="col-full">
					<div class="ts-circles-container">
						
						<!-- Item 1: Carrinhos -->
						<a href="<?php echo esc_url( ts_get_term_link_safe( 'carrinhos' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #E6EEF4; color: #4B6E8F;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="20" r="2"/><circle cx="18" cy="20" r="2"/><path d="M3 3h2l2 12h11l2-8H7.5"/></svg>
							</div>
							<span class="ts-circle-label">CARRINHOS</span>
						</a>
						
						<!-- Item 2: Alimentação -->
						<a href="<?php echo esc_url( ts_get_term_link_safe( 'alimentacao' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #FFF7E6; color: #D69E2E;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M6 2v10c0 3 2.5 5 5 5v5M18 2v10c0 3-2.5 5-5 5"/></svg>
							</div>
							<span class="ts-circle-label">ALIMENTAÇÃO</span>
						</a>
						
						<!-- Item 3: Copos -->
						<a href="<?php echo esc_url( ts_get_term_link_safe( 'copos' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #E6F4EA; color: #2F855A;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8h1a4 4 0 1 1 0 8h-1M5 8h12v11a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V8z"/><line x1="6" y1="2" x2="16" y2="2"/></svg>
							</div>
							<span class="ts-circle-label">COPOS</span>
						</a>
						
						<!-- Item 4: Biberões -->
						<a href="<?php echo esc_url( ts_get_term_link_safe( 'biberoes' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #F3E8FF; color: #7E3AF2;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 10h6v11a2 2 0 0 1-2 2H11a2 2 0 0 1-2-2V10zM12 2v3M10 5h4v5h-4V5z"/></svg>
							</div>
							<span class="ts-circle-label">BIBERÕES</span>
						</a>
						
						<!-- Item 5: Banho -->
						<a href="<?php echo esc_url( ts_get_term_link_safe( 'banho' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #E6F9FF; color: #007799;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h20M22 12a8 8 0 0 1-16 0M4 12V8a2 2 0 0 1 2-2h3M7 21v-2M17 21v-2"/></svg>
							</div>
							<span class="ts-circle-label">BANHO</span>
						</a>
						
						<!-- Item 6: Acessórios -->
						<a href="<?php echo esc_url( ts_get_term_link_safe( 'acessorios' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #FFEAE6; color: #C53030;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="13" rx="2" ry="2"/><path d="M16 8a4 4 0 0 1-8 0"/></svg>
							</div>
							<span class="ts-circle-label">ACESSÓRIOS</span>
						</a>
						
						<!-- Item 7: Novo -->
						<a href="<?php echo esc_url( home_url( '/loja/?store=twistshake&orderby=date' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #FFE6F0; color: #B83280;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
							</div>
							<span class="ts-circle-label">NOVO</span>
						</a>
						
						<!-- Item 8: Promoções -->
						<a href="<?php echo esc_url( home_url( '/loja/?store=twistshake&on_sale=1' ) ); ?>" class="ts-circle-item">
							<div class="ts-circle-icon-wrapper" style="background-color: #FFE6E6; color: #C53030;">
								<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
							</div>
							<span class="ts-circle-label">PROMOÇÕES</span>
						</a>
						
					</div>
				</div>
			</section>

			<!-- Value Props Bar -->
			<section class="ts-value-props">
				<div class="col-full">
					<div class="ts-value-props-container">
						<div class="ts-val-item">
							<span class="ts-val-icon">🍃</span>
							<div class="ts-val-text">
								<strong>LIVRE DE BPA</strong><br>
								<span>Segurança em cada detalhe</span>
							</div>
						</div>
						<div class="ts-val-item">
							<span class="ts-val-icon">🇸🇪</span>
							<div class="ts-val-text">
								<strong>DESIGN SUECO</strong><br>
								<span>Qualidade e estilo premium</span>
							</div>
						</div>
						<div class="ts-val-item">
							<span class="ts-val-icon">💧</span>
							<div class="ts-val-text">
								<strong>FÁCIL DE LIMPAR</strong><br>
								<span>Mais tempo para o que importa</span>
							</div>
						</div>
						<div class="ts-val-item">
							<span class="ts-val-icon">🥛</span>
							<div class="ts-val-text">
								<strong>ANTIDERRAME</strong><br>
								<span>Para bebés e pais tranquilos</span>
							</div>
						</div>
						<div class="ts-val-item">
							<span class="ts-val-icon">❤️</span>
							<div class="ts-val-text">
								<strong>CRESCE COM O SEU BEBÉ</strong><br>
								<span>Soluções para cada fase</span>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Featured Products (Mais Vendidos) -->
			<section class="ts-home-featured">
				<div class="col-full">
					<div class="ts-featured-header">
						<h2>MAIS VENDIDOS</h2>
						<div class="ts-featured-line"></div>
					</div>
					<?php echo do_shortcode( '[products limit="4" columns="4" orderby="popularity"]' ); ?>
				</div>
			</section>

			<!-- Products Showcase by Category (using correct local slugs) -->
			<div class="ts-home-products">
				<div class="col-full">

					<?php
					// We display main categories that contain Twistshake products
					$ts_categories = array(
						'carrinhos-de-passeio'   => 'Carrinhos de Passeio',
						'alimentacao'            => 'Alimentação',
						'copos'                  => 'Copos de Aprendizagem',
						'biberoes-e-acessorios'  => 'Biberões Anticólicas',
						'banho'                  => 'Banho',
						'chupetas-e-acessorios'  => 'Acessórios e Chupetas'
					);

					foreach ( $ts_categories as $slug => $name ) {
						$term = get_term_by( 'slug', $slug, 'product_cat' );
						
						// Only show the section if the category exists
						if ( $term ) {
							?>
							<div class="ts-category-section">
								<div class="ts-category-header">
									<h2><?php echo esc_html( $name ); ?></h2>
									<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="ts-view-all">Ver todos</a>
								</div>
								<?php echo do_shortcode( '[products category="' . esc_attr( $slug ) . '" limit="4" columns="4"]' ); ?>
							</div>
							<?php
						}
					}
					?>

				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
