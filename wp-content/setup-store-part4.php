<?php
require_once('/var/www/html/wp-load.php');

echo "Setting up Store Part 4...\n";

// Update permalinks
$permalinks = get_option('woocommerce_permalinks');
if (!$permalinks) {
    $permalinks = array();
}

$permalinks['category_base'] = 'categoria-produto';
$permalinks['tag_base'] = 'etiqueta-produto';
$permalinks['product_base'] = 'produto';

update_option('woocommerce_permalinks', $permalinks);

// Also set WordPress permalinks to post name (usually required for nice URLs)
update_option('permalink_structure', '/%postname%/');

// Flush rewrite rules
flush_rewrite_rules();

echo "Permalinks updated and flushed.\n";
