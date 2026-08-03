<?php
/**
 * The front page template file for Twistshake storefront.
 *
 * @package prestige-child
 */

get_header(); ?>

 	<div id="primary" class="content-area ts-homepage" style="width: 100%; margin: 0; padding: 0; float: none;">
		<main id="main" class="site-main" role="main">

			<!-- Top Hero Banner Slider Section -->
			<?php
			$banners = get_option( 'twistshake_home_banners', array() );
			if ( empty( $banners ) ) {
				if ( function_exists( 'custom_multidomain_get_default_banners' ) ) {
					$banners = custom_multidomain_get_default_banners();
				} else {
					$banners = array(
						array(
							'tag'      => 'NOVIDADE PASSEIO',
							'title'    => 'Carrinhos de Passeio Twistshake',
							'desc'     => 'Leves, dobráveis em 1 segundo e com o conforto máximo para o seu bebé.',
							'btn_text' => 'Descobrir Carrinhos',
							'link'     => home_url( '/categoria-produto/twistshake/carrinhos-de-passeio/' ),
							'img'      => content_url( '/uploads/2026/06/ts_banner_169_carrinhos.png' ),
							'bg'       => 'linear-gradient(135deg, #E6EEF4 0%, #D8E5F0 100%)',
						),
						array(
							'tag'      => 'ALIMENTAÇÃO PRÁTICA',
							'title'    => 'Conjuntos de Refeição Inteligentes',
							'desc'     => 'Pratos Click-Mat antiderramamento, talheres ergonómicos e babetes impermeáveis.',
							'btn_text' => 'Ver Alimentação',
							'link'     => home_url( '/categoria-produto/twistshake/alimentacao/' ),
							'img'      => content_url( '/uploads/2026/06/ts_banner_169_refeicao.png' ),
							'bg'       => 'linear-gradient(135deg, #FFF7E6 0%, #FFEFC6 100%)',
						),
						array(
							'tag'      => 'ANTICÓLICAS & APRENDIZAGEM',
							'title'    => 'Biberões & Copos de Aprendizagem',
							'desc'     => 'Sistema patenteado de rede misturadora e tetinas ultrasuaves livres de BPA.',
							'btn_text' => 'Ver Biberões & Copos',
							'link'     => home_url( '/categoria-produto/twistshake/copos/' ),
							'img'      => content_url( '/uploads/2026/06/ts_banner_169_biberoes.png' ),
							'bg'       => 'linear-gradient(135deg, #F3E8FF 0%, #E6D5FF 100%)',
						),
					);
				}
			}
			?>
			<!-- Hero Banner Slider Section (Main Top Banner) -->
			<?php if ( ! empty( $banners ) ) : ?>
			<style>
				.ts-banner-slider-section {
					margin: 0 0 30px !important;
				}
				.ts-banner-slider-wrapper {
					position: relative !important;
					border-radius: 16px !important;
					overflow: hidden !important;
					box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
					width: 100% !important;
					aspect-ratio: 16 / 9 !important;
					max-height: 520px !important;
					min-height: 380px !important;
				}
				.ts-banner-slider {
					position: relative !important;
					width: 100% !important;
					height: 100% !important;
					min-height: 380px !important;
				}
				.ts-banner-slider-section .ts-slide {
					display: none !important;
					opacity: 0 !important;
					visibility: hidden !important;
					position: absolute !important;
					top: 0 !important;
					left: 0 !important;
					width: 100% !important;
					height: 100% !important;
					align-items: center !important;
					justify-content: space-between !important;
					padding: 35px 50px !important;
					box-sizing: border-box !important;
					transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out !important;
				}
				.ts-banner-slider-section .ts-slide.active {
					display: flex !important;
					opacity: 1 !important;
					visibility: visible !important;
					position: absolute !important;
					top: 0 !important;
					left: 0 !important;
				}
			</style>
			<section class="ts-banner-slider-section">
				<div class="col-full">
					<div class="ts-banner-slider-wrapper">
						<div class="ts-banner-slider" id="tsBannerSlider">
							<?php 
							$bgs = array(
								'linear-gradient(135deg, #E6EEF4 0%, #D8E5F0 100%)',
								'linear-gradient(135deg, #FFF7E6 0%, #FFEFC6 100%)',
								'linear-gradient(135deg, #F3E8FF 0%, #E6D5FF 100%)'
							);
							$tag_bgs = array( '#005492', '#D69E2E', '#7E3AF2' );
							foreach ( $banners as $i => $b ) : 
								$bg = $b['bg'] ?? $bgs[$i % 3];
								$tag_bg = $tag_bgs[$i % 3];
							?>
							<!-- Slide <?php echo $i + 1; ?> -->
							<div class="ts-slide <?php echo $i === 0 ? 'active' : ''; ?>" style="background: <?php echo esc_attr($bg); ?>;">
								<div class="ts-slide-content">
									<?php if ( ! empty( $b['tag'] ) ) : ?>
										<span class="ts-slide-tag" style="background-color: <?php echo esc_attr($tag_bg); ?>;"><?php echo esc_html( $b['tag'] ); ?></span>
									<?php endif; ?>
									<h2 class="ts-slide-title"><?php echo esc_html( $b['title'] ?? '' ); ?></h2>
									<p class="ts-slide-desc"><?php echo esc_html( $b['desc'] ?? '' ); ?></p>
									<?php if ( ! empty( $b['link'] ) && ! empty( $b['btn_text'] ) ) : ?>
										<a href="<?php echo esc_url( $b['link'] ); ?>" class="ts-slide-btn" style="background-color: <?php echo esc_attr($tag_bg); ?>;"><?php echo esc_html( $b['btn_text'] ); ?></a>
									<?php endif; ?>
								</div>
								<?php if ( ! empty( $b['img'] ) ) : ?>
								<div class="ts-slide-image-wrapper">
									<img src="<?php echo esc_url( $b['img'] ); ?>" alt="<?php echo esc_attr( $b['title'] ?? '' ); ?>" class="ts-slide-img">
								</div>
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						</div>

						<!-- Slider Arrows -->
						<button class="ts-slider-arrow ts-slider-prev" id="tsSliderPrev" aria-label="Slide anterior">❮</button>
						<button class="ts-slider-arrow ts-slider-next" id="tsSliderNext" aria-label="Próximo slide">❯</button>

						<!-- Slider Navigation Dots -->
						<div class="ts-slider-dots" id="tsSliderDots">
							<?php foreach ( $banners as $i => $b ) : ?>
								<span class="ts-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</section>
			<?php endif; ?>



			<script>
			document.addEventListener('DOMContentLoaded', function() {
				var slider = document.getElementById('tsBannerSlider');
				if (!slider) return;

				var slides = slider.querySelectorAll('.ts-slide');
				var dots = document.querySelectorAll('.ts-dot');
				var prevBtn = document.getElementById('tsSliderPrev');
				var nextBtn = document.getElementById('tsSliderNext');
				var currentIndex = 0;
				var autoSlideTimer = null;

				function showSlide(index) {
					if (index >= slides.length) index = 0;
					if (index < 0) index = slides.length - 1;

					slides.forEach(function(slide, i) {
						if (i === index) {
							slide.classList.add('active');
						} else {
							slide.classList.remove('active');
						}
					});

					dots.forEach(function(dot, i) {
						if (i === index) {
							dot.classList.add('active');
						} else {
							dot.classList.remove('active');
						}
					});

					currentIndex = index;
				}

				function nextSlide() {
					showSlide(currentIndex + 1);
				}

				function prevSlide() {
					showSlide(currentIndex - 1);
				}

				function startAutoSlide() {
					stopAutoSlide();
					autoSlideTimer = setInterval(nextSlide, 3000);
				}

				function stopAutoSlide() {
					if (autoSlideTimer) clearInterval(autoSlideTimer);
				}

				if (nextBtn) {
					nextBtn.addEventListener('click', function() {
						nextSlide();
						startAutoSlide();
					});
				}

				if (prevBtn) {
					prevBtn.addEventListener('click', function() {
						prevSlide();
						startAutoSlide();
					});
				}

				dots.forEach(function(dot) {
					dot.addEventListener('click', function() {
						var slideIdx = parseInt(this.getAttribute('data-slide'), 10);
						showSlide(slideIdx);
						startAutoSlide();
					});
				});

				var wrapper = slider.closest('.ts-banner-slider-wrapper');
				if (wrapper) {
					wrapper.addEventListener('mouseenter', stopAutoSlide);
					wrapper.addEventListener('mouseleave', startAutoSlide);
				}

				startAutoSlide();
			});
			</script>

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
