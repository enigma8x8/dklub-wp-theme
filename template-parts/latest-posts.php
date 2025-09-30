<section class="latest-posts pt-70 bg-grey">
    <div class="container">
        <div class="section-heading-holder">
            <div>
                <h2 class="section-heading"><?php the_field('latest_posts_title'); ?></h2>
                <span class="sub-heading"><?php the_field('latest_posts_subtitle'); ?></span>
            </div>
            <?php $latest_posts_cta = get_field('latest_posts_cta_link'); ?>
            <?php if ($latest_posts_cta): ?>
                <a href="<?php echo esc_url($latest_posts_cta['url']); ?>" class="more-link" <?php if (!empty($latest_posts_cta['target'])) echo ' target="' . esc_attr($latest_posts_cta['target']) . '"'; ?>>
                    <?php echo !empty($latest_posts_cta['title']) ? esc_html($latest_posts_cta['title']) : get_field('latest_posts_cta_text'); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="posts-swiper">
            <div class="swiper-holder">
                <div class="swiper">
                    <div class="swiper-wrapper ">
                        <?php
                        $latest_posts = new WP_Query(array(
                            'posts_per_page' => 8,
                            'post_status' => 'publish'
                        ));
                        if ($latest_posts->have_posts()):
                            while ($latest_posts->have_posts()): $latest_posts->the_post();
                                $post_id = get_the_ID();
                                $categories = get_the_category($post_id);
                                $category_name = '';
                                $category_class = 'bg-orange'; // default color

                                if ($categories) {
                                    $category_name = $categories[0]->name;
                                    $custom_sticker = get_field('category_sticker', $post_id);
                                    $custom_color = get_field('category_color', $post_id);

                                    // Use custom category sticker if set, otherwise use category name
                                    if ($custom_sticker) {
                                        $category_name = $custom_sticker;
                                    }

                                    // Use custom color if set, otherwise determine by category name
                                    if ($custom_color) {
                                        $category_class = $custom_color;
                                    } else {
                                        switch ($category_name) {
                                            case 'Padoms':
                                                $category_class = 'bg-orange';
                                                break;
                                            case 'Jaunums':
                                                $category_class = 'bg-blue';
                                                break;
                                            case 'Noderīgi':
                                                $category_class = 'bg-light-green';
                                                break;
                                            case 'Pieredzes stāsts':
                                                $category_class = 'bg-green';
                                                break;
                                            default:
                                                $category_class = 'bg-orange';
                                        }
                                    }
                                }
                        ?>
                                <div class="swiper-slide">
                                    <article class="post-item">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                                        <?php endif; ?>

                                        <?php if ($category_name): ?>
                                            <span class="category-sticker <?php echo esc_attr($category_class); ?>"><?php echo esc_html($category_name); ?></span>
                                        <?php endif; ?>

                                        <div class="post-content">
                                            <h3 class="entry-title">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php
                                                    $blog_list_title = get_field('blog_list_title', $post_id);
                                                    echo esc_html($blog_list_title ? $blog_list_title : get_the_title());
                                                    ?>
                                                </a>
                                            </h3>
                                            <p class="excerpt">
                                                <?php
                                                $blog_list_subtitle = get_field('blog_list_subtitle', $post_id);
                                                echo esc_html($blog_list_subtitle ? $blog_list_subtitle : wp_trim_words(get_the_excerpt(), 20));
                                                ?>
                                            </p>
                                        </div>
                                    </article>
                                </div>
                        <?php endwhile;
                            wp_reset_postdata();
                        endif; ?>
                    </div>
                </div>
                <div class="swiper-nav">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</section>