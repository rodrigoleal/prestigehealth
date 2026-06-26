<?php
/**
 * The front page template file.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area" style="width: 100%; margin: 0; padding: 0; float: none;">
		<main id="main" class="site-main" role="main">

			<!-- Trust Bar -->
			<div class="custom-trust-bar" style="background-color: #f7f9fa; padding: 30px 0; border-bottom: 1px solid #eaeaea;">
				<div class="col-full" style="display: flex; justify-content: space-around; text-align: center; font-size: 14px; color: #555;">
					<div>
						<div style="font-size: 24px; color: #005492; margin-bottom: 10px;">🚚</div>
						<strong style="color: #333;">Envios Rápidos</strong><br>
						Entregas em 24/48h
					</div>
					<div>
						<div style="font-size: 24px; color: #005492; margin-bottom: 10px;">🔒</div>
						<strong style="color: #333;">Pagamento Seguro</strong><br>
						100% Garantido
					</div>
					<div>
						<div style="font-size: 24px; color: #005492; margin-bottom: 10px;">⭐</div>
						<strong style="color: #333;">Qualidade Premium</strong><br>
						As melhores marcas
					</div>
				</div>
			</div>

			<!-- Produtos por Categoria -->
			<div class="custom-home-products" style="padding: 50px 0; background-color: #fff;">
				<div class="col-full">

					<?php
					// Definir as categorias e subcategorias a mostrar na página principal
					$home_categories = array(
						'carrinhos-de-passeio' => 'Carrinhos',
						'calcado' => 'Calçado',
						'alimentacao' => 'Alimentação',
						'chupetas-e-acessorios' => 'Chupetas e Acessórios',
						'doudous' => 'Doudous',
						'produto-medicos-e-hospitalares' => 'Produtos Médicos'
					);

					foreach ( $home_categories as $slug => $name ) {
						$term = get_term_by( 'slug', $slug, 'product_cat' );
						
						// Apenas mostra a secção se a categoria existir e tiver pelo menos 1 produto
						if ( $term && $term->count > 0 ) {
							?>
							<div class="category-section" style="margin-bottom: 50px;">
								<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; border-bottom: 2px solid #eaeaea; padding-bottom: 10px;">
									<h2 style="color: #005492; margin: 0; font-size: 1.8em;"><?php echo esc_html( $name ); ?></h2>
									<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" style="color: #42a4f4; font-weight: 600; text-decoration: none;">Ver mais &rarr;</a>
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
