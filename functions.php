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