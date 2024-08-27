<?php
function apbp_update_prices() {
    try {
        check_ajax_referer('apbp-update-prices-nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            throw new Exception('No tienes permisos para realizar esta acción.');
        }

        $percentage = floatval($_POST['percentage']);
        $exclude_products = array_map('intval', explode(',', $_POST['exclude_products']));

        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish',
            'exclude' => $exclude_products,
        ));

        $total_products = count($products);
        $updated_products = 0;
        $skipped_products = 0;

        foreach ($products as $product) {
            $current_price = $product->get_regular_price();
            
            // Verificar si el precio es numérico y mayor que cero
            if (is_numeric($current_price) && floatval($current_price) > 0) {
                $current_price = floatval($current_price);
                $new_price = $current_price * (1 + ($percentage / 100));
                $product->set_regular_price(number_format($new_price, 2, '.', ''));
                $product->save();
                $updated_products++;
            } else {
                $skipped_products++;
            }
        }

        wp_send_json_success(array(
            'progress' => 100,
            'message' => "Se han actualizado $updated_products productos exitosamente. Se omitieron $skipped_products productos sin precio válido."
        ));
    } catch (Exception $e) {
        error_log('Error en apbp_update_prices: ' . $e->getMessage());
        wp_send_json_error('Error: ' . $e->getMessage());
    }
}
add_action('wp_ajax_apbp_update_prices', 'apbp_update_prices');