<?php
// Load WordPress environment
require_once('/var/www/html/wp-load.php');

echo "Setting up Store...\n";

// 1. Setup Menu
$menu_name = 'Menu Principal';
$menu_exists = wp_get_nav_menu_object( $menu_name );

if( !$menu_exists){
    $menu_id = wp_create_nav_menu($menu_name);
    echo "Created menu: $menu_name (ID: $menu_id)\n";

    // Assign to primary location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    // Get categories
    $categories = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ) );

    // Add specific parent categories
    $cats_to_add = ['Twistshake', 'Calçado', 'Desporto', 'Equipamento de Proteção', 'Geriatria', 'Produto Médicos e Hospitalares'];
    
    foreach ($cats_to_add as $cat_name) {
        $term = get_term_by('name', $cat_name, 'product_cat');
        if ($term) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' =>  $term->name,
                'menu-item-object-id' => $term->term_id,
                'menu-item-object' => 'product_cat',
                'menu-item-type' => 'taxonomy',
                'menu-item-status' => 'publish'
            ));
        }
    }
} else {
    echo "Menu already exists.\n";
}

// 2. Setup WooCommerce Shipping Zones
// First delete existing ones to avoid duplicates
global $wpdb;
$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}woocommerce_shipping_zones");
$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}woocommerce_shipping_zone_locations");
$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}woocommerce_shipping_zone_methods");

// Create 'Portugal' Zone
$zone = new WC_Shipping_Zone(null);
$zone->set_zone_name('Portugal');
$zone->add_location('PT', 'country');
$zone->save();

// Add Flat Rate
$instance_id = $zone->add_shipping_method('flat_rate');
$flat_rate = new WC_Shipping_Flat_Rate($instance_id);
$flat_rate->init_settings();
$settings = $flat_rate->get_settings();
$settings['title'] = 'Portes Normais';
$settings['cost'] = '5.00'; // Default cost, we'll ask user later
update_option($flat_rate->get_instance_option_key(), $settings);

// Add Free Shipping
$free_instance_id = $zone->add_shipping_method('free_shipping');
$free_shipping = new WC_Shipping_Free_Shipping($free_instance_id);
$free_shipping->init_settings();
$free_settings = $free_shipping->get_settings();
$free_settings['title'] = 'Portes Grátis';
$free_settings['requires'] = 'min_amount';
$free_settings['min_amount'] = '70';
update_option($free_shipping->get_instance_option_key(), $free_settings);

echo "Configured Shipping Zones.\n";

// 3. Enable Taxes
update_option('woocommerce_calc_taxes', 'yes');
update_option('woocommerce_prices_include_tax', 'no');

echo "Enabled Taxes.\n";

echo "Done.\n";
