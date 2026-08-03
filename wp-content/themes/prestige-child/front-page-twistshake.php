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
					margin: 15px 0 35px !important;
				}
				.ts-banner-slider-wrapper {
					position: relative !important;
					border-radius: 20px !important;
					overflow: hidden !important;
					box-shadow: 0 14px 40px rgba(0,0,0,0.07) !important;
					width: 100% !important;
					aspect-ratio: 16 / 9 !important;
					max-height: 480px !important;
					min-height: 380px !important;
					background-color: #FAF6F0 !important;
					border: 1px solid #EFEAE4 !important;
				}
				.ts-banner-slider {
					position: relative !important;
					width: 100% !important;
					height: 100% !important;
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
					padding: 40px 50px !important;
					box-sizing: border-box !important;
					transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out !important;
				}
				.ts-banner-slider-section .ts-slide.active {
					display: flex !important;
					opacity: 1 !important;
					visibility: visible !important;
				}
				.ts-banner-slider-section .ts-slide-content {
					flex: 0 1 45% !important;
					z-index: 3 !important;
					padding: 35px 40px !important;
					background: rgba(255, 255, 255, 0.88) !important;
					backdrop-filter: blur(14px) !important;
					-webkit-backdrop-filter: blur(14px) !important;
					border-radius: 18px !important;
					box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
					border: 1px solid rgba(255, 255, 255, 0.8) !important;
				}
				.ts-banner-slider-section .ts-slide-tag {
					display: inline-block !important;
					color: #FFFFFF !important;
					font-size: 10px !important;
					font-weight: 700 !important;
					letter-spacing: 0.12em !important;
					padding: 6px 16px !important;
					border-radius: 20px !important;
					margin-bottom: 14px !important;
					text-transform: uppercase !important;
					box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
				}
				.ts-banner-slider-section .ts-slide-title {
					font-size: 32px !important;
					font-weight: 800 !important;
					color: #111111 !important;
					line-height: 1.25 !important;
					margin-bottom: 14px !important;
				}
				.ts-banner-slider-section .ts-slide-desc {
					font-size: 14px !important;
					color: #4B5563 !important;
					line-height: 1.6 !important;
					margin-bottom: 24px !important;
				}
				.ts-banner-slider-section .ts-slide-btn {
					display: inline-flex !important;
					align-items: center !important;
					gap: 8px !important;
					background-color: #111111 !important;
					color: #FFFFFF !important;
					font-size: 13px !important;
					font-weight: 700 !important;
					padding: 13px 30px !important;
					border-radius: 30px !important;
					text-decoration: none !important;
					box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
					transition: all 0.3s ease !important;
				}
				.ts-banner-slider-section .ts-slide-btn:hover {
					transform: translateY(-2px) !important;
					box-shadow: 0 10px 25px rgba(0,0,0,0.25) !important;
					background-color: #005492 !important;
				}
				.ts-banner-slider-section .ts-slide-image-wrapper {
					flex: 0 1 50% !important;
					height: 100% !important;
					display: flex !important;
					justify-content: center !important;
					align-items: center !important;
					z-index: 2 !important;
				}
				.ts-banner-slider-section .ts-slide-img {
					width: 100% !important;
					height: 100% !important;
					max-height: 400px !important;
					object-fit: cover !important;
					border-radius: 14px !important;
					box-shadow: 0 12px 30px rgba(0,0,0,0.1) !important;
					border: 3px solid rgba(255,255,255,0.8) !important;
				}
				/* Navigation Arrows */
				.ts-banner-slider-wrapper .ts-slider-arrow {
					position: absolute !important;
					top: 50% !important;
					transform: translateY(-50%) !important;
					width: 46px !important;
					height: 46px !important;
					background-color: #FFFFFF !important;
					color: #111111 !important;
					border: 1px solid rgba(0,0,0,0.1) !important;
					border-radius: 50% !important;
					font-size: 18px !important;
					font-weight: 800 !important;
					cursor: pointer !important;
					z-index: 99 !important;
					display: flex !important;
					align-items: center !important;
					justify-content: center !important;
					transition: all 0.25s ease !important;
					box-shadow: 0 6px 18px rgba(0,0,0,0.15) !important;
					outline: none !important;
					padding: 0 !important;
				}
				.ts-banner-slider-wrapper .ts-slider-arrow:hover {
					background-color: #111111 !important;
					color: #FFFFFF !important;
					transform: translateY(-50%) scale(1.1) !important;
					box-shadow: 0 8px 24px rgba(0,0,0,0.25) !important;
				}
				.ts-banner-slider-wrapper .ts-slider-prev {
					left: 25px !important;
				}
				.ts-banner-slider-wrapper .ts-slider-next {
					right: 25px !important;
				}

				/* Navigation Dots */
				.ts-banner-slider-wrapper .ts-slider-dots {
					position: absolute !important;
					bottom: 22px !important;
					left: 50% !important;
					transform: translateX(-50%) !important;
					display: flex !important;
					gap: 10px !important;
					z-index: 99 !important;
					background: rgba(255, 255, 255, 0.75) !important;
					backdrop-filter: blur(8px) !important;
					padding: 6px 16px !important;
					border-radius: 20px !important;
					box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
					border: 1px solid rgba(255,255,255,0.8) !important;
				}
				.ts-banner-slider-wrapper .ts-dot {
					width: 10px !important;
					height: 10px !important;
					border-radius: 50% !important;
					background-color: rgba(0,0,0,0.25) !important;
					cursor: pointer !important;
					transition: all 0.3s ease !important;
					display: inline-block !important;
				}
				.ts-banner-slider-wrapper .ts-dot.active {
					background-color: #111111 !important;
					width: 26px !important;
					border-radius: 12px !important;
				}

				@media (max-width: 768px) {
					.ts-banner-slider-wrapper {
						aspect-ratio: auto !important;
						height: auto !important;
						max-height: none !important;
						min-height: 480px !important;
					}
					.ts-banner-slider {
						height: auto !important;
						min-height: 480px !important;
						position: relative !important;
					}
					.ts-banner-slider-section .ts-slide {
						padding: 15px 15px 60px !important;
						position: absolute !important;
						top: 0 !important;
						left: 0 !important;
						width: 100% !important;
						height: 100% !important;
						box-sizing: border-box !important;
					}
					.ts-banner-slider-section .ts-slide.active {
						display: flex !important;
						flex-direction: column !important;
						justify-content: flex-start !important;
						align-items: center !important;
						text-align: center !important;
					}
					.ts-banner-slider-section .ts-slide-image-wrapper {
						flex: 0 0 160px !important;
						width: 100% !important;
						height: 160px !important;
						margin-bottom: 10px !important;
						display: flex !important;
						justify-content: center !important;
						align-items: center !important;
					}
					.ts-banner-slider-section .ts-slide-img {
						max-height: 160px !important;
						width: auto !important;
						max-width: 90% !important;
						object-fit: contain !important;
						border-radius: 12px !important;
						box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
					}
					.ts-banner-slider-section .ts-slide-content {
						flex: 0 0 auto !important;
						width: 100% !important;
						padding: 16px 14px !important;
						margin: 0 !important;
						box-sizing: border-box !important;
						text-align: center !important;
						border-radius: 14px !important;
						background: rgba(255, 255, 255, 0.95) !important;
						box-shadow: 0 8px 25px rgba(0,0,0,0.06) !important;
					}
					.ts-banner-slider-section .ts-slide-title {
						font-size: 18px !important;
						margin-bottom: 6px !important;
						line-height: 1.25 !important;
					}
					.ts-banner-slider-section .ts-slide-desc {
						font-size: 12px !important;
						margin-bottom: 12px !important;
						line-height: 1.35 !important;
					}
					.ts-banner-slider-section .ts-slide-btn {
						font-size: 12px !important;
						padding: 8px 22px !important;
					}
					.ts-banner-slider-wrapper .ts-slider-arrow {
						display: none !important;
					}
					.ts-banner-slider-wrapper .ts-slider-dots {
						bottom: 14px !important;
					}
				}
			</style>
			<section class="ts-banner-slider-section">
				<div class="col-full">
					<div class="ts-banner-slider-wrapper">
						<div class="ts-banner-slider" id="tsBannerSlider">
							<?php 
							$bgs = array(
								'linear-gradient(135deg, #FBF8F5 0%, #F4ECE3 100%)',
								'linear-gradient(135deg, #FFF9F0 0%, #FFF2D6 100%)',
								'linear-gradient(135deg, #F8F5FA 0%, #EFE8F5 100%)'
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
										<a href="<?php echo esc_url( $b['link'] ); ?>" class="ts-slide-btn"><?php echo esc_html( $b['btn_text'] ); ?> →</a>
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
						<button class="ts-slider-arrow ts-slider-prev" id="tsSliderPrev" aria-label="Slide anterior">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
						</button>
						<button class="ts-slider-arrow ts-slider-next" id="tsSliderNext" aria-label="Próximo slide">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
						</button>

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
