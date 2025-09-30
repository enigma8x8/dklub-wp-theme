<?php get_header(); ?>

<main class="site-main" >
    <div class="container">
        <div class="content-wrapper">
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            <div class="post-thumbnail">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php else : ?>
                                    <div class="no-thumbnail">
                                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M30 5C16.19 5 5 16.19 5 30C5 43.81 16.19 55 30 55C43.81 55 55 43.81 55 30C55 16.19 43.81 5 30 5ZM30 50C18.95 50 10 41.05 10 30C10 18.95 18.95 10 30 10C41.05 10 50 18.95 50 30C50 41.05 41.05 50 30 50Z" fill="#206D69" />
                                            <path d="M30 15C21.72 15 15 21.72 15 30C15 38.28 21.72 45 30 45C38.28 45 45 38.28 45 30C45 21.72 38.28 15 30 15ZM30 40C24.48 40 20 35.52 20 30C20 24.48 24.48 20 30 20C35.52 20 40 24.48 40 30C40 35.52 35.52 40 30 40Z" fill="#206D69" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="post-content">
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </header>

                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                    <?php if (has_category()) : ?>
                                        <span class="categories">
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="read-more">
                                        Lasīt vairāk
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 1L15 8L8 15" stroke="#206D69" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M1 8H15" stroke="#206D69" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12L6 8L10 4" stroke="#206D69" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'next_text' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 4L10 8L6 12" stroke="#206D69" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                ));
                ?>

            <?php else : ?>
                <div class="no-posts">
                    <div class="no-posts-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40 10C23.43 10 10 23.43 10 40C10 56.57 23.43 70 40 70C56.57 70 70 56.57 70 40C70 23.43 56.57 10 40 10ZM40 65C26.75 65 15 53.25 15 40C15 26.75 26.75 15 40 15C53.25 15 65 26.75 65 40C65 53.25 53.25 65 40 65Z" fill="#206D69" />
                            <path d="M40 25C31.72 25 25 31.72 25 40C25 48.28 31.72 55 40 55C48.28 55 55 48.28 55 40C55 31.72 48.28 25 40 25ZM40 50C34.48 50 30 45.52 30 40C30 34.48 34.48 30 40 30C45.52 30 50 34.48 50 40C50 45.52 45.52 50 40 50Z" fill="#206D69" />
                        </svg>
                    </div>
                    <h2>Nav atrasts saturs</h2>
                    <p>Diemžēl nav atrasts neviens ieraksts. Mēģiniet meklēt vai pārlūkot kategorijas.</p>
                    <div class="no-posts-actions">
                        <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Atpakaļ uz sākumu</a>
                        <a href="<?php echo home_url('/?s='); ?>" class="btn btn-secondary">Meklēt</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>