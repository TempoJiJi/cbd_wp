<?php if (!function_exists('pe_post_thumbnail')):
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */


	function pe_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()):
			?>

			<div class="post-thumbnail single-post-image">
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>

		<?php else: ?>



			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail single-post-image',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					),
					false
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}

endif;

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pe-theme
 */

if (!function_exists('pe_posted_on')):
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function pe_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x('%s', 'post date', 'pe-core'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;



	add_shortcode('woo_cart_but', 'woo_cart_but');
	add_filter('woocommerce_add_to_cart_fragments', 'woo_cart_but_count');


	/**
	 * Create Shortcode for WooCommerce Cart Menu Item
	 */
	function woo_cart_but($text, $count)
	{
		ob_start();

		if ($count) {

			$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
		} else {

			$cart_count = 5;
		}

		$cart_url = wc_get_cart_url();  // Set Cart URL

		if (!$text) {

			$text = 'CART';
		}

		?>

		<a class="cart-contents" href="<?php echo esc_url($cart_url); ?>" title="My Basket">

			<?php
			if ($cart_count >= 0) {
				?>


				<div class="nayla-cart-button">

					<span class="cart-text"><?php echo esc_html($text, 'nayla') ?></span>

					<span class="cart-count"><span><?php echo esc_attr($cart_count); ?></span></span>
				</div>

				<?php
			}
			?>
		</a>
		<?php
		return ob_get_clean();
	}

	function pe_project_image($postid, $custom, $hover)
{
	$option = get_option('pe-redux');

	global $wp_query;
	$id = $postid;

	if ($custom) {

		$type = $custom['type'];

	} else {

		$type = get_field('media_type', $id);
	}

	if ($type === 'image') {

		$image = $custom ? $custom['imageUrl']['id'] : get_field('image', $id);
		$size = 'full';

		?>

			<?php if ($hover === 'bulge') { ?>

				<div class="pe--bulge card is-visible" data-img="<?php echo wp_get_attachment_image_url($image, $size); ?>">
					<div class="card__content">
						<canvas class="card__canvas"></canvas>
						<?php echo wp_get_attachment_image($image, $size) ?>
					</div>
				</div>

			<?php } else {
				echo wp_get_attachment_image($image, $size);
			} ?>


		<?php } else if ($type === 'video') {

		$provider = $custom ? $custom['provider'] : get_field('video_provider', $id);
		$video_id = $custom ? $custom['videoId'] : get_field('video_id', $id);
		$self_video = $custom ? $custom['videoUrl'] : get_field('self_video', $id);

		?>

				<div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false data-autoplay=true data-muted=true
					data-loop=true>

				<?php if ($provider === 'self') { ?>

						<video class="p-video" autoplay muted loop playsinline>
							<source src="<?php echo esc_url($self_video['url']); ?>">
						</video>

				<?php } else { ?>

						<div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
							data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>


				<?php } ?>

				</div>

		<?php }

}
