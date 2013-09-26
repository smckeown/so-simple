<?php
/**
 * @package sosimple
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'js-item-as-link' ); ?>>
	
	<?php
	// @todo Use JS to link entire item. This will allow links in the post to stil work.
	$permalink_override = get_post_meta( get_the_ID(), 'permalink_override', true );

	$permalink = $permalink_override ? $permalink_override : get_permalink();
	$target    = $permalink_override ? 'target="_blank"' : '';
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
