<?php
/**
 * Clear News Theme Customizer
 *
 * @package clearnews
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function so_simple_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'theme', array(
		'title'    => __( 'Theme', 'so-simple' ),
	) );

	/*
	 * Intro
	 */

	$wp_customize->add_setting( 'intro_page', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'intro_page', array(
		'label'    => __( 'Page for Intro', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'intro_page',
		'type'     => 'dropdown-pages',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'intro_format', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'intro_format', array(
		'label'    => __( 'Intro Format', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'intro_format',
		'type'     => 'radio',
		'choices'  => array(
			'standard' => __( 'Standard', 'so-simple' ),
			'full'     => __( 'Full Width', 'so-simple' ),
		),
		'priority' => 15,
	) );

	/*
	 * Nav
	 */
	
	$wp_customize->add_setting( 'search_in_nav', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'search_in_nav', array(
		'label'    => __( 'Show search form in navigation.', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'search_in_nav',
		'type'     => 'checkbox',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'twitter_url', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'twitter_url', array(
		'label'    => __( 'Twitter URL', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'twitter_url',
		'type'     => 'text',
		'priority' => 25,
	) );

	$wp_customize->add_setting( 'facebook_url', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'facebook_url', array(
		'label'    => __( 'Facebook URL', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'facebook_url',
		'type'     => 'text',
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'gplus_url', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'gplus_url', array(
		'label'    => __( 'Google+ URL', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'gplus_url',
		'type'     => 'text',
		'priority' => 35,
	) );

	/*
	 * Post & Pages
	 */
	
	$wp_customize->add_setting( 'related_post_count', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'related_post_count', array(
		'label'    => __( 'Related Post Count', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'related_post_count',
		'type'     => 'text',
		'priority' => 40,
	) );

	/*
	 * Footer
	 */
	
	$wp_customize->add_setting( 'footer_text_1', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'footer_text_1', array(
		'label'    => __( 'Footer Text 1', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'footer_text_1',
		'type'     => 'text',
		'priority' => 45,
	) );

	$wp_customize->add_setting( 'footer_text_2', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'footer_text_2', array(
		'label'    => __( 'Footer Text 2', 'so-simple' ),
		'section'  => 'theme',
		'settings' => 'footer_text_2',
		'type'     => 'text',
		'priority' => 50,
	) );
}
add_action( 'customize_register', 'so_simple_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function so_simple_customize_preview_js() {
	wp_enqueue_script( 'so_simple_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), so_simple_version_id(), true );
}
add_action( 'customize_preview_init', 'so_simple_customize_preview_js' );
