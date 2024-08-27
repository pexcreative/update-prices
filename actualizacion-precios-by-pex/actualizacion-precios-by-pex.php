<?php
/*
Plugin Name: Actualización de precios by Pex
Description: Actualiza los precios de los productos de WooCommerce en masa con un porcentaje definido por el usuario.
Version: 1.0
Author: Ezequiel Del Vacchio
Plugin URI: http://pex.com.ar
Author URI: https://www.pexcreative.com/desarrollo-de-apps/
*/

// Asegurarse de que WooCommerce esté activo
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

// Agregar la página de administración
function apbp_add_admin_page() {
    add_submenu_page(
        'woocommerce',
        'Actualización de precios',
        'Actualización de precios',
        'manage_woocommerce',
        'apbp-update-prices',
        'apbp_admin_page'
    );
}
add_action('admin_menu', 'apbp_add_admin_page');

// Cargar la página de administración
function apbp_admin_page() {
    include plugin_dir_path(__FILE__) . 'admin-page.php';
}

// Cargar estilos y scripts
function apbp_enqueue_admin_scripts() {
    $screen = get_current_screen();
    if ($screen->id === 'woocommerce_page_apbp-update-prices') {
        wp_enqueue_style('apbp-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/admin-styles.css');
        wp_enqueue_script('apbp-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin-script.js', array('jquery'), null, true);
        wp_localize_script('apbp-admin-script', 'apbp_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('apbp-update-prices-nonce')
        ));
    }
}
add_action('admin_enqueue_scripts', 'apbp_enqueue_admin_scripts');

// Incluir la función de actualización de precios
include plugin_dir_path(__FILE__) . 'update-prices.php';