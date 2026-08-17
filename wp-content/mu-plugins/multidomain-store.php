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
 * Add Meta Facebook Domain Verification Tag globally across all domains.
 */
add_action( 'wp_head', function() {
    echo '<meta name="facebook-domain-verification" content="7g96kl39amhls4d919wimbbjaz09zq" />' . "\n";

}, 0 );


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
 * Automatically hide out-of-stock items from catalog, search, and category listings.
 */
add_filter( 'option_woocommerce_hide_out_of_stock_items', 'custom_multidomain_hide_out_of_stock' );
function custom_multidomain_hide_out_of_stock( $val ) {
    return 'yes';
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
 * Append the active store query parameter to all generated URLs when testing on localhost.
 */
add_filter( 'home_url', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'post_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'post_type_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'page_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'term_link', 'custom_multidomain_append_store_param', 99, 1 );
add_filter( 'wp_setup_nav_menu_item', 'custom_multidomain_filter_menu_item_url', 99, 1 );

function custom_multidomain_append_store_param( $url ) {
    if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return $url;
    }
    
    if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
        return $url;
    }
    
    $host = $_SERVER['HTTP_HOST'];
    // Only apply this locally to ease multi-store testing on same hostname
    if ( strpos( $host, 'localhost' ) === false && strpos( $host, '127.0.0.1' ) === false ) {
        return $url;
    }
    
    // Skip assets and admin pages
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
 * Filter shipping rates:
 * 1. Limit Free Shipping (> 70€) exclusively to Portugal Continental.
 * 2. If destination is Islands (Madeira/Açores), remove Free Shipping.
 * 3. Ensure Local Pickup (Levantamento na Loja) is available with store address.
 * 4. Update rate labels for clarity as requested.
 */
add_filter( 'woocommerce_package_rates', 'custom_multidomain_filter_shipping_rates', 10, 2 );
function custom_multidomain_filter_shipping_rates( $rates, $package ) {
    $country  = isset( $package['destination']['country'] ) ? $package['destination']['country'] : 'PT';
    $postcode = isset( $package['destination']['postcode'] ) ? $package['destination']['postcode'] : '';
    
    $is_island = custom_is_portugal_islands( $postcode, $country );
    
    // Check if free shipping is available (> 70€)
    $has_free_shipping = false;
    foreach ( $rates as $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $has_free_shipping = true;
            break;
        }
    }
    
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'local_pickup' === $rate->method_id ) {
            $rate->label = 'Levantamento na Loja (0 €)';
        } elseif ( $is_island ) {
            // Islands (Madeira & Açores): REMOVE BOTH flat_rate (4.99€) AND free_shipping (0€)!
            // Online delivery is not permitted automatically; customer must contact store by phone/email.
            if ( 'free_shipping' === $rate->method_id || 'flat_rate' === $rate->method_id ) {
                unset( $rates[ $rate_id ] );
            }
        } else {
            // Portugal Continental:
            if ( 'free_shipping' === $rate->method_id ) {
                $rate->label = 'Portugal Continental (0 €)';
            } elseif ( 'flat_rate' === $rate->method_id ) {
                if ( $has_free_shipping ) {
                    // Hide flat rate if free shipping is available
                    unset( $rates[ $rate_id ] );
                } else {
                    $formatted_cost = wc_price( $rate->cost );
                    $rate->label = 'Portugal Continental (' . strip_tags( $formatted_cost ) . ')';
                }
            }
        }
    }
    
    return $rates;
}

/**
 * Format full label for Local Pickup to display the store address.
 */
add_filter( 'woocommerce_cart_shipping_method_full_label', 'custom_multidomain_shipping_method_full_label', 10, 2 );
function custom_multidomain_shipping_method_full_label( $label, $method ) {
    if ( 'local_pickup' === $method->method_id || false !== strpos( $method->id, 'local_pickup' ) ) {
        $address = 'Rua Senador Sousa Fernandes 242, 4760-164 Vila Nova de Famalicão';
        $label = 'Levantamento na Loja (0 €)';
        $label .= '<span class="shipping-method-address" style="display: block; font-size: 0.85em; color: #666; font-weight: normal; margin-top: 2px;">(Morada: ' . esc_html( $address ) . ')</span>';
    }
    return $label;
}

/**
 * Display notice above shipping methods on Checkout & Cart:
 * "* Para as Ilhas Madeira e Açores, contacte-nos"
 */
add_action( 'woocommerce_review_order_before_shipping', 'custom_multidomain_render_islands_notice' );
add_action( 'woocommerce_cart_totals_before_shipping', 'custom_multidomain_render_islands_notice' );
function custom_multidomain_render_islands_notice() {
    static $rendered = false;
    if ( $rendered ) {
        return;
    }
    $rendered = true;
    
    $is_twistshake = custom_multidomain_is_twistshake();
    
    if ( $is_twistshake ) {
        $contact_email = 'geral@twistshakeportugal.pt';
        $contact_phone = '+351 91 663 85 70';
        $phone_link    = 'tel:+351916638570';
        $phone_note    = '(Chamada para a rede móvel nacional)';
        $accent_color  = '#e07a5f';
    } else {
        $contact_email = 'marketing@prestigehealth.pt';
        $contact_phone = '252 095 673';
        $phone_link    = 'tel:252095673';
        $phone_note    = '(Chamada para a rede fixa nacional)';
        $accent_color  = '#005492';
    }
    
    ?>
    <div class="custom-islands-shipping-notice" style="margin: 10px 0 15px 0; padding: 14px 18px; background-color: #f8f9fa; border: 1px solid #e2e8f0; border-left: 4px solid <?php echo esc_attr( $accent_color ); ?>; border-radius: 6px; font-size: 0.93em; color: #333; line-height: 1.6;">
        <p style="margin: 0 0 6px 0; font-weight: 600; color: #2d3748;">
            * Para as Ilhas Madeira e Açores, contacte-nos por telefone ou email:
        </p>
        <div style="font-size: 0.95em; color: #4a5568;">
            <div>
                📞 <strong>Telefone:</strong> 
                <a href="<?php echo esc_url( $phone_link ); ?>" style="color: <?php echo esc_attr( $accent_color ); ?>; font-weight: 600; text-decoration: none;"><?php echo esc_html( $contact_phone ); ?></a> 
                <span style="font-size: 0.85em; color: #718096;"><?php echo esc_html( $phone_note ); ?></span>
            </div>
            <div style="margin-top: 2px;">
                ✉️ <strong>Email:</strong> 
                <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" style="color: <?php echo esc_attr( $accent_color ); ?>; text-decoration: underline; font-weight: 600;"><?php echo esc_html( $contact_email ); ?></a>
            </div>
        </div>
    </div>
    <script>
    if (typeof jQuery !== 'undefined') {
        jQuery(function($) {
            function removeDuplicateIslandsNotices() {
                var $notices = $('.custom-islands-shipping-notice');
                if ($notices.length > 1) {
                    $notices.not(':first').remove();
                }
            }
            removeDuplicateIslandsNotices();
            $(document).on('updated_checkout updated_cart_totals updated_wc_div', function() {
                removeDuplicateIslandsNotices();
            });
        });
    }
    </script>
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
            'post_content'   => '<h2>Termos e Condições de Utilização</h2><p>Bem-vindo ao nosso website. Ao aceder e efetuar compras nesta loja online, concorda com os seguintes termos e condições gerais de venda.</p><h3>1. Objeto</h3><p>As presentes condições regulam as vendas dos produtos apresentados nesta loja online.</p><h3>2. Encomendas e Preços</h3><p>Todos os preços apresentados incluem IVA à taxa legal em vigor. Reservamo-nos o direito de alterar os preços a qualquer momento, garantindo o preço em vigor no momento da confirmação da encomenda.</p><h3>3. Envio e Portes</h3><p>Os envios são efetuados para Portugal Continental e Ilhas. Portes grátis em compras superiores a 70€ para Portugal Continental.</p><h3>4. Devoluções e Direito de Livre Resolução</h3><p>Nos termos da legislação em vigor, o consumidor dispõe do prazo de 14 dias para proceder à devolução do produto adquiridos sem necessidade de indicar o motivo.</p><h3>5. Contactos</h3><p>Para suporte e questões comerciais, contacte <strong>marketing@prestigehealth.pt</strong>.</p>',
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
 * 1. Adicionar campo NIF aos campos de faturação no checkout.
 */
add_filter( 'woocommerce_billing_fields', 'prestige_add_billing_nif_field', 20, 1 );
function prestige_add_billing_nif_field( $fields ) {
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
 * Helper: detecta a loja a partir do domínio ou do meta da encomenda (funciona em cron).
 */
function prestige_email_is_twistshake( $email_object = null ) {
    // 1. Tenta pelo objeto de email (ordem associada) — robusto em cron
    if ( $email_object && isset( $email_object->object ) ) {
        $order = $email_object->object;
        if ( $order instanceof WC_Abstract_Order ) {
            $source = get_post_meta( $order->get_id(), '_order_source_domain', true );
            if ( $source === 'twistshakeportugal.pt' ) {
                return true;
            }
            if ( $source ) {
                return false;
            }
        }
    }
    // 2. Fallback: detecção por HTTP_HOST (pedidos síncronos)
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
 * Forçar home_url correto durante o envio de emails WooCommerce em cron.
 * Guarda o domínio da encomenda num global antes de gerar o conteúdo do email.
 */
add_action( 'woocommerce_email_before_send', 'prestige_email_set_store_context', 1, 3 );
function prestige_email_set_store_context( $email, $to, $subject ) {
    if ( ! isset( $email->object ) ) {
        return;
    }
    $order = $email->object;
    if ( ! $order instanceof WC_Abstract_Order ) {
        return;
    }
    $source = get_post_meta( $order->get_id(), '_order_source_domain', true );
    if ( $source ) {
        $GLOBALS['_prestige_email_domain_override'] = $source;
    }
}

add_action( 'woocommerce_email_after_send', 'prestige_email_clear_store_context', 99 );
function prestige_email_clear_store_context() {
    unset( $GLOBALS['_prestige_email_domain_override'] );
}

/**
 * Adicionar detecção de contexto de email ao filtro option_home.
 * Garante que links nas emails apontem para o domínio correto mesmo em cron.
 */
add_filter( 'option_home', 'prestige_email_override_home_url', 98 );
add_filter( 'option_siteurl', 'prestige_email_override_home_url', 98 );
function prestige_email_override_home_url( $url ) {
    if ( empty( $GLOBALS['_prestige_email_domain_override'] ) ) {
        return $url;
    }
    $source = $GLOBALS['_prestige_email_domain_override'];
    if ( $source === 'twistshakeportugal.pt' ) {
        return 'https://twistshakeportugal.pt';
    }
    return $url;
}
