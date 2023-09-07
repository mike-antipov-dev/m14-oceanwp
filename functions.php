<?php
/**
 * OceanWP Child Theme Functions
 *
 * When running a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions will be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

function oceanwp_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'oceanwp_add_woocommerce_support' );

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update the theme).
	$theme   = wp_get_theme( 'OceanWP' );
	$version = '0.1.1';

	// Load the stylesheet.
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	
}

add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style', 999 );

/**
 * Делаем товар покупаемым без цены
 */
add_filter('woocommerce_is_purchasable', '__return_TRUE');

/**
 * Меняем поля на странице заказа
 **/
function oceanwp_change_checkout_fields( $fields ) {

    // Детали оплаты
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_phone'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );
    $fields['billing']['billing_company'] = array(
        'type' => 'text',
        'class' => array('form-row'),
        'label' => 'Компания:',
        'required' => true,
        'priority' => 10
    );$fields['billing']['billing_first_name'] = array(
        'type' => 'text',
        'class' => array('form-row'),
        'label' => 'Фамилия, имя:',
        'required' => true,
        'priority' => 20
    );
    $fields['billing']['billing_phone'] = array(
        'type' => 'tel',
        'class' => array('form-row'),
        'label' => 'Телефон:',
        'required' => true,
        'priority' => 30
    );
    $fields['billing']['billing_email'] = array(
        'type' => 'email',
        'class' => array('form-row'),
        'label' => 'E-mail:',
        'required' => true,
        'priority' => 40
    );

    // Детали доставки
    unset( $fields['shipping']['shipping_country'] );
    unset( $fields['shipping']['shipping_company'] );
    unset( $fields['shipping']['shipping_state'] );
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_address_1'] );
    unset( $fields['shipping']['shipping_address_2'] );
    unset( $fields['shipping']['shipping_city'] );
    unset( $fields['shipping']['shipping_postcode'] );
    $fields['shipping']['shipping_first_name'] = array(
        'type' => 'text',
        'class' => array('form-row'),
        'label' => 'Фамилия, имя:',
        'required' => true,
        'priority' => 10
    );
    $fields['shipping']['shipping_phone'] = array(
        'type' => 'tel',
        'class' => array('form-row'),
        'label' => 'Телефон:',
        'required' => true,
        'priority' => 20
    );
    // Используем первую строку адреса для email т.к. по-умолчанию этого поля нет 
    $fields['shipping']['shipping_address_1'] = array(
        'type' => 'email',
        'class' => array('form-row'),
        'label' => 'E-mail:',
        'required' => false,
        'priority' => 30
    );
    $fields['shipping']['shipping_address_2'] = array(
        'type' => 'textarea',
        'class' => array('form-row'),
        'label' => 'Адрес:',
        'required' => true,
        'priority' => 40
    );

    // Комментарии
    unset( $fields['order']['order_comments'] );
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'oceanwp_change_checkout_fields' );

/**
 * Загружаем кастомный JS дочерней темы
 */
function oceanwp_enqueue_child_script() {
    wp_enqueue_script( 'mask', get_stylesheet_directory_uri() . '/inputmask/dist/jquery.inputmask.min.js', array ( 'jquery' ), '1', true );
    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/custom.js', array ( 'mask' ), '0.1.2', true );
}
add_action( 'wp_enqueue_scripts', 'oceanwp_enqueue_child_script' );

/**
 * Убираем аякс из оформления заказа
 */
function oceanwp_remove_checkout_script(){
    wp_dequeue_script( 'wc-checkout' );
}
add_action( 'wp_enqueue_scripts', 'oceanwp_remove_checkout_script' );

/**
 * Меняем лого и ссылку на странице логина
 */
function m14_custom_login_logo() { ?>
    <style>
        #login h1 a, .login h1 a {
            background-image: url('/wp-content/uploads/2023/03/logo-head.png') !important;
            background-size: contain !important;
            width: 100%;
            height: 64px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'm14_custom_login_logo' );

function m14_custom_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'm14_custom_login_url' );
function m14_login_logo_url_redirect() {
    return 'https://m14.onrg.ru/';
}
add_filter( 'login_headertext', 'm14_login_logo_url_redirect' );