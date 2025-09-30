<?php

/**
 * Template Name: FAQ Page
 *
 * @package dklubs
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    $hero_bg_image = get_field('hero_bg_image');
    $hero_bg_url = $hero_bg_image ? esc_url($hero_bg_image['url']) : get_template_directory_uri() . '/assets/images/page-header-bg-faq@1.5x.png';
    ?>
    <section class="page-header" style="background: #206D69 url('<?php echo $hero_bg_url; ?>') center center / cover no-repeat;">
        <div class="container">
            <h1><?php echo get_field('page_title') ?: 'Biežāk uzdotie jautājumi'; ?></h1>
            <p class="sub-text m-0"><?php echo get_field('page_subtitle') ?: 'Šajā sadaļā atradīsiet vērtīgu informāciju un iedvesmojošus pieredzes stāstus, kas palīdzēs jums labāk izprast mūsu produktus un to lietojumu.'; ?></p>
        </div>
    </section>

    <div class="container">
        <div class="faq-page">
            <aside class="content-sidebar w-460">
                <div class="widget categories">
                    <div class="widget-title"><?php echo get_field('sidebar_categories_title') ?: 'Visas kategorijas'; ?></div>

                    <div class="widget-content">
                        <ul class="product-categories">
                            <?php
                            // Получаем текущую категорию из URL
                            $current_faq_cat = isset($_GET['faq_category']) ? sanitize_text_field($_GET['faq_category']) : '';

                            // Слаг категории, которую нужно вывести первой
                            $priority_slug = 'visparigie-jautajumi';

                            // Получаем все FAQ категории
                            $faq_categories = get_terms(array(
                                'taxonomy' => 'faq_category_tax',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ));

                            // Сортируем категории: сначала нужная, потом остальные
                            if ($faq_categories && !is_wp_error($faq_categories)) {
                                usort($faq_categories, function($a, $b) use ($priority_slug) {
                                    if ($a->slug === $priority_slug && $b->slug !== $priority_slug) return -1;
                                    if ($b->slug === $priority_slug && $a->slug !== $priority_slug) return 1;
                                    return strcasecmp($a->name, $b->name);
                                });
                            }

                            // Добавляем "Все" категорию
                            /*?>
                            <li class="cat-item<?php echo (empty($current_faq_cat) ? ' current' : ''); ?>">
                                <a href="<?php echo esc_url(remove_query_arg('faq_category', get_permalink())); ?>">Visie jautājumi</a>
                            </li>
                            <?php
                            */

                            if ($faq_categories):
                                foreach ($faq_categories as $faq_cat): ?>
                                    <li class="cat-item<?php echo ($current_faq_cat == $faq_cat->slug ? ' current' : ''); ?>">
                                        <a href="<?php echo esc_url(add_query_arg('faq_category', $faq_cat->slug, get_permalink())); ?>">
                                            <?php echo esc_html($faq_cat->name); ?>
                                        </a>
                                    </li>
                            <?php endforeach;
                            endif; ?>
                        </ul>
                    </div>

                </div>

                <?php
                    // Заголовок блока (страница → options → дефолт)
                    $sidebar_posts_title = get_field('sidebar_posts_title') ?: get_field('sidebar_posts_title','option') ?: 'Ieskaties padomu sadaļā';

                    // Источник постов: ACF → options → fallback (последние 5)
                    $sidebar_posts = get_field('sidebar_posts');
                    if (!$sidebar_posts) $sidebar_posts = get_field('sidebar_posts','option');

                    $fallback_query = null;
                    if (empty($sidebar_posts)) {
                        $fallback_query = new WP_Query([
                            'post_type'      => 'post',
                            'posts_per_page' => 5,
                            'post_status'    => 'publish'
                            // если нужно ограничить категориями, раскомментируй:
                            // 'category_name'  => 'padoms,noderigi,pieredzes-stasts',
                        ]);
                    }
                    ?>

                    <div class="widget posts-swiper-widget">
                    <div class="widget-title"><?php echo esc_html($sidebar_posts_title); ?></div>

                    <?php if (!empty($sidebar_posts) || ($fallback_query && $fallback_query->have_posts())): ?>
                    <div class="posts-swiper single">
                        <div class="swiper-holder">
                        <div class="swiper">
                            <div class="swiper-wrapper">

                            <?php
                            if (!empty($sidebar_posts)) {
                                foreach ($sidebar_posts as $post_item) {
                                // нормализуем к ID (ID / WP_Post / ['post'=>...])
                                $post_id = 0;
                                if (is_numeric($post_item)) $post_id = (int)$post_item;
                                elseif ($post_item instanceof WP_Post) $post_id = $post_item->ID;
                                elseif (is_array($post_item) && isset($post_item['post'])) {
                                    $p = $post_item['post'];
                                    $post_id = is_numeric($p) ? (int)$p : ($p instanceof WP_Post ? $p->ID : 0);
                                }
                                if (!$post_id) continue;

                                $title   = get_the_title($post_id);
                                $excerpt = get_the_excerpt($post_id);
                                $link    = get_permalink($post_id);
                                $thumb   = get_the_post_thumbnail_url($post_id, 'large');

                                $cats = get_the_category($post_id);
                                $cat_name = $cats ? $cats[0]->name : '';
                                $cat_id   = $cats ? $cats[0]->term_id : 0;

                                $cat_class = match ($cat_name) {
                                    'Padoms' => 'bg-orange',
                                    'Jaunums' => 'bg-blue',
                                    'Noderīgi' => 'bg-light-green',
                                    'Pieredzes stāsts' => 'bg-green',
                                    default => 'bg-orange',
                                };
                                ?>
                                <div class="swiper-slide">
                                    <article class="post-item">
                                    <?php if ($thumb): ?>
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>">
                                    <?php endif; ?>

                                    <?php if ($cat_name && $cat_id): ?>
                                        <a href="<?php echo esc_url(get_category_link($cat_id)); ?>" class="category-sticker <?php echo esc_attr($cat_class); ?>">
                                        <?php echo esc_html($cat_name); ?>
                                        </a>
                                    <?php endif; ?>

                                    <div class="post-content">
                                        <h3 class="entry-title">
                                        <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
                                        </h3>
                                        <p class="excerpt"><?php echo esc_html(wp_trim_words($excerpt, 20, '...')); ?></p>
                                    </div>
                                    </article>
                                </div>
                                <?php
                                }
                            } else {
                                while ($fallback_query->have_posts()) { $fallback_query->the_post(); ?>
                                <div class="swiper-slide">
                                    <article class="post-item">
                                    <?php if (has_post_thumbnail()): the_post_thumbnail('large'); endif; ?>
                                    <?php
                                    $cats = get_the_category();
                                    if ($cats) {
                                        $n = $cats[0]->name; $id = $cats[0]->term_id;
                                        $cl = match ($n) {
                                        'Padoms' => 'bg-orange',
                                        'Jaunums' => 'bg-blue',
                                        'Noderīgi' => 'bg-light-green',
                                        'Pieredzes stāsts' => 'bg-green',
                                        default => 'bg-orange',
                                        }; ?>
                                        <a href="<?php echo esc_url(get_category_link($id)); ?>" class="category-sticker <?php echo esc_attr($cl); ?>"><?php echo esc_html($n); ?></a>
                                    <?php } ?>
                                    <div class="post-content">
                                        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?></p>
                                    </div>
                                    </article>
                                </div>
                                <?php }
                                wp_reset_postdata();
                            } ?>
                            </div>
                        </div>

                        <div class="swiper-nav">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    </div>

                    <?php
                    // Инициализация Swiper (если на странице ещё не инициализируется глобально)
                    if (function_exists('wp_add_inline_script')) {
                    wp_add_inline_script('swiper', "
                        document.addEventListener('DOMContentLoaded', function(){
                        var el = document.querySelector('.posts-swiper.single .swiper');
                        if (!el || el.swiper) return;
                        new Swiper(el, {
                            slidesPerView: 1,
                            
                            navigation: {
                            nextEl: '.posts-swiper-widget .swiper-button-next',
                            prevEl: '.posts-swiper-widget .swiper-button-prev'
                            },
                            breakpoints: { 768: { slidesPerView: 2 } }
                        });
                        });
                    ");
                    }
                    ?>



            </aside>

            <div class="content">
                <div class="accordion" id="faq-accordion">
                    <?php
                    // Получаем текущую категорию FAQ
                    $current_faq_cat = isset($_GET['faq_category']) ? sanitize_text_field($_GET['faq_category']) : '';

                    // Базовые параметры запроса FAQ
                    $faq_args = array(
                        'post_type' => 'faq_item',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    );

                    // Добавляем фильтр по категории, если она выбрана
                    if (!empty($current_faq_cat)) {
                        $faq_args['tax_query'] = array(
                            array(
                                'taxonomy' => 'faq_category_tax',
                                'field' => 'slug',
                                'terms' => $current_faq_cat
                            )
                        );
                    }

                    $faq_query = new WP_Query($faq_args);

                    if ($faq_query->have_posts()):
                        $counter = 1;
                        while ($faq_query->have_posts()): $faq_query->the_post();
                            $question = get_field('faq_question') ?: get_the_title();
                            $answer = get_field('faq_answer') ?: get_the_content();
                    ?>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button<?php echo ($counter > 1 ? ' collapsed' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $counter; ?>" aria-expanded="<?php echo ($counter == 1 ? 'true' : 'false'); ?>" aria-controls="collapse-<?php echo $counter; ?>">
                                        <?php echo esc_html($question); ?>
                                    </button>
                                </h2>

                                <div id="collapse-<?php echo $counter; ?>" class="accordion-collapse collapse<?php echo ($counter == 1 ? ' show' : ''); ?>" data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <?php echo wp_kses_post($answer); ?>
                                    </div>
                                </div>
                            </div>

                        <?php
                            $counter++;
                        endwhile;
                        wp_reset_postdata();
                    else: ?>
                        <p>Nav atrasts neviens jautājums.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>