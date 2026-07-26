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
    $is_twistshake = custom_multidomain_is_twistshake();
    
    if ( $is_twistshake ) {
        $contact_email = 'geral@twistshakeportugal.pt';
        $contact_phone = '+351 91 663 85 70';
        $phone_link    = 'tel:+351916638570';
        $phone_note    = '(Chamada para a rede móvel nacional)';
        $accent_color  = '#e07a5f';
    } else {
        $contact_email = 'geral@prestigehealth.pt';
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
                <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" style="color: <?php echo esc_attr( $accent_color ); ?>; font-weight: 600; text-decoration: underline;"><?php echo esc_html( $contact_email ); ?></a>
            </div>
        </div>
    </div>
    <?php
}
