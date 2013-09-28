<?php
/**
 * @package sosimple
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'js-item-as-link' ); ?>>
	
	<?php
	$permalink = apply_filters( 'sosimple_content_permalink', get_permalink() );
	
	// Permalinks can be overridden with 'sosimple_content_permalink' filter.
	// Open link in a new window if permalink does not match the current pages permalink.
	$target = ( $permalink != get_permalink() ) ? 'target="_blank"' : '';
	?>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php echo esc_url( $permalink ); ?>" <?php echo $target; ?> rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<div class="entry-content content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'sosimple' ) ); ?>
		<?php
		wp_link_pages( array(
			'before' => '<p class="page-links">' . __( 'Pages:', 'sosimple' ),
			'after'  => '</p>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php get_template_part( 'templates/parts/entry', 'meta' ); ?>
	</footer><!-- .entry-footer -->

</article>
