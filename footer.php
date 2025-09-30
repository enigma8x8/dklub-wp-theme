    </main>
    <footer id="main-footer">
        <div class="footer-content">
            <div class="container">
                <div class="widget-text">
                    <div class="footer-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="">
                    </div>
                    <p>Atklājiet mūsu plašo moduļu un pielāgotu risinājumu klāstu grāmatvedības sistēmām Jumis un Horizon. Uzlabojiet sava uzņēmuma efektivitāti ar mūsu viegli integrējamiem un lietošanai gataviem rīkiem</p>
                </div>

                <div class="cols">
                    <div class="col">
                        <h4 class="widget-title">Moduļi</h4>
                        <ul class="menu">
                            <?php
                            // Получаем 7 последних продуктов
                            $products = wc_get_featured_product_ids();
                            if (empty($products)) {
                                // Если нет избранных продуктов, берем последние
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 7,
                                    'post_status' => 'publish',
                                    'orderby' => 'date',
                                    'order' => 'DESC'
                                );
                                $products_query = new WP_Query($args);

                                if ($products_query->have_posts()) {
                                    while ($products_query->have_posts()) {
                                        $products_query->the_post();
                                        echo '<li class="menu-item"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                                    }
                                    wp_reset_postdata();
                                }
                            } else {
                                // Используем избранные продукты
                                $products = array_slice($products, 0, 7);
                                foreach ($products as $product_id) {
                                    $product = wc_get_product($product_id);
                                    if ($product) {
                                        echo '<li class="menu-item"><a href="' . $product->get_permalink() . '">' . $product->get_name() . '</a></li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="col">
                        <h4 class="widget-title">Izvēlne</h4>
                        <ul class="menu">
                            <?php
                            // Используем меню sidebar для футера
                            wp_nav_menu(array(
                                'theme_location' => 'sidebar',
                                'container'      => false,
                                'items_wrap'     => '%3$s', // только элементы <li>
                                'menu_class'     => '',
                                'fallback_cb'    => false,
                                'depth'          => 1,
                                'walker'         => new class extends Walker_Nav_Menu {
                                    function start_lvl(&$output, $depth = 0, $args = array()) {}
                                    function end_lvl(&$output, $depth = 0, $args = array()) {}
                                    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
                                    {
                                        $output .= '<li class="menu-item"><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                                    }
                                    function end_el(&$output, $item, $depth = 0, $args = array()) {}
                                }
                            ));
                            ?>
                        </ul>
                    </div>

                    <div class="col">
                        <h4 class="widget-title">Svarīgi</h4>
                        <ul class="menu">
                            <li class="menu-item"><a href="<?php echo esc_url(get_permalink(get_page_by_path('lietosanas-noteikumi'))); ?>">Lietošanas noteikumi</a></li>
                            <li class="menu-item"><a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>">Privātuma politika</a></li>
                            <li class="menu-item"><a href="<?php echo esc_url(get_permalink(get_page_by_path('faq-page'))); ?>">BUJ</a></li>
                            <li class="menu-item"><a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakti'))); ?>">Kontakti</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="copyrights-col">
                    <span class="copyrights">&copy; <?php echo date('Y'); ?> dkubs.lv Visas tiesības aizsargātas</span>
                </div>
                
            </div>
        </div>
    </footer>
    <div class="content-overlay"></div>

    <?php wp_footer(); ?>
    </body>

    </html>