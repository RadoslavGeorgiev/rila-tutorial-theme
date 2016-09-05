<?php
namespace Theme\Post_Type;
use Rila\Post_Type;

/**
 * Handles the "Events" custom post type.
 */
class Event extends Post_Type {
	/**
	 * Perform actual post type registration and assign fields through the class.
	 */
	public static function register() {
		self::register_post_type();

		self::add_fields( 'Event Data', array(
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
			),
			array(
				'name'  => 'event_address',
				'label' => 'Address',
				'type'  => 'text'
			),
			array(
				'name'  => 'event_street',
				'label' => 'Street Number',
				'type'  => 'text'
			),
			array(
				'name'  => 'event_city',
				'label' => 'City',
				'type'  => 'text'
			),
			array(
				'name'  => 'event_country',
				'label' => 'Country',
				'type'  => 'text'
			)
		));
	}

	/**
	 * Add more shortcuts on initialisation.
	 */
	public function initialize() {
		# Don't forget to initialize the parent class!
		parent::initialize();

		# Let 'start' point to 'event_start' and 'end' to 'event_end'
		$this->translate(array(
			'start'    => 'event_start',
			'end'      => 'event_end',
			'text'     => 'event_text',
			'category' => 'event_category'
		));

		# Let the framework know that both fields contain dates.
		$this->map(array(
			'event_start' => 'date',
			'event_end'   => 'date',
			'event_text'  => array( 'do_shortcode', 'wpautop' )
		));
	}

	/**
	 * Create a custom method that can be used within templates.
	 *
	 * @return string
	 */
	public function location() {
		$parts = array(
			trim( $this->event_address . ' ' . $this->event_street ),
			$this->event_city,
			$this->event_country
		);

		return implode( ', ', array_filter( $parts ) );
	}
}