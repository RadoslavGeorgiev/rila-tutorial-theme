<?php
namespace Theme\Block;

use Rila\Block;

/**
 * Handles a basic text block.
 */
class Text extends Block {
	/**
	 * Receves a blank definition that needs to be set up.
	 *
	 * @param Block_Definition block The definition to adjust.
	 */
	public static function setup( $block ) {
		$block->title = 'Text Block';
		$block->fields = array(
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
	}

	/**
	 * Returns the map that will be applied to the fields before rendering the block.
	 *
	 * @return string[]
	 */
	protected function map() {
		return array(
			'title'	=> 'wp_kses_post',
			'text'  => array( 'do_shortcode', 'wpautop' )
		);
	}

	/**
	 * Render the block.
	 *
	 * @param mixed[] $data The data of the block.
	 * @return string A template that will be echoed.
	 */
	public function render( $data ) {
		return rila_view( 'block/text', $data );
	}
}