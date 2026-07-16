<?php
/**
 * The front page template file for Twistshake storefront.
 *
 * @package prestige-child
 */

get_header(); ?>

	<div id="primary" class="content-area ts-homepage" style="width: 100%; margin: 0; padding: 0; float: none;">
		<main id="main" class="site-main" role="main">

			<!-- Hero Banner -->
			<section class="ts-hero-section">
				<div class="ts-hero-content">
					<span class="ts-hero-tagline">DESIGN SUECO PARA O SEU BEBÉ</span>
					<h1 class="ts-hero-title">Práticos, Seguros e Coloridos</h1>
					<p class="ts-hero-desc">Descubra a gama completa de biberões anticólicas, copos de aprendizagem e carrinhos inovadores da Twistshake.</p>
					<a href="<?php echo esc_url( home_url( '/loja/?store=twistshake' ) ); ?>" class="ts-hero-button">Ver Coleção Completa</a>
				</div>
			</section>

			<!-- Curated Categories Grid -->
			<section class="ts-categories-showcase">
				<div class="col-full">
					<h2 class="ts-section-title">Comprar por Categoria</h2>
					<div class="ts-categories-grid">
						<a href="<?php echo esc_url( get_term_link( 'biberoes', 'product_cat' ) ); ?>" class="ts-cat-card">
							<div class="ts-cat-card-overlay"></div>
							<div class="ts-cat-card-text">
								<h3>Biberões</h3>
								<span>Ver mais &rarr;</span>
							</div>
						</a>
						<a href="<?php echo esc_url( get_term_link( 'copos', 'product_cat' ) ); ?>" class="ts-cat-card">
							<div class="ts-cat-card-overlay"></div>
							<div class="ts-cat-card-text">
								<h3>Copos</h3>
								<span>Ver mais &rarr;</span>
							</div>
						</a>
						<a href="<?php echo esc_url( get_term_link( 'alimentacao', 'product_cat' ) ); ?>" class="ts-cat-card">
							<div class="ts-cat-card-overlay"></div>
							<div class="ts-cat-card-text">
								<h3>Alimentação</h3>
								<span>Ver mais &rarr;</span>
							</div>
						</a>
						<a href="<?php echo esc_url( get_term_link( 'carrinhos', 'product_cat' ) ); ?>" class="ts-cat-card">
							<div class="ts-cat-card-overlay"></div>
							<div class="ts-cat-card-text">
								<h3>Carrinhos</h3>
								<span>Ver mais &rarr;</span>
							</div>
						</a>
					</div>
				</div>
			</section>

			<!-- Products Showcase by category -->
			<div class="ts-home-products">
				<div class="col-full">

					<?php
					// We display main categories that contain Twistshake products
					$ts_categories = array(
						'biberoes' => 'Biberões Anticólicas',
						'copos' => 'Copos de Aprendizagem',
						'alimentacao' => 'Alimentação e Chupetas',
						'carrinhos' => 'Carrinhos de Passeio'
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
