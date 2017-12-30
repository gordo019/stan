<?php

add_action( 'cmb2_admin_init', 'cmb2_strappress_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_strappress_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_strappress_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'about_metabox',
		'title'         => __( 'Column Content', 'strappress' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on'       => array( 'key' => 'page-template', 'value' => 'templates/about.php' ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Textarea for left column
	$cmb->add_field( array(
		'name'       => __( 'Left Column', 'strappress' ),
		'desc'       => __( 'Content for left column', 'strappress' ),
		'id'         => $prefix . 'left',
		'type'       => 'textarea',
	) );

	// Textarea for right column
	$cmb->add_field( array(
		'name'       => __( 'Right Column', 'strappress' ),
		'desc'       => __( 'Content for right column', 'strappress' ),
		'id'         => $prefix . 'right',
		'type'       => 'textarea',
	) );
	

	// Add other metaboxes as needed
}