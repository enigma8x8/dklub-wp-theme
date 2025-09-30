<section class="">
    <?php $hero_image = get_field('hero_image'); ?>

    <section class="mb-5 page-header d-flex align-items-center" style="
    background: url('<?php echo esc_url($hero_image['url']); ?>') center center / cover no-repeat;
   
">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h1 class="section-heading"><?php the_field('modules_page_title'); ?></h1>
                    <span class="sub-heading"><?php the_field('modules_page_subtitle'); ?></span>
                </div>
            </div>
        </div>
    </section>



    <div class="container mb-5">

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
                                <span>
                                    <?php
                                    $note = get_post_meta(get_the_ID(), 'price_note', true);
                                    if ($note) echo esc_html($note);
                                    ?>
                                </span>

                                <?php
                                $payment_type = get_field('payment_type', get_the_ID());

                                if (!empty($payment_type)) {
                                    echo '<span>' . esc_html($payment_type) . '</span>';
                                }
                                ?>

                            </div>
                            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-white">
                                <?php echo __('Izpētīt', 'woocommerce'); ?>
                            </a>
                        </div>
                    </div>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>