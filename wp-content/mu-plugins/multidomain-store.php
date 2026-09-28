<?php
/**
 * Plugin Name: Twistshake Multi-Domain Storefront Filter
 * Description: Dynamically filters products, templates, and URLs based on active domain (Prestige Health vs. Twistshake Portugal).
 * Version: 1.0
 * Author: Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * TOGGLE: Set to false to temporarily display & sell Twistshake products on Prestige Health
 * while twistshakeportugal.pt 301 redirect is still active.
 * Set to true to isolate Twistshake products once the domain alias is working.
 */
if ( ! defined( 'CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE' ) ) {
    define( 'CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE', false );
}

/**
 * Add Meta Facebook and Google Search Console Domain Verification Tags globally across all domains.
 */
add_action( 'wp_head', function() {
    echo '<meta name="facebook-domain-verification" content="7g96kl39amhls4d919wimbbjaz09zq" />' . "\n";
    echo '<meta name="google-site-verification" content="350ee7dc820bf150" />' . "\n";
}, 0 );

/**
 * Universal High-Contrast Styles for WooCommerce Notices and Light Backgrounds
 * Injected with priority 99999 to guarantee overrides over any Storefront customizer styles.
 */
add_action( 'wp_head', 'prestige_universal_contrast_styles', 99999 );
add_action( 'wp_footer', 'prestige_universal_contrast_styles', 99999 );
function prestige_universal_contrast_styles() {
    static $printed = false;
    if ( $printed ) {
        return;
    }
    $printed = true;
    ?>
<style id="prestige-universal-notice-contrast-override">
/* Ocultar definitivamente qualquer mensagem antiga de envio para as Ilhas */
.custom-islands-shipping-notice {
    display: none !important;
}

/* === 1. WooCommerce Error Notices === */
.woocommerce-error,
ul.woocommerce-error,
div.woocommerce-error,
.woocommerce-NoticeGroup .woocommerce-error,
.woocommerce-NoticeGroup-checkout .woocommerce-error,
body.twistshake-theme .woocommerce-error,
body.twistshake-theme ul.woocommerce-error {
    background-color: #FEF2F2 !important;
    color: #991B1B !important;
    border: 1px solid #FECACA !important;
    border-left: 5px solid #EF4444 !important;
    border-radius: 8px !important;
    padding: 16px 20px 16px 50px !important;
    font-size: 14px !important;
    line-height: 1.6 !important;
    margin-bottom: 24px !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
    text-shadow: none !important;
}

.woocommerce-error li,
ul.woocommerce-error li,
.woocommerce-NoticeGroup .woocommerce-error li,
.woocommerce-NoticeGroup-checkout .woocommerce-error li,
body.twistshake-theme .woocommerce-error li,
body.twistshake-theme ul.woocommerce-error li,
.woocommerce-error *,
ul.woocommerce-error * {
    color: #991B1B !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    text-shadow: none !important;
}

.woocommerce-error a,
ul.woocommerce-error a,
.woocommerce-error a:hover,
.woocommerce-error strong,
.woocommerce-error b {
    color: #7F1D1D !important;
    font-weight: 700 !important;
    text-decoration: underline !important;
}

.woocommerce-error::before {
    color: #EF4444 !important;
}

/* === 2. WooCommerce Info Notices (Coupon & Login Boxes) === */
.woocommerce-info,
div.woocommerce-info,
.woocommerce-NoticeGroup .woocommerce-info,
.woocommerce-NoticeGroup-checkout .woocommerce-info,
body.twistshake-theme .woocommerce-info,
body.twistshake-theme div.woocommerce-info {
    background-color: #EFF6FF !important;
    color: #1E40AF !important;
    border: 1px solid #BFDBFE !important;
    border-left: 5px solid #3B82F6 !important;
    border-radius: 8px !important;
    padding: 16px 20px 16px 50px !important;
    font-size: 14px !important;
    line-height: 1.6 !important;
    margin-bottom: 24px !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
    text-shadow: none !important;
}

.woocommerce-info *,
div.woocommerce-info *,
body.twistshake-theme .woocommerce-info * {
    color: #1E40AF !important;
    text-shadow: none !important;
}

.woocommerce-info a,
.woocommerce-info a.showcoupon,
.woocommerce-info a.showlogin,
.woocommerce-info a:hover,
body.twistshake-theme .woocommerce-info a {
    color: #1D4ED8 !important;
    font-weight: 700 !important;
    text-decoration: underline !important;
}

.woocommerce-info::before {
    color: #3B82F6 !important;
}

/* === 3. WooCommerce Success Notices === */
.woocommerce-message,
div.woocommerce-message,
.woocommerce-NoticeGroup .woocommerce-message,
.woocommerce-NoticeGroup-checkout .woocommerce-message,
body.twistshake-theme .woocommerce-message {
    background-color: #F0FDF4 !important;
    color: #166534 !important;
    border: 1px solid #BBF7D0 !important;
    border-left: 5px solid #22C55E !important;
    border-radius: 8px !important;
    padding: 16px 20px 16px 50px !important;
    font-size: 14px !important;
    line-height: 1.6 !important;
    margin-bottom: 24px !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
    text-shadow: none !important;
}

.woocommerce-message *,
div.woocommerce-message *,
body.twistshake-theme .woocommerce-message * {
    color: #166534 !important;
    text-shadow: none !important;
}

.woocommerce-message a,
.woocommerce-message a:hover {
    color: #14532D !important;
    font-weight: 700 !important;
    text-decoration: underline !important;
}

.woocommerce-message .button,
.woocommerce-message .button:hover {
    background-color: #166534 !important;
    color: #FFFFFF !important;
}

.woocommerce-message::before {
    color: #22C55E !important;
}

/* === 4. Inline Field Validation Errors on Checkout === */
p.form-row.woocommerce-invalid label,
p.form-row.woocommerce-invalid-required-field label {
    color: #111111 !important;
}

p.form-row.woocommerce-invalid label span.required,
p.form-row.woocommerce-invalid-required-field label span.required {
    color: #EF4444 !important;
}

/* === 5. Payment Methods & Order Review Boxes === */
.woocommerce-checkout #payment div.payment_box {
    background-color: #F8FAFC !important;
    color: #334155 !important;
    border: 1px solid #E2E8F0 !important;
}
.woocommerce-checkout #payment div.payment_box * {
    color: #334155 !important;
}
.woocommerce-checkout #payment div.payment_box::before {
    border-bottom-color: #F8FAFC !important;
}
</style>
    <?php
}


/**
 * Google Analytics 4 (GA4) Tracking — Dynamic by Storefront
 * Twistshake: G-E4VCC4K585 | Prestige Health: G-BBXSN7WY8Q
 */
add_action( 'wp_head', 'prestige_google_analytics_tag', 1 );
function prestige_google_analytics_tag() {
    $is_twistshake = custom_multidomain_is_twistshake();
    $ga4_id = $is_twistshake ? 'G-E4VCC4K585' : 'G-BBXSN7WY8Q';

    if ( empty( $ga4_id ) ) {
        return;
    }
    ?>
<!-- Google Analytics 4 (GA4) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga4_id ); ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo esc_js( $ga4_id ); ?>', {
    'send_page_view': true,
    'cookie_flags': 'SameSite=None;Secure'
  });
</script>
    <?php
}

/**
 * GA4 E-commerce Purchase Event Tracking on Order Completed (Thank You Page)
 */
add_action( 'woocommerce_thankyou', 'prestige_ga4_ecommerce_purchase', 20 );
function prestige_ga4_ecommerce_purchase( $order_id ) {
    if ( ! $order_id ) {
        return;
    }
    
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }
    
    // Prevent duplicate purchase tracking on page refresh
    if ( $order->get_meta( '_ga4_purchase_tracked' ) ) {
        return;
    }
    $order->update_meta_data( '_ga4_purchase_tracked', '1' );
    $order->save();
    
    $items = array();
    foreach ( $order->get_items() as $item_id => $item ) {
        $product = $item->get_product();
        $items[] = array(
            'item_id'   => $product ? ( $product->get_sku() ?: (string) $product->get_id() ) : (string) $item_id,
            'item_name' => $item->get_name(),
            'price'     => (float) ( $item->get_total() / max( 1, $item->get_quantity() ) ),
            'quantity'  => (int) $item->get_quantity(),
        );
    }
    
    $purchase_data = array(
        'transaction_id' => (string) $order->get_order_number(),
        'value'          => (float) $order->get_total(),
        'tax'            => (float) $order->get_total_tax(),
        'shipping'       => (float) $order->get_shipping_total(),
        'currency'       => $order->get_currency(),
        'items'          => $items,
    );
    ?>
<script>
if (typeof gtag === 'function') {
    gtag('event', 'purchase', <?php echo json_encode( $purchase_data ); ?>);
}
</script>
    <?php
}


/**
 * Determine if the current request is for the Twistshake storefront.
 */
function custom_multidomain_is_twistshake() {
    static $is_ts = null;
    if ( null !== $is_ts ) {
        return $is_ts;
    }

    $host = $_SERVER['HTTP_HOST'] ?? '';
    
    // Check domain
    if ( strpos( $host, 'twistshakeportugal.pt' ) !== false || strpos( $host, 'twistshake' ) !== false ) {
        $is_ts = true;
        return true;
    }
    
    // Check URL query parameter
    if ( isset( $_GET['store'] ) ) {
        if ( $_GET['store'] === 'twistshake' ) {
            if ( ! isset( $_COOKIE['store'] ) || $_COOKIE['store'] !== 'twistshake' ) {
                if ( ! headers_sent() ) {
                    @setcookie( 'store', 'twistshake', time() + 3600 * 24 * 30, '/' );
                    $_COOKIE['store'] = 'twistshake';
                }
            }
            $is_ts = true;
            return true;
        } elseif ( $_GET['store'] === 'prestige' ) {
            if ( isset( $_COOKIE['store'] ) ) {
                if ( ! headers_sent() ) {
                    @setcookie( 'store', '', time() - 3600, '/' );
                    unset( $_COOKIE['store'] );
                }
            }
            $is_ts = false;
            return false;
        }
    }
    
    // Check cookie
    if ( isset( $_COOKIE['store'] ) && $_COOKIE['store'] === 'twistshake' ) {
        $is_ts = true;
        return true;
    }
    
    $is_ts = false;
    return false;
}

/**
 * Ensure out-of-stock items remain visible with 'Disponível brevemente' and waitlist notification.
 */
add_filter( 'option_woocommerce_hide_out_of_stock_items', 'custom_multidomain_hide_out_of_stock', 99 );
function custom_multidomain_hide_out_of_stock( $val ) {
    return 'no';
}

/**
 * Dynamically filter site URL and home URL to matching domain.
 */
add_filter( 'option_home', 'custom_multidomain_home_url' );
add_filter( 'option_siteurl', 'custom_multidomain_home_url' );
function custom_multidomain_home_url( $url ) {
    // Avoid running this during WP-CLI or cron unless HTTP_HOST is set
    if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
        return $url;
    }
    
    $host = $_SERVER['HTTP_HOST'];
    $is_twistshake = custom_multidomain_is_twistshake();
    
    if ( $is_twistshake ) {
        // If testing on localhost, keep localhost:port
        if ( strpos( $host, 'localhost' ) !== false || strpos( $host, '127.0.0.1' ) !== false ) {
            return ( is_ssl() ? 'https://' : 'http://' ) . $host;
        }
        return 'https://twistshakeportugal.pt';
    }
    
    return $url;
}

/**
 * Disable canonical redirects on Twistshake domain to prevent WordPress from redirecting to siteurl option in DB.
 */
add_filter( 'redirect_canonical', 'custom_multidomain_prevent_canonical_redirect', 10, 2 );
function custom_multidomain_prevent_canonical_redirect( $redirect_url, $requested_url ) {
    if ( custom_multidomain_is_twistshake() ) {
        return false;
    }
    return $redirect_url;
}

/**
 * Dynamically filter site name, description, and title parts for Twistshake Portugal.
 */
add_filter( 'option_blogname', 'custom_multidomain_blogname' );
function custom_multidomain_blogname( $name ) {
    if ( custom_multidomain_is_twistshake() ) {
        return 'Twistshake Portugal';
    }
    return $name;
}

add_filter( 'option_blogdescription', 'custom_multidomain_blogdescription' );
function custom_multidomain_blogdescription( $description ) {
    if ( custom_multidomain_is_twistshake() ) {
        return 'With passion for babies';
    }
    return $description;
}

add_filter( 'document_title_parts', 'custom_multidomain_document_title_parts' );
function custom_multidomain_document_title_parts( $parts ) {
    if ( custom_multidomain_is_twistshake() && is_array( $parts ) ) {
        $parts['site'] = 'Twistshake Portugal';
        if ( is_front_page() || is_home() ) {
            $parts['tagline'] = 'With passion for babies';
        }
    }
    return $parts;
}

/**
 * Force front-page-twistshake.php template on Twistshake homepage.
 */
add_filter( 'template_include', 'custom_multidomain_front_page_template', 999 );
function custom_multidomain_front_page_template( $template ) {
    if ( custom_multidomain_is_twistshake() && ( is_front_page() || is_home() ) ) {
        $ts_front = get_stylesheet_directory() . '/front-page-twistshake.php';
        if ( file_exists( $ts_front ) ) {
            return $ts_front;
        }
    }
    return $template;
}

/**
 * Helper function to apply product tax query filters.
 */
function custom_apply_product_visibility_filter( $q, $is_twistshake ) {
    $tax_query = (array) $q->get( 'tax_query' );
    $category_slug = 'twistshake';
    
    if ( $is_twistshake ) {
        // ONLY show Twistshake products
        $tax_query[] = array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => array( $category_slug ),
            'operator'         => 'IN',
            'include_children' => true,
        );
        $q->set( 'tax_query', $tax_query );
    } elseif ( defined( 'CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE' ) && CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE ) {
        // EXCLUDE Twistshake products from main site only if constant is true
        $tax_query[] = array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => array( $category_slug ),
            'operator'         => 'NOT IN',
            'include_children' => true,
        );
        $q->set( 'tax_query', $tax_query );
    }
}

/**
 * Filter main product queries (archives, search, categories, on_sale).
 */
add_action( 'pre_get_posts', 'custom_multidomain_pre_get_posts', 99 );
function custom_multidomain_pre_get_posts( $q ) {
    if ( is_admin() ) {
        return;
    }
    
    // Filter by on_sale=1 parameter
    if ( isset( $_GET['on_sale'] ) && '1' === (string) $_GET['on_sale'] && $q->is_main_query() ) {
        $on_sale_ids = function_exists( 'wc_get_product_ids_on_sale' ) ? wc_get_product_ids_on_sale() : array();
        if ( empty( $on_sale_ids ) ) {
            $on_sale_ids = array( 0 );
        }
        $q->set( 'post__in', $on_sale_ids );
    }

    // Filter by is_new=1 parameter (STRICT: only products explicitly marked as new)
    if ( isset( $_GET['is_new'] ) && '1' === (string) $_GET['is_new'] && $q->is_main_query() ) {
        $meta_query = (array) $q->get( 'meta_query' );
        $meta_query[] = array(
            'key'     => '_ts_is_new_launch',
            'value'   => '1',
            'compare' => '=',
        );
        $q->set( 'meta_query', $meta_query );
    }

    $post_types = (array) $q->get( 'post_type' );
    if ( in_array( 'product', $post_types ) || ( function_exists( 'is_shop' ) && is_shop() ) ) {
        // Skip single product pages and single post fetches
        if ( $q->is_single() || $q->is_singular() || $q->get( 'p' ) ) {
            return;
        }
        
        $is_twistshake = custom_multidomain_is_twistshake();
        custom_apply_product_visibility_filter( $q, $is_twistshake );
    }
}

/**
 * Filter shop page title to 'Promoções' or 'Novidades & Lançamentos' when filters are active.
 */
add_filter( 'woocommerce_page_title', 'custom_multidomain_woocommerce_page_title' );
function custom_multidomain_woocommerce_page_title( $title ) {
    if ( isset( $_GET['on_sale'] ) && '1' === (string) $_GET['on_sale'] ) {
        return 'Promoções';
    }
    if ( isset( $_GET['is_new'] ) && '1' === (string) $_GET['is_new'] ) {
        return 'Novidades & Lançamentos';
    }
    return $title;
}

/**
 * Add 'Novo / Lançamento' checkbox in WooCommerce Product Data > General metabox.
 */
add_action( 'woocommerce_product_options_general_product_data', 'custom_add_new_launch_product_field' );
function custom_add_new_launch_product_field() {
    echo '<div class="options_group">';
    woocommerce_wp_checkbox( array(
        'id'          => '_ts_is_new_launch',
        'label'       => 'Marcar como Novo / Lançamento 🏷️',
        'description' => 'Exibe o selo "NOVO" no produto e destaca-o na página de Novidades.',
    ) );
    echo '</div>';

    echo '<div class="options_group">';
    woocommerce_wp_text_input( array(
        'id'          => '_ts_color_group',
        'label'       => 'Grupo de Cores / Modelo 🎨',
        'placeholder' => 'ex: biberon-anticolicas-180ml',
        'description' => 'Insira o mesmo código/slug para agrupar produtos com cores diferentes.',
        'desc_tip'    => true,
    ) );
    woocommerce_wp_text_input( array(
        'id'          => '_ts_color_name',
        'label'       => 'Nome da Cor deste Produto 🏷️',
        'placeholder' => 'ex: Preto, Rosa, Pastel Blue',
        'description' => 'Nome da cor exibido ao passar o cursor na miniatura (opcional).',
        'desc_tip'    => true,
    ) );
    echo '</div>';
}

/**
 * Save 'Novo / Lançamento' & 'Grupo de Cores' fields on product save.
 */
add_action( 'woocommerce_process_product_meta', 'custom_save_new_launch_product_field' );
function custom_save_new_launch_product_field( $post_id ) {
    $is_new = isset( $_POST['_ts_is_new_launch'] ) ? '1' : '0';
    update_post_meta( $post_id, '_ts_is_new_launch', $is_new );

    if ( isset( $_POST['_ts_color_group'] ) ) {
        update_post_meta( $post_id, '_ts_color_group', sanitize_text_field( $_POST['_ts_color_group'] ) );
    }
    if ( isset( $_POST['_ts_color_name'] ) ) {
        update_post_meta( $post_id, '_ts_color_name', sanitize_text_field( $_POST['_ts_color_name'] ) );
    }
}

/**
 * Display Color Swatches on Single Product Page for products sharing the same _ts_color_group.
 */
add_action( 'woocommerce_before_add_to_cart_form', 'custom_display_product_color_group_swatches', 15 );
function custom_display_product_color_group_swatches() {
    global $product;
    if ( ! $product ) {
        return;
    }

    $current_id  = $product->get_id();
    $color_group = get_post_meta( $current_id, '_ts_color_group', true );

    if ( empty( $color_group ) ) {
        return;
    }

    // Query published products in the same color group
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 50,
        'meta_query'     => array(
            array(
                'key'     => '_ts_color_group',
                'value'   => $color_group,
                'compare' => '=',
            ),
        ),
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    $group_query = new WP_Query( $args );

    if ( ! $group_query->have_posts() || $group_query->post_count < 2 ) {
        wp_reset_postdata();
        return;
    }

    $current_color_name = get_post_meta( $current_id, '_ts_color_name', true );
    if ( empty( $current_color_name ) ) {
        $current_color_name = $product->get_attribute( 'pa_cor' );
        if ( empty( $current_color_name ) ) {
            $current_color_name = $product->get_attribute( 'cor' );
        }
    }

    echo '<div class="ts-color-swatches-wrapper">';
    echo '<div class="ts-color-swatches-header">';
    echo '<span class="ts-color-swatches-title">COR:</span> ';
    if ( ! empty( $current_color_name ) ) {
        echo '<span class="ts-color-swatches-active-label">' . esc_html( mb_strtoupper( $current_color_name, 'UTF-8' ) ) . '</span>';
    }
    echo '</div>';
    echo '<div class="ts-color-swatches-list">';

    while ( $group_query->have_posts() ) {
        $group_query->the_post();
        $item_id      = get_the_ID();
        $item_product = wc_get_product( $item_id );
        if ( ! $item_product ) {
            continue;
        }

        $is_active = ( $item_id === $current_id );
        $permalink = get_permalink( $item_id );

        // Color label
        $color_name = get_post_meta( $item_id, '_ts_color_name', true );
        if ( empty( $color_name ) ) {
            $color_name = $item_product->get_attribute( 'pa_cor' );
            if ( empty( $color_name ) ) {
                $color_name = $item_product->get_attribute( 'cor' );
            }
            if ( empty( $color_name ) ) {
                $color_name = get_the_title( $item_id );
            }
        }

        $is_in_stock = $item_product->is_in_stock();

        // Image URL
        $thumb_id  = $item_product->get_image_id();
        $thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : wc_placeholder_img_src( 'woocommerce_thumbnail' );

        $active_class = $is_active ? ' ts-color-swatch-active' : '';
        $stock_class  = ! $is_in_stock ? ' ts-color-swatch-outofstock' : '';

        echo '<div class="ts-color-swatch-card-wrap">';
        echo '<a href="' . esc_url( $permalink ) . '" class="ts-color-swatch-item' . $active_class . $stock_class . '" title="' . esc_attr( $color_name ) . '" aria-label="' . esc_attr( $color_name ) . '">';
        echo '<div class="ts-color-swatch-img-box">';
        echo '<img src="' . esc_url( $thumb_url ) . '" alt="' . esc_attr( $color_name ) . '" class="ts-color-swatch-img" />';
        echo '</div>';
        echo '</a>';
        if ( ! $is_in_stock ) {
            echo '<span class="ts-color-swatch-stock-label"><span class="ts-stock-dot"></span> Esgotado</span>';
        }
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';

    wp_reset_postdata();
}

/**
 * Localhost fallback for missing upload images (proxies missing images to production server).
 */
add_filter( 'wp_get_attachment_url', 'custom_local_image_fallback_to_prod', 20, 2 );
add_filter( 'wp_get_attachment_image_src', 'custom_local_image_src_fallback_to_prod', 20, 4 );

function custom_local_image_fallback_to_prod( $url, $post_id ) {
    if ( empty( $url ) ) {
        return $url;
    }
    $uploads = wp_upload_dir();
    if ( false !== strpos( $url, $uploads['baseurl'] ) ) {
        $relative   = str_replace( $uploads['baseurl'], '', $url );
        $local_path = $uploads['basedir'] . $relative;
        if ( ! file_exists( $local_path ) ) {
            return 'https://loja.prestigehealth.pt/wp-content/uploads' . $relative;
        }
    }
    return $url;
}

function custom_local_image_src_fallback_to_prod( $image, $attachment_id, $size, $icon ) {
    if ( ! is_array( $image ) || empty( $image[0] ) ) {
        return $image;
    }
    $uploads = wp_upload_dir();
    if ( false !== strpos( $image[0], $uploads['baseurl'] ) ) {
        $relative   = str_replace( $uploads['baseurl'], '', $image[0] );
        $local_path = $uploads['basedir'] . $relative;
        if ( ! file_exists( $local_path ) ) {
            $image[0] = 'https://loja.prestigehealth.pt/wp-content/uploads' . $relative;
        }
    }
    return $image;
}

/**
 * Add 'Novo' column to Products admin table.
 */
add_filter( 'manage_edit-product_columns', 'custom_add_new_launch_product_column', 20 );
function custom_add_new_launch_product_column( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $column ) {
        $new_columns[$key] = $column;
        if ( 'name' === $key ) {
            $new_columns['ts_is_new'] = 'Novo';
        }
    }
    return $new_columns;
}

add_action( 'admin_head', 'custom_new_launch_column_css' );
function custom_new_launch_column_css() {
    echo '<style>.column-ts_is_new { width: 75px !important; text-align: center !important; }</style>';
}

/**
 * Render content for 'Novo / Lançamento' column in Products admin table.
 */
add_action( 'manage_product_posts_custom_column', 'custom_render_new_launch_product_column', 10, 2 );
function custom_render_new_launch_product_column( $column, $post_id ) {
    if ( 'ts_is_new' === $column ) {
        $is_new = get_post_meta( $post_id, '_ts_is_new_launch', true );
        if ( '1' === $is_new ) {
            echo '<span style="display:inline-block; background:#111; color:#fff; font-weight:bold; font-size:11px; padding:3px 8px; border-radius:10px;">⭐ NOVO</span>';
        } else {
            echo '<span style="color:#999;">—</span>';
        }
    }
}

/**
 * Add Bulk Actions to Products list in WP-Admin.
 */
add_filter( 'bulk_actions-edit-product', 'custom_register_new_launch_bulk_actions' );
function custom_register_new_launch_bulk_actions( $bulk_actions ) {
    $bulk_actions['ts_mark_as_new'] = '🏷️ Marcar como Novo / Lançamento';
    $bulk_actions['ts_unmark_as_new'] = '❌ Desmarcar Novo / Lançamento';
    return $bulk_actions;
}

/**
 * Handle Bulk Actions for 'Novo / Lançamento'.
 */
add_filter( 'handle_bulk_actions-edit-product', 'custom_handle_new_launch_bulk_actions', 10, 3 );
function custom_handle_new_launch_bulk_actions( $redirect_to, $action, $post_ids ) {
    if ( 'ts_mark_as_new' === $action ) {
        foreach ( $post_ids as $post_id ) {
            update_post_meta( $post_id, '_ts_is_new_launch', '1' );
        }
        $redirect_to = add_query_arg( 'ts_new_marked', count( $post_ids ), $redirect_to );
    } elseif ( 'ts_unmark_as_new' === $action ) {
        foreach ( $post_ids as $post_id ) {
            update_post_meta( $post_id, '_ts_is_new_launch', '0' );
        }
        $redirect_to = add_query_arg( 'ts_new_unmarked', count( $post_ids ), $redirect_to );
    }
    return $redirect_to;
}

/**
 * Display admin notice after bulk action.
 */
add_action( 'admin_notices', 'custom_new_launch_bulk_action_notice' );
function custom_new_launch_bulk_action_notice() {
    if ( ! empty( $_REQUEST['ts_new_marked'] ) ) {
        $count = intval( $_REQUEST['ts_new_marked'] );
        echo '<div class="updated notice is-dismissible"><p><strong>' . $count . ' produto(s) marcado(s) como Novo / Lançamento com sucesso! ⭐</strong></p></div>';
    }
    if ( ! empty( $_REQUEST['ts_new_unmarked'] ) ) {
        $count = intval( $_REQUEST['ts_new_unmarked'] );
        echo '<div class="updated notice is-dismissible"><p><strong>' . $count . ' produto(s) desmarcado(s) com sucesso.</strong></p></div>';
    }
}

/**
 * Display "NOVO" badge on product catalog loops.
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'custom_display_new_launch_badge', 9 );
function custom_display_new_launch_badge() {
    global $product;
    if ( ! $product ) {
        return;
    }
    $is_new = $product->get_meta( '_ts_is_new_launch' );
    if ( '1' === $is_new ) {
        echo '<span class="ts-new-badge">NOVO</span>';
    }
}

/**
 * Filter WooCommerce native product queries (widgets, shortcodes, related).
 */
add_action( 'woocommerce_product_query', 'custom_multidomain_woocommerce_product_query' );
function custom_multidomain_woocommerce_product_query( $q ) {
    $is_twistshake = custom_multidomain_is_twistshake();
    custom_apply_product_visibility_filter( $q, $is_twistshake );
}

/**
 * Filter shortcode query args to vary transient keys (md5 hashes) by domain.
 */
add_filter( 'woocommerce_shortcode_products_query', 'custom_multidomain_shortcode_products_query', 10, 3 );
function custom_multidomain_shortcode_products_query( $query_args, $attributes, $type ) {
    $query_args['store'] = custom_multidomain_is_twistshake() ? 'twistshake' : 'prestige';
    return $query_args;
}

/**
 * Filter WooCommerce CPT data store queries (wc_get_products, etc.).
 */
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'custom_multidomain_cpt_products_query', 10, 2 );
function custom_multidomain_cpt_products_query( $query, $query_vars ) {
    if ( is_admin() ) {
        return $query;
    }
    
    // Skip if fetching a specific product ID
    if ( ! empty( $query_vars['post__in'] ) || ! empty( $query_vars['p'] ) ) {
        return $query;
    }
    
    $is_twistshake = custom_multidomain_is_twistshake();
    $category_slug = 'twistshake';
    
    $tax_query = isset( $query['tax_query'] ) ? $query['tax_query'] : array();
    
    if ( $is_twistshake ) {
        $tax_query[] = array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => array( $category_slug ),
            'operator'         => 'IN',
            'include_children' => true,
        );
        $query['tax_query'] = $tax_query;
    } elseif ( defined( 'CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE' ) && CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE ) {
        $tax_query[] = array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => array( $category_slug ),
            'operator'         => 'NOT IN',
            'include_children' => true,
        );
        $query['tax_query'] = $tax_query;
    }
    
    return $query;
}

/**
 * Filter product_cat taxonomy terms by store (Prestige Health vs Twistshake).
 */
add_filter( 'terms_clauses', 'custom_multidomain_filter_terms_clauses', 10, 3 );
function custom_multidomain_filter_terms_clauses( $clauses, $taxonomies, $args ) {
    if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return $clauses;
    }
    
    // Only filter if product_cat is in the queried taxonomies
    if ( ! in_array( 'product_cat', (array) $taxonomies, true ) ) {
        return $clauses;
    }
    
    static $twistshake_term_ids = null;
    static $fetching = false;
    
    if ( $fetching ) {
        return $clauses;
    }
    
    if ( null === $twistshake_term_ids ) {
        $fetching = true;
        remove_filter( 'terms_clauses', 'custom_multidomain_filter_terms_clauses', 10 );
        
        $parent_term = get_term_by( 'slug', 'twistshake', 'product_cat' );
        if ( $parent_term && ! is_wp_error( $parent_term ) ) {
            $children_ids = get_term_children( $parent_term->term_id, 'product_cat' );
            if ( is_wp_error( $children_ids ) ) {
                $children_ids = array();
            }
            $twistshake_term_ids = array_merge( array( $parent_term->term_id ), $children_ids );
        } else {
            $twistshake_term_ids = array();
        }
        
        add_filter( 'terms_clauses', 'custom_multidomain_filter_terms_clauses', 10, 3 );
        $fetching = false;
    }
    
    if ( empty( $twistshake_term_ids ) ) {
        return $clauses;
    }
    
    $is_twistshake = custom_multidomain_is_twistshake();
    $id_list = implode( ',', array_map( 'intval', $twistshake_term_ids ) );
    
    if ( $is_twistshake ) {
        // Twistshake store: include ONLY Twistshake category and its children
        $clauses['where'] .= " AND t.term_id IN ($id_list)";
    } elseif ( defined( 'CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE' ) && CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE ) {
        // Prestige store: EXCLUDE Twistshake category and its children only if constant is true
        $clauses['where'] .= " AND t.term_id NOT IN ($id_list)";
    }
    
    return $clauses;
}

/**
 * Dynamically hide Twistshake menu items on the Prestige Health domain.
 */
add_filter( 'wp_get_nav_menu_items', 'custom_multidomain_filter_menu_items', 10, 3 );
function custom_multidomain_filter_menu_items( $items, $menu, $args ) {
    if ( is_admin() ) {
        return $items;
    }
    
    $is_twistshake = custom_multidomain_is_twistshake();
    
    // Hide Twistshake links from Prestige Health only if constant is true
    if ( ! $is_twistshake && defined( 'CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE' ) && CUSTOM_HIDE_TWISTSHAKE_ON_PRESTIGE && is_array( $items ) ) {
        $exclude_ids = array();
        
        // Find the Twistshake item
        foreach ( $items as $item ) {
            if ( $item->title === 'Twistshake' || $item->db_id == 734 ) {
                $exclude_ids[] = $item->db_id;
            }
        }
        
        // Recursively exclude descendants
        if ( ! empty( $exclude_ids ) ) {
            $count = 0;
            do {
                $added = false;
                foreach ( $items as $item ) {
                    if ( in_array( $item->menu_item_parent, $exclude_ids ) && ! in_array( $item->db_id, $exclude_ids ) ) {
                        $exclude_ids[] = $item->db_id;
                        $added = true;
                    }
                }
                $count++;
            } while ( $added && $count < 5 );
            
            $filtered_items = array();
            foreach ( $items as $item ) {
                if ( ! in_array( $item->db_id, $exclude_ids ) ) {
                    $filtered_items[] = $item;
                }
            }
            return $filtered_items;
        }
    }
    
    return $items;
}

/**
 * Tag checkout orders with the domain source.
 */
add_action( 'woocommerce_checkout_create_order', 'custom_multidomain_tag_order', 10, 2 );
function custom_multidomain_tag_order( $order, $data ) {
    $is_twistshake = custom_multidomain_is_twistshake();
    $source = $is_twistshake ? 'twistshakeportugal.pt' : 'loja.prestigehealth.pt';
    $order->update_meta_data( '_order_source_domain', $source );
}

/**
 * Safe wrapper for get_term_link to prevent fatal errors when category slugs are missing/different between local and prod.
 */
function ts_get_term_link_safe( $slug, $taxonomy = 'product_cat' ) {
    $link = get_term_link( $slug, $taxonomy );
    if ( ! is_wp_error( $link ) && is_string( $link ) ) {
        return $link;
    }
    
    // Fallbacks for local vs production differences
    $fallbacks = array(
        'carrinhos'   => 'carrinhos-de-passeio',
        'biberoes'    => 'biberoes-e-acessorios',
        'acessorios'  => 'chupetas-e-acessorios',
    );
    
    if ( isset( $fallbacks[ $slug ] ) ) {
        $fallback_link = get_term_link( $fallbacks[ $slug ], $taxonomy );
        if ( ! is_wp_error( $fallback_link ) && is_string( $fallback_link ) ) {
            return $fallback_link;
        }
    }
    
    return '#';
}

/**
 * Update Twistshake cart count dynamically via AJAX.
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'custom_multidomain_cart_link_fragment', 10, 1 );
function custom_multidomain_cart_link_fragment( $fragments ) {
    ob_start();
    $cart_count = ( WC() && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
    ?>
    <span class="ts-cart-count" <?php if ( $cart_count == 0 ) echo 'style="display:none;"'; ?>><?php echo esc_html( $cart_count ); ?></span>
    <?php
    $fragments['span.ts-cart-count'] = ob_get_clean();
    return $fragments;
}

/**
 * Isolate WooCommerce session cookies for Twistshake and Prestige Health.
 */
add_filter( 'woocommerce_cookie', 'custom_multidomain_session_cookie_name', 10, 1 );
function custom_multidomain_session_cookie_name( $cookie_name ) {
    $suffix = custom_multidomain_is_twistshake() ? '_twistshake' : '_prestige';
    return $cookie_name . $suffix;
}

/**
 * Isolate user persistent cart metadata by store.
 */
add_filter( 'get_user_metadata', 'custom_multidomain_get_user_persistent_cart', 10, 5 );
function custom_multidomain_get_user_persistent_cart( $value, $object_id, $meta_key, $single, $meta_type ) {
    $target_key = '_woocommerce_persistent_cart_' . get_current_blog_id();
    if ( $meta_key === $target_key ) {
        $suffix = custom_multidomain_is_twistshake() ? '_twistshake' : '_prestige';
        $new_key = $meta_key . $suffix;
        
        remove_filter( 'get_user_metadata', 'custom_multidomain_get_user_persistent_cart', 10 );
        $val = get_user_meta( $object_id, $new_key, $single );
        add_filter( 'get_user_metadata', 'custom_multidomain_get_user_persistent_cart', 10, 5 );
        
        if ( $single ) {
            return array( $val );
        } else {
            return is_array( $val ) ? $val : array( $val );
        }
    }
    return $value;
}

add_filter( 'update_user_metadata', 'custom_multidomain_update_user_persistent_cart', 10, 5 );
function custom_multidomain_update_user_persistent_cart( $check, $object_id, $meta_key, $meta_value, $prev_value ) {
    $target_key = '_woocommerce_persistent_cart_' . get_current_blog_id();
    if ( $meta_key === $target_key ) {
        $suffix = custom_multidomain_is_twistshake() ? '_twistshake' : '_prestige';
        $new_key = $meta_key . $suffix;
        
        remove_filter( 'update_user_metadata', 'custom_multidomain_update_user_persistent_cart', 10 );
        update_user_meta( $object_id, $new_key, $meta_value, $prev_value );
        add_filter( 'update_user_metadata', 'custom_multidomain_update_user_persistent_cart', 10, 5 );
        
        return true;
    }
    return $check;
}

add_filter( 'delete_user_metadata', 'custom_multidomain_delete_user_persistent_cart', 10, 5 );
function custom_multidomain_delete_user_persistent_cart( $check, $object_id, $meta_key, $meta_value, $delete_all ) {
    $target_key = '_woocommerce_persistent_cart_' . get_current_blog_id();
    if ( $meta_key === $target_key ) {
        $suffix = custom_multidomain_is_twistshake() ? '_twistshake' : '_prestige';
        $new_key = $meta_key . $suffix;
        
        remove_filter( 'delete_user_metadata', 'custom_multidomain_delete_user_persistent_cart', 10 );
        delete_user_meta( $object_id, $new_key, $meta_value );
        add_filter( 'delete_user_metadata', 'custom_multidomain_delete_user_persistent_cart', 10, 5 );
        
        return true;
    }
    return $check;
}

/**
 * Define and register custom session handler to isolate active sessions for logged-in users.
 */
add_action( 'plugins_loaded', 'custom_multidomain_define_session_handler', 10 );
function custom_multidomain_define_session_handler() {
    if ( class_exists( 'WC_Session_Handler' ) && ! class_exists( 'Custom_Multidomain_Session_Handler' ) ) {
        class Custom_Multidomain_Session_Handler extends WC_Session_Handler {
            
            private function get_suffixed_customer_id( $customer_id ) {
                if ( is_numeric( $customer_id ) ) {
                    $suffix = custom_multidomain_is_twistshake() ? '_twistshake' : '_prestige';
                    if ( substr( $customer_id, -11 ) !== '_twistshake' && substr( $customer_id, -9 ) !== '_prestige' ) {
                        return $customer_id . $suffix;
                    }
                }
                return $customer_id;
            }

            public function get_session( $customer_id, $default_value = false ) {
                $customer_id = $this->get_suffixed_customer_id( $customer_id );
                return parent::get_session( $customer_id, $default_value );
            }

            public function delete_session( $customer_id ) {
                $customer_id = $this->get_suffixed_customer_id( $customer_id );
                parent::delete_session( $customer_id );
            }

            public function update_session_timestamp( $customer_id, $timestamp ) {
                $customer_id = $this->get_suffixed_customer_id( $customer_id );
                parent::update_session_timestamp( $customer_id, $timestamp );
            }

            public function save_data( $old_session_key = '' ) {
                $original_customer_id = $this->_customer_id;
                $this->_customer_id = $this->get_suffixed_customer_id( $this->_customer_id );
                
                if ( ! empty( $old_session_key ) ) {
                    $old_session_key = $this->get_suffixed_customer_id( $old_session_key );
                }
                
                parent::save_data( $old_session_key );
                
                $this->_customer_id = $original_customer_id;
            }
        }
    }
}

add_filter( 'woocommerce_session_handler', 'custom_multidomain_session_handler_class' );
function custom_multidomain_session_handler_class( $class ) {
    if ( class_exists( 'Custom_Multidomain_Session_Handler' ) ) {
        return 'Custom_Multidomain_Session_Handler';
    }
    return $class;
}


/**
 * Garante que no ambiente local (localhost / 127.0.0.1) todos os links apontem exclusivamente para o host local
 * e preserva o parâmetro ?store= para manter a loja selecionada.
 */
add_filter( 'post_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'post_type_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'page_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'term_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'wp_setup_nav_menu_item', 'custom_multidomain_filter_menu_item_url', 99, 1 );
add_filter( 'nav_menu_link_attributes', 'custom_multidomain_filter_nav_menu_link_attributes', 99, 2 );
add_filter( 'woocommerce_product_get_permalink', 'custom_multidomain_append_store_param', 99, 1 );

function custom_multidomain_append_store_param( $url ) {
    static $is_recursing = false;
    if ( $is_recursing || empty( $url ) || ! is_string( $url ) ) {
        return $url;
    }

    if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return $url;
    }
    
    if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
        return $url;
    }
    
    $host = $_SERVER['HTTP_HOST'];
    $is_local = ( strpos( $host, 'localhost' ) !== false || strpos( $host, '127.0.0.1' ) !== false );
    
    // No ambiente local, substituir domínios de produção pelo host local atual
    if ( $is_local ) {
        $is_recursing = true;
        $prod_domains = array(
            'https://loja.prestigehealth.pt',
            'http://loja.prestigehealth.pt',
            'https://twistshakeportugal.pt',
            'http://twistshakeportugal.pt',
            'https://prestigehealth.pt',
            'http://prestigehealth.pt',
            '//loja.prestigehealth.pt',
            '//twistshakeportugal.pt',
            '//prestigehealth.pt',
        );
        $scheme = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
        $local_home = $scheme . $host;
        $url = str_replace( $prod_domains, $local_home, $url );
        $is_recursing = false;
    } else {
        return $url;
    }
    
    // Ignorar ficheiros estáticos e admin
    if ( strpos( $url, '/wp-admin/' ) !== false || preg_match( '/\.(js|css|png|jpe?g|gif|xml|txt|ico|svg|woff2?|otf|ttf|eot)(\?.*)?$/i', $url ) ) {
        return $url;
    }
    
    $is_twistshake = custom_multidomain_is_twistshake();
    $store = $is_twistshake ? 'twistshake' : 'prestige';
    
    return add_query_arg( 'store', $store, $url );
}

function custom_multidomain_filter_menu_item_url( $menu_item ) {
    if ( isset( $menu_item->url ) ) {
        $menu_item->url = custom_multidomain_append_store_param( $menu_item->url );
    }
    return $menu_item;
}

function custom_multidomain_filter_nav_menu_link_attributes( $atts, $item ) {
    if ( isset( $atts['href'] ) ) {
        $atts['href'] = custom_multidomain_append_store_param( $atts['href'] );
    }
    return $atts;
}

/**
 * Helper to detect Portuguese Islands (Madeira and Açores) based on postal code.
 * Madeira: 9000-000 to 9499-999
 * Açores:  9500-000 to 9999-999
 */
function custom_is_portugal_islands( $postcode, $country = 'PT' ) {
    if ( 'PT' !== $country ) {
        return false;
    }
    $clean_code = preg_replace( '/[^0-9]/', '', $postcode );
    if ( strlen( $clean_code ) >= 4 ) {
        $prefix = (int) substr( $clean_code, 0, 4 );
        if ( $prefix >= 9000 && $prefix <= 9999 ) {
            return true;
        }
    }
    return false;
}

/**
 * Invalidate shipping package cache when postcode changes to guarantee fresh rate calculation.
 */
add_filter( 'woocommerce_cart_shipping_packages', 'custom_multidomain_invalidate_shipping_cache' );
function custom_multidomain_invalidate_shipping_cache( $packages ) {
    foreach ( $packages as $i => $package ) {
        $postcode = isset( $package['destination']['postcode'] ) ? $package['destination']['postcode'] : '';
        $packages[$i]['custom_version'] = md5( $postcode . '_v2' );
    }
    return $packages;
}

/**
 * ============================================================================
 * PORTES DE ENVIO, MENSAGENS PROMOCIONAIS E CONTROLO DE DESTINOS
 * ============================================================================
 */

/**
 * Retorna o valor padrão dos portes normais (Taxa Fixa). Padrão: 6.00 €
 */
function custom_get_standard_shipping_cost() {
    $cost = get_option( 'custom_shipping_standard_cost', '' );
    if ( '' !== $cost && is_numeric( $cost ) ) {
        return (float) $cost;
    }
    // Fallback: tentar ler do método flat_rate nas zonas do WooCommerce
    if ( class_exists( 'WC_Shipping_Zones' ) ) {
        $zones = WC_Shipping_Zones::get_zones();
        foreach ( $zones as $zone ) {
            if ( ! empty( $zone['shipping_methods'] ) ) {
                foreach ( $zone['shipping_methods'] as $method ) {
                    if ( 'flat_rate' === $method->id && $method->is_enabled() ) {
                        if ( isset( $method->cost ) && is_numeric( $method->cost ) ) {
                            return (float) $method->cost;
                        }
                    }
                }
            }
        }
    }
    return 6.00;
}

/**
 * Retorna o valor mínimo para Portes Grátis. Padrão: 100.00 €
 */
function custom_get_free_shipping_min_amount() {
    $threshold = get_option( 'custom_shipping_free_threshold', '' );
    if ( '' !== $threshold && is_numeric( $threshold ) ) {
        return (float) $threshold;
    }
    // Fallback: tentar ler do método free_shipping nas zonas do WooCommerce
    if ( class_exists( 'WC_Shipping_Zones' ) ) {
        $zones = WC_Shipping_Zones::get_zones();
        foreach ( $zones as $zone ) {
            if ( ! empty( $zone['shipping_methods'] ) ) {
                foreach ( $zone['shipping_methods'] as $method ) {
                    if ( 'free_shipping' === $method->id && $method->is_enabled() ) {
                        if ( ! empty( $method->min_amount ) && is_numeric( $method->min_amount ) ) {
                            return (float) $method->min_amount;
                        }
                    }
                }
            }
        }
    }
    return 100.00;
}

/**
 * Retorna o texto promocional de envio para o topo do site (Prestige Health ou Twistshake)
 */
function custom_get_shipping_promo_text( $store = 'prestige' ) {
    $min_amount = custom_get_free_shipping_min_amount();
    $min_formatted = number_format( $min_amount, ( fmod( $min_amount, 1.0 ) !== 0.0 ? 2 : 0 ), ',', '' ) . '€';
    $cost = custom_get_standard_shipping_cost();
    $cost_formatted = number_format( $cost, ( fmod( $cost, 1.0 ) !== 0.0 ? 2 : 0 ), ',', '' ) . '€';

    if ( 'twistshake' === $store ) {
        $template = get_option( 'custom_shipping_promo_twistshake', 'Portes grátis em compras superiores a {min_amount} para Portugal Continental' );
    } else {
        $template = get_option( 'custom_shipping_promo_prestige', 'Portes grátis para compras superiores a {min_amount} em Portugal Continental.' );
    }

    return str_replace( array( '{min_amount}', '{shipping_cost}' ), array( $min_formatted, $cost_formatted ), $template );
}

/**
 * Retorna o texto do selo de portes grátis no rodapé da Twistshake
 */
function custom_get_shipping_footer_twistshake_text() {
    $min_amount = custom_get_free_shipping_min_amount();
    $min_formatted = number_format( $min_amount, ( fmod( $min_amount, 1.0 ) !== 0.0 ? 2 : 0 ), ',', '' ) . '€';
    $cost = custom_get_standard_shipping_cost();
    $cost_formatted = number_format( $cost, ( fmod( $cost, 1.0 ) !== 0.0 ? 2 : 0 ), ',', '' ) . '€';

    $template = get_option( 'custom_shipping_footer_twistshake', 'Em compras superiores a {min_amount} (PT Continental)' );
    return str_replace( array( '{min_amount}', '{shipping_cost}' ), array( $min_formatted, $cost_formatted ), $template );
}

/**
 * Filtro dinâmico de taxas de envio:
 * 1. Remove qualquer método de envio se o destino for Ilhas (Madeira e Açores: 9000-9999).
 * 2. Aplica Portes Grátis (0€) exclusivamente a Portugal Continental quando o carrinho atinge o valor mínimo (100€).
 * 3. Aplica Taxa Normal (6,00€) para compras abaixo do valor mínimo.
 * 4. Mantém Levantamento na Loja disponível com morada física.
 */
add_filter( 'woocommerce_package_rates', 'custom_multidomain_filter_shipping_rates', 20, 2 );
function custom_multidomain_filter_shipping_rates( $rates, $package ) {
    $country  = isset( $package['destination']['country'] ) ? $package['destination']['country'] : 'PT';
    $postcode = isset( $package['destination']['postcode'] ) ? $package['destination']['postcode'] : '';
    
    $is_island = custom_is_portugal_islands( $postcode, $country );
    
    // Ilhas (Madeira e Açores): Bloqueio total de entrega
    if ( $is_island ) {
        return array();
    }
    
    $standard_cost  = custom_get_standard_shipping_cost();
    $free_threshold = custom_get_free_shipping_min_amount();
    
    // Obter o subtotal do carrinho
    $cart_total = 0;
    if ( isset( $package['contents_cost'] ) ) {
        $cart_total = (float) $package['contents_cost'];
    } elseif ( function_exists( 'WC' ) && WC()->cart ) {
        $cart_total = (float) WC()->cart->get_displayed_subtotal();
    }
    
    $has_free_shipping = ( $cart_total >= $free_threshold );
    
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'local_pickup' === $rate->method_id || false !== strpos( $rate_id, 'local_pickup' ) ) {
            $rate->label = 'Levantamento na Loja';
        } elseif ( 'free_shipping' === $rate->method_id || false !== strpos( $rate_id, 'free_shipping' ) ) {
            if ( ! $has_free_shipping ) {
                unset( $rates[ $rate_id ] );
            } else {
                $rate->label = 'Portugal Continental';
            }
        } elseif ( 'flat_rate' === $rate->method_id || false !== strpos( $rate_id, 'flat_rate' ) ) {
            if ( $has_free_shipping ) {
                unset( $rates[ $rate_id ] );
            } else {
                $rate->cost = $standard_cost;
                $rate->label = 'Portugal Continental';
            }
        }
    }
    
    return $rates;
}

/**
 * Formatação do rótulo de Levantamento na Loja com a morada física.
 */
add_filter( 'woocommerce_cart_shipping_method_full_label', 'custom_multidomain_shipping_method_full_label', 10, 2 );
function custom_multidomain_shipping_method_full_label( $label, $method ) {
    if ( 'local_pickup' === $method->method_id || false !== strpos( $method->id, 'local_pickup' ) ) {
        $address = 'Rua Senador Sousa Fernandes 242, 4760-164 Vila Nova de Famalicão';
        $label = 'Levantamento na Loja: <span class="woocommerce-Price-amount amount">Grátis</span>';
        $label .= '<span class="shipping-method-address" style="display: block; font-size: 0.85em; color: #666; font-weight: normal; margin-top: 2px;">(Morada: ' . esc_html( $address ) . ')</span>';
    }
    return $label;
}

/**
 * Validação no Checkout: Bloquear encomendas com destino às Ilhas (Madeira e Açores - 9000 a 9999).
 */
add_action( 'woocommerce_after_checkout_validation', 'custom_multidomain_validate_islands_checkout', 10, 2 );
function custom_multidomain_validate_islands_checkout( $data, $errors ) {
    $ship_to_different = ! empty( $data['ship_to_different_address'] );
    
    $country  = $ship_to_different ? ( $data['shipping_country'] ?? 'PT' ) : ( $data['billing_country'] ?? 'PT' );
    $postcode = $ship_to_different ? ( $data['shipping_postcode'] ?? '' ) : ( $data['billing_postcode'] ?? '' );
    
    if ( custom_is_portugal_islands( $postcode, $country ) ) {
        $errors->add(
            'shipping_islands_not_supported',
            '<strong>Envio Indisponível:</strong> De momento não realizamos envios para as Regiões Autónomas da Madeira e dos Açores. Os nossos envios estão disponíveis exclusivamente para Portugal Continental.'
        );
    }
}

/**
 * Script de validação visual e bloqueio em tempo real no Carrinho e Checkout para códigos postais das Ilhas.
 */
add_action( 'wp_footer', 'custom_multidomain_islands_realtime_block_script', 9999 );
function custom_multidomain_islands_realtime_block_script() {
    if ( ! is_checkout() && ! is_cart() ) {
        return;
    }
    ?>
    <script type="text/javascript">
    (function($) {
        function checkIslandsPostcode() {
            var isShipDiff = $('#ship-to-different-address-checkbox').is(':checked');
            var country = isShipDiff ? $('#shipping_country').val() : $('#billing_country').val();
            var postcode = isShipDiff ? $('#shipping_postcode').val() : $('#billing_postcode').val();
            
            if (!postcode) {
                postcode = $('#calc_shipping_postcode').val();
                country = $('#calc_shipping_country').val() || 'PT';
            }
            
            var isIsland = false;
            if (country === 'PT' && postcode) {
                var clean = postcode.replace(/[^0-9]/g, '');
                if (clean.length >= 1 && clean.charAt(0) === '9') {
                    isIsland = true;
                }
            }
            
            var noticeId = 'islands-blocked-warning-msg';
            $('#' + noticeId).remove();
            
            if (isIsland) {
                var alertHtml = '<div id="' + noticeId + '" style="margin: 12px 0; padding: 12px 16px; background-color: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; border-left: 4px solid #EF4444; border-radius: 6px; font-size: 13px; font-weight: 500; line-height: 1.5;">' +
                    '⚠️ <strong>Atenção:</strong> De momento não realizamos envios para as Regiões Autónomas da Madeira e dos Açores. Os envios estão disponíveis exclusivamente para Portugal Continental.' +
                    '</div>';
                
                if ($('#shipping_postcode_field').length && isShipDiff) {
                    $('#shipping_postcode_field').after(alertHtml);
                } else if ($('#billing_postcode_field').length) {
                    $('#billing_postcode_field').after(alertHtml);
                } else if ($('#calc_shipping_postcode').length) {
                    $('#calc_shipping_postcode').after(alertHtml);
                }
                
                $('#place_order').prop('disabled', true).css('opacity', '0.5');
            } else {
                $('#place_order').prop('disabled', false).css('opacity', '');
            }
        }
        
        $(document).ready(function() {
            $(document).on('input change blur keyup', '#billing_postcode, #shipping_postcode, #calc_shipping_postcode, #billing_country, #shipping_country, #ship-to-different-address-checkbox', function() {
                checkIslandsPostcode();
            });
            $(document).on('updated_checkout updated_cart_totals updated_wc_div', function() {
                checkIslandsPostcode();
            });
            checkIslandsPostcode();
        });
    })(jQuery);
    </script>
    <?php
}

/**
 * Menu Administrativo WooCommerce: Portes & Mensagens
 */
add_action( 'admin_menu', 'custom_multidomain_register_shipping_admin_menu' );
function custom_multidomain_register_shipping_admin_menu() {
    add_submenu_page(
        'woocommerce',
        'Portes & Mensagens',
        'Portes & Mensagens 🚚',
        'manage_options',
        'custom-shipping-settings',
        'custom_multidomain_render_shipping_settings_page'
    );
}

/**
 * Página de Configuração de Portes e Mensagens no Painel de Admin
 */
function custom_multidomain_render_shipping_settings_page() {
    if ( isset( $_POST['save_shipping_settings'] ) && check_admin_referer( 'custom_shipping_settings_action', 'custom_shipping_nonce' ) ) {
        $cost           = isset( $_POST['shipping_standard_cost'] ) ? (float) str_replace( ',', '.', sanitize_text_field( $_POST['shipping_standard_cost'] ) ) : 6.00;
        $free_threshold = isset( $_POST['shipping_free_threshold'] ) ? (float) str_replace( ',', '.', sanitize_text_field( $_POST['shipping_free_threshold'] ) ) : 100.00;
        $promo_prestige = isset( $_POST['shipping_promo_prestige'] ) ? sanitize_text_field( wp_unslash( $_POST['shipping_promo_prestige'] ) ) : '';
        $promo_twist    = isset( $_POST['shipping_promo_twistshake'] ) ? sanitize_text_field( wp_unslash( $_POST['shipping_promo_twistshake'] ) ) : '';
        $footer_twist   = isset( $_POST['shipping_footer_twistshake'] ) ? sanitize_text_field( wp_unslash( $_POST['shipping_footer_twistshake'] ) ) : '';

        update_option( 'custom_shipping_standard_cost', $cost );
        update_option( 'custom_shipping_free_threshold', $free_threshold );
        update_option( 'custom_shipping_promo_prestige', $promo_prestige );
        update_option( 'custom_shipping_promo_twistshake', $promo_twist );
        update_option( 'custom_shipping_footer_twistshake', $footer_twist );

        // Sincronizar automaticamente com métodos de envio do WooCommerce
        if ( class_exists( 'WC_Shipping_Zones' ) ) {
            $zones = WC_Shipping_Zones::get_zones();
            foreach ( $zones as $zone_data ) {
                $zone = new WC_Shipping_Zone( $zone_data['id'] );
                foreach ( $zone->get_shipping_methods() as $method ) {
                    if ( 'flat_rate' === $method->id ) {
                        $opt_key = $method->get_instance_option_key();
                        $settings = get_option( $opt_key, array() );
                        $settings['cost'] = (string) $cost;
                        update_option( $opt_key, $settings );
                    } elseif ( 'free_shipping' === $method->id ) {
                        $opt_key = $method->get_instance_option_key();
                        $settings = get_option( $opt_key, array() );
                        $settings['min_amount'] = (string) $free_threshold;
                        $settings['requires']   = 'min_amount';
                        update_option( $opt_key, $settings );
                    }
                }
            }
        }

        echo '<div class="updated notice is-dismissible" style="margin: 20px 0; padding: 12px 15px; background: #e6f4ea; border-left: 4px solid #2f855a;"><p><strong>Configurações de Portes guardadas com sucesso!</strong> Os valores e mensagens já foram sincronizados com as lojas Prestige Health e Twistshake.</p></div>';
    }

    $current_cost      = custom_get_standard_shipping_cost();
    $current_threshold = custom_get_free_shipping_min_amount();
    $promo_prestige    = get_option( 'custom_shipping_promo_prestige', 'Portes grátis para compras superiores a {min_amount} em Portugal Continental.' );
    $promo_twist       = get_option( 'custom_shipping_promo_twistshake', 'Portes grátis em compras superiores a {min_amount} para Portugal Continental' );
    $footer_twist      = get_option( 'custom_shipping_footer_twistshake', 'Em compras superiores a {min_amount} (PT Continental)' );
    ?>
    <div class="wrap" style="max-width: 900px;">
        <h1 style="display: flex; align-items: center; gap: 10px;">Gestão de Portes & Mensagens 🚚</h1>
        <p style="font-size: 14px; color: #555;">
            Configure os valores de envio e personalize as mensagens promocionais exibidas nos cabeçalhos e rodapés de <strong>Prestige Health</strong> e <strong>Twistshake Portugal</strong>.
        </p>

        <form method="post" action="">
            <?php wp_nonce_field( 'custom_shipping_settings_action', 'custom_shipping_nonce' ); ?>

            <div class="card" style="padding: 20px; border-radius: 8px; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <h2 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #005492;">Valores de Envio (Portugal Continental)</h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="shipping_standard_cost">Portes Normais (€)</label></th>
                        <td>
                            <input type="number" step="0.01" min="0" name="shipping_standard_cost" id="shipping_standard_cost" value="<?php echo esc_attr( number_format( $current_cost, 2, '.', '' ) ); ?>" class="regular-text" style="width: 120px;" required> €
                            <p class="description">Custo cobrado para encomendas abaixo do valor mínimo de portes grátis (ex: 6.00).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="shipping_free_threshold">Valor Mínimo para Portes Grátis (€)</label></th>
                        <td>
                            <input type="number" step="0.01" min="0" name="shipping_free_threshold" id="shipping_free_threshold" value="<?php echo esc_attr( number_format( $current_threshold, 2, '.', '' ) ); ?>" class="regular-text" style="width: 120px;" required> €
                            <p class="description">Valor de encomenda a partir do qual os portes passam a ser grátis (ex: 100.00).</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card" style="padding: 20px; border-radius: 8px; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <h2 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #005492;">Mensagens Promocionais dos Sites</h2>
                <p class="description" style="margin-bottom: 15px;">
                    Dica: Pode usar a tag <code>{min_amount}</code> para inserir automaticamente o valor de portes grátis (ex: 100€) e <code>{shipping_cost}</code> para o valor do frete (ex: 6€).
                </p>

                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="shipping_promo_prestige">Barra Superior — Prestige Health</label></th>
                        <td>
                            <input type="text" name="shipping_promo_prestige" id="shipping_promo_prestige" value="<?php echo esc_attr( $promo_prestige ); ?>" class="large-text" required>
                            <p class="description">Exibida na barra azul no topo do site loja.prestigehealth.pt.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="shipping_promo_twistshake">Barra Superior — Twistshake</label></th>
                        <td>
                            <input type="text" name="shipping_promo_twistshake" id="shipping_promo_twistshake" value="<?php echo esc_attr( $promo_twist ); ?>" class="large-text" required>
                            <p class="description">Exibida no carrossel de destaques no topo do site twistshakeportugal.pt.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="shipping_footer_twistshake">Selo Rodapé — Twistshake</label></th>
                        <td>
                            <input type="text" name="shipping_footer_twistshake" id="shipping_footer_twistshake" value="<?php echo esc_attr( $footer_twist ); ?>" class="large-text" required>
                            <p class="description">Subtítulo do badge "PORTES GRÁTIS" na barra de confiança do rodapé da Twistshake.</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card" style="padding: 20px; border-radius: 8px; margin-top: 20px; background: #fdfefe; border-left: 4px solid #3b82f6;">
                <h3 style="margin-top: 0;">ℹ️ Política de Envio para as Ilhas (Madeira e Açores)</h3>
                <p style="margin: 0; color: #475569; font-size: 13.5px;">
                    Os envios para os códigos postais das Ilhas (<strong>9000-000 a 9999-999</strong>) estão automaticamente bloqueados tanto na calculadora do carrinho quanto na finalização da compra (checkout), com aviso explicativo e prevenção de pedidos.
                </p>
            </div>

            <p class="submit" style="margin-top: 20px;">
                <input type="submit" name="save_shipping_settings" class="button button-primary button-hero" value="Guardar Alterações 💾">
            </p>
        </form>
    </div>
    <?php
}

/**
 * Register Twistshake Banners admin menu and options page.
 */
add_action( 'admin_menu', 'custom_multidomain_register_banner_admin_menu' );
function custom_multidomain_register_banner_admin_menu() {
    add_submenu_page(
        'woocommerce',
        'Banners Twistshake',
        'Banners Twistshake 🖼️',
        'manage_options',
        'twistshake-banners',
        'custom_multidomain_render_banner_admin_page'
    );
}

function custom_multidomain_render_banner_admin_page() {
    wp_enqueue_media();

    if ( isset( $_POST['ts_save_banners'] ) && check_admin_referer( 'ts_save_banners_action', 'ts_banners_nonce' ) ) {
        $banners = array();
        if ( isset( $_POST['banners'] ) && is_array( $_POST['banners'] ) ) {
            foreach ( $_POST['banners'] as $b ) {
                if ( ! empty( $b['img'] ) || ! empty( $b['title'] ) ) {
                    $banners[] = array(
                        'tag'       => sanitize_text_field( $b['tag'] ?? '' ),
                        'title'     => sanitize_text_field( $b['title'] ?? '' ),
                        'desc'      => sanitize_text_field( $b['desc'] ?? '' ),
                        'btn_text'  => sanitize_text_field( $b['btn_text'] ?? '' ),
                        'link'      => esc_url_raw( $b['link'] ?? '' ),
                        'img'       => esc_url_raw( $b['img'] ?? '' ),
                        'bg'        => sanitize_text_field( $b['bg'] ?? '' ),
                    );
                }
            }
        }
        update_option( 'twistshake_home_banners', $banners );
        echo '<div class="updated" style="margin:20px 0; padding:12px; background:#e6f4ea; border-left:4px solid #2f855a;"><p><strong>Banners guardados com sucesso!</strong> Os novos banners já estão visíveis na página inicial da Twistshake.</p></div>';
    }

    $banners = get_option( 'twistshake_home_banners', array() );
    if ( empty( $banners ) ) {
        $banners = custom_multidomain_get_default_banners();
    }

    // Fetch published WooCommerce products
    $products = get_posts( array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );
    ?>
    <div class="wrap">
        <h1>Gerir Banners da Página Inicial Twistshake 🖼️</h1>
        <p>Escolha produtos cadastrados, selecione imagens da galeria do WordPress ou insira informações personalizadas para os banners da loja Twistshake.</p>
        <form method="post" action="">
            <?php wp_nonce_field( 'ts_save_banners_action', 'ts_banners_nonce' ); ?>
            <div id="ts-banners-list">
                <?php foreach ( $banners as $idx => $b ) : ?>
                    <div class="card ts-banner-card" style="margin-bottom:20px; padding:20px; max-width:850px; border-radius:8px; border:1px solid #ccd0d4; background:#fff;">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:15px;">
                            <h3 style="margin:0;">Banner #<span class="ts-banner-num"><?php echo $idx + 1; ?></span></h3>
                            <button type="button" class="button button-link-delete ts-remove-banner-btn" style="color:#a00; text-decoration:none;">🗑️ Remover Banner</button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th>Etiqueta / Tag</th>
                                <td><input type="text" name="banners[<?php echo $idx; ?>][tag]" value="<?php echo esc_attr( $b['tag'] ?? '' ); ?>" class="regular-text" placeholder="Ex: NOVIDADE PASSEIO"></td>
                            </tr>
                            <tr>
                                <th>Título Principal</th>
                                <td><input type="text" name="banners[<?php echo $idx; ?>][title]" value="<?php echo esc_attr( $b['title'] ?? '' ); ?>" class="regular-text" placeholder="Ex: Carrinhos de Passeio"></td>
                            </tr>
                            <tr>
                                <th>Descrição Curta</th>
                                <td><input type="text" name="banners[<?php echo $idx; ?>][desc]" value="<?php echo esc_attr( $b['desc'] ?? '' ); ?>" class="large-text" placeholder="Ex: Leves e dobráveis em 1 segundo."></td>
                            </tr>
                            <tr>
                                <th>Texto do Botão</th>
                                <td><input type="text" name="banners[<?php echo $idx; ?>][btn_text]" value="<?php echo esc_attr( $b['btn_text'] ?? '' ); ?>" class="regular-text" placeholder="Ex: Descobrir Carrinhos"></td>
                            </tr>
                            <tr>
                                <th>Escolher Produto Cadastrado 🛍️</th>
                                <td>
                                    <select class="regular-text ts-product-select" data-target-link="ts_link_<?php echo $idx; ?>">
                                        <option value="">-- Selecionar um Produto da Loja --</option>
                                        <?php foreach ( $products as $prod ) : ?>
                                            <?php $prod_link = get_permalink( $prod->ID ); ?>
                                            <option value="<?php echo esc_url( $prod_link ); ?>"><?php echo esc_html( $prod->post_title ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Ao selecionar um produto cadastrado, o link de destino abaixo é preenchido automaticamente.</p>
                                </td>
                            </tr>
                            <tr>
                                <th>Link de Destino (URL)</th>
                                <td>
                                    <input type="url" id="ts_link_<?php echo $idx; ?>" name="banners[<?php echo $idx; ?>][link]" value="<?php echo esc_attr( $b['link'] ?? '' ); ?>" class="large-text" placeholder="https://...">
                                </td>
                            </tr>
                            <tr>
                                <th>Imagem do Banner 📷</th>
                                <td>
                                    <div style="display:flex; gap:10px; align-items:center;">
                                        <input type="url" id="ts_img_<?php echo $idx; ?>" name="banners[<?php echo $idx; ?>][img]" value="<?php echo esc_attr( $b['img'] ?? '' ); ?>" class="large-text ts-img-input" placeholder="https://.../imagem.png">
                                        <button type="button" class="button button-secondary ts-upload-img-btn" data-target="ts_img_<?php echo $idx; ?>">🖼️ Galeria / Upload</button>
                                    </div>
                                    <div class="ts-img-preview" id="preview_ts_img_<?php echo $idx; ?>" style="margin-top:10px;">
                                        <?php if ( ! empty( $b['img'] ) ) : ?>
                                            <img src="<?php echo esc_url( $b['img'] ); ?>" style="max-height:100px; max-width:200px; border-radius:6px; border:1px solid #ccc; background:#f9f9f9; padding:4px; object-fit:cover;">
                                        <?php endif; ?>
                                    </div>
                                    <p class="description">Clique no botão para escolher uma imagem existente na Galeria de Mídia do WordPress ou carregar um novo ficheiro.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>

            <p style="margin-top:15px; margin-bottom:25px;">
                <button type="button" id="ts-add-banner-btn" class="button button-secondary button-large" style="font-weight:600;">➕ Adicionar Novo Banner</button>
            </p>

            <p><input type="submit" name="ts_save_banners" class="button button-primary button-large" value="Guardar Alterações aos Banners"></p>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($){
        // Media Library Picker
        $(document).on('click', '.ts-upload-img-btn', function(e){
            e.preventDefault();
            var targetId = $(this).data('target');
            var targetInput = $('#' + targetId);
            var previewDiv = $('#preview_' + targetId);

            var frame = wp.media({
                title: 'Selecionar ou Carregar Imagem do Banner',
                button: { text: 'Usar esta imagem' },
                multiple: false
            });

            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                targetInput.val(attachment.url);
                previewDiv.html('<img src="' + attachment.url + '" style="max-height:100px; max-width:200px; border-radius:6px; border:1px solid #ccc; background:#f9f9f9; padding:4px; object-fit:cover;">');
            });

            frame.open();
        });

        // Product Selector Listener
        $(document).on('change', '.ts-product-select', function(){
            var selectedUrl = $(this).val();
            var targetLinkId = $(this).data('target-link');
            if (selectedUrl) {
                $('#' + targetLinkId).val(selectedUrl);
            }
        });

        // Remove Banner Card
        $(document).on('click', '.ts-remove-banner-btn', function(e){
            e.preventDefault();
            if ($('.ts-banner-card').length <= 1) {
                alert('A loja precisa de ter pelo menos 1 banner.');
                return;
            }
            if (confirm('Tem a certeza que deseja remover este banner?')) {
                $(this).closest('.ts-banner-card').remove();
                reindexBanners();
            }
        });

        // Add New Banner Card
        $('#ts-add-banner-btn').on('click', function(e){
            e.preventDefault();
            var nextIdx = $('.ts-banner-card').length;
            var uniqueId = Date.now();
            var productsOptions = $('#ts-banners-list .ts-product-select').first().html() || '<option value="">-- Selecionar um Produto da Loja --</option>';

            var cardHtml = `
            <div class="card ts-banner-card" style="margin-bottom:20px; padding:20px; max-width:850px; border-radius:8px; border:1px solid #ccd0d4; background:#fff;">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:15px;">
                    <h3 style="margin:0;">Banner #<span class="ts-banner-num">${nextIdx + 1}</span></h3>
                    <button type="button" class="button button-link-delete ts-remove-banner-btn" style="color:#a00; text-decoration:none;">🗑️ Remover Banner</button>
                </div>
                <table class="form-table">
                    <tr>
                        <th>Etiqueta / Tag</th>
                        <td><input type="text" name="banners[${nextIdx}][tag]" value="NOVIDADE" class="regular-text" placeholder="Ex: NOVIDADE PASSEIO"></td>
                    </tr>
                    <tr>
                        <th>Título Principal</th>
                        <td><input type="text" name="banners[${nextIdx}][title]" value="" class="regular-text" placeholder="Ex: Novo Produto Twistshake"></td>
                    </tr>
                    <tr>
                        <th>Descrição Curta</th>
                        <td><input type="text" name="banners[${nextIdx}][desc]" value="" class="large-text" placeholder="Ex: Leves e práticos para o dia a dia."></td>
                    </tr>
                    <tr>
                        <th>Texto do Botão</th>
                        <td><input type="text" name="banners[${nextIdx}][btn_text]" value="Ver Mais" class="regular-text" placeholder="Ex: Descobrir Carrinhos"></td>
                    </tr>
                    <tr>
                        <th>Escolher Produto Cadastrado 🛍️</th>
                        <td>
                            <select class="regular-text ts-product-select" data-target-link="ts_link_${uniqueId}">
                                ${productsOptions}
                            </select>
                            <p class="description">Ao selecionar um produto cadastrado, o link de destino abaixo é preenchido automaticamente.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Link de Destino (URL)</th>
                        <td>
                            <input type="url" id="ts_link_${uniqueId}" name="banners[${nextIdx}][link]" value="" class="large-text" placeholder="https://...">
                        </td>
                    </tr>
                    <tr>
                        <th>Imagem do Banner 📷</th>
                        <td>
                            <div style="display:flex; gap:10px; align-items:center;">
                                <input type="url" id="ts_img_${uniqueId}" name="banners[${nextIdx}][img]" value="" class="large-text ts-img-input" placeholder="https://.../imagem.png">
                                <button type="button" class="button button-secondary ts-upload-img-btn" data-target="ts_img_${uniqueId}">🖼️ Galeria / Upload</button>
                            </div>
                            <div class="ts-img-preview" id="preview_ts_img_${uniqueId}" style="margin-top:10px;"></div>
                            <p class="description">Clique no botão para escolher uma imagem existente na Galeria de Mídia do WordPress ou carregar um novo ficheiro.</p>
                        </td>
                    </tr>
                </table>
            </div>`;

            $('#ts-banners-list').append(cardHtml);
            reindexBanners();
        });

        function reindexBanners() {
            $('.ts-banner-card').each(function(idx){
                $(this).find('.ts-banner-num').text(idx + 1);
                $(this).find('input, select').each(function(){
                    var name = $(this).attr('name');
                    if (name) {
                        var newName = name.replace(/banners\[\d+\]/, 'banners[' + idx + ']');
                        $(this).attr('name', newName);
                    }
                });
            });
        }
    });
    </script>
    <?php
}

function custom_multidomain_get_default_banners() {
    return array(
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

/**
 * Automatically ensure 'Política de Privacidade' and 'Termos e Condições' pages exist.
 */
add_action( 'init', 'custom_multidomain_ensure_legal_pages' );
function custom_multidomain_ensure_legal_pages() {
    static $run = false;
    if ( $run ) {
        return;
    }
    $run = true;

    // 1. Política de Privacidade
    $privacy_page = get_page_by_path( 'politica-de-privacidade' );
    if ( ! $privacy_page ) {
        $privacy_id = wp_insert_post( array(
            'post_title'     => 'Política de Privacidade',
            'post_name'      => 'politica-de-privacidade',
            'post_content'   => '<h2>Política de Privacidade</h2><p>A privacidade e a proteção dos seus dados pessoais são fundamentais. Esta Política de Privacidade explica como recolhemos, utilizamos e protegemos as suas informações ao utilizar o nosso website e ao realizar encomendas.</p><h3>1. Recolha de Dados</h3><p>Recolhemos informações necessárias para o processamento das suas encomendas, tais como nome, morada de entrega, email, número de telefone e dados de faturação.</p><h3>2. Utilização das Informações</h3><p>Os seus dados são utilizados exclusivamente para processar pedidos, comunicar o estado da encomenda, fornecer apoio ao cliente e cumprir obrigações legais.</p><h3>3. Segurança</h3><p>Implementamos medidas de segurança técnicas e organizativas adequadas para proteger os seus dados pessoais contra acesso não autorizado, alteração ou destruição.</p><h3>4. Contacto</h3><p>Para qualquer questão sobre a nossa política de privacidade, contacte-nos através do email <strong>marketing@prestigehealth.pt</strong>.</p>',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        ) );
        if ( $privacy_id && ! is_wp_error( $privacy_id ) ) {
            update_option( 'wp_page_for_privacy_policy', $privacy_id );
        }
    }

    // 2. Termos e Condições
    $terms_page = get_page_by_path( 'termos-e-condicoes' );
    if ( ! $terms_page ) {
        $terms_id = wp_insert_post( array(
            'post_title'     => 'Termos e Condições',
            'post_name'      => 'termos-e-condicoes',
            'post_content'   => '<h2>Termos e Condições de Utilização</h2><p>Bem-vindo ao nosso website. Ao aceder e efetuar compras nesta loja online, concorda com os seguintes termos e condições gerais de venda.</p><h3>1. Objeto</h3><p>As presentes condições regulam as vendas dos produtos apresentados nesta loja online.</p><h3>2. Encomendas e Preços</h3><p>Todos os preços apresentados incluem IVA à taxa legal em vigor. Reservamo-nos o direito de alterar os preços a qualquer momento, garantindo o preço em vigor no momento da confirmação da encomenda.</p><h3>3. Envio e Portes</h3><p>Os envios são efetuados exclusivamente para Portugal Continental. Portes grátis em compras superiores a 100€ para Portugal Continental.</p><h3>4. Devoluções e Direito de Livre Resolução</h3><p>Nos termos da legislação em vigor, o consumidor dispõe do prazo de 14 dias para proceder à devolução do produto adquiridos sem necessidade de indicar o motivo.</p><h3>5. Contactos</h3><p>Para suporte e questões comerciais, contacte <strong>marketing@prestigehealth.pt</strong>.</p>',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        ) );
        if ( $terms_id && ! is_wp_error( $terms_id ) ) {
            update_option( 'woocommerce_terms_page_id', $terms_id );
        }
    }
}

/**
 * Replace broken font icons in WooCommerce pagination with clean arrows.
 */
add_filter( 'woocommerce_pagination_args', 'custom_multidomain_clean_pagination_args', 99 );
function custom_multidomain_clean_pagination_args( $args ) {
    $args['prev_text'] = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; display: inline-block;"><polyline points="15 18 9 12 15 6"></polyline></svg>';
    $args['next_text'] = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; display: inline-block;"><polyline points="9 18 15 12 9 6"></polyline></svg>';
    return $args;
}

/* ==========================================================================
 * NIF (Número de Identificação Fiscal) — Campo Opcional no Checkout
 * Aplicado em ambos os domínios (Prestige Health & Twistshake Portugal)
 * ========================================================================== */

/**
 * 1. Tornar o telefone de faturação obrigatório no checkout e adicionar campo NIF.
 */
add_filter( 'option_woocommerce_checkout_phone_field', function() {
    return 'required';
}, 999 );

add_filter( 'woocommerce_default_address_fields', 'prestige_force_default_phone_required', 999 );
function prestige_force_default_phone_required( $fields ) {
    if ( isset( $fields['phone'] ) ) {
        $fields['phone']['required'] = true;
    }
    return $fields;
}

add_filter( 'woocommerce_billing_fields', 'prestige_customize_billing_fields', 99, 1 );
function prestige_customize_billing_fields( $fields ) {
    // Campo de telefone obrigatório em ambas as lojas
    if ( isset( $fields['billing_phone'] ) ) {
        $fields['billing_phone']['required'] = true;
        $fields['billing_phone']['label']    = 'Telefone';
    }

    // Campo NIF (opcional)
    $fields['billing_nif'] = array(
        'type'         => 'text',
        'label'        => 'NIF',
        'placeholder'  => '123456789',
        'required'     => false,
        'class'        => array( 'form-row-wide' ),
        'clear'        => true,
        'maxlength'    => 9,
        'priority'     => 110,
        'autocomplete' => 'tax-id',
    );
    return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'prestige_force_checkout_phone_required', 99, 1 );
function prestige_force_checkout_phone_required( $fields ) {
    if ( isset( $fields['billing']['billing_phone'] ) ) {
        $fields['billing']['billing_phone']['required'] = true;
        $fields['billing']['billing_phone']['label']    = 'Telefone';
    }
    return $fields;
}



/**
 * 2. Guardar NIF no meta da encomenda quando o checkout é submetido.
 */
add_action( 'woocommerce_checkout_update_order_meta', 'prestige_save_billing_nif', 10, 1 );
function prestige_save_billing_nif( $order_id ) {
    if ( ! empty( $_POST['billing_nif'] ) ) {
        $nif = sanitize_text_field( $_POST['billing_nif'] );
        update_post_meta( $order_id, '_billing_nif', $nif );
    }
}

/**
 * 3a. Mostrar NIF no painel de administração WooCommerce (detalhe da encomenda).
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'prestige_display_billing_nif_admin', 10, 1 );
function prestige_display_billing_nif_admin( $order ) {
    $nif = get_post_meta( $order->get_id(), '_billing_nif', true );
    if ( ! empty( $nif ) ) {
        echo '<p><strong>NIF:</strong> ' . esc_html( $nif ) . '</p>';
    }
}

/**
 * 3b. Mostrar NIF na página "Minha Conta > Encomendas" (detalhes para o cliente).
 */
add_action( 'woocommerce_order_details_after_order_table', 'prestige_display_billing_nif_frontend', 10, 1 );
function prestige_display_billing_nif_frontend( $order ) {
    $nif = get_post_meta( $order->get_id(), '_billing_nif', true );
    if ( ! empty( $nif ) ) {
        echo '<section class="woocommerce-customer-details">';
        echo '<h2 class="woocommerce-column__title">Dados de Faturação Adicionais</h2>';
        echo '<address><strong>NIF:</strong> ' . esc_html( $nif ) . '</address>';
        echo '</section>';
    }
}

/**
 * 4. Incluir NIF no email de notificação enviado ao administrador.
 */
add_action( 'woocommerce_email_order_meta', 'prestige_add_nif_to_admin_email', 10, 3 );
function prestige_add_nif_to_admin_email( $order, $sent_to_admin, $plain_text ) {
    $nif = get_post_meta( $order->get_id(), '_billing_nif', true );
    if ( empty( $nif ) ) {
        return;
    }
    if ( $plain_text ) {
        echo "\nNIF: " . esc_html( $nif ) . "\n";
    } else {
        echo '<p style="margin:0 0 10px;"><strong>NIF:</strong> ' . esc_html( $nif ) . '</p>';
    }
}

/* ==========================================================================
 * Emails Dinâmicos por Loja — "De" Nome e Endereço
 * Prestige Health vs. Twistshake Portugal
 * ========================================================================== */

/**
 * Helper: verifica se um produto pertence à marca/categoria Twistshake.
 */
function prestige_is_twistshake_product( $product_id ) {
    if ( ! $product_id ) {
        return false;
    }
    $product = wc_get_product( $product_id );
    if ( ! $product ) {
        return false;
    }
    $parent_id = ( $product && $product->is_type( 'variation' ) ) ? $product->get_parent_id() : $product->get_id();

    if ( has_term( 'twistshake', 'product_cat', $parent_id ) ) {
        return true;
    }

    $terms = get_the_terms( $parent_id, 'product_cat' );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        $twistshake_term = get_term_by( 'slug', 'twistshake', 'product_cat' );
        $ts_term_id = $twistshake_term ? (int) $twistshake_term->term_id : 0;
        foreach ( $terms as $term ) {
            if ( $term->slug === 'twistshake' || stripos( $term->name, 'twistshake' ) !== false ) {
                return true;
            }
            if ( $ts_term_id ) {
                $ancestors = get_ancestors( $term->term_id, 'product_cat' );
                if ( ! empty( $ancestors ) && in_array( $ts_term_id, $ancestors, true ) ) {
                    return true;
                }
            }
        }
    }
    return false;
}

/**
 * Helper: detecta a loja a partir do domínio ou do meta da encomenda (funciona em cron).
 */
function prestige_email_is_twistshake( $email_object = null ) {
    // 1. Global definido via hooks de encomenda ou stock (robusto em cron/woo)
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        return $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt';
    }
    // 2. Tenta pelo objeto de email (ordem associada)
    if ( $email_object && isset( $email_object->object ) ) {
        $order = $email_object->object;
        if ( $order instanceof WC_Abstract_Order ) {
            $source = get_post_meta( $order->get_id(), '_order_source_domain', true );
            if ( $source === 'twistshakeportugal.pt' ) {
                return true;
            }
            if ( $source === 'loja.prestigehealth.pt' ) {
                return false;
            }
            // Fallback por itens da encomenda se meta não estiver definido
            foreach ( $order->get_items() as $item ) {
                $pid = $item->get_product_id();
                if ( $pid && prestige_is_twistshake_product( $pid ) ) {
                    return true;
                }
            }
        }
    }
    // 3. Tenta pelo objeto de email Back In Stock (subscriber associado)
    if ( $email_object && ! empty( $email_object->subscriber_id ) ) {
        $sub_id = $email_object->subscriber_id;
        $source = get_post_meta( $sub_id, '_subscriber_source_domain', true );
        if ( $source === 'twistshakeportugal.pt' ) {
            return true;
        }
        $pid = get_post_meta( $sub_id, 'cwginstock_pid', true );
        if ( $pid && prestige_is_twistshake_product( $pid ) ) {
            return true;
        }
        if ( $source === 'loja.prestigehealth.pt' ) {
            return false;
        }
    }
    // 4. Fallback: detecção por HTTP_HOST (pedidos síncronos)
    return custom_multidomain_is_twistshake();
}

/**
 * Filtrar o nome "De" dos emails WooCommerce por domínio ativo.
 */
add_filter( 'woocommerce_email_from_name', 'prestige_dynamic_email_from_name', 99, 2 );
function prestige_dynamic_email_from_name( $from_name, $email ) {
    if ( prestige_email_is_twistshake( $email ) ) {
        return 'Twistshake Portugal';
    }
    return 'Prestige Health';
}

/**
 * Filtrar o endereço "De" dos emails WooCommerce por domínio ativo.
 */
add_filter( 'woocommerce_email_from_address', 'prestige_dynamic_email_from_address', 99, 2 );
function prestige_dynamic_email_from_address( $from_address, $email ) {
    return 'marketing@prestigehealth.pt';
}

/**
 * Filtrar o nome do site (blogname) dinamicamente por loja.
 * Usado pelo WooCommerce no corpo dos emails: cabeçalho, rodapé e texto "conta em X".
 */
add_filter( 'option_blogname', 'prestige_dynamic_blogname', 99 );
function prestige_dynamic_blogname( $value ) {
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        return $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt'
            ? 'Twistshake Portugal'
            : 'Prestige Health';
    }
    if ( defined( 'PRESTIGE_CURRENT_STORE' ) && PRESTIGE_CURRENT_STORE === 'twistshake' ) {
        return 'Twistshake Portugal';
    }
    if ( defined( 'PRESTIGE_CURRENT_STORE' ) && PRESTIGE_CURRENT_STORE === 'prestige' ) {
        return 'Prestige Health';
    }
    return $value;
}

/**
 * Filtrar o rodapé dos emails WooCommerce por loja.
 * Inclui o URL e nome do site correto.
 */
add_filter( 'woocommerce_email_footer_text', 'prestige_dynamic_email_footer', 99 );
function prestige_dynamic_email_footer( $text ) {
    $is_ts = false;
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        $is_ts = ( $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt' );
    } elseif ( defined( 'PRESTIGE_CURRENT_STORE' ) ) {
        $is_ts = ( PRESTIGE_CURRENT_STORE === 'twistshake' );
    } else {
        $is_ts = custom_multidomain_is_twistshake();
    }

    if ( $is_ts ) {
        return 'Twistshake Portugal &bull; <a href="https://twistshakeportugal.pt">www.twistshakeportugal.pt</a> &bull; <a href="mailto:marketing@prestigehealth.pt">marketing@prestigehealth.pt</a>';
    }
    return 'Prestige Health &bull; <a href="https://loja.prestigehealth.pt">www.prestigehealth.pt</a> &bull; <a href="mailto:marketing@prestigehealth.pt">marketing@prestigehealth.pt</a>';
}


/* ==========================================================================
 * Links de Email — Substituição de Domínio por Loja
 * Garante que os links nos emails apontam para o domínio correto.
 *
 * Estratégia: detectar o domínio no início do request (HTTP_HOST/cookie)
 * e guardar numa constante global. O wp_mail filter usa essa constante
 * para substituir os links no HTML final do email.
 * ========================================================================== */

// Detectar e guardar contexto de loja no início do request.
// Esta constante fica disponível durante TODO o ciclo de vida do request,
// incluindo quando wp_mail é chamado posteriormente.
if ( ! defined( 'PRESTIGE_CURRENT_STORE' ) ) {
    if ( custom_multidomain_is_twistshake() ) {
        define( 'PRESTIGE_CURRENT_STORE', 'twistshake' );
    } else {
        define( 'PRESTIGE_CURRENT_STORE', 'prestige' );
    }
}

/**
 * 1. Definir contexto via order meta (para cron/emails futuros).
 *    O meta '_order_source_domain' já é guardado em woocommerce_checkout_create_order.
 */
add_action( 'woocommerce_order_status_changed', 'prestige_email_set_domain_for_order', 1, 3 );
function prestige_email_set_domain_for_order( $order_id, $old_status, $new_status ) {
    $source = get_post_meta( $order_id, '_order_source_domain', true );
    if ( $source ) {
        $GLOBALS['_prestige_email_domain_override'] = $source;
    }
}

add_action( 'woocommerce_order_status_changed', 'prestige_email_clear_domain_override', 99, 3 );
function prestige_email_clear_domain_override( $order_id, $old_status, $new_status ) {
    unset( $GLOBALS['_prestige_email_domain_override'] );
}

/**
 * 2. Post-processar o HTML final de TODOS os emails WordPress.
 *    Usa 3 fontes de contexto em ordem de prioridade:
 *    a) Global de encomenda (cron com status change)
 *    b) Constante do request atual (HTTP_HOST/cookie detetado no início)
 *    c) custom_multidomain_is_twistshake() como último fallback
 */
add_filter( 'wp_mail', 'prestige_fix_twistshake_email_links', 99 );
function prestige_fix_twistshake_email_links( $args ) {
    // Determinar se é Twistshake
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        // Contexto de cron com status change
        $is_twistshake = ( $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt' );
    } elseif ( defined( 'PRESTIGE_CURRENT_STORE' ) ) {
        // Constante definida no início do request (mais fiável)
        $is_twistshake = ( PRESTIGE_CURRENT_STORE === 'twistshake' );
    } else {
        $is_twistshake = custom_multidomain_is_twistshake();
    }

    if ( $is_twistshake ) {
        // ==========================================
        // MODO: TWISTSHAKE PORTUGAL
        // ==========================================
        if ( ! empty( $args['subject'] ) ) {
            $args['subject'] = str_replace(
                array( 'PRESTIGE HEALTH', 'Prestige Health' ),
                array( 'TWISTSHAKE PORTUGAL', 'Twistshake Portugal' ),
                $args['subject']
            );
        }

        if ( ! empty( $args['message'] ) ) {
            $args['message'] = str_replace(
                array(
                    'https://loja.prestigehealth.pt',
                    'http://loja.prestigehealth.pt',
                    'href="https://loja.prestigehealth.pt',
                    'href="http://loja.prestigehealth.pt',
                    'www.prestigehealth.pt',
                ),
                array(
                    'https://twistshakeportugal.pt',
                    'https://twistshakeportugal.pt',
                    'href="https://twistshakeportugal.pt',
                    'href="https://twistshakeportugal.pt',
                    'www.twistshakeportugal.pt',
                ),
                $args['message']
            );
        }
    } else {
        // ==========================================
        // MODO: PRESTIGE HEALTH
        // Substitui assinaturas e cabeçalhos hardcoded de Twistshake para Prestige Health
        // ==========================================
        if ( ! empty( $args['subject'] ) ) {
            $args['subject'] = str_replace(
                array( 'TWISTSHAKE PORTUGAL', 'Twistshake Portugal', 'TWISTSHAKE' ),
                array( 'PRESTIGE HEALTH', 'Prestige Health', 'PRESTIGE HEALTH' ),
                $args['subject']
            );
        }

        if ( ! empty( $args['message'] ) ) {
            $args['message'] = str_replace(
                array(
                    'https://twistshakeportugal.pt',
                    'http://twistshakeportugal.pt',
                    'href="https://twistshakeportugal.pt',
                    'href="http://twistshakeportugal.pt',
                    'www.twistshakeportugal.pt',
                    'twistshakeportugal.pt',
                    'TWISTSHAKE PORTUGAL',
                    'Twistshake Portugal',
                ),
                array(
                    'https://loja.prestigehealth.pt',
                    'https://loja.prestigehealth.pt',
                    'href="https://loja.prestigehealth.pt',
                    'href="https://loja.prestigehealth.pt',
                    'www.prestigehealth.pt',
                    'loja.prestigehealth.pt',
                    'PRESTIGE HEALTH',
                    'Prestige Health',
                ),
                $args['message']
            );
        }
    }

    return $args;
}


/* ==========================================================================
 * Configuração SMTP Nativa — sem plugin
 * Apenas ativo em produção (não em localhost/Docker).
 * Servidor: mail.prestigehealth.pt | Porta: 465 | SSL
 * ========================================================================== */

/**
 * Detectar se estamos em ambiente local (Docker/localhost).
 */
function prestige_is_local_env() {
    $host = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
    return (
        strpos( $host, 'localhost' ) !== false ||
        strpos( $host, '127.0.0.1' ) !== false ||
        strpos( $host, ':8081' ) !== false ||
        strpos( $host, '.local' ) !== false
    );
}

/**
 * Configurar PHPMailer para usar SMTP do hosting em produção.
 * Substitui o mail() nativo do PHP — mais fiável e evita spam.
 */
add_action( 'phpmailer_init', 'prestige_configure_smtp' );
function prestige_configure_smtp( $phpmailer ) {
    // Não aplicar em ambiente local
    if ( prestige_is_local_env() ) {
        return;
    }

    // Usar relay local do hosting (localhost:25) — sem autenticação, sem SSL.
    // É o método mais fiável em hosting partilhado: o Postfix local já trata
    // do DKIM, SPF e entrega para qualquer destino externo.
    $phpmailer->isSMTP();
    $phpmailer->Host       = '127.0.0.1';
    $phpmailer->Port       = 25;
    $phpmailer->SMTPAuth   = false;
    $phpmailer->SMTPSecure = '';
    $phpmailer->SMTPAutoTLS = false;


    // Remetente padrão (respeitando loja ativa e overrides)
    $is_ts = false;
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        $is_ts = ( $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt' );
    } elseif ( defined( 'PRESTIGE_CURRENT_STORE' ) ) {
        $is_ts = ( PRESTIGE_CURRENT_STORE === 'twistshake' );
    } else {
        $is_ts = custom_multidomain_is_twistshake();
    }

    if ( empty( $phpmailer->From ) || $phpmailer->From === 'wordpress@' . gethostname() ) {
        $phpmailer->From = 'marketing@prestigehealth.pt';
    }
    $phpmailer->FromName = $is_ts ? 'Twistshake Portugal' : 'Prestige Health';
}

/**
 * Definir remetente padrão via filtros WordPress (complementa phpmailer_init).
 */
add_filter( 'wp_mail_from', 'prestige_smtp_from_email' );
function prestige_smtp_from_email( $email ) {
    return 'marketing@prestigehealth.pt';
}

add_filter( 'wp_mail_from_name', 'prestige_smtp_from_name', 20 );
function prestige_smtp_from_name( $name ) {
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        return $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt'
            ? 'Twistshake Portugal'
            : 'Prestige Health';
    }
    if ( defined( 'PRESTIGE_CURRENT_STORE' ) && PRESTIGE_CURRENT_STORE === 'twistshake' ) {
        return 'Twistshake Portugal';
    }
    if ( custom_multidomain_is_twistshake() ) {
        return 'Twistshake Portugal';
    }
    return 'Prestige Health';
}


/* ==========================================================================
 * Back In Stock Notifier — Templates e Integração Multi-Loja (PT-PT)
 * Prestige Health vs. Twistshake Portugal
 * ========================================================================== */

/**
 * 1. Gravar a loja no momento da subscrição do alerta de stock.
 */
add_action( 'cwginstock_after_insert_subscriber', 'prestige_bis_record_subscriber_store', 10, 2 );
function prestige_bis_record_subscriber_store( $subscriber_id, $post_data ) {
    $is_ts = false;

    // 1. Verificar referer da requisição (ex: AJAX a partir de twistshakeportugal.pt)
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    if ( strpos( $referer, 'twistshake' ) !== false ) {
        $is_ts = true;
    }

    // 2. Detecção geral da loja (HTTP_HOST, GET store, COOKIE store)
    if ( ! $is_ts && custom_multidomain_is_twistshake() ) {
        $is_ts = true;
    }

    // 3. Verificar se o produto pertence à categoria/marca Twistshake
    if ( ! $is_ts ) {
        $pid = ! empty( $post_data['product_id'] ) ? absint( $post_data['product_id'] ) : get_post_meta( $subscriber_id, 'cwginstock_pid', true );
        if ( $pid && prestige_is_twistshake_product( $pid ) ) {
            $is_ts = true;
        }
    }

    update_post_meta( $subscriber_id, '_subscriber_source_domain', $is_ts ? 'twistshakeportugal.pt' : 'loja.prestigehealth.pt' );
}

/**
 * 2. Personalizar placeholders e contexto de loja antes do envio de emails.
 */
add_filter( 'cwginstock_email_placeholders', 'prestige_bis_filter_email_placeholders', 10, 3 );
function prestige_bis_filter_email_placeholders( $placeholders, $subscriber_id, $email_obj ) {
    $is_twistshake = false;
    if ( ! empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        $is_twistshake = ( $GLOBALS['_prestige_email_domain_override'] === 'twistshakeportugal.pt' );
    } elseif ( $subscriber_id ) {
        $source = get_post_meta( $subscriber_id, '_subscriber_source_domain', true );
        if ( $source === 'twistshakeportugal.pt' ) {
            $is_twistshake = true;
        } else {
            $pid = get_post_meta( $subscriber_id, 'cwginstock_pid', true );
            if ( $pid && prestige_is_twistshake_product( $pid ) ) {
                $is_twistshake = true;
            } elseif ( $source === 'loja.prestigehealth.pt' ) {
                $is_twistshake = false;
            }
        }
    } else {
        $is_twistshake = custom_multidomain_is_twistshake();
    }

    $GLOBALS['_prestige_email_domain_override'] = $is_twistshake ? 'twistshakeportugal.pt' : 'loja.prestigehealth.pt';

    $shop_name = $is_twistshake ? 'Twistshake Portugal' : 'Prestige Health';
    $placeholders['{shopname}'] = $shop_name;

    // Normalizar saudação de nome
    if ( empty( $placeholders['{subscriber_name}'] ) || $placeholders['{subscriber_name}'] === '{subscriber_name}' ) {
        $placeholders['{subscriber_name}'] = 'Estimado(a) Cliente';
    }

    // Ajustar domínios nos links de produto e carrinho
    if ( $is_twistshake ) {
        if ( ! empty( $placeholders['{product_link}'] ) ) {
            $placeholders['{product_link}'] = str_replace(
                array( 'https://loja.prestigehealth.pt', 'http://loja.prestigehealth.pt' ),
                'https://twistshakeportugal.pt',
                $placeholders['{product_link}']
            );
        }
        if ( ! empty( $placeholders['{cart_link}'] ) ) {
            $placeholders['{cart_link}'] = str_replace(
                array( 'https://loja.prestigehealth.pt', 'http://loja.prestigehealth.pt' ),
                'https://twistshakeportugal.pt',
                $placeholders['{cart_link}']
            );
        }
    } else {
        if ( ! empty( $placeholders['{product_link}'] ) ) {
            $placeholders['{product_link}'] = str_replace(
                array( 'https://twistshakeportugal.pt', 'http://twistshakeportugal.pt' ),
                'https://loja.prestigehealth.pt',
                $placeholders['{product_link}']
            );
        }
        if ( ! empty( $placeholders['{cart_link}'] ) ) {
            $placeholders['{cart_link}'] = str_replace(
                array( 'https://twistshakeportugal.pt', 'http://twistshakeportugal.pt' ),
                'https://loja.prestigehealth.pt',
                $placeholders['{cart_link}']
            );
        }
    }

    return $placeholders;
}

/**
 * Limpar override global após envio do email.
 */
add_action( 'woocommerce_email_sent', 'prestige_bis_clear_email_override', 99, 2 );
function prestige_bis_clear_email_override( $return = null, $email_id = '' ) {
    if ( in_array( $email_id, array( 'cwg_bis_subscription', 'cwg_bis_instock' ), true ) ) {
        unset( $GLOBALS['_prestige_email_domain_override'] );
    }
}

/**
 * 3. Textos em Português de Portugal (PT-PT) para o email de confirmação de subscrição.
 * Personalizado conforme pedido da cliente por loja e produto.
 */
add_filter( 'woocommerce_email_subject_cwg_bis_subscription', 'prestige_bis_sub_subject', 20, 3 );
function prestige_bis_sub_subject( $subject, $object, $email = null ) {
    $text = 'Subscrição confirmada | {shopname}';
    if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
        return $email->format_string( $text );
    }
    return $text;
}

add_filter( 'woocommerce_email_heading_cwg_bis_subscription', 'prestige_bis_sub_heading', 20, 3 );
function prestige_bis_sub_heading( $heading, $object, $email = null ) {
    $text = 'Subscrição confirmada';
    if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
        return $email->format_string( $text );
    }
    return $text;
}

add_filter( 'woocommerce_email_additional_content_cwg_bis_subscription', 'prestige_bis_sub_additional_content', 20, 3 );
function prestige_bis_sub_additional_content( $content, $object, $email = null ) {
    $text = "Olá {subscriber_name},<br/><br/>A sua subscrição foi confirmada com sucesso.<br/><br/>Ficará agora na nossa lista de notificações e será informado assim que o produto que pretende estiver novamente disponível.<br/><br/><strong>Produto:</strong> <a href=\"{product_link}\" style=\"color: #111111; text-decoration: underline;\">{product_name}</a><br/><br/>Assim que houver reposição de stock, receberá um email para que possa efetuar a sua compra.<br/><br/>Obrigado pelo seu interesse na {shopname} e por confiar na nossa marca.<br/><br/><strong>{shopname}</strong>";
    if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
        return $email->format_string( $text );
    }
    return $text;
}

/**
 * 4. Textos em Português de Portugal (PT-PT) para o email de produto disponível (reposição de stock).
 * Personalizado conforme pedido da cliente por loja e produto, com botão COMPRAR AGORA.
 */
add_filter( 'woocommerce_email_subject_cwg_bis_instock', 'prestige_bis_instock_subject', 20, 3 );
function prestige_bis_instock_subject( $subject, $object, $email = null ) {
    $text = 'O seu produto já está novamente disponível';
    if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
        return $email->format_string( $text );
    }
    return $text;
}

add_filter( 'woocommerce_email_heading_cwg_bis_instock', 'prestige_bis_instock_heading', 20, 3 );
function prestige_bis_instock_heading( $heading, $object, $email = null ) {
    $text = 'O seu produto já está novamente disponível';
    if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
        return $email->format_string( $text );
    }
    return $text;
}

add_filter( 'woocommerce_email_additional_content_cwg_bis_instock', 'prestige_bis_instock_additional_content', 20, 3 );
function prestige_bis_instock_additional_content( $content, $object, $email = null ) {
    $text = "Olá {subscriber_name},<br/><br/>Temos uma boa notícia: o produto que estava a aguardar já está novamente disponível.<br/><br/><strong>Produto:</strong> <a href=\"{product_link}\" style=\"color: #111111; text-decoration: underline;\">{product_name}</a><br/><br/>Não perca a oportunidade de garantir o seu antes que volte a esgotar.<br/><br/><p style=\"margin: 25px 0;\"><a href=\"{product_link}\" style=\"background-color: #111111; color: #ffffff; padding: 13px 28px; text-decoration: none; font-weight: bold; border-radius: 4px; display: inline-block; font-size: 14px; letter-spacing: 0.05em;\">COMPRAR AGORA</a></p>Obrigado por escolher a {shopname}.<br/><br/><strong>{shopname}</strong>";
    if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
        return $email->format_string( $text );
    }
    return $text;
}

/**
 * 5. Garantir que as opções exibidas e carregadas no WooCommerce wp-admin estejam em PT-PT.
 */
add_filter( 'option_woocommerce_cwg_bis_subscription_settings', 'prestige_bis_sub_settings_pt', 20 );
function prestige_bis_sub_settings_pt( $settings ) {
    if ( ! is_array( $settings ) ) {
        $settings = array();
    }
    $settings['subject'] = 'Subscrição confirmada | {shopname}';
    $settings['heading'] = 'Subscrição confirmada';
    $settings['additional_content'] = "Olá {subscriber_name},<br/><br/>A sua subscrição foi confirmada com sucesso.<br/><br/>Ficará agora na nossa lista de notificações e será informado assim que o produto que pretende estiver novamente disponível.<br/><br/><strong>Produto:</strong> <a href=\"{product_link}\" style=\"color: #111111; text-decoration: underline;\">{product_name}</a><br/><br/>Assim que houver reposição de stock, receberá um email para que possa efetuar a sua compra.<br/><br/>Obrigado pelo seu interesse na {shopname} e por confiar na nossa marca.<br/><br/><strong>{shopname}</strong>";
    return $settings;
}

add_filter( 'option_woocommerce_cwg_bis_instock_settings', 'prestige_bis_instock_settings_pt', 20 );
function prestige_bis_instock_settings_pt( $settings ) {
    if ( ! is_array( $settings ) ) {
        $settings = array();
    }
    $settings['subject'] = 'O seu produto já está novamente disponível';
    $settings['heading'] = 'O seu produto já está novamente disponível';
    $settings['additional_content'] = "Olá {subscriber_name},<br/><br/>Temos uma boa notícia: o produto que estava a aguardar já está novamente disponível.<br/><br/><strong>Produto:</strong> <a href=\"{product_link}\" style=\"color: #111111; text-decoration: underline;\">{product_name}</a><br/><br/>Não perca a oportunidade de garantir o seu antes que volte a esgotar.<br/><br/><p style=\"margin: 25px 0;\"><a href=\"{product_link}\" style=\"background-color: #111111; color: #ffffff; padding: 13px 28px; text-decoration: none; font-weight: bold; border-radius: 4px; display: inline-block; font-size: 14px; letter-spacing: 0.05em;\">COMPRAR AGORA</a></p>Obrigado por escolher a {shopname}.<br/><br/><strong>{shopname}</strong>";
    return $settings;
}

/**
 * 6. Traduzir títulos e descrições na tabela do ecrã WooCommerce > Configurações > Emails.
 */
add_filter( 'gettext', 'prestige_bis_translate_email_titles', 20, 3 );
function prestige_bis_translate_email_titles( $translation, $text, $domain ) {
    if ( $domain === 'back-in-stock-notifier-for-woocommerce' ) {
        if ( $text === 'Back In Stock - Subscription Confirmation' ) {
            return 'Alerta de Stock - Confirmação de Subscrição';
        }
        if ( $text === 'Back In Stock - Product Available' ) {
            return 'Alerta de Stock - Produto Disponível';
        }
        if ( strpos( $text, 'Sent to the subscriber immediately' ) === 0 ) {
            return 'Enviado ao cliente imediatamente após subscrever o alerta de reposição de stock.';
        }
        if ( strpos( $text, 'Sent to subscribers when a product' ) === 0 ) {
            return 'Enviado aos clientes quando o produto subscrito volta a ter stock.';
        }
    }
    return $translation;
}
