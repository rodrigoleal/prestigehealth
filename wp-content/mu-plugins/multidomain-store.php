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
add_action( 'pre_get_posts', 'custom_multidomain_pre_get_posts' );
function custom_multidomain_pre_get_posts( $q ) {
    if ( is_admin() ) {
        return;
    }
    
    // Only target main query on frontend for product-related page types
    if ( $q->is_main_query() && ( $q->is_post_type_archive( 'product' ) || $q->is_search() || $q->is_tax( 'product_cat' ) || $q->is_tax( 'product_tag' ) ) ) {
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
 * Tag checkout orders with the domain source.
 */
add_action( 'woocommerce_checkout_create_order', 'custom_multidomain_tag_order', 10, 2 );
function custom_multidomain_tag_order( $order, $data ) {
    $is_twistshake = custom_multidomain_is_twistshake();
    $source = $is_twistshake ? 'twistshakeportugal.pt' : 'loja.prestigehealth.pt';
    $order->update_meta_data( '_order_source_domain', $source );
}
