<?php
namespace Theme;
use Rila\Post_Type;

/**
 * Handles normal posts.
 */
class Post extends Post_Type {
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