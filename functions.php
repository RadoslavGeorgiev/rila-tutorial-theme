<?php
/**
 * This constant will be used when including files throughout the theme.
 *
 * @const string
 */
define( 'THEME_DIR', __DIR__ . '/' );

/**
 * Perform normal theme actions.
 */
add_action( 'after_setup_theme', 'theme_setup_theme' );
function theme_setup_theme() {
    add_theme_support( 'title-tag' );

	add_image_size( 'featured', 900 );
}

/**
 * Register a custom post type for events.
 *
 * We're declaring only some simple arguments for the sake of this example.
 * For your projects, please make sure to check the wollowing link:
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
add_action( 'init', 'theme_post_types' );
function theme_post_types() {
	$labels = array(
		'name'               => 'Events',
		'singular_name'      => 'Event',
		'menu_name'          => 'Events',
		'name_admin_bar'     => 'Event',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Event',
		'new_item'           => 'New Event',
		'edit_item'          => 'Edit Event',
		'view_item'          => 'View Event',
		'all_items'          => 'All Events',
		'search_items'       => 'Search Events',
		'parent_item_colon'  => 'Parent Events:',
		'not_found'          => 'No events found.',
		'not_found_in_trash' => 'No events found in Trash.'
	);

	register_post_type( 'event', array(
		'public'       => true,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array( 'title' ),
		'labels'       => $labels,
	));
}

/**
 * Swap the class that is used by Rila for posts.
 *
 * @param  string  $classname The classname that will be used.
 * @param  WP_Post $post The post whose classname is needed.
 * @return string An eventually swapped class name.
 */
add_action( 'rila.post_class', 'theme_post_class', 10, 2 );
function theme_post_class( $classname, $post ) {
	if( 'post' == $post->post_type ) {
		# For normal posts, we need the Theme_Post class.
		return 'Theme_Post';
	} elseif( 'event' == $post->post_type ) {
		return 'Theme_Event';
	}

	return $classname;
}

/**
 * Handles normal posts.
 */
class Theme_Post extends Rila\Post_Type {
	/**
	 * Add more shortcuts on initialisation.
	 */
	public function initialize() {
		# IMPORTANT: Always initialize the parent class first!
		parent::initialize();

		$this->translate(array(
			'featured_image' => 'custom_image'
		));

		$this->map(array(
			'custom_image' => 'image'
		));
	}
}

/**
 * Associate fields with the event CPT.
 */
add_action( 'register_acf_groups', 'theme_acf_fields' );
function theme_acf_fields() {
	ACF_Group::create( 'event_data', 'Event Data' )
		->add_location_rule( 'post_type', 'event' )
		->add_fields(array(
			array(
				'name'  => 'event_start',
				'label' => 'Event Start',
				'type'  => 'date_picker'
			),
			array(
				'name'  => 'event_end',
				'label' => 'Event End',
				'type'  => 'date_picker'
			),
			array(
				'name'  => 'event_text',
				'label' => 'Text',
				'type'  => 'wysiwyg'
			)
		))
		->register();
}

/**
 * Handles the "Events" custom post type.
 */
class Theme_Event extends Rila\Post_Type {
	/**
	 * Add more shortcuts on initialisation.
	 */
	public function initialize() {
		# Don't forget to initialize the parent class!
		parent::initialize();

		# Let 'start' point to 'event_start' and 'end' to 'event_end'
		$this->translate(array(
			'start' => 'event_start',
			'end'   => 'event_end',
			'text'  => 'event_text'
		));

		# Let the framework know that both fields contain dates.
		$this->map(array(
			'event_start' => 'date',
			'event_end'   => 'date',
			'event_text'  => array( 'do_shortcode', 'wpautop' )
		));
	}
}