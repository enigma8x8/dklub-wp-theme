<?php
/**
 * Single Blog Post Template
 * 
 * Template for displaying individual blog posts
 */

get_header();

// Get post data
$post_id = get_the_ID();
$post_title = get_the_title();
$post_content = get_the_content();
$post_date = get_the_date('d.m.Y');
$post_thumbnail = get_the_post_thumbnail_url($post_id, 'full');

// Get ACF fields from post-fields.json
$category_color = get_field('category_color');
$blog_list_title = get_field('blog_list_title');
$blog_list_subtitle = get_field('blog_list_subtitle');

// Get ACF fields from single-blog-fields.json
$post_gallery = get_field('post_gallery');
$header_featured_image = get_field('header_featured_image');
$content_image = get_field('content_image');
$content_title = get_field('content_title');
$content_text = get_field('content_text');
$meta_description = get_field('meta_description');

// Get categories
$categories = get_the_category();
$category_name = '';
$category_class = 'bg-orange'; // default color
$category_bg_style = '';

if ($categories) {
    $category_name = $categories[0]->name;

    // Use custom category sticker if set, otherwise use category name
    if ($category_sticker) {
        $category_name = $category_sticker;
    }

    // Use custom color if set, otherwise determine by category name
    if ($category_color) {
        $category_class = $category_color;

        // If $category_color is a color code (e.g. #FF0000), use it as background
        if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $category_color)) {
            $category_bg_style = 'background:' . esc_attr($category_color) . ';';
            $category_class = ''; // Remove class if using custom color code
        }
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

// Get featured image for header background
$header_background = '';
if ($header_featured_image) {
    $header_background = $header_featured_image['url'];
} elseif ($post_thumbnail) {
    $header_background = $post_thumbnail;
} else {
    $header_background = get_template_directory_uri() . '/assets/images/page-header-bg-single-post-image@1.5x.jpg';
}
?>


<main id="main" class="site-main" role="main">
    <section class="page-header single-post-header" style="background: url('<?php echo esc_url($header_background); ?>') center center / cover no-repeat;">
        <div class="container">
            <div class="page-header-content">
                <div>
                    <time class="added"><?php echo esc_html($post_date); ?></time>

                    <?php if ($category_name): ?>
                        <span class="post-category <?php echo esc_attr($category_class); ?>" <?php if ($category_bg_style) echo ' style="' . $category_bg_style . '"'; ?>><?php echo esc_html($category_name); ?></span>
                    <?php endif; ?>

                    <h1><?php echo esc_html($post_title); ?></h1>

                    <?php if ($blog_list_subtitle): ?>
                        <p class="sub-text m-0"><?php echo esc_html($blog_list_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="single-blog-post">
        <div class="container">
            <article class="post">
                <div class="entry-content">
                    <?php
                    // 1) Основной контент
                    the_content();
                    ?>

                    

                </div>
            </article>
        </div>
    </div>




    <?php //!!!! We need this ?>
    <section class="latest-posts pb-100">
        <div class="container">
            <h2 class="section-heading">Lasiet citus rakstus un padomus</h2>
            <div class="posts-swiper">
                <div class="swiper-holder">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php
                            global $post;
                            $current_post_id = get_the_ID();
                            // Получаем посты кроме текущего
                            $related_posts = new WP_Query(array(
                                'posts_per_page' => 8,
                                'post_status'    => 'publish',
                                'post__not_in'   => array($current_post_id),
                                'orderby'        => 'date',
                                'order'          => 'DESC'
                            ));
                            if ($related_posts->have_posts()): ?>
                                <?php while ($related_posts->have_posts()): $related_posts->the_post(); ?>
                                    <?php
                                    $related_post_id = get_the_ID();
                                    $related_categories = get_the_category($related_post_id);
                                    $related_category_name = '';
                                    $related_category_class = 'bg-orange';
                                    $related_category_bg_style = '';
                                    if ($related_categories) {
                                        $related_category_name = $related_categories[0]->name;
                                        $related_custom_sticker = get_field('category_sticker', $related_post_id);
                                        $related_custom_color   = get_field('category_color', $related_post_id);
                                        if ($related_custom_sticker) {
                                            $related_category_name = $related_custom_sticker;
                                        }
                                        if ($related_custom_color) {
                                            $related_category_class = $related_custom_color;
                                            if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $related_custom_color)) {
                                                $related_category_bg_style = 'background:' . esc_attr($related_custom_color) . ';';
                                                $related_category_class = '';
                                            }
                                        } else {
                                            switch ($related_category_name) {
                                                case 'Padoms': $related_category_class = 'bg-orange'; break;
                                                case 'Jaunums': $related_category_class = 'bg-blue'; break;
                                                case 'Noderīgi': $related_category_class = 'bg-light-green'; break;
                                                case 'Pieredzes stāsts': $related_category_class = 'bg-green'; break;
                                                default: $related_category_class = 'bg-orange';
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="swiper-slide">
                                        <article class="post-item">
                                            <?php if (has_post_thumbnail($related_post_id)): ?>
                                                <?php echo get_the_post_thumbnail($related_post_id, 'large', array('alt' => get_the_title($related_post_id))); ?>
                                            <?php endif; ?>
                                            <?php if ($related_category_name): ?>
                                                <span class="category-sticker <?php echo esc_attr($related_category_class); ?>" <?php if ($related_category_bg_style) echo ' style="' . $related_category_bg_style . '"'; ?>>
                                                    <?php echo esc_html($related_category_name); ?>
                                                </span>
                                            <?php endif; ?>
                                            <div class="post-content">
                                                <h3 class="entry-title">
                                                    <a href="<?php echo get_permalink($related_post_id); ?>">
                                                        <?php
                                                        $related_blog_list_title = get_field('blog_list_title', $related_post_id);
                                                        echo esc_html($related_blog_list_title ? $related_blog_list_title : get_the_title($related_post_id));
                                                        ?>
                                                    </a>
                                                </h3>
                                                <p class="excerpt">
                                                    <?php
                                                    $related_blog_list_subtitle = get_field('blog_list_subtitle', $related_post_id);
                                                    echo esc_html($related_blog_list_subtitle ? $related_blog_list_subtitle : wp_trim_words(get_the_excerpt($related_post_id), 20));
                                                    ?>
                                                </p>
                                            </div>
                                        </article>
                                    </div>
                                <?php endwhile; wp_reset_postdata(); ?>
                            <?php else: ?>
                                <p>Nav citu rakstu.</p>
                            <?php endif; ?>
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
                    


    

</main>

<?php
get_footer();
?>
