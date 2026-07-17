<?php
/**
 * The header for the Twistshake storefront.
 *
 * @package prestige-child
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class( 'twistshake-theme' ); ?>>

<?php wp_body_open(); ?>

<div id="page" class="hfeed site">
	
	<!-- Top Bar / Promo Bar -->
	<div class="ts-promo-bar">
		<div class="col-full ts-promo-content">
			<div class="ts-promo-item">
				<span class="ts-promo-icon">🏅</span>
				<span>Loja Oficial Twistshake Portugal</span>
			</div>
			<div class="ts-promo-item">
				<span class="ts-promo-icon">🚚</span>
				<span>Envio grátis em compras superiores a 50€</span>
			</div>
			<div class="ts-promo-item">
				<span class="ts-promo-icon">📦</span>
				<span>Entrega em 24/48h</span>
			</div>
			<div class="ts-promo-item">
				<span class="ts-promo-icon">⭐</span>
				<span>Avaliado 4.9/5 por mais de 2.000 clientes</span>
			</div>
		</div>
	</div>

	<!-- Main Header -->
	<header id="masthead" class="ts-header" role="banner">
		<div class="col-full ts-header-container">
			
			<!-- Logo -->
			<div class="ts-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="ts-logo-link">
					<span class="ts-logo-main">TWISTSHAKE</span>
					<span class="ts-logo-sub">with passion for babies</span>
					<span class="ts-logo-country">PORTUGAL</span>
				</a>
			</div>

			<!-- Search Bar -->
			<div class="ts-search">
				<form role="search" method="get" class="ts-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" class="ts-search-field" placeholder="Procurar produtos Twistshake..." value="<?php echo get_search_query(); ?>" name="s" />
					<button type="submit" class="ts-search-submit">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
					</button>
					<input type="hidden" name="post_type" value="product" />
				</form>
			</div>

			<!-- User & Cart Icons -->
			<div class="ts-icons">
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="ts-icon-link ts-account-icon" title="A Minha Conta">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
				</a>
				
				<?php 
				// Retrieve WooCommerce cart link
				if ( class_exists( 'WooCommerce' ) ) :
					$cart_url = wc_get_cart_url();
					$cart_count = WC()->cart->get_cart_contents_count();
				?>
				<a href="<?php echo esc_url( $cart_url ); ?>" class="ts-icon-link ts-cart-icon" title="Carrinho de Compras">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
					<?php if ( $cart_count > 0 ) : ?>
						<span class="ts-cart-count"><?php echo esc_html( $cart_count ); ?></span>
					<?php endif; ?>
				</a>
				<?php endif; ?>
			</div>

		</div>

		<!-- Navigation Bar -->
		<nav class="ts-nav" role="navigation">
			<div class="col-full">
				<ul class="ts-nav-menu">
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'carrinhos' ) ); ?>">Carrinhos</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'alimentacao' ) ); ?>">Alimentação</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'copos' ) ); ?>">Copos</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'biberoes' ) ); ?>">Biberões</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'banho' ) ); ?>">Banho</a></li>
					<li><a href="<?php echo esc_url( ts_get_term_link_safe( 'acessorios' ) ); ?>">Acessórios</a></li>
					<li><a href="<?php echo esc_url( home_url( '/loja/?store=twistshake&orderby=date' ) ); ?>">Novo</a></li>
					<li><a href="<?php echo esc_url( home_url( '/loja/?store=twistshake&on_sale=1' ) ); ?>" class="ts-promo-link">Promoções</a></li>
				</ul>
			</div>
		</nav>
	</header>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">
