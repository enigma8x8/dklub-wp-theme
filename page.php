<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="content-wrapper">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>

                    <div class="page-content" style="margin: 70px">
                        <?php the_content(); ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>