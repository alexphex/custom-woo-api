<?php

if (!defined('ABSPATH')) {
    exit;
}

class Custom_Woo_API {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes() {
        register_rest_route('custom-woo/v1', '/products', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_products'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('custom-woo/v1', '/products', array(
            'methods'  => 'POST',
            'callback' => array($this, 'create_product'),
            'permission_callback' => array($this, 'check_admin_permission'),
        ));

        register_rest_route('custom-woo/v1', '/products/(?P<id>\d+)', array(
            'methods'  => 'DELETE',
            'callback' => array($this, 'delete_product'),
            'permission_callback' => array($this, 'check_admin_permission'),
        ));
    }

    public function get_products() {
        $args = array(
            'limit' => -1,
        );
        $products = wc_get_products($args);
        $data = array();

        foreach ($products as $product) {
            $data[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' => $product->get_price(),
                'stock_status' => $product->get_stock_status(),
            );
        }

        return rest_ensure_response($data);
    }

    public function create_product(WP_REST_Request $request) {
        $name = sanitize_text_field($request->get_param('name'));
        $price = floatval($request->get_param('price'));
        $stock = intval($request->get_param('stock'));

        if (empty($name) || $price <= 0) {
            return new WP_Error('invalid_data', 'Некорректные данные', array('status' => 400));
        }

        $product = new WC_Product_Simple();
        $product->set_name($name);
        $product->set_price($price);
        $product->set_stock_quantity($stock);
        $product->set_manage_stock(true);
        $product_id = $product->save();

        return rest_ensure_response(array('message' => 'Товар создан', 'product_id' => $product_id));
    }

    public function delete_product(WP_REST_Request $request) {
        $product_id = intval($request->get_param('id'));

        if (!$product_id || get_post_type($product_id) !== 'product') {
            return new WP_Error('not_found', 'Товар не найден', array('status' => 404));
        }

        wp_delete_post($product_id, true);
        return rest_ensure_response(array('message' => 'Товар удален', 'product_id' => $product_id));
    }

    public function check_admin_permission() {
        return current_user_can('manage_woocommerce');
    }
}
