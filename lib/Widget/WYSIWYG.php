<?php
namespace Theme\Widget;

use Rila\Custom_Widget;

/**
 * Handles a simple WYSIWYG widget.
 */
class WYSIWYG extends Custom_Widget {
	/**
	 * Initializes the widget.
	 */
	public function initialize() {
		$this->title = 'WYSIWYG Widget';
		$this->description = 'A widget that lets you enter rich text content.';
		$this->width = 500;

		$this->fields = array(
			array(
			 	'type'  => 'text',
			 	'label' => 'Title',
			 	'name'  => 'title'
			),
			array(
			 	'type'  => 'wysiwyg',
			 	'label' => 'Text',
			 	'name'  => 'text'
			 )
		);

		$this->map(array(
			'title' => 'wp_kses_post',
			'text'  => 'filter:the_content'
		));
	}

	/**
	 * Renders the widget.
	 *
	 * @param Rila\Widget $widget A widget that contains all needed information.
	 */
	protected function render( $widget ) {
		rila_view( 'widget/text', compact( 'widget' ) )->render();
	}
}