<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Leksa
 */


if (!function_exists('leksa_posted_on')):
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function leksa_posted_on()
	{
		if (is_singular()) {

			$categories_list = get_the_category_list(esc_html__(', ', 'leksa'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<div class="post-cats"><span class="cat-links">' . esc_html__('%1$s', 'leksa') . '</span></div>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}


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
				esc_html_x('%s', 'post date', 'leksa'),
				'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
			);

			echo '<div class="post-date"><span class="post-meta-title">' . esc_html('Posted On', 'leksa') . '</span><span class="posted-on">' . $posted_on . '</span></div>';

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x(' / ', 'list item separator', 'leksa'));
			if ($tags_list) {
				/* translators: 1: list of tags. */
				printf('<div class="post-tags"><span class="post-meta-title">' . esc_html('Tags', 'leksa') . '</span><span class="tags-links">' . esc_html__('Tagged %1$s', 'leksa') . '</span></div>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}


		} else {

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
				esc_html_x('%s', 'post date', 'leksa'),
				'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
			);

			echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			$categories_list = get_the_category_list(esc_html__(', ', 'leksa'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span class="cat-links">' . esc_html__('%1$s', 'leksa') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

		}




	}
endif;

if (!function_exists('leksa_posted_by')):
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function leksa_posted_by()
	{

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x('%s', 'post author', 'leksa'),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
		);

		echo '<div class="post-author"><span class="post-meta-title">' . esc_html('Posted By', 'leksa') . '</span><span class="byline"> ' . $byline . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if (!function_exists('leksa_entry_footer')):
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function leksa_entry_footer()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(', ', 'leksa'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'leksa') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'leksa'));
			if ($tags_list) {
				/* translators: 1: list of tags. */
				printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'leksa') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'leksa'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__('Edit <span class="screen-reader-text">%s</span>', 'leksa'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;



if (!function_exists('leksa_post_thumbnail')):
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function leksa_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()):
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else: ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if (!function_exists('wp_body_open')):
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
endif;

function leksa_posts_nav()
{

	$ajax = false;
	$type = 'button'; // Pagination / Button / Scroll

	global $wp_query;

	$maxPages = $wp_query->max_num_pages;
	$paged = $wp_query->is_paged ? $wp_query->query['paged'] : '1';

	if ($maxPages != 1) {

		?>

		<div class="pe-theme-posts-nav type_<?php echo esc_attr($type); ?>" data-paged="<?php echo esc_attr($paged); ?>"
			data-max-pages="<?php echo esc_attr($maxPages); ?>">

			<?php

			if ($type === 'button') {

				?>

				<div class="pe_load_more">

					<?php echo get_next_posts_link('Load More Posts', 'leksa'); ?>

				</div>


			<?php }

			//       print("<pre>".print_r($wp_query,true)."</pre>");
	
			echo '</div>';

	}
}


function is_built_with_elementor($post_id = null)
{

	if (!class_exists('\Elementor\Plugin')) {
		return false;
	}

	if ($post_id == null) {
		$post_id = get_the_ID();
	}

	if (is_singular() && \Elementor\Plugin::$instance->documents->get($post_id)->is_built_with_elementor()) {
		return true;
	}

	return false;
}


function leksa_header_classes($id = null)
{
	if (class_exists("Redux")) {

		$option = get_option('pe-redux');

		if ($id == null) {
			$id = get_the_ID();
		}

		$headerClasses = [];

		if (get_field('header_behavior', $id) && (get_field('header_behavior', $id) !== 'default') ) {

			$behavior = 'header--' . get_field('header_behavior', $id);

		} else {
			$behavior = 'header--' . $option['header_behavior'];
		}
		
		if (get_field('header_layout', $id) && (get_field('header_layout', $id) !== 'use--global') ) {

			$layout = 'header--' . get_field('header_layout', $id);

		} else {
			$layout = 'header--' . $option['header_layout'];
		}

		array_push($headerClasses, $behavior);
		array_push($headerClasses, $layout);

		return esc_attr(implode(' ', $headerClasses));
	}
}

function leksa_mouse_cursor()
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');


		if ($option['mouse_cursor']) {
			?>

				<div id="mouseCursor" class="<?php echo $option['mouse_cursor_type']; ?>">

					<svg height="100%" width="100%" viewbox="0 0 100 100">
						<circle class="main-circle" cx="50" cy="50" r="50" />
					</svg>

					<span class="cursor-text"></span>
					<span class="cursor-icon"></span>

				</div>

			<?php }
	}
}

function leksa_project_hero()
{

	$option = get_option('pe-redux');

	global $wp_query;
	$id = $wp_query->post->ID;

	$type = get_field('hero_style') === 'template' ? get_field('hero_template') : (get_field('hero_style') === 'global' ? $option['project_hero_template'] : '');

	if ($type) {

		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($type);
	}
}

function leksa_next_project()
{
	$option = get_option('pe-redux');

	$template = $option['next_project_template'];

	if ($template) {

		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template);
	}
}

function leksa_project_image($postid, $custom, $hover)
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

function leksa_header_template()
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');
		$type = $option['header_type'];

		if ($type === 'template') {

			$id = $option['select-header-template'];

			return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id);

		} else {

			return false;
		}
	}
}

function leksa_footer_template()
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');
		$type = $option['footer_template'];

		if ($type === 'template') {

			$id = $option['select-footer-template'];

			return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id);

		} else {

			return false;
		}
	}
}

function leksa_post_template()
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');

		if (isset($option['single_post_template'])) {

			$id = $option['single_post_template'];

		} else {
			return false;
		}
	

		return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id);
	}

}

function leksa_barba($body)
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');

		$attr = '';
		if ($option['page_transitions']) {

			if ($body) {

				$attr = 'data-barba="wrapper"';

			} else {

				$attr = 'data-barba="container"';
			}
		}
		return $attr;
	}



}

function leksa_page_loader()
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');

		if ($option['page_loader']) {




			$type = 'pl__' . $option['loader_type'];
			$direction = 'pl__' . $option['loader_direction'];
			$curved = $option['loader_curved'];
			$duration = $option['loader_duration'];
			$elements = $option['loader_elements'];

			?>

				<div data-type="<?php echo esc_attr($option['loader_type']) ?>"
					data-direction="<?php echo esc_attr($option['loader_direction']) ?>"
					data-duration="<?php echo esc_attr($duration) ?>"
					class="pe--page--loader <?php echo esc_attr($type . ' ' . $direction) ?>">

					<span class="page--loader--ov"></span>

					<?php if (in_array('caption', $elements)) {

						$vAlign = 'v-align-' . $option['caption_v_align'];
						$hAlign = 'h-align-' . $option['caption_h_align'];

						echo '<div class="page--loader--caption ' . $vAlign . ' ' . $hAlign . ' ">' . $option['loader_caption'] . '</div>';

					}
					if (in_array('counter', $elements)) {

						$vAlign = 'v-align-' . $option['counter_v_align'];
						$hAlign = 'h-align-' . $option['counter_h_align'];
						?>

						<div class="page--loader--count <?php echo esc_attr($vAlign . ' ' . $hAlign) ?>">

							<div class="numbers--wrap">
								<span class="number number__1">
									<span>0</span>
									<span>1</span>
								</span>
								<span class="number number__2">
									<span>0</span>
									<span>1</span>
									<span>2</span>
									<span>3</span>
									<span>4</span>
									<span>5</span>
									<span>6</span>
									<span>7</span>
									<span>8</span>
									<span>9</span>
									<span>0</span>
								</span>
								<span class="number number__3">
									<span>0</span>
									<span>1</span>
									<span>2</span>
									<span>3</span>
									<span>4</span>
									<span>5</span>
									<span>6</span>
									<span>7</span>
									<span>8</span>
									<span>9</span>
									<span>0</span>
								</span>
							</div>

						</div>

					<?php } ?>
					<?php if (in_array('logo', $elements)) {

						$vAlign = 'v-align-' . $option['logo_v_align'];
						$hAlign = 'h-align-' . $option['logo_h_align'];
						?>

						<div class="page--loader--logo <?php echo esc_attr($vAlign . ' ' . $hAlign) ?>">

							<img class="op" src="<?php echo esc_url($option['loader_logo']['url']) ?>">
							<img class="no--op" src="<?php echo esc_url($option['loader_logo']['url']) ?>">

						</div>

					<?php }
					?>


				</div>
				<?php
		}
	}
}

function leksa_page_transitions()
{
	if (class_exists("Redux")) {
		$option = get_option('pe-redux');

		if ($option['page_transitions']) {



			$type = $option['transition_type']; //Slide, overlay , fade , blocks
			$curved = $option['transition_curved']; // true/false
			$elements = $option['transition_elements']; //Logo , Text , None
			$captionType = $option['caption_type'];
			$delay = 1; ?>

				<div class="page--transitions <?php echo esc_attr('pt__' . $type) ?>" data-type="<?php echo esc_attr($type) ?>">

					<span class="slide--op"></span>
					<div class="pt--wrapper">

						<span class="pt--overlay" data-curved="<?php echo esc_attr($curved) ?>"></span>


						<?php if (in_array('logo', $elements)) {
							$vAlign = 'v-align-' . $option['trans_logo_v_align'];
							$hAlign = 'h-align-' . $option['trans_logo_h_align'];

							?>

							<div class="pt--element <?php echo esc_attr($vAlign . ' ' . $hAlign . ' pt--logo') ?>">

								<img src="<?php echo esc_url($option['transition_logo']['url']) ?>">
							</div>
						<?php }

						if (in_array('caption', $elements)) {

							$vAlign = 'v-align-' . $option['trans_caption_v_align'];
							$hAlign = 'h-align-' . $option['trans_caption_h_align'];

							?>

							<div class="pt--element <?php echo esc_attr($vAlign . ' ' . $hAlign) ?>">
								<?php if ($captionType === 'basic') { ?>

									<span class="pt--text"><?php echo esc_html($option['transition_caption']) ?></span>

								<?php }

								if ($captionType === 'marquee') { ?>



									<div class="pb--marquee no-button">

										<div class="pb--marquee--wrap right-to-left" aria-hidden="true">
											<div class="pb--marquee__inner">
												<span><?php echo esc_html($option['transition_caption']) ?><i aria-hidden="true"
														class="material-icons md-fiber_manual_record" LOADING, PLEASE WAIT.
														data-md-icon="fiber_manual_record"></i></span>
												<span><?php echo esc_html($option['transition_caption']) ?><i aria-hidden="true"
														class="material-icons md-fiber_manual_record"
														data-md-icon="fiber_manual_record"></i></span>
												<span><?php echo esc_html($option['transition_caption']) ?><i aria-hidden="true"
														class="material-icons md-fiber_manual_record"
														data-md-icon="fiber_manual_record"></i></span>
												<span><?php echo esc_html($option['transition_caption']) ?><i aria-hidden="true"
														class="material-icons md-fiber_manual_record"
														data-md-icon="fiber_manual_record"></i></span>
											</div>
										</div>


									</div>
								</div>

							<?php }
						} ?>



					</div>

				</div>

				<?php
		}
	}
}
