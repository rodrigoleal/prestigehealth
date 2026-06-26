<?php
require_once('/var/www/html/wp-load.php');

echo "Setting up Store Part 2...\n";

// 1. Setup Taxes Display
update_option('woocommerce_tax_display_shop', 'excl');
update_option('woocommerce_tax_display_cart', 'excl');
update_option('woocommerce_tax_total_display', 'itemized');
echo "Configured Taxes Display.\n";

// 2. Setup Emails
$email_settings = get_option('woocommerce_new_order_settings');
if(is_array($email_settings)) {
    $email_settings['recipient'] = 'marketing@prestigehealth.pt';
    update_option('woocommerce_new_order_settings', $email_settings);
}

$email_settings = get_option('woocommerce_cancelled_order_settings');
if(is_array($email_settings)) {
    $email_settings['recipient'] = 'marketing@prestigehealth.pt';
    update_option('woocommerce_cancelled_order_settings', $email_settings);
}

$email_settings = get_option('woocommerce_failed_order_settings');
if(is_array($email_settings)) {
    $email_settings['recipient'] = 'marketing@prestigehealth.pt';
    update_option('woocommerce_failed_order_settings', $email_settings);
}
echo "Configured Emails.\n";

echo "Done.\n";
