<section class="faq" id="faq-section">
    <div class="container">
        <div class="accordion-container">
            <div class="section-heading-holder">
                <div>
                    <h2 class="section-heading">
                        <?php
                        $faq_title = get_field('faq_title');
                        echo $faq_title ? esc_html($faq_title) : 'Biežāk uzdotie jautājumi';
                        ?>
                    </h2>
                    <span class="sub-heading">
                        <?php
                        $faq_subtitle = get_field('faq_subtitle');
                        echo $faq_subtitle ? esc_html($faq_subtitle) : 'Šajā sadaļā atradīsiet vērtīgu informāciju un iedvesmojošus pieredzes stāstus, kas palīdzēs jums labāk izprast mūsu produktus un to lietojumu.';
                        ?>
                    </span>
                </div>
            </div>
            <div class="accordion" id="faq-accordion">
                <?php
                // Получаем вопросы из категории "Vispārīgie jautājumi"
                $faq_args = array(
                    'post_type' => 'faq_item',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'faq_category_tax',
                            'field'    => 'name',
                            'terms'    => 'Vispārīgie jautājumi',
                        ),
                    ),
                );
                $faq_query = new WP_Query($faq_args);
                if ($faq_query->have_posts()):
                    $i = 1;
                    while ($faq_query->have_posts()): $faq_query->the_post();
                        $question = get_field('faq_question') ?: get_the_title();
                        $answer = get_field('faq_answer') ?: get_the_content();
                ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button<?php if ($i > 1) echo ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $i; ?>" aria-expanded="<?php echo $i === 1 ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $i; ?>">
                                    <?php echo esc_html($question); ?>
                                </button>
                            </h2>
                            <div id="collapse-<?php echo $i; ?>" class="accordion-collapse collapse<?php if ($i === 1) echo ' show'; ?>" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    <?php echo wp_kses_post($answer); ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                else: ?>
                    <p>Nav atrasts neviens jautājums šajā kategorijā.</p>
                <?php endif; ?>
            </div>
            <?php $faq_cta = get_field('faq_cta_link'); ?>
            <?php
            if ($faq_cta) : ?>
                <a href="<?php echo esc_url($faq_cta['url']); ?>" class="btn btn-white" <?php if (!empty($faq_cta['target'])) echo ' target="' . esc_attr($faq_cta['target']) . '"'; ?>>
                    <?php echo esc_html($faq_cta['title']); ?>
                </a>
            <?php else:
                $kontakti_url = get_permalink(get_page_by_path('kontakti'));
            ?>
                <a href="<?php echo esc_url($kontakti_url); ?>" class="btn btn-white">
                    Sazinieties ar mums
                </a>
            <?php endif; ?>
        </div>
        <div class="form-container bg-green">
            <div class="form-header">
                <h3 class="form-name"><?php echo esc_html(get_field('faq_form_title') ?: 'Piesakieties konsultācijai'); ?></h3>
                <p class="short-text"><?php echo esc_html(get_field('faq_form_description') ?: 'Atstājiet savu kontaktinformāciju un mūsu speciālists ar Jums sazināsies, lai precizētu nianses par uzņēmuma procesiem un kā varam tos uzlabot.'); ?></p>
            </div>
            <?php echo do_shortcode('[gravityform id="1" title="false" description="false"]'); ?>
        </div>
    </div>
</section>