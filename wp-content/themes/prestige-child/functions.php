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

/**
 * Translate WooCommerce strings
 */
function prestige_translate_woocommerce_strings( $translated_text, $text, $domain ) {
    if ( $domain === 'woocommerce' ) {
        if ( $text === 'Have a coupon?' || strtolower($text) === 'have a coupon?' ) {
            $translated_text = 'Tem um cupão?';
        } elseif ( $text === 'Click here to enter your code' || strtolower($text) === 'click here to enter your code' ) {
            $translated_text = 'Clique aqui para inserir o seu código';
        }
    }
    return $translated_text;
}
add_filter( 'gettext', 'prestige_translate_woocommerce_strings', 20, 3 );
/**
 * Custom JS and CSS for cart icon and checkout sidebar
 */
function prestige_custom_cart_checkout_scripts() {
    ?>
    <style>
        /* Hide sidebar on checkout page */
        .woocommerce-checkout #secondary {
            display: none !important;
        }
        .woocommerce-checkout #primary {
            width: 100% !important;
            float: none !important;
        }
        
        /* Hide default storefront basket icon */
        .site-header-cart .cart-contents::after,
        .site-header-cart .cart-contents::before {
            display: none !important;
        }
        
        /* Custom Cart Icon injected via before */
        ul.site-header-cart .cart-contents::before,
        .site-icons .site-header-cart .cart-contents::before {
            content: "" !important;
            display: inline-block !important;
            width: 22px;
            height: 22px;
            margin-right: 8px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            /* Empty Cart SVG */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="%23ffffff" d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41.1 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>');
        }
        
        /* Full Cart SVG */
        ul.site-header-cart .cart-contents.has-items::before,
        .site-icons .site-header-cart .cart-contents.has-items::before {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="%23ffffff" d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41.1 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/><circle cx="288" cy="224" r="48" fill="%23ffcccc"/><circle cx="400" cy="224" r="48" fill="%23ccffcc"/><circle cx="176" cy="224" r="48" fill="%23ccccff"/></svg>');
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateCartIcon() {
                var cartLinks = document.querySelectorAll('.site-header-cart .cart-contents');
                cartLinks.forEach(function(link) {
                    var countEl = link.querySelector('.count');
                    if (countEl) {
                        var text = countEl.innerText.replace(/[^0-9]/g, '');
                        if (parseInt(text, 10) > 0) {
                            link.classList.add('has-items');
                        } else {
                            link.classList.remove('has-items');
                        }
                    }
                });
            }
            
            updateCartIcon();
            
            if (typeof jQuery !== 'undefined') {
                jQuery(document.body).on('updated_cart_totals added_to_cart removed_from_cart', function(){
                    setTimeout(updateCartIcon, 100);
                });
            }
        });
    </script>
    <?php
}
add_action( "wp_footer", "prestige_custom_cart_checkout_scripts", 99 );

/**
 * Filter WooCommerce Product Categories widget to show only categories 
 * that share products with the current category.
 */
function prestige_filter_category_widget_by_current_products( $list_args ) {
    if ( is_product_category() ) {
        global $wpdb;
        $category_id = get_queried_object_id();
        
        $valid_cat_ids = $wpdb->get_col( $wpdb->prepare( "
            SELECT DISTINCT tt2.term_id
            FROM {$wpdb->term_relationships} tr1
            INNER JOIN {$wpdb->term_relationships} tr2 ON tr1.object_id = tr2.object_id
            INNER JOIN {$wpdb->term_taxonomy} tt1 ON tr1.term_taxonomy_id = tt1.term_taxonomy_id
            INNER JOIN {$wpdb->term_taxonomy} tt2 ON tr2.term_taxonomy_id = tt2.term_taxonomy_id
            WHERE tt1.term_id = %d AND tt1.taxonomy = 'product_cat'
            AND tt2.taxonomy = 'product_cat'
        ", $category_id ) );
        
        if ( ! empty( $valid_cat_ids ) ) {
            $list_args['include'] = implode( ',', $valid_cat_ids );
        }
    }
    return $list_args;
}
add_filter( 'woocommerce_product_categories_widget_args', 'prestige_filter_category_widget_by_current_products', 10, 1 );
