<section class="home-consultation-cta">
    <div class="container">
        <div class="consultation-cta">
            <div class="text">
                <h2><?php the_field('consultation_title'); ?></h2>
                <p><?php the_field('consultation_text'); ?></p>
                <div class="cta-btns">
                    <?php $cta1 = get_field('consultation_cta_1_link'); ?>
                    <?php if ($cta1): ?>
                        <a href="<?php echo esc_url($cta1['url']); ?>" class="btn btn-white" <?php if (!empty($cta1['target'])) echo ' target="' . esc_attr($cta1['target']) . '"'; ?>><?php echo esc_html($cta1['title']); ?></a>
                    <?php endif; ?>
                    <?php $cta2 = get_field('consultation_cta_2_link'); ?>
                    <?php if ($cta2): ?>
                        <a href="<?php echo esc_url($cta2['url']); ?>" class="btn btn-transparent" <?php if (!empty($cta2['target'])) echo ' target="' . esc_attr($cta2['target']) . '"'; ?>><?php echo esc_html($cta2['title']); ?></a>
                    <?php endif; ?>

                </div>
                <ul class="features-icons d-flex">
                    <?php if (have_rows('consultation_features')): while (have_rows('consultation_features')): the_row(); ?>
                            <li><?php the_sub_field('feature'); ?></li>
                    <?php endwhile;
                    endif; ?>
                </ul>
            </div>
            <div class="video">
                <video autoplay loop muted playsinline class="bg-video">
                    <source src="<?php the_field('consultation_video'); ?>" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</section>