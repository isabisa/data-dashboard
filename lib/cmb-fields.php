<?php

namespace Stringable\DataDash\CMB;

add_action( 'cmb2_init', __NAMESPACE__ . '\\add_metabox' );

function add_metabox() {

	$prefix = '_dd_';

	$cmb_data_viz = new_cmb2_box( array(
		'id'           => $prefix . 'data_viz',
		'title'        => 'Data Viz',
		'object_types' => array( 'data-viz' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Type',
		'id' => $prefix . 'type',
		'type' => 'select',
		'options' => array(
			'false' => '(Select one)',
			'bar_chart' => 'Bar chart',
			'pie_chart' => 'Pie chart',
			'scatter_chart' => 'Scatter chart',
			'table' => 'Table',
			'cartodb_map' => 'CartoDB map',
			'text' => 'Text/image',
		),
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Data source',
		'id' => $prefix . 'data_source',
		'type' => 'text_url',
		'desc' => 'Paste sharable URL for Google Spreadsheet here.',
    'attributes' => array(
      'data-conditional-id' => $prefix . 'type',
      'data-conditional-value' => json_encode(array('bar_chart', 'pie_chart', 'scatter_chart', 'table'))
    )
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Options',
		'id' => $prefix . 'options',
		'type' => 'textarea_code',
		'desc' => 'Options for the chart in JavaScript object format.',
    'attributes' => array(
      'data-conditional-id' => $prefix . 'type',
      'data-conditional-value' => json_encode(array('bar_chart', 'pie_chart', 'scatter_chart', 'table'))
    )
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Columns',
		'id' => $prefix . 'columns',
		'type' => 'textarea_code',
		'desc' => 'Configurations for the view\'s columns in JavaScript object format.',
    'attributes' => array(
      'data-conditional-id' => $prefix . 'type',
      'data-conditional-value' => json_encode(array('bar_chart', 'pie_chart', 'scatter_chart', 'table'))
    )
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'CartoDB URL',
		'id' => $prefix . 'cartodb_url',
		'type' => 'oembed',
    'attributes' => array(
      'data-conditional-id' => $prefix . 'type',
      'data-conditional-value' => 'cartodb_map'
    )
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Static Map Image',
		'id' => $prefix . 'static_map_image',
		'type' => 'file',
		'desc' => 'Export static map image from CartoDB.',
    'attributes' => array(
      'data-conditional-id' => $prefix . 'type',
      'data-conditional-value' => 'cartodb_map'
    )
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Data',
		'id' => $prefix . 'text-based_data',
		'type' => 'wysiwyg',
		'options' => array(
			'wpautop' => true,
			'media_buttons' => true,
			'teeny' => false,
      'editor_height' => 5,
		),
    'after_field' => '<input type="hidden" data-conditional-id="_dd_type" data-conditional-value="text">',  // Fix for conditional display from https://github.com/jcchavezs/cmb2-conditionals/issues/6#issuecomment-176578817
    'attributes' => array(
      'data-conditional-id' => $prefix . 'type',
      'data-conditional-value' => 'text'
    )
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Notes',
		'id' => $prefix . 'notes',
		'type' => 'wysiwyg',
		'options' => array(
			'wpautop' => true,
			'media_buttons' => false,
			'teeny' => true,
      'editor_height' => 5,
		),
	) );

	$cmb_data_viz->add_field( array(
		'name' => 'Source',
		'id' => $prefix . 'source',
		'type' => 'wysiwyg',
		'options' => array(
			'wpautop' => true,
			'media_buttons' => false,
			'teeny' => true,
      'editor_height' => 5,
		),
	) );

	$cmb_data = new_cmb2_box( array(
		'id'           => 'data_dashboard',
		'title'        => 'Data Dashboard',
		'object_types' => array( 'data' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => false,
	) );

	$cmb_data->add_field( array(
		'name'    => 'Data Visualizations',
		'desc'    => 'Drag posts from the left column to the right column to add them to this section. You may rearrange the order of the posts in the right column by dragging and dropping.',
		'id'      => $prefix . 'data_visualizations',
		'type'    => 'custom_attached_posts',
		'options' => array(
			'show_thumbnails' => false,
			'filter_boxes'    => true,
			'query_args'      => array( 'posts_per_page' => -1, 'post_type' => 'data-viz' ),
		)
	) );

	$cmb_data->add_field( array(
		'name' => 'About Text',
		'id' => $prefix . 'intro',
		'type' => 'wysiwyg',
		'options' => array(
			'wpautop' => true,
			'media_buttons' => false,
			'teeny' => true,
      'editor_height' => 8,
		),
    'show_names' => true
	) );
}
