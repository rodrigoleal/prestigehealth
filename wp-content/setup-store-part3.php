<?php
require_once('/var/www/html/wp-load.php');

echo "Setting up Store Part 3...\n";

// 1. Fix Shipping Zone
$zone_id = 1; // Assuming 1 is Portugal based on the URL in the screenshot
$zone = new WC_Shipping_Zone($zone_id);

// Delete existing methods
$methods = $zone->get_shipping_methods();
foreach($methods as $method) {
    $zone->delete_shipping_method($method->get_instance_id());
}

// Add Flat Rate
$flat_rate_id = $zone->add_shipping_method('flat_rate');
$flat_rate = new WC_Shipping_Flat_Rate($flat_rate_id);
$flat_rate->title = 'Portes Envio';
update_option($flat_rate->get_instance_option_key(), array(
    'title'      => 'Portes Envio',
    'cost'       => '5', // Just setting a default 5
    'tax_status' => 'none'
));

// Add Free Shipping
$free_shipping_id = $zone->add_shipping_method('free_shipping');
$free_shipping = new WC_Shipping_Free_Shipping($free_shipping_id);
$free_shipping->title = 'Portes Grátis';
update_option($free_shipping->get_instance_option_key(), array(
    'title'        => 'Portes Grátis',
    'min_amount'   => '70',
    'requires'     => 'min_amount'
));

echo "Shipping fixed.\n";

// 2. Add Subcategories to Menu
$menu_name = 'Menu Principal';
$menu = wp_get_nav_menu_object($menu_name);

if ($menu) {
    // Find Twistshake parent item
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    $parent_id = 0;
    foreach ($menu_items as $item) {
        if ($item->title == 'Twistshake') {
            $parent_id = $item->ID;
            break;
        }
    }

    if ($parent_id) {
        $subcategories = [
            'Carrinhos De Passeio',
            'Alimentação',
            'Chupetas E Acessórios',
            'Doudous'
        ];

        foreach ($subcategories as $subcat) {
            wp_update_nav_menu_item($menu->term_id, 0, array(
                'menu-item-title'  => $subcat,
                'menu-item-classes' => 'menu-item-category',
                'menu-item-url'    => home_url('/categoria-produto/' . sanitize_title($subcat)),
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $parent_id
            ));
        }
        echo "Subcategories added.\n";
    }
}

echo "Done.\n";
