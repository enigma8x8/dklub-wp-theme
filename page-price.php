<?php

/**
 * Template Name: Price Page Template
 *
 * @package dklubs
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    $hero_bg_image = get_field('hero_bg_image');
    $hero_bg_url = $hero_bg_image ? esc_url($hero_bg_image['url']) : get_template_directory_uri() . '/assets/images/page-header-bg-cena@1.5x.png';
    ?>
    <section class="page-header large" style="background: #206D69 url('<?php echo $hero_bg_url; ?>') center center / cover no-repeat;">
        <div class="container">
            <div class="logo-holder">
                <?php
                $hero_logo = get_field('hero_logo');
                ?>
                <img src="<?php echo esc_url($hero_logo['url']); ?>" alt="<?php echo esc_attr($hero_logo['alt'] ?? 'Logo'); ?>">
                <?php ?>
                <span><?php echo get_field('hero_logo_text'); ?> </span>
                <?php  ?>
            </div>

            <h1><?php echo get_field('page_title'); ?></h1>
            <p class="sub-text m-0"><?php echo get_field('page_subtitle'); ?></p>

            <ul class="features-icons d-flex">
                <?php
                $header_features = get_field('header_features');
                if ($header_features):
                    foreach ($header_features as $feature): ?>
                        <li><?php echo $feature['feature_text']; ?></li>
                <?php endforeach;
                endif; ?>
            </ul>
        </div>
    </section>

    <div class="pricing-page">
        <div class="container">
            <div class="description-text">
                <h2 class="block-heading"><?php echo get_field('description_title'); ?></h2>

                <div class="text">
                    <?php echo get_field('description_content'); ?>
                </div>

                <?php
                $description_button = get_field('description_button');
                if ($description_button): ?>
                    <a href="<?php echo $description_button['url']; ?>" class="btn btn-white"><?php echo $description_button['title']; ?></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="pricing-plans">
            <div class="container">
                <h2 class="block-heading"><?php echo get_field('pricing_title'); ?></h2>

                <div class="plans-list">
                    <?php
                    $pricing_plans = get_field('pricing_plans');
                    if ($pricing_plans):
                        foreach ($pricing_plans as $plan): ?>
                            <div class="plan bg--<?php echo $plan['plan_style']; ?>">
                                <h3 class="plan-name"><?php echo $plan['plan_name']; ?></h3>

                                <div class="price-holder">
                                    <div class="price">
                                        <span><strong><?php echo $plan['price']; ?></strong></span>
                                        <span><?php echo $plan['price_period']; ?></span>
                                    </div>

                                    <?php if ($plan['apply_button']): ?>
                                        <a href="<?php echo $plan['apply_button']['url']; ?>" class="btn btn-white"><?php echo $plan['apply_button']['title']; ?></a>
                                    <?php endif; ?>
                                </div>

                                <ul class="features">
                                    <?php
                                    if ($plan['features']):
                                        foreach ($plan['features'] as $feature): ?>
                                            <li>
                                                <strong><?php echo $feature['feature_title']; ?>:</strong>
                                                <span><?php echo $feature['feature_description']; ?></span>
                                            </li>
                                    <?php endforeach;
                                    endif; ?>
                                </ul>

                                <?php if ($plan['bottom_button']): ?>
                                    <div class="plan-bottom-btn">
                                        <a href="<?php echo $plan['bottom_button']['url']; ?>" class="btn btn-white"><?php echo $plan['bottom_button']['title']; ?></a>
                                    </div>
                                <?php endif; ?>

                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>

        <div class="program-features" id="programmas-iespejas">
            <div class="container">
                <h2 class="block-heading"><?php echo get_field('features_title'); ?></h2>
                <span class="sub-heading"><?php echo get_field('features_subtitle'); ?></span>

                <div class="features-list">
                    <?php
                    $program_features = get_field('program_features');
                    if ($program_features):
                        foreach ($program_features as $feature): ?>
                            <div class="feature-item">
                                <div class="icon">
                                    <img src="<?php echo $feature['feature_icon']['url']; ?>" alt="<?php echo $feature['feature_icon']['alt']; ?>">
                                </div>

                                <h3 class="feature-name"><?php echo $feature['feature_name']; ?></h3>
                                <p class="m-0"><?php echo $feature['feature_description']; ?></p>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>

    </div>
</main>

<?php get_footer(); ?>