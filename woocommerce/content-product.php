<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if (! is_a($product, WC_Product::class) || ! $product->is_visible()) {
	return;
}

// Get ACF fields
$product_icon = get_the_post_thumbnail_url($product->get_id(), 'medium');
$product_subtitle = get_field('product_subtitle', $product->get_id());
$price_period = get_field('product_price_period', $product->get_id());

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
if ($product_categories && !is_wp_error($product_categories)) {
	foreach ($product_categories as $category) {
		if ($category->slug === 'gatavs-modulis' || $category->slug === 'gatavs_modulis') {
			$category_display = 'Gatavs modulis';
			break;
		} elseif ($category->slug === 'pielagojams-modulis' || $category->slug === 'pielagojams_modulis') {
			$category_display = 'Pielāgojams modulis';
			break;
		}
	}
}
?>
<li <?php wc_product_class('', $product); ?>>
	<div class="module-item">
		<div class="name-holder">
			<div class="icon">
				<img src="<?php echo esc_url($product_icon); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
			</div>

			<h3 class="name">
				<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
					<?php echo esc_html($product->get_name()); ?>
				</a>
			</h3>
		</div>

		<div class="description">
			<?php if ($product_subtitle): ?>
				<p class="m-0"><?php echo esc_html($product_subtitle); ?></p>
			<?php else: ?>
				<p class="m-0"><?php echo wp_kses_post($product->get_short_description()); ?></p>
			<?php endif; ?>
		</div>

		<div class="bottom">
			<div class="price-holder">
				<?php if ($price_html): ?>
					<span class="price"><?php echo wp_kses_post($price_html); ?></span>
				<?php endif; ?>
				<?php if ($price_period): ?>
					<span><?php echo esc_html($price_period); ?></span>
				<?php endif; ?>
			</div>

			<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="btn btn-white">
				<?php echo esc_html__('Izpētīt', 'dklubs'); ?>
			</a>
		</div>
	</div>
</li>