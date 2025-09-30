<?php

/**
 * Template Name: Blog List Page Template
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
            <h1><?php echo get_field('page_title') ?: 'Raksti un pieredze'; ?></h1>
            <p class="sub-text m-0"><?php echo get_field('page_subtitle') ?: 'Šajā sadaļā atradīsiet vērtīgu informāciju un iedvesmojošus pieredzes stāstus, kas palīdzēs jums labāk izprast mūsu produktus un to lietojumu.'; ?></p>
        </div>
    </section>

    <div class="container">
        <div class="blog-list-page">
            <aside class="content-sidebar w-345">
                <div class="widget categories">
                    <div class="widget-title"><?php echo get_field('sidebar_categories_title') ?: 'Rakstu kategorijas'; ?></div>

                    <div class="widget-content">
                        <ul class="product-categories">
                            <?php
                            // Получаем текущую категорию из URL
                            $current_cat = isset($_GET['category']) ? $_GET['category'] : '';

                            // Получаем все категории
                            $all_categories = get_categories(array(
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ));

                            // Добавляем "Все" категорию
                            ?>
                            <li class="cat-item<?php echo (empty($current_cat) ? ' current' : ''); ?>">
                                <a href="<?php echo esc_url(remove_query_arg('category', get_permalink())); ?>">Jaunākie</a>
                            </li>

                            <?php
                            if ($all_categories):
                                foreach ($all_categories as $cat): ?>
                                    <li class="cat-item<?php echo ($current_cat == $cat->slug ? ' current' : ''); ?>">
                                        <a href="<?php echo esc_url(add_query_arg('category', $cat->slug, get_permalink())); ?>">
                                            <?php echo esc_html($cat->name); ?>
                                        </a>
                                    </li>
                            <?php endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>

                <?php
                $sidebar_banner = get_field('sidebar_banner');
                if ($sidebar_banner): ?>
                    <div class="sidebar-bnr" style="background: url('<?php echo esc_url($sidebar_banner['background_image']['url']); ?>') center center / cover no-repeat;">
                        <div>
                            <div class="logo-holder">
                                <img src="<?php echo esc_url($sidebar_banner['logo']['url']); ?>" alt="<?php echo esc_attr($sidebar_banner['logo']['alt']); ?>">
                                <span><?php echo esc_html($sidebar_banner['logo_text']); ?></span>
                            </div>

                            <h4 class="title"><?php echo esc_html($sidebar_banner['title']); ?></h4>

                            <div class="btn-holder d-flex align-items-center justify-content-between">
                                <span><?php echo esc_html($sidebar_banner['button_text']); ?></span>
                                <?php if ($sidebar_banner['button_label']): ?>
                                    <a href="<?php echo esc_url($sidebar_banner['button_label']['url']); ?>" class="btn btn-white">
                                        <?php echo esc_html($sidebar_banner['button_label']['title']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="sidebar-bnr" style="background: url('<?php echo get_template_directory_uri(); ?>/assets/images/sidebar-bnr-img.jpg') center center / cover no-repeat;">
                        <div>
                            <div class="logo-holder">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/sidebar-bnr-shopify-logo.svg" alt="">
                                <span>Integrācija ar Shopify</span>
                            </div>

                            <h4 class="title">Reklāmas baneris ar tekstu</h4>

                            <div class="btn-holder d-flex align-items-center justify-content-between">
                                <span>Reklāmas baneris</span>
                                <a href="#" class="btn btn-white">Izpētīt</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </aside>

            <div class="content">
                <div class="posts-grid grid-3">
                    <?php
                    // Настройки для вывода постов с пагинацией
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $posts_per_page = 13; // Выводим только 3 поста на страницу

                    // Получаем текущую категорию из URL
                    $current_cat = isset($_GET['category']) ? $_GET['category'] : '';

                    // Базовые параметры запроса
                    $query_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $posts_per_page,
                        'paged' => $paged,
                        'post_status' => 'publish'
                    );

                    // Добавляем фильтр по категории, если она выбрана
                    if (!empty($current_cat)) {
                        $query_args['category_name'] = $current_cat;
                    }

                    $blog_query = new WP_Query($query_args);

                    if ($blog_query->have_posts()):
                        while ($blog_query->have_posts()): $blog_query->the_post();
                            $category_sticker = get_field('category_sticker');
                            $category_color = get_field('category_color') ?: 'bg-orange';
                    ?>

                            <article class="post-item">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                                <?php endif; ?>
                                <?php $cat = get_the_category();
                                if ($cat):
                                    $cat_name = $cat[0]->name;
                                    $cat_class = '';
                                    switch ($cat_name) {
                                        case 'Padoms':
                                            $cat_class = 'bg-orange';
                                            break;
                                        case 'Jaunums':
                                            $cat_class = 'bg-blue';
                                            break;
                                        case 'Noderīgi':
                                            $cat_class = 'bg-light-green';
                                            break;
                                        case 'Pieredzes stāsts':
                                            $cat_class = 'bg-green';
                                            break;
                                        default:
                                            $cat_class = 'bg-orange';
                                    }
                                ?>
                                    <a href="<?php echo get_category_link($cat[0]->term_id); ?>" class="category-sticker <?php echo $cat_class; ?>"><?php echo esc_html($cat[0]->name); ?></a>
                                <?php endif; ?>
                                <div class="post-content">
                                    <h3 class="entry-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                            $custom_title = get_field('blog_list_title');
                                            echo $custom_title ? esc_html($custom_title) : get_the_title();
                                            ?>
                                        </a>
                                    </h3>
                                    <p class="excerpt">
                                        <?php
                                        $custom_subtitle = get_field('blog_list_subtitle');
                                        echo $custom_subtitle ? esc_html($custom_subtitle) : wp_trim_words(get_the_excerpt(), 20, '...');
                                        ?>
                                    </p>
                                </div>
                            </article>
                        <?php endwhile;
                        wp_reset_postdata();
                    else: ?>
                        <p>Nav atrasts neviens raksts.</p>
                    <?php endif; ?>
                </div>

                <?php if ($blog_query->max_num_pages > 1): ?>
                    <nav class="navigation pagination">
                        <div class="nav-links">
                            <?php
                            $big = 999999999; // любое большое число

                            $pagination_args = array(
                                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format'    => '?paged=%#%',
                                'current'   => max(1, get_query_var('paged')),
                                'total'     => $blog_query->max_num_pages,
                                'prev_text' => '&laquo;',
                                'next_text' => '&raquo;',
                                'end_size'  => 3,
                                'mid_size'  => 3,
                                'type'      => 'plain', // <-- ВАЖНО: plain вместо list
                            );

                            if (!empty($current_cat)) {
                                $pagination_args['add_args'] = array('category' => $current_cat);
                            }

                            echo paginate_links($pagination_args);
                            ?>
                        </div>
                    </nav>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>