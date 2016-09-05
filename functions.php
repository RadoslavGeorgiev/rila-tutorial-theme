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

	# Include the classes for post types and events that we created
	require_once THEME_DIR . 'lib/Post_Type/Post.php';
	require_once THEME_DIR . 'lib/Post_Type/Page.php';
	require_once THEME_DIR . 'lib/Post_Type/Event.php';
	require_once THEME_DIR . 'lib/Taxonomy/Event_Category.php';
	require_once THEME_DIR . 'lib/Block/Text.php';
	require_once THEME_DIR . 'lib/Block/Gallery.php';

	# Register the newly created event post type
	Theme\Post_Type\Event::register();
	Theme\Taxonomy\Event_Category::register();
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
		return 'Theme\\Post_Type\\Post';
	} elseif( 'page' == $post->post_type ) {
		return 'Theme\\Post_Type\\Page';
	}

	return $classname;
}

/**
 * Add custom fields at the appropriate action.
 *
 * By using this hook, we ensure that even if the helper or ACF
 * are not active, our theme will not throw a fatal error and block the site.
 */
add_action( 'register_acf_groups', 'theme_acf_fields' );
function theme_acf_fields() {
	require_once THEME_DIR . 'lib/acf-fields.php';
}