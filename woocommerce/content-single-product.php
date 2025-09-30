<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

// Get ACF fields
$product_icon = get_the_post_thumbnail_url($product->get_id(), 'medium');
$product_subtitle = get_field('product_subtitle', $product->get_id());
$product_header_background = get_field('product_header_background', $product->get_id());
$price_period = get_field('product_price_period', $product->get_id());
$integration_tab = get_field('product_integration_tab', $product->get_id());
$benefits_tab = get_field('product_benefits_tab', $product->get_id());

// Default values
if (!$product_icon) {
	$product_icon = get_template_directory_uri() . '/assets/images/modules/module-item-image-1.svg';
}
if (!$price_period) {
	$price_period = 'Mēneša abonements';
}

// Get price display
$price_html = $product->get_price_html();

// Get category type from WooCommerce product categories
$product_categories = get_the_terms($product->get_id(), 'product_cat');
$category_display = '';
$product_category_type = '';
if ($product_categories && !is_wp_error($product_categories)) {
	foreach ($product_categories as $category) {
		if ($category->slug === 'gatavs-modulis' || $category->slug === 'gatavs_modulis') {
			$category_display = 'Gatavs modulis';
			$product_category_type = 'gatavs_modulis';
			break;
		} elseif ($category->slug === 'pielagojams-modulis' || $category->slug === 'pielagojams_modulis') {
			$category_display = 'Pielāgojams modulis';
			$product_category_type = 'pielagojams_modulis';
			break;
		}
	}
}

// Get related products
$related_products = array();
$related_limit = get_field('product_related_limit', $product->get_id()) ?: 3;

// Get products by category type for sidebar
$sidebar_products = array();
if ($product_category_type === 'pielagojams_modulis') {
	// Get products with category "Gatavs modulis" (opposite category)
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 3,
		'post__not_in' => array($product->get_id()),
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => array('gatavs-modulis', 'gatavs_modulis'),
				'operator' => 'IN'
			)
		)
	);
	$sidebar_query = new WP_Query($args);
	if ($sidebar_query->have_posts()) {
		while ($sidebar_query->have_posts()) {
			$sidebar_query->the_post();
			$sidebar_products[] = wc_get_product(get_the_ID());
		}
		wp_reset_postdata();
	}
} elseif ($product_category_type === 'gatavs_modulis') {
	// Get products with category "Pielāgojams modulis" (opposite category)
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 3,
		'post__not_in' => array($product->get_id()),
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => array('pielagojams-modulis', 'pielagojams_modulis'),
				'operator' => 'IN'
			)
		)
	);
	$sidebar_query = new WP_Query($args);
	if ($sidebar_query->have_posts()) {
		while ($sidebar_query->have_posts()) {
			$sidebar_query->the_post();
			$sidebar_products[] = wc_get_product(get_the_ID());
		}
		wp_reset_postdata();
	}
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

	<section class="page-header has-icon" style="background: #206D69 url('<?php echo $product_header_background ? esc_url($product_header_background) : get_template_directory_uri() . '/assets/images/page-header-bg-single-modules@1.5x.jpg'; ?>') center center / cover no-repeat;">
		<div class="container">
			<div class="page-header-content">
				<div class="icon">
					<img src="<?php echo esc_url($product_icon); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
				</div>

				<div>
					<h1><?php echo esc_html($product->get_name()); ?></h1>
					<?php if ($product_subtitle): ?>
						<p class="sub-text m-0"><?php echo esc_html($product_subtitle); ?></p>
					<?php else: ?>
						<p class="sub-text m-0"><?php echo wp_kses_post($product->get_short_description()); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<div class="single-module">
		<div class="container">
			<div class="details-container">
				<div class="content">
					<div class="tabs-holder">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#module-tab-pane-1" type="button" role="tab" aria-controls="module-tab-pane-1" aria-selected="true">Moduļa apraksts</button>
							</li>

							<li class="nav-item" role="presentation">
								<button class="nav-link" data-bs-toggle="tab" data-bs-target="#module-tab-pane-2" type="button" role="tab" aria-controls="module-tab-pane-2" aria-selected="false" tabindex="-1">Integrācija</button>
							</li>

							<li class="nav-item" role="presentation">
								<button class="nav-link" data-bs-toggle="tab" data-bs-target="#module-tab-pane-3" type="button" role="tab" aria-controls="module-tab-pane-3" aria-selected="false" tabindex="-1">Ieguvumi</button>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane fade active show" id="module-tab-pane-1" role="tabpanel" tabindex="0">
								<?php echo wp_kses_post($product->get_description()); ?>
							</div>

							<div class="tab-pane fade" id="module-tab-pane-2" role="tabpanel" tabindex="0">
								<?php if ($integration_tab): ?>
									<?php echo wp_kses_post($integration_tab); ?>
								<?php else: ?>
									<p><?php echo esc_html__('Integrācijas informācija tiks pievienota drīzumā.', 'dklubs'); ?></p>
								<?php endif; ?>
							</div>

							<div class="tab-pane fade" id="module-tab-pane-3" role="tabpanel" tabindex="0">
								<?php if ($benefits_tab): ?>
									<?php echo wp_kses_post($benefits_tab); ?>
								<?php else: ?>
									<p><?php echo esc_html__('Ieguvumu informācija tiks pievienota drīzumā.', 'dklubs'); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<aside class="sidebar">
					<div class="widget">
						<h3 class="widget-title"><?php echo esc_html__('Iegāde', 'dklubs'); ?></h3>

						<div class="widget-content">
							<form action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">
								<div class="add-to-cart">
									<div>
										<?php if ($category_display): ?>
											<span class="category"><?php echo esc_html($category_display); ?></span>
										<?php endif; ?>

										<div class="price-holder">
											<?php if ($price_html): ?>
												<span class="price"><?php echo wp_kses_post($price_html); ?></span>
											<?php endif; ?>
											<?php if ($price_period): ?>
												<span><?php echo esc_html($price_period); ?></span>
											<?php endif; ?>
										</div>
									</div>

									<button type="submit" class="btn btn-white"><?php echo esc_html__('Pievienot grozam', 'dklubs'); ?></button>
								</div>
							</form>
						</div>
					</div>

					<?php if (!empty($sidebar_products)): ?>
						<div class="widget">
							<h3 class="widget-title"><?php echo esc_html__('Citi risinājumi', 'dklubs'); ?></h3>

							<div class="widget-content">
								<div class="modules-list">
									<?php foreach ($sidebar_products as $sidebar_product): ?>
										<?php
										$sidebar_icon = get_the_post_thumbnail_url($sidebar_product->get_id(), 'medium');
										if (!$sidebar_icon) {
											$sidebar_icon = get_template_directory_uri() . '/assets/images/modules/module-item-image-7.svg';
										}

										$sidebar_price_html = $sidebar_product->get_price_html();
										$sidebar_price_period = get_field('product_price_period', $sidebar_product->get_id());
										if (!$sidebar_price_period) {
											$sidebar_price_period = 'Mēneša abonements';
										}
										?>
										<div class="module-item">
											<div class="icon">
												<img src="<?php echo esc_url($sidebar_icon); ?>" alt="<?php echo esc_attr($sidebar_product->get_name()); ?>">
											</div>

											<div class="details">
												<h4 class="name">
													<a href="<?php echo esc_url(get_permalink($sidebar_product->get_id())); ?>"><?php echo esc_html($sidebar_product->get_name()); ?></a>
												</h4>

												<div class="price-holder">
													<?php if ($sidebar_price_html): ?>
														<span class="price">Sākot no <?php echo wp_kses_post($sidebar_price_html); ?></span>
													<?php endif; ?>
													<?php if ($sidebar_price_period): ?>
														<span class="color-grey"><?php echo esc_html($sidebar_price_period); ?></span>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</aside>
			</div>

			<?php if ($product_category_type === 'gatavs_modulis' || $product_category_type === 'pielagojams_modulis'): ?>
				<div class="modules-list-holder">
					<h2 class="block-heading"><?php echo esc_html__('Citi gatavie moduļi biznesa procesu uzlabošanai', 'dklubs'); ?></h2>

					<div class="modules-list grid-3">
						<?php
						$ready_products_args = array(
							'post_type' => 'product',
							'posts_per_page' => 3,
							'post__not_in' => array($product->get_id()),
							'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => array('gatavs-modulis', 'gatavs_modulis'),
									'operator' => 'IN'
								)
							)
						);
						$ready_products_query = new WP_Query($ready_products_args);
						if ($ready_products_query->have_posts()):
							while ($ready_products_query->have_posts()): $ready_products_query->the_post();
								$ready_product = wc_get_product(get_the_ID());
								$ready_icon = get_the_post_thumbnail_url($ready_product->get_id(), 'medium');
								$ready_price_period = get_field('product_price_period', $ready_product->get_id());

								if (!$ready_icon) {
									$ready_icon = get_template_directory_uri() . '/assets/images/modules/module-item-image-4.svg';
								}
								if (!$ready_price_period) {
									$ready_price_period = 'Mēneša abonements';
								}

								$ready_price_html = $ready_product->get_price_html();
						?>
								<div class="module-item">
									<div class="name-holder">
										<div class="icon">
											<img src="<?php echo esc_url($ready_icon); ?>" alt="<?php echo esc_attr($ready_product->get_name()); ?>">
										</div>

										<h3 class="name">
											<a href="<?php echo esc_url(get_permalink($ready_product->get_id())); ?>"><?php echo esc_html($ready_product->get_name()); ?></a>
										</h3>
									</div>

									<div class="description">
										<p class="m-0"><?php echo wp_kses_post($ready_product->get_short_description()); ?></p>
									</div>

									<div class="bottom">
										<div class="price-holder">
											<?php if ($ready_price_html): ?>
												<span class="price"><?php echo wp_kses_post($ready_price_html); ?></span>
											<?php endif; ?>
											<?php if ($ready_price_period): ?>
												<span><?php echo esc_html($ready_price_period); ?></span>
											<?php endif; ?>
										</div>

										<a href="<?php echo esc_url(get_permalink($ready_product->get_id())); ?>" class="btn btn-white"><?php echo esc_html__('Izpētīt', 'dklubs'); ?></a>
									</div>
								</div>
						<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php include get_template_directory() . '/template-parts/faq-form.php'; ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>