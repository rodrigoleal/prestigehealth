<?php
/**
 * Back In Stock - Subscription Confirmation (Plain text)
 * Prestige Child Theme Override
 *
 * @package BackInStockNotifier/Templates/Emails/Plain
 * @version 7.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo '= ' . wp_strip_all_tags( $email_heading ) . " =\n\n";

if ( $additional_content ) {
	if ( is_object( $email ) && method_exists( $email, 'format_string' ) ) {
		$additional_content = $email->format_string( $additional_content );
	}
	echo "---\n\n";
	echo wp_strip_all_tags( wptexturize( $additional_content ) );
	echo "\n\n";
}

echo "\n---\n" . esc_html( $blogname ) . "\n";
