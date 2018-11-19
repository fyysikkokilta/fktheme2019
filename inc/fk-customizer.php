<?php
/**
 * FK Theme Customizer
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'fk_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function fk_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section( 'fk_frontpage', array(
			'title'       => __( 'Frontpage image', 'understrap' ),
			'capability'  => 'edit_theme_options',
			'description' => __( 'Set Frotpage settings', 'understrap' ),
			'priority'    => 160,
        ) );
        
        $wp_customize->add_setting( 'fk_front_image', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fk_front_image', array(
            'label'    => __( 'Upload Front Image (enables frontpage image)', 'fk' ),
            'section'  => 'fk_frontpage',
            'settings' => 'fk_front_image',
        ) ) );

	}
} // endif function_exists( 'fk_theme_customize_register' ).
add_action( 'customize_register', 'fk_theme_customize_register' );
