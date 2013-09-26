<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package sosimple
 */


/**
 * Remove default gallery styles
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function sosimple_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'sosimple' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'sosimple_wp_title', 10, 2 );


/**
 * Adds a wrapper to videos from the whitelisted services and attempts to add
 * the wmode parameter to YouTube videos and flash embeds.
 *
 * @return string
 */
function sosimple_embed_html( $html, $url = null ) {
	$wrapped = '<div class="video-embed">' . $html . '</div>';

	if ( empty( $url ) && 'video_embed_html' == current_filter() ) { // Jetpack
		$html = $wrapped;
	} elseif ( ! empty( $url ) ) {
		$players = array( 'youtube', 'youtu.be', 'vimeo', 'dailymotion', 'hulu', 'blip.tv', 'wordpress.tv', 'viddler', 'revision3' );

		foreach ( $players as $player ) {
			if ( false !== strpos( $url, $player ) ) {
				if ( false !== strpos( $url, 'youtube' ) && false !== strpos( $html, '<iframe' ) && false === strpos( $html, 'wmode' ) ) {
					$html = preg_replace_callback( '|https?://[^"]+|im', 'sosimple_oembed_youtube_wmode_parameter', $html );
				}

				$html = $wrapped;
				break;
			}
		}
	}

	if ( false !== strpos( $html, '<embed' ) && false === strpos( $html, 'wmode' ) ) {
		$html = str_replace( '</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque"', $html );
	}

	return $html;
}
add_filter( 'embed_oembed_html', 'sosimple_embed_html', 10, 2 );
add_filter( 'video_embed_html', 'sosimple_embed_html' ); // Jetpack


/**
 * Add wmode=transparent to YouTube videos to fix z-indexing issue
 */
function sosimple_oembed_youtube_wmode_parameter( $matches ) {
	return add_query_arg( 'wmode', 'transparent', $matches[0] );
}
