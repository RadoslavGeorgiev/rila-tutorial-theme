<?php
/**
 * This constant will be used when including files throughout the theme.
 *
 * @const string
 */
define( 'THEME_DIR', __DIR__ . '/' );

/**
 * Adds an autoloader for classes.
 *
 * Whenever a class is not available for PHP, this function will be executed
 * and it should try and locate that class as a last step before PHP dies.
 *
 * @param string $classname The name of the missing class.
 */
spl_autoload_register( 'theme_autoload_class' );
function theme_autoload_class( $classname ) {
	if( 0 !== stripos( $classname, 'Theme\\' ) )
		return;

	$classname = str_replace( 'Theme\\', '', $classname );
	$classname = THEME_DIR . 'lib/' . $classname . '.php';

	if( file_exists( $classname ) ) {
		require_once $classname;
	}
}

/**
 * Perform normal theme actions.
 */
add_action( 'after_setup_theme', 'theme_setup_theme' );
function theme_setup_theme() {
    add_theme_support( 'title-tag' );

	add_image_size( 'featured', 900 );

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

/**
 * Register sidebars and widgets in this function.
 */
add_action( 'widgets_init', 'theme_widgets' );
function theme_widgets() {
	register_sidebar( array(
		'id'            => 'main-sidebar',
		'name'          => 'Main Sidebar',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	));

	register_widget( Theme\Widget\WYSIWYG::class );
}