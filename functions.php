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
}