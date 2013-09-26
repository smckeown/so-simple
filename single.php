<?php
/**
 * The Template for displaying all single posts.
 *
 * @package So Simple
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/parts/content', 'single' ); ?>

			<?php sosimple_pagination(); ?>

		<?php endwhile; ?>

	</main><!-- #main -->

<?php get_footer(); ?>