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
 * Determine if the current request is for the Twistshake storefront.
 */
function custom_multidomain_is_twistshake() {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    
    // Check if the domain is the official Twistshake domain
    if ( strpos( $host, 'twistshakeportugal.pt' ) !== false || strpos( $host, 'twistshake' ) !== false ) {
        return true;
    }
    
    // Allow URL query parameters for testing (e.g. ?store=twistshake)
    if ( isset( $_GET['store'] ) ) {
        if ( $_GET['store'] === 'twistshake' ) {
            if ( ! headers_sent() ) {
                setcookie( 'store', 'twistshake', time() + 3600 * 24 * 30, '/' );
            }
            return true;
        } elseif ( $_GET['store'] === 'prestige' ) {
            if ( ! headers_sent() ) {
                setcookie( 'store', '', time() - 3600, '/' );
            }
            return false;
        }
    }
    
    // Check if the cookie is set
    if ( isset( $_COOKIE['store'] ) && $_COOKIE['store'] === 'twistshake' ) {
        return true;
    }
    
    return false;
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
    } else {
        // EXCLUDE Twistshake products from main site
        $tax_query[] = array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => array( $category_slug ),
            'operator'         => 'NOT IN',
            'include_children' => true,
        );
    }
    
    $q->set( 'tax_query', $tax_query );
}

/**
 * Filter main product queries (archives, search, categories).
 */
add_action( 'pre_get_posts', 'custom_multidomain_pre_get_posts', 99 );
function custom_multidomain_pre_get_posts( $q ) {
    if ( is_admin() ) {
        return;
    }
    
    $post_types = (array) $q->get( 'post_type' );
    if ( in_array( 'product', $post_types ) ) {
        // Skip single product pages and direct ID fetches (e.g. cart/checkout)
        if ( $q->is_single() || $q->is_singular() || $q->get( 'p' ) || $q->get( 'post__in' ) ) {
            return;
        }
        
        $is_twistshake = custom_multidomain_is_twistshake();
        custom_apply_product_visibility_filter( $q, $is_twistshake );
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
    } else {
        $tax_query[] = array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug',
            'terms'            => array( $category_slug ),
            'operator'         => 'NOT IN',
            'include_children' => true,
        );
    }
    
    $query['tax_query'] = $tax_query;
    return $query;
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
    
    // Hide Twistshake links from Prestige Health
    if ( ! $is_twistshake && is_array( $items ) ) {
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
    if ( ! is_wp_error( $link ) ) {
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
        if ( ! is_wp_error( $fallback_link ) ) {
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
