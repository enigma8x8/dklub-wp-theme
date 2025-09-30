<?php
// -----------------------------------------
// Theme setup
// -----------------------------------------
add_action('after_setup_theme', function () {
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
});

// -----------------------------------------
// Enqueue styles and scripts (единая точка)
// -----------------------------------------
add_action('wp_enqueue_scripts', function () {
    // Пути активной (child/parent) и родительской тем
    $stylesheet_uri = get_stylesheet_directory_uri(); // активная тема (child, если есть)
    $stylesheet_dir = get_stylesheet_directory();
    $template_uri   = get_template_directory_uri();   // родительская тема
    $template_dir   = get_template_directory();

    // Helper для версии по времени изменения файла
    $ver = function ($path) {
        return file_exists($path) ? filemtime($path) : null;
    };

    // 1) Базовые CSS (Bootstrap из родительской темы, если хранится там)
    $bootstrap_css_rel = '/assets/bootstrap/dist/css/bootstrap.css';
    wp_enqueue_style(
        'bootstrap',
        $template_uri . $bootstrap_css_rel,
        [],
        $ver($template_dir . $bootstrap_css_rel)
    );

    // 2) Все CSS из assets/css — сначала дочерняя, затем родительская (чтобы child переопределял)
    $enqueued_css = [];

    $enqueue_css_dir = function ($base_dir, $base_uri) use (&$enqueued_css, $ver) {
        $css_dir = $base_dir . '/assets/css';
        if (is_dir($css_dir)) {
            foreach (glob($css_dir . '/*.css') ?: [] as $css_file) {
                $base = basename($css_file);
                if (isset($enqueued_css[$base])) {
                    continue; // уже подключили из child
                }
                $handle = 'theme-' . basename($base, '.css');
                wp_enqueue_style(
                    $handle,
                    $base_uri . '/assets/css/' . $base,
                    ['bootstrap'],
                    $ver($css_file)
                );
                $enqueued_css[$base] = true;
            }
        }
    };

    // Сначала активная (child или parent), потом родительская
    $enqueue_css_dir($stylesheet_dir, $stylesheet_uri);
    $enqueue_css_dir($template_dir,   $template_uri);

    // 3) Главные стили темы (style.css)
    // Если это дочерняя тема — подключаем родительский style.css, затем дочерний
    if (is_child_theme() && file_exists($template_dir . '/style.css')) {
        wp_enqueue_style(
            'parent-style',
            $template_uri . '/style.css',
            ['bootstrap'],
            $ver($template_dir . '/style.css')
        );
    }

    if (file_exists($stylesheet_dir . '/style.css')) {
        $deps = ['bootstrap'];
        if (is_child_theme()) {
            $deps[] = 'parent-style';
        }
        wp_enqueue_style(
            'theme-style',
            get_stylesheet_uri(), // корректно для child/parent
            $deps,
            $ver($stylesheet_dir . '/style.css')
        );
    }

    // --------- JS ---------

    // Локальный jQuery как основной 'jquery'
    $jquery_rel = '/assets/js/jquery.min.js';
    if (file_exists($template_dir . $jquery_rel)) {
        wp_deregister_script('jquery');
        wp_register_script(
            'jquery',
            $template_uri . $jquery_rel,
            [],
            $ver($template_dir . $jquery_rel),
            true
        );
        wp_enqueue_script('jquery');
    }

    // Bootstrap JS bundle
    $bootstrap_js_rel = '/assets/bootstrap/dist/js/bootstrap.bundle.js';
    wp_enqueue_script(
        'bootstrap-bundle',
        $template_uri . $bootstrap_js_rel,
        ['jquery'],
        $ver($template_dir . $bootstrap_js_rel),
        true
    );

    // Остальные скрипты (если файлы лежат в активной теме — берем оттуда, иначе из родителя)
    $enqueue_js = function ($handle, $rel_path, $deps = []) use ($stylesheet_dir, $stylesheet_uri, $template_dir, $template_uri, $ver) {
        $path = file_exists($stylesheet_dir . $rel_path) ? ($stylesheet_dir . $rel_path) : ($template_dir . $rel_path);
        $uri  = file_exists($stylesheet_dir . $rel_path) ? ($stylesheet_uri . $rel_path) : ($template_uri . $rel_path);
        wp_enqueue_script($handle, $uri, $deps, $ver($path), true);
    };

    $enqueue_js('swiper',              '/assets/js/swiper-bundle.min.js');
    $enqueue_js('bootstrap-select',    '/assets/js/bootstrap-select.min.js', ['jquery']);
    $enqueue_js('search-modal',        '/assets/js/search-modal.js',         ['jquery']);
    $enqueue_js('fancybox',            '/assets/js/jquery.fancybox.min.js',  ['jquery']);
    $enqueue_js('functions-js',        '/assets/js/functions.js',            ['jquery']);
    $enqueue_js('search-autocomplete', '/assets/js/search-autocomplete.js',  ['jquery']);

    // Локализация для AJAX автодополнения
    wp_localize_script('search-autocomplete', 'search_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('search_nonce'),
    ]);
});

// -----------------------------------------
// WooCommerce: замены текста кнопок
// -----------------------------------------
add_filter('woocommerce_product_single_add_to_cart_text', function ($text) {
    return 'Купить';
});

add_filter('woocommerce_product_add_to_cart_text', function ($text) {
    return 'Izpētīt';
});

// -----------------------------------------
// Меню
// -----------------------------------------
register_nav_menus([
    'primary' => __('Primary Menu', 'dklubs'),
    'sidebar' => __('Sidebar Menu', 'dklubs')
]);

require_once get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

// -----------------------------------------
// Кастомные типы записей (FAQ)
// -----------------------------------------
add_action('init', function () {
    // FAQ Item Post Type
    register_post_type('faq_item', array(
        'labels' => array(
            'name'               => 'FAQ Items',
            'singular_name'      => 'FAQ Item',
            'add_new'            => 'Add New Question',
            'add_new_item'       => 'Add New FAQ Question',
            'edit_item'          => 'Edit FAQ Question',
            'new_item'           => 'New FAQ Question',
            'view_item'          => 'View FAQ Question',
            'search_items'       => 'Search FAQ Questions',
            'not_found'          => 'No FAQ questions found',
            'not_found_in_trash' => 'No FAQ questions found in trash'
        ),
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_icon'         => 'dashicons-format-chat',
        'supports'          => array('title', 'editor', 'thumbnail'),
        'has_archive'       => false,
        'rewrite'           => array('slug' => 'faq-item'),
        'show_in_rest'      => true,
        'taxonomies'        => array('faq_category_tax')
    ));

    // FAQ Category Taxonomy
    register_taxonomy('faq_category_tax', 'faq_item', array(
        'labels' => array(
            'name'              => 'FAQ Categories',
            'singular_name'     => 'FAQ Category',
            'search_items'      => 'Search FAQ Categories',
            'all_items'         => 'All FAQ Categories',
            'parent_item'       => 'Parent FAQ Category',
            'parent_item_colon' => 'Parent FAQ Category:',
            'edit_item'         => 'Edit FAQ Category',
            'update_item'       => 'Update FAQ Category',
            'add_new_item'      => 'Add New FAQ Category',
            'new_item_name'     => 'New FAQ Category Name',
            'menu_name'         => 'FAQ Categories'
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'faq-category'),
        'show_in_rest'      => true
    ));
});

// -----------------------------------------
// ACF: загрузка групп полей из JSON
// -----------------------------------------
add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        // product fields
        $acf_json_file = get_template_directory() . '/acf-json-product-fields.json';
        if (file_exists($acf_json_file)) {
            $acf_fields = json_decode(file_get_contents($acf_json_file), true);
            if ($acf_fields) {
                foreach ($acf_fields as $field_group) {
                    acf_add_local_field_group($field_group);
                }
            }
        }

        // папка acf-json
        $acf_json_dir = get_template_directory() . '/acf-json/';
        if (is_dir($acf_json_dir)) {
            $json_files = glob($acf_json_dir . '*.json') ?: [];
            foreach ($json_files as $json_file) {
                $fg = json_decode(file_get_contents($json_file), true);
                if ($fg) {
                    acf_add_local_field_group($fg);
                }
            }
        }
    }
});

// -----------------------------------------
// AJAX Search Autocomplete
// -----------------------------------------
add_action('wp_ajax_search_autocomplete', 'search_autocomplete_callback');
add_action('wp_ajax_nopriv_search_autocomplete', 'search_autocomplete_callback');

function search_autocomplete_callback()
{
    $search_term = isset($_POST['search_term']) ? sanitize_text_field($_POST['search_term']) : '';
    $results = array();

    if (strlen($search_term) < 2) {
        wp_send_json($results);
        return;
    }

    // Search in products
    if (function_exists('wc_get_products')) {
        $products = wc_get_products(array(
            'limit'  => 5,
            'status' => 'publish',
            's'      => $search_term,
        ));

        foreach ($products as $product) {
            $results[] = array(
                'type'   => 'product',
                'title'  => $product->get_name(),
                'url'    => $product->get_permalink(),
                'image'  => wp_get_attachment_image_url($product->get_image_id(), 'thumbnail'),
                'price'  => $product->get_price_html(),
            );
        }
    }

    // Search in posts
    $posts = get_posts(array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        's'              => $search_term,
        'post_status'    => 'publish',
    ));

    foreach ($posts as $post) {
        $results[] = array(
            'type'    => 'post',
            'title'   => $post->post_title,
            'url'     => get_permalink($post->ID),
            'excerpt' => wp_trim_words($post->post_content, 20),
        );
    }

    // Search in pages
    $pages = get_posts(array(
        'post_type'      => 'page',
        'posts_per_page' => 2,
        's'              => $search_term,
        'post_status'    => 'publish',
    ));

    foreach ($pages as $page) {
        $results[] = array(
            'type'  => 'page',
            'title' => $page->post_title,
            'url'   => get_permalink($page->ID),
        );
    }

    wp_send_json($results);
}

// -----------------------------------------
// Gravity Forms: кастомный "спиннер"
// -----------------------------------------
add_filter('gform_ajax_spinner_url', 'custom_gform_empty_spinner', 10, 2);
function custom_gform_empty_spinner($src, $form)
{
    return ''; // Отключаем стандартный спиннер
}

add_action('wp_footer', 'custom_gform_spinner_css');
function custom_gform_spinner_css()
{
    ?>
    <style>
        .gform_ajax_spinner {
            display: inline-block !important;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <?php
}

