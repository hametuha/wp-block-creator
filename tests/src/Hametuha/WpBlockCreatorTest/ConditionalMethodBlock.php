<?php

namespace Hametuha\WpBlockCreatorTest;


use Hametuha\WpBlockCreator\Pattern\AbstractBlock;

class ConditionalMethodBlock extends AbstractBlock {
	
	protected function get_script() {
		return '';
	}
	
	public function test_is_rest() {
		return $this->is_rest();
	}
	
	public function test_placeholder( $label, $desc ) {
		return $this->get_placeholder_for_editor( $label, $desc );
	}
}
