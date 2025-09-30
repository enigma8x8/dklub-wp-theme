<section class="pt-70 pb-90 bg-green">
    <div class="container">
        <div class="section-heading-holder text-white">
            <div>
                <h2 class="section-heading"><?php the_field('custom_modules_section_title'); ?></h2>
                <span class="sub-heading"><?php the_field('custom_modules_section_subtitle'); ?></span>
            </div>
            <?php $custom_modules_cta = get_field('custom_modules_section_cta_link'); ?>
            <?php if ($custom_modules_cta): ?>
                <a href="<?php echo esc_url($custom_modules_cta['url']); ?>" class="more-link" <?php if (!empty($custom_modules_cta['target'])) echo ' target="' . esc_attr($custom_modules_cta['target']) . '"'; ?>>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/heading-consultation-icon.svg" alt="">
                    <span><?php echo !empty($custom_modules_cta['title']) ? esc_html($custom_modules_cta['title']) : get_field('custom_modules_section_cta_text'); ?></span>
                </a>
            <?php endif; ?>
        </div>
        <div class="modules-list grid-3">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'name',
                        'terms'    => 'Pielāgojams modulis
',
                    ),
                ),
            );
            $products = new WP_Query($args);
            if ($products->have_posts()):
                while ($products->have_posts()): $products->the_post();
                    global $product;
            ?>
                    <div class="module-item">
                        <div class="sticker bg-dark">
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'product_cat');
                            if ($terms && !is_wp_error($terms)) {
                                echo esc_html($terms[0]->name);
                            }
                            ?>
                        </div>
                        <div class="name-holder">
                            <div class="icon">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('thumbnail', ['alt' => get_the_title()]); ?>
                                <?php endif; ?>
                            </div>
                            <h3 class="name">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                        </div>
                        <div class="description">
                            <p class="m-0"><?php echo get_the_excerpt(); ?></p>
                        </div>
                        <div class="bottom">
                            <div class="price-holder">
                                <span class="price">Sākot no <?php echo $product ? $product->get_price_html() : ''; ?></span>
                                <?php
                                $payment_type = get_field('payment_type', get_the_ID());

                                if (!empty($payment_type)) {
                                    echo '<span class="color-grey">' . esc_html($payment_type) . '</span>';
                                }
                                ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-white">
                                <?php _e('Izpētīt', 'woocommerce'); ?>
                            </a>
                        </div>
                    </div>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>