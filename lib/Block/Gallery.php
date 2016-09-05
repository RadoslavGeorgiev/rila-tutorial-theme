<?php
namespace Theme\Block;

use Rila\Block;

/**
 * Handles a block, which contains a gallery of images.
 */
class Gallery extends Block {
	/**
	 * Receves a blank definition that needs to be set up.
	 *
	 * @param Block_Definition block The definition to adjust.
	 */
	public static function setup( $block ) {
		$block->title = 'Gallery';
		$block->fields = array(
			array(
				'type'  => 'gallery',
				'label' => 'Images',
				'name'  => 'images'
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
			'images' => 'images'
		);
	}

	/**
	 * Render the block.
	 *
	 * @param mixed[] $data The data of the block.
	 * @return string A template that will be echoed.
	 */
	public function render( $data ) {
		return rila_view( 'block/gallery', $data );
	}
}