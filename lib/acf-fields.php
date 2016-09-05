<?php
/**
 * Add a page for theme options (ACF Pro only)
 */
acf_add_options_page(array(
	'page_title' 	=> 'Theme Options',
	'menu_slug' 	=> 'theme-options',
	'capability'	=> 'edit_posts',
	'redirect'		=> false,
	'parent_slug'   => 'themes.php'
));

/**
 * Add fields to the options page
 */
ACF_Group::create( 'theme_options', 'Theme Options' )
	->add_location_rule( 'options_page', 'theme-options' )
	->add_fields(array(
		array(
			'type'  => 'text',
			'name'  => 'logo_text',
			'label' => 'Logo Text'
		),
		array(
			'type'      => 'post_object',
			'name'      => 'login_page',
			'label'     => 'Login Page',
			'post_type' => 'page'
		),
		array(
		 	'type'       => 'repeater',
		 	'label'      => 'Social Networks',
		 	'name'       => 'social_networks',
			'sub_fields' => array(
				array(
				 	'type'    => 'select',
				 	'label'   => 'Networks',
				 	'name'    => 'network',
					'choices' => array(
						'facebook' => 'Facebook',
						'twitter'  => 'Twitter',
						'linkedin' => 'LinkedIn'
					)
				),
				array(
					'type'  => 'url',
					'label' => 'URL',
					'name'  => 'url'
				)
			)
		 )
	))
	->register();