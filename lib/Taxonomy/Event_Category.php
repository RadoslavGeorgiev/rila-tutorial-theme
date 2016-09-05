<?php
namespace Theme\Taxonomy;

use Rila\Taxonomy;
use Theme\Post_Type\Event;

/**
 * Handle an additional class for event categories.
 */
class Event_Category extends Taxonomy {
	/**
	 * Register the taxonomy and its custom fields.
	 */
	public static function register() {
		self::register_taxonomy( Event::class );

		self::add_fields( 'Event Category Data', array(
			array(
				'type'  => 'color_picker',
				'name'  => 'event_category_color',
				'label' => 'Color'
			)
		));
	}

	/**
	 * Add the needed translations.
	 */
	public function initialize() {
		# Always initialize the parent!
		parent::initialize();

		$this->translate(array(
			'color' => 'event_category_color'
		));
	}
}