<?php
/**
 * Admin display tweaks
 *
 * @package sosimple
 */


/**
 * Remove contact methods
 */
function sosimple_remove_user_contactmethods( $contactmethods ) {
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'sosimple_remove_user_contactmethods' );


/**
 * Remove top-level menu pages
 */
function sosimple_remove_menu_pages() {
	remove_menu_page( 'upload.php' );        // Media
	remove_menu_page( 'link-manager.php' );  // Links
	remove_menu_page( 'edit-comments.php' ); // Comments
}
add_action( 'admin_menu', 'sosimple_remove_menu_pages', 999 );


/**
 * Remove sub-menu pages
 */
function sosimple_remove_submenu_pages() {
	/* Posts */
	remove_submenu_page( 'edit.php', 'post-new.php' );                    // Add new
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // Categories
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // Tags

	/* Pages */
	remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' ); // Add new

	/* Appearance */
	remove_submenu_page( 'themes.php', 'customize.php' ); // Customize

}
add_action( 'admin_menu', 'sosimple_remove_submenu_pages', 999 );


/**
 * Remove Comment post type support
 */
function sosimple_remove_commment_post_type_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
add_action( 'init', 'sosimple_remove_commment_post_type_support' );


/**
 * Remove Post meta boxes
 */
function sosimple_remove_meta_boxes() {
	remove_meta_box( 'categorydiv',      'post', 'side' );   // Categories
	remove_meta_box( 'postexcerpt',      'post', 'normal' ); // Excerpt
	remove_meta_box( 'trackbacksdiv',    'post', 'normal' ); // Trackbacks
	remove_meta_box( 'postcustom',       'post', 'normal' ); // Custom Fields
	remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // Comment Status
	remove_meta_box( 'commentsdiv',      'post', 'normal' ); // Comments
	remove_meta_box( 'slugdiv',          'post', 'normal' ); // Slug

	remove_meta_box( 'postexcerpt',      'page', 'normal' ); // Excerpt
	remove_meta_box( 'postcustom',       'page', 'normal' ); // Custom Fields
	remove_meta_box( 'slugdiv',          'page', 'normal' ); // Slug
	remove_meta_box( 'authordiv',        'page', 'normal' ); // Author
}
add_action( 'admin_menu', 'sosimple_remove_meta_boxes' );


/**
 * Remove dashbaord meta boxes
 */
function sosimple_remove_dashboard_meta_boxes() {
	remove_meta_box('dashboard_right_now',       'dashboard', 'normal'); // Right Now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
    remove_meta_box('dashboard_incoming_links',  'dashboard', 'normal'); // Incoming Links
    remove_meta_box('dashboard_plugins',         'dashboard', 'normal'); // Plugins
    remove_meta_box('dashboard_quick_press',     'dashboard', 'side');   // Quick Press
    remove_meta_box('dashboard_recent_drafts',   'dashboard', 'side');   // Recent Drafts
    remove_meta_box('dashboard_primary',         'dashboard', 'side');   // WordPress blog
    remove_meta_box('dashboard_secondary',       'dashboard', 'side');   // Other WordPress News	
}
add_action( 'wp_dashboard_setup', 'sosimple_remove_dashboard_meta_boxes' );


