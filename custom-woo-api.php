<?php
/**
 * Plugin Name: Custom Woo API
 * Description: Добавляет кастомный REST API эндпоинт для управления товарами WooCommerce.
 * Version: 1.0
 * Author: me & ChatGPT  
 */

if (!defined('ABSPATH')) {
    exit; // Защита от прямого доступа
}

// Подключаем основной класс плагина
require_once plugin_dir_path(__FILE__) . 'includes/class-custom-woo-api.php';

// Запускаем плагин
function custom_woo_api_init() {
    new Custom_Woo_API();
}
add_action('plugins_loaded', 'custom_woo_api_init');
