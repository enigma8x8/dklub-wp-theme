<section class="home-hero">
    <div class="container">
        <div class="text">
            <h1><?php the_field('hero_title'); ?></h1>
            <p><?php the_field('hero_subtitle'); ?></p>
            <div class="cta-btns d-flex">
                <?php $cta1 = get_field('hero_cta_1_link'); ?>
                <?php if ($cta1): ?>
                    <a href="<?php echo esc_url($cta1['url']); ?>" class="btn btn-primary" <?php if (!empty($cta1['target'])) echo ' target="' . esc_attr($cta1['target']) . '"'; ?>><?php echo esc_html($cta1['title']); ?></a>
                <?php endif; ?>

                <?php $cta2 = get_field('hero_cta_2_link'); ?>
                <?php if ($cta2): ?>
                    <a href="<?php echo esc_url($cta2['url']); ?>" class="btn btn-black" <?php if (!empty($cta2['target'])) echo ' target="' . esc_attr($cta2['target']) . '"'; ?>><?php echo esc_html($cta2['title']); ?></a>
                <?php endif; ?>


            </div>
            <ul class="features-icons d-flex">
                <?php if (have_rows('hero_features')): while (have_rows('hero_features')): the_row(); ?>
                        <li><?php the_sub_field('feature'); ?></li>
                <?php endwhile;
                endif; ?>
            </ul>
        </div>
        <div class="video">
            <video autoplay loop muted playsinline class="bg-video">
                <source src="<?php the_field('hero_video'); ?>" type="video/mp4">
            </video>
            <div class="video-content">
                <span><?php the_field('hero_video_label'); ?></span>
                <ul class="logos d-flex align-items-center">
                    <?php if (have_rows('hero_logos')): while (have_rows('hero_logos')): the_row(); ?>
                            <li><img src="<?php the_sub_field('logo'); ?>" alt=""></li>
                    <?php endwhile;
                    endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="pt-70 pb-80" id="modules-section">
    <div class="container">
        <div class="section-heading-holder">
            <div>
                <h2 class="section-heading"><?php the_field('modules_section_title'); ?></h2>
                <span class="sub-heading"><?php the_field('modules_section_subtitle'); ?></span>
            </div>


            <?php $modules_cta = get_field('modules_section_cta_link'); ?>
            <?php if ($modules_cta): ?>
                <a href="<?php echo esc_url($modules_cta['url']); ?>" class="more-link" <?php if (!empty($modules_cta['target'])) echo ' target="' . esc_attr($modules_cta['target']) . '"'; ?>>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/heading-consultation-icon.svg" alt="">
                    <span><?php echo !empty($modules_cta['title']) ? esc_html($modules_cta['title']) : get_field('modules_section_cta_text'); ?></span>
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
                        'terms'    => 'Gatavs modulis',
                    ),
                ),
            );
            $products = new WP_Query($args);
            if ($products->have_posts()):
                while ($products->have_posts()): $products->the_post();
                    global $product;
            ?>
                    <div class="module-item">
                        <div class="sticker bg-green">
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
                            <p class="m-0"><?php echo apply_filters('woocommerce_short_description', $post->post_excerpt); ?></p>
                        </div>

                        <div class="bottom">
                            <div class="price-holder">
                                <span class="price"><?php echo $product ? $product->get_price_html() : ''; ?></span>
                                <?php
                                // Try to get product_price_period from post meta (ACF or custom field)
                                $product_price_period = get_post_meta(get_the_ID(), 'product_price_period', true);
                                if (!$product_price_period) {
                                    // Try ACF field as fallback
                                    $product_price_period = get_field('product_price_period', get_the_ID());
                                }
                                if ($product_price_period) {
                                    echo '<span>' . esc_html($product_price_period) . '</span>';
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