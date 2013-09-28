<?php
/**
 * The template part for displaying an intro.
 *
 * @package sosimple
 */

global $post;
$post = get_post( get_theme_mod( 'intro_page' ) );
setup_postdata( $post );

$class = get_theme_mod( 'intro_text_color' );
$style = 'style="background-color:' . get_theme_mod( 'intro_background_color' ) . ';"';
?>

<header id="masthead" class="site-header" role="banner">
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?> <?php echo $style; ?>>
		
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content content">
			<?php the_content(); ?>
			<?php edit_post_link(); ?>
		</div><!-- .entry-content -->

	</article>
</header>

<?php wp_reset_postdata(); ?>