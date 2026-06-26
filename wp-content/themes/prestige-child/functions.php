<?php
/**
 * Prestige Health Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package prestige-child
 */

add_action( "wp_enqueue_scripts", "prestige_child_parent_theme_enqueue_styles" );

/**
 * Enqueue scripts and styles.
 */
function prestige_child_parent_theme_enqueue_styles() {
	wp_enqueue_style( "storefront-style", get_template_directory_uri() . "/style.css", array(), "0.1.0" );
	wp_enqueue_style(
		"prestige-child-style",
		get_stylesheet_directory_uri() . "/style.css",
		array( "storefront-style" ),
		filemtime( get_stylesheet_directory() . "/style.css" )
	);
}

/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function prestige_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( "free_shipping" === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( "woocommerce_package_rates", "prestige_hide_shipping_when_free_is_available", 100 );

/**
 * Separate Login and Registration forms on My Account page
 */
function prestige_separate_login_registration_scripts() {
    if ( is_account_page() && ! is_user_logged_in() ) {
        ?>
        <style>
            .woocommerce-account .entry-header {
                text-align: center;
                border-bottom: none;
                margin-bottom: 2em;
            }
            .woocommerce-account .entry-title {
                font-size: 2.5em;
                font-weight: 300;
                color: #333;
            }
            #customer_login {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .u-columns.col2-set .u-column1,
            .u-columns.col2-set .u-column2 {
                float: none !important;
                width: 100% !important;
                max-width: 450px;
                margin: 0 auto !important;
                clear: both;
            }
            .u-columns.col2-set .u-column2 {
                display: none;
            }
            .woocommerce-account form.login,
            .woocommerce-account form.register {
                border: 1px solid #eaeaea;
                border-radius: 8px;
                padding: 40px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                background-color: #fff;
                margin-bottom: 10px;
            }
            .woocommerce-account .woocommerce-form-row input.input-text {
                border-radius: 4px;
                padding: 12px 15px;
                border: 1px solid #ddd;
                background-color: #f9f9f9;
            }
            .woocommerce-account .woocommerce-form-row input.input-text:focus {
                background-color: #fff;
                border-color: #005492;
                box-shadow: 0 0 5px rgba(0,84,146,0.2);
            }
            .woocommerce-account .woocommerce-Button {
                width: 100%;
                border-radius: 4px;
                padding: 15px;
                font-size: 1.1em;
                background-color: #005492;
                color: #fff;
                border: none;
                transition: background-color 0.3s;
            }
            .woocommerce-account .woocommerce-Button:hover {
                background-color: #003d6a;
            }
            .woocommerce-LostPassword {
                margin-bottom: 20px;
                text-align: center;
            }
            .woocommerce-LostPassword a {
                color: #666;
                text-decoration: underline;
            }
            .toggle-register-link,
            .toggle-login-link {
                display: block;
                text-align: center;
                margin-top: 15px;
                font-weight: 600;
                color: #005492;
                cursor: pointer;
                text-decoration: none;
                font-size: 1.1em;
            }
            .toggle-register-link:hover,
            .toggle-login-link:hover {
                text-decoration: underline;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var col1 = document.querySelector(".u-columns .u-column1");
                var col2 = document.querySelector(".u-columns .u-column2");
                
                if (col1 && col2) {
                    var createAccountLink = document.createElement("a");
                    createAccountLink.className = "toggle-register-link";
                    createAccountLink.innerHTML = "N&atilde;o tem conta? Criar conta";
                    col1.appendChild(createAccountLink);

                    var loginLink = document.createElement("a");
                    loginLink.className = "toggle-login-link";
                    loginLink.innerHTML = "J&aacute; tem conta? Iniciar Sess&atilde;o";
                    col2.appendChild(loginLink);

                    createAccountLink.addEventListener("click", function(e) {
                        e.preventDefault();
                        col1.style.display = "none";
                        col2.style.display = "block";
                    });

                    loginLink.addEventListener("click", function(e) {
                        e.preventDefault();
                        col2.style.display = "none";
                        col1.style.display = "block";
                    });
                }
            });
        </script>
        <?php
    }
}
add_action( "wp_footer", "prestige_separate_login_registration_scripts" );

