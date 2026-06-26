<?php
require 'wp-load.php';

$mbway = get_option('woocommerce_mbway_ifthen_for_woocommerce_settings', array());
$mbway['enabled'] = 'yes';
$mbway['mbwaykey'] = 'GJL-726686';
$mbway['secret_key'] = 'f01c89bb08efbac084459c0b69ba089e';
update_option('woocommerce_mbway_ifthen_for_woocommerce_settings', $mbway);

$multibanco = get_option('woocommerce_multibanco_ifthen_for_woocommerce_settings', array());
$multibanco['enabled'] = 'yes';
$multibanco['api_mode'] = 'yes';
$multibanco['mbkey'] = 'WYH-790104';
$multibanco['secret_key'] = 'ae6bdf0901fa56a96e24cc1e272abc68';
update_option('woocommerce_multibanco_ifthen_for_woocommerce_settings', $multibanco);

$payshop = get_option('woocommerce_payshop_ifthen_for_woocommerce_settings', array());
$payshop['enabled'] = 'yes';
$payshop['payshopkey'] = 'PDL-413286';
$payshop['secret_key'] = '81fd8a914cddcd36611494f21605d0aa';
update_option('woocommerce_payshop_ifthen_for_woocommerce_settings', $payshop);

echo "Updated!";
