<?php

class WpBlockCreatorProtectedTest extends WP_UnitTestCase {
	
	/**
	 * @var \Hametuha\WpBlockCreatorTest\ConditionalMethodBlock
	 */
	protected $block = null;
	
	function setUp() {
		$this->block = \Hametuha\WpBlockCreatorTest\ConditionalMethodBlock::get_instance();
		parent::setUp();
	}
	
	
	public function test_rest() {
		$this->assertFalse( $this->block->test_is_rest() );
		
		$expected = <<<HTML
			<div class="components-placeholder">
				<div class="components-placeholder__label"><span class="dashicons dashicons-warning"></span>aaa</div>
				<div class="components-placeholder__fieldset"><p>bbb</p></div>
			</div>
HTML;

		$actual = $this->block->test_placeholder( 'aaa', 'bbb' );
		$this->assertXmlStringEqualsXmlString( $expected, $actual );
	}
}
