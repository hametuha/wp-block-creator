<?php

/**
 * Test autoloader really works.
 */
class AutoloaderTest extends \PHPUnit\Framework\TestCase {

	public function test_autoloader() {
		// Main class.
		$this->assertTrue( class_exists( "Hametuha\\WpBlockCreator" ) );
		// Abstract.
		$reflection = new ReflectionClass( "Hametuha\\WpBlockCreator\\Pattern\\AbstractBlock" );
		$this->assertTrue( $reflection->isAbstract() );
	}
	
}
