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
	if( ! theme_check_dependencies() ) {
		return;
	}

    add_theme_support( 'title-tag' );

	add_image_size( 'featured', 900 );

	# Allow classes to be automatically loaded
	spl_autoload_register( 'theme_autoload_class' );

	# Add the primary hooks and actions
	add_action( 'rila.post_class', 'theme_post_class', 10, 2 );
	add_action( 'register_acf_groups', 'theme_acf_fields' );
	add_action( 'widgets_init', 'theme_widgets' );

	# Register the newly created event post type
	Theme\Post_Type\Event::register();
	Theme\Taxonomy\Event_Category::register();
}

/**
 * Checks if all needed plugins are activated.
 *
 * @return bool
 */
function theme_check_dependencies() {
	$framework = function_exists( 'rila_framework' );
	$helper    = class_exists( 'ACF_Group' );
	$acf       = class_exists( 'acf' );

	# Check if it's all in place
	if( $framework && $helper && $acf ) {
		return true;
	}

	# In the admin, just return false
	if( is_admin() ) {
		return false;
	}

	# In the front end, die with the appropriate message
	$message = <<<HTML
<strong>The current theme cannot work without the following dependencies:</strong></p>
<ul>
	<li><a href="https://github.com/RadoslavGeorgiev/rila-framework">Rila Framework</a></li>
	<li><a href="https://www.advancedcustomfields.com/">Advanced Custom Fields</a></li>
	<li><a href="https://github.com/RadoslavGeorgiev/acf-code-helper">ACF Code Helper</a></li>
</ul>
<p>Please make sure that all of the (plugins) above are installed and activated.
HTML;

	wp_die( trim( $message ) );
}

/**
 * Adds an autoloader for classes.
 *
 * Whenever a class is not available for PHP, this function will be executed
 * and it should try and locate that class as a last step before PHP dies.
 *
 * @param string $classname The name of the missing class.
 */
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
 * Swap the class that is used by Rila for posts.
 *
 * @param  string  $classname The classname that will be used.
 * @param  WP_Post $post The post whose classname is needed.
 * @return string An eventually swapped class name.
 */
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
function theme_acf_fields() {
	require_once THEME_DIR . 'lib/acf-fields.php';
}

/**
 * Register sidebars and widgets in this function.
 */
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