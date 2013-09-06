<?php
/**
 * @package So Simple
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<p class="page-links">' . __( 'Pages:', 'so-simple' ),
			'after'  => '</p>',
		) );
		?>
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">
		<?php get_template_part( 'templates/parts/entry', 'meta' ); ?>
	</footer><!-- .entry-footer -->

	<ul class="info">
		<li>
			<?php the_time( get_option('date_format') ); ?>
		</li>
	</ul>
</article>