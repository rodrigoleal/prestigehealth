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
<style id="ts-header-responsive-inline">
	html, body {
		overflow-x: hidden !important;
		max-width: 100vw !important;
	}

	/* Borderless Vector Pagination Arrows */
	.woocommerce-pagination ul.page-numbers li a.prev,
	.woocommerce-pagination ul.page-numbers li a.next,
	.woocommerce-pagination ul.page-numbers li span.prev,
	.woocommerce-pagination ul.page-numbers li span.next,
	.woocommerce-pagination a.prev,
	.woocommerce-pagination a.next,
	.page-numbers .prev,
	.page-numbers .next {
		background: transparent !important;
		background-color: transparent !important;
		border: none !important;
		box-shadow: none !important;
		outline: none !important;
		color: #111111 !important;
		padding: 6px 10px !important;
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
	}
	.woocommerce-pagination a.prev::before,
	.woocommerce-pagination a.next::before,
	.woocommerce-pagination span.prev::before,
	.woocommerce-pagination span.next::before,
	.page-numbers .prev::before,
	.page-numbers .next::before,
	.woocommerce-pagination a.prev::after,
	.woocommerce-pagination a.next::after,
	.woocommerce-pagination span.prev::after,
	.woocommerce-pagination span.next::after,
	.page-numbers .prev::after,
	.page-numbers .next::after {
		content: none !important;
		display: none !important;
	}
	@media (max-width: 991px) {
		/* Top Bar Mobile */
		.ts-promo-bar {
			padding: 8px 10px !important;
			background-color: #FAF8F5 !important;
			overflow: hidden !important;
		}
		.ts-promo-content {
			display: flex !important;
			flex-direction: row !important;
			flex-wrap: wrap !important;
			justify-content: center !important;
			align-items: center !important;
			gap: 8px 16px !important;
			width: 100% !important;
			max-width: 100% !important;
			margin: 0 auto !important;
		}
		.ts-promo-item {
			display: inline-flex !important;
			align-items: center !important;
			gap: 4px !important;
			font-size: 11px !important;
			white-space: nowrap !important;
		}

		/* Header Mobile Container */
		.ts-header {
			padding-top: 10px !important;
		}
		.ts-header-container {
			display: flex !important;
			flex-direction: column !important;
			align-items: center !important;
			justify-content: center !important;
			padding: 10px 15px 12px !important;
			gap: 12px !important;
			width: 100% !important;
			box-sizing: border-box !important;
		}
		.ts-branding {
			flex: 0 0 auto !important;
			width: 100% !important;
			text-align: center !important;
		}
		.ts-logo-main {
			font-size: 24px !important;
			text-align: center !important;
		}
		.ts-logo-sub, .ts-logo-country {
			text-align: center !important;
		}
		.ts-icons {
			display: flex !important;
			justify-content: center !important;
			gap: 20px !important;
			width: 100% !important;
			margin-top: 2px !important;
		}
		.ts-search {
			flex: 0 0 100% !important;
			width: 100% !important;
			max-width: 100% !important;
			box-sizing: border-box !important;
			order: 3 !important;
		}
		.ts-search-form {
			width: 100% !important;
			display: flex !important;
			box-sizing: border-box !important;
			background-color: #F9F6F0 !important;
			border: 1px solid #EAE5DB !important;
			border-radius: 25px !important;
		}
		.ts-search-field {
			width: 100% !important;
			font-size: 12px !important;
			padding: 8px 14px !important;
			box-sizing: border-box !important;
		}

		/* Mobile Navigation Pills - Multi-row Flex Wrap */
		.ts-nav {
			width: 100% !important;
			background: #FFFFFF !important;
			border-top: 1px solid #EAE5DB !important;
			border-bottom: 1px solid #EAE5DB !important;
			padding: 10px 12px !important;
			box-sizing: border-box !important;
		}
		.ts-nav-menu {
			display: flex !important;
			flex-wrap: wrap !important;
			justify-content: center !important;
			align-items: center !important;
			gap: 8px 10px !important;
			padding: 0 !important;
			margin: 0 !important;
			width: 100% !important;
			list-style: none !important;
		}
		.ts-nav-menu li {
			flex: 0 0 auto !important;
			margin: 0 !important;
		}
		.ts-nav-menu li a {
			font-size: 11px !important;
			white-space: nowrap !important;
			padding: 7px 15px !important;
			display: inline-block !important;
			border-radius: 20px !important;
			background-color: #F9F6F0 !important;
			color: #111111 !important;
			font-weight: 700 !important;
			text-transform: uppercase !important;
			letter-spacing: 0.04em !important;
			box-shadow: 0 2px 5px rgba(0,0,0,0.03) !important;
		}
		.ts-nav-menu li a.ts-promo-link {
			background-color: #FEE2E2 !important;
			color: #D32F2F !important;
		}
	}
</style>
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
				<span>Portes grátis em compras superiores a 70€ para Portugal Continental</span>
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
					<span class="ts-cart-count" <?php if ( $cart_count == 0 ) echo 'style="display:none;"'; ?>><?php echo esc_html( $cart_count ); ?></span>
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
					<li><a href="<?php echo esc_url( home_url( '/shop/?store=twistshake&is_new=1' ) ); ?>">Novo</a></li>
					<li><a href="<?php echo esc_url( home_url( '/shop/?store=twistshake&on_sale=1' ) ); ?>" class="ts-promo-link">Promoções</a></li>
				</ul>
			</div>
		</nav>
	</header>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">
