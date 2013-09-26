<?php get_header(); ?>

<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/parts/content', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php sosimple_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/no-results', 'index' ); ?>

	<?php endif; ?>

</main><!-- #main -->

<?php get_footer(); ?>