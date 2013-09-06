<?php
/**
 * @package So Simple
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
	// @todo Use JS to link entire item. This will allow links in the post to stil work.
	$permalink = isset($custom_link) ? $custom_link : get_permalink();
	$target    = isset($custom_link) ? 'target="_blank"' : '';

	printf( '<a class="permalink" href="%s"%s></a>', esc_url( $permalink ), $target ); 
	?>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content words content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'so-simple' ) ); ?>
			<?php
			wp_link_pages( array(
				'before' => '<p class="page-links">' . __( 'Pages:', 'so-simple' ),
				'after'  => '</p>',
			) );
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>	

	<footer class="entry-footer">
		<?php get_template_part( 'templates/parts/entry', 'meta' ); ?>
	</footer><!-- .entry-footer -->

</article>
