<?php
namespace Theme\Post_Type;
use Rila\Post_Type;

/**
 * Handles normal pages.
 */
class Page extends Post_Type {
	/**
	 * Add more shortcuts on initialisation.
	 */
	public function initialize() {
		# IMPORTANT: Always initialize the parent class first!
		parent::initialize();

		$this->translate(array(
			'content' => 'content_blocks'
		));

		$this->map(array(
			'content_blocks' => 'builder'
		));
	}
}