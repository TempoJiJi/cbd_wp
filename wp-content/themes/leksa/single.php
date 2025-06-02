<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Leksa
 */

get_header();

$option = get_option('pe-redux');



?>



	<main id="primary" class="site-main" <?php echo leksa_barba(false) ?>>



		<?php
		if (leksa_post_template()) { ?>

			<?php echo leksa_post_template() ?>

		<?php } else { ?>

			<div class="pe-section">

				<div class="pe-wrapper">

					<div class="pe-col-12">

						<?php
						while (have_posts()):
							the_post();

							get_template_part('template-parts/content', get_post_type()); ?>

						</div>
					</div>

					<div class="pe-wrapper">
						<div class="pe-col-12">

							<?php
							the_post_navigation(
								array(
									'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'leksa') . '</span> <span class="nav-title">%title</span>',
									'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'leksa') . '</span> <span class="nav-title">%title</span>',
								)
							); ?>


							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if (comments_open() || get_comments_number()):
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>

					</div>
				</div>

			</div>
		<?php } ?>


	</main><!-- #main -->

	<?php

	get_footer();
