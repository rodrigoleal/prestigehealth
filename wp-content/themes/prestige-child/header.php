<?php
if ( function_exists( 'custom_multidomain_is_twistshake' ) && custom_multidomain_is_twistshake() ) {
    get_template_part( 'header', 'twistshake' );
    return;
}

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="facebook-domain-verification" content="7g96kl39amhls4d919wimbbjaz09zq" />

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<style id="ts-icon-resets-inline">
/* Universal Font Awesome and Icon Reset Overrides */
.addresses header.title a,
.woocommerce-Address-title a,
.woocommerce-address-title a,
header.title a.edit,
a.edit,
.edit-address a,
.woocommerce-Address-title a.edit,
.addresses a.edit {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 28px !important;
    height: 28px !important;
    border-radius: 50% !important;
    background-color: #f1f5f9 !important;
    text-indent: -9999px !important;
    overflow: hidden !important;
    position: relative !important;
    transition: all 0.2s ease !important;
    vertical-align: middle !important;
    margin-left: 10px !important;
    border: none !important;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06) !important;
    cursor: pointer !important;
}

.addresses header.title a::before,
.woocommerce-Address-title a::before,
.woocommerce-address-title a::before,
header.title a.edit::before,
a.edit::before,
.edit-address a::before,
.woocommerce-Address-title a.edit::before,
.addresses a.edit::before {
    content: "" !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    width: 14px !important;
    height: 14px !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 1 2 2h14a2 2 0 0 1 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    font-family: inherit !important;
    text-indent: 0 !important;
    transition: all 0.2s ease !important;
}

.addresses header.title a:hover,
.woocommerce-Address-title a:hover,
a.edit:hover {
    background-color: #111111 !important;
}

.addresses header.title a:hover::before,
.woocommerce-Address-title a:hover::before,
a.edit:hover::before {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 1 2 2h14a2 2 0 0 1 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>') !important;
}

.woocommerce-form-row {
    position: relative !important;
}

span.show-password-input,
button.show-password-input,
.show-password-input,
.woocommerce-form-row .show-password-input {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 28px !important;
    height: 28px !important;
    position: absolute !important;
    top: 50% !important;
    right: 12px !important;
    transform: translateY(-50%) !important;
    cursor: pointer !important;
    background: transparent !important;
    border: none !important;
    text-indent: 0 !important;
    overflow: visible !important;
    z-index: 10 !important;
    font-size: 0 !important;
    color: transparent !important;
}

span.show-password-input::after,
button.show-password-input::after,
.show-password-input::after,
.woocommerce-form-row .show-password-input::after {
    content: "" !important;
    display: block !important;
    width: 18px !important;
    height: 18px !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="%2364748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    font-family: inherit !important;
    text-indent: 0 !important;
}

span.show-password-input::before,
button.show-password-input::before,
.show-password-input::before,
.woocommerce-form-row .show-password-input::before {
    display: none !important;
}

span.show-password-input.display-password::after,
button.show-password-input.display-password::after,
.show-password-input.display-password::after,
.woocommerce-form-row .show-password-input.display-password::after {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="%2364748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>') !important;
}

.woocommerce-password-strength::after {
    display: none !important;
}

.my_account_orders .button.view,
.woocommerce-orders-table__cell-order-actions .button.view,
.woocommerce-orders-table__cell-order-actions a.button,
td.order-actions a.button,
a.button.view,
.button.view,
.woocommerce-button.view,
td.woocommerce-orders-table__cell-order-actions a {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 6px 14px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
}

.my_account_orders .button.view::after,
.woocommerce-orders-table__cell-order-actions .button.view::after,
.woocommerce-orders-table__cell-order-actions a.view::after,
td.order-actions a.view::after,
a.button.view::after,
.button.view::after,
.woocommerce-button.view::after,
td.woocommerce-orders-table__cell-order-actions a::after {
    content: "" !important;
    display: inline-block !important;
    width: 14px !important;
    height: 14px !important;
    margin-left: 6px !important;
    vertical-align: middle !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    font-family: inherit !important;
    transition: all 0.2s ease !important;
}

.my_account_orders .button.view:hover::after,
.woocommerce-orders-table__cell-order-actions .button.view:hover::after,
.woocommerce-orders-table__cell-order-actions a.view:hover::after,
td.order-actions a.view:hover::after,
a.button.view:hover::after,
.button.view:hover::after,
.woocommerce-button.view:hover::after,
td.woocommerce-orders-table__cell-order-actions a:hover::after {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>') !important;
}
</style>
</head>


<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header custom-masthead" role="banner">

		<div class="custom-top-bar" style="background-color: #00467a; color: #fff; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
			<div class="col-full" style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 500; align-items: center; font-family: 'Inter', sans-serif;">
				<div class="top-bar-left" style="display: flex; align-items: center;">
					<span style="display: flex; align-items: center; transition: opacity 0.2s;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px; opacity:0.8;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> 252 095 673</span>
					<span style="margin-left: 25px; display: flex; align-items: center;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px; opacity:0.8;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> geral@prestigehealth.pt</span>
				</div>
				<div class="top-bar-right">
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" style="color: #fff; display: flex; align-items: center; text-decoration: none; opacity: 0.9; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> A minha conta</a>
				</div>
			</div>
		</div>

		<div class="custom-middle-bar" style="background-color: #005492; padding: 25px 0;">
			<div class="col-full" style="display: flex; align-items: center; justify-content: space-between;">
				<div class="site-branding" style="flex: 0 0 22%;">
					<?php storefront_site_branding(); ?>
				</div>
				<div class="site-search" style="flex: 0 0 55%; padding: 0 30px;">
					<form role="search" method="get" class="custom-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: flex; margin: 0; width: 100%; border-radius: 30px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
						<input type="search" class="search-field" placeholder="O que procura hoje?" value="<?php echo get_search_query(); ?>" name="s" style="flex-grow: 1; padding: 14px 20px; border: none; font-size: 0.95em; color: #333; background-color: #fff; min-width: 0; outline: none;" />
						<button type="submit" style="background-color: #42a4f4; color: #fff; border: none; padding: 0 25px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; gap: 8px;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
							Pesquisar
						</button>
						<input type="hidden" name="post_type" value="product" />
					</form>
				</div>
				<div class="site-icons" style="flex: 0 0 23%; display: flex; justify-content: flex-end; align-items: center; gap: 25px; color: #fff;">
					<?php storefront_header_cart(); ?>
				</div>
			</div>
		</div>

		<div class="custom-nav-bar" style="background-color: #fff; border-bottom: 1px solid #eee; position: relative; z-index: 999;">
			<div class="col-full" style="display: flex; justify-content: center;">
				<?php storefront_primary_navigation(); ?>
			</div>
		</div>

		<div class="custom-promo-bar" style="background-color: #005492; color: #fff; text-align: center; padding: 12px 0; font-weight: bold; font-size: 14px;">
			Portes grátis para compras superiores a 70€ em Portugal Continental.
		</div>

	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

		<?php
		do_action( 'storefront_content_top' );
