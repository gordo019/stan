<?php
/**
 * StrapPress Theme Customizer
 *
 * @package StrapPress
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
 
function strappress_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

add_action( 'customize_register', 'strappress_customize_register' );


if ( class_exists('Kirki') ) {
	Kirki::add_config( 'strappress_theme', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );
	
	/* Project Settings */
	Kirki::add_section( 'portfolios_section', array(
	    'title'          => esc_attr__( 'Portfolios Settings', 'strappress' ),
	    'description'    => esc_attr__( 'Settings for my portfolios.', 'strappress' ),
	    'priority'       => 160,
	) );
	Kirki::add_field( 'strappress_theme', array(
		'type'     => 'text',
		'settings' => 'portfolio_title',
		'label'    => __( 'Title', 'strappress' ),
		'section'  => 'portfolios_section',
		'default'  => esc_attr__( 'Portfolio', 'strappress' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'strappress_theme', array(
		'type'        => 'select',
		'settings'    => 'portfolio_items',
		'label'       => __( 'Portfolio Items per row', 'strappress' ),
		'section'     => 'portfolios_section',
		'default'     => '4',
		'priority'    => 10,
		'multiple'    => 1,
		'choices'     => array(
			'6' => esc_attr__( '2 Items', 'strappress' ),
			'4' => esc_attr__( '3 Items', 'strappress' ),
			'3' => esc_attr__( '4 Items', 'strappress' ),
			'2' => esc_attr__( '6 Items', 'strappress' ),
		),
	) );
	
	}




