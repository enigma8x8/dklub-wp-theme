<?php

/**
 * Class Name: wp_bootstrap_navwalker
 * Description: A custom WordPress nav walker class to implement clean navigation structure
 * Version: 1.0.0
 */

class wp_bootstrap_navwalker extends Walker_Nav_Menu
{

    // Start Level (Used to output submenus)
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        if ($depth === 0) {
            $output .= '<div class="dropdown-menu"><ul>';
        } else {
            $output .= '<ul>';
        }
    }

    // End Level (Close the submenu wrapper)
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        if ($depth === 0) {
            $output .= '</ul></div>';
        } else {
            $output .= '</ul>';
        }
    }

    // Start Element (Start each menu item)
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        // Add classes to the menu item - ensure classes is always an array
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // Remove unwanted WordPress default classes
        $classes = array_filter($classes, function ($class) {
            return !in_array($class, [
                'menu-item-type-post_type',
                'menu-item-object-page',
                'menu-item-object-service',
                'menu-item-type-post_type_archive',
                'page_item',
                'current_page_item'
            ]);
        });

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $output .= '<li class="' . esc_attr($class_names) . '">';

        // Generate the anchor tag
        $attributes = ' href="' . esc_attr($item->url) . '"';
        $output .= '<a' . $attributes . '>';

        // Output the menu item's title
        $output .= esc_html($item->title);

        $output .= '</a>';
    }

    // End Element (Close each menu item)
    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= '</li>';
    }
}
