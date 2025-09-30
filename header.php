<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    // SEO Meta Tags
    if (is_single() && get_post_type() === 'post') {
        $meta_description = get_field('meta_description');
        if (!$meta_description) {
            $meta_description = wp_trim_words(get_the_excerpt(), 25);
        }
        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }

        // Open Graph tags
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";

        if (has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
        }

        if ($meta_description) {
            echo '<meta property="og:description" content="' . esc_attr($meta_description) . '">' . "\n";
        }

        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        if ($meta_description) {
            echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '">' . "\n";
        }
        if (has_post_thumbnail()) {
            echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
        }
    }
    ?>

    <?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header id="masthead" class="site-header">
        <div class="top-bar">
            <div class="container">
                <ul class="header-contacts d-flex align-items-center">
                    <li><a href="mailto:dkubs@dkubs.lv">dkubs@dkubs.lv</a></li>
                    <li><a href="tel:+37167816048">+371 67 816 048</a></li>
                </ul>

                <ul class="links d-flex align-items-center">
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('faq-page'))); ?>">BUJ</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('par-mums'))); ?>">Par mums</a></li>
                    
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakti'))); ?>">Kontakti</a></li>
                </ul>
            </div>
        </div>

        <div class="container btm">
            <div class="left-side">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>">
                </a>

                <nav id="site-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'menu_id'         => 'primary-menu-list',
                        'menu_class'      => '',
                        'fallback_cb'     => false,
                        'walker'          => new WP_Bootstrap_Navwalker()
                    ));
                    ?>

                    <div class="mobile-view">
                        <?php
                        wp_nav_menu([
                            'theme_location'  => 'sidebar',
                            'depth'           => 1,
                            'container'       => false,
                            'menu_class'      => 'links',
                            'fallback_cb'     => false,
                        ]);
                        ?>

                        <a href="<?php echo esc_url(home_url('/#faq-section')); ?>" class="btn btn-primary cons-btn">Konsultācija</a>
                    </div>
                </nav>
            </div>

            <div class="right-side">
                <div class="buttons">
                    <a href="#" class="search-toggle" data-toggle="modal" data-target="#searchModal">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_7_3917)">
                                <path d="M20.8012 19.8575L15.3794 14.5223C16.7992 12.9797 17.6716 10.9396 17.6716 8.69472C17.6709 3.89245 13.7154 0 8.83568 0C3.95597 0 0.000488281 3.89245 0.000488281 8.69472C0.000488281 13.497 3.95597 17.3894 8.83568 17.3894C10.9441 17.3894 12.8778 16.6602 14.3967 15.4478L19.8396 20.804C20.1048 21.0653 20.5354 21.0653 20.8006 20.804C21.0664 20.5428 21.0664 20.1188 20.8012 19.8575ZM8.83568 16.0517C4.70692 16.0517 1.35991 12.7579 1.35991 8.69472C1.35991 4.63156 4.70692 1.33773 8.83568 1.33773C12.9645 1.33773 16.3115 4.63156 16.3115 8.69472C16.3115 12.7579 12.9645 16.0517 8.83568 16.0517Z" fill="#206D69" />
                            </g>
                            <defs>
                                <clipPath id="clip0_7_3917">
                                    <rect width="21" height="21" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>

                    <?php if (function_exists('wc_get_page_permalink')): ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                            <svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.964014 23.258C0.938014 23.258 0.938014 23.258 0.912014 23.258C0.574014 23.232 0.340014 22.946 0.366014 22.634C0.704014 17.668 5.38401 13.794 11 13.794C16.616 13.794 21.296 17.668 21.634 22.608C21.66 22.946 21.4 23.206 21.088 23.232C20.75 23.258 20.49 22.998 20.464 22.686C20.152 18.344 15.992 14.964 11 14.964C5.98202 14.964 1.82201 18.37 1.53601 22.712C1.51001 23.024 1.25001 23.258 0.964014 23.258Z" fill="#206D69" />
                                <path d="M11 12.598C7.72402 12.598 5.07202 9.946 5.07202 6.67C5.07202 3.394 7.72402 0.742004 11 0.742004C14.276 0.742004 16.928 3.394 16.928 6.67C16.928 9.946 14.276 12.598 11 12.598ZM11 1.938C8.40002 1.938 6.26802 4.07 6.26802 6.67C6.26802 9.27001 8.40002 11.402 11 11.402C13.6 11.402 15.732 9.27001 15.732 6.67C15.732 4.07 13.6 1.938 11 1.938Z" fill="#206D69" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if (function_exists('wc_get_cart_url') && function_exists('WC')): ?>
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-cart <?php echo WC()->cart->is_empty() ? 'no-items' : ''; ?>">
                            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.8181 19.1456C22.9408 19.1338 23.9224 18.3756 24.2104 17.2882L26.9788 6.9787C27.0669 6.64367 26.873 6.30276 26.538 6.20872C26.4851 6.19696 26.4322 6.18521 26.3793 6.18521H5.55446L4.13792 0.954026C4.06739 0.68365 3.82052 0.489685 3.53839 0.489685H0V1.74164H3.04466L4.41418 6.85527C4.4083 6.89641 4.4083 6.93756 4.41418 6.9787L7.23549 17.3235C7.25312 17.4058 7.28251 17.494 7.3119 17.5762L8.26409 21.0441C7.34716 21.532 6.72412 22.4959 6.72412 23.6068C6.72412 25.2114 8.0231 26.5104 9.62772 26.5104C11.2323 26.5104 12.5313 25.2114 12.5313 23.6068C12.5313 23.1072 12.402 22.6311 12.1787 22.2197C12.1258 22.1256 12.0729 22.0316 12.0082 21.9375H19.3965C19.0674 22.4077 18.8675 22.9838 18.8675 23.6068C18.8675 25.2114 20.1665 26.5104 21.7711 26.5104C23.3757 26.5104 24.6747 25.2114 24.6747 23.6068C24.6747 22.8486 24.3867 22.1609 23.9106 21.6436C23.3992 21.0617 22.6469 20.6914 21.8064 20.6856H9.51605L9.07522 19.0692C9.2633 19.1162 9.45727 19.1456 9.65123 19.1456H21.8181ZM21.777 21.9375C22.6998 21.9375 23.4463 22.684 23.4463 23.6068C23.4463 24.5296 22.6998 25.2761 21.777 25.2761C20.8542 25.2761 20.1077 24.5296 20.1077 23.6068C20.1077 22.684 20.8542 21.9375 21.777 21.9375ZM9.62772 21.9375C10.5505 21.9375 11.2911 22.6899 11.2911 23.6068C11.2911 24.5296 10.5446 25.2761 9.62185 25.2761C8.69904 25.2761 7.95845 24.5296 7.95845 23.6068C7.95845 22.684 8.70492 21.9375 9.62772 21.9375ZM8.51095 17.1002L7.10618 11.963L5.85422 7.44892H25.5387L22.9937 17.0061C22.8526 17.5527 22.3648 17.9348 21.8005 17.9465H9.63948C9.12812 17.9172 8.68141 17.588 8.51095 17.1002Z" fill="#206D69" />
                            </svg>
                            <?php /* if (!WC()->cart->is_empty()): ?>
                                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <?php endif; */?>
                        </a>
                    <?php endif; ?>
                </div>

                <a href="<?php echo esc_url(home_url('/#faq-section')); ?>" class="btn btn-primary cons-btn">Konsultācija</a>

                <button type="button" class="menu-toggle">
                    <i class="icon"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-wrapper">
                            <input type="search" class="search-field" placeholder="Meklēt..." value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_7_3917)">
                                        <path d="M20.8012 19.8575L15.3794 14.5223C16.7992 12.9797 17.6716 10.9396 17.6716 8.69472C17.6709 3.89245 13.7154 0 8.83568 0C3.95597 0 0.000488281 3.89245 0.000488281 8.69472C0.000488281 13.497 3.95597 17.3894 8.83568 17.3894C10.9441 17.3894 12.8778 16.6602 14.3967 15.4478L19.8396 20.804C20.1048 21.0653 20.5354 21.0653 20.8006 20.804C21.0664 20.5428 21.0664 20.1188 20.8012 19.8575ZM8.83568 16.0517C4.70692 16.0517 1.35991 12.7579 1.35991 8.69472C1.35991 4.63156 4.70692 1.33773 8.83568 1.33773C12.9645 1.33773 16.3115 4.63156 16.3115 8.69472C16.3115 12.7579 12.9645 16.0517 8.83568 16.0517Z" fill="#206D69" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_7_3917">
                                            <rect width="21" height="21" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>